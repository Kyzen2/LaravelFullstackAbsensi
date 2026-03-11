<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\SesiPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Memproses permintaan absensi dari aplikasi (scan QR).
     * Fungsi ini memvalidasi token QR, mengecek lokasi siswa, 
     * dan mencatat kehadiran jika semua syarat terpenuhi.
     */
    public function process(Request $request)
    {
        // Validasi input: memastikan token QR dan koordinat GPS (lat, long) dikirim
        $request->validate([
            'token_qr' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Mengambil data siswa yang sedang login lewat mobile/Flutter
        $siswa = Auth::user()->siswa;
        
        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya akun Siswa yang bisa melakukan absensi.'
            ]);
        }
        
        // Tahap 1: Mencari sesi presensi berdasarkan Token QR yang di-scan
        // Token ini harus valid dan tanggalnya harus hari ini.
        $sesi = SesiPresensi::where('token_qr', $request->token_qr)
            ->where('tanggal', now()->format('Y-m-d'))
            ->first();

        if (!$sesi) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau sudah kadaluarsa.'
            ]);
        }

        // Tahap 2: Cek apakah siswa sudah absen sebelumnya di sesi ini
        $existing = Absensi::where('sesi_id', $sesi->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah melakukan absensi untuk sesi ini.'
            ]);
        }

        // Tahap 3: Validasi Lokasi (Radius check)
        // Kita bandingkan lokasi HP siswa dengan lokasi yang ditentukan di jadwal (Lab/Kelas)
        $jadwal = $sesi->jadwal;
        $lokasi = $jadwal->lokasi;
        
        // Memanggil fungsi calculateDistance untuk dapet jarak dalam meter
        $distance = $this->calculateDistance(
            $request->latitude, 
            $request->longitude, 
            $lokasi->latitude, 
            $lokasi->longitude
        );

        // Jika jarak siswa lebih besar dari radius yang diizinkan (misal 50m)
        if ($distance > $lokasi->radius) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu berada di luar radius lokasi absensi (' . round($distance) . 'm).'
            ]);
        }

        // Tahap 4: Mencatat Absensi ke Database
        Absensi::create([
            'sesi_id' => $sesi->id,
            'siswa_id' => $siswa->id,
            'waktu_scan' => now(), // Waktu tepat saat tombol absen ditekan
            'status' => 'Hadir',
            'is_valid' => true,
            'lat_siswa' => $request->latitude,
            'long_siswa' => $request->longitude,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil dicatat.'
        ]);
    }

    /**
     * Helper Function: Menghitung jarak antara dua titik koordinat (HP vs Kelas).
     * Menggunakan Rumus Haversine untuk akurasi jarak di permukaan bumi.
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Jari-jari bumi dalam meter
        
        // Konversi koordinat ke format Radian
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        // Rumus matematika Haversine
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        // Hasil akhir adalah jarak dalam meter
        return $earthRadius * $c;
    }
}

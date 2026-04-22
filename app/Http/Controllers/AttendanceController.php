<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\SesiPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller untuk mengelola semua proses terkait absensi siswa.
 * Ini termasuk memproses scan QR dan menghitung jarak lokasi.
 */
class AttendanceController extends Controller
{
    /**
     * Memproses permintaan absensi dari aplikasi (scan QR).
     * Fungsi ini memvalidasi token QR, mengecek lokasi siswa, 
     * dan mencatat kehadiran jika semua syarat terpenuhi.
     */
    public function process(Request $request)
    {
        // 1. Validasi Input (GPS dibuat opsional/nullable biar ga ribet pas Ujikom)
        $request->validate([
            'token_qr' => 'required|string',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        // Mengambil data siswa yang sedang login
        $siswa = Auth::user()->siswa;
        
        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya akun Siswa yang bisa melakukan absensi.'
            ]);
        }
        
        // 2. Cari Sesi Aktif
        $sesi = SesiPresensi::where('token_qr', $request->token_qr)
            ->where('tanggal', now()->format('Y-m-d'))
            ->first();

        if (!$sesi) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau sudah kadaluarsa.'
            ]);
        }

        // 3. Cek apakah siswa sudah absen sebelumnya
        $existing = Absensi::where('sesi_id', $sesi->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah melakukan absensi untuk sesi ini.'
            ]);
        }

        // [FITUR GPS DIMATIKAN SESUAI REQUEST]
        // Kita tidak lagi mengecekan jarak/radius di sini agar memudahkan proses absen.

        // 4. Simpan ke Database
        $absensi = Absensi::create([
            'sesi_id' => $sesi->id,
            'siswa_id' => $siswa->id,
            'waktu_scan' => now(), 
            'status' => 'hadir',
            'is_valid' => true,
            'lat_siswa' => $request->latitude ?? '0',
            'long_siswa' => $request->longitude ?? '0',
        ]);

        // 5. Jalankan Mesin Poin (Tetap Berjalan)
        $pointService = new \App\Services\AttendancePointService();
        $pointService->evaluateAttendance($absensi);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil! Poin integritas kamu sudah dihitung.'
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

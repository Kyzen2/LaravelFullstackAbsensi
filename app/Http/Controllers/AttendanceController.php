<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\SesiPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'token_qr' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $siswa = Auth::user()->siswa;
        
        // Find the session
        $sesi = SesiPresensi::where('token_qr', $request->token_qr)
            ->where('tanggal', now()->format('Y-m-d'))
            ->first();

        if (!$sesi) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau sudah kadaluarsa.'
            ]);
        }

        // Check if student already absent today for this session
        $existing = Absensi::where('sesi_id', $sesi->id)
            ->where('siswa_id', $siswa->id)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah melakukan absensi untuk sesi ini.'
            ]);
        }

        // Validate Location (Radius check)
        $jadwal = $sesi->jadwal;
        $lokasi = $jadwal->lokasi;
        $distance = $this->calculateDistance(
            $request->latitude, 
            $request->longitude, 
            $lokasi->latitude, 
            $lokasi->longitude
        );

        if ($distance > $lokasi->radius) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu berada di luar radius lokasi absensi (' . round($distance) . 'm).'
            ]);
        }

        // Record Attendance
        Absensi::create([
            'sesi_id' => $sesi->id,
            'siswa_id' => $siswa->id,
            'waktu_scan' => now(),
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

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}

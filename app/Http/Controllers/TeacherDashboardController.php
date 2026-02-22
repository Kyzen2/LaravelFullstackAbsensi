<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\SesiPresensi;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        
        // Get today's schedules for this teacher
        $hariIni = $this->getHariIndonesia(now()->format('l'));
        $schedules = Jadwal::with(['kelas', 'mapel', 'lokasi'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->get();

        // Count total students present today for this teacher
        $todayStats = [
            'total_absen' => Absensi::whereHas('sesi', function($q) use ($guru) {
                $q->whereHas('jadwal', function($sq) use ($guru) {
                    $sq->where('guru_id', $guru->id);
                })->where('tanggal', now()->format('Y-m-d'));
            })->count()
        ];

        return view('teacher.dashboard', compact('schedules', 'todayStats'));
    }

    public function generateQr(Jadwal $jadwal)
    {
        // Check if session already exists for today
        $sesi = SesiPresensi::where('jadwal_id', $jadwal->id)
            ->where('tanggal', now()->format('Y-m-d'))
            ->first();

        if (!$sesi) {
            $sesi = SesiPresensi::create([
                'jadwal_id' => $jadwal->id,
                'tanggal' => now()->format('Y-m-d'),
                'token_qr' => Str::random(40),
            ]);
        }

        return view('teacher.qr-display', compact('sesi', 'jadwal'));
    }

    private function getHariIndonesia($day)
    {
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        return $days[$day];
    }
}

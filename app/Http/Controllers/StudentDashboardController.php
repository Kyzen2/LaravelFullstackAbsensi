<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\SesiPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        // Get recent attendance
        $recentAttendance = Absensi::with(['sesi.jadwal.mapel'])
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->take(5)
            ->get();

        // Get statistics
        $stats = [
            'total_absen' => Absensi::where('siswa_id', $siswa->id)->count(),
            'absen_bulan_ini' => Absensi::where('siswa_id', $siswa->id)
                ->whereMonth('waktu_scan', now()->month)
                ->whereYear('waktu_scan', now()->year)
                ->count(),
        ];

        return view('student.dashboard', compact('recentAttendance', 'stats'));
    }

    public function scan()
    {
        return view('student.scan');
    }

    public function history()
    {
        $siswa = Auth::user()->siswa;
        
        $attendanceHistory = Absensi::with(['sesi.jadwal.mapel'])
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->paginate(15);

        return view('student.history', compact('attendanceHistory'));
    }
}

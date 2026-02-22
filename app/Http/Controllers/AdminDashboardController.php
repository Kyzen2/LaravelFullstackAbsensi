<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Jadwal;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'guru' => Guru::count(),
            'siswa' => Siswa::count(),
            'kelas' => Kelas::count(),
            'absensi_today' => Absensi::whereDate('waktu_scan', now())->count(),
        ];

        $recent_absences = Absensi::with(['siswa', 'sesi.jadwal.mapel'])->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recent_absences'));
    }

    public function masterData()
    {
        // This is a placeholder for actual master data management
        return view('admin.master-data');
    }
}

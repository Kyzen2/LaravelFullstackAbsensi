<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\SesiPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    /**
     * Menampilkan halaman utama Dashboard Siswa.
     * Mengambil data absen terbaru dan statistik kehadiran siswa yang login.
     */
    public function index()
    {
        // Mengambil profil siswa yang sedang login
        $siswa = Auth::user()->siswa;
        
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil Siswa tidak ditemukan.');
        }

        // Mengambil 5 data absensi terbaru milik siswa ini
        // Eager loading 'sesi.jadwal.mapel' digunakan agar data mata pelajaran ikut terbawa
        $recentAttendance = Absensi::with(['sesi.jadwal.mapel'])
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->take(5)
            ->get();

        // Menghitung statistik sederhana: total absen dan absen khusus bulan ini
        $stats = [
            'total_absen' => Absensi::where('siswa_id', $siswa->id)->count(),
            'absen_bulan_ini' => Absensi::where('siswa_id', $siswa->id)
                ->whereMonth('waktu_scan', now()->month)
                ->whereYear('waktu_scan', now()->year)
                ->count(),
        ];

        return view('student.dashboard', compact('recentAttendance', 'stats'));
    }

    /**
     * Membuka halaman scan QR Code.
     * Halaman ini biasanya berisi logic JavaScript untuk mengakses kamera.
     */
    public function scan()
    {
        return view('student.scan');
    }

    /**
     * Menampilkan riwayat (history) seluruh absensi siswa.
     */
    public function history()
    {
        $siswa = Auth::user()->siswa;
        
        if (!$siswa) {
            return redirect()->route('dashboard')->with('error', 'Profil Siswa tidak ditemukan.');
        }
        
        // Mengambil data absensi dengan sistem pagination (pembagian per halaman)
        // Di sini diatur 15 data per halaman agar loading tidak berat
        $attendanceHistory = Absensi::with(['sesi.jadwal.mapel'])
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->paginate(15);

        return view('student.history', compact('attendanceHistory'));
    }
}

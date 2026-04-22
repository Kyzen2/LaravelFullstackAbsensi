<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Artisan;

/**
 * File routes/web.php ini adalah "peta" aplikasi.
 * Semua URL yang diketik di browser akan dicocokkan di sini 
 * untuk menentukan Controller mana yang akan jalan.
 */

// Halaman depan (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Grup Route yang butuh Login (Middleware 'auth')
Route::middleware(['auth'])->group(function () {
    
    // 1. DASHBOARD GURU
    // Menampilkan halaman utama, jadwal mengajar, dan daftar kelas.
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    Route::get('/teacher/schedule', [TeacherDashboardController::class, 'schedule'])->name('teacher.schedule');
    Route::get('/teacher/attendance', [TeacherDashboardController::class, 'attendanceIndex'])->name('teacher.attendance.index');
    Route::get('/teacher/attendance/class/{kelas}', [TeacherDashboardController::class, 'classAttendanceDetail'])->name('teacher.attendance.class');
    Route::get('/teacher/session/{sesi}', [TeacherDashboardController::class, 'sessionDetail'])->name('teacher.session.detail');
    Route::post('/teacher/attendance/manual', [TeacherDashboardController::class, 'storeManualAttendance'])->name('teacher.attendance.manual');
    // 2. SISTEM QR & REKAP PDF
    // Mengatur pembuatan QR Code presensi dan download laporan PDF.
    Route::get('/teacher/reports', [TeacherDashboardController::class, 'reportIndex'])->name('teacher.reports.index');
    Route::get('/teacher/reports/export', [TeacherDashboardController::class, 'exportFilteredPdf'])->name('teacher.reports.export');
    Route::get('/teacher/export-pdf/{jadwal}', [TeacherDashboardController::class, 'exportPdf'])->name('teacher.export.pdf');
    Route::get('/teacher/qr-current', [TeacherDashboardController::class, 'currentQr'])->name('teacher.qr.current');
    Route::post('/teacher/qr-refresh/{sesi}', [TeacherDashboardController::class, 'refreshToken'])->name('teacher.qr.refresh');
    Route::get('/teacher/qr/{jadwal}', [TeacherDashboardController::class, 'generateQr'])->name('teacher.qr');

    // Rute Penilaian (Assessment) Guru
    Route::get('/teacher/assessments', [App\Http\Controllers\Teacher\AssessmentController::class, 'index'])->name('teacher.assessments.index');
    Route::get('/teacher/assessments/evaluate/{studentUser}', [App\Http\Controllers\Teacher\AssessmentController::class, 'create'])->name('teacher.assessments.create');
    Route::post('/teacher/assessments/store', [App\Http\Controllers\Teacher\AssessmentController::class, 'store'])->name('teacher.assessments.store');

    // 4. DASHBOARD SISWA
    // Halaman utama siswa, fitur scan QR, dan riwayat absen.
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::post('/student/gamification/buy/{item}', [StudentDashboardController::class, 'buyToken'])->name('student.gamification.buy');
    Route::get('/student/scan', [StudentDashboardController::class, 'scan'])->name('student.scan');
    Route::get('/student/history', [StudentDashboardController::class, 'history'])->name('student.history');
    
    // Rute Penilaian (Assessment) Siswa
    Route::get('/student/assessments', [App\Http\Controllers\Student\AssessmentController::class, 'index'])->name('student.assessments.index');
    
    // Rute khusus Admin
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/master', [AdminDashboardController::class, 'masterData'])->name('admin.master.data');
    
    // Admin Directories (Direktori Guru/Siswa/Mapel)
    Route::resource('/admin/tahun-ajaran', App\Http\Controllers\Admin\TahunAjaranController::class)->names('admin.tahun-ajaran');
    Route::resource('/admin/kelas', App\Http\Controllers\Admin\KelasController::class)->names('admin.kelas');
    Route::resource('/admin/mapel', App\Http\Controllers\Admin\MapelController::class)->names('admin.mapel');
    Route::post('/admin/kelas/{kelas}/students', [App\Http\Controllers\Admin\KelasController::class, 'addStudent'])->name('admin.kelas.students.add');
    Route::delete('/admin/kelas/{kelas}/students/{siswa}', [App\Http\Controllers\Admin\KelasController::class, 'removeStudent'])->name('admin.kelas.students.remove');

    Route::resource('/admin/students', App\Http\Controllers\Admin\StudentController::class)->names('admin.students');
    Route::post('/admin/students/{student}/adjust-points', [App\Http\Controllers\Admin\StudentController::class, 'adjustPoints'])->name('admin.students.adjust-points');
    Route::resource('/admin/teachers', App\Http\Controllers\Admin\TeacherController::class)->names('admin.teachers');
    Route::resource('/admin/jadwal', App\Http\Controllers\Admin\JadwalController::class)->names('admin.jadwal');
    Route::resource('/admin/assessment-categories', App\Http\Controllers\Admin\AssessmentCategoryController::class)->names('admin.assessment-categories');
    
    // Gamification & Flexibility
    Route::get('/admin/gamification', [App\Http\Controllers\Admin\GamificationController::class, 'index'])->name('admin.gamification.index');
    Route::post('/admin/gamification/rules', [App\Http\Controllers\Admin\GamificationController::class, 'storeRule'])->name('admin.gamification.rules.store');
    Route::delete('/admin/gamification/rules/{rule}', [App\Http\Controllers\Admin\GamificationController::class, 'destroyRule'])->name('gamification.rules.destroy');
    Route::post('/admin/gamification/items', [App\Http\Controllers\Admin\GamificationController::class, 'storeItem'])->name('admin.gamification.items.store');
    Route::delete('/admin/gamification/items/{item}', [App\Http\Controllers\Admin\GamificationController::class, 'destroyItem'])->name('gamification.items.destroy');
    
    // Trigger Manual Auto-ALPA (Admin Only)
    Route::post('/admin/gamification/run-alpa-scan', function () {
        $today = \Carbon\Carbon::today();
        $now = \Carbon\Carbon::now();
        
        $hariMap = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu',
        ];
        $hariIni = $hariMap[$today->format('l')] ?? $today->format('l');

        // Cari jadwal hari ini yang jam_selesai sudah lewat
        $jadwals = \App\Models\Jadwal::with(['kelas.anggotaKelas.siswa.user', 'mapel'])
            ->where('hari', $hariIni)
            ->where('jam_selesai', '<=', $now->format('H:i:s'))
            ->get();

        $totalMarked = 0;

        foreach ($jadwals as $jadwal) {
            // Cari atau buat sesi presensi untuk jadwal ini hari ini
            $sesi = \App\Models\SesiPresensi::firstOrCreate(
                ['jadwal_id' => $jadwal->id, 'tanggal' => $today->toDateString()],
                ['token_qr' => 'AUTO-ALPA-' . \Illuminate\Support\Str::random(8)]
            );

            // Ambil siswa yg SUDAH absen di sesi ini
            $sudahAbsen = \App\Models\Absensi::where('sesi_id', $sesi->id)->pluck('siswa_id')->toArray();

            // Loop semua anggota kelas
            foreach ($jadwal->kelas->anggotaKelas as $anggota) {
                if (in_array($anggota->siswa_id, $sudahAbsen)) continue;
                
                $siswa = $anggota->siswa;
                if (!$siswa || !$siswa->user) continue;
                $user = $siswa->user;

                // Buat record ALPA
                \App\Models\Absensi::create([
                    'sesi_id' => $sesi->id, 'siswa_id' => $siswa->id,
                    'waktu_scan' => null, 'status' => 'alpa', 'is_valid' => false,
                ]);

                // Potong poin -5
                $user->point_balance -= 5;
                $user->save();

                \App\Models\PointLedger::create([
                    'user_id' => $user->id, 'transaction_type' => 'PENALTY',
                    'amount' => -5, 'current_balance' => $user->point_balance,
                    'description' => "Auto ALPA: Tidak hadir - " . ($jadwal->mapel->nama_mapel ?? 'N/A') . " ({$jadwal->kelas->nama_kelas})",
                ]);
                $totalMarked++;
            }
        }

        return back()->with('success', "Scan ALPA selesai! {$totalMarked} siswa ditandai ALPA dan dipotong poin hari ini ({$hariIni}).");
    })->name('admin.gamification.run-alpa');
    
    // Proses Scan Presensi (API call dari Mobile/Scan View)
    Route::post('/attendance/process', [AttendanceController::class, 'process'])->name('attendance.process');
});

/**
 * Pengelolaan Dashboard dinamis: 
 * Mengarahkan user ke dashboard yang sesuai dengan Role-nya (Guru/Siswa/Admin).
 */
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isGuru()) {
        return redirect()->route('teacher.dashboard');
    } elseif ($user->isSiswa()) {
        return redirect()->route('student.dashboard');
    } elseif ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute Standar Laravel Breeze (Profile Management)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Import rute autentikasi (login, logout, register, dsb)
require __DIR__.'/auth.php';

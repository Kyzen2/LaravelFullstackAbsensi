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
    
    // Rute khusus Guru
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    Route::get('/teacher/schedule', [TeacherDashboardController::class, 'schedule'])->name('teacher.schedule');
    Route::get('/teacher/attendance', [TeacherDashboardController::class, 'attendanceIndex'])->name('teacher.attendance.index');
    Route::get('/teacher/attendance/class/{kelas}', [TeacherDashboardController::class, 'classAttendanceDetail'])->name('teacher.attendance.class');
    Route::get('/teacher/session/{sesi}', [TeacherDashboardController::class, 'sessionDetail'])->name('teacher.session.detail');
    Route::post('/teacher/attendance/manual', [TeacherDashboardController::class, 'storeManualAttendance'])->name('teacher.attendance.manual');
    Route::get('/teacher/export-pdf/{jadwal}', [TeacherDashboardController::class, 'exportPdf'])->name('teacher.export.pdf');
    Route::get('/teacher/qr-current', [TeacherDashboardController::class, 'currentQr'])->name('teacher.qr.current');
    Route::post('/teacher/qr-refresh/{sesi}', [TeacherDashboardController::class, 'refreshToken'])->name('teacher.qr.refresh');
    Route::get('/teacher/qr/{jadwal}', [TeacherDashboardController::class, 'generateQr'])->name('teacher.qr');

    // Rute Penilaian (Assessment) Guru
    Route::get('/teacher/assessments', [App\Http\Controllers\Teacher\AssessmentController::class, 'index'])->name('teacher.assessments.index');
    Route::get('/teacher/assessments/evaluate/{studentUser}', [App\Http\Controllers\Teacher\AssessmentController::class, 'create'])->name('teacher.assessments.create');
    Route::post('/teacher/assessments/store', [App\Http\Controllers\Teacher\AssessmentController::class, 'store'])->name('teacher.assessments.store');

    // Rute khusus Siswa
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/student/scan', [StudentDashboardController::class, 'scan'])->name('student.scan');
    Route::get('/student/history', [StudentDashboardController::class, 'history'])->name('student.history');
    
    // Rute Penilaian (Assessment) Siswa
    Route::get('/student/assessments', [App\Http\Controllers\Student\AssessmentController::class, 'index'])->name('student.assessments.index');
    
    // Rute khusus Admin
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/master', [AdminDashboardController::class, 'masterData'])->name('admin.master.data');
    
    // Admin Directories (Direktori Guru/Siswa)
    Route::resource('/admin/students', App\Http\Controllers\Admin\StudentController::class)->names('admin.students');
    Route::resource('/admin/teachers', App\Http\Controllers\Admin\TeacherController::class)->names('admin.teachers');
    Route::resource('/admin/assessment-categories', App\Http\Controllers\Admin\AssessmentCategoryController::class)->names('admin.assessment-categories');
    
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

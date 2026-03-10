<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
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

    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/student/scan', [StudentDashboardController::class, 'scan'])->name('student.scan');
    Route::get('/student/history', [StudentDashboardController::class, 'history'])->name('student.history');
    
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/master', [AdminDashboardController::class, 'masterData'])->name('admin.master.data');
    
    // Admin Directories
    Route::get('/admin/students', [App\Http\Controllers\Admin\StudentController::class, 'index'])->name('admin.students.index');
    Route::get('/admin/teachers', [App\Http\Controllers\Admin\TeacherController::class, 'index'])->name('admin.teachers.index');
    
    Route::post('/attendance/process', [AttendanceController::class, 'process'])->name('attendance.process');
});

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

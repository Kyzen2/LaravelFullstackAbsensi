<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    Route::get('/teacher/qr/{jadwal}', [TeacherDashboardController::class, 'generateQr'])->name('teacher.qr');

    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/student/scan', [StudentDashboardController::class, 'scan'])->name('student.scan');
    Route::get('/student/history', [StudentDashboardController::class, 'history'])->name('student.history');
    
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
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

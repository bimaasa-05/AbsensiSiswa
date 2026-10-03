<?php

use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\AttendanceCorrectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FingerprintController;
use App\Http\Controllers\Admin\GuardianController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Parent\DashboardController as ParentDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->intended(auth()->user()->isAdmin() ? route('admin.dashboard') : route('parent.dashboard'))
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/absensi', [AttendanceController::class, 'scanner'])->name('attendance.scanner');
Route::post('/absensi/scan', [AttendanceController::class, 'scan'])
    ->middleware('throttle:60,1')
    ->name('attendance.scan');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('/admin/classes', SchoolClassController::class)
        ->names('admin.classes')
        ->except(['show']);

    Route::resource('/admin/guardians', GuardianController::class)
        ->names('admin.guardians')
        ->parameter('guardians', 'guardian')
        ->except(['show']);

    Route::resource('/admin/students', StudentController::class)
        ->names('admin.students')
        ->parameter('students', 'student');

    Route::post('/admin/students/{student}/qr/regenerate', [StudentController::class, 'regenerateQr'])
        ->name('admin.students.qr.regenerate');

    Route::get('/admin/attendances/today', [AdminAttendanceController::class, 'today'])->name('admin.attendances.today');
    Route::get('/admin/attendances/history', [AdminAttendanceController::class, 'history'])->name('admin.attendances.history');
    Route::get('/admin/attendances/recap', [AdminAttendanceController::class, 'recap'])->name('admin.attendances.recap');

    Route::get('/admin/attendances/{attendance}/correction', [AttendanceCorrectionController::class, 'edit'])->name('admin.corrections.edit');
    Route::put('/admin/attendances/{attendance}/correction', [AttendanceCorrectionController::class, 'update'])->name('admin.corrections.update');

    Route::get('/admin/fingerprint/mock', [FingerprintController::class, 'mock'])->name('admin.fingerprint.mock');
    Route::post('/admin/fingerprint/mock', [FingerprintController::class, 'store'])->name('admin.fingerprint.store');

    Route::get('/orang-tua/dashboard', [ParentDashboardController::class, 'index'])->name('parent.dashboard');
});

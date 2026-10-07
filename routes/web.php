<?php

use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\AttendanceCorrectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FingerprintController;
use App\Http\Controllers\Admin\GuardianController;
use App\Http\Controllers\Admin\HolidayController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SchoolSettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicLookupController;
use App\Http\Controllers\SchoolRegistrationController;
use App\Http\Controllers\Superadmin\SchoolController as SuperadminSchoolController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicLookupController::class, 'landing'])->name('landing');
Route::post('/cek', [PublicLookupController::class, 'check'])
    ->middleware('throttle:10,1')
    ->name('lookup.check');
Route::get('/hasil/{identifier}', [PublicLookupController::class, 'result'])
    ->middleware('throttle:30,1')
    ->name('lookup.result');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/absensi', [AttendanceController::class, 'scanner'])->name('attendance.scanner');
Route::post('/absensi/scan', [AttendanceController::class, 'scan'])
    ->middleware('throttle:60,1')
    ->name('attendance.scan');

Route::get('/daftar-sekolah', [SchoolRegistrationController::class, 'create'])->name('schools.register');
Route::post('/daftar-sekolah', [SchoolRegistrationController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('schools.register.store');
Route::get('/daftar-sekolah/berhasil', [SchoolRegistrationController::class, 'success'])->name('schools.register.success');

Route::middleware(['auth', 'role:admin'])->group(function () {
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
    Route::get('/admin/attendances/missing', [AdminAttendanceController::class, 'missing'])->name('admin.attendances.missing');
    Route::get('/admin/attendances/history', [AdminAttendanceController::class, 'history'])->name('admin.attendances.history');
    Route::get('/admin/attendances/recap', [AdminAttendanceController::class, 'recap'])->name('admin.attendances.recap');
    Route::get('/admin/attendances/recap/excel', [AdminAttendanceController::class, 'exportExcel'])->name('admin.attendances.recap.excel');
    Route::get('/admin/attendances/recap/print', [AdminAttendanceController::class, 'print'])->name('admin.attendances.recap.print');
    Route::get('/admin/attendances/notifications', [AdminAttendanceController::class, 'notifications'])->name('admin.attendances.notifications');

    Route::get('/admin/attendances/{attendance}/correction', [AttendanceCorrectionController::class, 'edit'])->name('admin.corrections.edit');
    Route::put('/admin/attendances/{attendance}/correction', [AttendanceCorrectionController::class, 'update'])->name('admin.corrections.update');

    Route::get('/admin/fingerprint/mock', [FingerprintController::class, 'mock'])->name('admin.fingerprint.mock');
    Route::post('/admin/fingerprint/mock', [FingerprintController::class, 'store'])->name('admin.fingerprint.store');

    Route::get('/admin/settings', [SchoolSettingController::class, 'edit'])->name('admin.settings.edit');
    Route::put('/admin/settings', [SchoolSettingController::class, 'update'])->name('admin.settings.update');

    Route::resource('/admin/holidays', HolidayController::class)
        ->names('admin.holidays')
        ->except(['show']);
});

Route::middleware(['auth', 'role:superadmin'])->prefix('/superadmin')->name('superadmin.')->group(function () {
    Route::get('/schools', [SuperadminSchoolController::class, 'index'])->name('schools.index');
    Route::get('/schools/{school}', [SuperadminSchoolController::class, 'show'])->name('schools.show');
    Route::post('/schools/{school}/approve', [SuperadminSchoolController::class, 'approve'])->name('schools.approve');
    Route::post('/schools/{school}/reject', [SuperadminSchoolController::class, 'reject'])->name('schools.reject');
});

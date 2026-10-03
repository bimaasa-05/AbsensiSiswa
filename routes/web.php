<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Halaman orang tua akan dibangun pada Phase 5 (Parent Monitoring).
    Route::get('/orang-tua/dashboard', function () {
        abort_unless(auth()->user()->isParent(), 403, 'Anda tidak memiliki akses ke halaman ini.');

        return response('Halaman orang tua dalam pengembangan.', 200);
    })->name('parent.dashboard');
});

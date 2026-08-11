<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DigitalBoardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

// Public Digital Display Board (Home Route)
Route::get('/', [DigitalBoardController::class, 'index'])->name('board');
Route::get('/board', [DigitalBoardController::class, 'index']);

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/demo-login/{role}', [AuthController::class, 'demoLogin'])->name('demo.login');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::post('/labs', [AdminController::class, 'storeLab'])->name('labs.store');
        Route::post('/pengumuman', [AdminController::class, 'storePengumuman'])->name('pengumuman.store');
        Route::delete('/pengumuman/{id}', [AdminController::class, 'deletePengumuman'])->name('pengumuman.delete');
    });

    // Dosen Routes
    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
        Route::post('/agenda', [DosenController::class, 'storeAgenda'])->name('agenda.store');
        Route::put('/agenda/{id}/realisasi', [DosenController::class, 'updateRealisasi'])->name('agenda.realisasi');
        Route::post('/agenda/{id}/qr-new', [DosenController::class, 'generateNewQrToken'])->name('agenda.qr');
    });

    // Mahasiswa Routes
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::post('/absensi', [MahasiswaController::class, 'submitAttendance'])->name('absensi.submit');
    });
});

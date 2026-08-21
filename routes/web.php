<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DigitalBoardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

// Public Digital Display Board (Home Route & Specific Lab Board)
Route::get('/', [DigitalBoardController::class, 'index'])->name('board');
Route::get('/board/{lab_id?}', [DigitalBoardController::class, 'index'])->name('board.lab');

// Guest Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/demo-login/{role}', [AuthController::class, 'demoLogin'])->name('demo.login');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::post('/users/promote', [AdminController::class, 'promoteSemesters'])->name('users.promote');
        Route::post('/labs', [AdminController::class, 'storeLab'])->name('labs.store');
        Route::post('/pengumuman', [AdminController::class, 'storePengumuman'])->name('pengumuman.store');
        Route::put('/pengumuman/{id}', [AdminController::class, 'updatePengumuman'])->name('pengumuman.update');
        Route::delete('/pengumuman/{id}', [AdminController::class, 'deletePengumuman'])->name('pengumuman.delete');

        // New Admin sub-pages
        Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('pengguna');
        Route::delete('/pengguna/{id}', [AdminController::class, 'deleteUser'])->name('pengguna.delete');
        Route::get('/laboratorium', [AdminController::class, 'laboratorium'])->name('laboratorium');
        Route::put('/laboratorium/{id}', [AdminController::class, 'updateLab'])->name('laboratorium.update');
        Route::delete('/laboratorium/{id}', [AdminController::class, 'deleteLab'])->name('laboratorium.delete');
        Route::get('/agenda', [AdminController::class, 'agenda'])->name('agenda');
        Route::delete('/agenda/{id}', [AdminController::class, 'deleteAgenda'])->name('agenda.delete');
        Route::get('/absensi', [AdminController::class, 'absensi'])->name('absensi');
        Route::get('/absensi/export', [AdminController::class, 'exportAbsensi'])->name('absensi.export');
        Route::get('/pengumuman', [AdminController::class, 'pengumuman'])->name('pengumuman');
        
        // Statistik & Akademik
        Route::get('/statistik', [AdminController::class, 'statistik'])->name('statistik');
        Route::get('/akademik', [AdminController::class, 'akademik'])->name('akademik');
        Route::post('/akademik/fakultas', [AdminController::class, 'storeFakultas'])->name('akademik.fakultas.store');
        Route::put('/akademik/fakultas/{id}', [AdminController::class, 'updateFakultas'])->name('akademik.fakultas.update');
        Route::delete('/akademik/fakultas/{id}', [AdminController::class, 'deleteFakultas'])->name('akademik.fakultas.delete');
        Route::post('/akademik/prodi', [AdminController::class, 'storeProdi'])->name('akademik.prodi.store');
        Route::put('/akademik/prodi/{id}', [AdminController::class, 'updateProdi'])->name('akademik.prodi.update');
        Route::delete('/akademik/prodi/{id}', [AdminController::class, 'deleteProdi'])->name('akademik.prodi.delete');
        Route::post('/akademik/kelas', [AdminController::class, 'storeKelas'])->name('akademik.kelas.store');
        Route::put('/akademik/kelas/{id}', [AdminController::class, 'updateKelas'])->name('akademik.kelas.update');
        Route::delete('/akademik/kelas/{id}', [AdminController::class, 'deleteKelas'])->name('akademik.kelas.delete');
    });

    // Dosen Routes
    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
        Route::post('/agenda', [DosenController::class, 'storeAgenda'])->name('agenda.store');
        Route::put('/agenda/{id}', [DosenController::class, 'updateAgenda'])->name('agenda.update');
        Route::delete('/agenda/bulk-delete', [DosenController::class, 'bulkDeleteAgendas'])->name('agenda.bulk-delete');
        Route::delete('/agenda/{id}', [DosenController::class, 'deleteAgenda'])->name('agenda.delete');
        Route::put('/agenda/{id}/realisasi', [DosenController::class, 'updateRealisasi'])->name('agenda.realisasi');
        Route::post('/agenda/{id}/qr-new', [DosenController::class, 'generateNewQrToken'])->name('agenda.qr');
        Route::post('/absensi', [DosenController::class, 'submitAttendance'])->name('absensi.submit');
        
        Route::get('/agenda', [DosenController::class, 'agenda'])->name('agenda');
        Route::get('/mahasiswa', [DosenController::class, 'mahasiswa'])->name('mahasiswa');
        Route::get('/mahasiswa/export', [DosenController::class, 'exportMahasiswa'])->name('mahasiswa.export');
        Route::get('/agenda/{id}/export-kehadiran', [DosenController::class, 'exportKehadiran'])->name('agenda.export-kehadiran');
        Route::get('/perizinan', [DosenController::class, 'perizinan'])->name('perizinan');
        Route::post('/perizinan/{id}/verifikasi', [DosenController::class, 'verifikasiIzin'])->name('perizinan.verifikasi');
        Route::get('/pengaturan', [DosenController::class, 'pengaturan'])->name('pengaturan');
        Route::put('/pengaturan', [DosenController::class, 'updatePengaturan'])->name('pengaturan.update');
    });

    // Mahasiswa Routes
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::post('/absensi', [MahasiswaController::class, 'submitAttendance'])->name('absensi.submit');
        Route::post('/perizinan', [MahasiswaController::class, 'submitIzin'])->name('perizinan.submit');
        
        Route::get('/riwayat', [MahasiswaController::class, 'riwayat'])->name('riwayat');
        Route::get('/agenda', [MahasiswaController::class, 'agenda'])->name('agenda');
        Route::get('/pengaturan', [MahasiswaController::class, 'pengaturan'])->name('pengaturan');
        Route::put('/pengaturan', [MahasiswaController::class, 'updatePengaturan'])->name('pengaturan.update');
    });
});

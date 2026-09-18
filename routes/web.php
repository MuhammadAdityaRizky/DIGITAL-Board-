<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DigitalBoardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\TemplateController;
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

    Route::get('/template/download/{type}', [TemplateController::class, 'download'])->name('template.download');

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
        Route::delete('/pengguna/bulk-delete', [AdminController::class, 'bulkDeleteUsers'])->name('pengguna.bulk-delete');
        Route::delete('/pengguna/{id}', [AdminController::class, 'deleteUser'])->name('pengguna.delete');
        Route::post('/pengguna/{id}/reset-password', [AdminController::class, 'resetPasswordUser'])->name('pengguna.reset-password');
        Route::post('/pengguna/{id}/toggle-status', [AdminController::class, 'toggleStatusUser'])->name('pengguna.toggle-status');
        Route::post('/pengguna/import/mahasiswa', [AdminController::class, 'importMahasiswa'])->name('pengguna.import-mahasiswa');
        Route::post('/pengguna/import/dosen', [AdminController::class, 'importDosen'])->name('pengguna.import-dosen');
        
        Route::get('/laboratorium', [AdminController::class, 'laboratorium'])->name('laboratorium');
        Route::put('/laboratorium/{id}', [AdminController::class, 'updateLab'])->name('laboratorium.update');
        Route::delete('/laboratorium/{id}', [AdminController::class, 'deleteLab'])->name('laboratorium.delete');
        Route::post('/laboratorium/import', [AdminController::class, 'importLaboratorium'])->name('laboratorium.import');
        
        Route::get('/agenda', [AdminController::class, 'agenda'])->name('agenda');
        Route::get('/agenda/{id}/berita-acara/cetak', [DosenController::class, 'cetakBeritaAcara'])->name('agenda.berita-acara.cetak');
        Route::get('/agenda/{id}/realisasi-praktikum/cetak', [DosenController::class, 'cetakRealisasiPraktikum'])->name('agenda.realisasi-praktikum.cetak');
        Route::post('/agenda', [AdminController::class, 'storeAgenda'])->name('agenda.store');
        Route::put('/agenda/{id}', [AdminController::class, 'updateAgenda'])->name('agenda.update');
        Route::delete('/agenda/bulk-delete', [AdminController::class, 'bulkDeleteAgendas'])->name('agenda.bulk-delete');
        Route::delete('/agenda/{id}', [AdminController::class, 'deleteAgenda'])->name('agenda.delete');
        Route::post('/agenda/import', [AdminController::class, 'importAgenda'])->name('agenda.import');
        
        Route::get('/absensi', [AdminController::class, 'absensi'])->name('absensi');
        Route::post('/absensi/import-global', [AdminController::class, 'importAbsensiGlobal'])->name('absensi.import-global');
        Route::get('/absensi/export', [AdminController::class, 'exportAbsensi'])->name('absensi.export');
        Route::get('/absensi/{id}/input', [AdminController::class, 'inputAbsensi'])->name('absensi.input');
        Route::post('/absensi/{id}/import', [AdminController::class, 'importAbsensi'])->name('absensi.import');
        Route::post('/absensi/{id}/input', [AdminController::class, 'storeInputAbsensi'])->name('absensi.store-input');
        Route::get('/pengumuman', [AdminController::class, 'pengumuman'])->name('pengumuman');
        Route::get('/aktivitas', [AdminController::class, 'aktivitas'])->name('aktivitas');
        
        // Master Jadwal Penggunaan Lab
        Route::get('/jadwal-lab', [AdminController::class, 'jadwalPenggunaanLab'])->name('jadwal-lab');
        Route::get('/jadwal-lab/export', [AdminController::class, 'exportJadwalLab'])->name('jadwal-lab.export');
        Route::post('/jadwal-lab/import', [AdminController::class, 'importJadwalLab'])->name('jadwal-lab.import');
        Route::post('/jadwal-lab', [AdminController::class, 'storeJadwalPenggunaanLab'])->name('jadwal-lab.store');
        Route::put('/jadwal-lab/{id}', [AdminController::class, 'updateJadwalPenggunaanLab'])->name('jadwal-lab.update');
        Route::delete('/jadwal-lab/bulk-delete', [AdminController::class, 'bulkDeleteJadwalLab'])->name('jadwal-lab.bulk-delete');
        Route::delete('/jadwal-lab/{id}', [AdminController::class, 'deleteJadwalPenggunaanLab'])->name('jadwal-lab.delete');
        
        Route::get('/akademik', [AdminController::class, 'akademik'])->name('akademik');
        Route::post('/akademik/fakultas', [AdminController::class, 'storeFakultas'])->name('akademik.fakultas.store');
        Route::put('/akademik/fakultas/{id}', [AdminController::class, 'updateFakultas'])->name('akademik.fakultas.update');
        Route::delete('/akademik/fakultas/{id}', [AdminController::class, 'deleteFakultas'])->name('akademik.fakultas.delete');
        Route::post('/akademik/fakultas/import', [AdminController::class, 'importFakultas'])->name('akademik.fakultas.import');
        
        Route::post('/akademik/prodi', [AdminController::class, 'storeProdi'])->name('akademik.prodi.store');
        Route::put('/akademik/prodi/{id}', [AdminController::class, 'updateProdi'])->name('akademik.prodi.update');
        Route::delete('/akademik/prodi/{id}', [AdminController::class, 'deleteProdi'])->name('akademik.prodi.delete');
        Route::post('/akademik/prodi/import', [AdminController::class, 'importProdi'])->name('akademik.prodi.import');
        
        Route::post('/akademik/kelas', [AdminController::class, 'storeKelas'])->name('akademik.kelas.store');
        Route::put('/akademik/kelas/{id}', [AdminController::class, 'updateKelas'])->name('akademik.kelas.update');
        Route::delete('/akademik/kelas/bulk-delete', [AdminController::class, 'bulkDeleteKelas'])->name('akademik.kelas.bulk-delete');
        Route::delete('/akademik/kelas/{id}', [AdminController::class, 'deleteKelas'])->name('akademik.kelas.delete');
        Route::post('/akademik/kelas/import', [AdminController::class, 'importKelas'])->name('akademik.kelas.import');

        Route::post('/akademik/matkul', [AdminController::class, 'storeMataKuliah'])->name('akademik.matkul.store');
        Route::put('/akademik/matkul/{id}', [AdminController::class, 'updateMataKuliah'])->name('akademik.matkul.update');
        Route::delete('/akademik/matkul/bulk-delete', [AdminController::class, 'bulkDeleteMataKuliah'])->name('akademik.matkul.bulk-delete');
        Route::delete('/akademik/matkul/{id}', [AdminController::class, 'deleteMataKuliah'])->name('akademik.matkul.delete');
        Route::post('/akademik/matkul/import', [AdminController::class, 'importMataKuliah'])->name('akademik.matkul.import');
    });

    // Dosen Routes
    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
        Route::post('/agenda', [DosenController::class, 'storeAgenda'])->name('agenda.store');
        Route::post('/agenda/generate-16/{jadwal_id}', [DosenController::class, 'generate16Pertemuan'])->name('agenda.generate-16');
        Route::put('/agenda/{id}', [DosenController::class, 'updateAgenda'])->name('agenda.update');
        Route::delete('/agenda/bulk-delete', [DosenController::class, 'bulkDeleteAgendas'])->name('agenda.bulk-delete');
        Route::delete('/agenda/{id}', [DosenController::class, 'deleteAgenda'])->name('agenda.delete');
        Route::put('/agenda/{id}/realisasi', [DosenController::class, 'updateRealisasi'])->name('agenda.realisasi');
        Route::put('/agenda/{id}/berita-acara', [DosenController::class, 'updateBeritaAcara'])->name('agenda.berita-acara');
        Route::post('/agenda/{id}/qr-new', [DosenController::class, 'generateNewQrToken'])->name('agenda.qr');
        Route::post('/absensi', [DosenController::class, 'submitAttendance'])->name('absensi.submit');
        Route::post('/absensi/import-global', [DosenController::class, 'importAbsensiGlobal'])->name('absensi.import-global');
        Route::get('/absensi/{id}/input', [DosenController::class, 'inputAbsensi'])->name('absensi.input');
        Route::post('/absensi/{id}/import', [DosenController::class, 'importAbsensi'])->name('absensi.import');
        Route::post('/absensi/{id}/input', [DosenController::class, 'storeInputAbsensi'])->name('absensi.store-input');
        
        Route::get('/agenda', [DosenController::class, 'agenda'])->name('agenda');
        Route::get('/agenda/{id}/export-kehadiran', [DosenController::class, 'exportKehadiran'])->name('agenda.export-kehadiran');
        Route::get('/agenda/{id}/berita-acara/cetak', [DosenController::class, 'cetakBeritaAcara'])->name('agenda.berita-acara.cetak');
        Route::get('/agenda/{id}/realisasi-praktikum/cetak', [DosenController::class, 'cetakRealisasiPraktikum'])->name('agenda.realisasi-praktikum.cetak');
        Route::get('/jadwal-lab', [DosenController::class, 'jadwalPenggunaanLab'])->name('jadwal-lab');
        Route::get('/jadwal-lab/check-availability', [DosenController::class, 'checkLabAvailability'])->name('jadwal-lab.check-availability');
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
        Route::get('/pengumuman', [MahasiswaController::class, 'pengumuman'])->name('pengumuman');
        Route::get('/pengaturan', [MahasiswaController::class, 'pengaturan'])->name('pengaturan');
        Route::put('/pengaturan', [MahasiswaController::class, 'updatePengaturan'])->name('pengaturan.update');
    });

    Route::get('/batch-status/{id}', [\App\Http\Controllers\BatchController::class, 'status'])->name('batch.status');
});

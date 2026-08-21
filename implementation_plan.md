# Rencana Implementasi: Halaman Panel Mahasiswa & Admin

Dokumen ini menjelaskan rencana teknis untuk melengkapi dan menyempurnakan seluruh halaman pada panel **Mahasiswa** dan **Admin** di platform **Digital Board** agar fungsional secara dinamis, teratur, dan premium.

---

## Panel Mahasiswa (Student Portal)

### 1. Dashboard (`/mahasiswa/dashboard`)
*   **Fungsi**: Halaman utama untuk scan QR token, daftar kelas praktikum hari ini, status check-in, dan pengumuman.
*   **Status**: Sudah diimplementasikan dan diintegrasikan dengan fitur "Ajukan Izin" (modal form).

### 2. Riwayat Kehadiran (`/mahasiswa/riwayat`) [NEW]
*   **Route**: `Route::get('/riwayat', [MahasiswaController::class, 'riwayat'])->name('riwayat');`
*   **View**: `resources/views/mahasiswa/riwayat.blade.php`
*   **Fitur**:
    *   Ringkasan Statistik Kehadiran (Total Hadir, Total Izin, Total Alpa, Persentase).
    *   Tabel filterable seluruh riwayat kehadiran kelas (berdasarkan pencarian nama MK, filter tipe kehadiran, atau range tanggal).
    *   Log status pengajuan izin beserta bukti surat izin/sakit.

### 3. Pengaturan Profil (`/mahasiswa/pengaturan`) [NEW]
*   **Route**:
    *   `Route::get('/pengaturan', [MahasiswaController::class, 'pengaturan'])->name('pengaturan');`
    *   `Route::put('/pengaturan', [MahasiswaController::class, 'updatePengaturan'])->name('pengaturan.update');`
*   **View**: `resources/views/mahasiswa/pengaturan.blade.php`
*   **Fitur**:
    *   Pembaruan nama lengkap dan NIM mahasiswa.
    *   Form ganti password akun mahasiswa.

---

## Panel Admin (Admin Console)

### 1. Dashboard Overview (`/admin/dashboard`) [MODIFY]
*   **Route**: `Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');`
*   **View**: `resources/views/admin/dashboard.blade.php`
*   **Fitur**:
    *   Memindahkan form manajemen pengguna, lab, dan pengumuman dari dashboard ke sub-page khusus agar dashboard lebih fokus pada visualisasi data.
    *   Dashboard difokuskan pada ringkasan statistik (Bento Box), monitoring lab yang aktif, pengumuman terbaru, dan grafik log aktivitas presensi terbaru.

### 2. Manajemen Pengguna (`/admin/pengguna`) [NEW]
*   **Route**:
    *   `Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('pengguna');`
    *   `Route::post('/pengguna', [AdminController::class, 'storeUser'])->name('pengguna.store');`
    *   `Route::put('/pengguna/{id}', [AdminController::class, 'updateUser'])->name('pengguna.update');`
    *   `Route::delete('/pengguna/{id}', [AdminController::class, 'deleteUser'])->name('pengguna.delete');`
*   **View**: `resources/views/admin/pengguna.blade.php`
*   **Fitur**:
    *   List seluruh pengguna dengan filter Role (Admin, Dosen, Mahasiswa).
    *   Pencarian berdasarkan Nama, NIM/NIP, atau Username.
    *   Aksi: Tambah User, Edit Data Akun, dan Hapus Akun (Cascading delete ke tabel dosen/mahasiswa).
    *   Pagination tabel pengguna.

### 3. Manajemen Laboratorium (`/admin/laboratorium`) [NEW]
*   **Route**:
    *   `Route::get('/laboratorium', [AdminController::class, 'laboratorium'])->name('laboratorium');`
    *   `Route::post('/laboratorium', [AdminController::class, 'storeLab'])->name('laboratorium.store');`
    *   `Route::put('/laboratorium/{id}', [AdminController::class, 'updateLab'])->name('laboratorium.update');`
    *   `Route::delete('/laboratorium/{id}', [AdminController::class, 'deleteLab'])->name('laboratorium.delete');`
*   **View**: `resources/views/admin/laboratorium.blade.php`
*   **Fitur**:
    *   List seluruh laboratorium (Nama lab, lokasi gedung/ruangan).
    *   Aksi: Tambah Lab baru, Edit Lokasi/Nama Lab, dan Hapus Lab.

### 4. Manajemen Agenda Praktikum (`/admin/agenda`) [NEW]
*   **Route**:
    *   `Route::get('/agenda', [AdminController::class, 'agenda'])->name('agenda');`
    *   `Route::delete('/agenda/{id}', [AdminController::class, 'deleteAgenda'])->name('agenda.delete');`
*   **View**: `resources/views/admin/agenda.blade.php`
*   **Fitur**:
    *   Daftar seluruh agenda/kelas mengajar yang dibuat oleh dosen di seluruh lab.
    *   Filter berdasarkan Dosen, Laboratorium, dan Tanggal.
    *   Aksi: Hapus agenda jika terjadi duplikasi atau kesalahan penjadwalan.

### 5. Laporan Absensi Mahasiswa (`/admin/absensi`) [NEW]
*   **Route**:
    *   `Route::get('/absensi', [AdminController::class, 'absensi'])->name('absensi');`
    *   `Route::get('/absensi/export', [AdminController::class, 'exportAbsensi'])->name('absensi.export');`
*   **View**: `resources/views/admin/absensi.blade.php`
*   **Fitur**:
    *   Monitoring kehadiran mahasiswa di seluruh kelas praktikum secara real-time.
    *   Filter presensi berdasarkan Mata Kuliah, Kelas, Tanggal, atau Status (Hadir, Izin, Alpa).
    *   Ekspor data absensi ke bentuk sederhana (Print-friendly HTML atau CSV).

### 6. Manajemen Pengumuman (`/admin/pengumuman`) [NEW]
*   **Route**:
    *   `Route::get('/pengumuman', [AdminController::class, 'pengumuman'])->name('pengumuman');`
    *   `Route::post('/pengumuman', [AdminController::class, 'storePengumuman'])->name('pengumuman.store');`
    *   `Route::delete('/pengumuman/{id}', [AdminController::class, 'deletePengumuman'])->name('pengumuman.delete');`
*   **View**: `resources/views/admin/pengumuman.blade.php`
*   **Fitur**:
    *   Tabel daftar seluruh pengumuman resmi lab yang diterbitkan oleh admin.
    *   Aksi: Tambah/Terbitkan pengumuman baru, dan Hapus pengumuman lama.

---

## Rencana Perubahan Kode & File

### 1. File Routing & Controllers
*   **[`web.php`](file:///c:/apk/laragon/www/digital%20board/routes/web.php)**: Tambahkan route baru untuk Mahasiswa dan Admin.
*   **[`MahasiswaController.php`](file:///c:/apk/laragon/www/digital%20board/app/Http/Controllers/MahasiswaController.php)**: Tambahkan method `riwayat`, `pengaturan`, dan `updatePengaturan`.
*   **[`AdminController.php`](file:///c:/apk/laragon/www/digital%20board/app/Http/Controllers/AdminController.php)**: Tambahkan method `pengguna`, `deleteUser`, `laboratorium`, `updateLab`, `deleteLab`, `agenda`, `deleteAgenda`, `absensi`, `exportAbsensi`, dan `pengumuman`.

### 2. Layouts & Templates
*   Membuat sidebar & bottombar yang konsisten untuk panel Admin dan Mahasiswa, mirip dengan panel Dosen yang telah dirapikan.
*   **[`mahasiswa/dashboard.blade.php`](file:///c:/apk/laragon/www/digital%20board/resources/views/mahasiswa/dashboard.blade.php)**: Hubungkan link sidebar/bottombar ke route dinamis yang baru.
*   **[`admin/dashboard.blade.php`](file:///c:/apk/laragon/www/digital%20board/resources/views/admin/dashboard.blade.php)**: Perbarui link sidebar ke halaman-halaman panel admin yang baru.

---

## Verification Plan

### Automated Tests
*   `php artisan route:list` untuk memastikan semua route terdaftar dan terikat ke controller dengan benar.

### Manual Verification
1.  **Panel Mahasiswa**:
    *   Login sebagai Mahasiswa (`2023001001`), buka menu **Riwayat Kehadiran**, pastikan grafik dan log izin pending muncul dengan benar.
    *   Buka menu **Pengaturan**, coba ubah nama dan password akun, lalu uji login kembali dengan password baru.
2.  **Panel Admin**:
    *   Login sebagai Admin (`admin1`).
    *   Buka halaman **Manajemen Pengguna**, coba buat akun baru, edit datanya, dan hapus akun tersebut. Pastikan cascading delete ke data mahasiswa/dosen terhapus di database.
    *   Buka halaman **Manajemen Laboratorium**, coba edit nama lab atau lokasi gedung, lalu periksa apakah perubahan terupdate di database.
    *   Buka halaman **Laporan Absensi**, periksa kebenaran log absensi mahasiswa, dan uji fitur ekspor data.

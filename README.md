# Digital Board 🖥️🎓

[![Laravel Version](https://img.shields.io/badge/Laravel-v11.x-red.svg?style=flat-flat&logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-v8.2+-blue.svg?style=flat-flat&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

**Digital Board** adalah platform manajemen presensi praktikum, penjadwalan laboratorium, dan portal informasi akademik berbasis web yang dirancang khusus untuk mahasiswa, dosen, dan administrator laboratorium. Sistem ini mengintegrasikan presensi real-time berbasis kode token/QR scan guna meminimalisir kecurangan absensi serta mempercepat rekapitulasi data akademik.

---

## 🚀 Fitur Utama Berdasarkan Peran

Sistem **Digital Board** membagi hak akses pengguna ke dalam 3 portal utama:

### 1. 🎓 Portal Mahasiswa (Student Portal)
*   **Dashboard Interaktif**: Scan token/QR code kelas, pantau status check-in, dan lihat kelas aktif hari ini.
*   **Pengajuan Izin**: Formulir digital untuk mengunggah bukti surat izin/sakit langsung dari dashboard.
*   **Riwayat Kehadiran**: Rekapitulasi statistik kehadiran (Hadir, Izin, Alfa) lengkap dengan log filter tanggal dan mata kuliah.
*   **Pengaturan Profil**: Mengubah nama, NIM, dan memperbarui kata sandi secara mandiri.

### 2. 👨‍🏫 Portal Dosen (Lecturer Portal)
*   **Manajemen Sesi Praktikum**: Membuat agenda kelas baru, membuka sesi presensi, serta menghasilkan token absensi secara dinamis.
*   **Verifikasi Izin**: Meninjau dan menyetujui/menolak pengajuan perizinan mahasiswa beserta bukti fisiknya.
*   **Rekap & Ekspor Laporan**: Mengunduh data absensi per kelas maupun per mahasiswa dalam format cetak (HTML Print) atau spreadsheet.

### 3. 🛡️ Konsol Admin (Admin Console)
*   **Bento-style Dashboard**: Visualisasi data statistik pengguna, log aktivitas presensi, monitoring laboratorium aktif, dan pengumuman terbaru.
*   **Manajemen Pengguna**: CRUD akun admin, dosen, dan mahasiswa dengan fitur pencarian, filter, dan penghapusan relasional (*cascading delete*).
*   **Manajemen Laboratorium**: Konfigurasi daftar ruang laboratorium beserta lokasi gedung.
*   **Oversight Agenda & Laporan**: Pemantauan semua agenda praktikum yang sedang berjalan serta rekapitulasi absensi global.
*   **Penerbitan Pengumuman**: Menyebarluaskan pengumuman resmi ke seluruh portal pengguna.

---

## 🛠️ Tech Stack & Prasyarat

Sebelum memulai instalasi, pastikan lingkungan pengembangan Anda telah memenuhi spesifikasi berikut:

*   **Runtime**: PHP `>= 8.2`
*   **Database**: MySQL / MariaDB (Direkomendasikan menggunakan Laragon atau XAMPP)
*   **Package Manager**: Composer & Node.js (NPM)
*   **Framework**: Laravel 11.x
*   **Frontend**: Tailwind CSS (via Vite) & Blade Templating Engine

---

## 💻 Instalasi dan Konfigurasi

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek **Digital Board** di server lokal Anda:

### 1. Clone Repositori
```bash
git clone https://github.com/MuhammadAdityaRizky/DIGITAL-Board-.git
cd "DIGITAL-Board-"
```

### 2. Instal Dependensi PHP & JavaScript
```bash
# Instal dependensi backend Laravel
composer install

# Instal dependensi frontend
npm install
```

### 3. Konfigurasi Environment File
Salin file konfigurasi `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Sesuaikan konfigurasi database pada file `.env` Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=digital_board
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Setup Database & Seeding
Anda dapat menyiapkan database dengan dua cara:

> [!TIP]
> **Cara A: Menjalankan Migrasi Laravel (Direkomendasikan untuk pengembangan)**
> ```bash
> php artisan migrate --seed
> ```
> 
> **Cara B: Mengimpor SQL Dump Manual**
> Impor file `digital_board yg baru.sql` yang tersedia di direktori root ke dalam database MySQL Anda (`digital_board`).

### 6. Jalankan Server Lokal
Jalankan server Laravel dan compiler aset frontend (Vite) secara bersamaan:
```bash
# Terminal 1: Menjalankan Server Laravel
php artisan serve

# Terminal 2: Menjalankan Vite Dev Server
npm run dev
```
Buka `http://localhost:8000` pada peramban web Anda.

---

## 🔑 Akun Demo (Default Credentials)

Berikut adalah beberapa akun bawaan hasil *seeding* database untuk keperluan pengujian:

| Role | Username / NIP / NIM | Password |
| :--- | :--- | :--- |
| **Admin** | `admin1` | `password` |
| **Dosen** | `198501012010121001` | `password` |
| **Mahasiswa** | `2023001001` | `password` |

---

## 📁 Struktur Direktori Penting

*   `app/Http/Controllers/` — Logika pengendali alur aplikasi (Admin, Dosen, Mahasiswa, Autentikasi).
*   `app/Models/` — Model Eloquent yang memetakan entitas database (Mahasiswa, Dosen, Absensi, Agenda, Kelas, dll).
*   `database/migrations/` — Definisi skema tabel database.
*   `resources/views/` — Tampilan UI Blade (Terbagi menjadi folder admin, dosen, mahasiswa, dan layout bersama).
*   `routes/web.php` — Definisi routing URL web.

---

## 📄 Lisensi

Proyek ini dirilis di bawah lisensi [MIT](LICENSE). Anda bebas menggunakannya untuk tujuan belajar maupun pengembangan lebih lanjut.

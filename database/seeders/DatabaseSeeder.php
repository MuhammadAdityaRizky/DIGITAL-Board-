<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users (Super Admin Default)
        DB::table('users')->insert([
            [
                'id' => 1,
                'username' => 'admin1',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'created_at' => now(),
            ],
        ]);

        // 2. Fakultas
        DB::table('fakultas')->insert([
            [
                'id' => 1,
                'nama_fakultas' => 'Fakultas Teknik dan Sains (FTS)',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis (FEB)',
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'nama_fakultas' => 'Fakultas Agama Islam (FAI)',
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'nama_fakultas' => 'Fakultas Keguruan dan Ilmu Pendidikan (FKIP)',
                'created_at' => now(),
            ],
            [
                'id' => 5,
                'nama_fakultas' => 'Fakultas Hukum (FH)',
                'created_at' => now(),
            ],
            [
                'id' => 6,
                'nama_fakultas' => 'Fakultas Ilmu Kesehatan (FIKES)',
                'created_at' => now(),
            ],
        ]);

        // 3. Prodi
        DB::table('prodi')->insert([
            // FAI
            [
                'id' => 1,
                'fakultas_id' => 1,
                'nama_prodi' => 'Pendidikan Agama Islam',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'fakultas_id' => 1,
                'nama_prodi' => 'Hukum Keluarga Islam (Ahwal Al-Syakhshiyyah)',
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'fakultas_id' => 1,
                'nama_prodi' => 'Komunikasi dan Penyiaran Islam',
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'fakultas_id' => 1,
                'nama_prodi' => 'Ekonomi Syariah (FAI)',
                'created_at' => now(),
            ],
            [
                'id' => 5,
                'fakultas_id' => 1,
                'nama_prodi' => 'Pendidikan Guru Madrasah Ibtidaiyah (PGMI)',
                'created_at' => now(),
            ],
            [
                'id' => 6,
                'fakultas_id' => 1,
                'nama_prodi' => 'Bimbingan dan Konseling Pendidikan Islam',
                'created_at' => now(),
            ],
            // FKIP
            [
                'id' => 7,
                'fakultas_id' => 2,
                'nama_prodi' => 'Pendidikan Masyarakat',
                'created_at' => now(),
            ],
            [
                'id' => 8,
                'fakultas_id' => 2,
                'nama_prodi' => 'Pendidikan Bahasa Inggris',
                'created_at' => now(),
            ],
            [
                'id' => 9,
                'fakultas_id' => 2,
                'nama_prodi' => 'Teknologi Pendidikan',
                'created_at' => now(),
            ],
            [
                'id' => 10,
                'fakultas_id' => 2,
                'nama_prodi' => 'Pendidikan Vokasional Desain Fashion (PVDF)',
                'created_at' => now(),
            ],
            // FTS
            [
                'id' => 11,
                'fakultas_id' => 3,
                'nama_prodi' => 'Teknik Informatika',
                'created_at' => now(),
            ],
            [
                'id' => 12,
                'fakultas_id' => 3,
                'nama_prodi' => 'Teknik Sipil',
                'created_at' => now(),
            ],
            [
                'id' => 13,
                'fakultas_id' => 3,
                'nama_prodi' => 'Teknik Mesin',
                'created_at' => now(),
            ],
            [
                'id' => 14,
                'fakultas_id' => 3,
                'nama_prodi' => 'Teknik Elektro',
                'created_at' => now(),
            ],
            // FEB
            [
                'id' => 15,
                'fakultas_id' => 4,
                'nama_prodi' => 'Manajemen',
                'created_at' => now(),
            ],
            [
                'id' => 16,
                'fakultas_id' => 4,
                'nama_prodi' => 'Akuntansi',
                'created_at' => now(),
            ],
            [
                'id' => 17,
                'fakultas_id' => 4,
                'nama_prodi' => 'Keuangan dan Perbankan',
                'created_at' => now(),
            ],
            [
                'id' => 18,
                'fakultas_id' => 4,
                'nama_prodi' => 'Ekonomi Syariah (FEB)',
                'created_at' => now(),
            ],
            // FH
            [
                'id' => 19,
                'fakultas_id' => 5,
                'nama_prodi' => 'Ilmu Hukum',
                'created_at' => now(),
            ],
            // FIKES
            [
                'id' => 20,
                'fakultas_id' => 6,
                'nama_prodi' => 'Kesehatan Masyarakat',
                'created_at' => now(),
            ],
        ]);

        // 5.5. Master Kelas Akademik
        DB::table('kelas')->insert([
            ['id' => 1, 'nama_kelas' => 'IF-A 2023', 'created_at' => now()],
            ['id' => 2, 'nama_kelas' => 'SI-B 2023', 'created_at' => now()],
            ['id' => 3, 'nama_kelas' => 'TI-1A', 'created_at' => now()],
            ['id' => 4, 'nama_kelas' => 'TI-1B', 'created_at' => now()],
        ]);

        // 6. Laboratorium
        DB::table('laboratorium')->insert([
            [
                'id' => 1,
                'nama_lab' => 'Laboratorium Komputer 1',
                'lokasi' => 'Gedung B Lantai 2',
                'kapasitas' => 30,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'nama_lab' => 'Laboratorium Sistem Informasi',
                'lokasi' => 'Gedung C Lantai 1',
                'kapasitas' => 40,
                'created_at' => now(),
            ],
        ]);

        // 9. Pengumuman
        DB::table('pengumuman')->insert([
            [
                'id' => 1,
                'admin_id' => 1,
                'judul' => 'Jadwal Ujian Tengah Semester (UTS)',
                'isi_pengumuman' => 'Pelaksanaan UTS ganjil akan dimulai pada minggu pertama bulan ini. Mohon persiapkan berkas pendaftaran Anda.',
                'prioritas' => 'Penting',
                'is_pinned' => 1,
                'foto_url' => null,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'admin_id' => 1,
                'judul' => 'Pemeliharaan Jaringan & Komputer Laboratorium',
                'isi_pengumuman' => 'Akan dilakukan perawatan rutin jaringan lokal (LAN) dan pembaruan perangkat lunak pada seluruh lab komputer.',
                'prioritas' => 'Biasa',
                'is_pinned' => 0,
                'foto_url' => null,
                'created_at' => now()->subDays(2),
            ],
            [
                'id' => 3,
                'admin_id' => 1,
                'judul' => 'Pendaftaran Asisten Praktikum Laboratorium',
                'isi_pengumuman' => 'Pendaftaran Asisten Praktikum untuk semester ini telah dibuka. Persyaratan dan formulir pendaftaran dapat diakses melalui portal resmi.',
                'prioritas' => 'Penting',
                'is_pinned' => 0,
                'foto_url' => null,
                'created_at' => now()->subDays(5),
            ],
        ]);
    }
}

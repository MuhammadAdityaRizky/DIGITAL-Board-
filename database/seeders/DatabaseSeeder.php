<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        DB::table('users')->insert([
            [
                'id' => 1,
                'username_or_nim_nip' => 'admin1',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'nama_lengkap' => 'Super Admin Lab',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'username_or_nim_nip' => '198501012010121001',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'nama_lengkap' => 'Dr. Budi Santoso, M.T.',
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'username_or_nim_nip' => '2023001001',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nama_lengkap' => 'Ahmad Rizky',
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'username_or_nim_nip' => '2023001002',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nama_lengkap' => 'Siti Nurhaliza',
                'created_at' => now(),
            ],
        ]);

        // 2. Dosen
        DB::table('dosen')->insert([
            [
                'id' => 1,
                'user_id' => 2,
                'nip' => '198501012010121001',
            ],
        ]);

        // 3. Mahasiswa
        DB::table('mahasiswa')->insert([
            [
                'id' => 1,
                'user_id' => 3,
                'nim' => '2023001001',
            ],
            [
                'id' => 2,
                'user_id' => 4,
                'nim' => '2023001002',
            ],
        ]);

        // 4. Laboratorium
        DB::table('laboratorium')->insert([
            [
                'id' => 1,
                'nama_lab' => 'Laboratorium Komputer 1',
                'lokasi' => 'Gedung B Lantai 2',
            ],
            [
                'id' => 2,
                'nama_lab' => 'Laboratorium Sistem Informasi',
                'lokasi' => 'Gedung C Lantai 1',
            ],
        ]);

        // 5. Pengumuman
        DB::table('pengumuman')->insert([
            [
                'id' => 1,
                'admin_id' => 1,
                'judul_pengumuman' => 'Pemeliharaan Jaringan Lab',
                'penjelasan' => 'Akan dilakukan perawatan jaringan lokal pada pukul 16:00 WIB.',
                'tanggal' => date('Y-m-d'),
                'created_at' => now(),
            ],
        ]);

        // 6. Agenda
        DB::table('agenda')->insert([
            [
                'id' => 1,
                'dosen_id' => 1,
                'lab_id' => 1,
                'judul_agenda' => 'Praktikum Pemrograman Web',
                'tanggal' => date('Y-m-d'),
                'waktu_masuk' => '08:00:00',
                'waktu_keluar' => '10:30:00',
                'rencana_pembelajaran' => 'Membahas integrasi MySQL dan PHP',
                'realisasi_pembelajaran' => 'Selesai menjelaskan koneksi database & CRUD sederhana',
                'qr_code_token' => 'TOKEN_QR_AGENDA_1_20260811',
                'created_at' => now(),
            ],
        ]);

        // 7. Absensi
        DB::table('absensi')->insert([
            [
                'id' => 1,
                'agenda_id' => 1,
                'mahasiswa_id' => 1,
                'waktu_kehadiran' => now(),
                'status' => 'Hadir',
            ],
            [
                'id' => 2,
                'agenda_id' => 1,
                'mahasiswa_id' => 2,
                'waktu_kehadiran' => now(),
                'status' => 'Hadir',
            ],
        ]);
    }
}

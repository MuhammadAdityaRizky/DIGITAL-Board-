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
                'username' => 'admin1',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'username' => '198501012010121001',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'username' => '2023001001',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'username' => '2023001002',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'created_at' => now(),
            ],
        ]);

        // 2. Fakultas
        DB::table('fakultas')->insert([
            [
                'id' => 1,
                'nama_fakultas' => 'Fakultas Agama Islam (FAI)',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'nama_fakultas' => 'Fakultas Keguruan dan Ilmu Pendidikan (FKIP)',
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'nama_fakultas' => 'Fakultas Teknik dan Sains (FTS)',
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis (FEB)',
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

        // 4. Dosen
        DB::table('dosen')->insert([
            [
                'id' => 1,
                'user_id' => 2,
                'nip' => '198501012010121001',
                'nama' => 'Dr. Budi Santoso, M.T.',
                'status' => 'Tetap',
                'id_fakultas' => 3,
                'id_prodi' => 11,
                'kompetensi' => 'Pemrograman Web, Cloud Computing',
                'created_at' => now(),
            ],
        ]);

        // 5. Mahasiswa
        DB::table('mahasiswa')->insert([
            [
                'id' => 1,
                'user_id' => 3,
                'nim' => '2023001001',
                'nama_lengkap' => 'Ahmad Rizky',
                'id_fakultas' => 3,
                'id_prodi' => 11,
                'kelas' => 'TI-1B',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'user_id' => 4,
                'nim' => '2023001002',
                'nama_lengkap' => 'Siti Nurhaliza',
                'id_fakultas' => 3,
                'id_prodi' => 11,
                'kelas' => 'TI-1B',
                'created_at' => now(),
            ],
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

        // 7. Agenda
        DB::table('agenda')->insert([
            [
                'id' => 1,
                'dosen_id' => 1,
                'lab_id' => 1,
                'mata_kuliah' => 'Praktikum Pemrograman Web',
                'tanggal' => date('Y-m-d'),
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '10:30:00',
                'status_agenda' => 'Berlangsung',
                'catatan' => 'Membahas integrasi MySQL dan PHP',
                'created_at' => now(),
            ],
        ]);

        // 8. Absensi
        DB::table('absensi')->insert([
            [
                'id' => 1,
                'agenda_id' => 1,
                'mahasiswa_id' => 1,
                'waktu_masuk' => now(),
                'status_kehadiran' => 'Hadir',
            ],
            [
                'id' => 2,
                'agenda_id' => 1,
                'mahasiswa_id' => 2,
                'waktu_masuk' => now(),
                'status_kehadiran' => 'Hadir',
            ],
        ]);

        // 9. Pengumuman
        DB::table('pengumuman')->insert([
            [
                'id' => 1,
                'admin_id' => 1,
                'judul' => 'Pemeliharaan Jaringan Lab',
                'isi_pengumuman' => 'Akan dilakukan perawatan jaringan lokal pada pukul 16:00 WIB.',
                'foto_url' => null,
                'created_at' => now(),
            ],
        ]);
    }
}

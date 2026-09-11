<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laboratorium;
use App\Models\JadwalPenggunaanLab;

class JadwalPenggunaanLabSeeder extends Seeder
{
    public function run()
    {
        $lab209 = Laboratorium::firstOrCreate(
            ['nama_lab' => 'Lab 209'],
            ['lokasi' => 'Gedung FTS Lantai 2', 'kapasitas' => 40]
        );

        $items = [
            ['lab_id' => $lab209->id, 'hari' => 'Senin', 'jam_mulai' => '08:00:00', 'jam_selesai' => '11:00:00', 'mata_kuliah' => 'Praktikum Dasar Bahasa Pemrograman', 'dosen_id' => 10, 'kelas' => 'Reg A', 'semester' => '1', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Senin', 'jam_mulai' => '13:00:00', 'jam_selesai' => '15:00:00', 'mata_kuliah' => 'Praktikum English for IT Business Communication', 'dosen_id' => 10, 'kelas' => 'Reg A', 'semester' => '3', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Senin', 'jam_mulai' => '15:00:00', 'jam_selesai' => '17:00:00', 'mata_kuliah' => 'Praktikum Dasar Bahasa Pemrograman', 'dosen_id' => 10, 'kelas' => 'Reg B', 'semester' => '1', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Selasa', 'jam_mulai' => '08:00:00', 'jam_selesai' => '10:00:00', 'mata_kuliah' => 'Proyek Aplikasi Bisnis + Praktikum', 'dosen_id' => 10, 'kelas' => 'Reg A', 'semester' => '5', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Selasa', 'jam_mulai' => '10:00:00', 'jam_selesai' => '12:00:00', 'mata_kuliah' => 'Proyek Aplikasi Bisnis + Praktikum', 'dosen_id' => 10, 'kelas' => 'Reg B', 'semester' => '5', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Selasa', 'jam_mulai' => '15:00:00', 'jam_selesai' => '17:00:00', 'mata_kuliah' => 'Pemrograman Berorientasi Objek', 'dosen_id' => 10, 'kelas' => 'Reg A', 'semester' => '3', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Selasa', 'jam_mulai' => '17:00:00', 'jam_selesai' => '19:00:00', 'mata_kuliah' => 'Praktikum Python Object Oriented Programming', 'dosen_id' => 10, 'kelas' => 'Reg A', 'semester' => '3', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Rabu', 'jam_mulai' => '08:00:00', 'jam_selesai' => '10:00:00', 'mata_kuliah' => 'Proyek Manajemen Bidang Sistem Informasi + Praktikum', 'dosen_id' => 9, 'kelas' => 'Reg B', 'semester' => '5', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Rabu', 'jam_mulai' => '10:00:00', 'jam_selesai' => '12:00:00', 'mata_kuliah' => 'Metode Penelitian Bidang Sistem Informasi + Praktikum', 'dosen_id' => 9, 'kelas' => 'Reg B', 'semester' => '5', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Rabu', 'jam_mulai' => '13:00:00', 'jam_selesai' => '15:00:00', 'mata_kuliah' => 'Praktikum Pemodelan Proses Bisnis', 'dosen_id' => 8, 'kelas' => 'Reg A', 'semester' => '3', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Rabu', 'jam_mulai' => '15:00:00', 'jam_selesai' => '17:00:00', 'mata_kuliah' => 'Praktikum Perancangan Sistem', 'dosen_id' => 8, 'kelas' => 'Reg A', 'semester' => '3', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Kamis', 'jam_mulai' => '08:00:00', 'jam_selesai' => '10:00:00', 'mata_kuliah' => 'Proyek Manajemen Bidang Sistem Informasi + Praktikum', 'dosen_id' => 7, 'kelas' => 'Reg A', 'semester' => '5', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Kamis', 'jam_mulai' => '10:00:00', 'jam_selesai' => '12:00:00', 'mata_kuliah' => 'Metode Penelitian Bidang Sistem Informasi + Praktikum', 'dosen_id' => 7, 'kelas' => 'Reg A', 'semester' => '5', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Kamis', 'jam_mulai' => '13:00:00', 'jam_selesai' => '15:00:00', 'mata_kuliah' => 'Business Intelligence + Praktikum', 'dosen_id' => 7, 'kelas' => 'Reg A', 'semester' => '5', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Kamis', 'jam_mulai' => '15:00:00', 'jam_selesai' => '17:00:00', 'mata_kuliah' => 'Business Intelligence + Praktikum', 'dosen_id' => 7, 'kelas' => 'Reg B', 'semester' => '5', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Jumat', 'jam_mulai' => '15:00:00', 'jam_selesai' => '17:00:00', 'mata_kuliah' => 'Komputasi Kolaboratif + Praktikum', 'dosen_id' => 11, 'kelas' => 'Reg A', 'semester' => '5', 'id_prodi' => 21],
            ['lab_id' => $lab209->id, 'hari' => 'Jumat', 'jam_mulai' => '17:00:00', 'jam_selesai' => '19:00:00', 'mata_kuliah' => 'Komputasi Kolaboratif + Praktikum', 'dosen_id' => 11, 'kelas' => 'Reg B', 'semester' => '5', 'id_prodi' => 21],
        ];

        foreach ($items as $item) {
            JadwalPenggunaanLab::updateOrCreate(
                [
                    'lab_id' => $item['lab_id'],
                    'hari' => $item['hari'],
                    'jam_mulai' => $item['jam_mulai'],
                    'mata_kuliah' => $item['mata_kuliah'],
                    'kelas' => $item['kelas'],
                ],
                $item
            );
        }
    }
}

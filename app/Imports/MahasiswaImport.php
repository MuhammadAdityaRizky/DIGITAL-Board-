<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Pastikan NIM ada dan belum terdaftar di tabel mahasiswa
        if (!isset($row['nim'])) {
            return null;
        }

        $existingMahasiswa = Mahasiswa::where('nim', $row['nim'])->first();
        if ($existingMahasiswa) {
            return null; // Skip jika sudah ada
        }

        // Cek atau buat User
        $user = User::firstOrCreate(
            ['username' => $row['nim']],
            [
                'password' => Hash::make($row['nim']), // Default password adalah NIM
                'role' => 'mahasiswa'
            ]
        );

        return new Mahasiswa([
            'user_id' => $user->id,
            'nim' => $row['nim'],
            'nama_lengkap' => $row['nama_lengkap'] ?? $row['nama'],
            'id_fakultas' => $row['id_fakultas'] ?? null,
            'id_prodi' => $row['id_prodi'] ?? null,
            'kelas' => $row['kelas'] ?? '-',
            'semester' => $row['semester'] ?? '1',
        ]);
    }
}

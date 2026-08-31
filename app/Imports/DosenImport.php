<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['nip'])) {
            return null;
        }

        $existingDosen = Dosen::where('nip', $row['nip'])->first();
        if ($existingDosen) {
            return null;
        }

        $user = User::firstOrCreate(
            ['username' => $row['nip']],
            [
                'password' => Hash::make($row['nip']),
                'role' => 'dosen'
            ]
        );

        return new Dosen([
            'user_id' => $user->id,
            'nip' => $row['nip'],
            'nama' => $row['nama'],
            'status' => $row['status'] ?? 'Tetap',
            'id_fakultas' => $row['id_fakultas'] ?? null,
            'id_prodi' => $row['id_prodi'] ?? null,
            'kompetensi' => $row['kompetensi'] ?? null,
        ]);
    }
}

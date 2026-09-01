<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToModel, WithHeadingRow
{
    public function model(array $row): \Illuminate\Database\Eloquent\Model|array|null
    {
        $nip = $row['nip'] ?? $row['nipd'] ?? $row['nik'] ?? null;

        if (!$nip) {
            return null;
        }

        $id_prodi = $row['id_prodi'] ?? null;
        $id_fakultas = $row['id_fakultas'] ?? null;

        if (empty($id_prodi) && !empty($row['prodi'])) {
            $prodi = \App\Models\Prodi::where('nama_prodi', 'like', '%' . $row['prodi'] . '%')->first();
            if ($prodi) {
                $id_prodi = $prodi->id;
                $id_fakultas = $prodi->fakultas_id;
            }
        }

        $existingDosen = Dosen::where('nip', $nip)->first();
        if ($existingDosen) {
            return null;
        }

        $user = User::firstOrCreate(
            ['username' => $nip],
            [
                'password' => Hash::make($nip),
                'role' => 'dosen'
            ]
        );

        return new Dosen([
            'user_id' => $user->id,
            'nip' => $nip,
            'nama' => $row['nama'],
            'status' => $row['status'] ?? 'Tetap',
            'jabatan' => $row['jabatan'] ?? null,
            'id_fakultas' => $id_fakultas,
            'id_prodi' => $id_prodi,
            'kompetensi' => $row['kompetensi'] ?? null,
        ]);
    }
}

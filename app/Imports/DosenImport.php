<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Fakultas;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToModel, WithHeadingRow
{
    protected ?int $defaultFakultasId;

    public function __construct(?int $defaultFakultasId = null)
    {
        $this->defaultFakultasId = $defaultFakultasId;
    }

    public function model(array $row): \Illuminate\Database\Eloquent\Model|array|null
    {
        $nip = $row['nip'] ?? $row['nipd'] ?? $row['nik'] ?? null;

        if (!$nip) {
            return null;
        }

        $id_prodi = $row['id_prodi'] ?? null;
        $id_fakultas = $this->defaultFakultasId ?: ($row['id_fakultas'] ?? null);

        if (empty($id_prodi) && !empty($row['prodi'])) {
            $prodiQuery = Prodi::where('nama_prodi', 'like', '%' . $row['prodi'] . '%');
            if ($this->defaultFakultasId) {
                $prodiQuery->where('fakultas_id', $this->defaultFakultasId);
            }
            $prodi = $prodiQuery->first();
            if ($prodi) {
                $id_prodi = $prodi->id;
                $id_fakultas = $prodi->fakultas_id ?? $id_fakultas;
            }
        }

        if (empty($id_fakultas) && !empty($row['fakultas'])) {
            $fak = Fakultas::where('nama_fakultas', 'like', '%' . $row['fakultas'] . '%')->first();
            if ($fak) {
                $id_fakultas = $fak->id;
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
                'role' => 'dosen',
                'fakultas_id' => $id_fakultas,
            ]
        );

        if ($id_fakultas && !$user->fakultas_id) {
            $user->update(['fakultas_id' => $id_fakultas]);
        }

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

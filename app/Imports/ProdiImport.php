<?php

namespace App\Imports;

use App\Models\Prodi;
use App\Models\Fakultas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProdiImport implements ToModel, WithHeadingRow
{
    public function model(array $row): \Illuminate\Database\Eloquent\Model|array|null
    {
        if (!isset($row['nama_prodi'])) {
            return null;
        }

        // Try to find fakultas by ID or Name
        $fakultasId = null;
        if (isset($row['fakultas_id'])) {
            $fakultasId = $row['fakultas_id'];
        } elseif (isset($row['nama_fakultas'])) {
            $fakultas = Fakultas::where('nama_fakultas', 'like', '%' . $row['nama_fakultas'] . '%')->first();
            if ($fakultas) {
                $fakultasId = $fakultas->id;
            }
        }

        if (!$fakultasId) {
            return null; // Skip if no valid fakultas
        }

        // Avoid duplicates within the same fakultas
        $existing = Prodi::where('nama_prodi', $row['nama_prodi'])->where('fakultas_id', $fakultasId)->first();
        if ($existing) {
            return null;
        }

        return new Prodi([
            'nama_prodi' => $row['nama_prodi'],
            'fakultas_id' => $fakultasId,
        ]);
    }
}

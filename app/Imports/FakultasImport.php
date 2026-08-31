<?php

namespace App\Imports;

use App\Models\Fakultas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FakultasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['nama_fakultas'])) {
            return null;
        }

        // Avoid duplicates
        $existing = Fakultas::where('nama_fakultas', $row['nama_fakultas'])->first();
        if ($existing) {
            return null;
        }

        return new Fakultas([
            'nama_fakultas' => $row['nama_fakultas'],
        ]);
    }
}

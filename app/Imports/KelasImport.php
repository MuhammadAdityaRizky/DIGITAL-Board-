<?php

namespace App\Imports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelasImport implements ToModel, WithHeadingRow
{
    public function model(array $row): \Illuminate\Database\Eloquent\Model|array|null
    {
        if (!isset($row['nama_kelas'])) {
            return null;
        }

        // Avoid duplicates
        $existing = Kelas::where('nama_kelas', $row['nama_kelas'])->first();
        if ($existing) {
            return null;
        }

        return new Kelas([
            'nama_kelas' => $row['nama_kelas'],
        ]);
    }
}

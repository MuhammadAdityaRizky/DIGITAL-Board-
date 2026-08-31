<?php

namespace App\Imports;

use App\Models\Laboratorium;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LaboratoriumImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['nama_lab'])) {
            return null;
        }

        // Avoid duplicates
        $existing = Laboratorium::where('nama_lab', $row['nama_lab'])->first();
        if ($existing) {
            return null;
        }

        return new Laboratorium([
            'nama_lab' => $row['nama_lab'],
            'lokasi' => $row['lokasi'] ?? '-',
            'kapasitas' => $row['kapasitas'] ?? 30,
        ]);
    }
}

<?php

namespace App\Imports;

use App\Models\MataKuliah;
use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MataKuliahImport implements ToModel, WithHeadingRow
{
    public function model(array $row): \Illuminate\Database\Eloquent\Model|array|null
    {
        $namaMk = $row['nama_mk'] ?? $row['nama_mata_kuliah'] ?? $row['mata_kuliah'] ?? null;
        if (!$namaMk) {
            return null;
        }

        $kodeMk = $row['kode_mk'] ?? $row['kode'] ?? null;
        $sks = isset($row['sks']) && is_numeric($row['sks']) ? (int)$row['sks'] : 3;

        // Try to match prodi by ID or Name
        $prodiId = null;
        if (isset($row['id_prodi']) && is_numeric($row['id_prodi'])) {
            $prodiId = $row['id_prodi'];
        } elseif (isset($row['nama_prodi']) || isset($row['prodi'])) {
            $namaProdi = $row['nama_prodi'] ?? $row['prodi'];
            $prodi = Prodi::where('nama_prodi', 'like', '%' . trim($namaProdi) . '%')->first();
            if ($prodi) {
                $prodiId = $prodi->id;
            }
        }

        // Avoid duplicates
        $query = MataKuliah::where('nama_mk', trim($namaMk));
        if ($kodeMk) {
            $query->orWhere('kode_mk', trim($kodeMk));
        }
        $existing = $query->first();

        if ($existing) {
            return null;
        }

        return new MataKuliah([
            'kode_mk' => $kodeMk ? trim($kodeMk) : null,
            'nama_mk' => trim($namaMk),
            'sks' => $sks,
            'id_prodi' => $prodiId,
        ]);
    }
}

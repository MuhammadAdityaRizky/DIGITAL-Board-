<?php

namespace App\Imports;

use App\Models\Fakultas;
use App\Models\Laboratorium;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LaboratoriumImport implements ToModel, WithHeadingRow
{
    protected ?int $defaultFakultasId;

    public function __construct(?int $defaultFakultasId = null)
    {
        $this->defaultFakultasId = $defaultFakultasId;
    }

    public function model(array $row): \Illuminate\Database\Eloquent\Model|array|null
    {
        if (!isset($row['nama_lab'])) {
            return null;
        }

        $fakultasId = $this->defaultFakultasId;
        if (!$fakultasId && !empty($row['fakultas'])) {
            $fak = Fakultas::where('nama_fakultas', 'like', '%' . trim($row['fakultas']) . '%')->first();
            if ($fak) {
                $fakultasId = $fak->id;
            }
        } elseif (!$fakultasId && !empty($row['fakultas_id'])) {
            $fakultasId = (int)$row['fakultas_id'];
        }

        if (!$fakultasId) {
            $fakultasId = Fakultas::first()?->id;
        }

        // Avoid duplicates
        $existing = Laboratorium::where('nama_lab', $row['nama_lab'])->first();
        if ($existing) {
            $updates = [];
            if ($fakultasId && !$existing->fakultas_id) {
                $updates['fakultas_id'] = $fakultasId;
            }
            $laboranVal = $row['nama_laboran'] ?? ($row['laboran'] ?? null);
            if (!empty($laboranVal)) {
                $updates['nama_laboran'] = trim($laboranVal);
            }
            if (!empty($updates)) {
                $existing->update($updates);
            }
            return null;
        }

        return new Laboratorium([
            'fakultas_id' => $fakultasId,
            'nama_lab' => $row['nama_lab'],
            'lokasi' => $row['lokasi'] ?? '-',
            'kapasitas' => $row['kapasitas'] ?? 30,
            'nama_laboran' => !empty($row['nama_laboran'] ?? ($row['laboran'] ?? null)) ? trim($row['nama_laboran'] ?? $row['laboran']) : null,
        ]);
    }
}

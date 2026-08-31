<?php

namespace App\Imports;

use App\Models\Agenda;
use App\Models\Dosen;
use App\Models\Laboratorium;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AgendaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['mata_kuliah'])) {
            return null;
        }

        // Try to match Dosen by NIP or Name
        $dosenId = null;
        if (isset($row['nip_dosen'])) {
            $dosen = Dosen::where('nip', $row['nip_dosen'])->first();
            if ($dosen) $dosenId = $dosen->id;
        }
        
        if (!$dosenId && isset($row['nama_dosen'])) {
            $dosen = Dosen::where('nama', 'like', '%' . $row['nama_dosen'] . '%')->first();
            if ($dosen) $dosenId = $dosen->id;
        }

        // Try to match Lab by Name
        $labId = null;
        if (isset($row['nama_lab'])) {
            $lab = Laboratorium::where('nama_lab', 'like', '%' . $row['nama_lab'] . '%')->first();
            if ($lab) $labId = $lab->id;
        }

        // Fallback to IDs if provided directly
        $dosenId = $dosenId ?? ($row['dosen_id'] ?? null);
        $labId = $labId ?? ($row['lab_id'] ?? null);

        if (!$dosenId || !$labId) {
            return null; // Skip if mandatory foreign keys are missing
        }

        // Parse time and date safely
        // Kadang excel formatnya aneh, but we assume string/Y-m-d H:i for now
        $tanggal = isset($row['tanggal']) ? date('Y-m-d', strtotime($row['tanggal'])) : date('Y-m-d');
        $jam_mulai = isset($row['jam_mulai']) ? date('H:i:s', strtotime($row['jam_mulai'])) : '08:00:00';
        $jam_selesai = isset($row['jam_selesai']) ? date('H:i:s', strtotime($row['jam_selesai'])) : '10:00:00';

        return new Agenda([
            'dosen_id' => $dosenId,
            'lab_id' => $labId,
            'mata_kuliah' => $row['mata_kuliah'],
            'kelas' => $row['kelas'] ?? null,
            'semester' => $row['semester'] ?? null,
            'jurusan' => $row['jurusan'] ?? null,
            'fakultas' => $row['fakultas'] ?? null,
            'tanggal' => $tanggal,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
            'status_agenda' => $row['status_agenda'] ?? 'Akan Datang',
            'catatan' => $row['catatan'] ?? null,
        ]);
    }
}

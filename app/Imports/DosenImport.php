<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Prodi;
use App\Models\Fakultas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;

class DosenImport implements ToCollection
{
    use Importable;

    protected ?int $defaultFakultasId;
    public int $importedCount = 0;

    public function __construct(?int $defaultFakultasId = null)
    {
        $this->defaultFakultasId = $defaultFakultasId;
    }

    public function collection(Collection $rows): void
    {
        $rowsArray = $rows->toArray();
        if (empty($rowsArray)) {
            return;
        }

        $headerRowIndex = null;
        $headers = [];

        // Scan for Header Row dynamically across rows 0 to 15
        foreach ($rowsArray as $idx => $row) {
            if ($idx > 15) break;
            foreach ($row as $cell) {
                $cellVal = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '', (string)$cell)));
                if (in_array($cellVal, ['nip', 'nipd', 'nik', 'kodedosen', 'nipdosen', 'nodosen'])) {
                    $headerRowIndex = $idx;
                    $headers = $row;
                    break 2;
                }
            }
        }

        if ($headerRowIndex === null) {
            $headerRowIndex = 0;
            $headers = $rowsArray[0] ?? [];
        }

        $colMap = [];
        foreach ($headers as $colIdx => $headerName) {
            $clean = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '', (string)$headerName)));
            if (!empty($clean)) {
                $colMap[$colIdx] = $clean;
            }
        }

        $dataRows = array_slice($rowsArray, $headerRowIndex + 1);

        foreach ($dataRows as $row) {
            $rowAssoc = [];
            foreach ($colMap as $cIdx => $keyName) {
                $rowAssoc[$keyName] = $row[$cIdx] ?? null;
            }

            // 1. Resolve NIP
            $nipRaw = null;
            foreach (['nip', 'nipd', 'nik', 'kodedosen', 'nipdosen', 'username', 'no'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $nipRaw = trim((string)$rowAssoc[$k]);
                    break;
                }
            }

            if (!$nipRaw && isset($row[1]) && !empty(trim((string)$row[1]))) {
                $nipRaw = trim((string)$row[1]);
            }

            if (!$nipRaw || in_array(strtolower($nipRaw), ['nip', 'nik', 'username', 'no', 'kodedosen', 'no.'])) {
                continue;
            }
            $nip = preg_replace('/[^0-9a-zA-Z]/', '', $nipRaw);
            if (empty($nip)) {
                continue;
            }

            // 2. Resolve Nama
            $namaDosen = null;
            foreach (['namadosen', 'namalengkap', 'nama', 'namadosenpengampu', 'dosen'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $namaDosen = trim((string)$rowAssoc[$k]);
                    break;
                }
            }
            if (!$namaDosen && isset($row[2]) && !empty(trim((string)$row[2]))) {
                $namaDosen = trim((string)$row[2]);
            }
            if (!$namaDosen) {
                $namaDosen = 'Dosen Baru';
            }

            // 3. Resolve Fakultas & Prodi
            $prodiName = null;
            foreach (['programstudi', 'prodi', 'jurusan', 'namaprodi', 'namajurusan', 'progstudi'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $prodiName = trim((string)$rowAssoc[$k]);
                    break;
                }
            }

            $id_prodi = null;
            $id_fakultas = $this->defaultFakultasId;

            if (!empty($prodiName)) {
                $prodiQuery = Prodi::where('nama_prodi', 'like', '%' . trim($prodiName) . '%');
                if ($this->defaultFakultasId) {
                    $prodiQuery->where('fakultas_id', $this->defaultFakultasId);
                }
                $prodi = $prodiQuery->first();
                if ($prodi) {
                    $id_prodi = $prodi->id;
                    $id_fakultas = $prodi->fakultas_id ?? $id_fakultas;
                }
            }

            $fakultasName = null;
            foreach (['fakultas', 'namafakultas', 'fakultasnaungan'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $fakultasName = trim((string)$rowAssoc[$k]);
                    break;
                }
            }
            if (empty($id_fakultas) && !empty($fakultasName)) {
                $fak = Fakultas::where('nama_fakultas', 'like', '%' . trim($fakultasName) . '%')->first();
                if ($fak) {
                    $id_fakultas = $fak->id;
                }
            }

            if (!$id_fakultas) {
                $id_fakultas = Fakultas::first()?->id;
            }

            // 4. Resolve Status, Jabatan, Kompetensi
            $statusDosen = null;
            foreach (['status', 'statusdosen', 'statustetap'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $statusDosen = trim((string)$rowAssoc[$k]);
                    break;
                }
            }
            if (!$statusDosen) $statusDosen = 'Tetap';

            $jabatan = null;
            foreach (['jabatan', 'jabatandosen', 'jabatanfungsional'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $jabatan = trim((string)$rowAssoc[$k]);
                    break;
                }
            }

            $kompetensi = null;
            foreach (['kompetensi', 'bidangkeahlian', 'keahlian', 'spesialisasi'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $kompetensi = trim((string)$rowAssoc[$k]);
                    break;
                }
            }

            // 5. User Account (Create or Update)
            $user = User::where('username', $nip)->first();
            if (!$user) {
                $user = User::create([
                    'username' => $nip,
                    'password' => Hash::make($nip),
                    'role' => 'dosen',
                    'status' => 'aktif',
                    'fakultas_id' => $id_fakultas,
                ]);
            } else {
                $user->update([
                    'role' => 'dosen',
                    'status' => 'aktif',
                    'fakultas_id' => $id_fakultas ?: $user->fakultas_id,
                ]);
            }

            // 6. Upsert Dosen record
            $existingDosen = Dosen::where('nip', $nip)->orWhere('user_id', $user->id)->first();
            if ($existingDosen) {
                $existingDosen->update([
                    'user_id' => $user->id,
                    'nip' => $nip,
                    'nama' => $namaDosen,
                    'status' => $statusDosen,
                    'jabatan' => $jabatan ?: $existingDosen->jabatan,
                    'id_fakultas' => $id_fakultas,
                    'id_prodi' => $id_prodi,
                    'kompetensi' => $kompetensi ?: $existingDosen->kompetensi,
                ]);
            } else {
                Dosen::create([
                    'user_id' => $user->id,
                    'nip' => $nip,
                    'nama' => $namaDosen,
                    'status' => $statusDosen,
                    'jabatan' => $jabatan,
                    'id_fakultas' => $id_fakultas,
                    'id_prodi' => $id_prodi,
                    'kompetensi' => $kompetensi,
                ]);
            }

            $this->importedCount++;
        }
    }
}

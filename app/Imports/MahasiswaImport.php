<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;

class MahasiswaImport implements ToCollection
{
    use Importable;

    public $importId;
    public ?int $defaultFakultasId;
    public int $importedCount = 0;

    public function __construct($importId = null, ?int $defaultFakultasId = null)
    {
        $this->importId = $importId;
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

        // 1. Scan for Header Row dynamically across rows 0 to 15
        foreach ($rowsArray as $idx => $row) {
            if ($idx > 15) break;
            foreach ($row as $cell) {
                $cellVal = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '', (string)$cell)));
                if (in_array($cellVal, ['nim', 'npm', 'noinduk', 'nimmahasiswa', 'nonim', 'nimnpm'])) {
                    $headerRowIndex = $idx;
                    $headers = $row;
                    break 2;
                }
            }
        }

        // If no explicit header row found, assume Row 0 is header
        if ($headerRowIndex === null) {
            $headerRowIndex = 0;
            $headers = $rowsArray[0] ?? [];
        }

        // Map column index -> clean key name
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

            // 1. Resolve NIM
            $nimRaw = null;
            foreach (['nim', 'npm', 'noinduk', 'nimmahasiswa', 'nonim', 'nimnpm', 'username', 'no'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $nimRaw = trim((string)$rowAssoc[$k]);
                    break;
                }
            }

            if (!$nimRaw && isset($row[1]) && !empty(trim((string)$row[1]))) {
                $nimRaw = trim((string)$row[1]);
            }

            if (!$nimRaw || in_array(strtolower($nimRaw), ['nim', 'npm', 'no', 'username', 'no_induk', 'nim_mahasiswa', 'nim/npm', 'no.'])) {
                continue;
            }
            $nim = preg_replace('/[^0-9a-zA-Z]/', '', $nimRaw);
            if (empty($nim)) {
                continue;
            }

            // 2. Resolve Nama
            $namaMhs = null;
            foreach (['namamahasiswa', 'namalengkap', 'nama', 'namamhs', 'namasiswa'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $namaMhs = trim((string)$rowAssoc[$k]);
                    break;
                }
            }
            if (!$namaMhs && isset($row[2]) && !empty(trim((string)$row[2]))) {
                $namaMhs = trim((string)$row[2]);
            }
            if (!$namaMhs) {
                $namaMhs = 'Mahasiswa Baru';
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

            if (!$id_prodi && $id_fakultas) {
                $id_prodi = Prodi::where('fakultas_id', $id_fakultas)->first()?->id ?? Prodi::first()?->id;
            }

            // 4. Resolve Semester & Angkatan
            $semesterRaw = null;
            foreach (['semester', 'sem', 'smt', 'semesteraktif'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $semesterRaw = trim((string)$rowAssoc[$k]);
                    break;
                }
            }

            $semester = 1;
            if (!empty($semesterRaw)) {
                preg_match('/\d+/', $semesterRaw, $matches);
                if (isset($matches[0])) {
                    $semester = (int)$matches[0];
                }
            }

            $angkatanRaw = null;
            foreach (['angkatan', 'tahunangkatan', 'tahunmasuk', 'thnangkatan'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $angkatanRaw = trim((string)$rowAssoc[$k]);
                    break;
                }
            }

            if ($semester === 1 && !empty($angkatanRaw)) {
                $angkatan = (int) $angkatanRaw;
                $currentYear = (int) date('Y');
                $currentMonth = (int) date('m');
                $calcSemester = (($currentYear - $angkatan) * 2) + ($currentMonth >= 8 ? 1 : 0);
                if ($calcSemester >= 1) {
                    $semester = $calcSemester;
                }
            }

            // 5. Resolve Program Kuliah & Kelas
            $rawKelasInput = null;
            foreach (['kelas', 'kelasmahasiswa', 'rombel', 'kelasmhs'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $rawKelasInput = trim((string)$rowAssoc[$k]);
                    break;
                }
            }

            $programKuliahInput = null;
            foreach (['programkuliah', 'program'] as $k) {
                if (!empty($rowAssoc[$k])) {
                    $programKuliahInput = trim((string)$rowAssoc[$k]);
                    break;
                }
            }

            $programKuliah = 'Reguler';
            if (!empty($programKuliahInput)) {
                $pk = strtoupper(trim($programKuliahInput));
                if (str_contains($pk, 'KARYAWAN') || str_contains($pk, 'KAR')) {
                    $programKuliah = 'Karyawan';
                }
            } elseif (!empty($rawKelasInput)) {
                $rawK = strtoupper(trim($rawKelasInput));
                if (str_contains($rawK, 'KARYAWAN') || str_contains($rawK, 'KAR')) {
                    $programKuliah = 'Karyawan';
                }
            }

            $kelasAsli = 'REG';
            if ($programKuliah === 'Karyawan') {
                $kelasAsli = 'KAR';
            } elseif (!empty($rawKelasInput)) {
                $rawK = strtoupper(trim($rawKelasInput));
                if (str_contains($rawK, 'REG A') || str_ends_with($rawK, 'REG A') || str_ends_with($rawK, 'A')) {
                    $kelasAsli = 'Reg A';
                } elseif (str_contains($rawK, 'REG B') || str_ends_with($rawK, 'REG B') || str_ends_with($rawK, 'B')) {
                    $kelasAsli = 'Reg B';
                } elseif (str_contains($rawK, 'REG C') || str_ends_with($rawK, 'REG C') || str_ends_with($rawK, 'C')) {
                    $kelasAsli = 'Reg C';
                } elseif (str_contains($rawK, 'KAR') || str_contains($rawK, 'KARYAWAN')) {
                    $kelasAsli = 'KAR';
                } else {
                    $cleaned = trim(preg_replace('/^(REGULER|KARYAWAN|REG|KAR|\d+)\s*/i', '', trim($rawKelasInput)));
                    $kelasAsli = !empty($cleaned) ? $cleaned : trim($rawKelasInput);
                }
            }

            // 6. User Account (Create or Update)
            $user = User::where('username', $nim)->first();
            if (!$user) {
                $user = User::create([
                    'username' => $nim,
                    'password' => Hash::make($nim),
                    'role' => 'mahasiswa',
                    'status' => 'aktif',
                    'fakultas_id' => $id_fakultas,
                ]);
            } else {
                $user->update([
                    'role' => 'mahasiswa',
                    'status' => 'aktif',
                    'fakultas_id' => $id_fakultas ?: $user->fakultas_id,
                ]);
            }

            // 7. Upsert Mahasiswa record
            $existingMahasiswa = Mahasiswa::where('nim', $nim)->orWhere('user_id', $user->id)->first();
            if ($existingMahasiswa) {
                $existingMahasiswa->update([
                    'user_id' => $user->id,
                    'nim' => $nim,
                    'nama_lengkap' => $namaMhs,
                    'id_fakultas' => $id_fakultas,
                    'id_prodi' => $id_prodi,
                    'program_kuliah' => $programKuliah,
                    'kelas' => $kelasAsli,
                    'semester' => $semester,
                    'status' => 'aktif',
                ]);
            } else {
                Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $nim,
                    'nama_lengkap' => $namaMhs,
                    'id_fakultas' => $id_fakultas,
                    'id_prodi' => $id_prodi,
                    'program_kuliah' => $programKuliah,
                    'kelas' => $kelasAsli,
                    'semester' => $semester,
                    'status' => 'aktif',
                ]);
            }

            $this->importedCount++;
        }
    }
}

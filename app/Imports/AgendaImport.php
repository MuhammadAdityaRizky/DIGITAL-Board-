<?php

namespace App\Imports;

use App\Models\Agenda;
use App\Models\Dosen;
use App\Models\Laboratorium;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AgendaImport implements ToCollection
{
    public int $importedCount = 0;

    public function collection(Collection $rows): void
    {
        if ($rows->isEmpty()) {
            return;
        }

        // 1. Scan top 15 rows for document metadata (Dosen, Mata Kuliah, Prodi, Semester, Kelas, Lab)
        $metaDosenMengajar = null;
        $metaDosenPengampu = null;
        $metaMataKuliah = null;
        $metaProdi = null;
        $metaFakultas = null;
        $metaSemester = null;
        $metaKelas = null;

        $topRows = $rows->slice(0, 15);
        foreach ($topRows as $r) {
            $rowStr = implode(' ', array_filter(array_map('strval', $r->toArray())));
            
            // Check Dosen
            if (preg_match('/Dosen\s*(?:Pengampu)?\s*:\s*([^:\n\r]+)/i', $rowStr, $m)) {
                $dosenNames = explode('/', $m[1]);
                if (isset($dosenNames[0])) $metaDosenMengajar = trim($dosenNames[0]);
                if (isset($dosenNames[1])) $metaDosenPengampu = trim($dosenNames[1]);
            }

            // Check Mata Kuliah
            if (preg_match('/Mata\s*Kuliah\s*:\s*([^:\n\r]+)/i', $rowStr, $m)) {
                $metaMataKuliah = trim($m[1]);
            }

            // Check Prodi
            if (preg_match('/Program\s*Studi\s*:\s*([^:\n\r]+)/i', $rowStr, $m)) {
                $metaProdi = trim($m[1]);
            }

            // Check Semester / Kelas
            if (preg_match('/Semester\s*\/\s*Kelas\s*:\s*([^:\n\r]+)/i', $rowStr, $m)) {
                $parts = explode('/', $m[1]);
                if (isset($parts[0])) $metaSemester = trim($parts[0]);
                if (isset($parts[1])) $metaKelas = trim($parts[1]);
            }
        }

        // Resolve Default Dosen & Lab IDs
        $defaultDosenId = null;
        if ($metaDosenMengajar) {
            $d = Dosen::where('nama', 'like', '%' . $metaDosenMengajar . '%')->first();
            if ($d) $defaultDosenId = $d->id;
        }
        if (!$defaultDosenId) {
            $defaultDosenId = Dosen::first()?->id;
        }

        $defaultDosenPengampuId = null;
        if ($metaDosenPengampu) {
            $dp = Dosen::where('nama', 'like', '%' . $metaDosenPengampu . '%')->first();
            if ($dp) $defaultDosenPengampuId = $dp->id;
        }

        $defaultLabId = Laboratorium::first()?->id;

        // 2. Identify Column Indexes or Heading Row
        $headerRowIndex = null;
        $colIndexMap = [];

        foreach ($rows as $idx => $r) {
            $arr = array_map('strval', $r->toArray());
            foreach ($arr as $colIdx => $val) {
                $valClean = strtolower(trim($val));
                if (in_array($valClean, ['materi', 'materi praktikum', 'mata kuliah', 'matakuliah', 'judul', 'judul agenda', 'course', 'subject'])) {
                    $headerRowIndex = $idx;
                    $colIndexMap['materi'] = $colIdx;
                } elseif (in_array($valClean, ['tanggal', 'hari / tanggal', 'hari/tanggal', 'tgl', 'date'])) {
                    $colIndexMap['tanggal'] = $colIdx;
                } elseif (in_array($valClean, ['waktu', 'jam', 'waktu / jam', 'jam_mulai', 'waktu_masuk', 'time'])) {
                    $colIndexMap['waktu'] = $colIdx;
                } elseif (in_array($valClean, ['dosen', 'nama dosen', 'dosen mengajar', 'pengajar'])) {
                    $colIndexMap['dosen'] = $colIdx;
                } elseif (in_array($valClean, ['dosen pengampu', 'pengampu'])) {
                    $colIndexMap['dosen_pengampu'] = $colIdx;
                } elseif (in_array($valClean, ['lab', 'nama lab', 'laboratorium', 'ruang', 'ruangan'])) {
                    $colIndexMap['lab'] = $colIdx;
                } elseif (in_array($valClean, ['kelas'])) {
                    $colIndexMap['kelas'] = $colIdx;
                } elseif (in_array($valClean, ['semester'])) {
                    $colIndexMap['semester'] = $colIdx;
                }
            }
            if ($headerRowIndex !== null) {
                break;
            }
        }

        // 3. Process Data Rows
        $startIdx = ($headerRowIndex !== null) ? $headerRowIndex + 1 : 0;

        for ($i = $startIdx; $i < count($rows); $i++) {
            $rowArray = array_map('strval', $rows[$i]->toArray());
            if (empty(array_filter($rowArray))) {
                continue; // Skip blank rows
            }

            // Extract values using mapped columns or heuristic fallback
            $valMateri = isset($colIndexMap['materi']) ? ($rowArray[$colIndexMap['materi']] ?? null) : null;
            $valTanggal = isset($colIndexMap['tanggal']) ? ($rowArray[$colIndexMap['tanggal']] ?? null) : null;
            $valWaktu = isset($colIndexMap['waktu']) ? ($rowArray[$colIndexMap['waktu']] ?? null) : null;
            $valDosen = isset($colIndexMap['dosen']) ? ($rowArray[$colIndexMap['dosen']] ?? null) : null;
            $valPengampu = isset($colIndexMap['dosen_pengampu']) ? ($rowArray[$colIndexMap['dosen_pengampu']] ?? null) : null;
            $valLab = isset($colIndexMap['lab']) ? ($rowArray[$colIndexMap['lab']] ?? null) : null;

            // Heuristic fallbacks if column mapping was not explicitly found
            if (!$valMateri || !$valTanggal) {
                foreach ($rowArray as $cellVal) {
                    $cellValTrim = trim($cellVal);
                    if (!$valTanggal && (preg_match('/\d{1,2}\s+[a-zA-Z]+\s+\d{4}/', $cellValTrim) || preg_match('/\d{4}-\d{2}-\d{2}/', $cellValTrim) || is_numeric($cellValTrim) && (float)$cellValTrim > 40000)) {
                        $valTanggal = $cellValTrim;
                    } elseif (!$valWaktu && preg_match('/\d{1,2}[\.:]\d{2}/', $cellValTrim)) {
                        $valWaktu = $cellValTrim;
                    } elseif (!$valMateri && strlen($cellValTrim) > 3 && !is_numeric($cellValTrim) && !in_array(strtolower($cellValTrim), ['ada', 'tidak', 'ya', 'tidak ada', 'paraf'])) {
                        $valMateri = $cellValTrim;
                    }
                }
            }

            if (!$valMateri && !$valTanggal && !$valWaktu) {
                continue; // Skip invalid row
            }

            // Determine final Mata Kuliah title
            $finalMataKuliah = $metaMataKuliah;
            if ($valMateri) {
                if ($metaMataKuliah && stripos($valMateri, $metaMataKuliah) === false) {
                    $finalMataKuliah = $metaMataKuliah . ' (' . $valMateri . ')';
                } else {
                    $finalMataKuliah = $valMateri;
                }
            }

            if (!$finalMataKuliah) {
                $finalMataKuliah = 'Agenda Mengajar Praktikum';
            }

            // Parse Date & Time
            $tanggal = $this->parseIndonesianDate($valTanggal);
            [$jamMulai, $jamSelesai] = $this->parseTimes($valWaktu);

            // Match Dosen
            $dosenId = $defaultDosenId;
            if ($valDosen) {
                $d = Dosen::where('nama', 'like', '%' . trim($valDosen) . '%')->orWhere('nip', trim($valDosen))->first();
                if ($d) $dosenId = $d->id;
            }

            // Match Dosen Pengampu
            $dosenPengampuId = $defaultDosenPengampuId;
            if ($valPengampu) {
                $dp = Dosen::where('nama', 'like', '%' . trim($valPengampu) . '%')->orWhere('nip', trim($valPengampu))->first();
                if ($dp) $dosenPengampuId = $dp->id;
            }

            // Match Lab
            $labId = $defaultLabId;
            if ($valLab) {
                $l = Laboratorium::where('nama_lab', 'like', '%' . trim($valLab) . '%')->first();
                if ($l) $labId = $l->id;
            }

            if (!$dosenId || !$labId) {
                continue;
            }

            Agenda::create([
                'dosen_id' => $dosenId,
                'dosen_pengampu_id' => $dosenPengampuId,
                'lab_id' => $labId,
                'mata_kuliah' => $finalMataKuliah,
                'program_kuliah' => 'Reguler',
                'jenis_pertemuan' => 'Praktikum',
                'kelas' => $metaKelas,
                'semester' => $metaSemester,
                'jurusan' => $metaProdi ?? 'Sistem Informasi',
                'fakultas' => $metaFakultas ?? 'Fakultas Teknik',
                'tanggal' => $tanggal,
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'status_agenda' => 'Akan Datang',
                'catatan' => $valMateri,
            ]);

            $this->importedCount++;
        }
    }

    private function parseIndonesianDate($dateStr): string
    {
        if (!$dateStr) {
            return date('Y-m-d');
        }

        if (is_numeric($dateStr) && (float)$dateStr > 30000) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateStr)->format('Y-m-d');
            } catch (\Exception $e) {
                // Ignore
            }
        }

        $dateStr = (string)$dateStr;
        // Strip day names (Senin, Selasa, etc.)
        $dateStr = preg_replace('/^[a-zA-Z]+\s*[\/,\-]*\s*/', '', trim($dateStr));
        
        $months = [
            'januari' => '01', 'jan' => '01',
            'februari' => '02', 'feb' => '02',
            'maret' => '03', 'mar' => '03',
            'april' => '04', 'apr' => '04',
            'mei' => '05', 'may' => '05',
            'juni' => '06', 'jun' => '06',
            'juli' => '07', 'jul' => '07',
            'agustus' => '08', 'agu' => '08', 'ags' => '08',
            'september' => '09', 'sep' => '09',
            'oktober' => '10', 'okt' => '10',
            'november' => '11', 'nov' => '11',
            'desember' => '12', 'des' => '12',
        ];

        foreach ($months as $name => $num) {
            if (stripos($dateStr, $name) !== false) {
                $dateStr = preg_replace('/' . $name . '/i', $num, $dateStr);
                break;
            }
        }

        $time = strtotime($dateStr);
        if ($time && $time > 0) {
            return date('Y-m-d', $time);
        }

        return date('Y-m-d');
    }

    private function parseTimes($timeStr): array
    {
        if (!$timeStr) {
            return ['08:00:00', '10:00:00'];
        }

        $timeStr = (string)$timeStr;
        // Replace dots with colons in time formats e.g. 14.00 -> 14:00
        $clean = preg_replace('/(\d{1,2})\.(\d{2})/', '$1:$2', $timeStr);
        
        $parts = preg_split('/[\-\–\—]|s\/d|to/iu', $clean);
        
        $jamMulai = '08:00:00';
        $jamSelesai = '10:00:00';

        if (isset($parts[0])) {
            preg_match('/(\d{1,2}:\d{2})/', $parts[0], $m);
            if (isset($m[1])) {
                $jamMulai = date('H:i:s', strtotime($m[1]));
            }
        }

        if (isset($parts[1])) {
            preg_match('/(\d{1,2}:\d{2})/', $parts[1], $m);
            if (isset($m[1])) {
                $jamSelesai = date('H:i:s', strtotime($m[1]));
            }
        }

        return [$jamMulai, $jamSelesai];
    }
}

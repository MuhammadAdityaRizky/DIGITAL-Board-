<?php

namespace App\Imports;

use App\Models\Laboratorium;
use App\Models\JadwalPenggunaanLab;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class JadwalLabImport
{
    public int $importedCount = 0;
    public ?string $detectedLabName = null;
    public ?string $detectedTahunAkademik = null;
    public ?int $targetLabId = null;

    protected $dosens;
    protected $prodis;
    protected $mataKuliahs;

    public function __construct()
    {
        $this->dosens = Dosen::all();
        $this->prodis = Prodi::all();
        $this->mataKuliahs = MataKuliah::all();
    }

    /**
     * Import matrix schedule from an Excel file
     *
     * @param string|\Illuminate\Http\UploadedFile $file
     * @param int|null $explicitLabId
     * @param string|null $explicitTahunAkademik
     * @param string $mode 'replace' or 'append'
     * @param User|null $user Logged in user for authorization check
     * @return array
     * @throws \Exception
     */
    public function import($file, ?int $explicitLabId = null, ?string $explicitTahunAkademik = null, string $mode = 'replace', ?User $user = null): array
    {
        $filePath = is_string($file) ? $file : $file->getRealPath();
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Detect Lab from Header if not explicitly provided
        $lab = null;
        if ($explicitLabId) {
            $lab = Laboratorium::find($explicitLabId);
        }

        if (!$lab) {
            // Check top 6 rows for lab name
            for ($r = 1; $r <= 6; $r++) {
                for ($c = 1; $c <= 7; $c++) {
                    $val = (string)$sheet->getCell([$c, $r])->getValue();
                    if (preg_match('/(?:Jadwal\s+Penggunaan\s+)?(Lab(?:oratorium)?\s*[0-9A-Za-z\s]+)/i', $val, $m)) {
                        $candidate = trim($m[1]);
                        $found = Laboratorium::where('nama_lab', 'LIKE', '%' . $candidate . '%')->first();
                        if ($found) {
                            $lab = $found;
                            break 2;
                        }
                    }
                    if (preg_match('/(?:Lab|Laboratorium)\s*([0-9]+)/i', $val, $m)) {
                        $num = $m[1];
                        $found = Laboratorium::where('nama_lab', 'LIKE', '%' . $num . '%')->first();
                        if ($found) {
                            $lab = $found;
                            break 2;
                        }
                    }
                }
            }
        }

        if (!$lab) {
            $lab = Laboratorium::first();
        }

        if (!$lab) {
            throw new \Exception("Data Laboratorium tidak ditemukan di sistem. Harap tambahkan laboratorium terlebih dahulu.");
        }

        $this->targetLabId = $lab->id;
        $this->detectedLabName = $lab->nama_lab;

        // Authorization check if user is Admin Fakultas
        if ($user && $user->isAdminFakultas()) {
            if (!$user->canManageLab($lab)) {
                $userFakultasName = $user->fakultas->nama_fakultas ?? 'Fakultas Anda';
                throw new \Exception("Akses Ditolak: Anda adalah Admin {$userFakultasName} dan tidak memiliki izin untuk mengimpor jadwal ke {$lab->nama_lab}.");
            }
        }

        // 2. Detect Tahun Akademik
        $tahunAkademik = $explicitTahunAkademik;
        if (!$tahunAkademik) {
            // Check F3 or top rows
            $f3 = trim((string)$sheet->getCell('F3')->getValue());
            if (preg_match('/\d{4}\/\d{4}\s+(?:Ganjil|Genap)/i', $f3)) {
                $tahunAkademik = $f3;
            } else {
                for ($r = 1; $r <= 6; $r++) {
                    for ($c = 1; $c <= 7; $c++) {
                        $val = (string)$sheet->getCell([$c, $r])->getValue();
                        if (preg_match('/\d{4}\/\d{4}\s+(?:Ganjil|Genap)/i', $val, $m)) {
                            $tahunAkademik = $m[0];
                            break 2;
                        }
                    }
                }
            }
        }

        if (!$tahunAkademik) {
            $tahunAkademik = '2026/2027 Ganjil';
        }
        $this->detectedTahunAkademik = $tahunAkademik;

        // 3. Map Days in Row 6 (Columns B to G)
        $dayColMap = [];
        $validDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        for ($c = 2; $c <= 7; $c++) {
            $val = trim((string)$sheet->getCell([$c, 6])->getValue());
            $normalizedDay = $this->normalizeDayName($val);
            if ($normalizedDay) {
                $dayColMap[$c] = $normalizedDay;
            } else {
                // Fallback by column position: B=Senin, C=Selasa, D=Rabu, E=Kamis, F=Jumat, G=Sabtu
                $dayColMap[$c] = $validDays[$c - 2] ?? 'Senin';
            }
        }

        // 4. Map Time Slots in Column A (Rows 7 to 20)
        $timeSlotMap = [];
        for ($r = 7; $r <= 20; $r++) {
            $val = trim((string)$sheet->getCell('A' . $r)->getValue());
            $times = $this->parseTimeSlot($val, $r);
            $timeSlotMap[$r] = $times;
        }

        // 5. Parse Schedule Matrix Cells
        $recordsToInsert = [];

        foreach ($dayColMap as $colIndex => $dayName) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);

            for ($r = 7; $r <= 20; $r++) {
                $coord = $colLetter . $r;
                $cell = $sheet->getCell($coord);

                // If in merge range and NOT the value cell (top-left), skip it
                if ($cell->isInMergeRange() && !$cell->isMergeRangeValueCell()) {
                    continue;
                }

                $cellVal = trim((string)$cell->getValue());
                if ($cellVal === '') {
                    continue;
                }

                // Determine end row if cell is merged
                $endRow = $r;
                if ($cell->isInMergeRange()) {
                    $range = $cell->getMergeRange();
                    [$tl, $br] = explode(':', $range);
                    $endRow = (int) preg_replace('/[A-Z]/', '', $br);
                    if ($endRow < $r || $endRow > 20) {
                        $endRow = $r;
                    }
                }

                // Get jam_mulai & jam_selesai
                $jamMulai = $timeSlotMap[$r]['start'] ?? '08:00:00';
                $jamSelesai = $timeSlotMap[$endRow]['end'] ?? '10:00:00';

                // Get Cell Fill Color for Prodi detection
                $fillColor = $cell->getStyle()->getFill()->getStartColor()->getARGB();

                // Parse cell contents
                $parsed = $this->parseCellText($cellVal, $fillColor);

                $recordsToInsert[] = [
                    'lab_id' => $lab->id,
                    'dosen_id' => $parsed['dosen_id'],
                    'dosen_pengampu_id' => null,
                    'id_prodi' => $parsed['id_prodi'],
                    'mata_kuliah' => $parsed['mata_kuliah'],
                    'hari' => $dayName,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'kelas' => $parsed['kelas'],
                    'semester' => $parsed['semester'],
                    'program_kuliah' => $parsed['program_kuliah'],
                    'tahun_akademik' => $tahunAkademik,
                    'is_aktif' => true,
                    'created_at' => now(),
                ];
            }
        }

        // 6. Execute DB Transaction
        DB::transaction(function() use ($mode, $lab, $tahunAkademik, $recordsToInsert) {
            if ($mode === 'replace') {
                JadwalPenggunaanLab::where('lab_id', $lab->id)
                    ->where('tahun_akademik', $tahunAkademik)
                    ->delete();
            }

            foreach ($recordsToInsert as $data) {
                JadwalPenggunaanLab::create($data);
            }
        });

        $this->importedCount = count($recordsToInsert);

        return [
            'count' => $this->importedCount,
            'lab_name' => $lab->nama_lab,
            'tahun_akademik' => $tahunAkademik,
            'mode' => $mode,
        ];
    }

    private function normalizeDayName(string $val): ?string
    {
        $clean = strtolower(trim($val));
        if (str_contains($clean, 'senin')) return 'Senin';
        if (str_contains($clean, 'selasa')) return 'Selasa';
        if (str_contains($clean, 'rabu')) return 'Rabu';
        if (str_contains($clean, 'kamis')) return 'Kamis';
        if (str_contains($clean, 'jum')) return 'Jumat';
        if (str_contains($clean, 'sabtu')) return 'Sabtu';
        return null;
    }

    private function parseTimeSlot(string $slotStr, int $rowIdx): array
    {
        // Default based on row index (Row 7 is 08:00, Row 8 is 09:00, etc.)
        $defaultStartHour = ($rowIdx - 7) + 8;
        $defaultEndHour = $defaultStartHour + 1;

        $defStart = sprintf('%02d:00:00', $defaultStartHour);
        $defEnd = sprintf('%02d:00:00', $defaultEndHour);

        if (!$slotStr) {
            return ['start' => $defStart, 'end' => $defEnd];
        }

        // Extract HH.MM or HH:MM
        if (preg_match('/(\d{1,2})[\.:](\d{2})\s*[\-–—to]\s*(\d{1,2})[\.:](\d{2})/u', $slotStr, $m)) {
            $sH = (int)$m[1];
            $sM = (int)$m[2];
            $eH = (int)$m[3];
            $eM = (int)$m[4];
            return [
                'start' => sprintf('%02d:%02d:00', $sH, $sM),
                'end' => sprintf('%02d:%02d:00', $eH, $eM),
            ];
        }

        return ['start' => $defStart, 'end' => $defEnd];
    }

    private function parseCellText(string $text, ?string $fillColor): array
    {
        $raw = trim($text);
        
        // Normalize newlines to " - "
        $norm = preg_replace('/\r?\n/', ' - ', $raw);

        // 1. Extract Semester (e.g. Semester 5, Sem 3, Semester I)
        $semester = '1';
        if (preg_match('/(?:Semester|Sem)\s*(\d+|[IVXLCDM]+)/i', $norm, $m)) {
            $semStr = strtoupper($m[1]);
            $romans = ['I'=>1,'II'=>2,'III'=>3,'IV'=>4,'V'=>5,'VI'=>6,'VII'=>7,'VIII'=>8];
            $semester = isset($romans[$semStr]) ? (string)$romans[$semStr] : $semStr;
        }

        // 2. Extract Program Kuliah (Reguler / Karyawan)
        $programKuliah = 'Reguler';
        if (preg_match('/\b(Karyawan|Kar)\b/i', $norm)) {
            $programKuliah = 'Karyawan';
        }

        // 3. Extract Kelas (A, B, C, etc.)
        $kelas = 'A';
        if (preg_match('/(?:Kelas|Reg|Kar|Reguler|Karyawan)\s*([A-Z0-9]+)/i', $norm, $m)) {
            $kelas = strtoupper($m[1]);
        } elseif (preg_match('/\b([A-Z])\b(?:\s*-\s*|\s*$)/', $norm, $m)) {
            $kelas = strtoupper($m[1]);
        }

        // 4. Extract Dosen
        $dosenNameCandidate = null;
        $dosen = null;
        if (preg_match('/(?:Pak|Bu|Bpk|Ibu)\s+([A-Za-z\s\.,]+)$/i', $norm, $m)) {
            $dosenNameCandidate = trim($m[0]);
            $dosen = $this->findDosen($dosenNameCandidate);
        } elseif (preg_match('/-\s*([A-Za-z\s\.,]+)$/', $norm, $m)) {
            $candidate = trim($m[1]);
            $testDosen = $this->findDosen($candidate);
            if ($testDosen) {
                $dosenNameCandidate = $candidate;
                $dosen = $testDosen;
            }
        }

        // 5. Clean up Mata Kuliah string
        $cleanMk = $norm;
        if ($dosenNameCandidate) {
            $cleanMk = str_replace($dosenNameCandidate, '', $cleanMk);
        }
        $cleanMk = preg_replace('/(?:Semester|Sem)\s*(\d+|[IVXLCDM]+)/i', '', $cleanMk);
        $cleanMk = preg_replace('/(?:Reguler|Karyawan|Reg|Kar)\s*[A-Z0-9]*/i', '', $cleanMk);
        $cleanMk = preg_replace('/Kelas\s*[A-Z0-9]*/i', '', $cleanMk);
        
        // Clean leading/trailing spaces and hyphens, preserve internal hyphens like E-Business
        $cleanMk = preg_replace('/\s*-\s*-\s*/', ' - ', $cleanMk);
        $cleanMk = preg_replace('/^\s*[-–—•]\s*/', '', $cleanMk);
        $cleanMk = preg_replace('/\s*[-–—•]\s*$/', '', $cleanMk);
        $cleanMk = preg_replace('/\s+/', ' ', $cleanMk);
        $cleanMk = trim($cleanMk);

        if ($cleanMk === '') {
            $cleanMk = 'Praktikum';
        }

        // 6. Detect Prodi
        $idProdi = $this->detectProdi($cleanMk, $dosen, $fillColor);

        // Fallback for dosen: if no dosen extracted, try matching by mata kuliah
        if (!$dosen) {
            $matchedMk = $this->mataKuliahs->first(function($mk) use ($cleanMk) {
                return stripos($cleanMk, $mk->nama_mk) !== false || stripos($mk->nama_mk, $cleanMk) !== false;
            });
            if ($matchedMk && $matchedMk->dosen_id) {
                $dosen = $this->dosens->firstWhere('id', $matchedMk->dosen_id);
            }
        }

        return [
            'mata_kuliah' => $cleanMk,
            'semester' => $semester,
            'kelas' => $kelas,
            'program_kuliah' => $programKuliah,
            'dosen_id' => $dosen ? $dosen->id : null,
            'id_prodi' => $idProdi,
        ];
    }

    private function findDosen(?string $str): ?Dosen
    {
        if (!$str) return null;
        $clean = trim($str);
        $clean = preg_replace('/^(?:pak|bu|bpk|ibu)\s+/i', '', $clean);
        $clean = trim($clean);

        // Direct case-insensitive match
        foreach ($this->dosens as $d) {
            if (stripos($d->nama, $clean) !== false) {
                return $d;
            }
        }

        // Match first word if length >= 3
        $words = explode(' ', $clean);
        $firstWord = $words[0] ?? '';
        if (strlen($firstWord) >= 3) {
            foreach ($this->dosens as $d) {
                if (stripos($d->nama, $firstWord) !== false) {
                    return $d;
                }
            }
        }

        return null;
    }

    private function detectProdi(string $mataKuliah, ?Dosen $dosen, ?string $fillColor): ?int
    {
        // 1. By cell fill color matching Excel legend
        if ($fillColor) {
            $upperFill = strtoupper($fillColor);
            // Biru Dongker = SI (Sistem Informasi)
            if (str_contains($upperFill, '17375E') || str_contains($upperFill, '1F3763')) {
                $si = $this->prodis->first(fn($p) => stripos($p->nama_prodi, 'Sistem Informasi') !== false);
                if ($si) return $si->id;
            }
            // Hijau = TS (Teknik Sipil)
            if (str_contains($upperFill, '00AF52')) {
                $ts = $this->prodis->first(fn($p) => stripos($p->nama_prodi, 'Sipil') !== false);
                if ($ts) return $ts->id;
            }
            // Kuning = TM (Teknik Mesin)
            if (str_contains($upperFill, 'FFFF00')) {
                $tm = $this->prodis->first(fn($p) => stripos($p->nama_prodi, 'Mesin') !== false);
                if ($tm) return $tm->id;
            }
            // Merah = TE (Teknik Elektro)
            if (str_contains($upperFill, 'FF0000')) {
                $te = $this->prodis->first(fn($p) => stripos($p->nama_prodi, 'Elektro') !== false);
                if ($te) return $te->id;
            }
            // Ungu = TI (Teknik Industri)
            if (str_contains($upperFill, '6F2F9F')) {
                $ti = $this->prodis->first(fn($p) => stripos($p->nama_prodi, 'Industri') !== false);
                if ($ti) return $ti->id;
            }
            // Hijau Tua = IL (Ilmu Lingkungan)
            if (str_contains($upperFill, '669900')) {
                $il = $this->prodis->first(fn($p) => stripos($p->nama_prodi, 'Lingkungan') !== false);
                if ($il) return $il->id;
            }
            // Coklat Muda = RPB / PWK
            if (str_contains($upperFill, 'FFE499')) {
                $rpb = $this->prodis->first(fn($p) => stripos($p->nama_prodi, 'Perencanaan') !== false || stripos($p->nama_prodi, 'RPB') !== false);
                if ($rpb) return $rpb->id;
            }
        }

        // 2. By Dosen prodi
        if ($dosen && $dosen->id_prodi) {
            return $dosen->id_prodi;
        }

        // 3. By Mata Kuliah name match
        $matchedMk = $this->mataKuliahs->first(function($mk) use ($mataKuliah) {
            return stripos($mataKuliah, $mk->nama_mk) !== false || stripos($mk->nama_mk, $mataKuliah) !== false;
        });
        if ($matchedMk && $matchedMk->id_prodi) {
            return $matchedMk->id_prodi;
        }

        // 4. Default: Sistem Informasi if exists, or first prodi
        $si = $this->prodis->first(fn($p) => stripos($p->nama_prodi, 'Sistem Informasi') !== false);
        return $si ? $si->id : ($this->prodis->first()->id ?? null);
    }
}

<?php

namespace App\Exports;

use App\Models\Laboratorium;
use App\Models\JadwalPenggunaanLab;
use App\Models\Dosen;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JadwalLabExport
{
    protected $labId;
    protected $tahunAkademik;

    public function __construct($labId = null, $tahunAkademik = '2026/2027 Ganjil')
    {
        $this->labId = $labId;
        $this->tahunAkademik = $tahunAkademik ?: '2026/2027 Ganjil';
    }

    public function buildSpreadsheet(): Spreadsheet
    {
        $lab = Laboratorium::find($this->labId) ?? Laboratorium::first();
        $labName = $lab ? $lab->nama_lab : 'Laboratorium';

        $jadwals = JadwalPenggunaanLab::with(['lab', 'dosen', 'prodi'])
            ->when($this->labId, function($q) {
                $q->where('lab_id', $this->labId);
            })
            ->where('tahun_akademik', $this->tahunAkademik)
            ->orderBy('jam_mulai', 'asc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Table 1');

        // Page Setup: Landscape A4, Fit to Width
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        $sheet->setShowGridLines(true);

        // Column Widths (A to G all 25.83)
        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        foreach ($columns as $col) {
            $sheet->getColumnDimension($col)->setWidth(25.83);
        }

        // Row Heights
        $sheet->getRowDimension(1)->setRowHeight(18.6);
        $sheet->getRowDimension(2)->setRowHeight(24.0);
        $sheet->getRowDimension(3)->setRowHeight(18.95);
        $sheet->getRowDimension(4)->setRowHeight(18.95);
        $sheet->getRowDimension(5)->setRowHeight(12.0);
        $sheet->getRowDimension(6)->setRowHeight(21.75);
        for ($r = 7; $r <= 20; $r++) {
            $sheet->getRowDimension($r)->setRowHeight(35.1);
        }
        $sheet->getRowDimension(21)->setRowHeight(12.0);
        $sheet->getRowDimension(22)->setRowHeight(18.0);
        for ($r = 23; $r <= 27; $r++) {
            $sheet->getRowDimension($r)->setRowHeight(16.0);
        }
        for ($r = 28; $r <= 37; $r++) {
            $sheet->getRowDimension($r)->setRowHeight(16.5);
        }

        // Common Thin Border Style
        $thinBorderArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        // --- ROW 1 ---
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E0F1');

        // --- ROWS 2 to 4 (Header Box) ---
        $sheet->mergeCells('A2:C3');
        $sheet->setCellValue('A2', 'Jadwal Penggunaan ' . $labName);
        $sheet->getStyle('A2:C3')->getFont()->setName('Tahoma')->setSize(14.5)->setBold(true);
        $sheet->getStyle('A2:C3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:C3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E0F1');

        $sheet->mergeCells('D2:E2');
        $sheet->setCellValue('D2', 'Jadwal Mulai Pukul');
        $sheet->getStyle('D2:E2')->getFont()->setName('Tahoma')->setSize(9.5);
        $sheet->getStyle('D2:E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('D2:E2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');

        $sheet->setCellValue('F2', 'Tahun Akademik');
        $sheet->getStyle('F2')->getFont()->setName('Tahoma')->setSize(9.5);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('F2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');

        $sheet->mergeCells('G2:G3');
        $sheet->getStyle('G2:G3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E0F1');

        // Row 3
        $sheet->mergeCells('D3:E3');
        $sheet->setCellValue('D3', '08.00');
        $sheet->getStyle('D3:E3')->getFont()->setName('Tahoma')->setSize(9.5);
        $sheet->getStyle('D3:E3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('D3:E3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');

        $sheet->setCellValue('F3', $this->tahunAkademik);
        $sheet->getStyle('F3')->getFont()->setName('Tahoma')->setSize(9.5);
        $sheet->getStyle('F3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('F3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');

        // Row 4
        $sheet->getStyle('A4:C4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E0F1');
        $sheet->getStyle('D4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDBE5F2');

        $sheet->setCellValue('E4', 'Revisi');
        $sheet->getStyle('E4')->getFont()->setName('Tahoma')->setSize(9.5);
        $sheet->getStyle('E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('E4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');

        $sheet->setCellValue('F4', '0');
        $sheet->getStyle('F4')->getFont()->setName('Tahoma')->setSize(9.5);
        $sheet->getStyle('F4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('F4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');

        $sheet->getStyle('G4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E0F1');
        $sheet->getStyle('D2:F4')->applyFromArray($thinBorderArray);

        // Row 5
        $sheet->mergeCells('A5:G5');
        $sheet->getStyle('A5:G5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E0F1');

        // --- ROW 6 (Table Headers) ---
        $headers = [
            'A' => ['text' => 'Waktu', 'fill' => 'FF595959', 'color' => 'FFFFFFFF'],
            'B' => ['text' => 'Senin', 'fill' => 'FFBFBFBF', 'color' => 'FF000000'],
            'C' => ['text' => 'Selasa', 'fill' => 'FFBFBFBF', 'color' => 'FF000000'],
            'D' => ['text' => 'Rabu', 'fill' => 'FFBFBFBF', 'color' => 'FF000000'],
            'E' => ['text' => 'Kamis', 'fill' => 'FFBFBFBF', 'color' => 'FF000000'],
            'F' => ['text' => "Jum'at", 'fill' => 'FFBFBFBF', 'color' => 'FF000000'],
            'G' => ['text' => 'Sabtu', 'fill' => 'FFBFBFBF', 'color' => 'FF000000'],
        ];
        foreach ($headers as $col => $h) {
            $coord = $col . '6';
            $sheet->setCellValue($coord, $h['text']);
            $sheet->getStyle($coord)->getFont()->setName('Tahoma')->setSize(14.5)->setBold(true)->getColor()->setARGB($h['color']);
            $sheet->getStyle($coord)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($h['fill']);
            $sheet->getStyle($coord)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($coord)->applyFromArray($thinBorderArray);
        }

        // --- ROWS 7 to 20 (Time Slots & Grid) ---
        $timeSlots = [
            7  => '08.00-09.00',
            8  => '09.00-10.00',
            9  => '10.00-11.00',
            10 => '11.00-12.00',
            11 => '12.00-13.00',
            12 => '13.00-14.00',
            13 => '14.00-15.00',
            14 => '15.00-16.00',
            15 => '16.00-17.00',
            16 => '17.00-18.00',
            17 => '18.00-19.00',
            18 => '19.00-20.00',
            19 => '20.00-21.00',
            20 => '21.00-22.00',
        ];

        // Initialize all grid cells with default light blue fill and thin borders
        for ($r = 7; $r <= 20; $r++) {
            // Col A
            $sheet->setCellValue('A' . $r, $timeSlots[$r]);
            $sheet->getStyle('A' . $r)->getFont()->setName('Tahoma')->setSize(11)->setBold(true);
            $sheet->getStyle('A' . $r)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDBE5F2');
            $sheet->getStyle('A' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A' . $r)->applyFromArray($thinBorderArray);

            // Cols B to G default empty
            foreach (['B', 'C', 'D', 'E', 'F', 'G'] as $col) {
                $coord = $col . $r;
                $sheet->getStyle($coord)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDBE5F2');
                $sheet->getStyle($coord)->applyFromArray($thinBorderArray);
            }
        }

        // Day Mapping
        $dayColMap = [
            'senin'  => 'B',
            'selasa' => 'C',
            'rabu'   => 'D',
            'kamis'  => 'E',
            'jumat'  => 'F',
            "jum'at" => 'F',
            'sabtu'  => 'G',
        ];

        // Populate schedules into grid
        foreach ($jadwals as $j) {
            $dayKey = strtolower(trim($j->hari));
            if (!isset($dayColMap[$dayKey])) continue;
            $col = $dayColMap[$dayKey];

            // Clean 5-char times (HH:MM)
            $jStart = substr($j->jam_mulai, 0, 5);
            $jEnd   = substr($j->jam_selesai, 0, 5);

            $startRow = null;
            $endRow = null;

            foreach ($timeSlots as $rowIdx => $slotStr) {
                [$sStart, $sEnd] = explode('-', $slotStr);
                $sStartClean = str_replace('.', ':', $sStart);
                $sEndClean   = str_replace('.', ':', $sEnd);

                if (($jStart <= $sStartClean && $jEnd > $sStartClean) ||
                    ($jStart >= $sStartClean && $jStart < $sEndClean)) {
                    if ($startRow === null) {
                        $startRow = $rowIdx;
                    }
                    $endRow = $rowIdx;
                }
            }

            if ($startRow === null || $endRow === null) continue;

            $range = ($startRow < $endRow) ? "{$col}{$startRow}:{$col}{$endRow}" : "{$col}{$startRow}";
            if ($startRow < $endRow) {
                $sheet->mergeCells($range);
            }

            // Determine Prodi background and text color based on prodi
            $prodiName = strtolower($j->prodi->nama_prodi ?? '');
            $fillColor = 'FF17375E'; // Biru Dongker (Sistem Informasi / Default)
            $fontColor = 'FFFFFFFF';

            if (str_contains($prodiName, 'sipil')) {
                $fillColor = 'FF00AF52'; // Hijau (Teknik Sipil)
            } elseif (str_contains($prodiName, 'mesin')) {
                $fillColor = 'FFFFFF00'; // Kuning (Teknik Mesin)
                $fontColor = 'FF000000';
            } elseif (str_contains($prodiName, 'elektro')) {
                $fillColor = 'FFFF0000'; // Merah (Teknik Elektro)
            } elseif (str_contains($prodiName, 'industri')) {
                $fillColor = 'FF6F2F9F'; // Ungu (Teknik Industri)
            } elseif (str_contains($prodiName, 'lingkungan')) {
                $fillColor = 'FF669900'; // Hijau Tua (Ilmu Lingkungan)
            } elseif (str_contains($prodiName, 'perencanaan') || str_contains($prodiName, 'rpb')) {
                $fillColor = 'FFFFE499'; // Coklat Muda (RPB / PWK)
                $fontColor = 'FF000000';
            }

            // Format content text matching template style
            $textParts = [];
            $textParts[] = $j->mata_kuliah;
            
            $subInfo = [];
            if ($j->program_kuliah || $j->kelas) {
                $subInfo[] = trim(($j->program_kuliah ? $j->program_kuliah . ' ' : '') . ($j->kelas ? $j->kelas : ''));
            }
            if ($j->semester) {
                $subInfo[] = 'Semester ' . $j->semester;
            }
            if (!empty($subInfo)) {
                $textParts[] = implode(' - ', $subInfo);
            }
            if ($j->dosen && $j->dosen->nama) {
                $textParts[] = $j->dosen->nama;
            }

            $cellText = implode(' - ', $textParts);
            $topCell = $col . $startRow;
            $sheet->setCellValue($topCell, $cellText);

            // Apply styles
            $sheet->getStyle($range)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($fillColor);
            $sheet->getStyle($range)->getFont()->setName('Times New Roman')->setSize(10)->setBold(true)->getColor()->setARGB($fontColor);
            $sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
            $sheet->getStyle($range)->applyFromArray($thinBorderArray);
        }

        // --- ROW 22 (Note) ---
        $sheet->setCellValue('A22', '*Note Jadwal Dapat berubah Menyesuaikan Dengan waktu');
        $sheet->getStyle('A22')->getFont()->setName('Tahoma')->setSize(9)->setItalic(true);

        // --- ROWS 23 to 27 (Legend) ---
        $sheet->setCellValue('A23', 'PRODI');
        $sheet->setCellValue('B23', 'WARNA');
        $sheet->setCellValue('C23', 'KET');
        $sheet->setCellValue('E23', 'PRODI');
        $sheet->setCellValue('F23', 'WARNA');
        $sheet->setCellValue('G23', 'KET');
        foreach (['A23', 'B23', 'C23', 'E23', 'F23', 'G23'] as $c) {
            $sheet->getStyle($c)->getFont()->setName('Tahoma')->setSize(11);
            $sheet->getStyle($c)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFADAAAA');
            $sheet->getStyle($c)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($c)->applyFromArray($thinBorderArray);
        }

        // Row 24
        $sheet->setCellValue('A24', 'TS');
        $sheet->getStyle('B24')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF00AF52');
        $sheet->setCellValue('C24', 'HIJAU');
        $sheet->setCellValue('E24', 'SI');
        $sheet->getStyle('F24')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F3763');
        $sheet->setCellValue('G24', 'Biru Dongker');

        // Row 25
        $sheet->setCellValue('A25', 'TM');
        $sheet->getStyle('B25')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');
        $sheet->setCellValue('C25', 'KUNING');
        $sheet->setCellValue('E25', 'IL');
        $sheet->getStyle('F25')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF669900');
        $sheet->setCellValue('G25', 'Hijau Tua');

        // Row 26
        $sheet->setCellValue('A26', 'TE');
        $sheet->getStyle('B26')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
        $sheet->setCellValue('C26', 'MERAH');
        $sheet->setCellValue('E26', 'RPB');
        $sheet->getStyle('F26')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFE499');
        $sheet->setCellValue('G26', 'Coklat Muda');

        // Row 27
        $sheet->setCellValue('A27', 'TI');
        $sheet->getStyle('B27')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF6F2F9F');
        $sheet->setCellValue('C27', 'UNGU');

        for ($r = 24; $r <= 27; $r++) {
            foreach (['A', 'B', 'C'] as $c) {
                $sheet->getStyle($c . $r)->getFont()->setName('Tahoma')->setSize(11);
                $sheet->getStyle($c . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle($c . $r)->applyFromArray($thinBorderArray);
            }
            if ($r <= 26) {
                foreach (['E', 'F', 'G'] as $c) {
                    $sheet->getStyle($c . $r)->getFont()->setName('Tahoma')->setSize(11);
                    $sheet->getStyle($c . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle($c . $r)->applyFromArray($thinBorderArray);
                }
            }
        }

        // --- ROWS 30 to 37 (Signature Area) ---
        Carbon::setLocale('id');
        $nowDate = Carbon::now()->translatedFormat('j F Y');
        $sheet->setCellValue('E30', 'Bogor, ' . $nowDate);
        $sheet->getStyle('E30')->getFont()->setName('Times New Roman')->setSize(12);

        $sheet->setCellValue('E31', 'Kepala Laboratorium ' . ($lab ? $lab->nama_lab : 'Komputer Sistem Informasi') . ',');
        $sheet->getStyle('E31')->getFont()->setName('Times New Roman')->setSize(12);

        $kepalaLab = Dosen::where('nama', 'LIKE', '%Jejen%')->first();
        $namaKepala = $kepalaLab ? $kepalaLab->nama : 'Jejen Jaenudin, S.Kom., M.Kom.';
        $nipKepala = $kepalaLab ? ($kepalaLab->nip ?: '410100470') : '410100470';

        $sheet->setCellValue('E36', $namaKepala);
        $sheet->getStyle('E36')->getFont()->setName('Times New Roman')->setSize(12)->setBold(true);

        $sheet->setCellValue('E37', $nipKepala);
        $sheet->getStyle('E37')->getFont()->setName('Times New Roman')->setSize(12);

        return $spreadsheet;
    }

    public function download($filename = null): StreamedResponse
    {
        $lab = Laboratorium::find($this->labId) ?? Laboratorium::first();
        $labCode = $lab ? str_replace(' ', '_', strtoupper($lab->nama_lab)) : 'LAB';
        $taCode = str_replace([' ', '/'], ['_', '-'], strtoupper($this->tahunAkademik));

        if (!$filename) {
            $filename = "JADWAL_{$labCode}_TA._{$taCode}.xlsx";
        }

        $spreadsheet = $this->buildSpreadsheet();
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}

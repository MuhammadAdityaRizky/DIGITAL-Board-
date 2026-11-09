<?php

namespace App\Exports;

use App\Models\DokumenPropertiLab;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PropertiLabExcelExport
{
    protected DokumenPropertiLab $dokumen;

    public function __construct(DokumenPropertiLab $dokumen)
    {
        $this->dokumen = $dokumen;
    }

    public function download(): BinaryFileResponse
    {
        $dokumen = $this->dokumen->load(['laboratorium.fakultas', 'creator', 'items.kategori', 'items.subKategori']);
        $items = $dokumen->items;
        $labName = $dokumen->laboratorium->nama_lab ?? 'Laboratorium';
        $tglStr = $dokumen->tanggal_pendataan ? Carbon::parse($dokumen->tanggal_pendataan)->format('d-m-Y') : date('d-m-Y');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Daftar Fasilitas & Properti');
        $sheet->setShowGridLines(true);

        // Page Setup: Standar Konsisten A4 Landscape
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);

        // Header Title
        $sheet->mergeCells('A1:L1');
        $sheet->setCellValue('A1', 'DAFTAR FASILITAS DAN PROPERTI (FORMULIR MUTU: ' . $dokumen->nomor_dokumen . ')');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('115E59'));
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Metadata
        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A2', strtoupper($labName) . ' • UIKA BOGOR • TGL PENDATAAN: ' . $tglStr);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(10)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('475569'));
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Table Header
        $row = 4;
        $sheet->mergeCells("A{$row}:A" . ($row + 1))->setCellValue("A{$row}", 'NO');
        $sheet->mergeCells("B{$row}:B" . ($row + 1))->setCellValue("B{$row}", 'KATEGORI BARANG');
        $sheet->mergeCells("C{$row}:C" . ($row + 1))->setCellValue("C{$row}", 'SUB KATEGORI BARANG');
        $sheet->mergeCells("D{$row}:D" . ($row + 1))->setCellValue("D{$row}", 'NAMA PROPERTI');
        $sheet->mergeCells("E{$row}:E" . ($row + 1))->setCellValue("E{$row}", 'MERK / TYPE');
        $sheet->mergeCells("F{$row}:F" . ($row + 1))->setCellValue("F{$row}", 'NOMOR INVENTARIS');
        $sheet->mergeCells("G{$row}:G" . ($row + 1))->setCellValue("G{$row}", 'RUANG');
        $sheet->mergeCells("H{$row}:H" . ($row + 1))->setCellValue("H{$row}", 'HARGA (RP)');
        $sheet->mergeCells("I{$row}:I" . ($row + 1))->setCellValue("I{$row}", 'TAHUN');
        $sheet->mergeCells("J{$row}:L{$row}")->setCellValue("J{$row}", 'KONDISI');
        $sheet->setCellValue("J" . ($row + 1), 'BAIK');
        $sheet->setCellValue("K" . ($row + 1), 'SEDANG');
        $sheet->setCellValue("L" . ($row + 1), 'RUSAK');
        $sheet->mergeCells("M{$row}:M" . ($row + 1))->setCellValue("M{$row}", 'FREKUENSI PEMELIHARAAN');

        // Header Styling
        $headerStyle = [
            'font' => ['bold' => true, 'size' => 9, 'color' => ['rgb' => '0F172A']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F1F5F9']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]
            ]
        ];
        $sheet->getStyle("A{$row}:M" . ($row + 1))->applyFromArray($headerStyle);
        $sheet->getRowDimension($row)->setRowHeight(24);
        $sheet->getRowDimension($row + 1)->setRowHeight(20);

        // Data Rows
        $dataRowStart = $row + 2;
        $currentRow = $dataRowStart;

        foreach ($items as $idx => $item) {
            $sheet->setCellValue("A{$currentRow}", $idx + 1);
            $sheet->setCellValue("B{$currentRow}", $item->kategori?->nama ?? '-');
            $sheet->setCellValue("C{$currentRow}", $item->subKategori?->nama ?? '-');
            $sheet->setCellValue("D{$currentRow}", $item->nama_properti);
            $sheet->setCellValue("E{$currentRow}", $item->merk_type ?: '-');
            $sheet->setCellValue("F{$currentRow}", $item->nomor_inventaris ?: '-');
            $sheet->setCellValue("G{$currentRow}", $item->ruang ?: '-');
            $sheet->setCellValue("H{$currentRow}", $item->harga > 0 ? $item->harga : 0);
            $sheet->setCellValue("I{$currentRow}", $item->tahun ?: '-');

            $sheet->setCellValue("J{$currentRow}", $item->kondisi === 'baik' ? '✓' : '');
            $sheet->setCellValue("K{$currentRow}", $item->kondisi === 'sedang' ? '✓' : '');
            $sheet->setCellValue("L{$currentRow}", $item->kondisi === 'rusak' ? '✓' : '');
            $sheet->setCellValue("M{$currentRow}", $item->frekuensi_pemeliharaan ?: '6 Bulan');

            // Format Harga
            $sheet->getStyle("H{$currentRow}")->getNumberFormat()->setFormatCode('#,##0');

            // Alignments
            $sheet->getStyle("A{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("F{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("G{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("I{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("J{$currentRow}:L{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("M{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Bold on item name & checkmarks
            $sheet->getStyle("D{$currentRow}")->getFont()->setBold(true);
            $sheet->getStyle("J{$currentRow}:L{$currentRow}")->getFont()->setBold(true);

            $currentRow++;
        }

        $lastDataRow = $currentRow - 1;
        if ($lastDataRow >= $dataRowStart) {
            $sheet->getStyle("A{$dataRowStart}:M{$lastDataRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]
                ]
            ]);
        }

        // Auto-fit Column Widths
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Save & Stream
        $cleanLab = preg_replace('/[^a-zA-Z0-9_-]/', '_', $labName);
        $fileName = "Daftar_Inventaris_{$cleanLab}_" . date('Ymd_His') . ".xlsx";
        $tempPath = storage_path("app/public/{$fileName}");

        if (!is_dir(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempPath);

        return response()->download($tempPath, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}


<?php

namespace App\Exports;

use App\Models\ItemPropertiLab;
use Carbon\Carbon;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class KartuRiwayatAlatDocxExport
{
    /**
     * @var \Illuminate\Support\Collection<int, ItemPropertiLab>
     */
    protected $items;

    /**
     * @param ItemPropertiLab|\Illuminate\Support\Collection|array $items
     */
    public function __construct($items)
    {
        if ($items instanceof ItemPropertiLab) {
            $this->items = collect([$items]);
        } elseif (is_array($items)) {
            $this->items = collect($items);
        } else {
            $this->items = $items;
        }
    }

    public function download(?string $filename = null): BinaryFileResponse
    {
        $phpWord = new PhpWord();

        // Standard Font Family
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(11);

        $totalItems = $this->items->count();

        foreach ($this->items as $index => $item) {
            $item->loadMissing(['dokumen.laboratorium.fakultas', 'riwayats']);

            // Setup Section per item in A6 format (exact match to UIKA template: 105 mm x 148 mm)
            $section = $phpWord->addSection([
                'orientation' => 'portrait',
                'pageSizeW' => 5953, // A6 width: 105 mm (5953 twips)
                'pageSizeH' => 8391, // A6 height: 148 mm (8391 twips)
                'marginTop' => 288,  // ~5.1 mm (288 twips)
                'marginRight' => 288,
                'marginBottom' => 288,
                'marginLeft' => 288,
            ]);

            $lab = $item->dokumen?->laboratorium;
            $namaLab = strtoupper($lab?->nama_lab ?? 'LABORATORIUM SISTEM INFORMASI 209');
            $fakultas = strtoupper($lab?->fakultas?->nama_fakultas ?? 'FAKULTAS TEKNIK DAN SAINS');
            $namaKepalaLab = $lab?->nama_kepala_lab ?: 'Jejen Jaenudin S.kom., M.kom';

            // 1. Document Header (A6 Compact Proportion)
            $section->addText('KARTU RIWAYAT ALAT', [
                'name' => 'Times New Roman',
                'size' => 10,
                'bold' => true,
            ], [
                'alignment' => Jc::CENTER,
                'spaceAfter' => 10,
            ]);

            $section->addText("LABORATORIUM " . str_replace('LABORATORIUM', '', $namaLab), [
                'name' => 'Times New Roman',
                'size' => 9,
                'bold' => true,
            ], [
                'alignment' => Jc::CENTER,
                'spaceAfter' => 10,
            ]);

            $section->addText("PROGRAM STUDI SISTEM INFORMASI | {$fakultas} |", [
                'name' => 'Times New Roman',
                'size' => 7.5,
                'bold' => false,
            ], [
                'alignment' => Jc::CENTER,
                'spaceAfter' => 10,
            ]);

            $section->addText('UNIV. IBN KHALDUN BOGOR', [
                'name' => 'Times New Roman',
                'size' => 7.5,
                'bold' => false,
            ], [
                'alignment' => Jc::CENTER,
                'spaceAfter' => 60,
            ]);

            // 2. Equipment Identity
            $namaAlat = $item->nama_properti ?: 'Komputer';
            $spesifikasi = $item->merk_type ?: '-';
            $noInventaris = $item->nomor_inventaris ?: '-';

            $section->addText("Nama Alat: {$namaAlat}", [
                'name' => 'Times New Roman',
                'size' => 8,
                'bold' => true,
            ], ['spaceAfter' => 15]);

            $section->addText("Spesifikasi: {$spesifikasi}", [
                'name' => 'Times New Roman',
                'size' => 8,
                'bold' => false,
            ], ['spaceAfter' => 15]);

            $section->addText("No. Inventarisasi: {$noInventaris}", [
                'name' => 'Times New Roman',
                'size' => 8,
                'bold' => false,
            ], ['spaceAfter' => 15]);

            $kondisi = strtoupper($item->kondisi ?? 'BAIK');
            $kondisiText = "Kondisi Alat: {$kondisi}";
            if (strtolower($item->kondisi ?? '') === 'rusak') {
                $kondisiText .= ' (PERANGKAT RUSAK - MEMERLUKAN PERBAIKAN)';
            }
            $section->addText($kondisiText, [
                'name' => 'Times New Roman',
                'size' => 8,
                'bold' => (strtolower($item->kondisi ?? '') === 'rusak'),
                'color' => (strtolower($item->kondisi ?? '') === 'rusak' ? 'B91C1C' : (strtolower($item->kondisi ?? '') === 'sedang' ? 'B45309' : '000000')),
            ], ['spaceAfter' => 50]);

            // 3. Maintenance / Action History Table (Exact A6 Template: 2229, 1236, 1366, 910 twips)
            $tableStyle = [
                'borderSize' => 6,
                'borderColor' => '000000',
                'cellMargin' => 40,
                'alignment' => JcTable::CENTER,
            ];
            $phpWord->addTableStyle("HistoryTable_{$item->id}", $tableStyle);
            $table = $section->addTable("HistoryTable_{$item->id}");

            // Table Header Row
            $table->addRow(300, ['tblHeader' => true]);
            $cellHeaderStyle = ['bgColor' => 'F2F2F2', 'valign' => 'center'];
            $textHeaderStyle = ['name' => 'Times New Roman', 'size' => 7.5, 'bold' => true];
            $pHeaderStyle = ['alignment' => Jc::CENTER, 'spaceAfter' => 0];

            $table->addCell(2229, $cellHeaderStyle)->addText('Tindakan', $textHeaderStyle, $pHeaderStyle);
            $table->addCell(1236, $cellHeaderStyle)->addText('Tanggal Dan Waktu' . "\n" . '(Mulai)', $textHeaderStyle, $pHeaderStyle);
            $table->addCell(1366, $cellHeaderStyle)->addText('Tanggal Dan Waktu' . "\n" . '(Berakhir)', $textHeaderStyle, $pHeaderStyle);
            $table->addCell(910, $cellHeaderStyle)->addText('Paraf', $textHeaderStyle, $pHeaderStyle);

            // Table Data Rows
            $riwayats = $item->riwayats;
            $rowCount = 0;

            if ($riwayats && $riwayats->count() > 0) {
                foreach ($riwayats as $r) {
                    $table->addRow(260);
                    $tglMulai = $r->tanggal_mulai ? Carbon::parse($r->tanggal_mulai)->format('d/m/Y H:i') : '-';
                    $tglSelesai = $r->tanggal_selesai ? Carbon::parse($r->tanggal_selesai)->format('d/m/Y H:i') : '-';

                    $table->addCell(2229, ['valign' => 'center'])->addText($r->tindakan, ['size' => 7], ['spaceAfter' => 0]);
                    $table->addCell(1236, ['valign' => 'center'])->addText($tglMulai, ['size' => 7], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
                    $table->addCell(1366, ['valign' => 'center'])->addText($tglSelesai, ['size' => 7], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
                    $table->addCell(910, ['valign' => 'center'])->addText($r->paraf ?: '', ['size' => 7], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
                    $rowCount++;
                }
            }

            // Fill empty rows to make at least 10 rows matching UIKA A6 form
            $emptyRowsNeeded = max(0, 10 - $rowCount);
            for ($k = 0; $k < $emptyRowsNeeded; $k++) {
                $table->addRow(260);
                $table->addCell(2229, ['valign' => 'center'])->addText('', ['size' => 7], ['spaceAfter' => 0]);
                $table->addCell(1236, ['valign' => 'center'])->addText('', ['size' => 7], ['spaceAfter' => 0]);
                $table->addCell(1366, ['valign' => 'center'])->addText('', ['size' => 7], ['spaceAfter' => 0]);
                $table->addCell(910, ['valign' => 'center'])->addText('', ['size' => 7], ['spaceAfter' => 0]);
            }

            // 4. Signature Block (Right Aligned matching A6 template)
            $section->addTextBreak(1);
            $sigTable = $section->addTable([
                'borderSize' => 0,
                'borderColor' => 'FFFFFF',
                'cellMargin' => 0,
                'alignment' => JcTable::END,
            ]);
            $sigTable->addRow();
            $sigCell = $sigTable->addCell(2600);
            $sigCell->addText('Kepala Laboratorium', ['name' => 'Times New Roman', 'size' => 8, 'bold' => true], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);

            // Ruang kosong untuk tanda tangan / paraf fisik asli Kepala Lab
            $sigCell->addTextBreak(2);

            $sigCell->addText($namaKepalaLab, ['name' => 'Times New Roman', 'size' => 8, 'bold' => true, 'underline' => 'single'], ['alignment' => Jc::CENTER, 'spaceAfter' => 0]);
        }

        // Save & Download
        if (!$filename) {
            if ($totalItems === 1) {
                $first = $this->items->first();
                $sanitized = preg_replace('/[^A-Za-z0-9_\-]/', '_', $first->nomor_inventaris ?: $first->nama_properti);
                $filename = "Kartu_Riwayat_{$sanitized}.docx";
            } else {
                $filename = "Kartu_Riwayat_Alat_Lab_" . date('Ymd_His') . ".docx";
            }
        }

        $tempPath = storage_path('app/' . uniqid('kartu_riwayat_', true) . '.docx');
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempPath);

        return response()->download($tempPath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }
}

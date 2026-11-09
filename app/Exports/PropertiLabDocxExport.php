<?php

namespace App\Exports;

use App\Models\DokumenPropertiLab;
use Carbon\Carbon;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PropertiLabDocxExport
{
    protected DokumenPropertiLab $dokumen;

    public function __construct(DokumenPropertiLab $dokumen)
    {
        $this->dokumen = $dokumen;
    }

    public function download(): BinaryFileResponse
    {
        $phpWord = new PhpWord();

        // 1. Setup Page: Landscape A4, Compact Margins (Konsisten Standar UIKA A4)
        $section = $phpWord->addSection([
            'orientation'  => 'landscape',
            'pageSizeW'    => 16838, // A4 Landscape width in twips (297 mm)
            'pageSizeH'    => 11906, // A4 Landscape height in twips (210 mm)
            'marginTop'    => 567,   // ~1 cm
            'marginRight'  => 567,
            'marginBottom' => 567,
            'marginLeft'   => 567,
        ]);

        $dokumen = $this->dokumen->load(['laboratorium.fakultas', 'creator', 'items.kategori', 'items.subKategori']);
        $items = $dokumen->items;
        $lab = $dokumen->laboratorium;
        $labName = $lab?->nama_lab ?? 'Laboratorium';
        $tglStr = $dokumen->tanggal_pendataan ? Carbon::parse($dokumen->tanggal_pendataan)->format('d-m-Y') : date('d-m-Y');
        $tglLong = $dokumen->tanggal_pendataan ? Carbon::parse($dokumen->tanggal_pendataan)->translatedFormat('d F Y') : date('d F Y');

        // 2. KOP HEADER RESMI UIKA (3 Kolom Sesuai Persis Tampilan Web)
        $headerTableStyle = [
            'borderSize' => 8,
            'borderColor' => '000000',
            'cellMarginTop' => 40,
            'cellMarginRight' => 60,
            'cellMarginBottom' => 40,
            'cellMarginLeft' => 60,
            'alignment' => JcTable::CENTER,
        ];
        $headerTable = $section->addTable($headerTableStyle);
        $headerTable->addRow(850, ['cantSplit' => true]);

        // Kolom 1: Logo & UIKA BOGOR (Lebar 2200 twips)
        $cell1 = $headerTable->addCell(2200, ['valign' => 'center', 'bgColor' => 'F8FAFC']);
        $logoPath = public_path('images/logo-uika.png');
        if (file_exists($logoPath)) {
            $cell1->addImage($logoPath, [
                'width' => 44,
                'height' => 44,
                'alignment' => Jc::CENTER,
            ]);
        }
        $cell1->addText('UIKA BOGOR', ['name' => 'Calibri', 'size' => 7.5, 'bold' => true, 'color' => '1E293B'], ['alignment' => Jc::CENTER, 'spaceBefore' => 15]);

        // Kolom 2: Judul Dokumen (Lebar 8200 twips)
        $cell2 = $headerTable->addCell(8200, ['valign' => 'center']);
        $cell2->addText('FORMULIR MUTU', ['name' => 'Calibri', 'size' => 8, 'bold' => true, 'color' => '64748B'], ['alignment' => Jc::CENTER, 'spaceAfter' => 20]);
        $cell2->addText('DAFTAR FASILITAS DAN PROPERTI', ['name' => 'Calibri', 'size' => 12, 'bold' => true, 'color' => '0F172A'], ['alignment' => Jc::CENTER, 'spaceAfter' => 20]);
        $cell2->addText(strtoupper($labName), ['name' => 'Calibri', 'size' => 9.5, 'bold' => true, 'color' => '0F766E'], ['alignment' => Jc::CENTER]);

        // Kolom 3: Metadata Dokumen (Lebar 4650 twips)
        $cell3 = $headerTable->addCell(4650, ['valign' => 'center', 'bgColor' => 'F8FAFC']);
        $metaTable = $cell3->addTable([
            'borderSize' => 4,
            'borderColor' => '000000',
            'cellMarginTop' => 20,
            'cellMarginBottom' => 20,
            'cellMarginLeft' => 30,
            'cellMarginRight' => 30,
            'alignment' => JcTable::CENTER,
        ]);
        $metaLblFont = ['name' => 'Calibri', 'size' => 7.5, 'color' => '475569'];
        $metaValFont = ['name' => 'Calibri', 'size' => 7.5, 'bold' => true, 'color' => '0F172A'];

        $metaTable->addRow(180);
        $metaTable->addCell(2000)->addText('No. Dokumen', $metaLblFont);
        $metaTable->addCell(2650)->addText($dokumen->nomor_dokumen, $metaValFont);

        $metaTable->addRow(180);
        $metaTable->addCell(2000)->addText('No. Revisi', $metaLblFont);
        $metaTable->addCell(2650)->addText($dokumen->nomor_revisi ?: '00', $metaValFont);

        $metaTable->addRow(180);
        $metaTable->addCell(2000)->addText('Tgl. Pendataan', $metaLblFont);
        $metaTable->addCell(2650)->addText($tglStr, $metaValFont);

        $metaTable->addRow(180);
        $metaTable->addCell(2000)->addText('Halaman', $metaLblFont);
        $metaTable->addCell(2650)->addText('1 dari 1', $metaValFont);

        $section->addTextBreak(1);

        // 3. TABEL 11 KOLOM RESMI (SAMA PERSIS DENGAN TAMPILAN WEB)
        // Total Lebar: ~15050 twips (Pas 100% di A4 Landscape 16838 twips dengan margin)
        $colW = [
            'no'           => 450,  // 1. No
            'kategori'     => 1550, // 2. Kategori Barang
            'sub_kategori' => 1550, // 3. Sub Kategori Barang
            'nama'         => 1600, // 4. Nama Properti
            'merk'         => 2000, // 5. Merk / Type
            'nomor'        => 2200, // 6. Nomor (Nomor Inventaris)
            'ruang'        => 800,  // 7. Ruang
            'harga'        => 1200, // 8. Harga (Rp)
            'tahun'        => 700,  // 9. Tahun
            'baik'         => 550,  // 10a. Baik
            'sedang'       => 550,  // 10b. Sedang
            'rusak'        => 550,  // 10c. Rusak
            'pemeliharaan' => 1350, // 11. Frekuensi Pemeliharaan
        ];

        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMarginTop' => 30,
            'cellMarginRight' => 45,
            'cellMarginBottom' => 30,
            'cellMarginLeft' => 45,
            'alignment' => JcTable::CENTER,
        ];
        $phpWord->addTableStyle('InventarisWordTable', $tableStyle);
        $table = $section->addTable('InventarisWordTable');

        $headerFont = ['name' => 'Calibri', 'size' => 8, 'bold' => true, 'color' => '0F172A'];
        $headerAlign = ['alignment' => Jc::CENTER];
        $cellBgHeader = ['bgColor' => 'F1F5F9', 'valign' => 'center'];

        // Header Row 1 (Induk Kolom)
        $table->addRow(320, ['tblHeader' => true, 'cantSplit' => true]);
        $table->addCell($colW['no'], array_merge($cellBgHeader, ['vMerge' => 'restart']))->addText('No', $headerFont, $headerAlign);
        $table->addCell($colW['kategori'], array_merge($cellBgHeader, ['vMerge' => 'restart']))->addText('Kategori Barang', $headerFont, $headerAlign);
        $table->addCell($colW['sub_kategori'], array_merge($cellBgHeader, ['vMerge' => 'restart']))->addText('Sub Kategori Barang', $headerFont, $headerAlign);
        $table->addCell($colW['nama'], array_merge($cellBgHeader, ['vMerge' => 'restart']))->addText('Nama Properti', $headerFont, $headerAlign);
        $table->addCell($colW['merk'], array_merge($cellBgHeader, ['vMerge' => 'restart']))->addText('Merk / Type', $headerFont, $headerAlign);
        $table->addCell($colW['nomor'], array_merge($cellBgHeader, ['vMerge' => 'restart']))->addText('Nomor', $headerFont, $headerAlign);
        $table->addCell($colW['ruang'], array_merge($cellBgHeader, ['vMerge' => 'restart']))->addText('Ruang', $headerFont, $headerAlign);
        $table->addCell($colW['harga'], array_merge($cellBgHeader, ['vMerge' => 'restart']))->addText('Harga (Rp)', $headerFont, $headerAlign);
        $table->addCell($colW['tahun'], array_merge($cellBgHeader, ['vMerge' => 'restart']))->addText('Tahun', $headerFont, $headerAlign);
        $table->addCell($colW['baik'] + $colW['sedang'] + $colW['rusak'], array_merge($cellBgHeader, ['gridSpan' => 3]))->addText('Kondisi', $headerFont, $headerAlign);
        $table->addCell($colW['pemeliharaan'], array_merge($cellBgHeader, ['vMerge' => 'restart']))->addText('Frekuensi Pemeliharaan', $headerFont, $headerAlign);

        // Header Row 2 (Sub-header Kondisi: Baik, Sedang, Rusak)
        $table->addRow(260, ['tblHeader' => true, 'cantSplit' => true]);
        $table->addCell($colW['no'], array_merge($cellBgHeader, ['vMerge' => 'continue']));
        $table->addCell($colW['kategori'], array_merge($cellBgHeader, ['vMerge' => 'continue']));
        $table->addCell($colW['sub_kategori'], array_merge($cellBgHeader, ['vMerge' => 'continue']));
        $table->addCell($colW['nama'], array_merge($cellBgHeader, ['vMerge' => 'continue']));
        $table->addCell($colW['merk'], array_merge($cellBgHeader, ['vMerge' => 'continue']));
        $table->addCell($colW['nomor'], array_merge($cellBgHeader, ['vMerge' => 'continue']));
        $table->addCell($colW['ruang'], array_merge($cellBgHeader, ['vMerge' => 'continue']));
        $table->addCell($colW['harga'], array_merge($cellBgHeader, ['vMerge' => 'continue']));
        $table->addCell($colW['tahun'], array_merge($cellBgHeader, ['vMerge' => 'continue']));
        $table->addCell($colW['baik'], $cellBgHeader)->addText('Baik', $headerFont, $headerAlign);
        $table->addCell($colW['sedang'], $cellBgHeader)->addText('Sedang', $headerFont, $headerAlign);
        $table->addCell($colW['rusak'], $cellBgHeader)->addText('Rusak', $headerFont, $headerAlign);
        $table->addCell($colW['pemeliharaan'], array_merge($cellBgHeader, ['vMerge' => 'continue']));

        // Data Rows
        $rowFont = ['name' => 'Calibri', 'size' => 7.5];
        $rowFontBold = ['name' => 'Calibri', 'size' => 7.5, 'bold' => true];
        $centerAlign = ['alignment' => Jc::CENTER];
        $rightAlign = ['alignment' => Jc::END];

        $summary = [];
        $totalKeseluruhan = count($items);

        foreach ($items as $idx => $item) {
            $table->addRow(260, ['cantSplit' => true]);

            $kategoriNama = $item->kategori?->nama ?? '-';
            $subKategoriNama = $item->subKategori?->nama ?? '-';

            // 1. No
            $table->addCell($colW['no'], ['valign' => 'center'])->addText((string)($idx + 1), $rowFont, $centerAlign);
            // 2. Kategori Barang
            $table->addCell($colW['kategori'], ['valign' => 'center'])->addText($kategoriNama, $rowFont);
            // 3. Sub Kategori Barang
            $table->addCell($colW['sub_kategori'], ['valign' => 'center'])->addText($subKategoriNama, $rowFont);
            // 4. Nama Properti
            $table->addCell($colW['nama'], ['valign' => 'center'])->addText($item->nama_properti, $rowFontBold);
            // 5. Merk / Type
            $table->addCell($colW['merk'], ['valign' => 'center'])->addText($item->merk_type ?: '-', $rowFont);
            // 6. Nomor
            $table->addCell($colW['nomor'], ['valign' => 'center'])->addText($item->nomor_inventaris ?: '-', $rowFont, $centerAlign);
            // 7. Ruang
            $table->addCell($colW['ruang'], ['valign' => 'center'])->addText($item->ruang ?: '-', $rowFont, $centerAlign);
            // 8. Harga (Rp)
            $hargaStr = ($item->harga > 0) ? number_format($item->harga, 0, ',', '.') : '0';
            $table->addCell($colW['harga'], ['valign' => 'center'])->addText($hargaStr, $rowFont, $rightAlign);
            // 9. Tahun
            $table->addCell($colW['tahun'], ['valign' => 'center'])->addText($item->tahun ?: '-', $rowFont, $centerAlign);

            // 10. Kondisi (Baik, Sedang, Rusak)
            $isBaik = $item->kondisi === 'baik';
            $isSedang = $item->kondisi === 'sedang';
            $isRusak = $item->kondisi === 'rusak';

            $table->addCell($colW['baik'], ['valign' => 'center'])->addText($isBaik ? '✓' : '', ['name' => 'Calibri', 'size' => 9, 'bold' => true], $centerAlign);
            $table->addCell($colW['sedang'], ['valign' => 'center'])->addText($isSedang ? '✓' : '', ['name' => 'Calibri', 'size' => 9, 'bold' => true], $centerAlign);
            $table->addCell($colW['rusak'], ['valign' => 'center'])->addText($isRusak ? '✓' : '', ['name' => 'Calibri', 'size' => 9, 'bold' => true], $centerAlign);

            // 11. Frekuensi Pemeliharaan
            $table->addCell($colW['pemeliharaan'], ['valign' => 'center'])->addText($item->frekuensi_pemeliharaan ?: '6 Bulan', $rowFont, $centerAlign);

            // Akumulasi ringkasan
            $key = $item->nama_properti;
            $kode = $item->kategori?->kode ?: ($item->subKategori?->kode ?: '');
            $displayKey = $key . ($kode ? " ({$kode})" : '');
            if (!empty($item->merk_type)) {
                $displayKey .= " " . $item->merk_type;
            }
            $summary[$displayKey] = ($summary[$displayKey] ?? 0) + 1;
        }

        // 4. Section Ringkasan Total Barang (Di Bawah Tabel)
        $section->addTextBreak(1);
        $section->addText('Ringkasan Total Barang', ['name' => 'Calibri', 'size' => 9.5, 'bold' => true, 'color' => '0F766E']);

        foreach ($summary as $lbl => $jml) {
            $section->addText("• {$lbl}: {$jml} Unit", ['name' => 'Calibri', 'size' => 8]);
        }
        $section->addText("Total Keseluruhan: {$totalKeseluruhan} Unit", [
            'name' => 'Calibri',
            'size' => 8.5,
            'bold' => true,
            'color' => '0F766E'
        ]);

        // 5. Section Tanda Tangan (Persis Lembar Fisik Web)
        $section->addTextBreak(1);
        $signTable = $section->addTable(['alignment' => JcTable::CENTER]);
        $signTable->addRow();

        $namaKepala = !empty($lab?->nama_kepala_lab) ? $lab->nama_kepala_lab : 'Dr. Jejen Jaenudin, S.Kom., M.Kom.';
        $nipKepala = !empty($lab?->nip_kepala_lab) ? $lab->nip_kepala_lab : '410100470';

        $c1 = $signTable->addCell(7500);
        $c1->addText('Mengetahui,', ['name' => 'Calibri', 'size' => 8.5], $centerAlign);
        $c1->addText('Kepala Laboratorium', ['name' => 'Calibri', 'size' => 8.5, 'bold' => true], $centerAlign);
        $c1->addTextBreak(3);
        $c1->addText($namaKepala, ['name' => 'Calibri', 'size' => 8.5, 'bold' => true, 'underline' => 'single'], $centerAlign);
        $c1->addText('NIP: ' . $nipKepala, ['name' => 'Calibri', 'size' => 7.5], $centerAlign);

        $c2 = $signTable->addCell(7500);
        $c2->addText("Bogor, {$tglLong}", ['name' => 'Calibri', 'size' => 8.5], $centerAlign);
        $c2->addText('Laboran / Pengelola Lab', ['name' => 'Calibri', 'size' => 8.5, 'bold' => true], $centerAlign);
        $c2->addTextBreak(3);
        $c2->addText($lab?->nama_laboran ?? 'Kurniawan, S.T.', ['name' => 'Calibri', 'size' => 8.5, 'bold' => true, 'underline' => 'single'], $centerAlign);
        $c2->addText('Petugas Pendataan', ['name' => 'Calibri', 'size' => 7.5], $centerAlign);

        // 6. Save & Stream
        $cleanLab = preg_replace('/[^a-zA-Z0-9_-]/', '_', $labName);
        $fileName = "Daftar_Inventaris_{$cleanLab}_" . date('Ymd_His') . ".docx";
        $tempPath = storage_path("app/public/{$fileName}");

        if (!is_dir(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempPath);

        return response()->download($tempPath, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }
}

<?php

namespace App\Imports;

use App\Models\DokumenPropertiLab;
use App\Models\ItemPropertiLab;
use App\Models\KategoriProperti;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory as ExcelIOFactory;
use ZipArchive;

class PropertiLabImport
{
    /**
     * Eksekusi Import File Inventaris ke Dokumen Lab
     * Mendukung: Word (.docx) dan Excel (.xlsx, .xls, .csv)
     *
     * @param DokumenPropertiLab $dokumen
     * @param UploadedFile|string $file
     * @param string $mode ('append' atau 'replace')
     * @return array
     */
    public function import(DokumenPropertiLab $dokumen, $file, string $mode = 'append'): array
    {
        $filePath = is_string($file) ? $file : $file->getRealPath();
        $extension = strtolower(is_string($file) ? pathinfo($file, PATHINFO_EXTENSION) : $file->getClientOriginalExtension());

        // 1. Parse File sesuai format ekstensi
        if (in_array($extension, ['docx', 'doc'])) {
            $parsedItems = $this->parseDocx($filePath);
        } elseif (in_array($extension, ['xlsx', 'xls', 'csv'])) {
            $parsedItems = $this->parseExcel($filePath);
        } else {
            throw new \InvalidArgumentException("Format file .{$extension} tidak didukung. Harap unggah file Word (.docx) atau Excel (.xlsx).");
        }

        if (empty($parsedItems)) {
            throw new \RuntimeException("Tidak ada baris data barang yang berhasil dibaca dari berkas.");
        }

        // 2. Jika Mode Replace, hapus semua item yang ada di dokumen ini
        if ($mode === 'replace') {
            ItemPropertiLab::where('dokumen_id', $dokumen->id)->delete();
            $currentUrutan = 0;
        } else {
            $currentUrutan = (int)(ItemPropertiLab::where('dokumen_id', $dokumen->id)->max('urutan') ?? 0);
        }

        // 3. Cache Kategori & Sub Kategori untuk kecepatan
        $allCategories = KategoriProperti::all();
        $categoriesByName = [];
        $subCategoriesByName = [];

        foreach ($allCategories as $cat) {
            $key = strtolower(trim($cat->nama));
            if ($cat->jenis === 'kategori') {
                $categoriesByName[$key] = $cat;
            } else {
                $subKey = $cat->parent_id . '_' . $key;
                $subCategoriesByName[$subKey] = $cat;
            }
        }

        $defaultRuang = $this->extractRuangNumber($dokumen->laboratorium);
        $importedCount = 0;
        $categoriesCreated = 0;

        // 4. Proses Tiap Item
        foreach ($parsedItems as $data) {
            $currentUrutan++;

            $kategoriId = null;
            $subKategoriId = null;

            // Handle Kategori Utama
            if (!empty($data['kategori'])) {
                $catName = trim($data['kategori']);
                $catKey = strtolower($catName);

                if (isset($categoriesByName[$catKey])) {
                    $kategori = $categoriesByName[$catKey];
                } else {
                    $kode = $this->generateCategoryCode($catName);
                    $kategori = KategoriProperti::create([
                        'nama' => $catName,
                        'kode' => $kode,
                        'jenis' => 'kategori',
                        'parent_id' => null,
                    ]);
                    $categoriesByName[$catKey] = $kategori;
                    $categoriesCreated++;
                }
                $kategoriId = $kategori->id;

                // Handle Sub Kategori
                if (!empty($data['sub_kategori'])) {
                    $subName = trim($data['sub_kategori']);
                    $subKey = $kategoriId . '_' . strtolower($subName);

                    if (isset($subCategoriesByName[$subKey])) {
                        $sub = $subCategoriesByName[$subKey];
                    } else {
                        $subKode = $this->generateCategoryCode($subName);
                        $sub = KategoriProperti::create([
                            'nama' => $subName,
                            'kode' => $subKode,
                            'jenis' => 'sub_kategori',
                            'parent_id' => $kategoriId,
                        ]);
                        $subCategoriesByName[$subKey] = $sub;
                        $categoriesCreated++;
                    }
                    $subKategoriId = $sub->id;
                }
            }

            // Normalisasi Ruang
            $ruang = !empty($data['ruang']) ? $data['ruang'] : $defaultRuang;

            // Normalisasi Tahun
            $tahun = !empty($data['tahun']) ? (string)$data['tahun'] : (string)date('Y');
            if (strlen($tahun) === 2) {
                $tahun = '20' . $tahun;
            }

            // Normalisasi Kondisi
            $kondisi = strtolower(trim($data['kondisi'] ?? 'baik'));
            if (!in_array($kondisi, ['baik', 'sedang', 'rusak'])) {
                if (str_contains($kondisi, 'rusak') || str_contains($kondisi, 'buruk')) {
                    $kondisi = 'rusak';
                } elseif (str_contains($kondisi, 'sedang')) {
                    $kondisi = 'sedang';
                } else {
                    $kondisi = 'baik';
                }
            }

            // Normalisasi Harga
            $harga = isset($data['harga']) ? (float)$data['harga'] : 0;

            // Normalisasi Nomor Inventaris
            $nomorInventaris = trim($data['nomor_inventaris'] ?? '');
            if (empty($nomorInventaris)) {
                $nomorInventaris = $this->buildAssetNumberFallback($dokumen, $kategoriId, $subKategoriId, $data['nama_properti'], $currentUrutan);
            }

            ItemPropertiLab::create([
                'dokumen_id' => $dokumen->id,
                'kategori_id' => $kategoriId,
                'sub_kategori_id' => $subKategoriId,
                'nama_properti' => trim($data['nama_properti']),
                'merk_type' => trim($data['merk_type'] ?? ''),
                'nomor_inventaris' => $nomorInventaris,
                'ruang' => $ruang,
                'harga' => $harga,
                'tahun' => $tahun,
                'kondisi' => $kondisi,
                'frekuensi_pemeliharaan' => trim($data['frekuensi_pemeliharaan'] ?? '6 Bulan') ?: '6 Bulan',
                'urutan' => $currentUrutan,
            ]);

            $importedCount++;
        }

        return [
            'count' => $importedCount,
            'categories_created' => $categoriesCreated,
            'mode' => $mode,
        ];
    }

    /**
     * Parser File Word (.docx)
     * Sangat akurat membaca format tabel Daftar Inventaris Barang.docx & format 11 Kolom UIKA
     */
    public function parseDocx(string $filePath): array
    {
        $zip = new ZipArchive();
        if ($zip->open($filePath) !== TRUE) {
            throw new \RuntimeException("Berkas Word (.docx) rusak atau tidak dapat dibuka.");
        }

        $xml = $zip->getFromName('word/document.xml');
        $zip->close();

        if (!$xml) {
            throw new \RuntimeException("Konten berkas Word tidak valid.");
        }

        $dom = new DOMDocument();
        @$dom->loadXML($xml);

        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

        $tables = $xpath->query('//w:tbl');
        if ($tables->length === 0) {
            throw new \RuntimeException("Tidak ditemukan tabel daftar barang di dalam berkas Word.");
        }

        // Ambil tabel pertama yang memiliki baris data terbanyak
        $targetTable = $tables->item(0);
        $maxRows = 0;
        foreach ($tables as $tbl) {
            $rowCount = $xpath->query('.//w:tr', $tbl)->length;
            if ($rowCount > $maxRows) {
                $maxRows = $rowCount;
                $targetTable = $tbl;
            }
        }

        $rows = $xpath->query('.//w:tr', $targetTable);
        $items = [];
        $startRow = 0;
        $headerFound = false;

        // Cari baris header
        for ($i = 0; $i < min(6, $rows->length); $i++) {
            $tr = $rows->item($i);
            $cells = $xpath->query('.//w:tc', $tr);
            $texts = [];
            foreach ($cells as $tc) {
                $texts[] = strtolower(trim($tc->nodeValue));
            }
            $rowStr = implode(' ', $texts);
            if (str_contains($rowStr, 'kategori') || str_contains($rowStr, 'properti') || str_contains($rowStr, 'id barang') || str_contains($rowStr, 'nama barang')) {
                $headerFound = true;
                // Cek apakah baris berikutnya adalah sub-header kondisi (Baik, Sedang, Buruk/Rusak)
                if ($i + 1 < $rows->length) {
                    $nextTr = $rows->item($i + 1);
                    $nextCells = $xpath->query('.//w:tc', $nextTr);
                    $nextTexts = [];
                    foreach ($nextCells as $tc) {
                        $nextTexts[] = strtolower(trim($tc->nodeValue));
                    }
                    $nextStr = implode(' ', $nextTexts);
                    if (str_contains($nextStr, 'baik') || str_contains($nextStr, 'sedang') || str_contains($nextStr, 'rusak') || str_contains($nextStr, 'buruk')) {
                        $startRow = $i + 2;
                    } else {
                        $startRow = $i + 1;
                    }
                } else {
                    $startRow = $i + 1;
                }
                break;
            }
        }

        if (!$headerFound) {
            $startRow = 2; // Default jika header 2 baris
        }

        for ($i = $startRow; $i < $rows->length; $i++) {
            $tr = $rows->item($i);
            $cells = $xpath->query('.//w:tc', $tr);
            $colVals = [];
            foreach ($cells as $tc) {
                $colVals[] = trim($tc->nodeValue);
            }

            // Lewati baris kosong / baris tanda tangan di dalam tabel
            if (count($colVals) < 4) continue;
            if (empty($colVals[0]) && empty($colVals[1]) && empty($colVals[2]) && empty($colVals[3])) continue;
            if (str_contains(strtolower($colVals[0]), 'mengetahui') || str_contains(strtolower($colVals[1] ?? ''), 'kepala')) continue;

            $kategori = $colVals[1] ?? '';
            $subKategori = $colVals[2] ?? '';
            $namaProperti = $colVals[3] ?? '';
            $merkType = $colVals[4] ?? '';
            $nomorInventaris = $colVals[5] ?? '';

            if (empty($namaProperti)) continue;

            $ruang = null;
            $harga = 0;
            $tahun = null;
            $kondisi = 'baik';
            $frekuensi = '6 Bulan';

            // Jika Format 11/12 Kolom Fisik UIKA
            if (count($colVals) >= 12) {
                $ruang = $colVals[6] ?? null;
                $harga = (float)preg_replace('/[^0-9.]/', '', $colVals[7] ?? 0);
                $tahun = $colVals[8] ?? null;
                $baik = $colVals[9] ?? '';
                $sedang = $colVals[10] ?? '';
                $rusak = $colVals[11] ?? '';
                $frekuensi = $colVals[12] ?? '6 Bulan';

                if (!empty($rusak) && $rusak !== '-') $kondisi = 'rusak';
                elseif (!empty($sedang) && $sedang !== '-') $kondisi = 'sedang';
                else $kondisi = 'baik';
            } else {
                // Format Daftar Inventaris Barang.docx (9 Kolom)
                $baik = $colVals[6] ?? '';
                $sedang = $colVals[7] ?? '';
                $buruk = $colVals[8] ?? '';

                if (!empty($buruk) && $buruk !== '-') $kondisi = 'rusak';
                elseif (!empty($sedang) && $sedang !== '-') $kondisi = 'sedang';
                else $kondisi = 'baik';

                // Ekstrak ruang & tahun dari kode ID Barang (misal M/SI/209/10/26/1)
                if ($nomorInventaris) {
                    $parts = explode('/', $nomorInventaris);
                    if (count($parts) >= 3 && is_numeric($parts[2])) {
                        $ruang = $parts[2];
                    }
                    if (count($parts) >= 5 && is_numeric($parts[4])) {
                        $yr = (int)$parts[4];
                        $tahun = $yr < 100 ? (2000 + $yr) : $yr;
                    }
                }
            }

            $items[] = [
                'kategori' => $kategori,
                'sub_kategori' => $subKategori,
                'nama_properti' => $namaProperti,
                'merk_type' => $merkType,
                'nomor_inventaris' => $nomorInventaris,
                'ruang' => $ruang,
                'harga' => $harga,
                'tahun' => $tahun,
                'kondisi' => $kondisi,
                'frekuensi_pemeliharaan' => $frekuensi,
            ];
        }

        return $items;
    }

    /**
     * Parser File Spreadsheet Excel / CSV
     */
    public function parseExcel(string $filePath): array
    {
        $spreadsheet = ExcelIOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, false);

        if (empty($rows)) {
            throw new \RuntimeException("Lembar kerja Excel kosong.");
        }

        $items = [];
        $startRow = 0;
        $headerFound = false;

        for ($i = 0; $i < min(6, count($rows)); $i++) {
            $rowStr = strtolower(implode(' ', array_filter($rows[$i] ?? [])));
            if (str_contains($rowStr, 'kategori') || str_contains($rowStr, 'properti') || str_contains($rowStr, 'id barang') || str_contains($rowStr, 'nama barang')) {
                $headerFound = true;
                if ($i + 1 < count($rows)) {
                    $nextStr = strtolower(implode(' ', array_filter($rows[$i + 1] ?? [])));
                    if (str_contains($nextStr, 'baik') || str_contains($nextStr, 'sedang') || str_contains($nextStr, 'rusak') || str_contains($nextStr, 'buruk')) {
                        $startRow = $i + 2;
                    } else {
                        $startRow = $i + 1;
                    }
                } else {
                    $startRow = $i + 1;
                }
                break;
            }
        }

        if (!$headerFound) {
            $startRow = 1;
        }

        for ($i = $startRow; $i < count($rows); $i++) {
            $cols = $rows[$i];
            if (empty($cols) || (empty($cols[1]) && empty($cols[2]) && empty($cols[3]))) {
                continue;
            }

            $kategori = trim((string)($cols[1] ?? ''));
            $subKategori = trim((string)($cols[2] ?? ''));
            $namaProperti = trim((string)($cols[3] ?? ''));
            $merkType = trim((string)($cols[4] ?? ''));
            $nomorInventaris = trim((string)($cols[5] ?? ''));

            if (empty($namaProperti)) continue;

            $ruang = null;
            $harga = 0;
            $tahun = null;
            $kondisi = 'baik';
            $frekuensi = '6 Bulan';

            if (count($cols) >= 12) {
                $ruang = trim((string)($cols[6] ?? ''));
                $harga = (float)preg_replace('/[^0-9.]/', '', (string)($cols[7] ?? 0));
                $tahun = trim((string)($cols[8] ?? ''));
                $baik = trim((string)($cols[9] ?? ''));
                $sedang = trim((string)($cols[10] ?? ''));
                $rusak = trim((string)($cols[11] ?? ''));
                $frekuensi = trim((string)($cols[12] ?? '6 Bulan'));

                if (!empty($rusak) && $rusak !== '-') $kondisi = 'rusak';
                elseif (!empty($sedang) && $sedang !== '-') $kondisi = 'sedang';
                else $kondisi = 'baik';
            } else {
                $baik = trim((string)($cols[6] ?? ''));
                $sedang = trim((string)($cols[7] ?? ''));
                $buruk = trim((string)($cols[8] ?? ''));

                if (!empty($buruk) && $buruk !== '-') $kondisi = 'rusak';
                elseif (!empty($sedang) && $sedang !== '-') $kondisi = 'sedang';
                else $kondisi = 'baik';

                if ($nomorInventaris) {
                    $parts = explode('/', $nomorInventaris);
                    if (count($parts) >= 3 && is_numeric($parts[2])) {
                        $ruang = $parts[2];
                    }
                    if (count($parts) >= 5 && is_numeric($parts[4])) {
                        $yr = (int)$parts[4];
                        $tahun = $yr < 100 ? (2000 + $yr) : $yr;
                    }
                }
            }

            $items[] = [
                'kategori' => $kategori,
                'sub_kategori' => $subKategori,
                'nama_properti' => $namaProperti,
                'merk_type' => $merkType,
                'nomor_inventaris' => $nomorInventaris,
                'ruang' => $ruang,
                'harga' => $harga,
                'tahun' => $tahun,
                'kondisi' => $kondisi,
                'frekuensi_pemeliharaan' => $frekuensi,
            ];
        }

        return $items;
    }

    private function generateCategoryCode(string $name): string
    {
        $clean = preg_replace('/[^a-zA-Z0-9\s]/', '', $name);
        $words = explode(' ', trim($clean));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($clean, 0, 2));
    }

    private function extractRuangNumber($lab): string
    {
        if (!$lab) return 'LAB';
        if (preg_match('/(\d{3,4})/', $lab->nama_lab . ' ' . $lab->lokasi, $matches)) {
            return $matches[1];
        }
        return trim($lab->nama_lab);
    }

    private function buildAssetNumberFallback($dokumen, $kategoriId, $subKategoriId, $namaProperti, $urutan): string
    {
        $kode = 'BRG';
        if ($namaProperti) {
            $words = explode(' ', trim($namaProperti));
            $kode = strtoupper(substr($words[0], 0, 2));
        }
        $ruang = $this->extractRuangNumber($dokumen->laboratorium);
        $tanggal = $dokumen->tanggal_pendataan ? Carbon::parse($dokumen->tanggal_pendataan) : now();
        $bulan = $tanggal->format('m');
        $tahun = $tanggal->format('y');
        $noUrut = str_pad($urutan, 2, '0', STR_PAD_LEFT);

        return "{$kode}/SI/{$ruang}/{$bulan}/{$tahun}/{$noUrut}";
    }
}


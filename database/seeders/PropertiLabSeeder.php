<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriProperti;
use App\Models\Laboratorium;
use App\Models\DokumenPropertiLab;
use App\Models\ItemPropertiLab;
use App\Models\User;

class PropertiLabSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama' => 'Peralatan Kantor',
                'kode' => 'PK',
                'jenis' => 'kategori',
                'subs' => [
                    ['nama' => 'Barang Persediaan', 'kode' => 'BP'],
                    ['nama' => 'Elektronik', 'kode' => 'EL'],
                ]
            ],
            [
                'nama' => 'Alat Keselamatan Kerja',
                'kode' => 'K3',
                'jenis' => 'kategori',
                'subs' => [
                    ['nama' => 'Alat Pemadam Kebakaran', 'kode' => 'APAR'],
                ]
            ],
            [
                'nama' => 'Komputer',
                'kode' => 'PC',
                'jenis' => 'kategori',
                'subs' => [
                    ['nama' => 'PC AMD Ryzen', 'kode' => 'PC-AMD'],
                    ['nama' => 'PC Intel', 'kode' => 'PC-INTEL'],
                ]
            ],
            [
                'nama' => 'Meja',
                'kode' => 'M',
                'jenis' => 'kategori',
                'subs' => [
                    ['nama' => 'Meja Informa', 'kode' => 'M-INF'],
                    ['nama' => 'Meja Dosen', 'kode' => 'MD'],
                ]
            ],
            [
                'nama' => 'Kursi',
                'kode' => 'K',
                'jenis' => 'kategori',
                'subs' => [
                    ['nama' => 'Kursi Futura', 'kode' => 'K-FUT'],
                ]
            ],
            [
                'nama' => 'Printer',
                'kode' => 'PR',
                'jenis' => 'kategori',
                'subs' => [
                    ['nama' => 'Printer Epson', 'kode' => 'PR-EPS'],
                ]
            ],
            [
                'nama' => 'Papan Tulis',
                'kode' => 'PT',
                'jenis' => 'kategori',
                'subs' => [
                    ['nama' => 'Whiteboard Magnetic', 'kode' => 'WB'],
                ]
            ],
            [
                'nama' => 'CCTV',
                'kode' => 'C',
                'jenis' => 'kategori',
                'subs' => [
                    ['nama' => 'CCTV Icsee', 'kode' => 'C-ICS'],
                ]
            ],
            [
                'nama' => 'Air Conditioner',
                'kode' => 'AC',
                'jenis' => 'kategori',
                'subs' => [
                    ['nama' => 'AC Split 1 PK', 'kode' => 'AC-1PK'],
                    ['nama' => 'AC Split 1.5 PK', 'kode' => 'AC-15PK'],
                ]
            ],
        ];

        foreach ($categories as $catData) {
            $cat = KategoriProperti::firstOrCreate(
                ['nama' => $catData['nama'], 'jenis' => 'kategori'],
                ['kode' => $catData['kode'], 'parent_id' => null]
            );

            if (!empty($catData['subs'])) {
                foreach ($catData['subs'] as $sub) {
                    KategoriProperti::firstOrCreate(
                        ['nama' => $sub['nama'], 'jenis' => 'sub_kategori', 'parent_id' => $cat->id],
                        ['kode' => $sub['kode']]
                    );
                }
            }
        }

        // Seed Sample Dokumen untuk Lab 209 (sesuai foto lampiran fisik UIKA)
        $lab = Laboratorium::first();
        if ($lab && DokumenPropertiLab::where('lab_id', $lab->id)->count() === 0) {
            $user = User::first();
            $dokumen = DokumenPropertiLab::create([
                'lab_id' => $lab->id,
                'nama_dokumen' => 'DAFTAR FASILITAS DAN PROPERTI LAB 209 2025',
                'nomor_dokumen' => 'FT-SPR-INS-F-01',
                'nomor_revisi' => '0',
                'tanggal_pendataan' => '2025-08-23',
                'created_by' => $user?->id,
            ]);

            $catPK = KategoriProperti::where('nama', 'Peralatan Kantor')->first();
            $subBP = KategoriProperti::where('nama', 'Barang Persediaan')->first();
            $subEL = KategoriProperti::where('nama', 'Elektronik')->first();
            $catK3 = KategoriProperti::where('nama', 'Alat Keselamatan Kerja')->first();
            $subAPAR = KategoriProperti::where('nama', 'Alat Pemadam Kebakaran')->first();
            $catPC = KategoriProperti::where('nama', 'Komputer')->first();
            $subPCAMD = KategoriProperti::where('nama', 'PC AMD Ryzen')->first();

            $sampleItems = [
                [
                    'kategori_id' => $catPK?->id,
                    'sub_kategori_id' => $subBP?->id,
                    'nama_properti' => 'AC',
                    'merk_type' => 'LG',
                    'nomor_inventaris' => '021/C3-ACE/05/2017',
                    'ruang' => '209',
                    'harga' => 4500000,
                    'tahun' => '2017',
                    'kondisi' => 'baik',
                    'frekuensi_pemeliharaan' => '6 Bulan',
                ],
                [
                    'kategori_id' => $catPK?->id,
                    'sub_kategori_id' => $subBP?->id,
                    'nama_properti' => 'AC',
                    'merk_type' => 'Air Conditioner (AC) 1pk Sansui',
                    'nomor_inventaris' => '118/C3-ACE/01/2021',
                    'ruang' => '209',
                    'harga' => 3879000,
                    'tahun' => '2021',
                    'kondisi' => 'baik',
                    'frekuensi_pemeliharaan' => '6 Bulan',
                ],
                [
                    'kategori_id' => $catPK?->id,
                    'sub_kategori_id' => $subBP?->id,
                    'nama_properti' => 'AC',
                    'merk_type' => 'Daikin 1.5PK',
                    'nomor_inventaris' => '118/C3-ACE/09/2022',
                    'ruang' => '209',
                    'harga' => 5650000,
                    'tahun' => '2022',
                    'kondisi' => 'baik',
                    'frekuensi_pemeliharaan' => '6 Bulan',
                ],
                [
                    'kategori_id' => $catPK?->id,
                    'sub_kategori_id' => $subBP?->id,
                    'nama_properti' => 'AC',
                    'merk_type' => 'Sharp 1pk Second',
                    'nomor_inventaris' => '140/C3-ACE/08/2025',
                    'ruang' => '209',
                    'harga' => 1500000,
                    'tahun' => '2025',
                    'kondisi' => 'baik',
                    'frekuensi_pemeliharaan' => '6 Bulan',
                ],
                [
                    'kategori_id' => $catK3?->id,
                    'sub_kategori_id' => $subAPAR?->id,
                    'nama_properti' => 'Alat Pemadam Kebakaran',
                    'merk_type' => 'Fire extinguisher',
                    'nomor_inventaris' => '005/G1-APR/10/2017',
                    'ruang' => '209',
                    'harga' => 550000,
                    'tahun' => '2017',
                    'kondisi' => 'baik',
                    'frekuensi_pemeliharaan' => '1 Tahun',
                ],
                [
                    'kategori_id' => $catPC?->id,
                    'sub_kategori_id' => $subPCAMD?->id,
                    'nama_properti' => 'Komputer',
                    'merk_type' => 'PC AMD Ryzen 7 3700X',
                    'nomor_inventaris' => 'PC/SI/209/10/26/01',
                    'ruang' => '209',
                    'harga' => 15000000,
                    'tahun' => '2019',
                    'kondisi' => 'baik',
                    'frekuensi_pemeliharaan' => '6 Bulan',
                ],
                [
                    'kategori_id' => $catPC?->id,
                    'sub_kategori_id' => $subPCAMD?->id,
                    'nama_properti' => 'Komputer',
                    'merk_type' => 'PC AMD Ryzen 7 3700X',
                    'nomor_inventaris' => 'PC/SI/209/10/26/02',
                    'ruang' => '209',
                    'harga' => 15000000,
                    'tahun' => '2019',
                    'kondisi' => 'baik',
                    'frekuensi_pemeliharaan' => '6 Bulan',
                ],
            ];

            foreach ($sampleItems as $idx => $itemData) {
                $itemData['dokumen_id'] = $dokumen->id;
                $itemData['urutan'] = $idx + 1;
                ItemPropertiLab::create($itemData);
            }
        }
    }
}

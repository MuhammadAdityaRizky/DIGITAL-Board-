<?php

namespace App\Exports\Templates;

use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MahasiswaTemplateExport implements FromArray, WithHeadings, WithEvents, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        $sampleProdi = Prodi::first()?->nama_prodi ?? 'Teknik Informatika';

        return [
            ['10101010', 'Budi Santoso', 'Reg A', 2, 2024, $sampleProdi],
        ];
    }

    public function headings(): array
    {
        return [
            'nim',
            'nama',
            'kelas',
            'semester',
            'angkatan',
            'prodi',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '0F766E']]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Dropdown for Prodi dynamically from Database
                $prodis = Prodi::pluck('nama_prodi')->toArray();
                if (!empty($prodis)) {
                    $prodiList = '"' . implode(',', $prodis) . '"';
                    $validation = $sheet->getCell('F2')->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Prodi tidak valid');
                    $validation->setError('Harap pilih Program Studi dari daftar dropdown.');
                    $validation->setPromptTitle('Pilih Program Studi');
                    $validation->setPrompt('Pilih nama Program Studi dari daftar.');
                    $validation->setFormula1($prodiList);

                    $sheet->setDataValidation('F2:F1000', $validation);
                }

                // Add header guidance comments
                $sheet->getComment('A1')->getText()->createTextRun("NIM Mahasiswa. Wajib diisi & unik.");
                $sheet->getComment('B1')->getText()->createTextRun("Nama lengkap mahasiswa.");
                $sheet->getComment('C1')->getText()->createTextRun("Kelas mahasiswa (contoh: Reg A, Reg B, KAR A).");
                $sheet->getComment('D1')->getText()->createTextRun("Semester aktif mahasiswa (contoh: 1, 2, 3...).");
                $sheet->getComment('E1')->getText()->createTextRun("Tahun angkatan mahasiswa (contoh: 2024).");
                $sheet->getComment('F1')->getText()->createTextRun("Program Studi (Dinamis dari database).");
            },
        ];
    }
}

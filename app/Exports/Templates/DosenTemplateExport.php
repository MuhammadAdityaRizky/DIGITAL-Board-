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

class DosenTemplateExport implements FromArray, WithHeadings, WithEvents, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            ['198501012010121001', 'Dr. Budi Santoso', 'Tetap', 'Lektor', Prodi::first()->nama_prodi ?? 'Teknik Informatika', 'Pemrograman Web'],
        ];
    }

    public function headings(): array
    {
        return [
            'nip',
            'nama',
            'status',
            'jabatan',
            'prodi',
            'kompetensi',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '0F766E']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $prodis = Prodi::pluck('nama_prodi')->toArray();
                if (!empty($prodis)) {
                    $prodiList = '"' . implode(',', $prodis) . '"';
                    $validation = $event->sheet->getDelegate()->getCell('E2')->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Prodi tidak valid');
                    $validation->setError('Harap pilih Prodi dari daftar dropdown.');
                    $validation->setPromptTitle('Pilih Prodi');
                    $validation->setPrompt('Pilih nama Prodi dari daftar.');
                    $validation->setFormula1($prodiList);

                    $event->sheet->getDelegate()->setDataValidation('E2:E1000', $validation);
                }

                $event->sheet->getDelegate()->getComment('A1')->getText()->createTextRun("Isi dengan angka unik (NIP dosen). Wajib diisi.");
                $event->sheet->getDelegate()->getComment('C1')->getText()->createTextRun("Contoh: Tetap, Honorer, LB");
            },
        ];
    }
}

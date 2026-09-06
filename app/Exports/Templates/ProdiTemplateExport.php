<?php

namespace App\Exports\Templates;

use App\Models\Fakultas;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProdiTemplateExport implements FromArray, WithHeadings, WithEvents, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            ['Teknik Informatika', Fakultas::first()->nama_fakultas ?? 'Fakultas Ilmu Komputer', 'aktif'],
        ];
    }

    public function headings(): array
    {
        return [
            'nama_prodi',
            'fakultas',
            'status',
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
                $fakultas = Fakultas::pluck('nama_fakultas')->toArray();
                if (!empty($fakultas)) {
                    $fakultasList = '"' . implode(',', $fakultas) . '"';
                    $validation = $event->sheet->getDelegate()->getCell('B2')->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Fakultas tidak valid');
                    $validation->setError('Harap pilih Fakultas dari daftar dropdown.');
                    $validation->setPromptTitle('Pilih Fakultas');
                    $validation->setPrompt('Pilih nama Fakultas dari daftar.');
                    $validation->setFormula1($fakultasList);

                    $event->sheet->getDelegate()->setDataValidation('B2:B1000', $validation);
                }

                $event->sheet->getDelegate()->getComment('A1')->getText()->createTextRun("Nama unik Program Studi.");
                $event->sheet->getDelegate()->getComment('C1')->getText()->createTextRun("Isi dengan 'aktif' atau 'nonaktif'.");
            },
        ];
    }
}

<?php

namespace App\Exports\Templates;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AbsensiGlobalTemplateExport implements FromArray, WithHeadings, WithEvents, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            ['10101010', 'Budi Santoso', 'Hadir', 'Izin', 'Hadir'],
            ['10101011', 'Andi Pratama', 'Sakit', 'Hadir', 'Alpa'],
        ];
    }

    public function headings(): array
    {
        return [
            'NIM',
            'NAMA',
            '01/09/2026',
            '08/09/2026',
            '15/09/2026',
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
                $statusList = '"Hadir,Izin,Sakit,Alpa,Terlambat"';
                $validation = $event->sheet->getDelegate()->getCell('C2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(true);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Status tidak valid');
                $validation->setError('Harap pilih status dari daftar dropdown.');
                $validation->setPromptTitle('Pilih Status');
                $validation->setPrompt('Pilih status kehadiran.');
                $validation->setFormula1($statusList);

                // Apply to column C to Z, row 2 to 1000
                $event->sheet->getDelegate()->setDataValidation('C2:Z1000', $validation);

                $event->sheet->getDelegate()->getComment('C1')->getText()->createTextRun("Ganti header ini dengan tanggal pertemuan (format bebas, misal 01/09/2026 atau Pertemuan 1). Anda bisa menambah kolom tanggal ke kanan sebanyak-banyaknya.");
            },
        ];
    }
}

<?php

namespace App\Exports\Templates;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MataKuliahTemplateExport implements FromArray, WithHeadings, WithEvents, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            ['IF201', 'Pemrograman Web', 'Teknik Informatika'],
            ['SI302', 'Basis Data Lanjut', 'Sistem Informasi'],
        ];
    }

    public function headings(): array
    {
        return [
            'kode_mk',
            'nama_mk',
            'nama_prodi',
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
                $event->sheet->getDelegate()->getComment('A1')->getText()->createTextRun("Kode Mata Kuliah. Opsional.");
                $event->sheet->getDelegate()->getComment('B1')->getText()->createTextRun("Nama Mata Kuliah. Wajib diisi.");
                $event->sheet->getDelegate()->getComment('C1')->getText()->createTextRun("Nama Program Studi (Opsional, sesuaikan dengan data Prodi).");
            },
        ];
    }
}

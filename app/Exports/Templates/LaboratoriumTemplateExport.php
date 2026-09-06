<?php

namespace App\Exports\Templates;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaboratoriumTemplateExport implements FromArray, WithHeadings, WithEvents, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            ['Lab Komputer Dasar', '40', 'Gedung A Lantai 1', 'aktif'],
        ];
    }

    public function headings(): array
    {
        return [
            'nama_lab',
            'kapasitas',
            'lokasi',
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
                $event->sheet->getDelegate()->getComment('A1')->getText()->createTextRun("Nama unik dari Laboratorium.");
                $event->sheet->getDelegate()->getComment('B1')->getText()->createTextRun("Angka jumlah maksimal mahasiswa di lab ini.");
                $event->sheet->getDelegate()->getComment('D1')->getText()->createTextRun("Isi dengan 'aktif' atau 'nonaktif'.");
            },
        ];
    }
}

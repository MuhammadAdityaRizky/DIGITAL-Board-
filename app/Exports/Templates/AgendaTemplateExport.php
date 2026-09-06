<?php

namespace App\Exports\Templates;

use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Laboratorium;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AgendaTemplateExport implements FromArray, WithEvents, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            ['Dosen :', Dosen::first()->nama ?? 'Pilih Dosen'],
            ['Mata Kuliah :', 'Pemrograman Web'],
            ['Program Studi :', Prodi::first()->nama_prodi ?? 'Pilih Prodi'],
            ['Semester / Kelas :', '1 / Reguler A'],
            ['Laboratorium :', Laboratorium::first()->nama_lab ?? 'Pilih Laboratorium'],
            [''],
            ['No', 'Tanggal', 'Jam Mulai', 'Jam Selesai', 'Materi'],
            ['1', '2026-09-01', '08:00', '10:00', 'Pengenalan Dasar'],
            ['2', '2026-09-08', '08:00', '10:00', 'Materi Lanjutan'],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
            3 => ['font' => ['bold' => true]],
            4 => ['font' => ['bold' => true]],
            5 => ['font' => ['bold' => true]],
            7 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '0F766E']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Dropdown Dosen (using hidden column to support commas)
                $dosens = Dosen::pluck('nama')->toArray();
                if (!empty($dosens)) {
                    $row = 1;
                    foreach($dosens as $dosen) {
                        $event->sheet->getDelegate()->setCellValue('AA' . $row, $dosen);
                        $row++;
                    }
                    $event->sheet->getDelegate()->getColumnDimension('AA')->setVisible(false);

                    $valDosen = $event->sheet->getDelegate()->getCell('B1')->getDataValidation();
                    $valDosen->setType(DataValidation::TYPE_LIST);
                    $valDosen->setShowDropDown(true);
                    $valDosen->setFormula1('=$AA$1:$AA$' . ($row - 1));
                }

                // Dropdown Prodi
                $prodis = Prodi::pluck('nama_prodi')->toArray();
                if (!empty($prodis)) {
                    $row = 1;
                    foreach($prodis as $prodi) {
                        $event->sheet->getDelegate()->setCellValue('AB' . $row, $prodi);
                        $row++;
                    }
                    $event->sheet->getDelegate()->getColumnDimension('AB')->setVisible(false);

                    $valProdi = $event->sheet->getDelegate()->getCell('B3')->getDataValidation();
                    $valProdi->setType(DataValidation::TYPE_LIST);
                    $valProdi->setShowDropDown(true);
                    $valProdi->setFormula1('=$AB$1:$AB$' . ($row - 1));
                }

                // Dropdown Laboratorium
                $labs = Laboratorium::pluck('nama_lab')->toArray();
                if (!empty($labs)) {
                    $row = 1;
                    foreach($labs as $lab) {
                        $event->sheet->getDelegate()->setCellValue('AC' . $row, $lab);
                        $row++;
                    }
                    $event->sheet->getDelegate()->getColumnDimension('AC')->setVisible(false);

                    $valLab = $event->sheet->getDelegate()->getCell('B5')->getDataValidation();
                    $valLab->setType(DataValidation::TYPE_LIST);
                    $valLab->setShowDropDown(true);
                    $valLab->setFormula1('=$AC$1:$AC$' . ($row - 1));
                }
                
                $event->sheet->getDelegate()->getComment('B4')->getText()->createTextRun("Format: [Semester] / [Nama Kelas]. Contoh: 1 / Reguler A");
            },
        ];
    }
}

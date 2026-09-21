<?php

namespace App\Exports\Templates;

use App\Models\Fakultas;
use App\Models\Laboratorium;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaboratoriumTemplateExport implements FromArray, WithHeadings, WithEvents, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        $defaultFakultas = Fakultas::first()?->nama_fakultas ?? 'Fakultas Teknologi & Sains';
        $defaultLokasi = Laboratorium::whereNotNull('lokasi')->pluck('lokasi')->first() ?? 'Gedung FTS';

        return [
            ['Lab Komputer Dasar', 40, $defaultLokasi, $defaultFakultas, 'aktif'],
        ];
    }

    public function headings(): array
    {
        return [
            'nama_lab',
            'kapasitas',
            'lokasi',
            'fakultas',
            'status',
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

                // Dynamic Dropdown for Fakultas from Database
                $fakultas = Fakultas::pluck('nama_fakultas')->toArray();
                if (!empty($fakultas)) {
                    $fakultasList = '"' . implode(',', $fakultas) . '"';
                    $validationFak = $sheet->getCell('D2')->getDataValidation();
                    $validationFak->setType(DataValidation::TYPE_LIST);
                    $validationFak->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $validationFak->setAllowBlank(false);
                    $validationFak->setShowInputMessage(true);
                    $validationFak->setShowErrorMessage(true);
                    $validationFak->setShowDropDown(true);
                    $validationFak->setErrorTitle('Fakultas tidak valid');
                    $validationFak->setError('Harap pilih Fakultas dari daftar dropdown.');
                    $validationFak->setPromptTitle('Pilih Fakultas');
                    $validationFak->setPrompt('Pilih nama Fakultas naungan dari daftar.');
                    $validationFak->setFormula1($fakultasList);

                    $sheet->setDataValidation('D2:D1000', $validationFak);
                }

                // Dropdown for Status
                $validationStatus = $sheet->getCell('E2')->getDataValidation();
                $validationStatus->setType(DataValidation::TYPE_LIST);
                $validationStatus->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationStatus->setAllowBlank(false);
                $validationStatus->setShowInputMessage(true);
                $validationStatus->setShowErrorMessage(true);
                $validationStatus->setShowDropDown(true);
                $validationStatus->setErrorTitle('Status tidak valid');
                $validationStatus->setError('Harap pilih status (aktif/nonaktif).');
                $validationStatus->setPromptTitle('Pilih Status');
                $validationStatus->setPrompt('Pilih status keaktifan lab.');
                $validationStatus->setFormula1('"aktif,nonaktif"');

                $sheet->setDataValidation('E2:E1000', $validationStatus);

                // Tooltip / Comments on Headers
                $sheet->getComment('A1')->getText()->createTextRun("Nama unik dari Laboratorium. Wajib diisi.");
                $sheet->getComment('B1')->getText()->createTextRun("Angka jumlah kapasitas maksimal mahasiswa.");
                $sheet->getComment('C1')->getText()->createTextRun("Gedung / Lokasi laboratorium berada (Dinamis dari database).");
                $sheet->getComment('D1')->getText()->createTextRun("Fakultas naungan laboratorium (Dinamis dari database).");
                $sheet->getComment('E1')->getText()->createTextRun("Pilih status 'aktif' atau 'nonaktif'.");
            },
        ];
    }
}

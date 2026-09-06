<?php

namespace App\Imports;

use App\Models\Agenda;
use App\Models\Absensi;
use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;

class KehadiranImport implements ToCollection
{
    protected $agenda;

    public function __construct(Agenda $agenda)
    {
        $this->agenda = $agenda;
    }

    public function collection(Collection $rows): void
    {
        if ($rows->isEmpty()) return;

        // Cari semua agenda yang berkaitan dengan kelas ini
        $relatedAgendas = Agenda::where('mata_kuliah', $this->agenda->mata_kuliah)
            ->where('kelas', $this->agenda->kelas)
            ->where('dosen_id', $this->agenda->dosen_id)
            ->where('program_kuliah', $this->agenda->program_kuliah)
            ->where('jurusan', $this->agenda->jurusan)
            ->get();

        // Buat map format tanggal ke ID Agenda
        $agendaDateMap = [];
        foreach ($relatedAgendas as $ag) {
            $date = Carbon::parse($ag->tanggal);
            $formats = [
                $date->format('d/m'),   // 23/02
                $date->format('j/n'),   // 23/2
                $date->format('d/m/Y'),
                $date->format('d-m-Y'),
                $date->format('Y-m-d')
            ];
            foreach ($formats as $fmt) {
                if (!isset($agendaDateMap[$fmt])) {
                    $agendaDateMap[$fmt] = $ag;
                }
            }
        }

        $headerRow = $rows->first()->toArray();
        $nimColIndex = -1;
        $dateColumnMap = []; // Map Column Index => Agenda Object
        
        foreach ($headerRow as $index => $col) {
            $colName = trim(strtolower($col ?? ''));
            if ($colName == 'nim' || $colName == 'npm' || $colName == 'nim/npm' || $colName == 'nim / npm') {
                $nimColIndex = $index;
            } else {
                $colTitle = trim($col ?? '');
                if (isset($agendaDateMap[$colTitle])) {
                    $dateColumnMap[$index] = $agendaDateMap[$colTitle];
                }
            }
        }

        if ($nimColIndex === -1) {
            throw new \Exception("Kolom NIM/NPM tidak ditemukan pada baris pertama Excel.");
        }

        if (empty($dateColumnMap)) {
            throw new \Exception("Tidak ditemukan kolom tanggal yang sesuai dengan agenda kelas ini.");
        }

        // Process rows (skip header)
        foreach ($rows->skip(1) as $row) {
            $nim = trim($row[$nimColIndex] ?? '');
            if (empty($nim)) continue;

            $mahasiswa = Mahasiswa::where('nim', $nim)->first();
            if (!$mahasiswa) continue;

            foreach ($dateColumnMap as $colIndex => $agendaTarget) {
                $statusCode = trim($row[$colIndex] ?? '');
                if ($statusCode === '') continue; // Kosong, lewati saja

                $statusStr = 'Alpa';
                $codeUpper = strtoupper($statusCode);
                if ($codeUpper == 'H' || $codeUpper == 'HADIR' || $codeUpper == 'V' || $codeUpper == '1') {
                    $statusStr = 'Hadir';
                } elseif ($codeUpper == 'I' || $codeUpper == 'IZIN') {
                    $statusStr = 'Izin';
                } elseif ($codeUpper == 'S' || $codeUpper == 'SAKIT') {
                    $statusStr = 'Sakit';
                } elseif ($codeUpper == 'T' || $codeUpper == 'TERLAMBAT') {
                    $statusStr = 'Terlambat';
                } elseif ($codeUpper == 'A' || $codeUpper == 'ALPA' || $codeUpper == '-') {
                    $statusStr = 'Alpa';
                } else {
                    $statusStr = 'Alpa';
                }

                $absensi = Absensi::firstOrNew([
                    'agenda_id' => $agendaTarget->id,
                    'mahasiswa_id' => $mahasiswa->id
                ]);

                $absensi->status_kehadiran = $statusStr;
                if (!$absensi->exists || !$absensi->waktu_masuk) {
                    $absensi->waktu_masuk = $agendaTarget->tanggal . ' ' . substr($agendaTarget->jam_mulai, 0, 8);
                }
                $absensi->save();
            }
        }
    }
}

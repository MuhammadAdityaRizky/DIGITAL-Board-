<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Fakultas;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PenggunaExport
{
    protected $authUser;
    protected $exportRole;
    protected $filters;

    public function __construct($authUser, string $exportRole = 'all', array $filters = [])
    {
        $this->authUser = $authUser;
        $this->exportRole = strtolower(trim($exportRole));
        $this->filters = $filters;
    }

    public function download(): StreamedResponse
    {
        $roleTitle = match ($this->exportRole) {
            'mahasiswa' => 'Mahasiswa',
            'dosen' => 'Dosen',
            'admin' => 'Admin',
            default => 'Semua_Pengguna',
        };

        $filename = "Export_Data_{$roleTitle}_" . date('Y-m-d_H-i-s') . ".xlsx";

        return new StreamedResponse(function () {
            $spreadsheet = $this->buildSpreadsheet();
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function buildSpreadsheet(): Spreadsheet
    {
        $query = User::with(['dosen.fakultas', 'dosen.prodi', 'mahasiswa.fakultas', 'mahasiswa.prodi', 'fakultas']);

        // Scope by admin fakultas
        if ($this->authUser->isAdminFakultas()) {
            $fakId = $this->authUser->fakultas_id;
            $query->where(function ($q) use ($fakId) {
                $q->where('users.fakultas_id', $fakId)
                  ->orWhereHas('dosen', fn($qd) => $qd->where('id_fakultas', $fakId))
                  ->orWhereHas('mahasiswa', fn($qm) => $qm->where('id_fakultas', $fakId));
            });
        } elseif (!empty($this->filters['fakultas_id'])) {
            $fakId = (int)$this->filters['fakultas_id'];
            $query->where(function ($q) use ($fakId) {
                $q->where('users.fakultas_id', $fakId)
                  ->orWhereHas('dosen', fn($qd) => $qd->where('id_fakultas', $fakId))
                  ->orWhereHas('mahasiswa', fn($qm) => $qm->where('id_fakultas', $fakId));
            });
        }

        // Apply Export Role Filter
        if ($this->exportRole === 'mahasiswa') {
            $query->where('role', 'mahasiswa');
        } elseif ($this->exportRole === 'dosen') {
            $query->where('role', 'dosen');
        } elseif ($this->exportRole === 'admin') {
            $query->whereIn('role', ['admin', 'super_admin']);
        }

        // Search query
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', function ($qm) use ($search) {
                      $qm->where('nama_lengkap', 'like', "%{$search}%")
                         ->orWhere('nim', 'like', "%{$search}%");
                  })
                  ->orWhereHas('dosen', function ($qd) use ($search) {
                      $qd->where('nama', 'like', "%{$search}%")
                         ->orWhere('nip', 'like', "%{$search}%");
                  });
            });
        }

        // Additional Mahasiswa Filters
        if ($this->exportRole === 'mahasiswa' || $this->exportRole === 'all') {
            if (!empty($this->filters['program_kuliah'])) {
                $prog = $this->filters['program_kuliah'];
                $query->whereHas('mahasiswa', fn($q) => $q->where('program_kuliah', 'like', "%{$prog}%"));
            }

            if (!empty($this->filters['semester'])) {
                $sem = $this->filters['semester'];
                $query->whereHas('mahasiswa', fn($q) => $q->where('semester', $sem));
            }

            if (!empty($this->filters['kelas'])) {
                $kls = $this->filters['kelas'];
                $query->whereHas('mahasiswa', fn($q) => $q->where('kelas', 'like', "%{$kls}%"));
            }

            if (!empty($this->filters['status_mahasiswa'])) {
                $st = strtolower($this->filters['status_mahasiswa']);
                $query->whereHas('mahasiswa', fn($q) => $q->where('status', $st));
            }
        }

        $users = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pengguna');
        $sheet->setShowGridLines(true);

        // Header Titles & Layout
        $roleLabel = match ($this->exportRole) {
            'mahasiswa' => 'MAHASISWA',
            'dosen' => 'DOSEN',
            'admin' => 'ADMIN / ADMINISTRATOR',
            default => 'SEMUA PENGGUNA',
        };

        // Title Row 1-2
        $sheet->setCellValue('A1', 'LAPORAN DATA PENGGUNA TERDAFTAR (' . $roleLabel . ')');
        $sheet->setCellValue('A2', 'DIHASILKAN PADA: ' . date('d F Y H:i:s') . ' | TOTAL DATA: ' . $users->count() . ' BARIS');

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('001D3D'));
        $sheet->getStyle('A2')->getFont()->setSize(9)->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('64748B'));

        // Table Headings setup
        $rowStart = 4;

        if ($this->exportRole === 'mahasiswa') {
            $headers = ['NO', 'NIM / USERNAME', 'NAMA LENGKAP', 'EMAIL', 'FAKULTAS', 'PROGRAM STUDI', 'PROGRAM KULIAH', 'SEMESTER', 'KELAS', 'STATUS MAHASISWA', 'STATUS AKUN'];
        } elseif ($this->exportRole === 'dosen') {
            $headers = ['NO', 'NIP / KODE DOSEN', 'NAMA LENGKAP', 'EMAIL', 'FAKULTAS', 'PROGRAM STUDI', 'JABATAN', 'KOMPETENSI', 'STATUS AKUN'];
        } elseif ($this->exportRole === 'admin') {
            $headers = ['NO', 'USERNAME / NIP', 'NAMA LENGKAP', 'EMAIL', 'ROLE AKUN', 'FAKULTAS', 'STATUS AKUN'];
        } else {
            $headers = ['NO', 'USERNAME / NIM / NIP', 'NAMA LENGKAP', 'EMAIL', 'ROLE AKUN', 'FAKULTAS', 'PROGRAM STUDI', 'SEMESTER / KELAS / JABATAN', 'STATUS AKUN'];
        }

        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headers));

        // Merge title rows
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->mergeCells("A2:{$lastCol}2");

        // Write Table Header
        foreach ($headers as $colIdx => $headerText) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx + 1);
            $cellRef = "{$colLetter}{$rowStart}";
            $sheet->setCellValue($cellRef, $headerText);
        }

        // Table Header Styling
        $headerRange = "A{$rowStart}:{$lastCol}{$rowStart}";
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 10,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0F766E'], // Teal Header
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '0D9488'],
                ],
            ],
        ]);
        $sheet->getRowDimension($rowStart)->setRowHeight(26);

        // Write Data Rows
        $currRow = $rowStart + 1;
        $no = 1;

        foreach ($users as $u) {
            $sheet->getRowDimension($currRow)->setRowHeight(20);

            if ($this->exportRole === 'mahasiswa') {
                $sheet->setCellValue("A{$currRow}", $no);
                $sheet->setCellValueExplicit("B{$currRow}", $u->mahasiswa?->nim ?? $u->username, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue("C{$currRow}", $u->mahasiswa?->nama_lengkap ?? $u->username);
                $sheet->setCellValue("D{$currRow}", $u->email ?? '-');
                $sheet->setCellValue("E{$currRow}", $u->mahasiswa?->fakultas?->nama_fakultas ?? $u->fakultas?->nama_fakultas ?? '-');
                $sheet->setCellValue("F{$currRow}", $u->mahasiswa?->prodi?->nama_prodi ?? '-');
                $sheet->setCellValue("G{$currRow}", $u->mahasiswa?->program_kuliah ?? 'Reguler');
                $sheet->setCellValue("H{$currRow}", $u->mahasiswa?->semester ?? '-');
                $sheet->setCellValue("I{$currRow}", $u->mahasiswa?->kelas ?? '-');
                $sheet->setCellValue("J{$currRow}", ucfirst($u->mahasiswa?->status ?? 'aktif'));
                $sheet->setCellValue("K{$currRow}", ucfirst($u->status ?? 'aktif'));
            } elseif ($this->exportRole === 'dosen') {
                $sheet->setCellValue("A{$currRow}", $no);
                $sheet->setCellValueExplicit("B{$currRow}", $u->dosen?->nip ?? $u->username, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue("C{$currRow}", $u->dosen?->nama ?? $u->username);
                $sheet->setCellValue("D{$currRow}", $u->email ?? '-');
                $sheet->setCellValue("E{$currRow}", $u->dosen?->fakultas?->nama_fakultas ?? $u->fakultas?->nama_fakultas ?? '-');
                $sheet->setCellValue("F{$currRow}", $u->dosen?->prodi?->nama_prodi ?? '-');
                $sheet->setCellValue("G{$currRow}", $u->dosen?->jabatan ?? '-');
                $sheet->setCellValue("H{$currRow}", $u->dosen?->kompetensi ?? '-');
                $sheet->setCellValue("I{$currRow}", ucfirst($u->status ?? 'aktif'));
            } elseif ($this->exportRole === 'admin') {
                $sheet->setCellValue("A{$currRow}", $no);
                $sheet->setCellValueExplicit("B{$currRow}", $u->username, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue("C{$currRow}", $u->username);
                $sheet->setCellValue("D{$currRow}", $u->email ?? '-');
                $sheet->setCellValue("E{$currRow}", $u->isSuperAdmin() ? 'Super Admin' : 'Admin Fakultas');
                $sheet->setCellValue("F{$currRow}", $u->fakultas?->nama_fakultas ?? ($u->isSuperAdmin() ? 'Semua Fakultas' : '-'));
                $sheet->setCellValue("G{$currRow}", ucfirst($u->status ?? 'aktif'));
            } else {
                $nama = $u->mahasiswa?->nama_lengkap ?? $u->dosen?->nama ?? $u->username;
                $nimNip = $u->mahasiswa?->nim ?? $u->dosen?->nip ?? $u->username;
                $fakultas = $u->mahasiswa?->fakultas?->nama_fakultas ?? $u->dosen?->fakultas?->nama_fakultas ?? $u->fakultas?->nama_fakultas ?? '-';
                $prodi = $u->mahasiswa?->prodi?->nama_prodi ?? $u->dosen?->prodi?->nama_prodi ?? '-';
                
                $detail = '-';
                if ($u->role === 'mahasiswa') {
                    $detail = 'Sem ' . ($u->mahasiswa?->semester ?? '-') . ' / Kls ' . ($u->mahasiswa?->kelas ?? '-');
                } elseif ($u->role === 'dosen') {
                    $detail = $u->dosen?->jabatan ?? 'Dosen';
                }

                $sheet->setCellValue("A{$currRow}", $no);
                $sheet->setCellValueExplicit("B{$currRow}", $nimNip, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue("C{$currRow}", $nama);
                $sheet->setCellValue("D{$currRow}", $u->email ?? '-');
                $sheet->setCellValue("E{$currRow}", ucfirst(str_replace('_', ' ', $u->role)));
                $sheet->setCellValue("F{$currRow}", $fakultas);
                $sheet->setCellValue("G{$currRow}", $prodi);
                $sheet->setCellValue("H{$currRow}", $detail);
                $sheet->setCellValue("I{$currRow}", ucfirst($u->status ?? 'aktif'));
            }

            // Alternating Row Background
            $rowRange = "A{$currRow}:{$lastCol}{$currRow}";
            $bgColor = ($no % 2 === 0) ? 'F8FAFC' : 'FFFFFF';
            $sheet->getStyle($rowRange)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $bgColor],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E2E8F0'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Center align NO
            $sheet->getStyle("A{$currRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $no++;
            $currRow++;
        }

        // Auto-fit Column Widths
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        return $spreadsheet;
    }
}

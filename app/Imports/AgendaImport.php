<?php

namespace App\Imports;

use App\Models\Agenda;
use App\Models\Dosen;
use App\Models\Laboratorium;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AgendaImport implements ToModel, WithHeadingRow
{
    public function model(array $row): \Illuminate\Database\Eloquent\Model|array|null
    {
        // Normalize keys to lowercase string array
        $rowNormalized = [];
        foreach ($row as $k => $v) {
            $keyClean = strtolower(trim(str_replace([' ', '-'], '_', (string)$k)));
            $rowNormalized[$keyClean] = $v;
        }

        // Identify Course Title
        $mataKuliah = $rowNormalized['mata_kuliah'] 
            ?? $rowNormalized['matakuliah'] 
            ?? $rowNormalized['materi'] 
            ?? $rowNormalized['judul_agenda'] 
            ?? $rowNormalized['judul'] 
            ?? $rowNormalized['course'] 
            ?? $rowNormalized['nama_matakuliah'] 
            ?? null;

        if (!$mataKuliah) {
            return null;
        }

        // Match Dosen Mengajar (Primary Dosen)
        $dosenId = null;
        $nipDosen = $rowNormalized['nip_dosen'] ?? $rowNormalized['nip'] ?? null;
        $namaDosen = $rowNormalized['nama_dosen'] ?? $rowNormalized['dosen'] ?? $rowNormalized['dosen_mengajar'] ?? $rowNormalized['pengajar'] ?? null;

        if ($nipDosen) {
            $dosen = Dosen::where('nip', trim((string)$nipDosen))->first();
            if ($dosen) $dosenId = $dosen->id;
        }

        if (!$dosenId && $namaDosen) {
            $dosen = Dosen::where('nama', 'like', '%' . trim((string)$namaDosen) . '%')->first();
            if ($dosen) $dosenId = $dosen->id;
        }

        $dosenId = $dosenId ?? ($rowNormalized['dosen_id'] ?? null);

        // Fallback to first Dosen in DB if no dosen specified or matched
        if (!$dosenId) {
            $dosenId = Dosen::first()?->id;
        }

        // Match Dosen Pengampu (Optional)
        $dosenPengampuId = null;
        $nipPengampu = $rowNormalized['nip_dosen_pengampu'] ?? $rowNormalized['nip_pengampu'] ?? null;
        $namaPengampu = $rowNormalized['nama_dosen_pengampu'] ?? $rowNormalized['dosen_pengampu'] ?? $rowNormalized['pengampu'] ?? null;

        if ($nipPengampu) {
            $dosenP = Dosen::where('nip', trim((string)$nipPengampu))->first();
            if ($dosenP) $dosenPengampuId = $dosenP->id;
        }

        if (!$dosenPengampuId && $namaPengampu) {
            $dosenP = Dosen::where('nama', 'like', '%' . trim((string)$namaPengampu) . '%')->first();
            if ($dosenP) $dosenPengampuId = $dosenP->id;
        }

        $dosenPengampuId = $dosenPengampuId ?? ($rowNormalized['dosen_pengampu_id'] ?? null);

        // Match Lab
        $labId = null;
        $namaLab = $rowNormalized['nama_lab'] ?? $rowNormalized['lab'] ?? $rowNormalized['laboratorium'] ?? $rowNormalized['ruang'] ?? $rowNormalized['ruangan'] ?? null;

        if ($namaLab) {
            $lab = Laboratorium::where('nama_lab', 'like', '%' . trim((string)$namaLab) . '%')->first();
            if ($lab) $labId = $lab->id;
        }

        $labId = $labId ?? ($rowNormalized['lab_id'] ?? null);

        // Fallback to first Lab in DB if no lab specified or matched
        if (!$labId) {
            $labId = Laboratorium::first()?->id;
        }

        if (!$dosenId || !$labId) {
            return null; // Skip if no Dosen or Lab exist in database
        }

        // Parse Date
        $rawTanggal = $rowNormalized['tanggal'] ?? $rowNormalized['tgl'] ?? $rowNormalized['date'] ?? null;
        if ($rawTanggal) {
            if (is_numeric($rawTanggal)) {
                $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rawTanggal)->format('Y-m-d');
            } else {
                $tanggal = date('Y-m-d', strtotime((string)$rawTanggal));
            }
        } else {
            $tanggal = date('Y-m-d');
        }

        // Parse Times
        $rawJamMulai = $rowNormalized['jam_mulai'] ?? $rowNormalized['waktu_mulai'] ?? $rowNormalized['waktu_masuk'] ?? $rowNormalized['mulai'] ?? '08:00';
        $rawJamSelesai = $rowNormalized['jam_selesai'] ?? $rowNormalized['waktu_selesai'] ?? $rowNormalized['waktu_keluar'] ?? $rowNormalized['selesai'] ?? '10:00';

        $jam_mulai = date('H:i:s', strtotime((string)$rawJamMulai));
        $jam_selesai = date('H:i:s', strtotime((string)$rawJamSelesai));

        $programKuliah = $rowNormalized['program_kuliah'] ?? $rowNormalized['program'] ?? 'Reguler';
        $jenisPertemuan = $rowNormalized['jenis_pertemuan'] ?? $rowNormalized['tipe'] ?? 'Praktikum';
        $kelas = $rowNormalized['kelas'] ?? null;
        $semester = $rowNormalized['semester'] ?? null;
        $jurusan = $rowNormalized['jurusan'] ?? $rowNormalized['prodi'] ?? $rowNormalized['program_studi'] ?? null;
        $fakultas = $rowNormalized['fakultas'] ?? null;
        $statusAgenda = $rowNormalized['status_agenda'] ?? $rowNormalized['status'] ?? 'Akan Datang';
        $catatan = $rowNormalized['catatan'] ?? $rowNormalized['rencana_pembelajaran'] ?? null;

        return new Agenda([
            'dosen_id' => $dosenId,
            'dosen_pengampu_id' => $dosenPengampuId,
            'lab_id' => $labId,
            'mata_kuliah' => trim((string)$mataKuliah),
            'program_kuliah' => trim((string)$programKuliah),
            'jenis_pertemuan' => trim((string)$jenisPertemuan),
            'kelas' => $kelas ? trim((string)$kelas) : null,
            'semester' => $semester ? trim((string)$semester) : null,
            'jurusan' => $jurusan ? trim((string)$jurusan) : null,
            'fakultas' => $fakultas ? trim((string)$fakultas) : null,
            'tanggal' => $tanggal,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
            'status_agenda' => trim((string)$statusAgenda),
            'catatan' => $catatan ? trim((string)$catatan) : null,
        ]);
    }
}

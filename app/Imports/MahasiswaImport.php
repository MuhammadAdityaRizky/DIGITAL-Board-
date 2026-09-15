<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;
use Illuminate\Support\Facades\Cache;

class MahasiswaImport implements ToModel, WithHeadingRow, ShouldQueue, WithChunkReading, WithEvents
{
    use Importable;

    public $importId;
    public ?int $defaultFakultasId;

    public function __construct($importId, ?int $defaultFakultasId = null)
    {
        $this->importId = $importId;
        $this->defaultFakultasId = $defaultFakultasId;
    }

    public function chunkSize(): int
    {
        return 50; 
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $totalRows = $event->reader->getTotalRows();
                $total = !empty($totalRows) ? array_values($totalRows)[0] : 0;
                Cache::put('import_total_' . $this->importId, $total, now()->addHours(1));
                Cache::put('import_progress_' . $this->importId, 0, now()->addHours(1));
                Cache::put('import_status_' . $this->importId, 'processing', now()->addHours(1));
            },
            AfterImport::class => function (AfterImport $event) {
                Cache::put('import_status_' . $this->importId, 'completed', now()->addHours(1));
            },
        ];
    }

    public function model(array $row): \Illuminate\Database\Eloquent\Model|array|null
    {
        // Pastikan NIM ada dan belum terdaftar di tabel mahasiswa
        if (!isset($row['nim'])) {
            return null;
        }

        $id_prodi = $row['id_prodi'] ?? null;
        $id_fakultas = $this->defaultFakultasId ?: ($row['id_fakultas'] ?? null);

        if (empty($id_prodi) && !empty($row['prodi'])) {
            $prodiQuery = \App\Models\Prodi::where('nama_prodi', 'like', '%' . $row['prodi'] . '%');
            if ($this->defaultFakultasId) {
                $prodiQuery->where('fakultas_id', $this->defaultFakultasId);
            }
            $prodi = $prodiQuery->first();
            if ($prodi) {
                $id_prodi = $prodi->id;
                $id_fakultas = $prodi->fakultas_id ?? $id_fakultas;
            }
        }

        if (empty($id_fakultas) && !empty($row['fakultas'])) {
            $fak = \App\Models\Fakultas::where('nama_fakultas', 'like', '%' . $row['fakultas'] . '%')->first();
            if ($fak) {
                $id_fakultas = $fak->id;
            }
        }

        $existingMahasiswa = Mahasiswa::where('nim', $row['nim'])->first();
        if ($existingMahasiswa) {
            return null; // Skip jika sudah ada
        }

        // Cek atau buat User
        $user = User::firstOrCreate(
            ['username' => $row['nim']],
            [
                'password' => Hash::make($row['nim']), // Default password adalah NIM
                'role' => 'mahasiswa',
                'fakultas_id' => $id_fakultas,
            ]
        );

        if ($id_fakultas && !$user->fakultas_id) {
            $user->update(['fakultas_id' => $id_fakultas]);
        }

        $semester = $row['semester'] ?? null;

        if (empty($semester) && !empty($row['angkatan'])) {
            $angkatan = (int) $row['angkatan'];
            $currentYear = (int) date('Y');
            $currentMonth = (int) date('m');
            
            // Rumus semester: ((Tahun Sekarang - Tahun Masuk) * 2) + (Bulan >= 8 ? 1 : 0)
            // Semester ganjil biasanya dimulai bulan Agustus/September
            $semester = (($currentYear - $angkatan) * 2) + ($currentMonth >= 8 ? 1 : 0);
            
            // Jika hasil kurang dari 1, set minimal 1
            if ($semester < 1) {
                $semester = 1;
            }
        }

        $programKuliah = 'Reguler';
        $kelasAsli = 'A';
        
        if (isset($row['kelas'])) {
            $k = strtoupper(trim($row['kelas']));
            if (str_contains($k, 'KARYAWAN')) {
                $programKuliah = 'Karyawan';
            } elseif (str_contains($k, 'REGULER')) {
                $programKuliah = 'Reguler';
            }
            
            // Extract class letter if exists (e.g., Karyawan A)
            if (preg_match('/(A|B|C|D)/', $k, $matches)) {
                $kelasAsli = $matches[1];
            }
        }

        $model = new Mahasiswa([
            'user_id' => $user->id,
            'nim' => $row['nim'],
            'nama_lengkap' => $row['nama_lengkap'] ?? $row['nama'],
            'id_fakultas' => $id_fakultas,
            'id_prodi' => $id_prodi,
            'program_kuliah' => $programKuliah,
            'kelas' => $kelasAsli,
            'semester' => $semester ?? 1,
        ]);

        Cache::increment('import_progress_' . $this->importId);

        return $model;
    }
}

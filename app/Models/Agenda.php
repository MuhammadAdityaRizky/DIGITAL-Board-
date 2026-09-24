<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use LogsActivity;

    protected $table = 'agenda';
    public $timestamps = false;
    protected $guarded = [];

    public function jadwalPenggunaanLab()
    {
        return $this->belongsTo(JadwalPenggunaanLab::class, 'jadwal_penggunaan_lab_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function dosenPengampu()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pengampu_id');
    }

    public function lab()
    {
        return $this->belongsTo(Laboratorium::class, 'lab_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * Query Mahasiswa presisi berdasarkan Prodi, Semester, Program Kuliah, dan Kelas
     */
    public function getStudentsQuery()
    {
        $query = Mahasiswa::with(['prodi', 'fakultas'])->where('status', 'aktif');

        // 1. Prodi / Jurusan
        if (!empty($this->jurusan)) {
            $jurusan = trim($this->jurusan);
            $query->whereHas('prodi', function($q) use ($jurusan) {
                $q->where('nama_prodi', 'like', "%{$jurusan}%");
            });
        }

        // 2. Semester
        if (!empty($this->semester)) {
            $semNum = (int) preg_replace('/[^0-9]/', '', $this->semester);
            if ($semNum > 0) {
                $query->where('semester', $semNum);
            }
        }

        // 3. Program Kuliah (Reguler vs Karyawan)
        $isKaryawan = strcasecmp($this->program_kuliah ?? '', 'karyawan') === 0;

        if ($isKaryawan) {
            $query->where(function($q) {
                $q->where('program_kuliah', 'like', '%Karyawan%')
                  ->orWhere('kelas', 'like', '%Karyawan%')
                  ->orWhere('kelas', 'KAR');
            });
        } else {
            // Reguler
            $query->where(function($q) {
                $q->where('program_kuliah', 'like', '%Reguler%')
                  ->orWhereNull('program_kuliah');
            });

            // 4. Kelas for Reguler
            if (!empty($this->kelas)) {
                $rawKelas = trim($this->kelas);
                if (preg_match('/^[A-Z]$/i', $rawKelas)) {
                    $letter = strtoupper($rawKelas);
                    $query->where(function($q) use ($letter) {
                        $q->where('kelas', $letter)
                          ->orWhere('kelas', 'like', "% {$letter}")
                          ->orWhere('kelas', 'like', "{$letter} %")
                          ->orWhere('kelas', 'like', "%-{$letter}");
                        if ($letter === 'A') {
                            $q->orWhere('kelas', 'Reguler');
                        }
                    });
                } else {
                    $query->where('kelas', 'like', "%{$rawKelas}%");
                }
            }
        }

        return $query;
    }

    /**
     * Get the academic year / tahun ajaran for this agenda (e.g. "2026/2027").
     */
    public function getTahunAjaranAttribute()
    {
        $raw = $this->tahun_akademik ?? $this->jadwalPenggunaanLab?->tahun_akademik ?? '2026/2027 Ganjil';
        if (preg_match('/(\d{4}\/\d{4})/', $raw, $matches)) {
            return $matches[1];
        }
        return $raw ?: '2026/2027';
    }

    /**
     * Get Indonesian day name for this agenda (e.g. "Senin", "Rabu").
     */
    public function getHariAttribute()
    {
        if (!$this->tanggal) return '-';
        $dayNames = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $c = \Carbon\Carbon::parse($this->tanggal);
        return $dayNames[$c->format('l')] ?? $c->format('l');
    }

    /**
     * Get Indonesian formatted day and date (e.g. "Rabu, 16 Sep 2026").
     */
    public function getHariTanggalAttribute()
    {
        if (!$this->tanggal) return '-';
        $dayNames = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        $c = \Carbon\Carbon::parse($this->tanggal);
        $hari = $dayNames[$c->format('l')] ?? $c->format('l');
        $bln = $monthNames[(int) $c->format('n')] ?? $c->format('M');
        return "{$hari}, " . $c->format('d') . " {$bln} " . $c->format('Y');
    }

    /**
     * Determine agenda status dynamically based on current date and time.
     */
    public function getStatusAgendaAttribute($value)
    {
        if ($value === 'Dibatalkan') {
            return 'Dibatalkan';
        }

        if ($value === 'Selesai') {
            return 'Selesai';
        }
        
        $now = now();
        $tanggal = \Carbon\Carbon::parse($this->tanggal);
        
        if ($tanggal->isPast() && !$tanggal->isToday()) {
            return 'Selesai';
        }
        
        if ($tanggal->isFuture() && !$tanggal->isToday()) {
            return 'Akan Datang';
        }
        
        // Today
        $currentTime = $now->format('H:i:s');
        if ($currentTime < $this->jam_mulai) {
            return 'Akan Datang';
        } elseif ($currentTime >= $this->jam_mulai && $currentTime <= $this->jam_selesai) {
            return 'Berlangsung';
        } else {
            return 'Selesai';
        }
    }

    /**
     * Generate a 5-second dynamic QR token for an agenda.
     * Example output: AGENDA_ID_15_A8F3
     */
    public static function generateDynamicQrToken($agendaId, $timestamp = null, $interval = 5)
    {
        $ts = $timestamp ?? time();
        $timeBlock = (int) floor($ts / $interval);
        $hash = strtoupper(substr(md5("DIGITAL_BOARD_SALT_{$agendaId}_{$timeBlock}"), 0, 4));
        return "AGENDA_ID_{$agendaId}_{$hash}";
    }

    /**
     * Validate a dynamic QR token against current and recent time windows.
     * Returns array ['agenda' => Agenda|null, 'error' => string|null]
     */
    public static function validateDynamicQrToken($token, $interval = 5, $tolerance = 2)
    {
        $token = trim($token);
        if (!$token) {
            return ['agenda' => null, 'error' => 'Token QR / Kode Presensi tidak boleh kosong.'];
        }

        $parts = explode('_', $token);
        $agendaId = null;
        $providedHash = null;

        if (count($parts) >= 4 && strtoupper($parts[0]) === 'AGENDA' && strtoupper($parts[1]) === 'ID') {
            $agendaId = $parts[2];
            $providedHash = strtoupper($parts[3]);
        } elseif (count($parts) == 3 && strtoupper($parts[0]) === 'AGENDA' && strtoupper($parts[1]) === 'ID') {
            // Received AGENDA_ID_15 without 5s hash
            return [
                'agenda' => null, 
                'error' => 'Token QR statis tidak berlaku. Silakan scan/masukkan Kode Presensi terbaru yang tampil di layar (refresh 5 detik).'
            ];
        } elseif (count($parts) == 2 && is_numeric($parts[0])) {
            $agendaId = $parts[0];
            $providedHash = strtoupper($parts[1]);
        } elseif (is_numeric($token)) {
            return [
                'agenda' => null, 
                'error' => 'Kode Presensi statis tidak berlaku. Silakan scan/masukkan Kode Presensi terbaru yang tampil di layar (refresh 5 detik).'
            ];
        }

        if (!$agendaId || !$providedHash) {
            return ['agenda' => null, 'error' => 'Format Token QR / Kode Presensi tidak valid.'];
        }

        $agenda = self::find($agendaId);
        if (!$agenda) {
            return ['agenda' => null, 'error' => 'Agenda tidak ditemukan.'];
        }

        $currentTs = time();
        $currentBlock = (int) floor($currentTs / $interval);

        for ($i = -$tolerance; $i <= 1; $i++) {
            $checkBlock = $currentBlock + $i;
            $expectedHash = strtoupper(substr(md5("DIGITAL_BOARD_SALT_{$agendaId}_{$checkBlock}"), 0, 4));
            if ($providedHash === $expectedHash) {
                return ['agenda' => $agenda, 'error' => null];
            }
        }

        return [
            'agenda' => null, 
            'error' => 'Kode Presensi / QR Code telah KADALUARSA (berubah setiap 5 detik). Silakan scan QR Code terbaru di layar!'
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get parsed Berita Acara details for display and official printing (FTS-LAB-P03-F-01).
     */
    public function getBeritaAcaraDetailsAttribute()
    {
        $raw = $this->berita_acara;
        $parsed = [];
        $isJson = false;

        if (!empty($raw) && is_string($raw)) {
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $parsed = $decoded;
                $isJson = true;
            }
        }

        // Format Indonesian Day and Date: e.g. "Senin / 23 Februari 2025"
        $dayNames = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $carbonDate = \Carbon\Carbon::parse($this->tanggal ?? now());
        $hariEn = $carbonDate->format('l');
        $hariId = $dayNames[$hariEn] ?? $hariEn;
        $tglStr = $carbonDate->format('j') . ' ' . ($monthNames[(int) $carbonDate->format('n')] ?? $carbonDate->format('F')) . ' ' . $carbonDate->format('Y');
        $hariTanggalIndo = "{$hariId} / {$tglStr}";

        // Calculate Duration in minutes
        $jamMulai = substr($this->jam_mulai ?? '08:00', 0, 5);
        $jamSelesai = substr($this->jam_selesai ?? '10:00', 0, 5);
        $durasiMenit = 120;
        try {
            $start = \Carbon\Carbon::parse($this->jam_mulai);
            $end = \Carbon\Carbon::parse($this->jam_selesai);
            $diff = $start->diffInMinutes($end);
            if ($diff > 0) $durasiMenit = $diff;
        } catch (\Exception $e) {}

        $waktuDurasi = "{$jamMulai} - {$jamSelesai} ({$durasiMenit} menit)";

        // Program Studi, Semester, Program Kuliah & Kelas dari Database
        $prodi = $this->jurusan ?: ($this->jadwalPenggunaanLab?->prodi?->nama_prodi ?: 'Sistem Informasi');
        $programKuliah = $this->program_kuliah ?: ($this->jadwalPenggunaanLab?->program_kuliah ?: 'Reguler');
        $kelasRaw = trim($this->kelas ?: ($this->jadwalPenggunaanLab?->kelas ?: ''));
        $semesterRaw = $this->semester ?: ($this->jadwalPenggunaanLab?->semester ?: '1');

        $isKaryawan = stripos($programKuliah, 'karyawan') !== false 
            || stripos($kelasRaw, 'karyawan') !== false 
            || stripos($kelasRaw, 'kar') !== false;

        $progLabel = $isKaryawan ? 'Karyawan' : 'Reguler';
        $cleanKelas = trim(preg_replace('/karyawan|kar|reguler|reg|\s+/i', ' ', $kelasRaw));
        $kelasSuffix = $cleanKelas ? " {$cleanKelas}" : ($kelasRaw ? " {$kelasRaw}" : '');

        $romanMap = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII'];
        $semRomawi = is_numeric($semesterRaw) && isset($romanMap[(int)$semesterRaw]) ? $romanMap[(int)$semesterRaw] : $semesterRaw;

        $defaultProdiSemesterKelas = "{$prodi} / {$semRomawi} {$progLabel}{$kelasSuffix}";
        $prodiSemesterKelas = !empty($parsed['prodi_semester_kelas']) ? $parsed['prodi_semester_kelas'] : $defaultProdiSemesterKelas;
        $semesterProgramKelas = "{$semRomawi} {$progLabel}{$kelasSuffix}";

        // Tahun Akademik dari Jadwal atau default aktif
        $tahunAjaran = '2025/2026';
        if (!empty($this->jadwalPenggunaanLab?->tahun_akademik)) {
            if (preg_match('/(\d{4}\/\d{4})/', $this->jadwalPenggunaanLab->tahun_akademik, $matches)) {
                $tahunAjaran = $matches[1];
            } else {
                $tahunAjaran = $this->jadwalPenggunaanLab->tahun_akademik;
            }
        }

        // Laboran (Prioritaskan override manual di JSON jika ada, fallback ke lab->nama_laboran)
        $laboranNama = !empty($parsed['laboran']) ? $parsed['laboran'] : ($this->lab->nama_laboran ?? '-');

        // Dosen Instruktur & Asisten Praktikum (Prioritaskan override manual di JSON jika ada, fallback ke relasi)
        $defaultDosenPengampu = $this->dosenPengampu->nama ?? $this->dosen->nama ?? '-';
        $defaultAsisten = $this->dosen->nama ?? '-';

        $dosenNama = !empty($parsed['dosen']) ? $parsed['dosen'] : $defaultDosenPengampu;
        $asistenNama = !empty($parsed['asisten']) ? $parsed['asisten'] : $defaultAsisten;

        // Check if Dosen Pengampu & Pengajar/Asisten are identical
        $isSameDosen = ($dosenNama === $asistenNama) || empty($asistenNama) || ($asistenNama === '-');

        return [
            'materi' => $parsed['materi'] ?? ($this->materi_realisasi ?: ($this->catatan ?: '')),
            'catatan' => $parsed['catatan'] ?? ($isJson ? '' : ($this->berita_acara ?: '')),
            'laboran' => $laboranNama,
            'asisten' => $asistenNama,
            'dosen' => $dosenNama,
            'is_same_dosen' => $isSameDosen,
            'tahun_ajaran' => $tahunAjaran,
            'hari_tanggal_indo' => $hariTanggalIndo,
            'waktu_durasi' => $waktuDurasi,
            'prodi' => $prodi,
            'semester' => $semesterRaw,
            'semester_romawi' => $semRomawi,
            'program_kuliah' => $progLabel,
            'kelas' => $cleanKelas ?: $kelasRaw,
            'semester_program_kelas' => $semesterProgramKelas,
            'prodi_semester_kelas' => $prodiSemesterKelas,
            'is_custom' => $isJson,
        ];
    }
}


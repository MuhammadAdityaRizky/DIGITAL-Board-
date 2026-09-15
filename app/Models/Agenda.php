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

        // Program Studi / Semester Kelas
        $prodi = $this->jurusan ?: 'Sistem Informasi';
        $semester = $this->semester ? "{$this->semester}" : 'IV';
        $kelas = $this->kelas ? " {$this->kelas}" : '';
        $prodiSemesterKelas = "{$prodi}/ {$semester}{$kelas}";

        // Tahun Akademik dari Jadwal atau default aktif
        $tahunAjaran = '2025/2026';
        if (!empty($this->jadwalPenggunaanLab?->tahun_akademik)) {
            if (preg_match('/(\d{4}\/\d{4})/', $this->jadwalPenggunaanLab->tahun_akademik, $matches)) {
                $tahunAjaran = $matches[1];
            } else {
                $tahunAjaran = $this->jadwalPenggunaanLab->tahun_akademik;
            }
        }

        // Laboran (Ketetapan Laboratorium FT UIKA)
        $laboranNama = 'Kurniawan S.T';

        // Dosen & Asisten Praktikum sesuai data jadwal resmi
        $dosenNama = $this->dosenPengampu->nama ?? $this->dosen->nama ?? 'Zulkarnaen Noor Syarif, S.Kom., M.Kom';
        $asistenNama = 'Anggra Triawan, S.Kom, M.Kom';

        if ($this->dosen_pengampu_id && $this->dosen_pengampu_id != $this->dosen_id) {
            $dosenNama = $this->dosenPengampu->nama ?? $dosenNama;
            $asistenNama = $this->dosen->nama ?? $asistenNama;
        } elseif ($this->dosen && str_contains($this->dosen->nama, 'Anggra')) {
            $dosenNama = $this->dosenPengampu->nama ?? 'Zulkarnaen Noor Syarif, S.Kom., M.Kom';
            $asistenNama = $this->dosen->nama;
        }

        return [
            'materi' => $parsed['materi'] ?? ($this->materi_realisasi ?: ($this->catatan ?: '')),
            'catatan' => $parsed['catatan'] ?? ($isJson ? '' : ($this->berita_acara ?: '')),
            'laboran' => $laboranNama,
            'asisten' => $asistenNama,
            'dosen' => $dosenNama,
            'tahun_ajaran' => $tahunAjaran,
            'hari_tanggal_indo' => $hariTanggalIndo,
            'waktu_durasi' => $waktuDurasi,
            'prodi_semester_kelas' => $prodiSemesterKelas,
            'is_custom' => $isJson,
        ];
    }
}


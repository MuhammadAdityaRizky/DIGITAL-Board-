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

}


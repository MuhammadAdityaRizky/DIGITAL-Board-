<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';
    public $timestamps = false;
    protected $guarded = [];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
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
}

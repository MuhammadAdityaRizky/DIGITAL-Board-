<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class JadwalPenggunaanLab extends Model
{
    use LogsActivity;

    protected $table = 'jadwal_penggunaan_lab';
    public $timestamps = false;
    protected $guarded = [];

    public function lab()
    {
        return $this->belongsTo(Laboratorium::class, 'lab_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function dosenPengampu()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pengampu_id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'jadwal_penggunaan_lab_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}

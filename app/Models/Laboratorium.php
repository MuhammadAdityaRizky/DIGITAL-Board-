<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Laboratorium extends Model
{
    use LogsActivity;

    protected $table = 'laboratorium';
    public $timestamps = false;
    protected $guarded = [];

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'lab_id');
    }

    public function pengumumans()
    {
        return $this->belongsToMany(Pengumuman::class, 'laboratorium_pengumuman', 'laboratorium_id', 'pengumuman_id')->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}


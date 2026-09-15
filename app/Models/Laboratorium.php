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

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function scopeForUser($query, $user)
    {
        if (!$user) {
            return $query;
        }

        if ($user->isSuperAdmin()) {
            return $query;
        }

        if ($user->isAdminFakultas() && $user->fakultas_id) {
            return $query->where('fakultas_id', $user->fakultas_id);
        }

        return $query;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}


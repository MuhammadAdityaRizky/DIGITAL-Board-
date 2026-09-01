<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use LogsActivity;

    protected $table = 'pengumuman';
    public $timestamps = false;
    protected $guarded = [];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function laboratoriums()
    {
        return $this->belongsToMany(Laboratorium::class, 'laboratorium_pengumuman', 'pengumuman_id', 'laboratorium_id')->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}


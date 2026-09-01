<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratorium extends Model
{
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
}

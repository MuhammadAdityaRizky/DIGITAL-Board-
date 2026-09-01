<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
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
}

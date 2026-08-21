<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = 'fakultas';
    public $timestamps = false;
    protected $guarded = [];

    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'fakultas_id');
    }

    public function dosen()
    {
        return $this->hasMany(Dosen::class, 'id_fakultas');
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'id_fakultas');
    }
}

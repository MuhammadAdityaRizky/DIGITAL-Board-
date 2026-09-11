<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';
    public $timestamps = false;
    protected $guarded = [];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }
}

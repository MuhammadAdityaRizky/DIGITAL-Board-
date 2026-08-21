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
}

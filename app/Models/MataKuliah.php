<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SemiBlockchainLedger;

class MataKuliah extends Model
{
    use SemiBlockchainLedger;
    protected $table = 'mata_kuliah';
    public $timestamps = false;
    protected $guarded = [];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }
}

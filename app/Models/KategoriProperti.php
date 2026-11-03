<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\SemiBlockchainLedger;

class KategoriProperti extends Model
{
    use HasFactory, LogsActivity, SemiBlockchainLedger;

    protected $table = 'kategori_properti';
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(KategoriProperti::class, 'parent_id');
    }

    public function subKategori()
    {
        return $this->hasMany(KategoriProperti::class, 'parent_id');
    }

    public function itemProperti()
    {
        return $this->hasMany(ItemPropertiLab::class, 'kategori_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\SemiBlockchainLedger;

class ItemPropertiLab extends Model
{
    use HasFactory, LogsActivity, SemiBlockchainLedger;

    protected $table = 'item_properti_lab';
    protected $guarded = [];

    protected $casts = [
        'harga' => 'decimal:2',
        'urutan' => 'integer',
    ];

    public function dokumen()
    {
        return $this->belongsTo(DokumenPropertiLab::class, 'dokumen_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriProperti::class, 'kategori_id');
    }

    public function subKategori()
    {
        return $this->belongsTo(KategoriProperti::class, 'sub_kategori_id');
    }

    public function riwayats()
    {
        return $this->hasMany(RiwayatPemeliharaanAlat::class, 'item_properti_id')
            ->orderBy('tanggal_mulai', 'asc')
            ->orderBy('id', 'asc');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}


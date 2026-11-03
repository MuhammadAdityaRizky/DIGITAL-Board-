<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\SemiBlockchainLedger;

class DokumenPropertiLab extends Model
{
    use HasFactory, LogsActivity, SemiBlockchainLedger;

    protected $table = 'dokumen_properti_lab';
    protected $guarded = [];

    protected $casts = [
        'tanggal_pendataan' => 'date',
    ];

    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class, 'lab_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(ItemPropertiLab::class, 'dokumen_id')->orderBy('urutan', 'asc')->orderBy('id', 'asc');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}


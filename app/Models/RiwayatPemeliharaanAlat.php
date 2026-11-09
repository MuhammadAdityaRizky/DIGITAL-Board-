<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\SemiBlockchainLedger;

class RiwayatPemeliharaanAlat extends Model
{
    use HasFactory, LogsActivity, SemiBlockchainLedger;

    protected $table = 'riwayat_pemeliharaan_alat';
    protected $guarded = [];

    protected static function booted()
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('riwayat_pemeliharaan_alat')) {
                \Illuminate\Support\Facades\Schema::create('riwayat_pemeliharaan_alat', function (\Illuminate\Database\Schema\Blueprint $table) {
                    $table->id();
                    $table->foreignId('item_properti_id')->constrained('item_properti_lab')->onDelete('cascade');
                    $table->text('tindakan');
                    $table->dateTime('tanggal_mulai');
                    $table->dateTime('tanggal_selesai')->nullable();
                    $table->string('paraf', 100)->nullable();
                    $table->text('keterangan')->nullable();
                    $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            // Ignore if already created or connection issue during early bootstrap
        }
    }

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function itemProperti()
    {
        return $this->belongsTo(ItemPropertiLab::class, 'item_properti_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}


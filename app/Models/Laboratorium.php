<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Laboratorium extends Model
{
    use LogsActivity;

    protected $table = 'laboratorium';
    public $timestamps = false;
    protected $guarded = [];

    protected static function booted()
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('laboratorium') && !\Illuminate\Support\Facades\Schema::hasColumn('laboratorium', 'nama_kepala_lab')) {
                \Illuminate\Support\Facades\Schema::table('laboratorium', function (\Illuminate\Database\Schema\Blueprint $table) {
                    $table->string('nama_kepala_lab', 150)->nullable();
                    $table->string('nip_kepala_lab', 50)->nullable();
                });
            }
        } catch (\Throwable $e) {
            // Silently ignore
        }
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'lab_id');
    }

    public function pengumumans()
    {
        return $this->belongsToMany(Pengumuman::class, 'laboratorium_pengumuman', 'laboratorium_id', 'pengumuman_id')->withTimestamps();
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function scopeForUser($query, $user)
    {
        if (!$user) {
            return $query;
        }

        if ($user->isSuperAdmin()) {
            return $query;
        }

        if ($user->isAdminFakultas() && $user->fakultas_id) {
            return $query->where('fakultas_id', $user->fakultas_id);
        }

        return $query;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}


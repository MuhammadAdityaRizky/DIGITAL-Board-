<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, LogsActivity;

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class);
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin' || ($this->role === 'admin' && is_null($this->fakultas_id));
    }

    public function isAdminFakultas(): bool
    {
        return $this->role === 'admin' && !is_null($this->fakultas_id);
    }

    public function canManageLab(?Laboratorium $lab): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (!$lab || !$this->fakultas_id) {
            return false;
        }

        return (int)$lab->fakultas_id === (int)$this->fakultas_id;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}

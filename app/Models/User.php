<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\SemiBlockchainLedger;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, LogsActivity, SemiBlockchainLedger;

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static ?bool $hasRememberTokenCol = null;

    /**
     * Cek apakah kolom remember_token ada di tabel users, jika belum coba buat otomatis.
     */
    public static function checkRememberTokenColumn(): bool
    {
        if (static::$hasRememberTokenCol !== null) {
            return static::$hasRememberTokenCol;
        }

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
                if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'remember_token')) {
                    try {
                        \Illuminate\Support\Facades\Schema::table('users', function (\Illuminate\Database\Schema\Blueprint $table) {
                            $table->rememberToken();
                        });
                        static::$hasRememberTokenCol = true;
                        return true;
                    } catch (\Throwable $e) {
                        try {
                            \Illuminate\Support\Facades\DB::statement("ALTER TABLE users ADD COLUMN remember_token VARCHAR(100) NULL");
                            static::$hasRememberTokenCol = true;
                            return true;
                        } catch (\Throwable $e2) {
                            static::$hasRememberTokenCol = false;
                            return false;
                        }
                    }
                }
                static::$hasRememberTokenCol = true;
                return true;
            }
        } catch (\Throwable $e) {
            // DB connection/schema exception
        }

        static::$hasRememberTokenCol = false;
        return false;
    }

    protected static function booted()
    {
        static::checkRememberTokenColumn();
    }

    /**
     * Dapatkan nama kolom remember token.
     * Jika database belum memiliki kolom ini dan tidak dapat dibuat, kembalikan string kosong
     * agar Laravel tidak mengeksekusi UPDATE yang menyebabkan QueryException: 1054 Unknown column.
     */
    public function getRememberTokenName()
    {
        return static::checkRememberTokenColumn() ? 'remember_token' : '';
    }

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

    public function isAdmin(): bool
    {
        return $this->isSuperAdmin() || $this->isAdminFakultas();
    }

    public function isDosen(): bool
    {
        return strtolower((string)$this->role) === 'dosen';
    }

    public function isMahasiswa(): bool
    {
        return strtolower((string)$this->role) === 'mahasiswa';
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

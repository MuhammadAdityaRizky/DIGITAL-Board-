<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use LogsActivity;

    protected $table = 'pengumuman';
    public $timestamps = false;
    protected $guarded = [];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function laboratoriums()
    {
        return $this->belongsToMany(Laboratorium::class, 'laboratorium_pengumuman', 'pengumuman_id', 'laboratorium_id')->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Scope untuk pengumuman yang aktif ditampilkan di Digital Board (sesuai rentang waktu).
     */
    public function scopeActiveForDisplay($query)
    {
        $now = now();
        return $query->where(function ($q) use ($now) {
            $q->whereNull('tanggal_mulai')->orWhere('tanggal_mulai', '<=', $now);
        })->where(function ($q) use ($now) {
            $q->whereNull('tanggal_selesai')->orWhere('tanggal_selesai', '>=', $now);
        });
    }

    /**
     * Cek apakah durasi pengumuman sudah habis (kedaluwarsa).
     */
    public function isExpired(): bool
    {
        if (!$this->tanggal_selesai) {
            return false;
        }
        return \Carbon\Carbon::parse($this->tanggal_selesai)->isPast();
    }

    /**
     * Cek apakah pengumuman sedang dalam masa tenggang 24 jam sebelum dihapus otomatis.
     */
    public function isInGracePeriod(): bool
    {
        if (!$this->tanggal_selesai) {
            return false;
        }
        $selesai = \Carbon\Carbon::parse($this->tanggal_selesai);
        $deleteAt = $selesai->copy()->addHours(24);
        return $selesai->isPast() && now()->lt($deleteAt);
    }

    /**
     * Hitung sisa waktu masa tenggang sebelum pengumuman dihapus otomatis.
     */
    public function getGracePeriodCountdown(): ?string
    {
        if (!$this->isInGracePeriod()) {
            return null;
        }
        $deleteAt = \Carbon\Carbon::parse($this->tanggal_selesai)->addHours(24);
        $diff = now()->diff($deleteAt);
        if ($diff->h > 0) {
            return "{$diff->h} jam {$diff->i} menit";
        }
        return "{$diff->i} menit";
    }

    /**
     * Membersihkan pengumuman yang durasinya sudah selesai dan telah melewati masa tenggang 24 jam.
     * Menghapus file gambar di storage, relasi pivot laboratorium, dan data pengumuman.
     */
    public static function cleanExpiredPengumuman(): int
    {
        $cutoff = now()->subHours(24);
        $expiredList = self::whereNotNull('tanggal_selesai')
            ->where('tanggal_selesai', '<=', $cutoff)
            ->get();

        $count = 0;
        foreach ($expiredList as $item) {
            if ($item->foto_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->foto_url)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($item->foto_url);
            }
            $item->laboratoriums()->detach();
            $item->delete();
            $count++;
        }

        return $count;
    }

}


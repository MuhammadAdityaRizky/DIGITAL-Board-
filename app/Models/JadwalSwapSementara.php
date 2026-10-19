<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSwapSementara extends Model
{
    use HasFactory;

    protected $table = 'jadwal_swap_sementara';

    protected $fillable = [
        'tanggal',
        'jadwal_1_id',
        'jadwal_2_id',
        'agenda_1_id',
        'agenda_2_id',
        'jam_mulai_1_asli',
        'jam_selesai_1_asli',
        'jam_mulai_2_asli',
        'jam_selesai_2_asli',
        'jam_mulai_1_tukar',
        'jam_selesai_1_tukar',
        'jam_mulai_2_tukar',
        'jam_selesai_2_tukar',
        'admin_id',
    ];

    public function jadwal1()
    {
        return $this->belongsTo(JadwalPenggunaanLab::class, 'jadwal_1_id');
    }

    public function jadwal2()
    {
        return $this->belongsTo(JadwalPenggunaanLab::class, 'jadwal_2_id');
    }

    public function agenda1()
    {
        return $this->belongsTo(Agenda::class, 'agenda_1_id');
    }

    public function agenda2()
    {
        return $this->belongsTo(Agenda::class, 'agenda_2_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

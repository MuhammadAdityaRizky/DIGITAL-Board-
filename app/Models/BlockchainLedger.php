<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockchainLedger extends Model
{
    /**
     * Koneksi ke Database 2 (digital_board_ledger)
     */
    protected $connection = 'mysql_ledger';
    protected $table = 'blockchain_ledgers';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'payload' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Relasi ke User pembuat aksi di Database 1
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

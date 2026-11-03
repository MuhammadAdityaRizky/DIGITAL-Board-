<?php

namespace App\Traits;

use App\Services\BlockchainService;

trait SemiBlockchainLedger
{
    /**
     * Boot trait untuk merekam setiap aksi data di DB 1 langsung ke DB 2
     */
    public static function bootSemiBlockchainLedger()
    {
        // 1. Saat data baru dibuat di Database 1
        static::created(function ($model) {
            try {
                BlockchainService::record(
                    $model->getTable(),
                    $model->getKey(),
                    'CREATED',
                    $model->getAttributes()
                );
            } catch (\Throwable $e) {
                // Log error jika diperlukan agar proses DB 1 tidak terhenti bila DB 2 down
                report($e);
            }
        });

        // 2. Saat data diubah di Database 1
        static::updated(function ($model) {
            try {
                BlockchainService::record(
                    $model->getTable(),
                    $model->getKey(),
                    'UPDATED',
                    $model->getAttributes()
                );
            } catch (\Throwable $e) {
                report($e);
            }
        });

        // 3. Saat data dihapus (Hard Delete di DB 1)
        static::deleted(function ($model) {
            try {
                // Gunakan getOriginal() agar seluruh data sebelum terhapus tersimpan utuh di DB 2
                $snapshot = !empty($model->getOriginal()) ? $model->getOriginal() : $model->getAttributes();

                BlockchainService::record(
                    $model->getTable(),
                    $model->getKey(),
                    'DELETED',
                    $snapshot
                );
            } catch (\Throwable $e) {
                report($e);
            }
        });
    }
}

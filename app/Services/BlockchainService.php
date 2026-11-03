<?php

namespace App\Services;

use App\Models\BlockchainLedger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class BlockchainService
{
    /**
     * Genesis Hash untuk blok pertama (#1)
     */
    const GENESIS_HASH = '0000000000000000000000000000000000000000000000000000000000000000';

    /**
     * Hitung SHA-256 hash secara konsisten dan deterministik
     */
    public static function calculateHash(
        string $previousHash,
        string $tableName,
        $recordId,
        string $action,
        array $payload,
        $userId,
        string $timestamp
    ): string {
        // Urutkan kunci array secara rekursif agar hasil json_encode selalu konsisten
        self::recursiveKsort($payload);
        $payloadJson = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $rawString = implode('|', [
            $previousHash,
            $tableName,
            (string) ($recordId ?? ''),
            $action,
            $payloadJson,
            (string) ($userId ?? ''),
            $timestamp,
        ]);

        return hash('sha256', $rawString);
    }

    /**
     * Catat blok transaksi baru ke Database 2
     */
    public static function record(string $tableName, $recordId, string $action, array $payload, $userId = null): BlockchainLedger
    {
        // 1. Ambil blok terakhir di Database 2
        $lastBlock = BlockchainLedger::orderBy('id', 'desc')->first();
        $previousHash = $lastBlock ? $lastBlock->current_hash : self::GENESIS_HASH;

        $timestamp = now()->format('Y-m-d H:i:s');
        $effectiveUserId = $userId ?? (Auth::check() ? Auth::id() : null);

        // 2. Hitung hash blok sekarang
        $currentHash = self::calculateHash(
            $previousHash,
            $tableName,
            $recordId,
            $action,
            $payload,
            $effectiveUserId,
            $timestamp
        );

        // 3. Simpan blok ke Database 2 (Append-Only)
        return BlockchainLedger::create([
            'table_name'    => $tableName,
            'record_id'     => $recordId,
            'action'        => strtoupper($action),
            'payload'       => $payload,
            'user_id'       => $effectiveUserId,
            'ip_address'    => Request::ip() ?? '127.0.0.1',
            'user_agent'    => substr(Request::userAgent() ?? 'CLI/System', 0, 500),
            'previous_hash' => $previousHash,
            'current_hash'  => $currentHash,
            'created_at'    => $timestamp,
        ]);
    }

    /**
     * Verifikasi integritas rantai semi-blockchain di Database 2
     * Memastikan tidak ada blok yang pernah diedit, dihapus, atau disisipkan secara ilegal
     */
    public static function verifyChain(): array
    {
        $blocks = BlockchainLedger::orderBy('id', 'asc')->get();
        $previousHash = self::GENESIS_HASH;
        $corruptedBlocks = [];

        foreach ($blocks as $block) {
            $isCorrupted = false;
            $reasons = [];

            // 1. Periksa kaitan rantai: previous_hash harus cocok dengan hash blok sebelumnya
            if ($block->previous_hash !== $previousHash) {
                $isCorrupted = true;
                $reasons[] = "Rantai putus! previous_hash tidak cocok dengan hash blok sebelumnya.";
            }

            // 2. Hitung ulang hash dari payload data blok
            $payload = is_array($block->payload) ? $block->payload : (json_decode($block->payload, true) ?: []);
            $recalculatedHash = self::calculateHash(
                $block->previous_hash,
                $block->table_name,
                $block->record_id,
                $block->action,
                $payload,
                $block->user_id,
                $block->created_at->format('Y-m-d H:i:s')
            );

            if ($recalculatedHash !== $block->current_hash) {
                $isCorrupted = true;
                $reasons[] = "Data dimanipulasi! Isi payload tidak cocok dengan current_hash tersimpan.";
            }

            if ($isCorrupted) {
                $corruptedBlocks[] = [
                    'block_id'        => $block->id,
                    'table_name'      => $block->table_name,
                    'record_id'       => $block->record_id,
                    'action'          => $block->action,
                    'expected_prev'   => $previousHash,
                    'actual_prev'     => $block->previous_hash,
                    'stored_hash'     => $block->current_hash,
                    'calculated_hash' => $recalculatedHash,
                    'reasons'         => $reasons,
                ];
            }

            $previousHash = $block->current_hash;
        }

        return [
            'is_valid'         => empty($corruptedBlocks),
            'total_blocks'     => $blocks->count(),
            'corrupted_count'  => count($corruptedBlocks),
            'corrupted_blocks' => $corruptedBlocks,
        ];
    }

    /**
     * Helper rekursif ksort untuk deterministik hashing
     */
    private static function recursiveKsort(array &$array): void
    {
        ksort($array);
        foreach ($array as &$value) {
            if (is_array($value)) {
                self::recursiveKsort($value);
            }
        }
    }
}

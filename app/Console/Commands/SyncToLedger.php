<?php

namespace App\Console\Commands;

use App\Models\BlockchainLedger;
use App\Services\BlockchainService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncToLedger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ledger:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kloning/Sinkronkan ulang seluruh data dari Database 1 ke Database 2 jika Database 2 sempat terhapus';

    /**
     * Daftar tabel yang disinkronkan ke ledger
     */
    protected $tables = [
        'jadwal_penggunaan_lab',
        'agenda',
        'users',
        'laboratorium',
        'dosen',
        'mahasiswa',
        'mata_kuliah',
        'pengumuman',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("=== MEMBANGUN ULANG DATABASE 2 (digital_board_recovery) DARI DATABASE 1 ===");

        $totalSynced = 0;

        foreach ($this->tables as $tableName) {
            if (!DB::getSchemaBuilder()->hasTable($tableName)) {
                continue;
            }

            $rows = DB::table($tableName)->orderBy('id', 'asc')->get();

            if ($rows->isEmpty()) {
                continue;
            }

            $this->line("Proses tabel [{$tableName}] ({$rows->count()} data)...");

            foreach ($rows as $row) {
                $payload = (array) $row;
                $recordId = $row->id ?? null;

                // Cek apakah data ini sudah pernah tercatat di DB 2
                $alreadyExists = BlockchainLedger::where('table_name', $tableName)
                    ->where('record_id', $recordId)
                    ->exists();

                if (!$alreadyExists) {
                    BlockchainService::record($tableName, $recordId, 'CREATED', $payload);
                    $totalSynced++;
                }
            }
        }

        $this->info("\n✓ SUKSES: Database 2 berhasil dibangun ulang!");
        $this->info("Total data yang berhasil disalin kembali ke digital_board_recovery: {$totalSynced}");

        // Jalankan verifikasi rantai
        $audit = BlockchainService::verifyChain();
        $this->info("Status Rantai Blockchain: " . ($audit['is_valid'] ? 'VALID & UTUH' : 'ADA MASALAH'));

        return Command::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\BlockchainLedger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RestoreFromLedger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ledger:restore {--table= : Nama tabel tertentu yang ingin dipulihkan} {--include-deleted : Pulihkan juga data yang status terakhirnya pernah dihapus}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulihkan data Database 1 yang hilang/terhapus menggunakan fotokopi dari Database 2 (digital_board_recovery)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("=== PROSES PEMULIHAN DATA DARI DATABASE 2 (digital_board_recovery) ===");

        $tableFilter = $this->option('table');
        $includeDeleted = $this->option('include-deleted');

        $query = BlockchainLedger::orderBy('id', 'asc');
        if ($tableFilter) {
            $query->where('table_name', $tableFilter);
        }

        $allBlocks = $query->get();

        if ($allBlocks->isEmpty()) {
            $this->warn("Tidak ada data backup yang ditemukan di digital_board_recovery.");
            return Command::SUCCESS;
        }

        // Kumpulkan status paling terakhir untuk setiap [table_name][record_id]
        $latestStates = [];
        foreach ($allBlocks as $b) {
            $key = $b->table_name . ':' . $b->record_id;
            $latestStates[$key] = $b;
        }

        $restoredCount = 0;
        $skippedDeletedCount = 0;

        foreach ($latestStates as $key => $lastBlock) {
            if ($lastBlock->action === 'DELETED' && !$includeDeleted) {
                $skippedDeletedCount++;
                continue;
            }

            $tableName = $lastBlock->table_name;
            $payload = is_array($lastBlock->payload) ? $lastBlock->payload : json_decode($lastBlock->payload, true);

            if (empty($payload)) {
                continue;
            }

            try {
                // Nonaktifkan foreign key checks sementara untuk menghindari urutan dependensi
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                // Cek apakah data sudah ada di Database 1
                $exists = DB::table($tableName)->where('id', $lastBlock->record_id)->exists();

                if ($exists) {
                    DB::table($tableName)->where('id', $lastBlock->record_id)->update($payload);
                } else {
                    DB::table($tableName)->insert($payload);
                }

                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                $restoredCount++;
                $this->line(" [✓] Berhasil memulihkan tabel {$tableName} ID: {$lastBlock->record_id}");
            } catch (\Exception $e) {
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                $this->error(" [✗] Gagal memulihkan tabel {$tableName} ID: {$lastBlock->record_id}: " . $e->getMessage());
            }
        }

        $this->info("\n--- RINGKASAN PEMULIHAN ---");
        $this->info("Total data berhasil dipulihkan ke Database 1: {$restoredCount}");
        if ($skippedDeletedCount > 0) {
            $this->comment("Data sengaja dilewati (karena status terakhirnya memang dihapus): {$skippedDeletedCount}");
            $this->comment("(Gunakan flag --include-deleted jika ingin memaksakan data yang pernah dihapus ikut kembali)");
        }

        return Command::SUCCESS;
    }
}

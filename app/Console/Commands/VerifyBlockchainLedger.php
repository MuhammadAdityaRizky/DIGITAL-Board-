<?php

namespace App\Console\Commands;

use App\Services\BlockchainService;
use Illuminate\Console\Command;

class VerifyBlockchainLedger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ledger:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifikasi keaslian dan integritas rantai data di Database 2 (Semi-Blockchain Ledger)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Memeriksa integritas rantai Database 2 (digital_board_ledger)...");

        $audit = BlockchainService::verifyChain();

        if ($audit['total_blocks'] === 0) {
            $this->warn("Belum ada blok transaksi yang tercatat di Database 2.");
            return Command::SUCCESS;
        }

        if ($audit['is_valid']) {
            $this->info("✓ VALID: Rantai utuh, semua {$audit['total_blocks']} blok terverifikasi aman & asli (0 data diubah/dimanipulasi).");
            return Command::SUCCESS;
        }

        $this->error("✗ PERINGATAN: Ditemukan manipulasi atau data korup sebanyak {$audit['corrupted_count']} blok!");

        $rows = [];
        foreach ($audit['corrupted_blocks'] as $err) {
            $rows[] = [
                $err['block_id'],
                $err['table_name'],
                $err['action'],
                implode(', ', $err['reasons']),
            ];
        }

        $this->table(['Block #', 'Tabel', 'Aksi', 'Penyebab'], $rows);

        return Command::FAILURE;
    }
}

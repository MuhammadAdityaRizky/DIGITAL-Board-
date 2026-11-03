<?php

namespace App\Http\Controllers;

use App\Models\BlockchainLedger;
use App\Services\BlockchainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RecoveryLedgerController extends Controller
{
    /**
     * Tampilkan halaman Data Terhapus & Blockchain Ledger
     */
    public function index(Request $request)
    {
        $actionFilter = $request->get('action', 'DELETED'); // Default tampilkan data terhapus
        $tableFilter = $request->get('table', '');
        $search = $request->get('search', '');

        $query = BlockchainLedger::orderBy('id', 'desc');

        if ($actionFilter && $actionFilter !== 'ALL') {
            $query->where('action', $actionFilter);
        }

        if ($tableFilter) {
            $query->where('table_name', $tableFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('table_name', 'like', "%{$search}%")
                  ->orWhere('record_id', 'like', "%{$search}%")
                  ->orWhere('payload', 'like', "%{$search}%")
                  ->orWhere('current_hash', 'like', "%{$search}%");
            });
        }

        $ledgers = $query->paginate(15)->withQueryString();

        // Statistik
        $totalBlocks = BlockchainLedger::count();
        $totalDeleted = BlockchainLedger::where('action', 'DELETED')->count();
        $totalCreated = BlockchainLedger::where('action', 'CREATED')->count();
        $totalUpdated = BlockchainLedger::where('action', 'UPDATED')->count();

        // Daftar tabel unik untuk dropdown filter
        $availableTables = BlockchainLedger::select('table_name')
            ->distinct()
            ->orderBy('table_name')
            ->pluck('table_name');

        // Status Keaslian Rantai Blockchain
        $chainStatus = BlockchainService::verifyChain();

        return view('admin.recovery_ledger', compact(
            'ledgers',
            'totalBlocks',
            'totalDeleted',
            'totalCreated',
            'totalUpdated',
            'availableTables',
            'chainStatus',
            'actionFilter',
            'tableFilter',
            'search'
        ));
    }

    /**
     * Pulihkan data spesifik dari Database 2 ke Database 1
     */
    public function restore(Request $request, $id)
    {
        $block = BlockchainLedger::findOrFail($id);
        $tableName = $block->table_name;
        $recordId = $block->record_id;
        $payload = is_array($block->payload) ? $block->payload : json_decode($block->payload, true);

        if (empty($payload)) {
            return back()->with('error', 'Gagal memulihkan: Isi snapshot data kosong.');
        }

        if (!Schema::hasTable($tableName)) {
            return back()->with('error', "Gagal memulihkan: Tabel '{$tableName}' tidak ditemukan di Database 1.");
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Cek apakah data sudah ada di Database 1
            $exists = DB::table($tableName)->where('id', $recordId)->exists();

            if ($exists) {
                DB::table($tableName)->where('id', $recordId)->update($payload);
            } else {
                DB::table($tableName)->insert($payload);
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Data [{$tableName}] dengan ID #{$recordId} berhasil dipulihkan ke Database 1!"
                ]);
            }

            return back()->with('success', "Data [{$tableName}] dengan ID #{$recordId} berhasil dipulihkan ke Database 1!");
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memulihkan: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Terjadi kesalahan saat memulihkan: ' . $e->getMessage());
        }
    }

    /**
     * API Cek Keaslian Rantai Blockchain
     */
    public function verifyApi()
    {
        $status = BlockchainService::verifyChain();
        return response()->json($status);
    }
}

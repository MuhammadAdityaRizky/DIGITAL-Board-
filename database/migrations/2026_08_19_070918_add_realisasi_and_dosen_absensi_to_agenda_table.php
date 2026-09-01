<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            if (!Schema::hasColumn('agenda', 'materi_realisasi')) {
                $table->text('materi_realisasi')->nullable()->after('catatan');
            }
            if (!Schema::hasColumn('agenda', 'dosen_waktu_masuk')) {
                $table->timestamp('dosen_waktu_masuk')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            $table->dropColumn(['materi_realisasi', 'dosen_waktu_masuk']);
        });
    }
};

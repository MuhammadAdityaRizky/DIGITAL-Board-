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
            if (!Schema::hasColumn('agenda', 'jadwal_penggunaan_lab_id')) {
                $table->foreignId('jadwal_penggunaan_lab_id')->nullable()->after('id')->constrained('jadwal_penggunaan_lab')->onDelete('set null')->onUpdate('cascade');
            }
            if (!Schema::hasColumn('agenda', 'berita_acara')) {
                $table->text('berita_acara')->nullable()->after('materi_realisasi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            if (Schema::hasColumn('agenda', 'jadwal_penggunaan_lab_id')) {
                $table->dropForeign(['jadwal_penggunaan_lab_id']);
                $table->dropColumn('jadwal_penggunaan_lab_id');
            }
            if (Schema::hasColumn('agenda', 'berita_acara')) {
                $table->dropColumn('berita_acara');
            }
        });
    }
};

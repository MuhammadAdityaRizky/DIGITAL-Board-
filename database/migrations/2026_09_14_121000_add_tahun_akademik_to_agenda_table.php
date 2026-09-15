<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            if (!Schema::hasColumn('agenda', 'tahun_akademik')) {
                $table->string('tahun_akademik', 50)->nullable()->default('2026/2027 Ganjil')->after('program_kuliah');
            }
        });

        // Set tahun akademik for existing agendas
        DB::table('agenda')
            ->leftJoin('jadwal_penggunaan_lab', 'agenda.jadwal_penggunaan_lab_id', '=', 'jadwal_penggunaan_lab.id')
            ->update([
                'agenda.tahun_akademik' => DB::raw('COALESCE(jadwal_penggunaan_lab.tahun_akademik, "2026/2027 Ganjil")')
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            if (Schema::hasColumn('agenda', 'tahun_akademik')) {
                $table->dropColumn('tahun_akademik');
            }
        });
    }
};

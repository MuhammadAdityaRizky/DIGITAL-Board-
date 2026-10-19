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
        Schema::table('laboratorium', function (Blueprint $table) {
            if (!Schema::hasColumn('laboratorium', 'nama_kepala_lab')) {
                $table->string('nama_kepala_lab', 150)->nullable()->after('nama_laboran');
            }
            if (!Schema::hasColumn('laboratorium', 'nip_kepala_lab')) {
                $table->string('nip_kepala_lab', 50)->nullable()->after('nama_kepala_lab');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laboratorium', function (Blueprint $table) {
            if (Schema::hasColumn('laboratorium', 'nip_kepala_lab')) {
                $table->dropColumn('nip_kepala_lab');
            }
            if (Schema::hasColumn('laboratorium', 'nama_kepala_lab')) {
                $table->dropColumn('nama_kepala_lab');
            }
        });
    }
};

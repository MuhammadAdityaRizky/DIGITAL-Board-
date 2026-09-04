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
            if (!Schema::hasColumn('agenda', 'jenis_pertemuan')) {
                $table->enum('jenis_pertemuan', ['Teori', 'Praktikum'])->default('Praktikum')->after('program_kuliah');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            if (Schema::hasColumn('agenda', 'jenis_pertemuan')) {
                $table->dropColumn('jenis_pertemuan');
            }
        });
    }
};

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
        if (!Schema::hasColumn('laboratorium', 'warna_theme')) {
            Schema::table('laboratorium', function (Blueprint $table) {
                $table->string('warna_theme', 20)->nullable()->default('#0f172a')->after('nama_laboran');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('laboratorium', 'warna_theme')) {
            Schema::table('laboratorium', function (Blueprint $table) {
                $table->dropColumn('warna_theme');
            });
        }
    }
};

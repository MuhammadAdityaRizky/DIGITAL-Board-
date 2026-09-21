<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('laboratorium') && !Schema::hasColumn('laboratorium', 'nama_laboran')) {
            Schema::table('laboratorium', function (Blueprint $table) {
                $table->string('nama_laboran', 100)->nullable()->after('kapasitas');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('laboratorium') && Schema::hasColumn('laboratorium', 'nama_laboran')) {
            Schema::table('laboratorium', function (Blueprint $table) {
                $table->dropColumn('nama_laboran');
            });
        }
    }
};

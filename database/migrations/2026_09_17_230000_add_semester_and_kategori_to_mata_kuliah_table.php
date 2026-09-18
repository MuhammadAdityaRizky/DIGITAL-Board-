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
        if (Schema::hasTable('mata_kuliah')) {
            Schema::table('mata_kuliah', function (Blueprint $table) {
                if (!Schema::hasColumn('mata_kuliah', 'semester')) {
                    $table->integer('semester')->default(1)->after('sks');
                }
                if (!Schema::hasColumn('mata_kuliah', 'kategori')) {
                    $table->string('kategori', 50)->default('Wajib')->after('semester');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('mata_kuliah')) {
            Schema::table('mata_kuliah', function (Blueprint $table) {
                if (Schema::hasColumn('mata_kuliah', 'semester')) {
                    $table->dropColumn('semester');
                }
                if (Schema::hasColumn('mata_kuliah', 'kategori')) {
                    $table->dropColumn('kategori');
                }
            });
        }
    }
};

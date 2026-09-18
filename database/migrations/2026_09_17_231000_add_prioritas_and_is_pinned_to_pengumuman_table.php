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
        if (Schema::hasTable('pengumuman')) {
            Schema::table('pengumuman', function (Blueprint $table) {
                if (!Schema::hasColumn('pengumuman', 'prioritas')) {
                    $table->string('prioritas', 30)->default('Normal')->after('foto_url');
                }
                if (!Schema::hasColumn('pengumuman', 'is_pinned')) {
                    $table->boolean('is_pinned')->default(false)->after('prioritas');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pengumuman')) {
            Schema::table('pengumuman', function (Blueprint $table) {
                if (Schema::hasColumn('pengumuman', 'prioritas')) {
                    $table->dropColumn('prioritas');
                }
                if (Schema::hasColumn('pengumuman', 'is_pinned')) {
                    $table->dropColumn('is_pinned');
                }
            });
        }
    }
};

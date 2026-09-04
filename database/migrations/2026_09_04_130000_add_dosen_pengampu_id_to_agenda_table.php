<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            $table->foreignId('dosen_pengampu_id')
                ->nullable()
                ->after('dosen_id')
                ->constrained('dosen')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            $table->dropForeign(['dosen_pengampu_id']);
            $table->dropColumn('dosen_pengampu_id');
        });
    }
};

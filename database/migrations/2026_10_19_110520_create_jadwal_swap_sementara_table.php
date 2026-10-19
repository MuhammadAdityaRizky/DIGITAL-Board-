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
        Schema::create('jadwal_swap_sementara', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->index();
            $table->foreignId('jadwal_1_id')->nullable()->constrained('jadwal_penggunaan_lab')->nullOnDelete();
            $table->foreignId('jadwal_2_id')->nullable()->constrained('jadwal_penggunaan_lab')->nullOnDelete();
            $table->foreignId('agenda_1_id')->nullable()->constrained('agenda')->nullOnDelete();
            $table->foreignId('agenda_2_id')->nullable()->constrained('agenda')->nullOnDelete();
            $table->time('jam_mulai_1_asli')->nullable();
            $table->time('jam_selesai_1_asli')->nullable();
            $table->time('jam_mulai_2_asli')->nullable();
            $table->time('jam_selesai_2_asli')->nullable();
            $table->time('jam_mulai_1_tukar');
            $table->time('jam_selesai_1_tukar');
            $table->time('jam_mulai_2_tukar');
            $table->time('jam_selesai_2_tukar');
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_swap_sementara');
    }
};

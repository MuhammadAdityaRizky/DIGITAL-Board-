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
        if (!Schema::hasTable('perizinan')) {
            Schema::create('perizinan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('agenda_id')->constrained('agenda')->onDelete('cascade')->onUpdate('cascade');
                $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
                $table->enum('kategori', ['Izin', 'Sakit']);
                $table->text('alasan');
                $table->string('bukti_url', 255)->nullable();
                $table->enum('status_persetujuan', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
                $table->timestamp('created_at')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinan');
    }
};

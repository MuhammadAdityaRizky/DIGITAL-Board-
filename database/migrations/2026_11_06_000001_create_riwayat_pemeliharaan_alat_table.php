<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('riwayat_pemeliharaan_alat')) {
            Schema::create('riwayat_pemeliharaan_alat', function (Blueprint $table) {
                $table->id();
                $table->foreignId('item_properti_id')->constrained('item_properti_lab')->onDelete('cascade');
                $table->text('tindakan');
                $table->dateTime('tanggal_mulai');
                $table->dateTime('tanggal_selesai')->nullable();
                $table->string('paraf', 100)->nullable();
                $table->text('keterangan')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pemeliharaan_alat');
    }
};


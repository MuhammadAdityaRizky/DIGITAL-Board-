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
        if (!Schema::hasTable('jadwal_penggunaan_lab')) {
            Schema::create('jadwal_penggunaan_lab', function (Blueprint $table) {
                $table->id();
                $table->foreignId('lab_id')->nullable()->constrained('laboratorium')->onDelete('set null')->onUpdate('cascade');
                $table->foreignId('dosen_id')->nullable()->constrained('dosen')->onDelete('cascade')->onUpdate('cascade');
                $table->foreignId('dosen_pengampu_id')->nullable()->constrained('dosen')->onDelete('set null')->onUpdate('cascade');
                $table->foreignId('id_prodi')->nullable()->constrained('prodi')->onDelete('set null')->onUpdate('cascade');
                $table->string('mata_kuliah', 150);
                $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])->default('Senin');
                $table->time('jam_mulai')->default('08:00:00');
                $table->time('jam_selesai')->default('10:30:00');
                $table->string('kelas', 50)->nullable()->default('Reg A');
                $table->string('semester', 20)->nullable()->default('1');
                $table->enum('program_kuliah', ['Reguler', 'Karyawan'])->default('Reguler');
                $table->string('tahun_akademik', 50)->default('2026/2027 Ganjil');
                $table->boolean('is_aktif')->default(true);
                $table->timestamp('created_at')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_penggunaan_lab');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username_or_nim_nip', 50)->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'dosen', 'mahasiswa']);
            $table->string('nama_lengkap', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });

        // 2. Dosen Table
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nip', 30)->unique();
        });

        // 3. Mahasiswa Table
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nim', 30)->unique();
        });

        // 4. Laboratorium Table
        Schema::create('laboratorium', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lab', 100);
            $table->string('lokasi', 100);
        });

        // 5. Agenda Table
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lab_id')->constrained('laboratorium')->onDelete('cascade')->onUpdate('cascade');
            $table->string('judul_agenda', 150);
            $table->date('tanggal');
            $table->time('waktu_masuk');
            $table->time('waktu_keluar');
            $table->text('rencana_pembelajaran');
            $table->text('realisasi_pembelajaran')->nullable();
            $table->string('qr_code_token', 255)->nullable()->unique();
            $table->timestamp('created_at')->useCurrent();
        });

        // 6. Absensi Table
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')->constrained('agenda')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('waktu_kehadiran')->useCurrent();
            $table->enum('status', ['Hadir', 'Izin', 'Alpa'])->default('Hadir');
            $table->unique(['agenda_id', 'mahasiswa_id'], 'unique_absensi_per_agenda');
        });

        // 7. Pengumuman Table
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('judul_pengumuman', 150);
            $table->text('penjelasan');
            $table->date('tanggal');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('agenda');
        Schema::dropIfExists('laboratorium');
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('dosen');
        Schema::dropIfExists('users');
    }
};

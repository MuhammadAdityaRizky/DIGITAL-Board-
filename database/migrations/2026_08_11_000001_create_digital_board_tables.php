<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 0. Sessions Table (required by Laravel)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // 1. Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'dosen', 'mahasiswa']);
            $table->timestamp('created_at')->useCurrent();
        });

        // 2. Fakultas Table
        Schema::create('fakultas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_fakultas', 100);
            $table->timestamp('created_at')->useCurrent();
        });

        // 3. Prodi Table
        Schema::create('prodi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fakultas_id')->constrained('fakultas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_prodi', 100);
            $table->timestamp('created_at')->useCurrent();
        });

        // 4. Dosen Table
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nip', 30)->unique();
            $table->string('nama', 100);
            $table->enum('status', ['Tetap', 'Tidak Tetap', 'Honorer', 'Cuti']);
            $table->foreignId('id_fakultas')->nullable()->constrained('fakultas')->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('id_prodi')->nullable()->constrained('prodi')->onDelete('set null')->onUpdate('cascade');
            $table->text('kompetensi')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // 5. Mahasiswa Table
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nim', 20)->unique();
            $table->string('nama_lengkap', 100);
            $table->foreignId('id_fakultas')->nullable()->constrained('fakultas')->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('id_prodi')->nullable()->constrained('prodi')->onDelete('set null')->onUpdate('cascade');
            $table->string('kelas', 20);
            $table->timestamp('created_at')->useCurrent();
        });

        // 6. Laboratorium Table
        Schema::create('laboratorium', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lab', 100);
            $table->string('lokasi', 100);
            $table->integer('kapasitas');
            $table->timestamp('created_at')->useCurrent();
        });

        // 7. Agenda Table
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lab_id')->constrained('laboratorium')->onDelete('cascade')->onUpdate('cascade');
            $table->string('mata_kuliah', 150);
            $table->string('kelas', 50)->nullable();
            $table->string('semester', 20)->nullable();
            $table->string('jurusan', 100)->nullable();
            $table->string('fakultas', 100)->nullable();
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('status_agenda', ['Akan Datang', 'Berlangsung', 'Selesai', 'Dibatalkan']);
            $table->text('catatan')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // 8. Absensi Table
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')->constrained('agenda')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('waktu_masuk')->useCurrent();
            $table->enum('status_kehadiran', ['Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpa']);
        });

        // 9. Perizinan Table
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

        // 10. Pengumuman Table
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('judul', 150);
            $table->text('isi_pengumuman');
            $table->string('foto_url', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
        Schema::dropIfExists('perizinan');
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('agenda');
        Schema::dropIfExists('laboratorium');
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('dosen');
        Schema::dropIfExists('prodi');
        Schema::dropIfExists('fakultas');
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};

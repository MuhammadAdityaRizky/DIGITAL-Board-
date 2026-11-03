<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Master Kategori & Sub Kategori Properti
        if (!Schema::hasTable('kategori_properti')) {
            Schema::create('kategori_properti', function (Blueprint $table) {
                $table->id();
                $table->string('nama', 100);
                $table->string('kode', 20)->nullable()->comment('Singkatan kode barang: M, K, PC, PR, MD, PT, C, dll');
                $table->enum('jenis', ['kategori', 'sub_kategori'])->default('kategori');
                $table->foreignId('parent_id')->nullable()->constrained('kategori_properti')->onDelete('cascade');
                $table->timestamps();
            });
        }

        // 2. Berkas / Dokumen Properti per Lab
        if (!Schema::hasTable('dokumen_properti_lab')) {
            Schema::create('dokumen_properti_lab', function (Blueprint $table) {
                $table->id();
                $table->foreignId('lab_id')->constrained('laboratorium')->onDelete('cascade');
                $table->string('nama_dokumen', 150);
                $table->string('nomor_dokumen', 50)->default('FT-SPR-INS-F-01');
                $table->string('nomor_revisi', 20)->default('0');
                $table->date('tanggal_pendataan');
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }

        // 3. Item / Fasilitas Properti Lab (11 Kolom standar UIKA)
        if (!Schema::hasTable('item_properti_lab')) {
            Schema::create('item_properti_lab', function (Blueprint $table) {
                $table->id();
                $table->foreignId('dokumen_id')->constrained('dokumen_properti_lab')->onDelete('cascade');
                $table->foreignId('kategori_id')->nullable()->constrained('kategori_properti')->onDelete('set null');
                $table->foreignId('sub_kategori_id')->nullable()->constrained('kategori_properti')->onDelete('set null');
                $table->string('nama_properti', 150);
                $table->string('merk_type', 150)->nullable();
                $table->string('nomor_inventaris', 100)->nullable();
                $table->string('ruang', 100)->nullable();
                $table->decimal('harga', 15, 2)->default(0);
                $table->string('tahun', 10)->nullable();
                $table->enum('kondisi', ['baik', 'sedang', 'rusak'])->default('baik');
                $table->string('frekuensi_pemeliharaan', 50)->nullable();
                $table->integer('urutan')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('item_properti_lab');
        Schema::dropIfExists('dokumen_properti_lab');
        Schema::dropIfExists('kategori_properti');
    }
};


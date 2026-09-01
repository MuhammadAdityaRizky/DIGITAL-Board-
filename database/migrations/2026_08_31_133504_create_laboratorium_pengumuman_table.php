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
        if (!Schema::hasTable('laboratorium_pengumuman')) {
            Schema::create('laboratorium_pengumuman', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('laboratorium_id');
                $table->unsignedBigInteger('pengumuman_id');
                $table->timestamps();

                $table->foreign('laboratorium_id')->references('id')->on('laboratorium')->onDelete('cascade');
                $table->foreign('pengumuman_id')->references('id')->on('pengumuman')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratorium_pengumuman');
    }
};

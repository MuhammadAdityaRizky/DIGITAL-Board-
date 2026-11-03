<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The database connection that should be used by the migration.
     *
     * @var string
     */
    protected $connection = 'mysql_ledger';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::connection('mysql_ledger')->hasTable('blockchain_ledgers')) {
            Schema::connection('mysql_ledger')->create('blockchain_ledgers', function (Blueprint $table) {
                $table->id(); // Block Index (#1, #2, #3, ...)
                $table->string('table_name', 100);
                $table->unsignedBigInteger('record_id')->nullable();
                $table->string('action', 30); // CREATED, UPDATED, DELETED
                $table->longText('payload'); // Snapshot data lengkap dalam bentuk JSON
                $table->unsignedBigInteger('user_id')->nullable(); // ID pengguna yang melakukan aksi
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->char('previous_hash', 64); // SHA-256 hash dari blok sebelumnya
                $table->char('current_hash', 64);  // SHA-256 hash blok ini
                $table->timestamp('created_at')->useCurrent();

                $table->index(['table_name', 'record_id']);
                $table->index('action');
                $table->index('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_ledger')->dropIfExists('blockchain_ledgers');
    }
};

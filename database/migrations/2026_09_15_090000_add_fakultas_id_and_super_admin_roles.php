<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add fakultas_id to laboratorium table
        if (Schema::hasTable('laboratorium')) {
            Schema::table('laboratorium', function (Blueprint $table) {
                if (!Schema::hasColumn('laboratorium', 'fakultas_id')) {
                    $table->foreignId('fakultas_id')->nullable()->after('id')->constrained('fakultas')->onDelete('set null')->onUpdate('cascade');
                }
            });
        }

        // 2. Add fakultas_id and expand role on users table
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'fakultas_id')) {
                    $table->foreignId('fakultas_id')->nullable()->after('password')->constrained('fakultas')->onDelete('set null')->onUpdate('cascade');
                }
            });

            // Modify role column to string so it can store 'super_admin', 'admin', 'dosen', 'mahasiswa'
            try {
                DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(30) NOT NULL DEFAULT 'admin'");
            } catch (\Throwable $e) {
                // In case of SQLite or drivers where MODIFY COLUMN is not supported
            }

            // Update existing admin1 to super_admin
            DB::table('users')->where('username', 'admin1')->update([
                'role' => 'super_admin',
                'fakultas_id' => null,
            ]);
        }

        // 3. Associate existing labs with FTS (Fakultas Teknik dan Sains) by default if applicable
        $fts = DB::table('fakultas')->where('nama_fakultas', 'LIKE', '%Teknik%')->first();
        if ($fts) {
            DB::table('laboratorium')->whereNull('fakultas_id')->update([
                'fakultas_id' => $fts->id
            ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('laboratorium') && Schema::hasColumn('laboratorium', 'fakultas_id')) {
            Schema::table('laboratorium', function (Blueprint $table) {
                $table->dropForeign(['fakultas_id']);
                $table->dropColumn('fakultas_id');
            });
        }

        if (Schema::hasTable('users')) {
            if (Schema::hasColumn('users', 'fakultas_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropForeign(['fakultas_id']);
                    $table->dropColumn('fakultas_id');
                });
            }
            try {
                DB::table('users')->where('role', 'super_admin')->update(['role' => 'admin']);
                DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'dosen', 'mahasiswa') NOT NULL DEFAULT 'admin'");
            } catch (\Throwable $e) {
                // Ignore rollback failure
            }
        }
    }
};

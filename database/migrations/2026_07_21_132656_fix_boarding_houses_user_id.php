<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah kolom owner_id ada
        if (Schema::hasColumn('boarding_houses', 'owner_id')) {
            Schema::table('boarding_houses', function (Blueprint $table) {
                // Hapus foreign key jika ada
                try {
                    $table->dropForeign(['owner_id']);
                } catch (\Exception $e) {
                    // Foreign key mungkin sudah tidak ada
                }
            });
            
            // Rename kolom
            Schema::table('boarding_houses', function (Blueprint $table) {
                $table->renameColumn('owner_id', 'user_id');
            });
        }
        
        // Jika kolom user_id belum ada
        if (!Schema::hasColumn('boarding_houses', 'user_id')) {
            Schema::table('boarding_houses', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            });
        }
        
        // Tambah foreign key ke users
        Schema::table('boarding_houses', function (Blueprint $table) {
            // Cek apakah foreign key sudah ada
            $foreignKeys = DB::select("
                SELECT conname 
                FROM pg_constraint 
                WHERE conrelid = 'boarding_houses'::regclass 
                AND contype = 'f'
                AND conname LIKE '%user_id%'
            ");
            
            if (empty($foreignKeys)) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('boarding_houses', function (Blueprint $table) {
            try {
                $table->dropForeign(['user_id']);
            } catch (\Exception $e) {
                // Foreign key mungkin sudah tidak ada
            }
            
            if (Schema::hasColumn('boarding_houses', 'user_id')) {
                $table->renameColumn('user_id', 'owner_id');
            }
        });
    }
};
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
        Schema::table('boarding_houses', function (Blueprint $table) {
            // Cek apakah kolom facilities sudah ada
            if (!Schema::hasColumn('boarding_houses', 'facilities')) {
                $table->json('facilities')->nullable()->after('rules');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boarding_houses', function (Blueprint $table) {
            if (Schema::hasColumn('boarding_houses', 'facilities')) {
                $table->dropColumn('facilities');
            }
        });
    }
};
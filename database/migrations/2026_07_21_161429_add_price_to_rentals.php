<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            // Tambahkan kolom price jika belum ada
            if (!Schema::hasColumn('rentals', 'price')) {
                $table->decimal('price', 15, 2)->nullable()->after('end_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (Schema::hasColumn('rentals', 'price')) {
                $table->dropColumn('price');
            }
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rentals', function (Blueprint $table) {
            // Ubah panjang kolom unique_code menjadi 50 karakter
            $table->string('unique_code', 50)->change();
        });
    }

    public function down()
    {
        Schema::table('rentals', function (Blueprint $table) {
            // Kembalikan ke panjang semula (8 karakter)
            $table->string('unique_code', 8)->change();
        });
    }
};
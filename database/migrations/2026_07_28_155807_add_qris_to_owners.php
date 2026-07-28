<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('owners', function (Blueprint $table) {
            // Tambahkan field untuk QRIS
            $table->string('qris_ewallet')->nullable()->after('ewallet_shopeepay')->comment('E-wallet utama untuk QRIS (ovo/dana/shopeepay)');
            $table->string('qris_image')->nullable()->after('qris_ewallet')->comment('Path ke gambar QRIS');
        });
    }

    public function down()
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->dropColumn(['qris_ewallet', 'qris_image']);
        });
    }
};
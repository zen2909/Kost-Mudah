<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('owners', function (Blueprint $table) {
           
            // Tambahkan field untuk 3 jenis e-wallet
            $table->string('ewallet_ovo')->nullable()->after('bank_account_holder');
            $table->string('ewallet_dana')->nullable()->after('ewallet_ovo');
            $table->string('ewallet_shopeepay')->nullable()->after('ewallet_dana');
            
        });
    }

    public function down()
    {
        Schema::table('owners', function (Blueprint $table) {
            
            $table->dropColumn(['ewallet_ovo', 'ewallet_dana', 'ewallet_shopeepay']);
        });
    }
};
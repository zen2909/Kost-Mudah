<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 15)->unique()->after('email');
            $table->timestamp('phone_verified_at')->nullable()->after('phone');
            $table->enum('role', ['tenant', 'owner', 'admin'])->default('tenant')->after('password');
            $table->string('photo')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'phone_verified_at', 'role', 'photo']);
        });
    }
};

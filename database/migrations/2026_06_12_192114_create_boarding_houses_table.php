<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boarding_houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->string('slug', 200)->unique();
            $table->string('name', 150);
            $table->text('address');
            $table->string('kelurahan', 100);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('type', ['putra', 'putri', 'campur']);
            $table->decimal('price_per_month', 12, 2);
            $table->integer('total_rooms');
            $table->integer('available_rooms');
            $table->text('description')->nullable();
            $table->text('rules')->nullable();
            $table->json('facil ities')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->index(['kelurahan', 'price_per_month', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boarding_houses');
    }
};

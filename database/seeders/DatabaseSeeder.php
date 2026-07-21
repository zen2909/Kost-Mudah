<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,           // Buat roles
            UserSeeder::class,           // Buat semua user (admin, owner, tenant) + owner & tenant records
            BoardingHouseSeeder::class,  // Buat kost
        ]);
    }
}
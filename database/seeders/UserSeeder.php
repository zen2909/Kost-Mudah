<?php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::create([
            'name' => 'Admin KostMudah',
            'email' => 'admin@kostmudah.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'role' => 'admin',
            'photo' => null,
        ]);

        // 2. Owner (Pemilik Kost)
        $owner = User::create([
            'name' => 'Budi Pemilik Kost',
            'email' => 'owner@kostmudah.com',
            'password' => Hash::make('password'),
            'phone' => '082345678901',
            'role' => 'owner',
            'photo' => null,
        ]);

        Owner::create([
            'user_id' => $owner->id,
            'verification_document' => 'documents/owner_ktp.pdf',
            'verification_status' => 'approved',
            'verified_at' => now(),
        ]);

        // 3. Tenant (Penyewa)
        $tenant = User::create([
            'name' => 'Andi Penyewa',
            'email' => 'tenant@kostmudah.com',
            'password' => Hash::make('password'),
            'phone' => '083456789012',
            'role' => 'tenant',
            'photo' => null,
        ]);

        Tenant::create([
            'user_id' => $tenant->id,
            'occupation' => 'Mahasiswa',
            'gender' => 'L',
        ]);

        $this->command->info('1 Admin, 1 Owner, 1 Tenant berhasil dibuat!');
    }
}

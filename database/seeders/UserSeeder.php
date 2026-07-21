<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Owner;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan semua role tersedia
        $this->ensureRolesExist();

        $users = [
            // Admin
            [
                'name' => 'Admin KostMudah',
                'email' => 'admin@kostmudah.com',
                'phone' => '081234567899',
                'password' => 'password123',
                'role' => 'admin',
            ],
            // Owners
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@kostmudah.com',
                'phone' => '081234567890',
                'password' => 'password123',
                'role' => 'owner',
                'owner_data' => [
                    'verification_status' => 'approved',
                    'verification_document' => 'documents/ktp_budi.pdf',
                ],
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti@kostmudah.com',
                'phone' => '081234567891',
                'password' => 'password123',
                'role' => 'owner',
                'owner_data' => [
                    'verification_status' => 'approved',
                    'verification_document' => 'documents/ktp_siti.pdf',
                ],
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi@kostmudah.com',
                'phone' => '081234567892',
                'password' => 'password123',
                'role' => 'owner',
                'owner_data' => [
                    'verification_status' => 'approved',
                    'verification_document' => 'documents/ktp_andi.pdf',
                ],
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@kostmudah.com',
                'phone' => '081234567893',
                'password' => 'password123',
                'role' => 'owner',
                'owner_data' => [
                    'verification_status' => 'pending',
                    'verification_document' => 'documents/ktp_dewi.pdf',
                ],
            ],
            [
                'name' => 'Rudi Hartono',
                'email' => 'rudi@kostmudah.com',
                'phone' => '081234567894',
                'password' => 'password123',
                'role' => 'owner',
                'owner_data' => [
                    'verification_status' => 'approved',
                    'verification_document' => 'documents/ktp_rudi.pdf',
                ],
            ],
            // Tenants
            [
                'name' => 'Ayu Maharani',
                'email' => 'ayu@email.com',
                'phone' => '081234567901',
                'password' => 'password123',
                'role' => 'tenant',
                'tenant_data' => [
                    'occupation' => 'Mahasiswa',
                    'gender' => 'P',
                ],
            ],
            [
                'name' => 'Sari Utami',
                'email' => 'sari@email.com',
                'phone' => '081234567902',
                'password' => 'password123',
                'role' => 'tenant',
                'tenant_data' => [
                    'occupation' => 'Karyawan',
                    'gender' => 'P',
                ],
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya@email.com',
                'phone' => '081234567903',
                'password' => 'password123',
                'role' => 'tenant',
                'tenant_data' => [
                    'occupation' => 'Mahasiswa',
                    'gender' => 'P',
                ],
            ],
            [
                'name' => 'Rina Melati',
                'email' => 'rina@email.com',
                'phone' => '081234567904',
                'password' => 'password123',
                'role' => 'tenant',
                'tenant_data' => [
                    'occupation' => 'Karyawan',
                    'gender' => 'P',
                ],
            ],
            [
                'name' => 'Dewi Anggraini',
                'email' => 'dewi.ten@email.com',
                'phone' => '081234567905',
                'password' => 'password123',
                'role' => 'tenant',
                'tenant_data' => [
                    'occupation' => 'Mahasiswa',
                    'gender' => 'P',
                ],
            ],
            [
                'name' => 'Andi Saputra',
                'email' => 'andi.s@email.com',
                'phone' => '081234567906',
                'password' => 'password123',
                'role' => 'tenant',
                'tenant_data' => [
                    'occupation' => 'Karyawan',
                    'gender' => 'L',
                ],
            ],
            [
                'name' => 'Budi Pratama',
                'email' => 'budi.p@email.com',
                'phone' => '081234567907',
                'password' => 'password123',
                'role' => 'tenant',
                'tenant_data' => [
                    'occupation' => 'Mahasiswa',
                    'gender' => 'L',
                ],
            ],
            [
                'name' => 'Cahya Nugraha',
                'email' => 'cahya@email.com',
                'phone' => '081234567908',
                'password' => 'password123',
                'role' => 'tenant',
                'tenant_data' => [
                    'occupation' => 'Karyawan',
                    'gender' => 'L',
                ],
            ],
            [
                'name' => 'Deni Ramdani',
                'email' => 'deni@email.com',
                'phone' => '081234567909',
                'password' => 'password123',
                'role' => 'tenant',
                'tenant_data' => [
                    'occupation' => 'Mahasiswa',
                    'gender' => 'L',
                ],
            ],
            [
                'name' => 'Eko Susanto',
                'email' => 'eko@email.com',
                'phone' => '081234567910',
                'password' => 'password123',
                'role' => 'tenant',
                'tenant_data' => [
                    'occupation' => 'Karyawan',
                    'gender' => 'L',
                ],
            ],
            // Lanjutkan tenant lainnya...
        ];

        foreach ($users as $userData) {
            // Cek apakah user sudah ada
            $existingUser = User::where('email', $userData['email'])->first();
            
            if (!$existingUser) {
                // Buat user baru
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'phone' => $userData['phone'],
                    'password' => Hash::make($userData['password']),
                    'email_verified_at' => now(),
                ]);
                $this->command->info("✅ User '{$userData['name']}' created!");

                // Assign role menggunakan DB langsung (karena syncRoles bermasalah)
                $role = Role::where('name', $userData['role'])->first();
                if ($role) {
                    DB::table('model_has_roles')->insert([
                        'role_id' => $role->id,
                        'model_type' => 'App\\Models\\User',
                        'model_id' => $user->id,
                    ]);
                    $this->command->info("✅ Role '{$userData['role']}' assigned to '{$user->name}'");
                }

                // Update kolom role
                $user->update(['role' => $userData['role']]);

                // Jika role owner, tambahkan ke tabel owners
                if ($userData['role'] === 'owner' && isset($userData['owner_data'])) {
                    $this->createOwner($user, $userData['owner_data']);
                }

                // Jika role tenant, tambahkan ke tabel tenants
                if ($userData['role'] === 'tenant' && isset($userData['tenant_data'])) {
                    $this->createTenant($user, $userData['tenant_data']);
                }
            } else {
                $this->command->warn("⚠️ User '{$userData['name']}' already exists.");
            }
        }

        $this->command->info('✅ All users seeded successfully!');
    }

    /**
     * Ensure all roles exist.
     */
    private function ensureRolesExist(): void
    {
        $roles = ['admin', 'owner', 'tenant'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }
        $this->command->info('✅ Roles ensured!');
    }

    /**
     * Create owner record.
     */
    private function createOwner(User $user, array $ownerData): void
    {
        $owner = Owner::where('user_id', $user->id)->first();
        
        if (!$owner) {
            Owner::create([
                'user_id' => $user->id,
                'verification_document' => $ownerData['verification_document'] ?? null,
                'verification_status' => $ownerData['verification_status'] ?? 'pending',
                'verified_at' => ($ownerData['verification_status'] ?? 'pending') === 'approved' ? now() : null,
            ]);
            $this->command->info("✅ Owner record created for '{$user->name}'");
        } else {
            $this->command->warn("⚠️ Owner record already exists for '{$user->name}'");
        }
    }

    /**
     * Create tenant record.
     */
    private function createTenant(User $user, array $tenantData): void
    {
        $tenant = Tenant::where('user_id', $user->id)->first();
        
        if (!$tenant) {
            Tenant::create([
                'user_id' => $user->id,
                'occupation' => $tenantData['occupation'] ?? null,
                'gender' => $tenantData['gender'] ?? null,
            ]);
            $this->command->info("✅ Tenant record created for '{$user->name}'");
        } else {
            $this->command->warn("⚠️ Tenant record already exists for '{$user->name}'");
        }
    }
}
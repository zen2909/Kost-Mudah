<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat roles
        $roles = ['admin', 'owner', 'tenant'];

        foreach ($roles as $role) {
            // Cek apakah role sudah ada
            $existingRole = Role::where('name', $role)->first();
            if (!$existingRole) {
                Role::create(['name' => $role]);
                $this->command->info("✅ Role '{$role}' created!");
            } else {
                $this->command->warn("⚠️ Role '{$role}' already exists.");
            }
        }

        $this->command->info('✅ All roles seeded successfully!');
    }
}
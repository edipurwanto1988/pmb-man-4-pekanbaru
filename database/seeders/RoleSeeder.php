<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Create Permissions
        $permissions = [
            // Siswa Permissions
            'view_own_profile',
            'edit_own_profile',
            'upload_berkas',
            'view_own_berkas_status',
            'view_jadwal',
            'view_own_hasil_tes',
            'view_pengumuman',
            'daftar_ulang',
            
            // Admin Core Permissions
            'manage_roles',
            'manage_permissions',
            'manage_users',
            'manage_pendaftar',
            'manage_syarat',
            'manage_settings',
            
            // Panitia / Staff Permissions (Granular)
            'view_pendaftar',
            'verify_berkas',
            'input_nilai',
            'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $siswaRole = Role::firstOrCreate(['name' => 'calon_siswa']);

        // 3. Assign Permissions to Roles
        // Admin gets all permissions
        $adminRole->givePermissionTo(Permission::all());

        // Siswa gets specific permissions
        $siswaRole->givePermissionTo([
            'view_own_profile',
            'edit_own_profile',
            'upload_berkas',
            'view_own_berkas_status',
            'view_jadwal',
            'view_own_hasil_tes',
            'view_pengumuman',
            'daftar_ulang',
        ]);

        // 4. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@pmb.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        
        // Check if user already has role to avoid duplication error if run multiple times without fresh
        if (!$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
    }
}

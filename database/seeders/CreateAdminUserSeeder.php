<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat atau ambil Super Admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => bcrypt('123456'),
            ]
        );

        // Buat atau ambil role Super Admin
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Ambil semua permission
        $allPermissions = Permission::pluck('id', 'id')->all();

        // Sinkronisasi semua permission ke role
        $superAdminRole->syncPermissions($allPermissions);

        // Assign role ke user
        $superAdmin->assignRole($superAdminRole);

        // ==============================

        // Buat atau ambil Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('123456'),
            ]
        );

        // Buat atau ambil role Admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Sinkronisasi semua permission ke role admin (jika diinginkan)
        $adminRole->syncPermissions($allPermissions);

        // Assign role ke admin
        $admin->assignRole($adminRole);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Roles
        $adminRole = Role::create(['name' => 'admin']);
        $supplierRole = Role::create(['name' => 'supplier']);
        $verifikatorRole = Role::create(['name' => 'verifikator']);
        $pimpinanRole = Role::create(['name' => 'pimpinan']);
        $operatorRole = Role::create(['name' => 'operator_fakultas']);

        // Buat User Statis & berikan role
        $admin = User::create([
            'name' => 'Admin UNEJ',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password') // ganti dengan password yang aman
        ]);
        $admin->assignRole($adminRole);

        $verifikator = User::create([
            'name' => 'Verifikator UNEJ',
            'email' => 'verifikator@gmail.com',
            'password' => Hash::make('password')
        ]);
        $verifikator->assignRole($verifikatorRole);

        $pimpinan = User::create([
            'name' => 'Pimpinan UNEJ',
            'email' => 'pimpinan@gmail.com',
            'password' => Hash::make('password')
        ]);
        $pimpinan->assignRole($pimpinanRole);

        $operator = User::create([
            'name' => 'Operator Fakultas UNEJ',
            'email' => 'operator@gmail.com',
            'password' => Hash::make('password')
        ]);
        $operator->assignRole($operatorRole);
    }
}

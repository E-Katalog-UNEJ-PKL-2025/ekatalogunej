<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'supplier']); // Pastikan baris ini ada
        Role::create(['name' => 'verifikator']);
        Role::create(['name' => 'pimpinan']);
        Role::create(['name' => 'operator_fakultas']);

        // Buat User Statis & berikan role
        User::create([
            'name' => 'Admin UNEJ',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ])->assignRole('admin');

        User::create([
            'name' => 'Verifikator UNEJ',
            'email' => 'verifikator@gmail.com',
            'password' => Hash::make('password')
        ])->assignRole('verifikator');

        User::create([
            'name' => 'Pimpinan UNEJ',
            'email' => 'pimpinan@gmail.com',
            'password' => Hash::make('password')
        ])->assignRole('pimpinan');

        User::create([
            'name' => 'Operator Fakultas UNEJ',
            'email' => 'operator@gmail.com',
            'password' => Hash::make('password')
        ])->assignRole('operator_fakultas');
    }
}
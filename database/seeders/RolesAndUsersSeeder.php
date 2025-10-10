<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Buat Permissions
        $permissions = [
            'dashboard.view',
            'products.view', 'products.create', 'products.edit', 'products.delete',
            'documents.view', 'documents.create',
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'roles.view', 'roles.edit',
            'suppliers.verify',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // 3. Buat Roles dan SIMPAN ke dalam variabel
        $adminRole = Role::create(['name' => 'admin']);
        $supplierRole = Role::create(['name' => 'supplier']);
        $verificatorRole = Role::create(['name' => 'verifikator']);
        $pimpinanRole = Role::create(['name' => 'pimpinan']);
        $operatorRole = Role::create(['name' => 'operator_fakultas']);

        // 4. Berikan permissions ke roles menggunakan VARIABEL
        $supplierRole->givePermissionTo([
            'dashboard.view', 
            'products.view', 'products.create', 'products.edit', 'products.delete', 
            'documents.view', 'documents.create'
        ]);
        
        $verificatorRole->givePermissionTo(['dashboard.view', 'suppliers.verify']);
        $pimpinanRole->givePermissionTo('dashboard.view');
        $operatorRole->givePermissionTo('dashboard.view');
        $adminRole->givePermissionTo(Permission::all());

        // 5. Buat pengguna statis
        User::create([
            'name' => 'Admin UNEJ',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ])->assignRole($adminRole);

        User::create([
            'name' => 'Verifikator UNEJ',
            'email' => 'verifikator@gmail.com',
            'password' => Hash::make('password')
        ])->assignRole($verificatorRole);

        User::create([
            'name' => 'Pimpinan UNEJ',
            'email' => 'pimpinan@gmail.com',
            'password' => Hash::make('password')
        ])->assignRole($pimpinanRole);

        User::create([
            'name' => 'Operator Fakultas UNEJ',
            'email' => 'operator@gmail.com',
            'password' => Hash::make('password')
        ])->assignRole($operatorRole);
    }
}
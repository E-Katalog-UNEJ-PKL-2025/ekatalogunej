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
            RolesAndUsersSeeder::class,
            DocumentTypeSeeder::class,
            DocumentStatusSeeder::class,
            ProductCategorySeeder::class, // Kita panggil ini juga untuk jaga-jaga
        ]);
    }
}
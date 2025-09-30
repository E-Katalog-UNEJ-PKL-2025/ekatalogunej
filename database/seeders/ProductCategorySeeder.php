<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ProductCategory::create(['nama' => 'Alat Tulis Kantor']);
        \App\Models\ProductCategory::create(['nama' => 'Elektronik']);
        \App\Models\ProductCategory::create(['nama' => 'Furnitur']);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\DocumentType::create(['name' => 'KTP']);
        \App\Models\DocumentType::create(['name' => 'NPWP']);
        \App\Models\DocumentType::create(['name' => 'SIUP']);
    }
}

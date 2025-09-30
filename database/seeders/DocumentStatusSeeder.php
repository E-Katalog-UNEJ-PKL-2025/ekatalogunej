<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\DocumentStatus::create(['name' => 'Menunggu Verifikasi']);
        \App\Models\DocumentStatus::create(['name' => 'Disetujui']);
        \App\Models\DocumentStatus::create(['name' => 'Ditolak']);
    }
}

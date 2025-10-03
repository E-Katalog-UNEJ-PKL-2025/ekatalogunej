<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambahkan kolom baru di tabel supplier_profiles
        Schema::table('supplier_profiles', function (Blueprint $table) {
            $table->text('remarks')->nullable()->after('is_verified');
        });

        // Hapus kolom lama dari tabel supplier_documents
        Schema::table('supplier_documents', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplier_profiles', function (Blueprint $table) {
            //
        });
    }
};

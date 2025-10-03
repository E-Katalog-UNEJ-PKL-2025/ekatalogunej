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
        Schema::table('supplier_documents', function (Blueprint $table) {
            // Kolom untuk menyimpan alasan penolakan atau pesan lain
            $table->text('remarks')->nullable()->after('document_status_id');
        });
    }

    public function down(): void
    {
        Schema::table('supplier_documents', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });
    }
};

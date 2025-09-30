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
        Schema::table('document_statuses', function (Blueprint $table) {
            // Mengubah tipe kolom 'name' menjadi string dengan panjang 50
            $table->string('name', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_statuses', function (Blueprint $table) {
            //
        });
    }
};

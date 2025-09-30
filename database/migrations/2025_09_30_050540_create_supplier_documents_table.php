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
        Schema::create('supplier_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles'); // [cite: 164, 185]
            $table->foreignId('document_status_id')->constrained('document_statuses'); // [cite: 174, 186]
            $table->foreignId('document_type_id')->constrained('document_types'); // [cite: 180, 187]
            $table->string('name'); // [cite: 143, 149]
            $table->text('path_file'); // [cite: 156, 157]
            $table->timestamp('uploaded_at'); // [cite: 148]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_documents');
    }
};

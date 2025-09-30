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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles'); // [cite: 218, 228]
            $table->foreignId('category_id')->constrained('product_categories'); // [cite: 225, 229]
            $table->string('name'); // [cite: 200, 201]
            $table->integer('price'); // [cite: 205, 206]
            $table->text('description')->nullable(); // [cite: 212, 213]
            $table->timestamp('updated_at')->nullable(); // 
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

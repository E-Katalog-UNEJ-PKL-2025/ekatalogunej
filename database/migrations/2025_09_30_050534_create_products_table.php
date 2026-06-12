<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('product_categories')->onDelete('cascade');
            $table->string('name');
            $table->unsignedBigInteger('price');
            $table->text('description')->nullable();
            
            $table->string('image_path')->nullable();
            $table->json('specifications')->nullable(); 
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
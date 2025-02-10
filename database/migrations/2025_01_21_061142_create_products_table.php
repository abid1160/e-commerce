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
            $table->id(); // Primary key
            $table->string('product_name');
            $table->decimal('price', 10, 2); // For monetary values
            $table->text('description');
            $table->integer('quantity'); // For quantities
            $table->string('color');
            $table->string('size');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id');
           
            $table->timestamps(); // Adds created_at and updated_at columns
            
            // Foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
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

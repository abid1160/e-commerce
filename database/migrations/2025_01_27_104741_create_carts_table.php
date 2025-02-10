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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // For logged-in users, nullable for guest users
            $table->unsignedBigInteger('product_id'); // ID of the product in the cart
            $table->integer('quantity')->default(1); // Quantity of the product
            $table->decimal('price', 10, 2); // Product price at the time of adding to the cart
            $table->string('image')->nullable(); // Path to the product image
            $table->timestamps(); // Created at and updated at timestamps
            
            // Foreign key constraints (optional)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};

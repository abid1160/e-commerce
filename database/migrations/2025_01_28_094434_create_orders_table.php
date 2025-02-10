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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Nullable for guest users
            $table->unsignedBigInteger('address_id')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->string('shipping_address');
            $table->string('image_path');
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            // Dropping each column separately for PostgreSQL/SQLite compatibility
            if (Schema::hasColumn('discounts', 'amount')) {
                $table->dropColumn('amount');
            }
            if (Schema::hasColumn('discounts', 'percentage')) {
                $table->dropColumn('percentage');
            }
        });

        Schema::table('discounts', function (Blueprint $table) {
            // Adding new column
            $table->enum('type', ['percentage', 'fixed'])->after('code');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            // Rolling back: re-adding dropped columns
            $table->decimal('amount', 10, 2)->nullable();
            $table->integer('percentage')->nullable();
        });

        Schema::table('discounts', function (Blueprint $table) {
            // Removing the new column
            $table->dropColumn('type');
        });
    }
};

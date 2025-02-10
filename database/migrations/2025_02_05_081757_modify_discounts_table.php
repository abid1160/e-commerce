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
        Schema::table('discounts', function (Blueprint $table) {
            // Dropping each column separately for PostgreSQL/SQLite compatibility
            if (Schema::hasColumn('discounts', 'code')) {
                $table->dropColumn('code');
            }
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};

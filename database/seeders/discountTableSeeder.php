<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class discountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('discounts')->insert([
            'code' => 'SUMMER10',
            'percentage' => 10,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'is_active' => true
            
        ]);
    }
}

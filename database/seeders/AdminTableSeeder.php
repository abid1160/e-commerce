<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            ['name' => 'admin2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('12345678'),
            'phone_number'=>'6387119202',
            'usertype'=>'admin',],
            ['name' => 'abid',
            'email' => 'mdabid1160@gmail.com',
            'password' => Hash::make('12345678'),
            'phone_number'=>'6387119204',
            'usertype'=>'admin',]
        ]);
    }
}

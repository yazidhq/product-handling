<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role_id' => 1,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'role_id' => 2,
            'name' => 'pegawai',
            'email' => 'pegawai@gmail.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'role_id' => 3,
            'name' => 'kurir',
            'email' => 'kurir@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}

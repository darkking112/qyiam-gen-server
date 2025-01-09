<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert the admin user
        DB::table('users')->insert([
            'email' => 'admin@qyiam-gen.com',
            'password' => Hash::make('qyiam@gen_admin#1'), // Securely hash the password
            'name' => 'Admin User',
            'role' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

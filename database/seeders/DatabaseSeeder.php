<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create an Admin
        User::create([
            'name' => 'Bert Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Create a Staff member
        User::create([
            'name' => 'Bert Staff',
            'email' => 'staff@test.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        // 3. Create a Customer
        User::create([
            'name' => 'Bert Customer',
            'email' => 'customer@test.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'phone' => '09123456789',
            'driver_license' => 'D01-12-345678',
        ]);
    }
}
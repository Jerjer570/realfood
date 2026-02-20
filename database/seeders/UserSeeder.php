<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Data User Manual dari mockData.ts
        User::create([
            'name' => 'Admin',
            'email' => 'admin@realfood.id', //
            'password' => Hash::make('admin123'), //
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com', //
            'password' => Hash::make('user123'), //
        ]);
    }
}
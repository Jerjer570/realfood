<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Admin Manual
        User::create([
            'nama' => 'Admin',
            'email' => 'admin@realfood.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'alamat' => 'Jl. Admin No. 1',
            'no_hp' => '081234567890',
            'foto_profil' => 'admin.jpg',
            'status_email' => 'verified',
        ]);

        // 2. Data User Manual
        User::create([
            'nama' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'alamat' => 'Jl. User No. 1',
            'no_hp' => '081234567891',
            'foto_profil' => 'user.jpg',
            'status_email' => 'verified',
        ]);

        // 3. Membuat 100 Data Dummy (Ditaruh di luar, bukan di dalam array create)
        User::factory()->count(100)->create();
    }
}

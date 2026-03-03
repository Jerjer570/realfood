<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama'         => fake()->name(), // Perbaikan: Gunakan name(), bukan nama()
            'email'        => fake()->unique()->safeEmail(),
            'password'     => Hash::make('password123'),
            'role'         => 'user',
            'alamat'       => fake()->address(),
            'no_hp'        => fake()->phoneNumber(),
            'foto_profil'  => 'default.jpg',
            'status_email' => 'verified',
        ];
    }

    /**
     * Jika Anda tidak menggunakan kolom email_verified_at, 
     * sebaiknya sesuaikan atau hapus method ini agar tidak membingungkan.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_email' => 'unverified', // Disesuaikan dengan kolom Anda
        ]);
    }
}
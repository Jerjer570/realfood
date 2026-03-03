<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_menu' => $this->faker->words(3, true),
            'harga'     => $this->faker->numberBetween(20000, 100000),
            'kalori'    => $this->faker->numberBetween(50, 600),
            'deskripsi' => $this->faker->sentence(),
            'kategori'  => $this->faker->randomElement(['Salads', 'Main Course', 'Bowls']),
            'gambar'    => 'images/menu' . $this->faker->numberBetween(1, 6) . '.webp',
            'rating'    => $this->faker->randomFloat(1, 3, 5),
        ];
    }
}
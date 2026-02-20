<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food; // Alamat model harus benar

class FoodSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     */
    public function run(): void
    {
        // Data menu yang akan dimasukkan ke database
        $menuItems = [
            [
                'name' => 'Grilled Salmon Bowl',
                'description' => 'Salmon panggang dengan sayuran segar dan quinoa',
                'price' => 85000,
                'calories' => 450,
                'image' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=500',
                'rating' => 4.8,
                'category' => 'Bowls'
            ],
            [
                'name' => 'Fresh Garden Salad',
                'description' => 'Salad sayuran organik dengan dressing vinaigrette',
                'price' => 45000,
                'calories' => 280,
                'image' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=500',
                'rating' => 4.6,
                'category' => 'Salads'
            ],
            [
                'name' => 'Berry Smoothies',
                'description' => 'Campuran buah berry segar yang kaya antioksidan',
                'price' => 35000,
                'calories' => 180,
                'image' => 'https://images.unsplash.com/photo-1553530666-ba11a7da3888?w=500',
                'rating' => 4.7,
                'category' => 'Drinks'
            ],
            [
                'name' => 'Chicken Avocado Wrap',
                'description' => 'Dada ayam grill dengan irisan alpukat mentega',
                'price' => 55000,
                'calories' => 380,
                'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500',
                'rating' => 4.5,
                'category' => 'Main Course'
            ],
            [
                'name' => 'Detox Green Juice',
                'description' => 'Ekstrak kale, apel hijau, dan lemon untuk detox',
                'price' => 30000,
                'calories' => 90,
                'image' => 'https://images.unsplash.com/photo-1610970881699-44a55874c431?w=500',
                'rating' => 4.9,
                'category' => 'Drinks'
            ]
        ];

        // Looping untuk memasukkan data satu per satu
        foreach ($menuItems as $item) {
            Food::create($item);
        }
    }
}
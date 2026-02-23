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
                'name' => 'Cooked Salad with Peanut Sauce',
                'description' => 'Salad yang sudah direbus atau dikukus dengan saus kacang yang kaya rasa',
                'price' => 85000,
                'calories' => 450,
                'image' => 'images/menu1.webp',
                'rating' => 5.0,
                'category' => 'Salads'
            ],
            [
                'name' => 'Red Rice with Tempeh',
                'description' => 'Nasi merah dengan tempeh yang dipotong kecil dan disajikan dengan sayuran segar',
                'price' => 45000,
                'calories' => 280,
                'image' => 'images/menu2.webp',
                'rating' => 4.6,
                'category' => 'Main Course'
            ],
            [
                'name' => 'Vegetables Mix',
                'description' => 'Sayur mayur campur yang segar dan kaya serat, cocok untuk diet sehat',
                'price' => 35000,
                'calories' => 180,
                'image' => 'images/menu3.webp',
                'rating' => 4.7,
                'category' => 'Bowls'
            ],
            [
                'name' => 'Salmon with Corn Rice',
                'description' => 'Ikan salmon dengan nasi jagung yang lezat dan sehat',
                'price' => 55000,
                'calories' => 380,
                'image' => 'images/menu4.webp',
                'rating' => 4.5,
                'category' => 'Main Course'
            ],
            [
                'name' => 'Chicken Filled with Red Rice',
                'description' => 'Dada ayam yang dipadukan dengan nasi merah dan sayuran segar',
                'price' => 30000,
                'calories' => 90,
                'image' => 'images/menu5.webp',
                'rating' => 4.7,
                'category' => 'Main Course'
            ],
             [
                'name' => 'Boiled Egg with Oatmeal',
                'description' => 'Telur rebus dengan oatmeal yang lezat dan sehat',
                'price' => 25000,
                'calories' => 120,
                'image' => 'images/menu6.webp',
                'rating' => 4.7,
                'category' => 'Main Course'
            ]
        ];

        // Looping untuk memasukkan data satu per satu
        foreach ($menuItems as $item) {
            Food::create($item);
        }
    }
}
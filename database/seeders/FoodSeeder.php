<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\menu; // Alamat model harus benar

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
                'nama_menu' => 'Cooked Salad with Peanut Sauce',
                'deskripsi' => 'Salad yang sudah direbus atau dikukus dengan saus kacang yang kaya rasa',
                'harga' => 85000,
                'kalori' => 450,
                'gambar' => 'images/menu1.webp',
                'rating' => 5.0,
                'kategori' => 'Salads'
            ],
            [
                'nama_menu' => 'Red Rice with Tempeh',
                'deskripsi' => 'Nasi merah dengan tempeh yang dipotong kecil dan disajikan dengan sayuran segar',
                'harga' => 45000,
                'kalori' => 280,
                'gambar' => 'images/menu2.webp',
                'rating' => 4.6,
                'kategori' => 'Main Course'
            ],
            [
                'nama_menu' => 'Vegetables Mix',
                'deskripsi' => 'Sayur mayur campur yang segar dan kaya serat, cocok untuk diet sehat',
                'harga' => 35000,
                'kalori' => 180,
                'gambar' => 'images/menu3.webp',
                'rating' => 4.7,
                'kategori' => 'Bowls'
            ],
            [
                'nama_menu' => 'Salmon with Corn Rice',
                'deskripsi' => 'Ikan salmon dengan nasi jagung yang lezat dan sehat',
                'harga' => 55000,
                'kalori' => 380,
                'gambar' => 'images/menu4.webp',
                'rating' => 4.5,
                'kategori' => 'Main Course'
            ],
            [
                'nama_menu' => 'Chicken Filled with Red Rice',
                'deskripsi' => 'Dada ayam yang dipadukan dengan nasi merah dan sayuran segar',
                'harga' => 30000,
                'kalori' => 90,
                'gambar' => 'images/menu5.webp',
                'rating' => 4.7,
                'kategori' => 'Main Course'
            ],
             [
                'nama_menu' => 'Boiled Egg with Oatmeal',
                'deskripsi' => 'Telur rebus dengan oatmeal yang lezat dan sehat',
                'harga' => 25000,
                'kalori' => 120,
                'gambar' => 'images/menu6.webp',
                'rating' => 4.7,
                'kategori' => 'Main Course'
            ]
        ];

        // Looping untuk memasukkan data satu per satu
        foreach ($menuItems as $item) {
            Menu::create($item);
        }
    }
}
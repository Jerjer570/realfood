<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'rating',   // Tetap masukkan jika ingin diisi manual/seeder
        'calories', // Tambahkan jika memang ada di struktur tabel
    ];

    /**
     * Opsional: Jika rating selalu dimulai dari 0, 
     * kita bisa mengatur default value di sini.
     */
    protected $attributes = [
        'rating' => 0,
    ];
}
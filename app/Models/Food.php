<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * Secara default Laravel mencari 'foods', jadi kita paksa ke 'food'.
     */
    protected $table = 'food'; 

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     * Pastikan kolom-kolom ini ada di tabel database Anda.
     */
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
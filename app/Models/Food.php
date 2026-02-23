<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'food'; // Memaksa Laravel menggunakan tabel 'food'
=======
    // Nama tabel di database (pastikan sesuai dengan migrasi Anda)
    protected $table = 'food'; 
>>>>>>> 41a5e4cc35fde4948e3f89b317758a08d6fad597

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'rating',
        'calories',
    ];
}
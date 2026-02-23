<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'food'; // Memaksa Laravel menggunakan tabel 'food'

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
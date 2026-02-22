<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    // Nama tabel di database (pastikan sesuai dengan migrasi Anda)
    protected $table = 'food'; 

    // Ini WAJIB ada agar seeder bisa memasukkan data
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'rating',
        'calories',
        'category',
    ];
}
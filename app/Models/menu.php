<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    use HasFactory; // Tambahkan ini agar bisa pakai factory()

    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    
    protected $fillable = [
        'nama_menu',
        'harga',
        'kalori',
        'deskripsi',
        'kategori',
        'gambar',
        'rating'
    ];
    
    protected $guarded = ['id_menu'];
    
    protected $attributes = [
        'rating' => 0
    ];
    
    protected $casts = [
        'rating' => 'float',
        'harga' => 'float',
        'kalori' => 'integer'
    ];
}
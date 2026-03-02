<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
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
    protected $attributes = ['rating' => 0];
    protected $casts = ['rating' => 'float',
                        'harga' => 'float',
                        'kalori' => 'integer'];
}

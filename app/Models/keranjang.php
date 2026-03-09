<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';

    protected $fillable = [
        'id_user',    // TAMBAHKAN INI
        'id_menu',    // TAMBAHKAN INI
        'kuantitas',
        'subtotal',
    ];

    protected $guarded = ['id_keranjang'];

    protected $casts = [
        'id_user' => 'integer',
        'id_menu' => 'integer',
        'kuantitas' => 'integer',
        'subtotal' => 'float'
    ];

    // Rekomendasi: Gunakan nama relasi yang standar (user dan menu)
    // agar lebih mudah dipanggil di Controller atau Blade
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function menu()
    {
        return $this->belongsTo(menu::class, 'id_menu', 'id_menu');
    }
}
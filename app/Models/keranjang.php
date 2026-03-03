<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    protected $fillable = [
        'kuantitas',
        'subtotal',
    ];
    protected $guarded = ['id_keranjang'];
    protected $casts = ['kuantitas' => 'integer',
                        'subtotal' => 'float'];

    public function userr(){
        return $this->belongsTo(user::class, 'id_user');
    }
    public function menuu(){
        return $this->belongsTo(menu::class, 'id_menu');
    }
}

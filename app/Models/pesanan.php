<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $fillable = [
        'subtotal',
        'status',
        'alamat_pengiriman',
        'no_hp',
        'metode_pembayaran',
        'ongkos_kirim'
    ];
    protected $guarded = ['id_pesanan'];
    protected $casts = ['subtotal' => 'float',
                        'ongkos_kirim' => 'float'];
    protected $attributes = ['status' => 'pending'];

    public function userr(){
        return $this->belongsTo(user::class, 'id_user');
    }
    public function keranjangg(){
        return $this->hasMany(detail_pesanan::class, 'id_pesanan');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Mass Assignment: Tambahkan kolom yang dibutuhkan database Anda.
     * deliveryAddress, phone, dan payment_method WAJIB ada di sini.
     */
    protected $fillable = [
        'user_id', 
        'total', 
        'deliveryAddress', 
        'phone', 
        'status', 
        'payment_method'
    ];

    /**
     * Relasi ke User (Satu Order dimiliki oleh satu User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke OrderItems (Satu Order memiliki banyak Item)
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
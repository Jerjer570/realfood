<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    
    protected $fillable = [
        'id_user',           // WAJIB ditambahkan agar relasi terbaca
        'total_harga',       // Tambahkan ini (biasanya subtotal + ongkir)
        'subtotal',
        'status',
        'alamat_pengiriman',
        'no_hp',
        'metode_pembayaran',
        'ongkos_kirim'
    ];

    protected $guarded = ['id_pesanan'];

    protected $casts = [
        'subtotal' => 'float',
        'total_harga' => 'float',
        'ongkos_kirim' => 'float',
        'created_at' => 'datetime' // Memastikan format tanggal aman untuk diparsing
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    /**
     * Relasi ke User
     * Digunakan untuk mengambil nama pelanggan di laporan keuangan
     */
    public function user()
    {
        // Sesuaikan foreign key 'id_user' dengan yang ada di tabel pesanan
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke Detail Pesanan
     */
    public function detail_pesanan()
    {
        return $this->hasMany(detail_pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Shortcut relasi untuk keranjang (jika kamu masih menggunakan nama ini)
     */
    public function keranjangg()
    {
        return $this->hasMany(detail_pesanan::class, 'id_pesanan');
    }
}
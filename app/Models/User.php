<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini
use Illuminate\Foundation\Auth\User as Authenticatable; // Gunakan ini jika ini model User untuk Login
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // Sebaiknya extends Authenticatable untuk fitur Auth
{
    use HasFactory, Notifiable; // Tambahkan HasFactory di sini

    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'email',    
        'nama',      // Pastikan tetap 'nama'
        'role',
        'password',
        'alamat',
        'no_hp',
        'foto_profil',
        'status_email'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Nilai default untuk kolom tertentu
    protected $attributes = [
        'role' => 'user',
        'status_email' => 'unverified'
    ];

    // Relasi
    public function pesanann() {
        return $this->hasMany(Pesanan::class, 'id_user');
    }

    public function sesii() {
        return $this->hasMany(Sesi::class, 'id_user');
    }

    public function keranjangg() {
        return $this->hasMany(Keranjang::class, 'id_user');
    }

}


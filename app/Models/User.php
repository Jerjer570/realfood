<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * Sesuai dengan migration: Schema::create('user', ...)
     */
    protected $table = 'user';

    /**
     * Primary key yang digunakan oleh tabel ini.
     * Sesuai dengan migration: $table->bigIncrements('id_user');
     */
    protected $primaryKey = 'id_user';

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'email',    
        'nama',
        'role',
        'password',
        'alamat',
        'no_hp',
        'foto_profil',
        'status_email'
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi (seperti API).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus dikonversi ke tipe data tertentu.
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Nilai default untuk kolom tertentu saat membuat record baru.
     */
    protected $attributes = [
        'role' => 'user',
        'status_email' => 'unverified'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Antar Model
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke tabel Pesanan (One to Many).
     */
    public function pesanann() 
    {
        return $this->hasMany(Pesanan::class, 'id_user');
    }

    /**
     * Relasi ke tabel Sesi (One to Many).
     */
    public function sesii() 
    {
        return $this->hasMany(Sesi::class, 'id_user');
    }

    /**
     * Relasi ke tabel Keranjang (One to Many).
     */
    public function keranjangg() 
    {
        return $this->hasMany(Keranjang::class, 'id_user');
    }
}
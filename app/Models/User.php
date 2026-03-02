<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user extends Model{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
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
    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];
    protected $guarded = ['id_user'];
    protected $attributes = [
        'role' => 'user',
        'status_email' => 'unverified'
    ];

    public function pesanann(){
        return $this->hasMany(pesanan::class, 'id_user');
    }
    public function sesii(){
        return $this->hasMany(sesi::class, 'id_user');
    }
    public function keranjangg(){
        return $this->hasMany(keranjang::class, 'id_user');
    }

}

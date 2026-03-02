<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sesi extends Model
{
    protected $table = 'sesi';
    protected $primaryKey = 'id_sesi';
    protected $fillable = [
        'ip_address',
        'user_agent',
        'payload',
        'last_activity'
    ];
    protected $guarded = ['id_sesi'];

    public function userr(){
        return $this->belongsTo(user::class, 'id_user');
    }
}

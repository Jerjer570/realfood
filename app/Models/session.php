<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class session extends Model
{
    protected $table = 'sessions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ip_address',
        'user_agent',
        'payload',
        'last_activity'
    ];
    protected $guarded = ['id'];

    public function userr(){
        return $this->belongsTo(user::class, 'id_user');
    }
}

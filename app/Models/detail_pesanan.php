<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detail_pesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail';
    protected $fillable = [
        'kuantitas',
        'subtotal'
    ];
    protected $guarded = ['id_detail'];
    protected $casts = ['kuantitas' => 'integer',
                        'subtotal' => 'float'];

    public function pesann(){
        return $this->belongsTo(pesanan::class, 'id_pesanan');
    }
    public function menuu(){
        return $this->belongsTo(menu::class, 'id_menu');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Barang;

class Card extends Model 
{
    protected $table = 'cards';

    protected $fillable = [
        'user_id', 
        'product_id', 
        'jumlah'
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke produk/barang
    public function product()
    {
        return $this->belongsTo(Barang::class, 'product_id');
    }
}

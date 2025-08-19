<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model 
{
    protected $table = 'cards';
    protected $fillable = ['user_id', 'product_id', 'jumlah'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Barang (gunakan ini untuk konsistensi)
    public function product()
    {
        return $this->belongsTo(Barang::class, 'product_id');
    }
    
    // Hapus relasi barang() untuk menghindari konfusi
    // public function barang() { ... } // HAPUS INI
}
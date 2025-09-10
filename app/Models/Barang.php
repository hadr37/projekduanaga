<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory; 
    protected $fillable = [
        'kode_barang', 'nama_barang', 'kategori_id', 'deskripsi', 'harga', 'stok', 'gambar'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function pesananDetails()
{
    return $this->hasMany(PesananDetail::class, 'product_id');
}

}

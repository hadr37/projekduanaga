<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // Jika nama tabel tidak mengikuti default plural "kategoris", ubah di sini
    protected $table = 'kategoris';

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = ['nama_kategori'];

    /**
     * Relasi: satu kategori punya banyak barang
     */
    public function barang()
{
    return $this->hasMany(Barang::class, 'kategori', 'nama_kategori');
}

}

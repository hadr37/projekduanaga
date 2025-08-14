<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function show($id)
    {
        // Ambil data barang berdasarkan ID
        $barang = Barang::with('kategori')->findOrFail($id);

        // Kalau manfaat disimpan sebagai string dipisahkan tanda "|", ubah jadi array
        if (!is_array($barang->manfaat) && $barang->manfaat) {
            $barang->manfaat = explode('|', $barang->manfaat);
        }

        return view('shop.produk_deskripsi', compact('barang'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class KatalogController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('katalog.index', compact('barangs'));
    }
    // Controller
public function tambah(Request $request, $id)
{
    $barang = Barang::findOrFail($id);
    $keranjang = session()->get('keranjang', []);

    if (isset($keranjang[$id])) {
        $keranjang[$id]['jumlah']++;
    } else {
        $keranjang[$id] = [
            'nama' => $barang->nama_barang,
            'harga' => $barang->harga,
            'gambar' => $barang->gambar,
            'jumlah' => 1
        ];
    }

    session(['keranjang' => $keranjang]);
    return redirect()->back()->with('success', 'Berhasil ditambahkan ke keranjang');
}

}

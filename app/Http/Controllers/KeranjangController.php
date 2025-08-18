<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class KeranjangController extends Controller
{
    public function index()
{
    $keranjang = session()->get('keranjang', []);
    $total = array_sum(array_map(fn($item) => $item['harga'] * $item['jumlah'], $keranjang));

    return view('keranjang.katalog', compact('keranjang', 'total'));
}

public function tambah(Request $request, $id)
{
    $barang = Barang::findOrFail($id);
    $keranjang = session()->get('keranjang', []);

    if(isset($keranjang[$id])){
        $keranjang[$id]['jumlah']++;
    } else {
        $keranjang[$id] = [
            'nama' => $barang->nama_barang,
            'harga' => $barang->harga,
            'jumlah' => 1,
            'stok' => $barang->stok,
            'gambar' => $barang->gambar,
        ];
    }

    session()->put('keranjang', $keranjang);
    return redirect()->route('keranjang.katalog')->with('success', 'Barang ditambahkan ke keranjang.');
}

public function update(Request $request, $id)
{
    $keranjang = session()->get('keranjang', []);

    if(isset($keranjang[$id])){
        $keranjang[$id]['jumlah'] = $request->jumlah;
        session()->put('keranjang', $keranjang);
    }

    return redirect()->route('keranjang.katalog');
}

public function destroy($id)
{
    $keranjang = session()->get('keranjang', []);
    if(isset($keranjang[$id])){
        unset($keranjang[$id]);
    }
    session()->put('keranjang', $keranjang);

    return redirect()->route('keranjang.katalog');
}

public function checkout()
{
    session()->forget('keranjang');
    return redirect()->route('keranjang.katalog')->with('success', 'Checkout berhasil!');
}

}

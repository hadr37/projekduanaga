<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = session()->get('keranjang', []);
        return view('keranjang.index', compact('keranjang'));
    }

    public function tambah(Request $request)
    {
        $barang = Barang::findOrFail($request->barang_id);

        $cart = session()->get('keranjang', []);

        if (isset($cart[$barang->id])) {
            $cart[$barang->id]['jumlah']++;
        } else {
            $cart[$barang->id] = [
                "nama" => $barang->nama_barang,
                "harga" => $barang->harga,
                "gambar" => $barang->gambar,
                "jumlah" => 1,
                "stok" => $barang->stok,
            ];
        }

        session()->put('keranjang', $cart);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function checkout(Request $request)
    {
        $keranjang = session()->get('keranjang', []);
        $metode = $request->input('metode');
        $nomor = $request->input('nomor');

        foreach ($keranjang as $id => $item) {
            $barang = Barang::find($id);
            if ($barang) {
                $barang->stok -= $item['jumlah'];
                $barang->save();
            }
        }

        session()->forget('keranjang');

    
        $request->validate([
        'metode_pembayaran' => 'required|string',
        'nomor_pembayaran' => 'required|string|min:5',
    ]);

    // Simulasi penyimpanan atau proses pembayaran...

    // Setelah selesai, kosongkan keranjang
    Keranjang::truncate(); // Atau hanya milik user tertentu jika ada autentikasi

    return redirect()->route('keranjang.index')->with('success', 'Checkout berhasil!');
    }



}

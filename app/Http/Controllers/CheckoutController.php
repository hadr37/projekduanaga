<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Card;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\AlamatUser;

class CheckoutController extends Controller
{
    // Halaman checkout
    public function show()
    {
        $keranjang = Card::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item->product->harga * $item->jumlah;
        }

        $alamat = AlamatUser::where('user_id', Auth::id())
            ->where('is_default', 1)
            ->first();

        return view('katalog.checkout', compact('keranjang', 'total', 'alamat'));
    }

    // Proses checkout
    public function proses(Request $request)
    {
        $request->validate([
            'jenis_pembayaran' => 'required',
            'bank' => 'required',
        ]);

        $keranjang = Card::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('katalog.shop')->with('error', 'Keranjang kosong!');
        }

        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'total' => $keranjang->sum(fn($item) => $item->product->harga * $item->jumlah),
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'bank' => $request->bank,
            'no_rekening' => $request->no_rekening ?? $request->no_virtual,
            'pesan' => $request->pesan,
            'alamat' => $request->alamat,
        ]);

        foreach ($keranjang as $item) {
            PesananDetail::create([
                'pesanan_id' => $pesanan->id,
                'barang_id' => $item->product_id,
                'jumlah' => $item->jumlah,
                'harga' => $item->product->harga,
            ]);

            // Kurangi stok barang
            $item->product->decrement('stok', $item->jumlah);
        }

        // Kosongkan keranjang user
        Card::where('user_id', Auth::id())->delete();

        return redirect()->route('keranjang.katalog')->with('success', 'Pesanan berhasil dibuat!');
    }
}

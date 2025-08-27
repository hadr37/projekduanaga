<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    $total = $keranjang->sum(fn($item) => $item->product->harga * $item->jumlah);

    // Ambil alamat default dari tabel alamat_users
    $alamat = AlamatUser::where('user_id', Auth::id())
        ->where('is_default', 1)
        ->first();

    return view('katalog.checkout', compact('keranjang', 'total', 'alamat'));
}

public function checkout()
{ 
    $keranjang = Card::with('product')
        ->where('user_id', Auth::id())
        ->get();

    if ($keranjang->isEmpty()) {
        return redirect()->route('katalog.shop')->with('error', 'Keranjang masih kosong.');
    }

    $total = $keranjang->sum(fn($c) => $c->jumlah * $c->product->harga);

    // Ambil alamat default user
    $alamat = \App\Models\AlamatUser::where('user_id', Auth::id())
        ->where('is_default', 1)
        ->first();

    return view('katalog.checkout', compact('keranjang', 'total', 'alamat'));
}

public function pesanan()
{
    $pesanan = Pesanan::with('details.barang')
        ->where('user_id', Auth::id())
        ->latest()
        ->get();
    
    return view('katalog.pesanan', compact('pesanan'));
}

}

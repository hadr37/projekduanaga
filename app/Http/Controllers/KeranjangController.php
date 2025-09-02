<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Card;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $keranjang = Card::with('product')->where('user_id', $userId)->get();

        $total = $keranjang->reduce(function ($carry, $item) {
            return $carry + ($item->product->harga * $item->jumlah);
        }, 0);
        
        return view('keranjang.katalog', compact('keranjang', 'total'));
    }

    public function tambah(Request $request, $id)
    {
        $userId = Auth::id();
        $barang = Barang::findOrFail($id);

        $cartItem = Card::where('user_id', $userId)->where('product_id', $id)->first();

        if ($cartItem) {
            if ($cartItem->jumlah < $barang->stok) {
                $cartItem->increment('jumlah', 1);
                return redirect()->route('keranjang.katalog')->with('success', 'Jumlah barang berhasil ditambah.');
            } else {
                return redirect()->route('keranjang.katalog')->with('error', 'Stok barang tidak cukup.');
            }
        } else {
            if ($barang->stok > 0) {
                Card::create([
                    'user_id' => $userId,
                    'product_id' => $id,
                    'jumlah' => 1,
                ]);
                return redirect()->route('keranjang.katalog')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
            } else {
                return back()->with('error', 'Stok barang tidak cukup.');
            }
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $cartItem = Card::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $barang = Barang::findOrFail($cartItem->product_id);

        if ($request->jumlah <= $barang->stok) {
            $cartItem->update(['jumlah' => $request->jumlah]);
            return redirect()->route('keranjang.katalog')->with('success', 'Jumlah barang berhasil diperbarui.');
        } else {
            return redirect()->route('keranjang.katalog')->with('error', 'Jumlah melebihi stok yang tersedia (Stok: ' . $barang->stok . ').');
        }
    }

    public function destroy($id)
    {
        $userId = Auth::id();
        $cartItem = Card::where('id', $id)->where('user_id', $userId)->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('keranjang.katalog')->with('success', 'Barang berhasil dihapus dari keranjang.');
        }

        return redirect()->route('keranjang.katalog')->with('error', 'Barang tidak ditemukan di keranjang.');
    }

    /**
     * Menampilkan halaman checkout (bukan langsung proses).
     */
    public function checkout()
    {
        $userId = Auth::id();
        $keranjang = Card::with('product')->where('user_id', $userId)->get();   
        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang.katalog')->with('error', 'Keranjang kosong!');
        }

        $total = $keranjang->reduce(function ($carry, $item) {
            return $carry + ($item->product->harga * $item->jumlah);
        }, 0);

        return view('katalog.checkout', compact('keranjang', 'total'));
    }

    
}

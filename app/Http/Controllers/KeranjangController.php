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
        // Ambil semua item keranjang milik user dengan relasi produk
        $keranjang = Card::with('product')->where('user_id', $userId)->get();

        // Hitung total harga
        $total = $keranjang->reduce(function ($carry, $item) {
            return $carry + ($item->product->harga * $item->jumlah);
        }, 0);

        return view('keranjang.katalog', compact('keranjang', 'total')); // Sesuaikan path view
    }

    public function tambah(Request $request, $id)
    {
        $userId = Auth::id();
        $barang = Barang::findOrFail($id);

        // Cari apakah barang sudah ada di keranjang user ini
        $cartItem = Card::where('user_id', $userId)->where('product_id', $id)->first();

        if ($cartItem) {
            // Update jumlah barang, jika stok memungkinkan
            if ($cartItem->jumlah < $barang->stok) {
                $cartItem->increment('jumlah', 1);
                return redirect()->route('keranjang.katalog')->with('success', 'Jumlah barang berhasil ditambah.');
            } else {
                return redirect()->route('keranjang.katalog')->with('error', 'Stok barang tidak cukup.');
            }
        } else {
            // Tambah barang baru ke keranjang
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

    public function checkout()
    {
        $userId = Auth::id();
        
        // Ambil semua item keranjang untuk validasi stok
        $keranjangItems = Card::with('product')->where('user_id', $userId)->get();
        
        if ($keranjangItems->isEmpty()) {
            return redirect()->route('keranjang.katalog')->with('error', 'Keranjang kosong!');
        }
        
        // Validasi stok sebelum checkout
        foreach ($keranjangItems as $item) {
            if ($item->jumlah > $item->product->stok) {
                return redirect()->route('keranjang.katalog')->with('error', 
                    'Stok ' . $item->product->nama . ' tidak mencukupi (Tersedia: ' . $item->product->stok . ')');
            }
        }
        
        // Kurangi stok barang
        foreach ($keranjangItems as $item) {
            $barang = Barang::find($item->product_id);
            $barang->decrement('stok', $item->jumlah);
        }
        
        // Hapus semua item dari keranjang
        Card::where('user_id', $userId)->delete();

        return redirect()->route('keranjang.katalog')->with('success', 'Checkout berhasil! Terima kasih atas pembelian Anda.');
    }
}
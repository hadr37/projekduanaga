<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Barang;

class KatalogController extends Controller
{
    // Tampilkan katalog
    public function index()
    {
        $barangs = Barang::all();
        return view('katalog.index', compact('barangs'));
    }

    // Tambah barang ke keranjang session
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

    // Tampilkan halaman checkout
    public function checkout()
    {
        $keranjang = session()->get('keranjang', []);
        return view('katalog.checkout', compact('keranjang'));
    }

    // Proses checkout
    public function prosesCheckout(Request $request)
    {
        $userId = Auth::id();
        $keranjang = session()->get('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->route('katalog.checkout')->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();
        try {
            // Hitung total
            $total = array_sum(array_map(fn($item) => $item['harga'] * $item['jumlah'], $keranjang));

            // Simpan pesanan
            $pesanan = Pesanan::create([
                'user_id' => $userId,
                'status' => 'pemrosesan',
                'total' => $total,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'bank' => $request->bank,
                'nama_rekening' => $request->nama_rekening,
                'no_rekening' => $request->no_rekening,
            ]);

            // Simpan detail pesanan dan kurangi stok
            foreach ($keranjang as $id => $item) {
                PesananDetail::create([
                    'pesanan_id' => $pesanan->id,
                    'product_id' => $id,
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                ]);

                $barang = Barang::find($id);
                $barang->decrement('stok', $item['jumlah']);
            }

            // Hapus keranjang session
            session()->forget('keranjang');

            DB::commit();
            return redirect()->route('katalog.pesanan')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    // Tampilkan halaman "Pesanan Saya"
    public function pesanan()
    {
        $pesanan = Pesanan::with('details.product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('katalog.pesanan', compact('pesanan'));
    }
}

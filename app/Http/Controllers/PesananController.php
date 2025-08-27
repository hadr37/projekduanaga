<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\AlamatUser;
use App\Models\PesananDetail;
use App\Models\Barang;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Simpan pesanan baru (checkout).
     */
    public function store(Request $request)
    {
        // Validasi awal
        $rules = [
            'jenis_pembayaran' => 'required|string',
            'bank'             => 'required|string',
            'nama_rekening'    => 'required|string|max:255',
        ];

        // Jika bukan virtual account → nomor rekening wajib diisi
        if ($request->jenis_pembayaran !== 'virtual_account') {
            $rules['no_rekening'] = 'required|string|max:50';
        }

        $request->validate($rules);

        // Ambil keranjang user
        $keranjang = Card::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('katalog.shop')->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();
        try {
            // Validasi stok
            foreach ($keranjang as $item) {
                if ($item->product->stok < $item->jumlah) {
                    throw new \Exception("Stok {$item->product->nama_barang} tidak mencukupi. Tersedia: {$item->product->stok}");
                }
            }

            // Hitung total
            $total = $keranjang->sum(fn($item) => $item->product->harga * $item->jumlah);

            // Ambil alamat default user (opsional)
            $alamat = AlamatUser::where('user_id', Auth::id())
                ->where('is_default', 1)
                ->first();

            // Buat pesanan dulu (sementara no_rekening kosong)
            $pesanan = Pesanan::create([
                'user_id'          => Auth::id(),
                'total'            => $total,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'bank'             => $request->bank,
                'nama_rekening'    => $request->nama_rekening,
                'no_rekening'      => $request->no_rekening ?? null,
                'status'           => 'pemrosesan'
            ]);

            // Jika Virtual Account → generate nomor rekening otomatis
            if ($request->jenis_pembayaran === 'virtual_account') {
                $noVA = "VA" . str_pad($pesanan->id, 6, "0", STR_PAD_LEFT);
                $pesanan->update(['no_rekening' => $noVA]);
            }

            // Simpan detail pesanan + kurangi stok
            foreach ($keranjang as $item) {
                PesananDetail::create([
                    'pesanan_id' => $pesanan->id,
                    'product_id' => $item->product_id,
                    'jumlah'     => $item->jumlah,
                    'harga'      => $item->product->harga
                ]);

                $item->product->decrement('stok', $item->jumlah);
            }

            // Kosongkan keranjang
            Card::where('user_id', Auth::id())->delete();

            DB::commit();
            return redirect()->route('katalog.pesanan')
                ->with('success', 'Pesanan berhasil dibuat! Kode Pesanan: #' . $pesanan->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Halaman "Pesanan Saya" untuk user.
     */
    public function index(Request $request)
    {
        $query = Pesanan::with('details.product')->where('user_id', Auth::id());

        $status = $request->status ?? 'all';
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $pesanan = $query->orderBy('created_at', 'desc')->get();

        if ($request->ajax()) {
            $html = view('katalog.pesanan', compact('pesanan'))->render();
            return response()->json(['html' => $html]);
        }

        return view('katalog.pesanan', compact('pesanan'));
    }

    /**
     * Batalkan pesanan.
     */
    public function cancel($id)
    {
        $pesanan = Pesanan::with('details.product')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($pesanan->status == 'pemrosesan') {
            DB::transaction(function () use ($pesanan) {
                foreach ($pesanan->details as $detail) {
                    $detail->product->increment('stok', $detail->jumlah);
                }
                $pesanan->update(['status' => 'dibatalkan']);
            });

            return redirect()->route('katalog.pesanan')->with('success', 'Pesanan berhasil dibatalkan!');
        }

        return redirect()->route('katalog.pesanan')->with('error', 'Pesanan tidak bisa dibatalkan.');
    }

    /**
     * Daftar semua pesanan untuk admin.
     */
    public function adminIndex()
    {
        $pesanan = Pesanan::with(['details.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pesanan.index', compact('pesanan'));
    }

    /**
     * Update status pesanan (admin).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pemrosesan,dikirim,diterima,dibatalkan,refund'
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => $request->status]);

        return redirect()->route('admin.pesanan.index')->with('success', 'Status pesanan berhasil diupdate!');
    }

    /**
     * Halaman checkout.
     */
    public function checkout()
    {
        $keranjang = Card::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('katalog.shop')->with('error', 'Keranjang masih kosong.');
        }

        $total = $keranjang->sum(fn($c) => $c->jumlah * $c->product->harga);

        $alamat = AlamatUser::where('user_id', Auth::id())
            ->where('is_default', 1)
            ->first();

        return view('katalog.checkout', compact('keranjang', 'total', 'alamat'));
    }
}

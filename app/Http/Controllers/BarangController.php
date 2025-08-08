<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    // Tampilkan daftar barang + filter
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        // terima baik 'kategori_id' (disarankan) ataupun 'kategori' (compatibilitas)
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        } elseif ($request->filled('kategori')) {
            // jika front-end masih mengirim nama kategori
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        $barangs = $query->get();

        // daftar kategori untuk dropdown
        $kategoris = Kategori::all();

        // jumlah barang per kategori (key = nama_kategori) — kompatibel dengan kode lama
        $kategoriCount = Kategori::withCount('barang')->pluck('barang_count', 'nama_kategori');

        return view('barang.index', compact('barangs', 'kategoris', 'kategoriCount'));
    }

    // Form tambah
    public function create()
    {
        $kategoris = Kategori::all();
        $kategoriCount = Kategori::withCount('barang')->pluck('barang_count', 'nama_kategori');
        return view('barang.create', compact('kategoris', 'kategoriCount'));
    }

    // Simpan data
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        Barang::create($validated);
        return redirect()->route('barang.index')->with('success', 'Data berhasil ditambahkan.');
    }

    // Form edit
    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        $kategoriCount = Kategori::withCount('barang')->pluck('barang_count', 'nama_kategori');
        return view('barang.edit', compact('barang', 'kategoris', 'kategoriCount'));
    }

    // Update data
    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        $barang->update($validated);
        return redirect()->route('barang.index')->with('success', 'Data berhasil diupdate.');
    }

    // Hapus data
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Data berhasil dihapus.');
    }

    // Halaman katalog depan (limit 6)
    public function katalog(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $barangs = $query->limit(6)->get();
        $kategoris = Kategori::all();
        $kategoriCount = Kategori::withCount('barang')->pluck('barang_count', 'nama_kategori');

        return view('katalog.index', compact('barangs', 'kategoris', 'kategoriCount'));
    }

    // Halaman shop dengan sorting
    public function shop(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->sort == 'harga_asc') {
            $query->orderBy('harga', 'asc');
        } elseif ($request->sort == 'harga_desc') {
            $query->orderBy('harga', 'desc');
        } elseif ($request->sort == 'stok_asc') {
            $query->orderBy('stok', 'asc');
        } elseif ($request->sort == 'stok_desc') {
            $query->orderBy('stok', 'desc');
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $barangs = $query->get();
        $kategoris = Kategori::all();
        $kategoriCount = Kategori::withCount('barang')->pluck('barang_count', 'nama_kategori');

        return view('katalog.shop', compact('barangs', 'kategoris', 'kategoriCount'));
    }
}

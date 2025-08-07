<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        // Search by nama_barang
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Get all barangs sesuai filter
        $barangs = $query->get();

        // Ambil jumlah barang per kategori
        $kategoriCount = Barang::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        // List kategori unik untuk dropdown
        $kategoriList = Barang::select('kategori')->distinct()->pluck('kategori');

        return view('barang.index', compact('barangs', 'kategoriCount', 'kategoriList'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = $gambarPath;
        }

        Barang::create($validated);
        return redirect()->route('barang.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('barang', 'public');
            $validated['gambar'] = $gambarPath;
        }

        $barang->update($validated);
        return redirect()->route('barang.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Data berhasil dihapus.');
    }

    // Halaman katalog 
   public function katalog(Request $request)
{
    $query = Barang::query();

    if ($request->filled('search')) {
        $query->where('nama_barang', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    $barangs = $query->limit(6)->get();
    $kategoriList = Barang::select('kategori')->distinct()->pluck('kategori');

    return view('katalog.index', compact('barangs', 'kategoriList'));
}
public function shop(Request $request)
{
    $query = Barang::query();

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

    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    $barangs = $query->get();
    $kategoriList = Barang::select('kategori')->distinct()->pluck('kategori');

    return view('katalog.shop', compact('barangs', 'kategoriList'));
}


    
}

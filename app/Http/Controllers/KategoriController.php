<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Kategori::query();

        if ($request->filled('search')) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        $kategoris = $query->orderBy('nama_kategori')->get();

        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $data = $request->only(['nama_kategori', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('kategori', 'public');
        }

        Kategori::create($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $data = $request->only(['nama_kategori', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            if ($kategori->gambar && Storage::disk('public')->exists($kategori->gambar)) {
                Storage::disk('public')->delete($kategori->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('kategori', 'public');
        }

        $kategori->update($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->gambar && Storage::disk('public')->exists($kategori->gambar)) {
            Storage::disk('public')->delete($kategori->gambar);
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus');
    }

    public function katalogKosmetik()
    {
        $kategoris = Kategori::where('nama_kategori', 'like', '%Kosmetik%')->get();
        return view('keranjang.katalog', compact('kategoris'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // ===============================
    // 📊 Dashboard Admin
    // ===============================
   public function dashboard()
{
    // =========================
    // Ringkasan
    // =========================
    $totalBarang   = (int) Barang::count();
    $totalUser     = (int) User::count();
    $totalKategori = (int) Kategori::count();
    $totalStok     = (int) Barang::sum('stok');

    // =========================
    // Data kategori
    // =========================
    $kategoriList = Kategori::select('id', 'nama_kategori')
        ->orderBy('nama_kategori')
        ->get();

    // Jumlah barang per kategori
    $countMap = Barang::selectRaw('kategori_id, COUNT(*) as jumlah')
        ->groupBy('kategori_id')
        ->pluck('jumlah', 'kategori_id');

    // Total stok per kategori
    $stokMap = Barang::selectRaw('kategori_id, COALESCE(SUM(stok), 0) as total_stok')
        ->groupBy('kategori_id')
        ->pluck('total_stok', 'kategori_id');

    // Siapkan data chart kategori
    $kategoriLabels = $kategoriList->pluck('nama_kategori');
    $kategoriData   = $kategoriList->map(
        fn($k) => (int) ($countMap[$k->id] ?? 0)
    );
    $stokData       = $kategoriList->map(
        fn($k) => (int) ($stokMap[$k->id] ?? 0)
    );

    // =========================
    // Data barang
    // =========================
    $barangList  = Barang::select('nama_barang', 'stok')->orderBy('nama_barang')->get();
    $barangLabels = $barangList->pluck('nama_barang');
    $barangStok   = $barangList->pluck('stok')->map(fn($s) => (int) $s);

    // =========================
    // Kirim ke view
    // =========================
    return view('admin.dashboard', [
        'totalBarang'    => $totalBarang,
        'totalUser'      => $totalUser,
        'totalKategori'  => $totalKategori,
        'totalStok'      => $totalStok,
        'kategoriLabels' => $kategoriLabels,
        'kategoriData'   => $kategoriData,
        'stokData'       => $stokData,
        'barangLabels'   => $barangLabels,
        'barangStok'     => $barangStok,
    ]);
}



    // ===============================
    // 📦 Daftar Barang (Admin)
    // ===============================
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        // Pencarian nama barang
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $barangs   = $query->orderBy('nama_barang')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.barang.index', compact('barangs', 'kategoris'));
    }

    // Form tambah barang
    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('admin.barang.create', compact('kategoris'));
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi'   => 'nullable',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        Barang::create($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Data berhasil ditambahkan.');
    }

    // Form edit barang
    public function edit(Barang $barang)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    // Update barang
    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi'   => 'nullable',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        $barang->update($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Data berhasil diupdate.');
    }

    // Hapus barang
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('admin.barang.index')->with('success', 'Data berhasil dihapus.');
    }

    // ===============================
    // 🛍️ Katalog depan (limit 6 barang)
    // ===============================
    public function katalog(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $barangs   = $query->limit(6)->get();
        $kategoris = Kategori::all();

        return view('katalog.index', compact('barangs', 'kategoris'));
    }

    // ===============================
    // 🛒 Shop (dengan sorting & filter)
    // ===============================
    public function shop(Request $request)
    {
        $query = Barang::with('kategori');

        // Pencarian
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        // Sorting
        if ($request->sort === 'harga_asc') {
            $query->orderBy('harga', 'asc');
        } elseif ($request->sort === 'harga_desc') {
            $query->orderBy('harga', 'desc');
        } elseif ($request->sort === 'stok_asc') {
            $query->orderBy('stok', 'asc');
        } elseif ($request->sort === 'stok_desc') {
            $query->orderBy('stok', 'desc');
        }

        // Filter kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $barangs   = $query->get();
        $kategoris = Kategori::all();

        return view('katalog.shop', compact('barangs', 'kategoris'));
    }
}

@extends('adminlte::page')
@section('title', 'Data Barang')

@section('content_header')
    <h1>Data Barang</h1>
@endsection

@section('content')

    {{-- 🔍 Form Search & Filter --}}
    <form method="GET" class="row mb-4 g-2 align-items-end">
        <div class="col-md-4">
            <label for="search" class="form-label">Cari Nama Barang</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Contoh: Facial Wash">
        </div>
        <div class="col-md-4">
            <label for="kategori" class="form-label">Filter Kategori</label>
            <select name="kategori" id="kategori" class="form-select">
                <option value="">-- Semua Kategori --</option>
                @foreach ($kategoris as $kategori)
    <option value="{{ $kategori->nama_kategori }}" {{ request('kategori') == $kategori->nama_kategori ? 'selected' : '' }}>
        {{ $kategori->nama_kategori }}
    </option>
@endforeach

            </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">🔎 Cari</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">🔄 Reset</a>
        </div>
    </form>

    {{-- 🧾 Statistik Jumlah per Kategori --}}
    @if ($kategoriCount->count())
        <div class="mb-3">
            <strong>📊 Jumlah Barang per Kategori:</strong>
            <ul>
                @foreach ($kategoriCount as $kategori => $total)
                    <li>{{ $kategori }}: {{ $total }} item</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ➕ Tombol Tambah --}}
    <a href="{{ route('barang.create') }}" class="btn btn-success mb-3">+ Tambah Barang</a>

    {{-- 📋 Tabel --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($barangs as $barang)
                <tr>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->kategori }}</td>
                    <td>{{ $barang->deskripsi }}</td>
                    <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                    <td>{{ $barang->stok }}</td>
                    <td>
                        @if($barang->gambar)
                            <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar {{ $barang->nama_barang }}" width="100">
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Tidak ada data barang ditemukan.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('content')

    @include('layouts.navbar')

    <div class="container mt-5 pt-3">

        {{-- FILTER, SORTING, SEARCH --}}
        <form method="GET" action="{{ route('katalog.shop') }}#katalog" class="row g-2 mb-4">
            <div class="col-md-4">
                <label for="kategori_id" class="form-label">Filter Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-select">
                    <option value="">-- Semua Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Urutkan</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Pilih</option>
                    <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga Termahal</option>
                    <option value="stok_asc" {{ request('sort') == 'stok_asc' ? 'selected' : '' }}>Stok Terendah</option>
                    <option value="stok_desc" {{ request('sort') == 'stok_desc' ? 'selected' : '' }}>Stok Terbanyak</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari produk...">
            </div>

            <div class="col-md-1 d-grid align-items-end">
                <button type="submit" class="btn btn-success" title="Terapkan Filter">
                    <i class="fas fa-filter"></i>
                </button>
            </div>

            <div class="col-md-1 d-grid align-items-end">
                <a href="{{ route('katalog.shop') }}#katalog" class="btn btn-outline-danger" title="Reset Filter">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </div>
        </form>

        {{-- KATALOG --}}
        <div id="katalog" class="katalog-container">
            @forelse ($barangs as $barang)
                <div class="katalog-card position-relative">

                    {{-- Badge kategori --}}
                    <div class="badge">{{ $barang->kategori->nama_kategori ?? 'Tidak ada kategori' }}</div>

                    {{-- Gambar barang --}}
                    @php
                        $gambar = $barang->gambar
                            ? (Str::startsWith($barang->gambar, ['http', 'assets/'])
                                ? asset($barang->gambar)
                                : asset('storage/' . $barang->gambar))
                            : 'https://via.placeholder.com/300x180?text=No+Image';
                    @endphp
                    <img src="{{ $gambar }}" alt="{{ $barang->nama_barang }}">

                    {{-- Body --}}
                    <div class="katalog-body">
                        <div class="katalog-title">{{ $barang->nama_barang }}</div>
                        <div class="katalog-desc">{{ $barang->deskripsi }}</div>
                        <div class="text-muted mt-1" style="font-size:12px;">
                            Stok: {{ $barang->stok }}
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="katalog-footer">
                        <div class="harga">Rp {{ number_format($barang->harga, 0, ',', '.') }}</div>
                        <a href="{{ route('produk.show', $barang->id) }}" >Lihat Detail</a>
                        @auth
                        <form action="{{ route('keranjang.tambah', $barang->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-cart">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </form>
                         @endauth
                    </div>

                </div>
            @empty
                <p class="text-muted">Barang tidak ditemukan.</p>
            @endforelse
        </div>

    </div>
@endsection
    
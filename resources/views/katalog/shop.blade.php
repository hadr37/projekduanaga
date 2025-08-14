<!-- resources/views/katalog/shop.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop - Skincare Dua Naga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <style>
        body { padding-top: 90px; }
        .katalog-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding: 20px;
        }
        .katalog-card {
            border: 1px solid #eee;
            border-radius: 10px;
            background: #fff;
            overflow: hidden;
            transition: 0.2s;
        }
        .katalog-card:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }
        .katalog-card img {
            width: 100%;
            height: 140px;
            object-fit: contain;
            background-color: #f9f9f9;
        }
        .katalog-body { padding: 10px; }
        .katalog-title {
            font-size: 14px;
            font-weight: 600;
        }
        .katalog-desc {
            font-size: 12px;
            color: #666;
            height: 38px;
            overflow: hidden;
        }
        .katalog-footer {
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f0f0f0;
        }
        .harga {
            color: #198754;
            font-weight: bold;
            font-size: 14px;
        }
        .btn-cart {
            font-size: 13px;
            padding: 5px 10px;
            border: 1px solid #198754;
            color: #198754;
            background: white;
            border-radius: 20px;
            transition: 0.2s;
            cursor: pointer;
        }
        .btn-cart:hover {
            background: #198754;
            color: white;
        }
        .badge {
            position: absolute;
            background: #76c043;
            color: white;
            padding: 3px 8px;
            font-size: 11px;
            border-radius: 20px;
            top: 8px;
            right: 8px;
        }
        @media (max-width: 991px) {
            .katalog-container { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 575px) {
            .katalog-container { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

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
            <div class="badge">
                {{ $barang->kategori->nama_kategori ?? 'Tidak ada kategori' }}
            </div>

            {{-- Gambar barang --}}
@php
    $gambar = $barang->gambar
        ? (Str::startsWith($barang->gambar, ['http', 'assets/'])
            ? asset($barang->gambar) // Seeder (public path) atau URL langsung
            : asset('storage/' . $barang->gambar)) // Upload manual
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
                <div class="harga">
                    Rp {{ number_format($barang->harga, 0, ',', '.') }}
                </div>
                <a href="{{ route('produk.show', $barang->id) }}" class="btn-cart">
    <i class="fas fa-cart-plus"></i>
</a>

            </div>
        </div>
    @empty
        <p class="text-muted">Barang tidak ditemukan.</p>
    @endforelse
</div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

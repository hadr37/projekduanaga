@extends('layouts.app')

@section('content')

    <style>
        .container-fluid.fixed-top {
        border-radius: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        background: var(--bs-primary, #0d6efd) !important; /* fallback biru */
    }
        body { 
            padding-top: 100px; 
            font-family: 'Open Sans', sans-serif; 
        }
        .produk-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .produk-card {
            border: 1px solid #eee;
            border-radius: 10px;
            background: #fff;
            padding: 20px;
        }
        .produk-image img {
            width: 100%;
            border-radius: 10px;
            background-color: #f9f9f9;
            object-fit: contain;
        }
        .produk-details h2 {
            font-weight: bold;
            margin-bottom: 15px;
        }
        .produk-details ul {
            padding-left: 18px;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .btn-offer {
            background: black;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s;
            display: inline-block;
            margin-top: 15px;
        }
        .btn-offer:hover {
            background: #333;
        }
        /* Agar kategori tidak terpotong */
        .produk-kategori {
            font-size: 14px;
            color: #888;
            white-space: normal !important;
            word-break: break-word;
            line-height: 1.5;
            margin-bottom: 8px;
            display: block;
        }
        @media(max-width: 768px) {
            .produk-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>


<div class="container">
    <div class="produk-container">

        {{-- Gambar Produk --}}
        <div class="produk-card produk-image">
            @php
                $gambar = $barang->gambar
                    ? (Str::startsWith($barang->gambar, ['http', 'assets/']) 
                        ? asset($barang->gambar) 
                        : asset('storage/' . $barang->gambar))
                    : 'https://via.placeholder.com/400x400?text=No+Image';
            @endphp
            <img src="{{ $gambar }}" alt="{{ $barang->nama_barang }}">
        </div>

        {{-- Detail Produk --}}
        <div class="produk-card produk-details">
            <p class="produk-kategori">
                Kategori: <span class="text-warning">{{ $barang->kategori->nama_kategori ?? 'Tidak ada kategori' }}</span>
            </p>
            <h2>{{ $barang->nama_barang }}</h2>

            {{-- Deskripsi Produk --}}
            <div class="produk-deskripsi">
                <h3>Deskripsi Produk</h3>
                <p>{!! nl2br(e($barang->deskripsi)) !!}</p>
            </div>

            {{-- Manfaat Produk --}}
            @if(!empty($barang->manfaat))
                <h4>Manfaat</h4>
                <ul>
                    @foreach(explode('|', $barang->manfaat) as $m)
                        @if(trim($m) !== '')
                            <li>{{ $m }}</li>
                        @endif
                    @endforeach
                </ul>
            @endif

            <a href="#" class="btn-offer">Dapatkan Penawaran</a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

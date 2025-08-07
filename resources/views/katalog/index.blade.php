@extends('layouts.fruitables')

@section('content')
<!-- Product Section Start -->
<div class="container py-5">
    <div class="row g-4">
        @foreach($barangs as $barang)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="product-item bg-light border border-1 rounded p-3 h-100">
                <div class="position-relative overflow-hidden">
                    <a href="#">
                        <img class="img-fluid w-100" src="{{ asset('storage/' . $barang->gambar) }}" alt="{{ $barang->nama_barang }}">
                    </a>
                </div>
                <div class="text-center mt-3">
                    <h6 class="fw-bold mb-1">{{ $barang->nama_barang }}</h6>
                    <p class="text-muted small mb-2">{{ Str::limit($barang->deskripsi, 50) }}</p>
                    <span class="text-success fw-bold">Rp{{ number_format($barang->harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Product Section End -->
@endsection

@extends('adminlte::page')

@section('title', 'Tambah Data Barang')

@section('content_header')
    <h1>Tambah Data Barang</h1>
@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" name="kode_barang" value="{{ old('kode_barang') }}" class="form-control" placeholder="Contoh: BRG001" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" class="form-control" placeholder="Contoh: Facial Wash XYZ" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" placeholder="Opsional: Tuliskan keunggulan produk...">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga') }}" class="form-control" placeholder="cth: 25000" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" value="{{ old('stok') }}" class="form-control" placeholder="cth: 10" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Gambar Barang</label>
            <input type="file" name="gambar" class="form-control-file" accept="image/*">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                ← Batal
            </a>
            <button type="submit" class="btn btn-success">
                💾 Simpan Data
            </button>
        </div>
    </form>
@stop

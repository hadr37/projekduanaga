@extends('adminlte::page')

@section('title', 'Edit Barang')

@section('content_header')
    <h1>Edit Barang</h1>
@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" class="form-control" required>
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
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga', $barang->harga) }}" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $barang->stok) }}" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Gambar Barang</label>
            <input type="file" name="gambar" class="form-control-file" accept="image/*">
            @if ($barang->gambar)
                <div class="mt-2">
                    <small>Gambar saat ini:</small><br>
                    <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar Barang" class="img-thumbnail" style="max-width: 150px;">
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">← Kembali</a>
            <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
        </div>
    </form>
@stop

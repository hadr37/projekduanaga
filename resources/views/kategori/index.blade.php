@extends('adminlte::page')

@section('title', 'Data Kategori')

@section('content_header')
    <h1>Data Kategori</h1>
@stop

@section('content')
    <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>

    {{-- Form pencarian --}}
    <form action="{{ route('kategori.index') }}" method="GET" class="mb-3">
        <div class="input-group" style="max-width: 400px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama kategori..."
                value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $kategori)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>
                        <a href="{{ route('kategori.edit', $kategori) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus kategori ini?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">Kategori tidak ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>
@stop

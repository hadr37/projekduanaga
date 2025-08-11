@extends('adminlte::page')

@section('title', 'Daftar Users')

@section('content_header')
    <h1>Daftar Users</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">Tambah User</a>
<form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama atau email...">
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </div>
</form>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Users</h3>
    </div>
    <div class="card-body table-responsive p-0" style="max-height: 450px;">
        <table class="table table-hover text-nowrap table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm" title="Edit">Edit
                        </a>

                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $users->links() }}
    </div>
</div>

@stop

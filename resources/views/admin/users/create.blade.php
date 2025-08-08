@extends('adminlte::page')

@section('title', 'Tambah User')
@php
    $isCreate = isset($user) ? false : true;
@endphp

@section('content_header')
    <h1>Tambah User</h1>
@stop

@section('content')

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror" required>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror" required>
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

         <div class="form-group">
    <label for="password">Password</label>
    <div class="input-group">
        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" {{ $isCreate ? 'required' : '' }}>
        <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary btn-toggle-password" data-target="#password" tabindex="-1">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group">
    <label for="password_confirmation">Konfirmasi Password</label>
    <div class="input-group">
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" {{ $isCreate ? 'required' : '' }}>
        <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary btn-toggle-password" data-target="#password_confirmation" tabindex="-1">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        @error('password_confirmation')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </form>
        <script>
document.querySelectorAll('.btn-toggle-password').forEach(button => {
    button.addEventListener('click', () => {
        const input = document.querySelector(button.dataset.target);
        if (input.type === 'password') {
            input.type = 'text';
            button.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            input.type = 'password';
            button.innerHTML = '<i class="fas fa-eye"></i>';
        }
    });
});
</script>

    </div>
</div>

@stop

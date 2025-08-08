@extends('adminlte::page')

@section('title', 'Edit User')
@php
    $isCreate = isset($user) ? false : true;
@endphp

@section('content_header')
    <h1>Edit User</h1>
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
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="form-control @error('name') is-invalid @enderror" required>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="form-control @error('email') is-invalid @enderror" required>
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                </select>
                @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

           <div class="form-group">
    <label for="old_password">Password Lama</label>
    <div class="input-group">
        <input type="password" name="old_password" id="old_password" class="form-control" autocomplete="current-password">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary btn-toggle-password" type="button" data-target="#old_password">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="password">Password Baru</label>
    <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary btn-toggle-password" type="button" data-target="#password">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="password_confirmation">Konfirmasi Password Baru</label>
    <div class="input-group">
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary btn-toggle-password" type="button" data-target="#password_confirmation">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </div>
</div>



            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </form>

    <script>
document.querySelectorAll('.btn-toggle-password').forEach(button => {
  button.addEventListener('click', () => {
    const input = document.querySelector(button.dataset.target);
    if (!input) return;

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

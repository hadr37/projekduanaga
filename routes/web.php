<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeranjangController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', function () {
    return view('home');
});

// Login & Register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Barang (Admin Resource)
Route::resource('barang', BarangController::class);

// Katalog & Shop (User)
Route::get('/katalog', [BarangController::class, 'katalog'])->name('katalog');
Route::get('/shop', [BarangController::class, 'shop'])->name('katalog.shop');

// Keranjang
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
});

// Redirect dashboard sesuai role
Route::middleware(['auth'])->group(function () {
    Route::get('admin/katalog', [BarangController::class, 'index']) // halaman admin
    ->name('admin.dashboard');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('layouts.fruitables'); // halaman user
    })->name('user.katalog');
});

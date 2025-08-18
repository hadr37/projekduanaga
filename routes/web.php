<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('layouts.fruitables'); // Halaman utama
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication (User & Admin)
|--------------------------------------------------------------------------
*/
// Login & Register User
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Register Admin
Route::get('/register/admin', [AuthController::class, 'showRegisterAdmin'])->name('register.admin');
Route::post('/register/admin', [AuthController::class, 'registerAdmin']);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Buat file resources/views/admin/dashboard.blade.php
    })->name('admin.dashboard');

    // CRUD Users
    Route::resource('users', UserController::class);

    // CRUD Barang
    Route::resource('barang', BarangController::class);

    // CRUD Kategori
    Route::resource('kategori', KategoriController::class);
});

/*
|--------------------------------------------------------------------------
| User Routes (Katalog & Shop)
|--------------------------------------------------------------------------
*/
Route::get('/katalog', [BarangController::class, 'katalog'])->name('katalog');
Route::get('/shop', [BarangController::class, 'shop'])->name('katalog.shop');

/*
|--------------------------------------------------------------------------
| Keranjang & Checkout (User)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');

    // Dashboard User
    Route::get('/user/dashboard', function () {
        return view('layouts.fruitables');
    })->name('user.katalog');
});

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // resources/views/admin/dashboard.blade.php
    })->name('dashboard');

    // CRUD Users
    Route::resource('users', UserController::class);

    // CRUD Barang
    Route::resource('barang', BarangController::class);

    // CRUD Kategori
    Route::resource('kategori', KategoriController::class);
});
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
Route::resource('barang', BarangController::class);
Route::resource('kategori', KategoriController::class);
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});
Route::get('/admin/dashboard', [BarangController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.katalog');
Route::post('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
Route::delete('/keranjang/delete/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');


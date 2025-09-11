<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home.index'); // Halaman utama
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
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Register Admin
Route::get('/register/admin', [AuthController::class, 'showRegisterAdmin'])->name('register.admin');
Route::post('/register/admin', [AuthController::class, 'registerAdmin']);

/*
|--------------------------------------------------------------------------
| Admin Routes (Versi 1)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
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
| Keranjang & Checkout (User - Versi 1)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');

    // Dashboard User
    Route::get('/user/dashboard', function () {
        return view('home.index');
    })->name('user.katalog');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Versi 2)
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Produk
|--------------------------------------------------------------------------
*/
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');

/*
|--------------------------------------------------------------------------
| Barang & Kategori (Versi resource di luar group)
|--------------------------------------------------------------------------
*/
Route::resource('barang', BarangController::class);
Route::resource('kategori', KategoriController::class);

/*
|--------------------------------------------------------------------------
| Admin Routes (Versi 3 - hanya Users)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});

/*
|--------------------------------------------------------------------------
| Admin Dashboard (Versi 4)
|--------------------------------------------------------------------------
*/
Route::get('/admin/dashboard', [BarangController::class, 'dashboard'])->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| Keranjang (Versi 2)
|--------------------------------------------------------------------------
*/
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.katalog');
Route::post('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
Route::delete('/keranjang/delete/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');

/*
|--------------------------------------------------------------------------
| Contact
|--------------------------------------------------------------------------
*/
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/{id}/set-default', [ProfileController::class, 'setDefault'])->name('profile.setDefault');
});

/*
|--------------------------------------------------------------------------
| Checkout & Pesanan (User)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Checkout
    Route::get('/checkout', [PesananController::class, 'checkout'])->name('katalog.checkout');
    Route::post('/checkout/proses', [PesananController::class, 'store'])->name('katalog.checkout.proses');

    // Pesanan User
    Route::get('/pesanan', [PesananController::class, 'index'])->name('katalog.pesanan');
    Route::post('/pesanan/{id}/cancel', [PesananController::class, 'cancel'])->name('pesanan.cancel');
});

/*
|--------------------------------------------------------------------------
| Pesanan (Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/pesanan', [PesananController::class, 'adminIndex'])->name('admin.pesanan.index');
    Route::post('/admin/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('admin.pesanan.updateStatus');
});

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Kategori;

use App\Models\Barang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagi variabel kategori ke semua view
        View::share('kategoris', Kategori::orderBy('nama_kategori')->get());
         View::share('barangs', Barang::with('kategori')->orderBy('nama_barang')->get());
        // Kalau mau sekalian hitung jumlah barang per kategori
        View::share('kategoriCount', Kategori::withCount('barang')->pluck('barang_count', 'nama_kategori'));
    }
}

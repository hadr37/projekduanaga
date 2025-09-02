<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
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
        // Cek tabel ada dulu sebelum query
        if (Schema::hasTable('kategoris') && Schema::hasTable('barangs')) {
            // Share ke SEMUA view (pakai '*')
            View::composer('*', function ($view) {
                $view->with('kategoris', Kategori::orderBy('nama_kategori')->get());
                $view->with('barangs', Barang::with('kategori')->orderBy('nama_barang')->get());
                $view->with('kategoriCount', Kategori::withCount('barang')->pluck('barang_count', 'nama_kategori'));
            });
        }
    }
}

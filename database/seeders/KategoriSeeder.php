<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class KategoriSeeder extends Seeder
{
    public function run()
{
    $faker = \Faker\Factory::create();

    if (\App\Models\Kategori::count() > 0) {
        return; // Jangan seed kalau sudah ada kategori
    }

    for ($i = 1; $i <= 10; $i++) {
        \App\Models\Kategori::create([
            'nama_kategori' => $faker->unique()->word(),
            'deskripsi' => $faker->sentence(10),
            'gambar' => 'assets/img/kategori/' . $faker->image('public/assets/img/kategori', 640, 480, null, false),
        ]);
    }
}

}

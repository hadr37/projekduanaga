<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $kategoriList = [];

        for ($i = 1; $i <= 10; $i++) {
            $kategoriList[] = [
                'nama_kategori' => $faker->unique()->word(),
                'deskripsi' => $faker->sentence(10),
                'gambar' => 'assets/img/kategori/' . $faker->image('public/assets/img/kategori', 640, 480, null, false), // generate random image
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('kategoris')->insert($kategoriList);
    }
}


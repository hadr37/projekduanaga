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
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('kategoris')->insert($kategoriList);
    }
}


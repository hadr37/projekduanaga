<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 50; $i++) {
            DB::table('barangs')->insert([
                'kode_barang' => 'BRG' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama_barang' => ucfirst($faker->words(rand(2, 4), true)),
                'kategori_id' => rand(1, 10), 
                'deskripsi' => $faker->sentence(rand(6, 12)),
                'harga' => $faker->numberBetween(10000, 20000000),
                'stok' => $faker->numberBetween(0, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

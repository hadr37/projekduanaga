<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    protected $model = Barang::class;

    public function definition(): array
    {
        return [
            'kode_barang' => $this->faker->unique()->numerify('BRG###'),
            'nama_barang' => $this->faker->word(),
            // ✅ bikin kategori otomatis kalau belum ada
            'kategori_id' => Kategori::factory(),
            'deskripsi'   => $this->faker->sentence(),
            'harga'       => $this->faker->numberBetween(1000, 50000),
            'stok'        => $this->faker->numberBetween(1, 100),
            'gambar'      => $this->faker->imageUrl(200, 200, 'product'),
        ];
    }
}

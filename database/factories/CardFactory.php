<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\User;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition(): array
    {
        return [
            'user_id'    => User::factory(),
            'product_id' => Barang::factory(),
            'jumlah'     => $this->faker->numberBetween(1, 5),
        ];
    }
}

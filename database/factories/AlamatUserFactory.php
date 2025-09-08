<?php

namespace Database\Factories;

use App\Models\AlamatUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlamatUserFactory extends Factory
{
    protected $model = AlamatUser::class;

    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'namapenerima' => $this->faker->name(),
            'no_telepon'   => $this->faker->phoneNumber(),
            'alamat'       => $this->faker->address(),
            'kecamatan_id' => null,
            'kabupaten_id' => null,
            'provinsi_id'  => null,
            'is_default'   => false,
        ];
    }
}

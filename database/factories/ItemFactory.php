<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'location' => $this->faker->city(),
            'stock' => $this->faker->numberBetween(10, 100),
            'unit' => $this->faker->randomElement(['pcs', 'kg', 'ltr']),
        ];
    }
}

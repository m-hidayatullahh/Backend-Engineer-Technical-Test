<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Request;
use App\Models\RequestItem;
use App\Models\Item;

class RequestItemFactory extends Factory
{
    protected $model = RequestItem::class;

    public function definition()
    {
        return [
            'request_id' => Request::inRandomOrder()->first()->id ?? Request::factory(),
            'item_id' => Item::inRandomOrder()->first()->id ?? Item::factory(),
            'quantity_requested' => $this->faker->numberBetween(1, 10),
            'quantity_fulfilled' => 0,
        ];
    }
}

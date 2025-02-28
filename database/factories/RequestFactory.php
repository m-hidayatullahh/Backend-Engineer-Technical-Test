<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Request;
use App\Models\User;

class RequestFactory extends Factory
{
    protected $model = Request::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'status' => 'Pending',
        ];
    }
}

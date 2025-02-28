<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'nik' => $this->faker->unique()->numerify('##########'),
            'name' => $this->faker->name(),
            'department' => $this->faker->randomElement(['IT', 'HR', 'Finance', 'Operations']),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Eatery;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'user_id' => User::query()->inRandomOrder()->value('id'),
            'rating' => fake()->numberBetween(1, 5),
            'body' => fake()->sentences(2, true),
        ];
    }
}

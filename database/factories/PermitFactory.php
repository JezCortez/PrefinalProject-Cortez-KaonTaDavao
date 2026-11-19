<?php

namespace Database\Factories;

use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            // DVO-YYYY-#### matches the regex in StoreEateryRequest
            'permit_no' => sprintf('DVO-%d-%04d', fake()->numberBetween(2025, 2026), fake()->unique()->numberBetween(1000, 4999)),
            'expires_on' => fake()->dateTimeBetween('+2 months', '+2 years'),
        ];
    }

    public function expired(): static
    {
        return $this->state(fn () => [
            'expires_on' => fake()->dateTimeBetween('-6 months', '-2 weeks'),
        ]);
    }
}

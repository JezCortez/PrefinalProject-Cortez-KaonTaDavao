<?php

namespace Database\Factories;

use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

class DishFactory extends Factory
{
    private const DISHES = [
        'Sinigang na Baboy', 'Adobong Manok', 'Kare-Kare', 'Pancit Canton', 'Lechon Kawali',
        'Tinolang Isda', 'Bicol Express', 'Sisig', 'Dinuguan', 'Sinugbang Tilapia',
        'Chicken Inasal', 'Bulalo', 'Halang-halang', 'Pinakbet', 'Kinilaw na Tanigue',
    ];

    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'name' => fake()->randomElement(self::DISHES),
            'price' => fake()->randomFloat(2, 35, 250),
            'is_bestseller' => fake()->boolean(20),
        ];
    }
}

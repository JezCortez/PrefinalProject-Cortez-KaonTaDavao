<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EateryFactory extends Factory
{
    private const NAMES = [
        'Kainan sa Roxas', 'Lutong Bahay ni Aling Nena', 'Tinola House Matina', 'Kinilaw Corner Agdao',
        'Durian Haven', 'Ihaw-Ihaw sa Toril', 'Bahay Kainan ni Mang Ben', 'Sugba Station',
        'Panaderia at Carinderia Lola', 'Tapsilogan sa Buhangin', 'Siomai King Davao', 'Balut and Beer Garden',
        'Pares ni Kuya Jun', 'Pastil Express', 'Lechon Manok Junction', 'Sinigang Sentral',
        'Bulalo Kubo', 'Sizzling Plate Poblacion', 'Halo-Halo Hub', 'Turo-Turo ni Tiya Mel',
    ];

    private const SPECIALTIES = [
        'Kinilaw na Tanigue', 'Sinigang na Baboy', 'Bulalo', 'Tapsilog', 'Sisig',
        'Pares', 'Lechon Manok', 'Pastil', 'Halo-Halo', 'Siomai',
    ];

    public function definition(): array
    {
        $name = fake()->unique()->randomElement(self::NAMES);

        return [
            'district_id' => District::query()->inRandomOrder()->value('id'),
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->buildingNumber() . ' ' . fake()->streetName() . ', Davao City',
            'price_range' => fake()->randomElement(['budget', 'mid', 'splurge']),
            'specialty' => fake()->optional(0.8)->randomElement(self::SPECIALTIES),
            'is_open' => true,
        ];
    }

    public function closed(): static
    {
        return $this->state(fn () => ['is_open' => false]);
    }
}

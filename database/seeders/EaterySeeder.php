<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Dish;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    public function run(): void
    {
        $this->makeMyEatery();
        $this->makeFactoryEateries();
    }

    private function makeMyEatery(): void
    {
        $name = 'Carinderia ni Cortez';
        $poblacion = District::where('name', 'Poblacion')->first();

        $eatery = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        $featureIds = Feature::whereIn('name', ['Suki ni Cortez', 'Budget Meal'])->pluck('id')->all();
        $eatery->features()->sync($featureIds);

        // permit expires on my birthday next year (May 31)
        $eatery->permit()->create([
            'permit_no' => 'DVO-2026-0531',
            'expires_on' => '2027-05-31',
        ]);

        $eatery->dishes()->createMany([
            ['name' => 'Tinolang Manok', 'price' => 85.00, 'is_bestseller' => true],
            ['name' => 'Kinilaw na Tuna', 'price' => 120.00, 'is_bestseller' => false],
            ['name' => 'Durian Shake', 'price' => 75.00, 'is_bestseller' => false],
        ]);
    }

    private function makeFactoryEateries(): void
    {
        $featureIds = Feature::pluck('id');

        // which of the 14 are closed, and which ones get an already-expired permit
        $closed = [4, 9, 13];
        $expiredPermit = [2, 6, 11];

        for ($i = 1; $i <= 14; $i++) {
            $factory = Eatery::factory();

            if (in_array($i, $closed)) {
                $factory = $factory->closed();
            }

            $eatery = $factory->create();

            $permit = Permit::factory()->for($eatery);
            if (in_array($i, $expiredPermit)) {
                $permit = $permit->expired();
            }
            $permit->create();

            Dish::factory()->count(rand(2, 5))->for($eatery)->create();

            $eatery->features()->attach($featureIds->random(rand(1, 3))->all());
        }
    }
}

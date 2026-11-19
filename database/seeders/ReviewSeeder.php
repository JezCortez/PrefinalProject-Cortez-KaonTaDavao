<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $mine = Eatery::where('slug', 'carinderia-ni-cortez')->first();
        $jez = User::where('email', 'cortez@kaonta.test')->first();
        $tita = User::where('email', 'tita.cortez@kaonta.test')->first();
        $someoneElse = User::whereNotIn('id', [$jez->id, $tita->id])->first();

        $mine->reviews()->createMany([
            ['user_id' => $tita->id, 'rating' => 5, 'body' => 'Lami kaayo! Balik-balikan ni Tita Cortez.'],
            ['user_id' => $jez->id, 'rating' => 4, 'body' => 'Sulit ang tinola, init pa gyud ang sabaw.'],
            ['user_id' => $someoneElse->id, 'rating' => 5, 'body' => 'Tama ang presyo ug dako ang servings.'],
        ]);

        // the other open eateries get 0 to 6 random reviews, closed ones get none
        Eatery::where('is_open', true)
            ->where('id', '!=', $mine->id)
            ->get()
            ->each(function (Eatery $eatery) {
                Review::factory()->count(rand(0, 6))->for($eatery)->create();
            });
    }
}

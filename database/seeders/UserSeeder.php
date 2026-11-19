<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('kaonta2026');

        User::create([
            'name' => 'Jez Cortez',
            'email' => 'cortez@kaonta.test',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Tita Cortez',
            'email' => 'tita.cortez@kaonta.test',
            'password' => $password,
        ]);

        // 10 more so there are 12 users in total
        User::factory()->count(10)->create();
    }
}

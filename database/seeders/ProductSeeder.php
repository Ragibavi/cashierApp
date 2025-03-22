<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            Product::create([
                'id' => Str::uuid(),
                'name' => $faker->words(3, true),
                'image' => 'image' . $i . '.jpg',
                'quantity' => $faker->numberBetween(1, 100),
                'price' => $faker->randomFloat(2, 10, 1000),
            ]);
        }
    }
}

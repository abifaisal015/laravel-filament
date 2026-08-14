<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $rows = [];
        for ($i = 0; $i < 50; $i++) {
            $rows[] = [
                'code' => strtoupper($faker->unique()->bothify('???-####')),
                'name' => $faker->words(3, true),
                'price' => $faker->randomFloat(2, 1, 9999),
                'stock' => $faker->numberBetween(0, 1000),
                'is_active' => $faker->boolean(80) ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->upsert(
            $rows,
            ['code'],
            ['name', 'price', 'stock', 'is_active', 'updated_at'],
        );
    }
}

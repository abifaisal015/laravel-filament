<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
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
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'is_active' => $faker->boolean(80) ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('customers')->insert($rows);
    }
}

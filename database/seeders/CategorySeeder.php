<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Elektronik',
            'Pakaian & Aksesoris',
            'Makanan & Minuman',
            'Peralatan Rumah Tangga',
            'Kecantikan & Perawatan',
            'Olahraga & Outdoor',
            'Buku & Alat Tulis',
            'Mainan & Hobi',
            'Otomotif',
            'Furniture',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}

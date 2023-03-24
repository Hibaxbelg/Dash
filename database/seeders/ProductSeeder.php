<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Medwin Monoposte',
            'min_pc_number' => 1,
            'price' => 300,
            'price_without_promo' => 500,
            'price_per_additional_pc' => 200,
        ]);

        Product::create([
            'name' => 'Medwin Reséaux',
            'min_pc_number' => 1,
            'price' => 500,
            'price_without_promo' => 800,
            'price_per_additional_pc' => 200
        ]);

        Product::create([
            'name' => 'Medwin Radio',
            'min_pc_number' => 2,
            'price' => 600,
            'price_per_additional_pc' => 200
        ]);

        Product::create([
            'name' => 'Medwin Ophta',
            'min_pc_number' => 2,
            'price' => 600,
            'price_per_additional_pc' => 200
        ]);
    }
}

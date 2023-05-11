<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(2),
            'min_pc_number' => fake()->randomNumber(1),
            'price' => fake()->randomNumber(3),
            'price_per_additional_pc' => fake()->randomNumber(2),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
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
            'name' => $this->faker->sentence,
            'category_id' => Category::factory(),
            'price' => $this->faker->randomNumber(2),
            'initial_stock_quantity' => $this->faker->randomNumber(2),
            'current_stock_quantity' => $this->faker->randomNumber(2),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ledger>
 */
class LedgerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'credit' => $this->faker->randomNumber(6),
            'debit' => $this->faker->randomNumber(6),
            'balance' => $this->faker->randomNumber(6),
            'transaction_date' => $this->faker->date(),
            'remarks' => $this->faker->sentence(),
        ];
    }
}

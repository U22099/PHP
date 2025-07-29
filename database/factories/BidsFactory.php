<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bids>
 */
class BidsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bid_amount' => $this->faker->numberBetween(30000, 150000),
            'bid_time_budget' => $this->faker->numberBetween(1, 100),
            'bid_message' => $this->faker->paragraphs(rand(1, 5), true),
        ];
    }
}

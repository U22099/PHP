<?php

namespace Database\Factories;

use App\Models\Employer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'salary' => '$' . $this->faker->numberBetween(30000, 150000),
            'description' => '',
            'screenshots' => $this->generateFakeImagesArray(),
        ];
    }

    protected function generateFakeImagesArray(): array
    {
        $images = [];
        $numberOfImages = rand(1, 5);

        for ($i = 0; $i < $numberOfImages; $i++) {
            $images[] = 'https://i.pravatar.cc/400?img=' . rand(1,70);
        }

        return $images;
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Projects>
 */
class ProjectsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraphs(rand(3, 7), true),
            'link' => $this->faker->url(),
            'images' => $this->generateFakeImagesArray()
        ];
    }

    protected function generateFakeImagesArray(): array
    {
        $images = [];
        $numberOfImages = rand(1, 5);

        for ($i = 0; $i < $numberOfImages; $i++) {
            $images[] = 'https://i.pravatar.cc/300?img=' . rand(1, 70);
        }

        return $images;
    }
}

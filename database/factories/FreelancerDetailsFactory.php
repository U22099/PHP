<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FreelancerDetails>
 */
class FreelancerDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'professional_name' => $this->faker->name(),
            'professional_summary' => $this->faker->text(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'phone_number' => $this->faker->phoneNumber(),
            'skills' => json_encode($this->faker->words(5)),
            'portfolio_link' => $this->faker->url(),
            'years_of_experience' => $this->faker->numberBetween(1, 20),
            'education' => $this->faker->sentence(),
            'certifications' => $this->faker->sentence(),
            'languages' => json_encode($this->faker->words(3)),
            'availability' => $this->faker->randomElement(['Full-time', 'Part-time', 'Hourly']),
            'response_time' => $this->faker->randomElement(['Within an hour', 'Within a few hours', 'Within a day']),
            'linkedin_profile' => $this->faker->url(),
        ];
    }
}

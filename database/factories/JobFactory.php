<?php

namespace Database\Factories;

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
            'title' => fake()->jobTitle(),
            'user_id' => \App\Models\User::all()->random()->id,
            'job_type_id' => \App\Models\JobType::all()->random()->id,
            'category_id' => \App\Models\Category::all()->random()->id,
            'vacancy' => rand(1, 5),
            'location' => fake()->city(),
            'description' => fake()->paragraph(),
            'experience' => fake()->numberBetween(1, 10) . ' years',
            'company_name' => fake()->company()
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobApplication>
 */
class JobApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_id' => \App\Models\Job::factory(),
            'user_id' => \App\Models\User::factory(),
            'employer_id' => \App\Models\User::factory(),
            'applied_date' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkExperience>
 */
class WorkExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company' => $this->faker->company(),
            'position' => $this->faker->jobTitle(),
            'location' => $this->faker->city(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->optional()->date(),
            'is_current' => $this->faker->boolean(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
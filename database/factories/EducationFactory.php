<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
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
            'institution' => $this->faker->company(),
            'degree' => $this->faker->word() . ' in ' . $this->faker->word(),
            'field_of_study' => $this->faker->word(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->optional()->date(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
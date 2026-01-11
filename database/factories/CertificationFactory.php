<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certification>
 */
class CertificationFactory extends Factory
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
            'name' => $this->faker->word() . ' Certification',
            'issuer' => $this->faker->company(),
            'issue_date' => $this->faker->date(),
            'expiry_date' => $this->faker->optional()->date(),
            'url' => $this->faker->optional()->url(),
        ];
    }
}
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserDetailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => $this->faker->phoneNumber,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'date_of_birth' => $this->faker->date(),
            'created_at' => now(),
        ];
    }
}

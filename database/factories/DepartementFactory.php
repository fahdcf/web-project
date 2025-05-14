<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartementFactory extends Factory
{
    protected $model = \App\Models\Departement::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word().' Department',
            'description' => $this->faker->sentence(),
            'user_id' => \App\Models\User::factory(), // Responsable du département
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Filiere;
use Illuminate\Database\Eloquent\Factories\Factory;

class FiliereFactory extends Factory
{
    protected $model = Filiere::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word().' Program',
            'description' => $this->faker->paragraph(),
            'department_id' => \App\Models\Departement::factory(),
            'coordonnateur_id' => \App\Models\User::factory(),
        ];
    }
}

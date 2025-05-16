<?php

namespace Database\Factories;

use App\Models\Filiere;
use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    protected $model = Module::class;

    public function definition(): array
    {
        return [
            'name' => 'Module ' . $this->faker->unique()->word(),

            'code' => 'M' . $this->faker->unique()->randomNumber(nbDigits:3,strict:true),
            'type' => 'premier',

            'description' => $this->faker->paragraph(),
            'semester' => $this->faker->numberBetween(1, 6),


            'tp_hours'=> $this->faker->numberBetween(10, 100),
            'td_hours'=> $this->faker->numberBetween(10, 100),
            'cm_hours'=> $this->faker->numberBetween(10, 100),


            'status' => $this->faker->randomElement(['active', 'inactive']),

            // Relations
            'filiere_id' => Filiere::factory(), // Crée/associe une filière automatiquement si aucune n'existe
            'professor_id' => User::factory(), // Crée/associe un professeur automatiquement si aucune n'existe
            'responsable_id' => User::factory(), // Crée/associe un professeur automatiquement si aucune n'existe


            // Groupes TD/TP
            // 'nb_groupes_td' => $this->faker->numberBetween(1, 3),
            // 'nb_groupes_tp' => $this->faker->numberBetween(1, 3),

            // Crédits
            'credits' => $this->faker->numberBetween(1, 5),
            'evaluation' => $this->faker->numberBetween(1, 6),

            'type'=>$this->faker->randomElement(['complet','element'])
        ];
    }
}

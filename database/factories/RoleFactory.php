<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'isadmin' => $this->faker->boolean(10),
            'iscoordonnateur' => $this->faker->boolean(10),
            'ischef' => $this->faker->boolean(10),
            'isprof' => $this->faker->boolean(30),
            'isvocataire' => $this->faker->boolean(10),
            'isstudent' => $this->faker->boolean(50),
        ];
    }
}

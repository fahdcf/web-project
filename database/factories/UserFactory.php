<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\UserDetail;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'role' => 'student',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($user) {
            $user->user_details()->create([
                'profile_img' => null,
                'number' => $this->faker->phoneNumber,
                'status' => $this->faker->randomElement(['active', 'inactive']),
                'date_of_birth' => $this->faker->date(),
                'created_at' => now(),
            ]);
        });
    }
}

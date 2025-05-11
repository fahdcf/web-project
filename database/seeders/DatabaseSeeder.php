<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\Role;
use App\Models\User;
use App\Models\user_detail;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed roles table

        // 1. Create manual users
        $this->createManualUsers();

        // 2. Create departments with GI as priority
        $giDepartment = $this->createGiDepartment();

        // 3. Create GI filière with Imad Badi as coordinator
        $giFiliere = $this->createGiFiliere($giDepartment);

        // 4. Create 20 professors for GI department
        $giProfessors = $this->createGiProfessors($giDepartment);

        // 5. Create 30 modules for GI filière distributed by semester
        $this->createGiModules($giFiliere, $giProfessors);

        // 6. Create other departments and filières (optional)
        $this->createOtherDepartments();

        $this->command->info('✅ Database seeded successfully with GI department setup!');
    }

   

    private function createManualUsers(): array
    {
        $users = [
            [
                'firstname' => 'Mohssine',
                'lastname' => 'Echlaihi',
                'email' => 'mohssine@gmail.com',
                'departement' => 'GI',
                'password' => Hash::make('mohssine'),
                'role' => ['isadmin' => true, 'iscoordonnateur' => false, 'isprof' => true]
            ],
            [
                'firstname' => 'Fahd',
                'lastname' => 'Chafai',
                'email' => 'fahdfahd427@gmail.com',
                'departement' => 'GI',
                'password' => Hash::make('fahd'),
                'role' => ['isadmin' => true, 'iscoordonnateur' => false, 'isprof' => true]
            ],
            // Imad Badi - GI Coordinator
            [
                'firstname' => 'Imad',
                'lastname' => 'Badi',
                'email' => 'mohssine888@gmail.com',
                'departement' => 'GI',
                'password' => Hash::make('password'),
                'role' => ['isadmin' => false, 'iscoordonnateur' => true, 'isprof' => true]
            ],
            // Yahya Azalmat - Professor
            [
                'firstname' => 'Yahya',
                'lastname' => 'Azalmat',
                'email' => 'yahya@gmail.com',
                'departement' => 'GI',
                'password' => Hash::make('yahya'),
                'role' => ['isadmin' => false, 'iscoordonnateur' => false, 'isprof' => true]
            ]
        ];

        $createdUsers = [];
        foreach ($users as $data) {
            $user = User::create([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'departement' => $data['departement'],
                'password' => $data['password']
            ]);

            Role::create(array_merge(['user_id' => $user->id], $data['role']));

            user_detail::create([
                'user_id' => $user->id,
                'number' => '06' . fake()->numerify('########'),
                'status' => 'active',
                'date_of_birth' => fake()->date('Y-m-d', '-30 years')
            ]);

            $createdUsers[] = $user;
        }

        return $createdUsers;
    }

    private function createGiDepartment(): Departement
    {
        $chef = User::where('email', 'mohssine@gmail.com')->first();

        return Departement::create([
            'name' => 'Génie Informatique',
            'description' => 'Département de Génie Informatique',
            'user_id' => $chef->id
        ]);
    }

    private function createGiFiliere(Departement $department): Filiere
    {
        $coordinator = User::where('email', 'mohssine888@gmail.com')->first();

        return Filiere::create([
            'name' => 'Génie Informatique',
            'description' => 'Filière en Génie Informatique',
            'department_id' => $department->id,
            'coordonnateur_id' => $coordinator->id
        ]);
    }

    private function createGiProfessors(Departement $department): array
    {
        $professors = [];

        // Create 20 professors for GI department
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'firstname' => fake()->firstName(),
                'lastname' => fake()->lastName(),
                'email' => 'prof.gi' . $i . '@gmail.com',
                'departement' => $department->code,
                'password' => Hash::make('password')
            ]);

            Role::create([
                'user_id' => $user->id,
                'isprof' => true,
                'isvocataire' => fake()->boolean(30) // 30% chance of being vacataire
            ]);

            user_detail::create([
                'user_id' => $user->id,
                'number' => '06' . fake()->numerify('########'),
                'status' => 'active',
                'date_of_birth' => fake()->date('Y-m-d', '-25 years')
            ]);

            $professors[] = $user;
        }

        return $professors;
    }

    private function createGiModules(Filiere $filiere, array $professors): void
    {
        $modules = [
            // Semester 1
            ['name' => 'Algorithmique', 'code' => 'GI1-M1', 'semester' => 1, 'credits' => 6, 'status' => '1'],
            ['name' => 'Programmation C', 'code' => 'GI1-M2', 'semester' => 1, 'credits' => 5, 'status' => '1'],
            ['name' => 'Mathématiques', 'code' => 'GI1-M3', 'semester' => 1, 'credits' => 4, 'status' => '1'],
            [
                'name' => 'Systèmes d\'exploitation',
                'code' => 'GI1-M4',
                'semester' => 1,
                'credits' => 5,
                'status' => '1'
            ],
            ['name' => 'Bases de données', 'code' => 'GI1-M5', 'semester' => 1, 'credits' => 5, 'status' => '1'],

            // Semester 2
            ['name' => 'Structures de données', 'code' => 'GI2-M1', 'semester' => 2, 'credits' => 6, 'status' => '1'],
            [
                'name' => 'Programmation Orientée Objet',
                'code' => 'GI2-M2',
                'semester' => 2,
                'credits' => 6,
                'status' => '1'
            ],
            ['name' => 'Réseaux', 'code' => 'GI2-M3', 'semester' => 2, 'credits' => 5, 'status' => '1'],
            ['name' => 'Web Development', 'code' => 'GI2-M4', 'semester' => 2, 'credits' => 5, 'status' => '1'],
            ['name' => 'Analyse numérique', 'code' => 'GI2-M5', 'semester' => 2, 'credits' => 4, 'status' => '0']

            // Continue with more modules up to 30...
        ];

        // If we need more modules than predefined, generate random ones
        while (count($modules) < 30) {
            $semester = fake()->numberBetween(1, 6);
            $modules[] = [
                'name' => fake()->randomElement(['Advanced ', 'Fundamentals of ']) . fake()->words(2, true),
                'code' => 'GI' . $semester . 'M' . (count($modules) + 1),
                'semester' => $semester,
                'status' => fake()->randomElement([0, 1, null]),

                'credits' => fake()->randomElement([3, 4, 5, 6])
            ];
        }

        foreach ($modules as $module) {
            $module = Module::create([
                'name' => $module['name'],
                'status' => $module['status'],
                'code' => $module['code'],
                'credits' => $module['credits'],
                'semester' => $module['semester'],
                'filiere_id' => $filiere->id,
                'responsable_id' => $professors[array_rand($professors)]->id,
                'description' => fake()->paragraph(3),
            ]);
    
            // Assign a random number of professors (1 to 3) to each module
            $numProfessorsToAssign = fake()->numberBetween(1, 3);
            $randomProfessors = fake()->randomElements($professors, $numProfessorsToAssign);
    
            foreach ($randomProfessors as $professor) {
                $module->users()->attach($professor->id); // No role needed in the pivot table
            }
        }
    }

    private function createOtherDepartments(): void
    {
        // Create other departments if needed
        $otherDepartments = ['RT', 'GC', 'GM', 'GP'];

        foreach ($otherDepartments as $dept) {
            Departement::create([
                'name' => 'Département ' . $dept,
                'description' => 'Description for ' . $dept,
                'user_id' => User::whereHas('role', function ($query) {
                    $query->where('isprof', true);
                })
                    ->inRandomOrder()
                    ->first()->id
            ]);
        }
    }
}

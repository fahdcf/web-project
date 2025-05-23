<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Module;
use App\Models\Role;
use App\Models\Task;
use App\Models\task as ModelsTask;
use App\Models\User;
use App\Models\user_detail;
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
        $modules = $this->createGiModules($giFiliere, $giProfessors);

        // 7. Create tasks
        $this->createTasks();

        // 8. Create other departments and filières (optional)
        $this->createOtherDepartments();

        $this->command->info('✅ Database seeded successfully with all tables!');
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
                'role' => ['isadmin' => false, 'iscoordonnateur' => false, 'isprof' => true]
            ],
            [
                'firstname' => 'Ayoub',
                'lastname' => 'Nassih',
                'email' => 'ayoub@gmail.com',
                'departement' => 'GI',
                'password' => Hash::make('ayoub'),
                'role' => ['isadmin' => false, 'iscoordonnateur' => false, 'isprof' => false, 'isvocataire' => true]
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

    private function createGiModules(Filiere $filiere, array $professors): array
    {
        $modules = [
            // Semester 1
            ['nbr_groupes_tp' => 1, 'nbr_groupes_td' => 2, 'name' => 'Algorithmique', 'code' => 'GI1-M1', 'semester' => 1, 'credits' => 6, 'status' => 'active'],
            ['nbr_groupes_tp' => 1, 'nbr_groupes_td' => 2, 'name' => 'Programmation C', 'code' => 'GI1-M2', 'semester' => 1, 'credits' => 5, 'status' => 'active'],
            ['nbr_groupes_tp' => 1, 'nbr_groupes_td' => 2, 'name' => 'Mathématiques', 'code' => 'GI1-M3', 'semester' => 1, 'credits' => 4, 'status' => 'inactive'],
            [
                'nbr_groupes_tp' => 2,
                'nbr_groupes_td' => 1,
                'name' => 'Systèmes d\'exploitation',
                'code' => 'GI1-M4',
                'semester' => 1,
                'credits' => 5,
                'status' => 'inactive'
            ],
            ['nbr_groupes_tp' => 2, 'nbr_groupes_td' => 1, 'name' => 'Bases de données', 'code' => 'GI1-M5', 'semester' => 1, 'credits' => 5, 'status' => 'active'],

            // Semester 2
            ['nbr_groupes_tp' => 2, 'nbr_groupes_td' => 1, 'name' => 'Structures de données', 'code' => 'GI2-M1', 'semester' => 2, 'credits' => 6, 'status' => 'active'],
            [
                'nbr_groupes_tp' => 2,
                'nbr_groupes_td' => 1,
                'name' => 'Programmation Orientée Objet',
                'code' => 'GI2-M2',
                'semester' => 2,
                'credits' => 6,
                'status' => 'active'
            ],
            ['nbr_groupes_tp' => 2, 'nbr_groupes_td' => 1, 'name' => 'Réseaux', 'code' => 'GI2-M3', 'semester' => 2, 'credits' => 5, 'status' => 'active'],
            ['nbr_groupes_tp' => 2, 'nbr_groupes_td' => 1, 'name' => 'Web Development', 'code' => 'GI2-M4', 'semester' => 2, 'credits' => 5, 'status' => 'active'],
            ['nbr_groupes_tp' => 2, 'nbr_groupes_td' => 1, 'name' => 'Analyse numérique', 'code' => 'GI2-M5', 'semester' => 2, 'credits' => 4, 'status' => 'inactive']

            // Continue with more modules up to 30...
        ];

        // $rondomModules=Module::factory(100)->create();

        // $$modules=array_merge($modules,$rondomModules) ;

        // If we need more modules than predefined, generate random ones
        while (count($modules) < 100) {
            $semester = fake()->numberBetween(3, 6);
            $modules[] = [
                'name' => fake()->randomElement(['Advanced ', 'Fundamentals of ']) . fake()->words(2, true),
                'code' => 'GI' . $semester . 'M' . (count($modules) + 1),
                'semester' => $semester,
                'status' => fake()->randomElement(['active', 'inactive', 'inactive']),

                'credits' => fake()->randomElement([2, 3, 4, 5, 6]),
                'evaluation' => fake()->randomElement([1, 2, 3, 4, 5, 6]),

                'tp_hours' => fake()->randomElement([10, 100, 89, 23, 8, 12, 44, 32]),
                'td_hours' => fake()->randomElement([10, 100, 89, 23, 8, 12, 44, 32]),
                'cm_hours' => fake()->randomElement([10, 100, 89, 23, 8, 12, 44, 32]),

                'nbr_groupes_td' => fake()->randomElement([1, 0, 2, 3]),
                'nbr_groupes_tp' => fake()->randomElement([1, 0, 2, 3])
            ];
        }
        $createdModules = [];

        foreach ($modules as $moduleData) {
            $module = Module::create([
                'nbr_groupes_tp' => $moduleData['nbr_groupes_tp'],
                'nbr_groupes_td' => $moduleData['nbr_groupes_td'],


                'name' => $moduleData['name'],
                'status' => $moduleData['status'],
                'code' => $moduleData['code'],
                'credits' => $moduleData['credits'],
                'semester' => $moduleData['semester'],
                'filiere_id' => $filiere->id,
                'responsable_id' => $professors[array_rand($professors)]->id,
                'description' => fake()->paragraph(3),
            ]);

            // Assign a random number of professors (1 to 3) to each module
            $numProfessorsToAssign = fake()->numberBetween(1, 3);
            $randomProfessors = fake()->randomElements($professors, $numProfessorsToAssign);

            foreach ($randomProfessors as $professor) {
                $module->users()->attach($professor->id);
            }

            $createdModules[] = $module;
        }

        return $createdModules;
    }




    private function createTasks(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Create 3-10 tasks per user
            $numTasks = fake()->numberBetween(3, 10);

            for ($i = 0; $i < $numTasks; $i++) {
                ModelsTask::create([
                    'description' => fake()->sentence(),
                    'isdone' => fake()->boolean(70), // 70% chance of being done
                    'user_id' => $user->id,
                ]);
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

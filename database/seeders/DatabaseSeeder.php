<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Departement;
use App\Models\Emploi;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\Note;
use App\Models\Role;
use App\Models\Seance;
use App\Models\Student;
use App\Models\StudentModuleNote;
use App\Models\Task;
use App\Models\User;
use App\Models\user_detail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private $academicYear = '2024-2025';
    private $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    private $rooms = ['Salle A1', 'Salle B1', 'Labo TP1', 'Amphi 1', 'Salle A2', 'Salle C1'];
    private $timeSlots = [
        ['08:30:00', '10:30:00'],
        ['10:30:00', '12:30:00'],
        ['14:30:00', '16:30:00'],
        ['16:30:00', '18:30:00'],
    ];

    public function run(): void
    {
        // 1. Create manual users
        $manualUsers = $this->createManualUsers();

        // 2. Create GI department
        $giDepartment = $this->createGiDepartment();

        // 3. Create GI filière
        $giFiliere = $this->createGiFiliere($giDepartment);

        // 4. Create additional professors (including vacataires)
        $professors = $this->createProfessors($giDepartment);

        // 5. Create students for GI filière
        $students = $this->createStudents($giFiliere);

        // 6. Create modules (6 per semester, total 36)
        $modules = $this->createModules($giFiliere, array_merge($manualUsers, $professors));

        // 7. Create emplois du temps for each semester
        $emplois = $this->createEmplois($giFiliere);

        // 8. Assign users to modules and create seances
        $this->assignUsersToModules(array_merge($manualUsers, $professors), $modules, $emplois);

        // 9. Create tasks
        $this->createTasks(array_merge($manualUsers, $professors));

        // 10. Seed notes and student module notes
        $this->createNotesAndStudentModuleNotes($modules, $students, $manualUsers);

        $this->command->info('✅ Database seeded successfully!');
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
                'role' => ['isadmin' => false, 'iscoordonnateur' => false, 'isprof' => true, 'isvocataire' => false],
            ],
            [
                'firstname' => 'Fahd',
                'lastname' => 'Chafai',
                'email' => 'fahdfahd427@gmail.com',
                'departement' => 'GI',
                'password' => Hash::make('fahd'),
                'role' => ['isadmin' => true, 'iscoordonnateur' => false, 'isprof' => true, 'isvocataire' => false],
            ],
            [
                'firstname' => 'Imad',
                'lastname' => 'Badi',
                'email' => 'mohssine888@gmail.com',
                'departement' => 'GI',
                'password' => Hash::make('password'),
                'role' => ['isadmin' => false, 'iscoordonnateur' => true, 'isprof' => true, 'isvocataire' => false],
            ],
            [
                'firstname' => 'Yahya',
                'lastname' => 'Azalmat',
                'email' => 'yahya@gmail.com',
                'departement' => 'GI',
                'password' => Hash::make('yahya'),
                'role' => ['isadmin' => false, 'iscoordonnateur' => false, 'isprof' => false, 'isvocataire' => true],
            ],
        ];

        $createdUsers = [];
        foreach ($users as $data) {
            $user = User::create([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'departement' => $data['departement'],
                'password' => $data['password'],
            ]);

            Role::create(array_merge(['user_id' => $user->id], $data['role']));

            user_detail::create([
                'user_id' => $user->id,
                'number' => '06' . fake()->numerify('########'),
                'status' => 'active',
                'date_of_birth' => fake()->date('Y-m-d', '-30 years'),
            ]);

            $createdUsers[] = $user;
        }

        return $createdUsers;
    }

    private function createGiDepartment(): Departement
    {
        $chef = User::where('email', 'mohssine@gmail.com')->first();

        return Departement::create([
            'name' => 'GI',
            'description' => 'Département de Génie Informatique',
            'user_id' => $chef->id,
        ]);
    }

    private function createGiFiliere(Departement $department): Filiere
    {
        $coordinator = User::where('email', 'mohssine888@gmail.com')->first();

        return Filiere::create([
            'name' => 'GI',
            'description' => 'Filière en Génie Informatique',
            'department_id' => $department->id,
            'coordonnateur_id' => $coordinator->id,
        ]);
    }

    private function createProfessors(Departement $department): array
    {
        $professors = [];

        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'firstname' => fake()->firstName(),
                'lastname' => fake()->lastName(),
                'email' => 'prof.gi' . $i . '@gmail.com',
                'departement' => $department->name,
                'password' => Hash::make('password'),
            ]);

            $isVacataire = fake()->boolean(40);
            Role::create([
                'user_id' => $user->id,
                'isprof' => !$isVacataire,
                'isvocataire' => $isVacataire,
            ]);

            user_detail::create([
                'user_id' => $user->id,
                'number' => '06' . fake()->numerify('########'),
                'status' => 'active',
                'date_of_birth' => fake()->date('Y-m-d', '-25 years'),
            ]);

            $professors[] = $user;
        }

        return $professors;
    }

    private function createStudents(Filiere $filiere): array
    {
        $students = [];
        $groups = ['A', 'B', 'C'];
        $semesters = [1, 2, 3, 4, 5, 6];

        for ($i = 1; $i <= 50; $i++) {
            $semester = fake()->randomElement($semesters);
            $group = fake()->randomElement($groups);

            $student = Student::create([
                'firstname' => fake()->firstName(),
                'lastname' => fake()->lastName(),
                'email' => 'student.gi' . $semester . $group . $i . '@gmail.com',
                'status' => 'active',
                'sexe' => fake()->randomElement(['male', 'female']),
                'cin' => fake()->numerify('AA######'),
                'adresse' => fake()->address(),
                'number' => '06' . fake()->numerify('########'),
                'date_of_birth' => fake()->date('Y-m-d', '-20 years'),
                'filiere_id' => $filiere->id,
                'CNE' => fake()->numerify('G#########'),
            ]);

            $students[] = $student;
        }

        return $students;
    }

    private function createModules(Filiere $filiere, array $users): array
    {
        $moduleTemplates = [
            // Semester 1
            ['name' => 'Algorithmique', 'code' => 'GI1-M1', 'semester' => 1, 'credits' => 6, 'cm_hours' => 20, 'td_hours' => 15, 'tp_hours' => 15, 'nbr_groupes_td' => 2, 'nbr_groupes_tp' => 1, 'status' => 'active'],
            ['name' => 'Programmation C', 'code' => 'GI1-M2', 'semester' => 1, 'credits' => 5, 'cm_hours' => 18, 'td_hours' => 12, 'tp_hours' => 12, 'nbr_groupes_td' => 2, 'nbr_groupes_tp' => 1, 'status' => 'active'],
            ['name' => 'Mathématiques', 'code' => 'GI1-M3', 'semester' => 1, 'credits' => 4, 'cm_hours' => 20, 'td_hours' => 10, 'tp_hours' => 0, 'nbr_groupes_td' => 1, 'nbr_groupes_tp' => 0, 'status' => 'active'],
            ['name' => 'Systèmes d\'exploitation', 'code' => 'GI1-M4', 'semester' => 1, 'credits' => 5, 'cm_hours' => 18, 'td_hours' => 10, 'tp_hours' => 10, 'nbr_groupes_td' => 1, 'nbr_groupes_tp' => 2, 'status' => 'active'],
            ['name' => 'Bases de données', 'code' => 'GI1-M5', 'semester' => 1, 'credits' => 5, 'cm_hours' => 18, 'td_hours' => 12, 'tp_hours' => 12, 'nbr_groupes_td' => 1, 'nbr_groupes_tp' => 2, 'status' => 'active'],
            ['name' => 'Anglais Technique', 'code' => 'GI1-M6', 'semester' => 1, 'credits' => 3, 'cm_hours' => 15, 'td_hours' => 10, 'tp_hours' => 0, 'nbr_groupes_td' => 1, 'nbr_groupes_tp' => 0, 'status' => 'active'],
            // Semester 2
            ['name' => 'Structures de données', 'code' => 'GI2-M1', 'semester' => 2, 'credits' => 6, 'cm_hours' => 20, 'td_hours' => 15, 'tp_hours' => 15, 'nbr_groupes_td' => 2, 'nbr_groupes_tp' => 1, 'status' => 'active'],
            ['name' => 'Programmation Orientée Objet', 'code' => 'GI2-M2', 'semester' => 2, 'credits' => 6, 'cm_hours' => 20, 'td_hours' => 12, 'tp_hours' => 12, 'nbr_groupes_td' => 2, 'nbr_groupes_tp' => 1, 'status' => 'active'],
            ['name' => 'Réseaux', 'code' => 'GI2-M3', 'semester' => 2, 'credits' => 5, 'cm_hours' => 18, 'td_hours' => 10, 'tp_hours' => 10, 'nbr_groupes_td' => 1, 'nbr_groupes_tp' => 2, 'status' => 'active'],
            ['name' => 'Web Development', 'code' => 'GI2-M4', 'semester' => 2, 'credits' => 5, 'cm_hours' => 18, 'td_hours' => 12, 'tp_hours' => 12, 'nbr_groupes_td' => 4, 'nbr_groupes_tp' => 0, 'status' => 'active'],
            ['name' => 'Statistiques', 'code' => 'GI2-M5', 'semester' => 2, 'credits' => 4, 'cm_hours' => 20, 'td_hours' => 10, 'tp_hours' => 0, 'nbr_groupes_td' => 1, 'nbr_groupes_tp' => 0, 'status' => 'active'],
            ['name' => 'Communication', 'code' => 'GI2-M6', 'semester' => 2, 'credits' => 3, 'cm_hours' => 15, 'td_hours' => 10, 'tp_hours' => 0, 'nbr_groupes_td' => 1, 'nbr_groupes_tp' => 0, 'status' => 'active'],
        ];

        // Generate modules for semesters 3–6
        $semesters = [3, 4, 5, 6];
        foreach ($semesters as $semester) {
            for ($i = 1; $i <= 6; $i++) {
                $moduleTemplates[] = [
                    'name' => fake()->randomElement(['Advanced ', 'Fundamentals of ']) . fake()->words(2, true),
                    'code' => 'GI' . $semester . '-M' . $i,
                    'semester' => $semester,
                    'credits' => fake()->randomElement([3, 4, 5, 6]),
                    'cm_hours' => fake()->randomElement([15, 18, 20]),
                    'td_hours' => fake()->randomElement([10, 12, 15]),
                    'tp_hours' => fake()->randomElement([0, 10, 12]),
                    'nbr_groupes_td' => fake()->randomElement([0, 1, 2]),
                    'nbr_groupes_tp' => fake()->randomElement([0, 1, 2]),
                    'status' => 'active',
                ];
            }
        }

        $createdModules = [];
        foreach ($moduleTemplates as $moduleData) {
            $professor = fake()->randomElement($users);
            $module = Module::create([
                'name' => $moduleData['name'],
                'code' => $moduleData['code'],
                'semester' => $moduleData['semester'],
                'credits' => $moduleData['credits'],
                'cm_hours' => $moduleData['cm_hours'] ?? 0,
                'td_hours' => $moduleData['td_hours'] ?? 0,
                'tp_hours' => $moduleData['tp_hours'] ?? 0,
                'nbr_groupes_td' => $moduleData['nbr_groupes_td'] ?? 0,
                'nbr_groupes_tp' => $moduleData['nbr_groupes_tp'] ?? 0,
                'status' => $moduleData['status'],
                'filiere_id' => $filiere->id,
                'responsable_id' => $professor->id,
                'description' => fake()->sentence(),
            ]);

            // Assign professor or vacataire
            $isVacataireModule = fake()->boolean(20);
            $eligibleUsers = array_filter($users, fn($user) => $isVacataireModule ? $user->role->isvocataire : $user->role->isprof);
            $assignedUsers = fake()->randomElements($eligibleUsers, fake()->numberBetween(1, 2));

            foreach ($assignedUsers as $user) {
                Assignment::create([
                    'module_id' => $module->id,
                    'prof_id' => $user->id,
                    'hours' => fake()->numberBetween(10, 30),
                    'teach_cm' => $module->cm_hours > 0 && fake()->boolean(70),
                    'teach_td' => $module->td_hours > 0 && fake()->boolean(70),
                    'teach_tp' => $module->tp_hours > 0 && fake()->boolean(70),
                    'academic_year' => $this->academicYear,
                ]);
            }

            $createdModules[] = $module;
        }

        return $createdModules;
    }

    private function createEmplois(Filiere $filiere): array
    {
        $emplois = [];

        for ($semester = 1; $semester <= 6; $semester++) {
            $emploi = Emploi::create([
                'filiere_id' => $filiere->id,
                'semester' => $semester,
                'name' => "Emploi du Temps S$semester {$this->academicYear}",
                'is_active' => true,
                'file_path' => null,
            ]);

            $emplois[] = $emploi;
        }

        return $emplois;
    }

    private function assignUsersToModules(array $users, array $modules, array $emplois): void
    {
        $occupiedSlots = [];

        foreach ($users as $user) {
            if (!$user->role->isprof && !$user->role->isvocataire) {
                continue;
            }

            $numModules = fake()->numberBetween(1, 3);
            $activeModules = array_filter($modules, fn($module) => $module->status === 'active');
            $assignedModules = fake()->randomElements($activeModules, min($numModules, count($activeModules)));

            foreach ($assignedModules as $module) {
                $assignment = Assignment::firstOrCreate(
                    [
                        'module_id' => $module->id,
                        'prof_id' => $user->id,
                        'academic_year' => $this->academicYear,
                    ],
                    [
                        'hours' => fake()->numberBetween(10, 30),
                        'teach_cm' => $module->cm_hours > 0 && fake()->boolean(70),
                        'teach_td' => $module->td_hours > 0 && fake()->boolean(70),
                        'teach_tp' => $module->tp_hours > 0 && fake()->boolean(70),
                    ]
                );

                $this->createModuleSeances($module, $assignment, $emplois, $occupiedSlots);
            }
        }
    }

    private function createModuleSeances(Module $module, Assignment $assignment, array $emplois, array &$occupiedSlots): void
    {
        $emploi = collect($emplois)->firstWhere('semester', $module->semester);
        if (!$emploi) {
            return;
        }

        if (!isset($occupiedSlots[$emploi->id])) {
            $occupiedSlots[$emploi->id] = [];
        }

        $typesToSchedule = [];
        if ($assignment->teach_cm) {
            $typesToSchedule[] = ['type' => 'CM', 'count' => 1];
        }
        if ($assignment->teach_td) {
            $typesToSchedule[] = ['type' => 'TD', 'count' => $module->nbr_groupes_td > 0 ? $module->nbr_groupes_td : 1];
        }
        if ($assignment->teach_tp) {
            $typesToSchedule[] = ['type' => 'TP', 'count' => $module->nbr_groupes_tp > 0 ? $module->nbr_groupes_tp : 1];
        }

        foreach ($typesToSchedule as $typeData) {
            for ($i = 0; $i < $typeData['count']; $i++) {
                $group = null;
                if ($typeData['type'] === 'TD' && $module->nbr_groupes_td > 0) {
                    $group = 'TD' . ($i + 1);
                } elseif ($typeData['type'] === 'TP' && $module->nbr_groupes_tp > 0) {
                    $group = 'TP' . ($i + 1);
                }

                $this->scheduleSeance($module, $emploi, $typeData['type'], $group, $occupiedSlots);
            }
        }
    }

    private function scheduleSeance(Module $module, Emploi $emploi, string $type, ?string $group, array &$occupiedSlots): void
    {
        $maxRetries = 10;
        $retryCount = 0;
        $scheduled = false;

        while ($retryCount < $maxRetries && !$scheduled) {
            $timeSlot = fake()->randomElement($this->timeSlots);
            $day = fake()->randomElement($this->days);
            $room = fake()->randomElement($this->rooms);
            $slotKey = "{$day}-{$timeSlot[0]}-{$room}";

            if (!isset($occupiedSlots[$emploi->id]) || !in_array($slotKey, $occupiedSlots[$emploi->id])) {
                Seance::create([
                    'module_id' => $module->id,
                    'emploi_id' => $emploi->id,
                    'type' => $type,
                    'jour' => $day,
                    'heure_debut' => $timeSlot[0],
                    'heure_fin' => $timeSlot[1],
                    'salle' => $room,
                    'groupe' => $group,
                ]);

                $occupiedSlots[$emploi->id][] = $slotKey;
                $scheduled = true;
            } else {
                $retryCount++;
            }
        }
    }

    private function createTasks(array $users): void
    {
            foreach ($users as $user) {
                $numTasks = fake()->numberBetween(3, 5);
                for ($i = 0; $i < $numTasks; $i++) {
                    Task::create([
                        'description' => fake()->sentence(),
                        'isdone' => fake()->boolean(70),
                        'user_id' => $user->id,
                    ]);
                }
            }
    
        }

    private function createNotesAndStudentModuleNotes(array $modules, array $students, array $manualUsers): void
    {
        $professor = collect($manualUsers)->firstWhere('email', 'mohssine@gmail.com');
        if (!$professor) {
            return;
        }

        $activeModules = array_filter($modules, fn($module) => $module->status === 'active');
        $selectedModules = fake()->randomElements($activeModules, 5);

        foreach ($selectedModules as $module) {
            $note = Note::create([
                'module_id' => $module->id,
                'prof_id' => $professor->id,
                'session_type' => fake()->randomElement(['normale', 'rattrapage']),
                'semester' => $module->semester,
                'storage_path' => 'grades/module_' . $module->id . '_notes.xlsx',
                'original_name' => 'module_' . $module->id . '_notes.xlsx',
                'status' => 'active',
            ]);

            $moduleStudents = array_filter($students, fn($student) => $student->filiere_id === $module->filiere_id);
            $randomStudents = fake()->randomElements($moduleStudents, min(10, count($moduleStudents)));

            foreach ($randomStudents as $student) {
                StudentModuleNote::create([
                    'student_id' => $student->id,
                    'module_id' => $module->id,
                    'note_id' => $note->id,
                    'session_type' => $note->session_type,
                    'semester' => $module->semester,
                    'note' => fake()->randomFloat(2, 0, 20),
                    'remarque' => fake()->boolean(50) ? fake()->sentence() : null,
                ]);
            }
        }
    }

    
}
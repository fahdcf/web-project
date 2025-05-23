<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Filiere;
use App\Models\Group;

use App\Models\Groupe;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupeController extends Controller
{
    // Helper method to determine current/next semester (autom , printemps)
    public static function getCurrentSemester(): array
    {
        $month = now()->month;
        $year = now()->year;

        // Calcul de l'année académique (ex: 2023-2024)
        $academicYear = ($month >= 9)
            ? $year . '-' . ($year + 1)
            : ($year - 1) . '-' . $year;

        // Détermination du semestre actuel
        if ($month >= 9 || $month == 1) {
            // Semestre Automne (S1, S3 ou S5)
            $semesterType = 'AUTOMNE';
            $semesterNumber = (($year - ($month >= 9 ? 0 : 1)) % 3) * 2 + 1;
        } else {
            // Semestre Printemps (S2, S4 ou S6)
            $semesterType = 'PRINTEMPS';
            $semesterNumber = (($year - 1) % 3) * 2 + 2;
        }

        return [
            'academic_year' => $academicYear,
            'semester_type' => $semesterType,
            'semester_number' => 'S' . $semesterNumber,
            'semester_full' => $semesterType . ' (S' . $semesterNumber . ')'
        ];
    }

    private function getNextSemester()
    {
        $current = $this->getCurrentSemester();

        $yearAca = explode('-', $current['academic_year']); // Nouvelle année académique

        // Logique pour déterminer le semestre suivant
        if ($current['semester_type'] === 'AUTOMNE') {
            return [
                'semester_type' => 'PRINTEMPS',
                'academic_year' => $yearAca[0] . "-" . $yearAca[1] // Même année académique

            ];
        } else {

            $yearAca[0]++;
            $yearAca[1]++;

            return [
                'semester_type' => 'AUTOMNE',
                'academic_year' => $yearAca[0] . "-" . $yearAca[1] //
            ];
        }
    }





    //////confiquer le nbr td tp tous les module de semester
    public function index()
    {
        // Récupération des données du semestre courant
        $semesterData = $this->getCurrentSemester();
        $currentYear = $semesterData['academic_year'];
        $currentSemesterType = $semesterData['semester_type'];
        // $currentSemesterNumber = $semesterData['semester_number'];

        // Récupération de la filière gérée par l'utilisateur
        $filiere = auth()->user()->manage;

        // Détermination des semestres à charger en fonction du type courant
        $targetSemesters = $currentSemesterType === 'AUTOMNE'
            ? [1, 3, 5]  // Semestres impairs (Automne)
            : [2, 4, 6];  // Semestres pairs (Printemps)

        // Chargement des modules pour le type de semestre courant
        $modules = Module::with(['professor', 'responsable'])
            ->where('filiere_id', $filiere->id)
            ->where('status', 'active')
            ->whereIn('semester', $targetSemesters)
            ->orderBy('semester')
            ->get()
            ->groupBy('semester'); // Ajoutez cette ligne pour grouper par semestre

        // dd($modules);

        return view('coordonnateur.groupes', [
            'filiere' => $filiere,
            'modules' => $modules, // Maintenant groupés par semestre
            'currentYear' => $currentYear,
            'currentSemester' => $currentSemesterType,
            // 'currentSemesterNumber' => $currentSemesterNumber,
        ]);
    }

    public function saveNextSemesterConfig(Request $request)
    {
        $semestersData = $this->getNextSemester();
        $validated = $request->validate([
            'nb_groupes_td' => 'required|integer|min:0',
            'nb_groupes_tp' => 'required|integer|min:0',
            'max_tp' => 'required|integer|min:0',
            'max_td' => 'required|integer|min:0',
            'semester' => 'required|integer|min:1|max:6'
        ]);

        $modules = Module::where('semester', $validated['semester'])
            ->where('status', 'active')
            ->get();

        DB::transaction(function () use ($modules, $validated, $semestersData) {
            // First delete existing groups if needed (optional)
            Groupe::whereIn('module_id', $modules->pluck('id'))->delete();

            foreach ($modules as $module) {
                // Create TD groups
                for ($i = 1; $i <= $validated['nb_groupes_td']; $i++) {
                    Groupe::create([
                        'module_id' => $module->id,
                        'type' => 'TD',
                        'max_students' => $validated['max_td'],
                        'nbr_student' => 0, // Initialize with 0 students
                        'academicYear' => $semestersData['academic_year'], // Use correct column name
                        // 'name' => 'TD ' . $i // Add group name if needed
                    ]);
                }

                // Create TP groups
                for ($i = 1; $i <= $validated['nb_groupes_tp']; $i++) {
                    Groupe::create([
                        'module_id' => $module->id,
                        'type' => 'TP',
                        'max_students' => $validated['max_tp'],
                        'nbr_student' => 0,
                        'academicYear' => $semestersData['academic_year'],
                        // 'name' => 'TP ' . $i
                    ]);
                }
            }
        });

        return back()->with('success', 'Configuration enregistrée avec succès!');
    }

    ////confique /modifier just pour un module
    public function updateModuleConfig(Request $request)
    {


        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'nb_groupes_td' => 'required|integer|min:1|max:10',
            'nb_groupes_tp' => 'required|integer|min:0|max:10',
            'max_td' => 'required|integer|min:10|max:50',
            'max_tp' => 'required|integer|min:5|max:30'
        ]);

        $module = Module::findOrFail($validated['module_id']);

        DB::transaction(function () use ($module, $validated) {
            // Synchroniser les groupes TD
            $this->syncGroups($module, 'TD', $validated['nb_groupes_td'], $validated['max_td']);

            // Synchroniser les groupes TP
            $this->syncGroups($module, 'TP', $validated['nb_groupes_tp'], $validated['max_tp']);
        });

        return redirect()->back()->with('success', 'Configuration saved successfully');
    }
    ////////////////////////////////
    public function configureNextSemester()
    {


        // Récupération des données du semestre courant
        $semesterData = $this->getNextSemester();
        $year = $semesterData['academic_year'];
        $nextSemesterType = $semesterData['semester_type'];
        // $currentSemesterNumber = $semesterData['semester_number'];

        // Récupération de la filière gérée par l'utilisateur
        $filiere = auth()->user()->manage;
        $professors = User::orderBy('lastname')->get(['id', 'firstname', 'lastname']);

        // Détermination des semestres à charger en fonction du type courant
        $targetSemesters = $nextSemesterType === 'AUTOMNE'
            ? [1, 3, 5]  // Semestres impairs (Automne)
            : [2, 4, 6];  // Semestres pairs (Printemps)

        // Chargement des modules pour le type de semestre courant
        $modules = Module::with(['professor', 'responsable'])
            ->where('filiere_id', $filiere->id)
            ->where('status', 'active')
            ->whereIn('semester', $targetSemesters)
            ->orderBy('semester')
            ->get()
            ->groupBy('semester'); // Ajoutez cette ligne pour grouper par semestre

        // dd($modules);


        return view('coordonnateur.config_semester_suivant', [
            'filiere' => $filiere,
            'modules' => $modules,
            'currentYear' => $year,
            'nextSemester' => $nextSemesterType,
            'professors' => $professors
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    


    // public function availableModules()
    // {
    //     $groupes = Groupe::whereNull('user_id')
    //         ->with(['module' => function ($query) {
    //             $query->withCount([
    //                 'groupes as cm_groups_count' => function ($query) {
    //                     $query->where('type', 'cm')->whereNull('user_id');
    //                 },
    //                 'groupes as td_groups_count' => function ($query) {
    //                     $query->where('type', 'td')->whereNull('user_id');
    //                 },
    //                 'groupes as tp_groups_count' => function ($query) {
    //                     $query->where('type', 'tp')->whereNull('user_id');
    //                 }
    //             ]);
    //         }])
    //         ->get();

    //     return view('modules.availableModules', compact('groupes'));
    // }
    ///////////////////////////

    // public function availableModules()
    // {
    //     // Get unique modules with available groups count
    //     $modules = Module::with(['filiere', 'responsable'])

    //         ->get();

    //     return view('modules.availableModules', compact('modules'));
    // }

    public function availableModules(Request $request)
    {
        $modules = Module::with(['filiere', 'responsable', 'assignments'])
            ->where('status', 'active')
            ->where(function ($query) {
                // Modules sans aucune assignation
                $query->doesntHave('assignments')
                    ->orWhereHas('assignments', function ($q) {
                        // Ou modules avec au moins un type non assigné
                        $q->where('teach_cm', false)
                            ->orWhere('teach_td', false)
                            ->orWhere('teach_tp', false);
                    });
            })
            ->get();
        return view('modules.availableModules', compact('modules'));
    }




    //     public function availableModules()
    // {
    //     // Get all groups with module and filter only the available ones
    //     $allGroupes = Groupe::with('module.filiere', 'module.responsable')
    //         ->get();

    //     // Group all groupes by module_id
    //     $modulesGrouped = $allGroupes->groupBy('module_id');

    //     // Prepare final modules array
    //     $modules = [];

    //     foreach ($modulesGrouped as $moduleId => $groupes) {
    //         $module = $groupes->first()->module;

    //         $availableCM = $groupes->where('type', 'CM')->whereNull('user_id')->count();
    //         $availableTD = $groupes->where('type', 'TD')->whereNull('user_id')->count();
    //         $availableTP = $groupes->where('type', 'TP')->whereNull('user_id')->count();

    //         $modules[] = [
    //             'module' => $module,
    //             'available' => [
    //                 'CM' => $availableCM,
    //                 'TD' => $availableTD,
    //                 'TP' => $availableTP,
    //             ]
    //         ];
    //     }

    //     return view('modules.availableModules', compact('modules'));
    // }

}


                            ////////////////////////////////////
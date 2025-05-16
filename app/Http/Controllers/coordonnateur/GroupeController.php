<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;


use App\Models\Filiere;
use App\Models\Group;

use App\Models\Groupe;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupeController extends Controller
{


    // public function manageGroupes(Module $module)
    // {
    //     $groupes = $module->groupes()->orderBy('type')->get(); // Récupère les groupes liés au module
    //     return view('groupes.index', compact('module', 'groupes'));
    // }


    // public function createGroupe(Module $module)
    // {
    //     return view('groupes.create', compact('module'));
    // }


    // public function storeGroupe(Request $request, Module $module)
    // {
    //     $validated = $request->validate([
    //         'type' => 'required|in:TP,TD',
    //         'name' => 'nullable|string|max:255',
    //         'max_students' => 'nullable|integer|min:0',
    //         'annee' => 'required|integer',
    //     ]);

    //     $module->groupes()->create(array_merge($validated, ['annee' => $validated['annee'] ?? now()->year]));

    //     return redirect()->route('groupes.index', $module)->with('success', 'Groupe créé avec succès!');
    // }


    // public function editGroupe(Module $module, Groupe $groupe)
    // {
    //     return view('groupes.edit', compact('module', 'groupe'));
    // }

    // public function updateGroupe(Request $request, Module $module, Groupe $groupe)
    // {
    //     $validated = $request->validate([
    //         'type' => 'required|in:TP,TD',
    //         'name' => 'nullable|string|max:255',
    //         'max_students' => 'nullable|integer|min:0',
    //         'annee' => 'required|integer',
    //     ]);

    //     $groupe->update($validated);

    //     return redirect()->route('groupes.index', $module)->with('success', 'Groupe mis à jour avec succès!');
    // }

    // public function destroyGroupe(Module $module, Groupe $groupe)
    // {
    //     $groupe->delete();
    //     return redirect()->route('groupes.index', $module)->with('success', 'Groupe supprimé avec succès!');
    // }

    /////////////////////////////////////////////////////////
    // Helper method to determine current semester
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





    //////confiquer tous les module de semester//////////
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
        $modules = Module::with(['tdGroups', 'tpGroups', 'professor', 'responsable'])
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

    ////modifier un module/////////////////////
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

    private function syncGroups($module, $type, $targetCount, $maxStudents)
    {
        $semestersData = $this->getNextSemester();

        $currentGroups = $module->groupes()->where('type', $type)->get();

        // Supprimer les groupes excédentaires
        if ($currentGroups->count() > $targetCount) {
            $module->groupes()
                ->where('type', $type)
                ->orderBy('id', 'desc')
                ->limit($currentGroups->count() - $targetCount)
                ->delete();
        }

        // Mettre à jour la taille maximale des groupes existants
        $module->groupes()
            ->where('type', $type)
            ->update(['max_students' => $maxStudents]);

        // Ajouter les groupes manquants
        if ($currentGroups->count() < $targetCount) {
            $groupsToAdd = $targetCount - $currentGroups->count();

            for ($i = 0; $i < $groupsToAdd; $i++) {
                Groupe::create([
                    'module_id' => $module->id,
                    'type' => $type,
                    'max_students' => $maxStudents,
                    'nbr_student' => 0,
                    'academicYear' => $semestersData['academic_year'], // Use correct column name
                    // 'name' => $type . ' ' . ($currentGroups->count() + $i + 1)
                ]);
            }
        }
    }
    ///////////////////////////////////////////



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
        $modules = Module::with(['tdGroups', 'tpGroups', 'professor', 'responsable'])
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

    // public function saveNextSemesterConfig(Request $request)
    // {
    //     $validated = $request->validate([
    //         'groups.td.*.max_students' => 'required|integer|min:10|max:50',
    //         'groups.tp.*.max_students' => 'required|integer|min:5|max:30',
    //         'groups.td.*.annee' => 'required|integer',
    //         'groups.tp.*.annee' => 'required|integer'
    //     ]);

    //     // Get the next semester data
    //     $nextSemester = $this->getNextSemester();
    //     $academicYear = $nextSemester['academic_year'];

    //     // Process TD groups
    //     foreach ($validated['groups']['td'] ?? [] as $groupId => $data) {
    //         Groupe::where('id', $groupId)
    //             ->where('type', 'TD')
    //             ->update([
    //                 'max_students' => $data['max_students'],
    //                 'annee' => $academicYear
    //             ]);
    //     }

    //     // Process TP groups
    //     foreach ($validated['groups']['tp'] ?? [] as $groupId => $data) {
    //         Groupe::where('id', $groupId)
    //             ->where('type', 'TP')
    //             ->update([
    //                 'max_students' => $data['max_students'],
    //                 'annee' => $academicYear
    //             ]);
    //     }

    //     return back()->with('success', 'Configuration enregistrée avec succès!');
    // }

    private function updateGroups(array $groups, string $model)
    {
        foreach ($groups as $id => $data) {
            $model::find($id)->update([
                'professor_id' => $data['professor_id'],
                'max_students' => $data['max_students']
            ]);
        }
    }



    // private function getNextSemesterData()
    // {
    //     $current = app('current-semester'); // Assuming you have a helper/service

    //     return [
    //         'type' => $current['type'] === 'AUTOMNE' ? 'PRINTEMPS' : 'AUTOMNE',
    //         'number' => $current['number'] + 1,
    //         'year' => $current['type'] === 'AUTOMNE'
    //             ? $current['year']
    //             : $current['year'] + 1
    //     ];
    // }



    private function getAvailableProfessors()
    {
        return User::active()
            ->orderBy('lastname')
            ->get(['id', 'firstname', 'lastname']);
    }

    // private function updateGroups(array $groups, string $model)
    // {
    //     foreach ($groups as $id => $data) {
    //         $model::find($id)->update([
    //             'professor_id' => $data['professor_id'] ?? null,
    //             'max_students' => $data['max_students']
    //         ]);
    //     }
    // }
    /////////////////////////////////
    public function configure(Request $request)
    {
        $data = $request->validate([
            'filiere_id' => 'required|exists:filieres,id',
            'semester' => 'required|integer|between:1,6',
            'annee' => 'required|integer',
            'default_td' => 'required|integer|min:1',
            'default_tp' => 'required|integer|min:0',
            'max_td' => 'required|integer|min:10',
            'max_tp' => 'required|integer|min:5'
        ]);

        // Enregistrer la configuration (à implémenter selon votre logique)

        return back()->with('success', 'Configuration enregistrée avec succès');
    }

    public function manage(Module $module)
    {
        $tdGroups = $module->tdGroups()->get();
        $tpGroups = $module->tpGroups()->get();

        return view('coordonnateur.manage', compact('module', 'tdGroups', 'tpGroups'));
    }

    public function addTdGroup(Request $request, Module $module)
    {
        $max = $request->input('max_students', 30);

        $group = $module->groups()->create([
            'type' => 'TD',
            'max_students' => $max,
            'nbr_student' => 0,
            'annee' => date('Y')
        ]);

        return back()->with('success', 'Groupe TD créé avec succès');
    }

    public function addTpGroup(Request $request, Module $module)
    {
        $max = $request->input('max_students', 20);

        $group = $module->groups()->create([
            'type' => 'TP',
            'max_students' => $max,
            'nbr_student' => 0,
            'annee' => date('Y')
        ]);

        return back()->with('success', 'Groupe TP créé avec succès');
    }

    public function update(Request $request, Groupe $group)
    {
        $data = $request->validate([
            'max_students' => 'required|integer|min:1',
            'nbr_student' => 'required|integer|min:0'
        ]);

        $group->update($data);

        return back()->with('success', 'Groupe mis à jour avec succès');
    }

    public function delete(Groupe $group)
    {
        $group->delete();

        return back()->with('success', 'Groupe supprimé avec succès');
    }
}

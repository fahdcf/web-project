<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\admin_action;
use App\Models\Assignment;
use App\Models\chef_action;
use App\Models\coord_action;
use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Module;
use App\Models\prof_request;
use App\Models\Seance;
use App\Models\Student;
use App\Models\Task;
use App\Models\User;
use App\Models\user_detail;
use App\Models\user_log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoordonnateurController extends Controller
{


    public function affectations(Request $request)
    {
        if (!auth()->user()->isCoordonnateur()) {
            abort(403, 'Unauthorized: You are not a coordinator.');
        }

        $semester = $request->input('semester', '');
        $search = $request->input('name-search', '');
        $selected_prof = $request->input('professor', '');

        $query = Assignment::with(['user.role', 'module.filiere'])
            ->whereHas('user', function ($q) {
                $q->whereHas('role', fn($r) => $r->where('isprof', true)->orWhere('isvocataire', true));
            });

        if ($semester) {
            $query->whereHas('module', fn($q) => $q->where('semester', $semester));
        }
        if ($search) {
            $query->whereHas('user', fn($q) => $q->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%$search%"]));
        }

        $assignments = $query->get();

        // Module-centric view
        $modules = $assignments->groupBy('module_id')->map(function ($moduleAssignments) {
            $module = $moduleAssignments->first()->module;
            return [
                'module' => $module,
                'cm_profs' => $moduleAssignments->where('teach_cm', true)->map(function ($assignment) {
                    return [
                        'name' => $assignment->user->fullname,
                        'role' => $assignment->user->role->isprof ? 'Professor' : 'Vacataire',
                    ];
                })->unique('name')->values(),
                'td_profs' => $moduleAssignments->where('teach_td', true)->map(function ($assignment) {
                    return [
                        'name' => $assignment->user->fullname,
                        'role' => $assignment->user->role->isprof ? 'Professor' : 'Vacataire',
                    ];
                })->unique('name')->values(),
                'tp_profs' => $moduleAssignments->where('teach_tp', true)->map(function ($assignment) {
                    return [
                        'name' => $assignment->user->fullname,
                        'role' => $assignment->user->role->isprof ? 'Professor' : 'Vacataire',
                    ];
                })->unique('name')->values(),
                'total_hours' => $moduleAssignments->sum('hours'),
            ];
        })->values();

        // Professor-centric view
        $professors = $assignments->groupBy('prof_id')->map(function ($profAssignments) {
            $user = $profAssignments->first()->user;
            return [
                'id' => $user->id,
                'name' => $user->fullname,
                'role' => $user->role->isprof ? 'Professor' : 'Vacataire',
                'modules' => $profAssignments->map(function ($assignment) {
                    return [
                        'module_name' => $assignment->module->name,
                        'filiere' => $assignment->module->filiere ? $assignment->module->filiere->name : 'N/A',
                        'semester' => $assignment->module->semester ?? 'N/A',
                        'type' => $assignment->module->type,
                        'cm_hours' => $assignment->teach_cm ? $assignment->module->cm_hours : 0,
                        'td_hours' => $assignment->teach_td ? $assignment->module->td_hours : 0,
                        'tp_hours' => $assignment->teach_tp ? $assignment->module->tp_hours : 0,
                        'teaching_types' => collect([
                            $assignment->teach_cm ? 'CM' : null,
                            $assignment->teach_td ? 'TD' : null,
                            $assignment->teach_tp ? 'TP' : null,
                        ])->filter()->values(),
                    ];
                })->values(),
            ];
        })->values();

        // Filter professors for selected professor (if any)
        $selected_professor = $selected_prof ? $professors->firstWhere('id', $selected_prof) : null;

        $semesters = Module::distinct()->pluck('semester')->filter()->sort()->values();

        return view('coordonnateur.assignments', compact('modules', 'professors', 'semesters', 'selected_professor', 'selected_prof'));
    }

    public function dashboard()
    {

        $moduleCount = Module::where('filiere_id', auth()->user()->manage->id)
            ->where('status', 'active')
            ->count();

        $studentCount = Student::count();//place holder
        $vacataireCount = User::whereHas('role', fn($q) => $q->where('isvocataire', true))->count();
        $coordActions = coord_action::where('user_id', auth()->id())->latest()->take(5)->get();
        $tasks = Task::where('user_id', auth()->user()->id)->latest()->take(5)->get();

        // Répartition des Groupes TD/TP/CM
        $tdGroups = Module::sum('nbr_groupes_td');
        $tpGroups = Module::sum('nbr_groupes_tp');
        $cmGroups = Seance::where('type', 'CM')
            ->distinct('module_id')
            ->count();
        $groupesData = [$tdGroups, $tpGroups, $cmGroups];

        // Nombre de Séances par Jour
        $seancesParJourRaw = Seance::select('jour', DB::raw('count(*) as count'))
            ->groupBy('jour')
            ->pluck('count', 'jour')
            ->toArray();

        // Initialize all days with 0 count
        $days = ['Lundi' => 0, 'Mardi' => 0, 'Mercredi' => 0, 'Jeudi' => 0, 'Vendredi' => 0, 'Samedi' => 0];
        // Merge actual counts
        $seancesParJour = array_merge($days, $seancesParJourRaw);
        // Extract values in correct order
        $seancesParJour = array_values(array_intersect_key($seancesParJour, $days));


        return view('coordonnateur.dashboard', compact('moduleCount','studentCount', 'vacataireCount', 'coordActions', 'tasks', 'groupesData', 'seancesParJour'));
    }

    ////////////////////////////////////////////////////////////////
    public function vacataire_profile(User $user)
    {
        // dd(auth()->user()->manage->id);

        $assignement = Assignment::where('prof_id', $user->id)->get();

        $available_modules = Module::with(['filiere', 'responsable', 'assignments'])
            ->where('status', 'active')
            ->where('filiere_id', auth()->user()->manage->id)
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

        return view('coordonnateur.vacataire_profile', ['user' => $user, 'available_modules' => $available_modules, 'assignement' => $assignement]);
    }

    public function editHours(User $user)
    {
        if (auth()->user()->role->iscoordonnateur) {

            request()->validate([
                'min_hours' => 'nullable|numeric',
                'max_hours' => 'nullable|numeric',

            ]);

            $userDetails = $user->user_details;

            if (!$userDetails) {
                $userDetails = user_detail::create(['user_id' => $user->id]);
            }

            if (request('min_hours') && $userDetails->min_hours !== request('min_hours')) {
                $userDetails->min_hours = request('min_hours');
            }
            if (request('max_hours') && $userDetails->max_hours !== request('max_hours')) {
                $userDetails->max_hours = request('max_hours');
            }
            $userDetails->save();

            // $chefActionDetails = [
            //     'chef_id' => auth()->user()->id,
            //     'action_type' => 'modifier',
            //     'description' => auth()->user()->firstname . " " . auth()->user()->lastname . " a modifieé la charge horaire du professeur " . $prof->firstname . " " . $prof->lastname,
            //     'target_table' => 'users',
            //     'target_id' => $vacataire->id,
            // ];
            // chef_action::create($chefActionDetails);



            return redirect()->back();
        }

        return redirect()->back()->with('success', 'hours modifiee avec succès.');;
    }

    public function removeAssignation(Assignment $assignation)
    {

        $profId = $assignation->prof_id;
        $prof = User::findOrFail($profId);

        $assignation->delete();
        coord_action::create(['user_id' => auth()->id(), 'action_type' => 'delete', 'target_table' => 'assignments', 'target_id' => $assignation->id, 'description' => "Suppression de l'assignation pour le professeur: {$prof->firstname} {$prof->lastname}"]);

        // chef_action::create($chefActionDetails);

        return redirect()->back()->with('success', 'assignation du module supprimé avec succès.');
    }


    public function affecterModules()
    {

        $tab = [];
        $i = 0;

        foreach (request('modules') as $assaign) {
            // dd($assaign);
            $id = $assaign['module_id'];
            $module = Module::findOrFail($id);

            if ($assaign['prof_id']) {

                $prof = user::findOrFail($assaign['prof_id']); //find the vacatiaire

                $module->status = "active";


                $newAssign = [
                    'prof_id' => $prof->id,
                    'module_id' => $module->id,
                ];

                $hours = 0;
                if ($assaign['cm'] == "cm") {
                    $newAssign['teach_cm'] = 1;
                    $hours = $hours + $module->cm_hours;
                }

                if ($assaign['tp'] == "tp") {
                    $newAssign['teach_tp'] = 1;

                    $coff = 1;
                    if ($module->nbr_groupes_tp > 1) $coff = $module->nbr_groupes_tp;


                    $hours = $hours + $module->tp_hours * $coff;
                }

                if ($assaign['td'] == "td") {
                    $newAssign['teach_td'] = 1;

                    $coff = 1;
                    if ($module->nbr_groupes_td > 1) $coff = $module->nbr_groupes_td;

                    $hours = $hours + $module->td_hours * $coff;
                }


                $newAssign['hours'] = $hours;

                $tab[$i] = $newAssign;
                $i++;

                $assignation=Assignment::create($newAssign);
                coord_action::create(['user_id' => auth()->id(), 'action_type' => 'affecter', 'target_table' => 'assignments', 'target_id' => $assignation->id, 'description' => "Affectation du module pour le professeur: {$prof->firstname} {$prof->lastname}"]);


                $module->save();


                // $chefActionDetails = [
                //     'chef_id' => auth()->user()->id,
                //     'action_type' => 'affecter',
                //     'description' => auth()->user()->firstname . " " . auth()->user()->lastname . " a affecteé le module " . $module->name . " a le professeur " . $prof->firstname . " " . $prof->lastname,
                //     'target_table' => 'modules',
                //     'target_id' => $module->id,
                // ];
                // chef_action::create($chefActionDetails);
            }
        }





        return redirect()->back()->with('success', 'assignation effectuee avec succès.');;
    }
    ///////////////////////////////////////////////////////////////////////


}

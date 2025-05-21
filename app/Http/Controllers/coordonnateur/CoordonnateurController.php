<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\admin_action;
use App\Models\chef_action;
use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Module;
use App\Models\prof_request;
use App\Models\Student;
use App\Models\task;
use App\Models\User;
use App\Models\user_log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CoordonnateurController extends Controller
{

    //  public function index(Request $request)
    // {
    //     // $filiere = Filiere::findOrFail($request->input('filiere_id', auth()->user()->filiere_id));
    //     // $semester = $request->input('semester', 1);
    //     // $annee = $request->input('annee', date('Y'));

    //     // $modules = Module::where('filiere_id', $filiere->id)
    //     //     ->where('semester', $semester)
    //     //     ->withCount(['tdGroups', 'tpGroups'])
    //     //     ->get();

    //     return view('coordonnateur.groupes');
    // }

    public function dashboard()
    {


        $studentCount = student::get()->count();
        $professorCount = User::get()->count();
        $chefHistory = chef_action::latest()->take(4)->get();
        $tasks = task::where('user_id', auth()->user()->id)->latest()->take(5)->get();

        $departmentName =  auth()->user()->manage->name;
        $professorsMin = user::where('departement', $departmentName)->paginate(15);


        $professorsMin = User::where('departement', $departmentName)->latest()->take(3)->get();
        $module_requests = prof_request::where('type', 'module')->where('status', 'pending')->latest()->take(3)->get();

        // Get user logs this week
        $logs = user_log::whereBetween('created_at', [
            Carbon::now()->startOfWeek(), // Monday
            Carbon::now()->endOfWeek(),   // Sunday
        ])->get();


        $logsByDay = $logs->groupBy(function ($log) {
            return ucfirst(Carbon::parse($log->created_at)->locale('fr')->isoFormat('dddd'));
        });

        // Prepare counts for each day
        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        // Build login counts
        $loginCounts = [];
        foreach ($days as $day) {
            $loginCounts[] = isset($logsByDay[$day]) ? $logsByDay[$day]->count() : 0;
        }



        return View('coordonnateur.dashboard', ['tasks' => $tasks, 'studentCount' => $studentCount, 'professorCount' => $professorCount, 'chefHistory' => $chefHistory, 'professorsMin' => $professorsMin, 'loginCounts' => $loginCounts, 'module_requests' => $module_requests]);
    }


    public function vacataires()
    {
        $user = auth()->user();

        //list des vacatairee
        $vacataires = User::whereHas('role', function ($query) {
            $query->where('isvocataire', true);
        })->with('user_details')->simplePaginate(10);


        // $modules = Module::where('filiere_id', $user->manage->id)
        //     ->whereNull('professor_id')
        //     ->orderBy('name')
        //     ->get();

        return view('coordonnateur.vacataires.index', compact('vacataires'));
    }

    public function createVacataire()
    {
        return view('vacataire.create');
    }

    public function storeVacataire(Request $request)
    {


        // dd($request->all());
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:modules,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cm_hours' => 'required|integer|min:10',
            'td_hours' => 'required|integer|min:10',
            'tp_hours' => 'required|integer|min:10',
            'semester' => 'required|integer|min:1',

            'specialty' => 'nullable|string|max:255',
            'credit' => 'required|integer|min:1',
            'responsable_id' => 'nullable|exists:users,id'
        ]);
        // dd($validated);

        // Ajoute automatiquement la filière du coordonnateur
        $attributes = array_merge($validated, [
            'filiere_id' => auth()->user()->manage->id
        ]);

        Module::create($attributes);

        return redirect()->route('coordonnateur.modules.index')->with('success', 'UE créée avec succès !');
    }

    public function manageGroups(Request $request)
    {
        // Simulation de mise à jour des groupes
        return back()->with('success', 'Configuration des groupes enregistrée!');
    }

    ////////////////page des gestion des groupes////////
    //     public function groupes()
    // {
    //     // Récupérer le module
    //     // $module = Module::find(2);
    //     $modules = Module::get();


    //     // Récupérer tous les groupes liés à ce module
    //     $groupes = Groupe::get();

    //     // Calcul des totaux
    //     $totalGroupes = $groupes->count();
    //     $totalTD = $groupes->where('type', 'TD')->count();
    //     $totalTP = $groupes->where('type', 'TP')->count();
    //     $totalCapacity = $groupes->sum('max_students');
    //     $totalStudents = $groupes->sum('nbr_student');

    //     // Nombre total de modules actifs (optionnel selon ta logique)
    //     $totalModules = Module::count();

    //     // Grouper les groupes par module (ici c'est 1 seul module, mais la vue semble attendre une collection groupée)
    //     $groupesParModule = collect([$modules->name => $groupes]);

    //     // Extraire les années uniques
    //     $anneesUniques = $groupes->pluck('annee')->unique()->sort()->values();

    //     return view('coordonnateur.groupes', [
    //         'totalGroupes'     => $totalGroupes,
    //         'totalTD'          => $totalTD,
    //         'totalTP'          => $totalTP,
    //         'totalCapacity'    => $totalCapacity,
    //         'totalStudents'    => $totalStudents,
    //         'totalModules'     => $totalModules,
    //         'groupesParModule' => $groupesParModule,
    //         'anneesUniques'    => $anneesUniques,
    //     ]);
    // }

    // public function groupes()
    //     {

    //         $filiere=auth()->user()->manage;
    //         $groupes = Groupe::with('module')->orderBy('annee')->orderBy('module_id')->orderBy('type')->get();
    //         $groupesParAnnee = $groupes->groupBy('annee')->sortKeysDesc();
    //         $anneesUniques = $groupes->pluck('annee')->unique()->sortDesc()->values()->toArray();
    //         $modules = Module::orderBy('name')->paginate(3);

    //         return view('coordonnateur.groupes', compact('groupesParAnnee', 'filiere','anneesUniques', 'modules'));
    //     }



}

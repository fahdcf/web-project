<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Module;
use App\Models\User;
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
        // Données fictives pour la filière
        $filiere = (object)[
            'id' => 1,
            'nom' => 'Génie Informatique',
            'code' => 'GI'
        ];

        // Données statistiques fictives
        $stats = [
            'total_ues' => 15,
            'total_vacataires' => 8,
            'groupes_pending' => 3,
            'edt_pending' => 7
        ];

        // Données fictives pour les UE
        $ues = [
            (object)[
                'id' => 1,
                'code' => 'M1101',
                'name' => 'Programmation Web',
                'semester' => 1,
                'professeur' => (object)[
                    'id' => 1,
                    'nom_complet' => 'Pr. Ahmed ZEROUAL'
                ],
                'valide' => true
            ],
            (object)[
                'id' => 2,
                'code' => 'M1102',
                'name' => 'Base de Données',
                'semester' => 1,
                'professeur' => null,
                'valide' => false
            ],
            // Ajouter d'autres UE fictives au besoin...
        ];

        // Données fictives pour les groupes
        $groupes = [
            (object)[
                'ue' => (object)[
                    'code' => 'M1101',
                    'semester' => 1
                ],
                'nb_td' => 2,
                'nb_tp' => 2,
                'confirme' => true
            ],
            (object)[
                'ue' => (object)[
                    'code' => 'M1102',
                    'semester' => 1
                ],
                'nb_td' => 3,
                'nb_tp' => 3,
                'confirme' => false
            ],
        ];

        // Données fictives pour les vacataires
        $vacataires = [
            (object)[
                'id' => 1,
                'nom_complet' => 'M. Karim BENNANI',
                'email' => 'k.bennani@example.com',
                'specialite' => 'Développement Web',
                'ues_count' => 2
            ],
            (object)[
                'id' => 2,
                'nom_complet' => 'Mme. Fatima ALAOUI',
                'email' => 'f.alaoui@example.com',
                'specialite' => 'Base de Données',
                'ues_count' => 1
            ],
        ];

        // Affectations aux vacataires
        $affectations_vacataires = [
            (object)[
                'ue' => (object)[
                    'code' => 'M1101',
                    'semester' => 1
                ],
                'vacataire' => (object)[
                    'nom_complet' => 'M. Karim BENNANI',
                    'email' => 'k.bennani@example.com'
                ]
            ]
        ];

        // Créneaux EDT fictifs
        $creneaux = [
            (object)[
                'id' => 1,
                'jour' => 'Lundi',
                'plage' => '8h-10h'
            ],
            (object)[
                'id' => 2,
                'jour' => 'Mardi',
                'plage' => '10h-12h'
            ],
        ];

        // Historique des années
        $annees_historique = [
            '2023/2024',
            '2022/2023',
            '2021/2022'
        ];
        $annee_universitaire = 2024;

        return view('coordonnateur.dashboard', compact(
            'filiere',
            'stats',
            'ues',
            'groupes',
            'vacataires',
            'affectations_vacataires',
            'creneaux',
            'annees_historique',
            'annee_universitaire'

        ));
    }


    public function vacataires()
    {
        $user = auth()->user();

        $vacataires = User::whereHas('role', function ($query) {
            $query->where('isvocataire', true);
        })->with('user_details')->simplePaginate(10);

        $modules = Module::where('filiere_id', $user->manage->id)
            ->orderBy('name')
            ->get();

        return view('coordonnateur.vacataires.index', compact('vacataires', 'modules'));
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

    public function addVacataire(Request $request)
    {
        // Simulation d'ajout de vacataire
        return back()->with('success', 'Vacataire ajouté avec succès!');
    }

    public function affecterEDT(Request $request)
    {
        // Simulation d'affectation EDT
        return back()->with('success', 'Affectation enregistrée!');
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

<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;

class CoordonnateurController extends Controller
{
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
        $annee_universitaire=2024;

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


    public function createVacataire(){
        return view ('vacataire.create');
    }
    public function storeVacataire(Request $request){


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
}
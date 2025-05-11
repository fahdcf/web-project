<?php
namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Module;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    // Afficher la liste des UE

    public function showConfirmDelete(Module $module)
    {
        return view('modules.confirm-delete', compact('module'));
    }

    // Afficher la liste des UE
    public function index()
    {
        $user = auth()->user();

        $semestersData = [];
        for ($i = 1; $i <= 6; $i++) {
            $semestersData["S$i"] = Module::with(['professor', 'filiere'])
                ->where('filiere_id', $user->manage->id)
                ->where('semester', $i)
                ->whereIn('status', [0, 1])
                ->orderBy('name')
                ->get();
        }

        $filiere = $user->manage;
        $vacataires = User::whereHas('role', function ($query) {
            $query->where('isvocataire', true);
        })->get();

        return view('modules.index', [
            'filiere' => $filiere,
            'vacataires' => $vacataires,
            'semesters' => $semestersData
        ]);
    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $filiereId = $user->manage->id;

        $filterSemester = $request->input('filterSemester');
        $filterStatus = $request->input('filterStatus');
        $searchInput = $request->input('searchInput');

        $query = Module::with(['professor', 'filiere'])->where('filiere_id', $filiereId);

        if ($filterSemester !== 'all') {
            $query->where('semester', $filterSemester);
        }

        if ($filterStatus !== 'all') {
            $query->where('status', $filterStatus === 'actif' ? 1 : 0); // Adaptez vos valeurs de statut
        }

        if ($searchInput) {
            $query->where(function ($q) use ($searchInput) {
                $q->where('code', 'like', '%' . $searchInput . '%')->orWhere('name', 'like', '%' . $searchInput . '%');
            });
        }

        $searchResults = $query->get();

        $semestersData = [];
        for ($i = 1; $i <= 6; $i++) {
            $semestersData["S$i"] = Module::with(['professor', 'filiere'])
                ->where('filiere_id', $filiereId)
                ->where('semester', $i)
                ->whereIn('status', [0, 1])
                ->orderBy('name')
                ->get();
        }

        $filiere = $user->manage;
        $vacataires = User::whereHas('role', function ($query) {
            $query->where('isvocataire', true);
        })->get();

        return view('modules.index', [
            'filiere' => $filiere,
            'vacataires' => $vacataires,
            'semesters' => $semestersData,
            'searchResults' => $searchResults
        ]);
    }

    // Afficher le formulaire de création
    public function create()
    {
        $professeurs = User::whereHas('role', function ($query) {
            $query->where('isprof', true);
        })
            ->whereHas('filieres', function ($query) {
                $query->where('filieres.id', auth()->user()->filiere_id);
            })
            ->get();

        return view('modules.create', compact('professeurs'));
    }

    public function show($id)
    {
        // Récupère le module avec l'ID donné
        $module = Module::with('professor')->findOrFail($id);
        // dd($module);

        // $modules=Module::find(3);
        // dd($modules->status);
        // Retourne la vue avec les données du module et du professeur
        return view('modules.show', compact('module'));
    }

    public function edit(Module $module)
    {
        $professors = User::all();

        return view('modules.edit', compact('module', 'professors'));
    }
    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:modules,code,' . $module->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cm_hours' => 'required|integer|min:10',
            'td_hours' => 'required|integer|min:10',
            'tp_hours' => 'required|integer|min:10',
            'semester' => 'required|integer|min:1',
            'specialty' => 'nullable|string|max:255',
            'nb_groupes_td' => 'required|integer|min:1',
            'nb_groupes_tp' => 'required|integer|min:1',
            'credit' => 'required|integer|min:1',
            'responsable_id' => 'nullable|exists:users,id'
        ]);

        $module->update($validated);
        dd($validated);

        return redirect()->route('coordonnateur.modules.index')->with('success', 'Module mis à jour avec succès.');
    }

    public function store(Request $request)
    {
        // dd($request);

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

    public function destroy(Module $module)
    {
        // Supprimer le module
        $module->delete();

        // Rediriger avec un message de succès
        return redirect()->route('coordonnateur.modules.index')->with('success', 'Module supprimé avec succès.');
    }
}

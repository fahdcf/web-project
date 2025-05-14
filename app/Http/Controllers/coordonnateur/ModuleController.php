<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
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
                // ->where('status', 1)
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
            'searchResults' => null
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
                ->where('filiere_id', $user->manage->id)
                ->where('semester', $i)
                // ->where('status', 1)
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
            'searchResults' => $searchResults, // Afficher les résultats après la recherche
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
        $parentModules=Module::where('type','complet')->get();

        return view('modules.create', compact('professeurs','parentModules'));
    }

    public function store(Request $request)
{
    // Validation rules
    $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'cm_hours' => 'required|integer|min:10',
        'td_hours' => 'required|integer|min:10',
        'tp_hours' => 'required|integer|min:10',
        'semester' => 'required|integer|min:1',
        'specialty' => 'nullable|string|max:255',
        'credit' => 'required|integer|min:1',
        'responsable_id' => 'nullable|exists:users,id',
        'type' => 'required|in:complet,element',
    ];

    // Conditionally add 'parent_id' validation if type is 'element'
    if ($request->input('type') === 'element') {
        $rules['parent_id'] = 'required|exists:modules,id';
    }

    $validated = $request->validate($rules);

    // Logic for handling 'element' type
    if ($validated['type'] === 'element') {
        // Find the parent module
        $parent = Module::find($validated['parent_id']);

        // Check if parent module exists
        if (!$parent) {
            return back()->withErrors(['parent_id' => 'Parent module not found.'])->withInput();
        }

        // Generate the code for the element
        $code = $parent->code . '-' . (Module::where('parent_id', $validated['parent_id'])->count() + 1);

        $attributes = array_merge($validated, [
            'filiere_id' => auth()->user()->manage->id,
            'code' => $code,
            'parent_id' => $validated['parent_id'],
        ]);
    Module::create($attributes);

    } else { // Logic for 'complet' type
        // Generate the code for the complete module
        $code = "M" . $validated['semester'] . "-" . uniqid(); // Using uniqid() for unique ID

        $attributes = array_merge($validated, [
            'filiere_id' => auth()->user()->manage->id,
            'parent_id' => null,
        ]);
    $module=Module::create($attributes);
    $module->code=
        "M".$module->semester."-".$module->id;
$module->save();

    }


    return redirect()->route('coordonnateur.modules.index')->with('success', 'UE créée avec succès!');
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

    
    public function destroy(Module $module)
    {
        // Supprimer le module
        $module->delete();

        // Rediriger avec un message de succès
        return redirect()->route('coordonnateur.modules.index')->with('success', 'Module supprimé avec succès.');
    }


    public function assignVacataire(Request $request)
    {
        // 1. Validate the request data
        $attributes=$request->validate([
            'module_id' => 'required|exists:modules,id',
            'vacataire_id' => 'required|exists:users,id',
            'role' => 'required|in:enseignant,responsable',
            'hours' => 'required|integer|min:1',
        ]);

        

                Assignment::create($attributes);



        // 4. Return a success response (redirect)
        return redirect()->route('coordonnateur.modules.index')->with('success', 'Vacataire assigned successfully!');
    }
}

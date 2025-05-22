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





        $modules=Module::where('filiere_id', $user->manage->id)->get();


        $filiere = $user->manage;
        $allVacataires = User::whereHas('role', function ($query) {
            $query->where('isvocataire', true);
        })->get();

        return view('modules.index', [
            'filiere' => $filiere,
            'allVacataires' => $allVacataires,
            'semesters' => $semestersData,
            'searchResults' => null,
            'modules'=>$modules
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
            $query->where('status', $filterStatus); // Adaptez vos valeurs de statut

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
        //cpas bonne pour le chef deparemtent
        $filiere = auth()->user()->manage;
        $professeurs = User::whereHas('role', function ($query) {
            $query->where('isprof', true);
        })
            ->whereHas('filieres', function ($query) {
                $query->where('filieres.id', auth()->user()->filiere_id);
            })
            ->get();
        $parentModules = Module::where('type', 'complet')->get();

        return view('modules.create', compact('professeurs', 'parentModules', 'filiere'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'type' => 'required|in:complet,element',
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',

            'semester' => 'required|integer|min:1',
            'credits' => 'required|integer|min:1',
            'evaluation' => 'required|integer|min:1',

            'description' => 'nullable|string',

            'cm_hours' => 'nullable|integer',
            'td_hours' => 'nullable|integer',
            'tp_hours' => 'nullable|integer',
            'autre_hours' => 'nullable|integer',

            'responsable_id' => 'nullable|exists:users,id',
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
            $module = Module::create($attributes);
            $module->code =
                "M" . $module->semester . "-" . $module->id;
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

    public function edit(Module $module, Filiere $filiere)
    {
        $professeurs = User::all(); // Or fetch relevant professors
        $parentModules = Module::where('filiere_id', $filiere->id)->where('id', '!=', $module->id)->get(); // Fetch parent modules for the same filiere, excluding the current module
        $anneeUniversitaire = '2024-2025'; // Or dynamically determine the academic year

        return view('modules.edit', compact('module', 'filiere', 'professeurs', 'parentModules', 'anneeUniversitaire'));
    }


    public function update(Request $request, Module $module)
{
    // Validation rules (similar to store, but parent_id is conditionally nullable)
    $rules = [
        'type' => 'required|in:complet,element',
        'name' => 'required|string|max:255',
        'specialty' => 'nullable|string|max:255',
        'status' => 'required|in:active,inactive',

        'semester' => 'required|integer|min:1',
        'credits' => 'required|integer|min:1',
        'evaluation' => 'required|integer|min:1',
        'description' => 'nullable|string',
        'cm_hours' => 'nullable|integer',
        'td_hours' => 'nullable|integer',
        'tp_hours' => 'nullable|integer',
        'autre_hours' => 'nullable|integer',
        'responsable_id' => 'nullable|exists:users,id',
    ];

    // Conditionally add 'parent_id' validation if type is 'element'
    if ($request->input('type') === 'element') {
        $rules['parent_id'] = 'required|exists:modules,id|different:' . $module->id;
    } else {
        $rules['parent_id'] = 'nullable';
    }

    $validated = $request->validate($rules);

    // Logic for handling 'element' type update
    if ($validated['type'] === 'element') {
        // Find the parent module
        $parent = Module::find($validated['parent_id']);

        // Check if parent module exists
        if (!$parent) {
            return back()->withErrors(['parent_id' => 'Parent module not found.'])->withInput();
        }

        // Generate the code for the element (it might be better to keep the original code if it doesn't change)
        // Option 1: Keep the existing code
        // $code = $module->code;

        // Option 2: Regenerate the code based on the new parent (use with caution if the code is used elsewhere)
        $code = $parent->code . '-' . (Module::where('parent_id', $validated['parent_id'])->where('id', '!=', $module->id)->count() + 1);

        $validated['parent_id'] = $validated['parent_id'];
        $validated['code'] = $code;
    }else { // Logic for 'complet' type update
        // Generate the code for the complete module if the semester changes
        if ($module->type === 'complet' && $module->semester !== $validated['semester']) {
            $validated['code'] = "M" . $validated['semester'] . "-" . $module->id;
        } else {
            // Keep the existing code if the semester doesn't change and it's a complete module
            $validated['code'] = $module->code;
        }
        $validated['parent_id'] = null;
    }


    // Update the module attributes
    $module->update($validated);

    return redirect()->route('coordonnateur.modules.index')->with('success', 'UE mise à jour avec succès!');
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
        $attributes = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'vacataire_id' => 'required|exists:users,id',
            'role' => 'required|in:enseignant,responsable',
            'hours' => 'required|integer|min:1',
        ]);



        Assignment::create($attributes);



        // 4. Return a success response (redirect)
        return redirect()->route('coordonnateur.modules.index')->with('success', 'Vacataire assigned successfully!');
    }

    /////////////////////////
    // public function getAssignedVacataires(Module $module)
    // {
    //     $vacataires = $module->users()->get()->map(function ($vacataire) {
    //         return [
    //             'id' => $vacataire->id,
    //             'full_name' => $vacataire->lastname . ' ' . $vacataire->firstname,
    //             'pivot' => [
    //                 'hours' => $vacataire->pivot->hours
    //             ]
    //         ];
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'vacataires' => $vacataires
    //     ]);
    // }

    // public function assignVacataires(Request $request)
    // {
    //     $request->validate([
    //         'module_id' => 'required|exists:modules,id',
    //         'vacataires' => 'nullable|array',
    //         'vacataires.*' => 'exists:users,id',
    //         'hours' => 'required|array',
    //         'hours.*' => 'required|integer|min:1'
    //     ]);

    //     $module = Module::find($request->module_id);
    //     $assignations = [];

    //     foreach ($request->vacataires ?? [] as $vacataireId) {
    //         $assignations[$vacataireId] = ['hours' => $request->hours[$vacataireId]];
    //     }

    //     $module->users()->sync($assignations);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Assignation mise à jour avec succès'
    //     ]);
    // }

    public function showAssignationPage(Module $module)
    {

        $availableVacataires = User::whereHas('role', function ($query) {
            $query->where('isvocataire', true);
        })->orderBy('lastname')
            ->get();


        // $availableVacataires = User::where('role', 'vacataire')
        //     ->whereDoesntHave('modules', function ($query) use ($module) {
        //         $query->where('modules.id', $module->id);
        //     })
        //     ->orderBy('lastname')
        //     ->get();

        return view('modules.assignation', [
            'module' => $module,
            'availableVacataires' => $availableVacataires
        ]);
    }

    public function updateHours(Request $request, Module $module)
    {
        $validated = $request->validate([
            'cm_hours' => 'required|integer|min:0',
            'td_hours' => 'required|integer|min:0',
            'tp_hours' => 'required|integer|min:0'
        ]);

        $module->update($validated);

        return back()->with('success', 'Charges horaires mises à jour');
    }

    public function addAssignation(Request $request, Module $module)
    {
        $validated = $request->validate([
            'vacataire_id' => 'required|exists:users,id',
            'role' => 'required|in:CM,TD,TP,Autre',
            'hours' => 'required|integer|min:1'
        ]);

        $module->users()->attach($validated['vacataire_id'], [
            'role' => $validated['role'],
            'hours' => $validated['hours']
        ]);

        return back()->with('success', 'Assignation ajoutée');
    }

    public function updateAssignation(Request $request, Module $module, User $vacataire)
    {
        $validated = $request->validate([
            'role' => 'required|in:CM,TD,TP,Autre',
            'hours' => 'required|integer|min:1'
        ]);

        $module->users()->updateExistingPivot($vacataire->id, [
            'role' => $validated['role'],
            'hours' => $validated['hours']
        ]);

        return back()->with('success', 'Assignation mise à jour');
    }

    public function removeAssignation(Module $module, User $vacataire)
    {

        $module->users()->detach($vacataire->id);

        return back()->with('success', 'Assignation supprimée');
    }
}

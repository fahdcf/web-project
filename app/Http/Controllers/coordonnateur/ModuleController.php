<?php

namespace App\Http\Controllers\coordonnateur;

use App\Exports\ModulesExport;
use App\Http\Controllers\Controller;
use App\Imports\ModulesImport;
use App\Models\Assignment;
use App\Models\coord_action;
use App\Models\Deadline;
use App\Models\Departement;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isCoordonnateur()) {
            abort(403, 'Unauthorized: You are not a coordinator.');
        }

        $filiere_id = auth()->user()->manage->id;
        $modules = Module::with(['filiere', 'responsable'])
            ->where('filiere_id', $filiere_id)
            ->get();

        return view('modules.index', compact('modules'));
    }

    public function show(Module $module)
    {
        // $responsables = User::where('filiere_id', auth()->user()->filiere_id)->get();
        $responsables = User::get();
        return view('modules.show', compact('module', 'responsables'));
    }


    public function update(Request $request, Module $module)
    {
        // Validation rules
        $rules = [
            'type' => 'required|in:complet,element',
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'semester' => 'required|integer|min:1|max:6',
            'credits' => 'required|integer|min:1',
            'evaluation' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string',
            'cm_hours' => 'required|integer|min:0',
            'td_hours' => 'required|integer|min:0',
            'tp_hours' => 'required|integer|min:0',
            'autre_hours' => 'required|integer|min:0',
            'responsable_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive',
        ];

        // Conditionally add 'parent_id' validation if type is 'element'
        if ($request->input('type') === 'element') {
            $rules['parent_id'] = 'required|exists:modules,id';

            // Additional validation to prevent circular references
            $rules['parent_id'] .= '|not_in:' . $module->id;
        }

        $validated = $request->validate($rules);

        // Handle type change validation
        if ($module->type === 'complet' && $validated['type'] === 'element') {
            // Check if this module has any child elements
            if ($module->children()->exists()) {
                return back()
                    ->withErrors(['type' => 'Cannot change to element type because this module has child elements.'])
                    ->withInput();
            }
        }

        // Handle parent module changes
        if ($validated['type'] === 'element') {
            $parent = Module::find($validated['parent_id']);

            // Check if parent module exists and is not the same as current module
            if (!$parent || $parent->id === $module->id) {
                return back()
                    ->withErrors(['parent_id' => 'Invalid parent module selection.'])
                    ->withInput();
            }

            // If changing parent, update the code
            if ($module->parent_id !== $validated['parent_id']) {
                $newCode = $parent->code . '-' . (Module::where('parent_id', $validated['parent_id'])->count() + 1);
                $validated['code'] = $newCode;
            }
        } else {
            // If changing from element to complet, generate a new code
            if ($module->type === 'element') {
                $validated['code'] = "M" . $validated['semester'] . "-" . $module->id;
            }

            $validated['parent_id'] = null;
        }

        // Update the module
        $module->update($validated);
        coord_action::create(['user_id' => auth()->id(), 'action_type' => 'update', 'target_table' => 'modules', 'target_id' => $module->id, 'description' => "Mise à jour du module: {$module->name}"]);

        return redirect()
            ->route('coordonnateur.modules.index')
            ->with('success', 'UE mise à jour avec succès!');
    }



    public function create()
    {


        $filiere = auth()->user()->manage;
        $professeurs = User::with('role')->where('departement', auth()->user()->departement)->whereHas('role', function ($query) {
            $query->where('isprof', true)->orWhere('isvocataire', true);
        })
            ->get();
            // dd($professeurs);
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
            $module = Module::create($attributes);
            coord_action::create(['user_id' => auth()->id(), 'action_type' => 'create', 'target_table' => 'modules', 'target_id' => $module->id, 'description' => "Création du module: {$module->name}"]);
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



    public function edit(Module $module, Filiere $filiere)
    {
        $professeurs = User::all(); // Or fetch relevant professors
        $parentModules = Module::where('filiere_id', $filiere->id)->where('id', '!=', $module->id)->get(); // Fetch parent modules for the same filiere, excluding the current module
        $anneeUniversitaire = '2024-2025'; // Or dynamically determine the academic year

        return view('modules.edit', compact('module', 'filiere', 'professeurs', 'parentModules', 'anneeUniversitaire'));
    }


    public function export(Request $request)
    {
        $semester = $request->query('semester');
        $user = Auth::user();
        $filiere = Filiere::where('coordonnateur_id', $user->id)->firstOrFail();

        $query = Module::where('filiere_id', $filiere->id);

        if ($semester !== 'all') {
            $query->where('semester', $semester);
        }

        $modules = $query->orderBy('semester')->get();

        if ($modules->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun module trouvé pour l\'exportation.');
        }

        $filename = 'modules_' . ($semester === 'all' ? 'tous_semestres' : 'S' . $semester) . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new ModulesExport($modules), $filename);
    }



    public function import(Request $request)
    {
        $user = Auth::user();
        $filiere = Filiere::where('coordonnateur_id', $user->id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file|mimes:xlsx,xls|max:2048',
        ], [
            'excel_file.required' => 'Veuillez sélectionner un fichier Excel.',
            'excel_file.mimes' => 'Le fichier doit être au format .xlsx ou .xls.',
            'excel_file.max' => 'Le fichier ne doit pas dépasser 2 Mo.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Load the Excel file
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $highestColumn = $sheet->getHighestColumn();
            $rawHeaders = $sheet->rangeToArray("A1:{$highestColumn}1", null, true, true, false)[0];

            // Clean and normalize headers
            $normalizedHeaders = array_map(function ($header) {
                // Remove BOM, trim, lowercase, replace spaces with underscores
                $header = preg_replace('/^[\x{FEFF}]+/u', '', trim($header ?? ''));
                return strtolower(preg_replace('/\s+/', '_', $header));
            }, $rawHeaders);

            // Remove empty headers
            $normalizedHeaders = array_filter($normalizedHeaders, fn($v) => $v !== '');

            // Remove duplicates, keeping first occurrence
            $uniqueHeaders = [];
            foreach ($normalizedHeaders as $header) {
                if (!in_array($header, $uniqueHeaders)) {
                    $uniqueHeaders[] = $header;
                }
            }

            // Required headers
            $requiredHeaders = ['id', 'name', 'semester', 'description', 'cm_hours', 'td_hours', 'tp_hours', 'credits', 'evaluation', 'type'];
            $missingHeaders = array_diff($requiredHeaders, $uniqueHeaders);

            if (!empty($missingHeaders)) {
                return redirect()->back()->with('error', 'Colonnes requises manquantes : ' . implode(', ', $missingHeaders));
            }

            Excel::import(new ModulesImport($filiere->id), $file);
            coord_action::create(['user_id' => auth()->id(), 'action_type' => 'import', 'target_table' => 'modules', 'description' => 'Importation de modules via fichier.']);
            return redirect()->route('coordonnateur.modules.index')
                ->with('success', 'Unités d\'enseignement importées avec succès.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Ligne {$failure->row()} : " . implode(', ', $failure->errors());
            }
            return redirect()->back()->with('error', implode('; ', $errors));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Échec de l\'importation : ' . $e->getMessage());
        }
    }



    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




    // public function update(Request $request, Module $module)
    // {
    //     // Validation rules (similar to store, but parent_id is conditionally nullable)
    //     $rules = [
    //         'type' => 'required|in:complet,element',
    //         'name' => 'required|string|max:255',
    //         'specialty' => 'nullable|string|max:255',
    //         'status' => 'required|in:active,inactive',

    //         'semester' => 'required|integer|min:1',
    //         'credits' => 'required|integer|min:1',
    //         'evaluation' => 'required|integer|min:1',
    //         'description' => 'nullable|string',
    //         'cm_hours' => 'nullable|integer',
    //         'td_hours' => 'nullable|integer',
    //         'tp_hours' => 'nullable|integer',
    //         'autre_hours' => 'nullable|integer',
    //         'responsable_id' => 'nullable|exists:users,id',
    //     ];

    //     // Conditionally add 'parent_id' validation if type is 'element'
    //     if ($request->input('type') === 'element') {
    //         $rules['parent_id'] = 'required|exists:modules,id|different:' . $module->id;
    //     } else {
    //         $rules['parent_id'] = 'nullable';
    //     }

    //     $validated = $request->validate($rules);

    //     // Logic for handling 'element' type update
    //     if ($validated['type'] === 'element') {
    //         // Find the parent module
    //         $parent = Module::find($validated['parent_id']);

    //         // Check if parent module exists
    //         if (!$parent) {
    //             return back()->withErrors(['parent_id' => 'Parent module not found.'])->withInput();
    //         }

    //         // Generate the code for the element (it might be better to keep the original code if it doesn't change)
    //         // Option 1: Keep the existing code
    //         // $code = $module->code;

    //         // Option 2: Regenerate the code based on the new parent (use with caution if the code is used elsewhere)
    //         $code = $parent->code . '-' . (Module::where('parent_id', $validated['parent_id'])->where('id', '!=', $module->id)->count() + 1);

    //         $validated['parent_id'] = $validated['parent_id'];
    //         $validated['code'] = $code;
    //     } else { // Logic for 'complet' type update
    //         // Generate the code for the complete module if the semester changes
    //         if ($module->type === 'complet' && $module->semester !== $validated['semester']) {
    //             $validated['code'] = "M" . $validated['semester'] . "-" . $module->id;
    //         } else {
    //             // Keep the existing code if the semester doesn't change and it's a complete module
    //             $validated['code'] = $module->code;
    //         }
    //         $validated['parent_id'] = null;
    //     }


    //     // Update the module attributes
    //     $module->update($validated);

    //     return redirect()->route('coordonnateur.modules.index')->with('success', 'UE mise à jour avec succès!');
    // }


    public function destroy(Module $module)
    {
        // Supprimer le module
        $module->delete();
        coord_action::create(['user_id' => auth()->id(), 'action_type' => 'delete', 'target_table' => 'modules', 'target_id' => $module->id, 'description' => "Suppression du module: {$module->name}"]);

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

    // public function showAssignationPage(Module $module)
    // {

    //     $availableVacataires = User::whereHas('role', function ($query) {
    //         $query->where('isvocataire', true);
    //     })->orderBy('lastname')
    //         ->get();


    //     // $availableVacataires = User::where('role', 'vacataire')
    //     //     ->whereDoesntHave('modules', function ($query) use ($module) {
    //     //         $query->where('modules.id', $module->id);
    //     //     })
    //     //     ->orderBy('lastname')
    //     //     ->get();

    //     return view('modules.assignation', [
    //         'module' => $module,
    //         'availableVacataires' => $availableVacataires
    //     ]);
    // }

    // public function updateHours(Request $request, Module $module)
    // {
    //     $validated = $request->validate([
    //         'cm_hours' => 'required|integer|min:0',
    //         'td_hours' => 'required|integer|min:0',
    //         'tp_hours' => 'required|integer|min:0'
    //     ]);

    //     $module->update($validated);

    //     return back()->with('success', 'Charges horaires mises à jour');
    // }

    // public function addAssignation(Request $request, Module $module)
    // {
    //     $validated = $request->validate([
    //         'vacataire_id' => 'required|exists:users,id',
    //         'role' => 'required|in:CM,TD,TP,Autre',
    //         'hours' => 'required|integer|min:1'
    //     ]);

    //     $module->users()->attach($validated['vacataire_id'], [
    //         'role' => $validated['role'],
    //         'hours' => $validated['hours']
    //     ]);

    //     return back()->with('success', 'Assignation ajoutée');
    // }

    // public function updateAssignation(Request $request, Module $module, User $vacataire)
    // {
    //     $validated = $request->validate([
    //         'role' => 'required|in:CM,TD,TP,Autre',
    //         'hours' => 'required|integer|min:1'
    //     ]);

    //     $module->users()->updateExistingPivot($vacataire->id, [
    //         'role' => $validated['role'],
    //         'hours' => $validated['hours']
    //     ]);

    //     return back()->with('success', 'Assignation mise à jour');
    // }

    // public function removeAssignation(Module $module, User $vacataire)
    // {

    //     $module->users()->detach($vacataire->id);

    //     return back()->with('success', 'Assignation supprimée');
    // }

    ////////////////////////////////////////////////////////////////


    public function availableModules(Request $request)
    {
        $department = Departement::where('name', auth()->user()->departement)->first();

        // dd($department,auth()->user()->departement);
        // dd($department->name,auth()->user()->departement);

        $FilieretargetIDs = Filiere::where('department_id',  $department->id)
            ->pluck('id'); // Plucks all the IDs into a collection

        $modules = Module::with(['filiere', 'responsable', 'assignments'])
            ->whereIn('filiere_id', $FilieretargetIDs)
            ->where(function ($query) {
                $query->whereDoesntHave('assignment', function ($q) {
                    $q->where('teach_tp', 1);
                })->orWhereDoesntHave('assignment', function ($q) {
                    $q->where('teach_td', 1);
                })->orWhereDoesntHave('assignment', function ($q) {
                    $q->where('teach_cm', 1);
                });
            })
            ->get();




        // Fetch the active 'ue_selecion' deadline
        $deadline = Deadline::where('type', 'ue_selecion')
            ->where('status', 'active')
            ->where('deadline_date', '>', Carbon::now())
            ->first();

        // // Restrict access if no valid deadline exists
        // if (!$deadline) {
        //     return redirect()->route('professor.dashboard')->with('error', 'Aucune échéance active pour la sélection des UE.');
        // }

        return view('modules.availableModules', compact('modules', 'deadline'));
    }
}

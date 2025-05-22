<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Module;
use App\Models\Role;
use App\Models\User;
use App\Models\user_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class vacataireController extends Controller
{


    public function index(Request $request)
    {
        $query = User::where('role', 'vacataire')->with('userDetails');

        // Filtre de recherche
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('lastname', 'LIKE', "%$search%")
                    ->orWhere('firstname', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('id', 'LIKE', "%$search%");
            });
        }

        // Filtre par statut
        if ($request->has('status') && in_array($request->status, ['active', 'inactive'])) {
            $query->whereHas('userDetails', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // Nombre d'éléments par page
        $perPage = $request->input('rows', 15);
        $vacataires = $query->paginate($perPage);

        return view('coordonnateur.vacataires.index', compact('vacataires'));
    }

    public function create()
    {
        return view('coordonnateur.vacataires.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255|min:2',
            'lastname' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6',
            'status' => 'required|in:active,inactive',
            'min_hours' => 'nullable|numeric',
            'max_hours' => 'nullable|numeric',
            'date' => 'nullable|date',
            'adresse' => 'nullable|string|max:255',
            'tele' => 'nullable|numeric',
            'sexe' => 'nullable|in:male,female',
            'cin' => 'nullable|max:20',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $user = User::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);


        $userDetails = [
            'user_id' => $user->id,
            'status' => $validatedData['status'],
            'date_of_birth' => $validatedData['date'],
            'adresse' => $validatedData['adresse'],
            'number' => $validatedData['tele'],
            'cin' => $validatedData['cin'],
            'sexe' => $validatedData['sexe'],
            'min_hours' => $validatedData['min_hours'],
            'max_hours' => $validatedData['max_hours'],
        ];

        if ($request->hasFile('profile_img')) {
            $profileImgPath = $request->file('profile_img')->store('images/profile', 'public');
            $userDetails['profile_img'] = $profileImgPath;
        }



        Role::create(['user_id' => $user->id, 'isvocataire' => 1]);
        user_detail::create($userDetails);

        return redirect()->route('coordonnateur.vacataires.index')->with('success', 'Compte vacataire créé avec succès !');
    }

    public function update(Request $request, User $vacataire)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255|min:2',
            'lastname' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email,' . $vacataire->id,
            'password' => 'nullable|min:6',
            'status' => 'required|in:active,inactive',
            'min_hours' => 'nullable|numeric',
            'max_hours' => 'nullable|numeric',
            'date' => 'nullable|date',
            'adresse' => 'nullable|string|max:255',
            'tele' => 'nullable|numeric',
            'cin' => 'nullable|max:20',
            'sexe' => 'nullable|in:male,female',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_profile_img' => 'nullable|boolean',
        ]);

        $vacataire->update([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            // 'departement' => $validatedData['departement'], // Supprimer cette ligne
        ]);

        if ($validatedData['password']) {
            $vacataire->update(['password' => bcrypt($validatedData['password'])]);
        }

        $userDetails = [
            'status' => $validatedData['status'],
            'date_of_birth' => $validatedData['date'],
            'adresse' => $validatedData['adresse'],
            'number' => $validatedData['tele'],
            'cin' => $validatedData['cin'],
            'sexe' => $validatedData['sexe'],
            'min_hours' => $validatedData['min_hours'],
            'max_hours' => $validatedData['max_hours'],
        ];

        if ($request->hasFile('profile_img')) {
            if ($vacataire->userDetail && $vacataire->userDetail->profile_img) {
                Storage::disk('public')->delete($vacataire->userDetail->profile_img);
            }
            $profileImgPath = $request->file('profile_img')->store('images/profile', 'public');
            $userDetails['profile_img'] = $profileImgPath;
        } elseif (isset($validatedData['remove_profile_img']) && $validatedData['remove_profile_img']) {
            if ($vacataire->userDetail && $vacataire->userDetail->profile_img) {
                Storage::disk('public')->delete($vacataire->userDetail->profile_img);
                $userDetails['profile_img'] = null;
            }
        }

        $vacataire->user_details()->updateOrCreate(['user_id' => $vacataire->id], $userDetails);

        return redirect()->route('coordonnateur.vacataires.index')->with('success', 'Vacataire mis à jour avec succès.');
    }

    public function edit(User $vacataire)
    {

        // $vacataires = User::findOrfail($vacataire->id)->with('user_details');
        return view('coordonnateur.vacataires.edit', compact('vacataire'));
    }

    public function filter()
    {
        $query = User::WhereHas('role', function ($query) {
            $query->where('isvocataire', true);
        });

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%$search%")
                    ->orWhere('lastname', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");;
            });
        }


        if (request('status')) {
            $status = request('status');
            $query->whereHas('user_details', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }


        $rows = request('rows', 10); // default to 5 if not provided

        $vacataire = $query->with('user_details')->simplePaginate($rows);

        return view('coordonnateur.vacataires.index', compact('$vacataire'));
    }

    public function destroy(User $vacataire)
    {
        // Supprimer la photo de profil associée si elle existe
        if ($vacataire->userDetail && $vacataire->userDetail->profile_img) {
            Storage::disk('public')->delete($vacataire->userDetail->profile_img);
        }

        // Supprimer le vacataire
        $vacataire->delete();

        return redirect()->route('coordonnateur.vacataires.index')->with('success', 'Vacataire supprimé avec succès.');
    }



    public function dashboard()
    {
        $vacataireId = Auth::id(); // Get the logged-in vacataire's ID

        $assignments = Assignment::where('user_id', $vacataireId)
            ->with('module') // Eager load the module to access its details
            ->get();

        return view('vacataire.index', compact('assignments'));
    }

    public function uploadGrades(Module $module)
    {
        return view('vacataire.upload-grades', compact('module'));
    }

    public function storeGrades(Request $request, Module $module)
    {
        $request->validate([
            'session' => 'required|in:normale,rattrapage',
            'gradeFile' => 'required|file|mimes:csv|max:2048' // Adjust max size as needed
        ]);

        // 1. Handle File Upload
        $file = $request->file('gradeFile');
        $filename = 'grades_' . $module->id . '_' . $request->session . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('grades', $filename); // Store in 'grades' directory

        // 2.  Parse CSV and Store Grades (Example - Adjust based on your CSV structure)
        $filepath = Storage::path($path);
        $handle = fopen($filepath, 'r');
        $header = fgetcsv($handle); // Assuming first row is header

        DB::beginTransaction();
        try {
            while ($row = fgetcsv($handle)) {
                $gradeData = array_combine($header, $row);

                //  Example:  Storing in a 'grades' table
                DB::table('grades')->insert([
                    'module_id' => $module->id,
                    'student_id' => $gradeData['student_id'], // Adjust keys to your CSV
                    'grade' => $gradeData['grade'],
                    'session' => $request->session,
                    // ... other fields
                ]);
            }

            fclose($handle);
            DB::commit();

            return redirect()->route('vacataire.dashboard')->with('success', 'Grades uploaded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            Storage::delete($path); // Delete the file on error
            return redirect()->back()->withErrors(['error' => 'Error processing grade file: ' . $e->getMessage()])->withInput();
        }
    }


    ///////////////////////////
    public function showAssignForm(User $vacataire)
    {
        $modules = Module::orderBy('code')->get();
        return view('coordonnateur.assign-ue', compact('vacataire', 'modules'));
    }

    public function storeAssign(Request $request, User $vacataire)
    {
        $request->validate([
            'ues' => 'nullable|array',
            'ues.*' => 'exists:modules,id'
        ]);

        $vacataire->modules()->sync($request->ues ?? []);

        return redirect()
            ->route('assign', $vacataire->id)
            ->with('success', 'Assignation mise à jour avec succès');
    }

    ////////////////

    // groupe controller(new way)

    // public function mesModules()
    // {
    //     $vacataire = auth()->user();

    //     $modules = $vacataire->modulesVacataire()

    //         ->with('filiere') // Chargement anticipé de la filière
    //         ->orderBy('semester')
    //         ->get();


    //     return view('modules.mesModules', [
    //         'modules' => $modules
    //     ]);
    // }
}

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
    public function index()
    {
        $vacataires = User::whereHas('role', function ($query) {
            $query->where('isvocataire', true);
        })->with('user_details')->simplePaginate(10);

        return view('coordonnateur.vacataires.index', ['vacataires' => $vacataires]);
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
}

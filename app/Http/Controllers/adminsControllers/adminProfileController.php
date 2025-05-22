<?php

namespace App\Http\Controllers\adminsControllers;

use App\Http\Controllers\Controller;

use App\Models\filiere;
use App\Models\student;
use App\Models\User;
use App\Models\user_detail;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\FileProfilerStorage;


class adminProfileController extends Controller
{
    public function edit(Request $request, $id)
    {


                      $user = User::findOrFail($id);

                    
        // Validate incoming request data (adjust validation as necessary)
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|max:255',
            'email' => 'required|email|max:255',
            'departement' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'min_hours' => 'nullable|numeric',
            'max_hours' => 'nullable|numeric',
            'date' => 'nullable|date',
            'adresse' => 'nullable|string|max:255',
            'tele' => 'nullable|numeric',
            'cin' => 'nullable|max:20',
            'sexe' => 'nullable|in:male,female',

            'old_password' => 'nullable',
            'password' => 'nullable|confirmed',
        ]);







        if ($request->input('old_password') && $request->input('password') && $request->input('password_confirmation') && password_verify(request('old_password'), $user->password)) {

            $hashedPassword = password_hash(request(('password')), PASSWORD_BCRYPT);
            $user->password = $hashedPassword;
            $user->save();
        }
        // Check and update the user's information only if it has changed
        if ($user->lastname !== $request->input('lastname')) {
            $user->lastname = $request->input('lastname');
        }

        if ($user->firstname !== $request->input('firstname')) {
            $user->firstname = $request->input('firstname');
        }

        if ($user->email !== $request->input('email')) {
            $exists = User::where('email', $request->input('email'))->exists();
            if (!$exists) {

                $user->email = $request->input('email');
            } else {
                return redirect()->back()->withErrors(['email' => 'Email already exists.']);
            }
        }

        if ($request->input('departement') && $user->departement !== $request->input('departement')) {
            $user->departement = $request->input('departement');
        }

        $userDetails = $user->user_details;

        if (!$userDetails) {
            $userDetails = user_detail::create(['user_id' => $user->id]);
        }

        if (request('status') && $userDetails->status !== $request->input('status')) {
            $userDetails->status = $request->input('status');
        }

        if (request('min_hours') && $userDetails->min_hours !== $request->input('min_hours')) {
            $userDetails->min_hours = $request->input('min_hours');
        }
        if (request('max_hours') && $userDetails->max_hours !== $request->input('max_hours')) {
            $userDetails->max_hours = $request->input('max_hours');
        }

        if (request('date') && $userDetails->date_of_birth !== $request->input('date')) {
            $userDetails->date_of_birth = $request->input('date');
        }

        if (request('tele') && $userDetails->number !== $request->input('tele')) {
            $userDetails->number = $request->input('tele');
        }

        if (request('adresse') && $userDetails->adresse !== $request->input('adresse')) {
            $userDetails->adresse = $request->input('adresse');
        }


        if ($userDetails->cin !== $request->input('cin')) {
            $userDetails->cin = $request->input('cin');
        }

        if ($userDetails->sexe !== $request->input('sexe')) {
            $userDetails->sexe = $request->input('sexe');
        }



        if ($request->input('email')) {

            $role = $user->role; // Make sure this is the Role model object

            $rolesData = [
                'isadmin' => $request->boolean('isadmin'),
                'iscoordonnateur' => $request->boolean('iscoordonnateur'),
                'ischef' => $request->boolean('ischef'),
                'isprof' => $request->boolean('isprof'),
                'isvocataire' => $request->boolean('isvocataire'),
                'isstudent' => $request->boolean('isstudent'),
            ];

            if ($role) {
                $role->fill($rolesData)->save(); // clean update
            } else {
                $user->role()->create($rolesData);
            }
        }

        // Save the changes if any field has been updated
        $user->save();
        $userDetails->save();

        // Redirect with success message
        return redirect()->back();
    }

    public function studentprofile($id)
    {
        $student = student::findOrFail($id);
        $filiere_id = $student->filiere_id;
        $filiere = filiere::find($filiere_id);
        $filire_name = $filiere->name;
        $filieres = filiere::all();


        return view('admin.admin-student-profile', ['student' => $student, 'filiere_name' => $filire_name, 'filieres' => $filieres]);
    }

    public function editEtudiant(Request $request, $id)
    {


        $student = student::findOrFail($id);

        // Validate incoming request data (adjust validation as necessary)
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|max:255',
            'email' => 'required|email|max:255',
            'filiere_id' => 'nullable|max:255',
            'status' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'adresse' => 'nullable|string|max:255',
            'tele' => 'nullable|numeric',
            'cin' => 'nullable|max:20',
            'sexe' => 'nullable|in:male,female',

        ]);



        // Check and update the student's information only if it has changed
        if ($student->lastname !== $request->input('lastname')) {
            $student->lastname = $request->input('lastname');
        }

        if ($student->firstname !== $request->input('firstname')) {
            $student->firstname = $request->input('firstname');
        }

        if ($student->email !== $request->input('email')) {
            $exists = student::where('email', $request->input('email'))->exists();
            if (!$exists) {

                $student->email = $request->input('email');
            } else {
                return redirect()->back()->withErrors(['email' => 'Email already exists.']);
            }
        }

        if ($request->input('filiere_id') && $student->filiere_id !== $request->input('filiere_id')) {
            $student->filiere_id = $request->input('filiere_id');
        }




        if ($request->input('status') && $student->status !== $request->input('status')) {
            $student->status = $request->input('status');
        }



        if ($student->date_of_birth !== $request->input('date')) {
            $student->date_of_birth = $request->input('date');
        }

        if ($student->number !== $request->input('tele')) {
            $student->number = $request->input('tele');
        }

        if ($student->adresse !== $request->input('adresse')) {
            $student->adresse = $request->input('adresse');
        }


        if ($student->CNE !== $request->input('cin')) {
            $student->CNE = $request->input('cin');
        }

        if ($student->sexe !== $request->input('sexe')) {
            $student->sexe = $request->input('sexe');
        }






        // Save the changes if any field has been updated
        $student->save();

        // Redirect with success message
        return redirect()->back();
    }
}

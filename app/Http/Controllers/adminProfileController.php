<?php

namespace App\Http\Controllers;
use App\Models\user;
use App\Models\user_detail;
use Illuminate\Http\Request;


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
            'hours' => 'nullable|numeric',
            'date' => 'nullable|date',
            'adresse' => 'nullable|string|max:255',
            'tele' => 'nullable|numeric',
            'cin' => 'nullable|max:20',
            'sexe' => 'nullable|in:male,female',
            
            'old_password' => 'nullable',
            'password' => 'nullable|confirmed',
        ]);
        
        
        if ($request->input('old_password') && $request->input('password') &&$request->input('password_confirmation') && password_verify(request('old_password'),$user->password)) {

            $hashedPassword = password_hash(request(('password')), PASSWORD_BCRYPT);
            $user->password=$hashedPassword;
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
            $user->email = $request->input('email');
        }
        
        if ($request->input('departement') && $user->departement !== $request->input('departement')) {
            $user->departement = $request->input('departement');
        }
        
        $userDetails = $user->user_details;  

if(!$userDetails){
    $userDetails= user_detail::create(['user_id'=>$user->id]);
}

        if ($request->input('status') && $userDetails->status !== $request->input('status')) {
            $userDetails->status = $request->input('status');
        }

        if ($userDetails->hours !== $request->input('hours')) {
            $userDetails->hours = $request->input('hours');
        }
        
        if ($userDetails->date_of_birth !== $request->input('date')) {
            $userDetails->date_of_birth = $request->input('date');
        }
        
        if ($userDetails->number !== $request->input('tele')) {
            $userDetails->number = $request->input('tele');
        }

        if ($userDetails->adresse !== $request->input('adresse')) {
            $userDetails->adresse = $request->input('adresse');
        }


        if ($userDetails->cin !== $request->input('cin')) {
            $userDetails->cin = $request->input('cin');
        }

        if ($userDetails->sexe !== $request->input('sexe')) {
            $userDetails->sexe = $request->input('sexe');
        }
        



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
        

        // Save the changes if any field has been updated
        $user->save();
        $userDetails->save();

        // Redirect with success message
        return redirect()->back();
    }
}

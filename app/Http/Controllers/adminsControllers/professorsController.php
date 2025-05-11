<?php

namespace App\Http\Controllers\adminsControllers;
use App\Http\Controllers\Controller;
use App\Models\admin_action;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Models\Departement;
use App\Models\filiere;
use App\Models\Role;
use App\Models\User;
use App\Models\user_detail;
use App\Notifications\ProfUnassignedNotification;
use Illuminate\Support\Facades\Notification;

class professorsController extends Controller
{
    public function index()
    {

        $departments = Departement::all();

        $professors = User::WhereHas('role', function ($query) {
            $query->where('isprof', true);
        })
        ->simplePaginate(5);
        
        
        return view('admin.professeurs',['professors' => $professors,'Departements'=>$departments]);
   
    }

    public function filter()
    {
        $departments = Departement::all();

        $query = User::WhereHas('role', function ($query) {
            $query->where('isprof', true);
        });

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%$search%")
                    ->orWhere('lastname', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");

            });
        }

        if (request('departement')) {
            $departement = request('departement');
            $query->where('departement', $departement);
        }

        if (request('status')) {
            $status = request('status');
            $query->whereHas('user_details', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $rows = request('rows', 5); // default to 5 if not provided

        $professors = $query->with('user_details')->simplePaginate($rows);

        return view('admin.professeurs', ['professors' => $professors, 'Departements' => $departments]);

    }

    public function showadd()
    {

        $departements = Departement::all();

        return view('admin.add_professeur', ['Departements' => $departements]);

    }

    public function add()
    {
        request()->validate([
            'firstname'=>'required|string|max:255|min:2',
            'lastname'=>'required|string|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password'=>'required',
            'status'=>'required',
            'departement' => 'nullable|string|max:255',
            'min_hours' => 'required|numeric',
            'max_hours' => 'required|numeric',
            'date' => 'nullable|date',
            'adresse' => 'nullable|string|max:255',
            'tele' => 'nullable|numeric',
            'cin' => 'nullable|max:20',
            'sexe' => 'nullable|in:male,female',

        ]);

 

        
        $userdata=[
            'firstname'=>request('firstname'),
            'lastname'=>request('lastname'),
            'email'=>request('email'),
            'password'=>password_hash(request('password'), PASSWORD_BCRYPT),
            'departement'=>request('departement'),
            
    ];

        $newprof = User::create($userdata);
        Role::create(['user_id' => $newprof->id, 'isprof' => 1]);

        $userdetails = [
            'user_id' => $newprof->id,
            'status' => request('status'),
            'date_of_birth' => request('date'),
            'adresse' => request('adresse'),
            'number' => request('tele'),
            'cin' => request('cin'),
            'sexe' => request('sexe'),
            'hours' => request('hours'),

        ];

   
    
    $userdetails=[
        'user_id'=>$newprof->id,
        'status'=>request('status'),
        'date_of_birth' => request('date'),
        'adresse' => request('adresse'),
        'number' => request('tele'),
        'cin' => request('cin'),
        'sexe' => request('sexe'),
        'min_hours'=>request('min_hours'),
        'max_hours'=>request('max_hours'),
        
    ];

    
        if (request()->hasFile('profile_img')) {
            $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
            $userdetails['profile_img'] = $profileImgPath;

        }

        user_detail::create($userdetails);


        $actionDetails=[
            'admin_id'=>auth()->user()->id,
            'action_type' =>'create',
            'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a ajeuté le professeur " . $newprof->firstname ." " . $newprof->lastname,
            'target_table' =>'users',
            'target_id' => $newprof->id,
        ];
        
        
        admin_action::create($actionDetails);
    

return redirect('professeurs'); 
    }

    public function showmodify($id)
    {

        $professeur = User::find($id);

        return view('admin.modify_professeurs', ['professeur' => $professeur]);

    }

    public function modify($id){
        
 

        request()->validate([
            'firstname' => 'required|string|max:255|min:2',
            'lastname' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255',
            'status' => 'required',

        ]);

        $prof = User::where('id', $id)->first();
        $prof->firstname = request('firstname');
        $prof->lastname = request('lastname');

        if (request('password') != null) {
            $prof->password = password_hash(request('password'), PASSWORD_BCRYPT);

        }

        if ($prof->email != request('email')) {

            $emailexit = User::where('email', request('email'))->first();

            if (! $emailexit) {

                $prof->email = request('email');
            } else {

                return redirect()->back()->withErrors('email exist');
            }

        }
        if ($prof->user_details) {

            $prof_details = user_detail::where('user_id', $id)->first();

            $prof_details->status = request('status');

            if (request()->hasFile('profile_img')) {
                $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');

                $prof_details->profile_img = $profileImgPath;
            }
            $prof_details->save();

        } else {

            $userdetails = [
                'user_id' => $prof->id,
                'status' => request('status'),

            ];

            if (request()->hasFile('profile_img')) {
                $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
                $userdetails['profile_img'] = $profileImgPath;

            }

            user_detail::create($userdetails);

        }

        $prof->save();





    
$prof->save();

$actionDetails=[
    'admin_id'=>auth()->user()->id,
    'action_type' =>'upadate',
    'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a modifié les informations du professeur " . $prof->firstname ." " . $prof->lastname ,
    'target_table' =>'users',
    'target_id' => $prof->id,
];


admin_action::create($actionDetails);

    
        return redirect('professeurs');

    }

    public function delete($id) {
        $departement=Departement::where('user_id',$id)->first();
        $filiere=filiere::where('coordonnateur_id',$id)->first();
    
        $deletedProf=User::find($id);
        if($departement){
    
            $admins = User::WhereHas('role', function ($query) {
            $query->where('isadmin', true);
              })->get();
    
            Notification::send($admins, new ProfUnassignedNotification($departement->name,1,0));
       
        }
        elseif ($filiere) {

          $admins = User::WhereHas('role', function ($query) {
            $query->where('isadmin', true);
              })->get(); 
                 
            Notification::send($admins, new ProfUnassignedNotification($filiere->name,0,1));
          
        }

        $actionDetails=[
            'admin_id'=>auth()->user()->id,
            'action_type' =>'delete',
            'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a supprimé le compte du professeur " . $deletedProf->firstname . " " . $deletedProf->lastname ,
            'target_table' =>'users',
            'target_id' => $deletedProf->id,
        ];


        
        
        admin_action::create($actionDetails);
    $deletedProf->delete();
      
    
        return redirect()->back();
        
    }

    //     User::find($id)->delete();
    //     if ($departement) {

    //         $admins = User::where('role_column', 'admin')->get();

    //         Notification::send($admins, new ProfUnassignedNotification($departement->name, 1, 0));

    //     } elseif ($filiere) {
    //         $admins = User::where('role_column', 'admin')->get();

    //         Notification::send($admins, new ProfUnassignedNotification($filiere->name, 0, 1));

    //     }

    //     return redirect()->back();

    // }
}

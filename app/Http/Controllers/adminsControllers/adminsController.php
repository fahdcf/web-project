<?php

namespace App\Http\Controllers\adminsControllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\user_detail;
use App\Models\admin_action;


use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Models\Departement;
use App\Models\filiere;
use App\Models\Role;

use Illuminate\Support\Facades\Notification;
use App\Notifications\ProfUnassignedNotification;

class adminsController extends Controller
{
    public function index(){
        $departments = Departement::all();
        $admins = User::WhereHas('role', function ($query) {
            $query->where('isadmin', true);
        })->paginate(10); 
        return view('admin.admins', ['admins' => $admins, 'Departements' => $departments]);
    
    }

    public function showadd(){
        $departments = Departement::all();
        $professeurs = User::WhereHas('role', function ($query) {
            $query->where('isprof', true);
        })->get();
    
    
        return view('admin.add_admin',['professeurs'=>$professeurs,'Departements' => $departments]);
    
    }

    public function add(){
        
        request()->validate([
            'firstname'=>'required|string|max:255|min:2',
            'lastname'=>'required|string|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password'=>'required',
            'status'=>'required',
            'min_hours' => 'required|numeric',
            'max_hours' => 'required|numeric',
            'departement' => 'nullable|string|max:255',
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
            'departement' =>request('departement'),


    ];

    $newadmin=User::create($userdata);
    Role::create(['user_id' => $newadmin->id,'isprof'=>1, 'isadmin'=>1]);


    $userdetails=[
        'user_id'=>$newadmin->id,
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
            $userdetails['profile_img']=$profileImgPath;

        }


        user_detail::create($userdetails);



        $actionDetails=[
            'admin_id'=>auth()->user()->id,
            'action_type' =>'create',
            'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a ajeuté l'admin " . $newadmin->firstname ." " . $newadmin->lastname,
            'target_table' =>'users',
            'target_id' => $newadmin->id,
        ];
        
        
        admin_action::create($actionDetails);
    
return redirect('admins');

    }

    public function choose(){
        request()->validate([
            'professeur_id' =>'required'
        ]);
        
        $prof=User::findOrFail(request('professeur_id'));
        
        
        if($prof->role){
            $prof->role->isadmin=1;
            $prof->save();
        }
    
        else{
            $prof->save();
            Role::create(['user_id'=>$prof->id,'isadmin'=>1,'isprof'=>1]);
        }
    
    
        $actionDetails=[
            'admin_id'=>auth()->user()->id,
            'action_type' =>'create',
            'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a assigné le professeur " . $prof->firstname ." " . $prof->lastname ." comme Admin",
            'target_table' =>'users',
            'target_id' => $prof->id,
        ];
        
        
        admin_action::create($actionDetails);
    

        return redirect('admins');     
    }
    public function showmodify($id){
        
$admin=User::find($id);



return view('admin.modify_admins',['admin'=>$admin]);

    }

    public function modify($id){
        

request()->validate([
    'firstname'=>'required|string|max:255|min:2',
    'lastname'=>'required|string|max:255|min:2',
    'email' => 'required|email|max:255|unique:users,email',
    'status'=>'required',


]);


$admin = User::where('id', $id)->first();
$admin->firstname=request('firstname');
$admin->lastname=request('lastname');



if(request('password')!=null){
    $admin->password=password_hash(request('password'), PASSWORD_BCRYPT);

}



if($admin->email!=request('email')){

$emailexit = User::where('email', request('email'))->first();

if(!$emailexit){
    
    $admin->email=request('email');
}
else{

    return  redirect()->back()->withErrors('email exist');
}


}
if($admin->user_details){

$admin_details=user_detail::where('user_id', $id)->first();

$admin_details->status=request('status');

if (request()->hasFile('profile_img')) {
    $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
    
    $admin_details->profile_img=$profileImgPath;
}
$admin_details->save();


}

else{

$userdetails=[
    'user_id'=>$admin->id,
    'status'=>request('status'),

];

if (request()->hasFile('profile_img')) {
    $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
    $userdetails['profile_img']=$profileImgPath;

}



user_detail::create($userdetails);




}



$admin->save();

$actionDetails=[
    'admin_id'=>auth()->user()->id,
    'action_type' =>'update',
    'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a modifié les informations de l'admin " . $admin->firstname  . " " . $admin->lastname,
    'target_table' =>'users',
    'target_id' => $admin->id,
];


admin_action::create($actionDetails);


    return redirect('admins');
    }

    public function filter() {
        $query = User::WhereHas('role', function ($query) {
            $query->where('isadmin', true);
        });



        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%$search%")
                  ->orWhere('lastname', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
                  ;
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
      
        $admins = $query->with('user_details')->simplePaginate($rows);
        $departments=Departement::all();
    
    
        return view('admin.admins', ['admins' => $admins,'Departements'=>$departments]);
        
    }

    public function delete($id){
        $deletedAdmin=User::find($id);

        $actionDetails=[
            'admin_id'=>auth()->user()->id,
            'action_type' =>'delete',
            'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a supprimé le compte de l'admin " . $deletedAdmin->firstname  ." " . $deletedAdmin->lastname,
            'target_table' =>'users',
            'target_id' => $deletedAdmin->id,
        ];
        
        
        admin_action::create($actionDetails);

       $deletedAdmin->delete();
        return redirect()->back();
    }
}

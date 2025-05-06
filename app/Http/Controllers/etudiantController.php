<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\User;
use App\Models\user_detail;

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
class etudiantController extends Controller
{
    public function index(){
        $etudiants = User::where('role_column', 'student')
        ->orderBy('created_at', 'desc')
        ->simplePaginate(7);
    
        $departments=Departement::all();
    
    
        return view('admin.etudiants',['etudiants' => $etudiants,'Departements'=>$departments]);
     
    }

    public function filter(){
        $query = User::where('role_column', 'student');

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
      
        $etudiants = $query->with('user_details')->simplePaginate($rows);
        $departments=Departement::all();
    
    
        return view('admin.etudiants', ['etudiants' => $etudiants,'Departements'=>$departments]);
    
    }

    public function showadd(){
        $departments=Departement::all();


        return view('admin.add_etudiant',['Departements'=>$departments]);
        
    
    }

public function add(){
    
    request()->validate([
        'firstname'=>'required|string|max:255|min:2',
        'lastname'=>'required|string|max:255|min:2',
        'email'=>'required|email',
        'password'=>'required',
        'status'=>'required',
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
        'role_column'=>'student',
        'departement'=>request('departement'),

];

$newetudiant=User::create($userdata);
Role::create(['user_id' => $newetudiant->id,'isstudent'=>1]);



$userdetails=[
    'user_id'=>$newetudiant->id,
    'status'=>request('status'),
    'date_of_birth' => request('date'),
    'adresse' => request('adresse'),
    'number' => request('tele'),
    'cin' => request('cin'),
    'sexe' => request('sexe'),

];

    if (request()->hasFile('profile_img')) {
        $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
        $userdetails['profile_img']=$profileImgPath;

    }


    user_detail::create($userdetails);




return redirect('etudiants');   
}

public function showmodify($id){
    
$etudiant=User::find($id);



return view('admin.modify_etudiants',['etudiant'=>$etudiant]);

}
public function modify($id){
    


request()->validate([
    'firstname'=>'required|string|max:255|min:2',
    'lastname'=>'required|string|max:255|min:2',
    'email' => 'required|email|max:255',
    'status'=>'required',


]);


$etudiant = User::where('id', $id)->first();
$etudiant->firstname=request('firstname');
$etudiant->lastname=request('lastname');



if(request('password')!=null){
    $etudiant->password=password_hash(request('password'), PASSWORD_BCRYPT);

}



if($etudiant->email!=request('email')){

$emailexit = User::where('email', request('email'))->first();

if(!$emailexit){
    
    $etudiant->email=request('email');
}
else{

    return  redirect()->back()->withErrors('email exist');
}


}
if($etudiant->user_details){

$etudiant_details=user_detail::where('user_id', $id)->first();

$etudiant_details->status=request('status');

if (request()->hasFile('profile_img')) {
    $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
    
    $etudiant_details->profile_img=$profileImgPath;
}
$etudiant_details->save();


}

else{

$userdetails=[
    'user_id'=>$etudiant->id,
    'status'=>request('status'),

];

if (request()->hasFile('profile_img')) {
    $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
    $userdetails['profile_img']=$profileImgPath;

}



user_detail::create($userdetails);


}



$etudiant->save();

    return redirect('etudiants');
}

public function delete($id){
    User::find($id)->delete();
return redirect()->back();
}
}


<?php

namespace App\Http\Controllers;



use App\Models\student;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\user_detail;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Models\Departement;
use App\Models\admin_action;

use App\Models\filiere;
use App\Models\Role;

use Illuminate\Support\Facades\Notification;
use App\Notifications\ProfUnassignedNotification;
class etudiantController extends Controller
{
    public function index(){
        $etudiants = student::orderBy('created_at', 'desc')
        ->simplePaginate(7);
    
        $filieres=filiere::all();
    
    
        return view('admin.etudiants',['etudiants' => $etudiants,'filieres'=>$filieres]);
     
    }

    public function filter(){
    $query = Student::query();

           if (request('search')) {
        $search = request('search');
        $query->where(function ($q) use ($search) {
            $q->where('firstname', 'like', "%$search%")
              ->orWhere('lastname', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        });
    }
    
        // Filter by filiere
    if (request('filiere')) {
        $filiereName = request('filiere'); // corrected typo
        $filiere = Filiere::where('name', $filiereName)->first();
        if ($filiere) {
            $query->where('filiere_id', $filiere->id);
        }
    }

          // Filter by status
    if (request('status')) {
        $status = request('status');
        $query->where('status', $status);
    }

    
    
 // Number of rows per page
    $rows = request('rows', 5); // default to 5
    
    
    $etudiants = $query->simplePaginate($rows);

        $filieres=filiere::all();
    
    
        return view('admin.etudiants', ['etudiants' => $etudiants,'filieres'=>$filieres]);
    
    }

    public function showadd(){
        $filieres=filiere::all();


        return view('admin.add_etudiant',['filieres'=>$filieres]);
        
    
    }

public function add(){
    
    request()->validate([
        'firstname'=>'required|string|max:255|min:2',
        'lastname'=>'required|string|max:255|min:2',
        'email' => 'required|email|max:255|unique:users,email',
        'status'=>'required',
        'filiere' => 'nullable|string|max:255',
        'date' => 'nullable|date',
        'adresse' => 'nullable|string|max:255',
        'tele' => 'nullable|numeric',
        'cin' => 'nullable|max:20',
        'sexe' => 'nullable|in:male,female',



    ]);
            $filiere = Filiere::where('name', request('filiere'))->first();

    
    $studentdata=[
        'firstname'=>request('firstname'),
        'lastname'=>request('lastname'),
        'email'=>request('email'),
        'filiere_id'=>$filiere->id,
        'status'=>request('status'),
        'date_of_birth' => request('date'),
        'adresse' => request('adresse'),
        'number' => request('tele'),
        'cin' => request('cin'),
        'sexe' => request('sexe'),

];

$newetudiant=student::create($studentdata);



    if (request()->hasFile('profile_img')) {
        $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
        $studentdata['profile_img']=$profileImgPath;

    }



    $actionDetails=[
        'admin_id'=>auth()->user()->id,
        'action_type' =>'create',
        'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a ajeuté l'etudiant " . $newetudiant->firstname . " " . $newetudiant->lastname,
        'target_table' =>'users',
        'target_id' => $newetudiant->id,
    ];
    
    
    admin_action::create($actionDetails);



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
    'email' => 'required|email|max:255|unique:users,email',
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

$actionDetails=[
    'admin_id'=>auth()->user()->id,
    'action_type' =>'update',
    'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a modifié les informations de l'etudiant " . $etudiant->firstname . " " . $etudiant->lastname ,
    'target_table' =>'users',
    'target_id' => $etudiant->id,
];


admin_action::create($actionDetails);


    return redirect('etudiants');
}

public function delete($id){
    $etudiant=User::find($id);

    $actionDetails=[
        'admin_id'=>auth()->user()->id,
        'action_type' =>'delete',
        'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a supprimé l'etudiant " . $etudiant->firstname . " " . $etudiant->lastname ,
        'target_table' =>'users',
        'target_id' => $etudiant->id,
    ];
    
    
    admin_action::create($actionDetails);


return redirect()->back();
}

public function profile($id) {
            $user = student::findOrFail($id);
            $filiere_id=$user->filiere_id;
            $filiere=filiere::where('id',$filiere_id)->get()->first();
            $filiere_name=$filiere->name;

    return view('etudiant-profile',['user'=>$user, 'filiere_name'=> $filiere_name]);
    
}
}



<?php
use App\Models\Departement;
use App\Models\filiere;
use App\Models\Role;
use App\Models\User;
use App\Models\task;
use App\Models\pending_user;
use App\Models\user_detail;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\signupController;
use App\Http\Controllers\loginController;
use App\Mail\resetPasswordEmail;
use App\Mail\newuserEmail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use App\Http\Controllers\newuserController;

use App\Http\Controllers\pendinguserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;
use App\Http\Controllers\adminProfileController;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ProfUnassignedNotification;

Route::get('/', function () {
    if(Auth::check()) {
        if(Auth()->user()->role_column == 'admin') {


            $studentCount=User::where('role_column','student')->count();
            $professorCount=User::where('role_column','professor')->count();

            $tasks=task::where('user_id',auth()->user()->id)->get();
            return view('admin.admin_dashboard',['tasks'=>$tasks,'studentCount'=>$studentCount,'professorCount'=>$professorCount]);
        }

        else{
            return view('dashboard');
        }
        
    }
    else{
        return redirect('login');
    }
    
});






Route::get("/pending_users", function () {
    $pendingusers = pending_user::all();
    return view("admin.pending_users", ['pending_users' => $pendingusers]);
    
})->name('pending_users');  

Route::patch("/pending_users/{id}", function ($id) {
    $pendinguser = pending_user::findOrFail($id);
    
    $newuser = [
        'firstname' => $pendinguser->firstname,
        'lastname' => $pendinguser->lastname,
        'email' => $pendinguser->email,
        'password' => $pendinguser->pwd, 
    ];
    
    $user = User::create($newuser);
    
    $role_column = request('role_column'); 
    
    
    $user->role_column = $role_column;  
    $user->save();
    
    $pendinguser->delete();
    
    return redirect()->route('pending_users')->with('success', 'User approved successfully!');});
    
    
    Route::delete("/pending_users/{id}", function ($id) {
        
        $pendinguser = pending_user::findOrFail($id); 
        $pendinguser->delete();
        
        return redirect::back();
        ;
        
    });
    
    
    
    
    Route::get('/signup',[signupController::class,'index']);
    Route::get('/login',[loginController::class,'index']);

    
Route::delete('/login', function () {
    auth()->logout();
    return view('login');
});


Route::post('/signup', [signupController::class,'store']);



Route::post('/login', [loginController::class,'login']);


Route::get('/pending_user', [PendingUserController::class, 'show'])->name('pendinguser');




Route::get("/reset_password", function () {
    return view("password_reset");
})->name('reset');


Route::post("/reset_password", function () {
    
    $data = request()->validate([
        'reset_email' => ['required', 'email'],
    ]);

    $user = User::where('email', $data['reset_email'])->first();

    if (!$user) {
        return redirect()->back()->withErrors([
            'reset_email' => 'Account not found'
        ])->withInput();  
      }

    $generatedcode=rand(10000, 99999);
    

    session(['code' => $generatedcode,'reset_email'=>request('reset_email')]);
    
    Mail::to(['mohssineechlaihi85@gmail.com', 'joihfah@gmail.com'])->queue(new resetPasswordEmail($generatedcode));


    
    return redirect('/reset_password?validation_code');
});




Route::patch("/reset_password", function () {
    

    request()->validate([
        'entered_code'=> ['required'],

    ]);

   

    if(session('code') == request('entered_code')) {
       

        return redirect('/reset_password?new_password');
   
    }
    else {
            return redirect()->back()->withErrors([
                'entered_code' => 'Code non valid'
            ])->withInput();  
          

    }

 
 //   return view("password_reset");
});


Route::delete("/reset_password", function () {
    
    request()->validate([
        'password'=> ['required' ,'confirmed'],

    ]);

   
    $user = User::where('email', session('reset_email'))->first();

    if ($user) {
        $user->password = Hash::make(request('password'));
        $user->save();
    
        session()->forget('reset_email');
    
        return redirect('login')->with('success', 'Mot de passe mis à jour avec succès !');
    } else {
        return dd('user not found');
    }

 
 //   return view("password_reset");
});










Route::get('departements',function(){
    $departments=Departement::all();

    $professors = User::where('role_column', 'professor')
    ->orWhereHas('role', function ($query) {
        $query->where('isprof', true);
    })->get();

return view('admin.departments',['departements'=>$departments, 'professors'=>$professors]);
})->name('departements.list');


Route::get('departements/add', function(){


    $professors = User::where('role_column', 'professor')->get();

    return view('admin.add_department',['professors'=>$professors]);
});

Route::post('departements/add', function(){

request()->validate([
    'name'=> 'required|max:255|min:2',
    'user_id'=>'required'
]);
$newDepartement=['name'=>request('name'), 'user_id'=>request(('user_id'))];

Departement::create($newDepartement);
return redirect('/departements');
});


Route::patch('departements/{id}',function($id){
    request()->validate([
        'name'=>'required',
    ]);

    if(auth()->user()->role_column=="admin"){
    
         $dep=Departement::find($id);
         $dep->name=request('name');
         if(request('user_id')==null){

             $dep->save();

         }
         else{
            $dep->user_id=request('user_id');
             $dep->save();
         }


    }

    return redirect()->back();

});


Route::delete('departements/{id}',function($id){
    
    Departement::find($id)->delete();

return redirect()->back();

});

Route::post('/addtask',function(){
request()->validate([

    'task'=>'required',
]);

$newtask=['description'=>request('task'),'user_id'=>auth()->user()->id];
task::create($newtask);
return redirect()->back();

});


Route::get('filieres',function(){

    $departements=Departement::all();
    $filieres= filiere::all();

    $professors = User::where('role_column', 'professor')
    ->orWhereHas('role', function ($query) {
        $query->where('isprof', true);
    })->get();

    return view('admin.filieres',['filieres'=>$filieres,'professors'=>$professors, 'departements'=>$departements]);
})->name('filieres.list');

Route::get('filieres/add',function(){
    $professors = User::where('role_column', 'professor')->get();
    $departements=Departement::all();

    return view('admin.add_filiere',['professors'=>$professors,'Departements'=>$departements]);
});

Route::post('filieres/add', function(){

    request()->validate([
        'name'=> 'required|max:255|min:2',
        'user_id'=>'required',
        'departement_id'=>'required'
    ]);

    $newFiliere=['name'=>request('name'), 'department_id'=>request('departement_id'),'coordonnateur_id' =>request(('user_id'))];
    Filiere::create($newFiliere);
    return redirect('/filieres');
    });


    Route::patch('filieres/{id}',function($id){
        request()->validate([
            'name'=>'required',
        ]);
    
        if(auth()->user()->role_column=="admin"){
        
             $fil=filiere::find($id);
             $fil->name=request('name');
             if(request('departement_id')==null){
    
                if(request('user_id')==null){

                    $fil->save();
                }
                else{
                    $fil->coordonnateur_id=request('user_id');
                    $fil->save();

                }
    
             }
            
             else{


              if(request('user_id')==null){

                $fil->department_id=request('departement_id');

                    $fil->save();
                }
                else{
                    $fil->department_id=request('departement_id');
                    $fil->coordonnateur_id=request('user_id');
                    $fil->save();

                }
             }
    
    
        }
    
        return redirect()->back();
    
    });

    
Route::delete('filieres/{id}',function($id){
    
    filiere::find($id)->delete();
return redirect()->back();

});


    Route::get('professeurs',function(){

        $departments=Departement::all();

        $professors = User::where('role_column', 'professor')
        ->orWhereHas('role', function ($query) {
            $query->where('isprof', true);
        })
        ->simplePaginate(5);
        
        
        return view('admin.professeurs',['professors' => $professors,'Departements'=>$departments]);
        
    });

 
    
    Route::patch('professeurs', function () {
        $departments=Departement::all();

        $query = User::where('role_column', 'professor');

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
      
        $professors = $query->with('user_details')->simplePaginate($rows);
    
        return view('admin.professeurs', ['professors' => $professors,'Departements'=>$departments]);
    });
    

    Route::get('professeurs/add',function(){

        $departements=Departement::all();

        return view('admin.add_professeur',['Departements'=>$departements]);
        
    });

    Route::Post('professeurs/add',function(){

                request()->validate([
                    'firstname'=>'required|string|max:255|min:2',
                    'lastname'=>'required|string|max:255|min:2',
                    'email'=>'required|email',
                    'password'=>'required',
                    'status'=>'required',
                    'departement' => 'nullable|string|max:255',
                    'hours' => 'required|numeric',
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
                    'role_column'=>'professor',
                    'departement'=>request('departement'),
                    
            ];


            $newprof=User::create($userdata);
            Role::create(['user_id' => $newprof->id,'isprof'=>1]);

    
            
            
            $userdetails=[
                'user_id'=>$newprof->id,
                'status'=>request('status'),
                'date_of_birth' => request('date'),
                'adresse' => request('adresse'),
                'number' => request('tele'),
                'cin' => request('cin'),
                'sexe' => request('sexe'),
                'hours'=>request('hours'),
                
            ];

            
                if (request()->hasFile('profile_img')) {
                    $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
                    $userdetails['profile_img']=$profileImgPath;

                }


                user_detail::create($userdetails);




    return redirect('professeurs');        
    });


Route::get('/professeurs/modifier/{id}',function($id){

$professeur=User::find($id);



    return view('admin.modify_professeurs',['professeur'=>$professeur]);

});



Route::post('/professeurs/modifier/{id}',function($id){


    
    request()->validate([
        'firstname'=>'required|string|max:255|min:2',
        'lastname'=>'required|string|max:255|min:2',
        'email' => 'required|email|max:255',
        'status'=>'required',


    ]);

    
    $prof = User::where('id', $id)->first();
    $prof->firstname=request('firstname');
    $prof->lastname=request('lastname');
    
    
    
    if(request('password')!=null){
        $prof->password=password_hash(request('password'), PASSWORD_BCRYPT);

    }

   

if($prof->email!=request('email')){

    $emailexit = User::where('email', request('email'))->first();

    if(!$emailexit){
        
        $prof->email=request('email');
    }
    else{

        return  redirect()->back()->withErrors('email exist');
    }


}
if($prof->user_details){

    $prof_details=user_detail::where('user_id', $id)->first();

$prof_details->status=request('status');

    if (request()->hasFile('profile_img')) {
        $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
        
        $prof_details->profile_img=$profileImgPath;
    }
    $prof_details->save();


}

else{
    
    $userdetails=[
        'user_id'=>$prof->id,
        'status'=>request('status'),

    ];

    if (request()->hasFile('profile_img')) {
        $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
        $userdetails['profile_img']=$profileImgPath;

    }



    user_detail::create($userdetails);


}


    
$prof->save();
    
        return redirect('professeurs');
    
    });


Route::delete('professors/{id}',function($id){
    $departement=Departement::where('user_id',$id)->first();
    $filiere=filiere::where('coordonnateur_id',$id)->first();

    User::find($id)->delete();
    if($departement){

        $admins = User::where('role_column', 'admin')->get();

        Notification::send($admins, new ProfUnassignedNotification($departement->name,1,0));
   
    }
    elseif ($filiere) {
        $admins = User::where('role_column', 'admin')->get();

        Notification::send($admins, new ProfUnassignedNotification($filiere->name,0,1));
      
    }
  

    return redirect()->back();
});





Route::get('admins', function () {
    $departments = Departement::all();
    $admins = User::where('role_column', 'admin')->paginate(10); 
    return view('admin.admins', ['admins' => $admins, 'Departements' => $departments]);
});

Route::get('admins/add',function(){
    $departments = Departement::all();
    $professeurs = User::where('role_column', 'professor')->get();


    return view('admin.add_admin',['professeurs'=>$professeurs,'Departements' => $departments]);
    
});

Route::Post('admins/add',function(){

            request()->validate([
                'firstname'=>'required|string|max:255|min:2',
                'lastname'=>'required|string|max:255|min:2',
                'email'=>'required|email',
                'password'=>'required',
                'status'=>'required',
                'hours' => 'required|numeric',
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
                'role_column'=>'admin',
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
            'hours'=>request('hours'),

        ];

            if (request()->hasFile('profile_img')) {
                $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
                $userdetails['profile_img']=$profileImgPath;

            }


            user_detail::create($userdetails);




return redirect('admins');        
});

Route::patch('admins/add',function(){
    request()->validate([
        'professeur_id' =>'required'
    ]);
    
    $prof=User::findOrFail(request('professeur_id'));
    $prof->role_column='admin';
    
    
    if($prof->role){
        $prof->role->isadmin=1;
        $prof->save();
    }

    else{
        $prof->save();
        Role::create(['user_id'=>$prof->id,'isadmin'=>1,'isprof'=>1]);
    }


    return redirect('admins');        

});


Route::get('/admins/modifier/{id}',function($id){

$admin=User::find($id);



return view('admin.modify_admins',['admin'=>$admin]);

});


Route::patch('admins', function () {
    $query = User::where('role_column', 'admin');

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
});


Route::post('/admins/modifier/{id}',function($id){



request()->validate([
    'firstname'=>'required|string|max:255|min:2',
    'lastname'=>'required|string|max:255|min:2',
    'email' => 'required|email|max:255',
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

    return redirect('admins');

});


Route::delete('admins/{id}',function($id){
User::find($id)->delete();
return redirect()->back();
});




Route::get('etudiants',function(){

    $etudiants = User::where('role_column', 'student')
    ->orderBy('created_at', 'desc')
    ->simplePaginate(7);

    $departments=Departement::all();


    return view('admin.etudiants',['etudiants' => $etudiants,'Departements'=>$departments]);
    
});

Route::patch('etudiants', function () {
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
});


Route::get('etudiants/add',function(){
    $departments=Departement::all();


    return view('admin.add_etudiant',['Departements'=>$departments]);
    
});

Route::Post('etudiants/add',function(){

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
});


Route::get('/etudiants/modifier/{id}',function($id){

$etudiant=User::find($id);



return view('admin.modify_etudiants',['etudiant'=>$etudiant]);

});


Route::post('/etudiants/modifier/{id}',function($id){



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

});


Route::delete('etudiants/{id}',function($id){
User::find($id)->delete();
return redirect()->back();
});


Route::get('profile',function(){

    if(optional(auth()->user()->role)->isadmin){

        return view('admin.admin_profile');
    }
    else{
        return view('user_profile');

    }


   
});

Route::get('profile/{id}', function($id){
    
    $user=User::findOrFail($id);
    $departments=Departement::all();

    if((optional(auth()->user()->role)->isadmin)){

        return view('admin.admin_user_profile',['user'=>$user,'Departements'=>$departments]);
    }
    else{
        return view('other_profile',['user'=>$user]);

    }


});




Route::post('profile/edit/{id}', [adminProfileController::class, 'edit'])->name('profile.edit');

Route::post('profile/modifier-image/{id}',function($id){

    
        $user=user::find($id);
        $userdetails=$user->user_details;
        $userdetails->profile_img;

    if (request()->hasFile('profile_img')) {
        $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
        
        $userdetails->profile_img=$profileImgPath;
    }

    $userdetails->save();
    
    return redirect()->back();
});

Route::delete('profile/modifier-image/{id}',function($id){

    
    $user=user::find($id);
    $userdetails=$user->user_details;
    $userdetails->profile_img;


    $userdetails->profile_img=null;


$userdetails->save();

return redirect()->back();
});

Route::get('test',function(){
    $departements=Departement::all();
    $filieres= filiere::all();
    $professors = User::where('role_column', 'professor')->get();

    return view('admin.testpage',['filieres'=>$filieres,'professors'=>$professors, 'departements'=>$departements]);

});


Route::get('/notifications/read/{id}', function ($id) {
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();

    return redirect($notification->data['url']);
})->name('notifications.read');
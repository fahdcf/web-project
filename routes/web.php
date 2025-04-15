<?php
use App\Models\User;
use App\Models\pending_user;
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


Route::get('/', function () {
    if(Auth::check()) {
        if(Auth()->user()->role == 'admin') {
            
            return view('admin.admin_dashboard');
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
    
    $role = request('role'); 
    
    
    $user->role = $role;  
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


Route::get('test',function(){

    return view('password_reset');
});
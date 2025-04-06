<?php
use App\Models\User;
use App\Models\pending_user;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\registrationController;

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



Route::get("/test", function () {
    return view("dashboard");
});


Route::get("/pending_users", function () {
    $pendingusers = pending_user::all();
    return view("approuve_pendings", ['pending_users' => $pendingusers]);

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


Route::get('/', function () {
    if(Auth::check()) {
    return view('dashboard');}
    else{
        return redirect('registration');
    }
});

Route::get('/registration',[registrationController::class,'index']);


Route::delete('/registration', function () {
    auth()->logout();
    return view('signup');
});


Route::post('/signup', [registrationController::class,'store']);




Route::post('/login', [registrationController::class,'login']);


/*
Route::get('/test', function () {
    $newuser = [
        'firstname' => 'Test User',
        'email' => 'testuser@example.com',
    ];
    
    Mail::to("joihfah@gmail.com")->queue(new NewuserEmail($newuser));

    return "Test email sent!";
});*/

Route::get('/pending_user', [PendingUserController::class, 'show'])->name('pendinguser');



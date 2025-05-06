<?php
use App\Http\Controllers\adminsController;
use App\Http\Controllers\departementController;
use App\Http\Controllers\etudiantController;
use App\Http\Controllers\filiereController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\professorsController;
use App\Http\Controllers\profileController;

use App\Http\Controllers\resetPasswordController;
use App\Http\Controllers\tasksController;
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

Route::get('/', [homeController::class,'index']);

Route::get('/signup',[signupController::class,'index']);
Route::post('/signup', [signupController::class,'store']);

Route::get('/login',[loginController::class,'index']);
Route::post('/login', [loginController::class,'login']);

Route::delete('/login', [loginController::class,'exit']);

Route::get('/pending_user', [PendingUserController::class, 'show'])->name('pendinguser');

Route::get("/reset_password",[resetPasswordController::class,'idnex'])->name('reset');


Route::post("/reset_password", [resetPasswordController::class,'reset']);
    
         
Route::patch("/reset_password", [resetPasswordController::class,'validate']);


Route::delete("/reset_password", [resetPasswordController::class,'newpassword']);

Route::get('departements', [departementController::class,'index'])->name('departements.list');


Route::get('departements/add', [departementController::class,'showadd']);

Route::post('departements/add', [departementController::class,'add']);


Route::patch('departements/{id}',[departementController::class,'modify']);


Route::delete('departements/{id}',[departementController::class,'delete']);

Route::post('/addtask',[tasksController::class,'addtask']);


Route::get('filieres',[filiereController::class,'index'])->name('filieres.list');

Route::get('filieres/add',[filiereController::class,'showadd']);

Route::post('filieres/add',[filiereController::class,'add']);


 Route::patch('filieres/{id}',[filiereController::class,'modify']);

    
Route::delete('filieres/{id}',[filiereController::class,'delete']);


Route::get('professeurs',[professorsController::class,'index']);

Route::patch('professeurs', [professorsController::class,'filter']);
    

Route::get('professeurs/add',[professorsController::class,'showadd']);

Route::Post('professeurs/add',[professorsController::class,'add']);


Route::get('/professeurs/modifier/{id}',[professorsController::class,'showmodify']);



Route::post('/professeurs/modifier/{id}',[professorsController::class,'modify']);


Route::delete('professors/{id}',[professorsController::class,'delete']);





Route::get('admins', [adminsController::class,'index']);

Route::get('admins/add',[adminsController::class,'showadd']);

Route::Post('admins/add',[adminsController::class,'add']);

Route::patch('admins/add',[adminProfileController::class,'choose']);


Route::get('/admins/modifier/{id}',[adminsController::class,'showmodify']);


Route::patch('admins', [adminsController::class,'filter']);


Route::post('/admins/modifier/{id}',[adminsController::class,'modify']);


Route::delete('admins/{id}',[adminsController::class,'delete']);




Route::get('etudiants',[etudiantController::class,'index']);

Route::patch('etudiants', [etudiantController::class,'filter']);


Route::get('etudiants/add',[etudiantController::class,'showadd']);

Route::Post('etudiants/add',[etudiantController::class,'add']);


Route::get('/etudiants/modifier/{id}',[etudiantController::class,'showmodify']);


Route::post('/etudiants/modifier/{id}',[etudiantController::class,'modify']);


Route::delete('etudiants/{id}',[etudiantController::class,'delete']);

Route::post('profile/edit/{id}', [adminProfileController::class, 'edit'])->name('profile.edit');

Route::get('profile',[profileController::class,'index']);


Route::get('profile/{id}', [profileController::class,'otherprofile']);



Route::post('profile/modifier-image/{id}',[profileController::class,'editimage']);

Route::delete('profile/modifier-image/{id}',[profileController::class,'deleteimage']);

Route::get("/pendingusers", [pendinguserController::class,'index'])->name('pending_users');  

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






Route::get('/notifications/read/{id}', function ($id) {
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();

    return redirect($notification->data['url']);
})->name('notifications.read');


Route::get('test',function(){
    $departements=Departement::all();
    $filieres= filiere::all();
    $professors = User::where('role_column', 'professor')->get();

    return view('admin.testpage',['filieres'=>$filieres,'professors'=>$professors, 'departements'=>$departements]);

});


    
    
    

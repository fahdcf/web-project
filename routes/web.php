<?php

use App\Http\Controllers\adminsControllers\adminProfileController;
use App\Http\Controllers\adminsControllers\adminsController;
use App\Http\Controllers\adminsControllers\departementController;
use App\Http\Controllers\adminsControllers\etudiantController;
use App\Http\Controllers\adminsControllers\filiereController;
use App\Http\Controllers\adminsControllers\pendinguserController;
use App\Http\Controllers\adminsControllers\professorsController;

use App\Http\Controllers\adminsControllers\profileController;

use App\Http\Controllers\adminsControllers\resetPasswordController;
use App\Http\Controllers\adminsControllers\signupController;
use App\Http\Controllers\adminsControllers\tasksController;
use App\Http\Controllers\chef_departementControllers\cheffiliereController;
use App\Http\Controllers\chef_departementControllers\ChefProfessorController;
use App\Http\Controllers\chef_departementControllers\chefModulesController;

use App\Http\Controllers\chef_departementControllers\requestsController;
use App\Http\Controllers\Controller;


use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\newuserController;

use App\Mail\newuserEmail;
use App\Mail\resetPasswordEmail;
use App\Mail\WelcomeEmail;
use App\Models\Departement;
use App\Models\filiere;
use App\Models\pending_user;
use App\Models\Role;
use App\Models\task;
use App\Models\User;

use Illuminate\Support\Facades\Route;


//FOR CHEF DEPARTEMENT

use App\Models\user_detail;
use App\Notifications\ProfUnassignedNotification;
use function PHPUnit\Framework\returnArgument;



///////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;


/////////Coordonnateur//////////////////////////////////////////////////////
use App\Http\Controllers\coordonnateur\CoordonnateurController;



Route::prefix('coordonnateur')->group(function () {
    Route::get('/dashboard', [CoordonnateurController::class, 'dashboard'])->name('coordonnateur.dashboard');
});

//////coordonateur: gestion des modules/////////////
use App\Http\Controllers\coordonnateur\ModuleController;

Route::middleware(['auth'])
    ->prefix('coordonnateur/modules')
    ->group(function () {
        Route::get('/', [ModuleController::class, 'index'])->name('coordonnateur.modules.index');

        Route::get('/create', [ModuleController::class, 'create'])->name('coordonnateur.modules.create');
        Route::post('/', [ModuleController::class, 'store'])->name('coordonnateur.modules.store');

        Route::get('/{module}/edit', [ModuleController::class, 'edit'])->name('coordonnateur.modules.edit');
        Route::put('/{module}', [ModuleController::class, 'update'])->name('coordonnateur.modules.update');

        Route::get('/{module}', [ModuleController::class, 'show'])->name('coordonnateur.modules.show');
        Route::delete('/{module}', [ModuleController::class, 'destroy'])->name('coordonnateur.modules.destroy');

        Route::post('/search', [ModuleController::class, 'search'])->name('coordonnateur.modules.search');
        Route::post('/filter', [ModuleController::class, 'filter'])->name('coordonnateur.modules.filter');

        ///////Assignation //////////////////// 
        Route::get('/assign-vacataire', [ModuleController::class, 'create'])->name('coordonnateur.modules.assign-vacataire');

        Route::get('coordonnateur/modules/{module}/assigner', [ModuleController::class, 'showAssignationPage'])
            ->name('coordonnateur.modules.assigner');
        Route::post('coordonnateur/modules/{module}/assigner', [ModuleController::class, 'processAssignation'])
            ->name('coordonnateur.modules.assigner.process');


        Route::prefix('coordonnateur/modules/{module}')->group(function () {
            // Mise à jour des heures
            Route::put('/update-hours', [ModuleController::class, 'updateHours'])
                ->name('coordonnateur.modules.update-hours');

            // Gestion des assignations///////////// 
            Route::post('/assignations', [ModuleController::class, 'addAssignation'])
                ->name('coordonnateur.modules.add-assignation');

            Route::put('/assignations/{vacataire}', [ModuleController::class, 'updateAssignation'])
                ->name('coordonnateur.modules.update-assignation');

            Route::delete('/assignations/{vacataire}', [ModuleController::class, 'removeAssignation'])
                ->name('coordonnateur.modules.remove-assignation');
        });
    });




//////coordonateur: gestion des vacataire  /////////////
use App\Http\Controllers\coordonnateur\vacataireController;

Route::middleware(['auth'])
    ->prefix('coordonnateur/vacataires')
    ->group(function () {
        Route::get('/', [CoordonnateurController::class, 'vacataires'])->name('coordonnateur.vacataires.index');

        Route::post('/filter', [vacataireController::class, 'create'])->name('coordonnateur.vacataires.filter');



        Route::get('/create', [vacataireController::class, 'create'])->name('coordonnateur.vacataires.create');
        Route::post('/', [vacataireController::class, 'store'])->name('coordonnateur.vacataires.store');

        Route::get('/{vacataire}/edit', [vacataireController::class, 'edit'])->name('coordonnateur.vacataires.edit');
        Route::put('/{vacataire}', [vacataireController::class, 'update'])->name('coordonnateur.vacataires.update');

        Route::get('/{vacataire}', [vacataireController::class, 'show'])->name('coordonnateur.vacataires.show');
        Route::delete('/{vacataire}', [vacataireController::class, 'destroy'])->name('coordonnateur.vacataires.destroy');

        //////////////////////////////////////////

        // Route::post('assing', [vacataireController::class, 'assign'])->name('coordonnateur.vacataires.assign');
        // Route::get('assign.form/{vacataire}', [vacataireController::class, 'assing_modules']);



        /////////////////////////////////////////////

        Route::get('/{vacataire}/assign', [VacataireController::class, 'showAssignForm'])
            ->name('assign');
        Route::post('/{vacataire}/assign', [VacataireController::class, 'storeAssign'])
            ->name('store-assign');
    });





// ////// gestion des goupes/////////////////////////////////
use App\Http\Controllers\coordonnateur\GroupeController;

// // Route pour la page générale de gestion des groupes (si vous la conservez)
// Route::middleware(['auth'])
//     ->prefix('coordonnateur')
//     ->group(function () {
//         Route::get('groupes', [CoordonnateurController::class, 'groupes'])->name('coordonnateur.groupes.index');
//     });

// Route::middleware(['auth'])
//     ->prefix('coordonnateur/modules/{module}') // Préfixe avec le paramètre {module} pour les groupes liées à un module
//     ->group(function () {
//         Route::get('groupes', [GroupeController::class, 'manageGroupes'])->name('modules.groupes.index');

//         Route::get('groupes/create', [GroupeController::class, 'createGroupe'])->name('modules.groupes.create');

//         Route::post('groupes', [GroupeController::class, 'storeGroupe'])->name('modules.groupes.store');

//         Route::get('groupes/{groupe}/edit', [GroupeController::class, 'editGroupe'])->name('modules.groupes.edit');

//         Route::put('groupes/{groupe}', [GroupeController::class, 'updateGroupe'])->name('modules.groupes.update');

//         Route::delete('groupes/{groupe}', [GroupeController::class, 'destroyGroupe'])->name('modules.groupes.destroy');
//     });

// Route::middleware(['auth'])->group(function () {
//     // Next semester configuration

//     // Route::post('/config_semester_suivant', [GroupeController::class, 'saveNextSemesterConfig'])
//     //     ->name('save.next-semester-config');
// });


//page de confuguraton des semester suivant 
Route::get('/config_semester_suivant', [GroupeController::class, 'configureNextSemester'])
    ->name('config_semester_suivant');
//saving action tout les moduel du semester
Route::post('/config-semestre-suivant', [GroupeController::class, 'saveNextSemesterConfig'])
    ->name('save_semester_suivant');

//saving acon modufication dune seule module groupes
Route::post('/module_config/update', [GroupeController::class, 'updateModuleConfig'])
    ->name('module_config_update');

    
# Groupes - Coordinateur
Route::prefix('coordonnateur/groupes')->middleware(['auth'])->group(function () {
    Route::get('/', [GroupeController::class, 'index'])->name('coordonnateur.groupes.index'); //overview of he current semester

});

Route::get('/mohssine', [CoordonnateurController::class, 'index']);




//////professor//////////////////////////////////////////
use App\Http\Controllers\coordonnateur\ProfessorController;


Route::prefix('professor')->group(function () {
    Route::get('/dashboard', [ProfessorController::class, 'index'])->name('professor.dashboard');
});

////////vacataire ///////////////////////////////////

Route::prefix('vacataire')->group(function () {
    Route::get('/dashboard', [vacataireController::class, 'dashboard'])->name('vacataire.dashboard');

    Route::get('/upload-grades', [vacataireController::class, 'upload-grades'])->name('vacataire.upload-grades');
    Route::post('/upload-grades', [vacataireController::class, 'upload-grades'])->name('vacataire.upload-grades');
});
//////////////////////////////////////////////////////////////////////////////////////////
Route::get('/', [homeController::class, 'index']);

Route::get('/signup', [signupController::class, 'index']);
Route::post('/signup', [signupController::class, 'store']);

Route::get('/login', [loginController::class, 'index']);
Route::post('/login', [loginController::class, 'login']);

Route::delete('/login', [loginController::class, 'exit']);

Route::get('/pending_user', [PendingUserController::class, 'show'])->name('pendinguser');

Route::get("/reset_password", [resetPasswordController::class, 'index'])->name('reset');


Route::post("/reset_password", [resetPasswordController::class, 'reset']);


Route::patch("/reset_password", [resetPasswordController::class, 'validate']);


Route::delete("/reset_password", [resetPasswordController::class, 'newpassword']);

Route::get('departements', [departementController::class, 'index'])->name('departements.list');


Route::get('departements/add', [departementController::class, 'showadd']);

Route::post('departements/add', [departementController::class, 'add']);


Route::patch('departements/{id}', [departementController::class, 'modify']);


Route::delete('departements/{id}', [departementController::class, 'delete']);

Route::post('/addtask', [tasksController::class, 'addtask']);


Route::get('filieres', [filiereController::class, 'index'])->name('filieres.list');

Route::get('filieres/add', [filiereController::class, 'showadd']);

Route::post('filieres/add', [filiereController::class, 'add']);


Route::patch('filieres/{id}', [filiereController::class, 'modify']);


Route::delete('filieres/{id}', [filiereController::class, 'delete']);


Route::get('professeurs', [professorsController::class, 'index']);

Route::patch('professeurs', [professorsController::class, 'filter']);


Route::get('professeurs/add', [professorsController::class, 'showadd']);

Route::Post('professeurs/add', [professorsController::class, 'add']);


Route::get('/professeurs/modifier/{id}', [professorsController::class, 'showmodify']);



Route::post('/professeurs/modifier/{id}', [professorsController::class, 'modify']);


Route::delete('professors/{id}', [professorsController::class, 'delete']);





Route::get('admins', [adminsController::class, 'index']);

Route::get('admins/add', [adminsController::class, 'showadd']);

Route::Post('admins/add', [adminsController::class, 'add']);

Route::patch('admins/add', [adminProfileController::class, 'choose']);


Route::get('/admins/modifier/{id}', [adminsController::class, 'showmodify']);


Route::patch('admins', [adminsController::class, 'filter']);


Route::post('/admins/modifier/{id}', [adminsController::class, 'modify']);


Route::delete('admins/{id}', [adminsController::class, 'delete']);




Route::get('etudiants', [etudiantController::class, 'index']);

Route::patch('etudiants', [etudiantController::class, 'filter']);


Route::get('etudiants/add', [etudiantController::class, 'showadd']);

Route::Post('etudiants/add', [etudiantController::class, 'add']);


Route::get('/etudiants/modifier/{id}', [etudiantController::class, 'showmodify']);


Route::post('/etudiants/modifier/{id}', [etudiantController::class, 'modify']);


Route::delete('etudiants/{id}', [etudiantController::class, 'delete']);

Route::post('profile/edit/{id}', [adminProfileController::class, 'edit'])->name('profile.edit');
Route::post('student-profile/edit/{id}', [adminProfileController::class, 'editEtudiant'])->name('student-profile.edit');

Route::get('profile', [profileController::class, 'index']);


Route::get('profile/{id}', [profileController::class, 'otherprofile']);



Route::post('profile/modifier-image/{id}', [profileController::class, 'editimage']);

Route::delete('profile/modifier-image/{id}', [profileController::class, 'deleteimage']);

Route::get("/pendingusers", [pendinguserController::class, 'index'])->name('pending_users');

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

    return redirect()->route('pending_users')->with('success', 'User approved successfully!');
});


Route::delete("/pending_users/{id}", function ($id) {

    $pendinguser = pending_user::findOrFail($id);
    $pendinguser->delete();

    return redirect::back();;
});






Route::get('/notifications/read/{id}', function ($id) {
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();

    return redirect($notification->data['url']);
})->name('notifications.read');


Route::get('test', function () {
    $departements = Departement::all();
    $filieres = filiere::all();
    $professors = User::where('role_column', 'professor')->get();

    return view('admin.testpage', ['filieres' => $filieres, 'professors' => $professors, 'departements' => $departements]);
});

Route::post('mark-task-asdone/{id}', [tasksController::class, 'markAsDone']);
Route::post('delete-task/{id}', [tasksController::class, 'delete']);
Route::post('mark-task-aspending/{id}', [tasksController::class, 'markAsPending']);
//for others
Route::get('etudiant_profile/{id}', [etudiantController::class, 'profile']);

//for admin
Route::get('etudiant-profile/{id}', [adminProfileController::class, 'studentprofile']);

 Route::get('chef/professeurs',[ChefProfessorController::class,'index']);
  Route::get('chef/filieres',[cheffiliereController::class,'index']);
Route::PATCH('chef/filieres/modifier/{id}',[cheffiliereController::class,'modify']); 
Route::get('chef/modules',[chefModulesController::class,'index']); 
Route::get('chef/modules_vacantes',[chefModulesController::class,'vacantesList']); 
Route::post('chef/modules_vacantes/affecter/{id}',[chefModulesController::class,'affecter']); 

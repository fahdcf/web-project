<?php

use App\Http\Controllers\adminsControllers\adminProfileController;
use App\Http\Controllers\adminsControllers\adminsController;
use App\Http\Controllers\adminsControllers\departementController;
use App\Http\Controllers\adminsControllers\etudiantController;
use App\Http\Controllers\adminsControllers\filiereController;
use App\Http\Controllers\adminsControllers\pendinguserController;
use App\Http\Controllers\adminsControllers\professorsController;
use App\Http\Controllers\adminsControllers\UserLogController;
use App\Http\Controllers\adminsControllers\AdminActionController;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\adminsControllers\profileController;

use App\Http\Controllers\adminsControllers\resetPasswordController;
use App\Http\Controllers\adminsControllers\signupController;
use App\Http\Controllers\adminsControllers\tasksController;

use App\Http\Controllers\chef_departementControllers\ChefActionsController;
use App\Http\Controllers\chef_departementControllers\cheffiliereController;
use App\Http\Controllers\chef_departementControllers\chefModulesController;
use App\Http\Controllers\chef_departementControllers\ChefProfessorController;

use App\Http\Controllers\chef_departementControllers\requestsController;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Coordinator\ApiController;
use App\Http\Controllers\Coordinator\ScheduleController;

use App\Http\Controllers\coordonnateur\CoordonnateurController;
use App\Http\Controllers\coordonnateur\EmploiController;
use App\Http\Controllers\coordonnateur\GroupeController;
use App\Http\Controllers\coordonnateur\ModuleController;
use App\Http\Controllers\coordonnateur\NoteController;
use App\Http\Controllers\coordonnateur\ProfessorController;
use App\Http\Controllers\coordonnateur\ScheduleBuilderController;
use App\Http\Controllers\coordonnateur\ScheduleController as scheduleCoor;
use App\Http\Controllers\coordonnateur\vacataireController;

use App\Http\Controllers\GradeController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;

//FOR CHEF DEPARTEMENT

use App\Http\Controllers\newuserController;
use App\Http\Controllers\Professor\ScheduleController as scheduleProf;
use App\Mail\newuserEmail;

use App\Mail\resetPasswordEmail;

use App\Mail\WelcomeEmail;
use App\Models\Departement;

use App\Models\chef_action;
use App\Models\filiere;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

///////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////
use App\Models\pending_user;
use App\Models\Role;
use App\Models\task;
use App\Models\User;

use App\Models\user_detail;
use App\Notifications\ProfUnassignedNotification;
use function PHPUnit\Framework\returnArgument;
use Illuminate\Support\Facades\DB;

/////////Coordonnateur//////////////////////////////////////////////////////
Route::prefix('coordonnateur')->group(function () {
    Route::get('/', [CoordonnateurController::class, 'dashboard'])->name('coordonnateur.dashboard');
});

//////coordonateur: gestion des modules/////////////




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

        //Assignation: 
        Route::get('/assign-vacataire', [ModuleController::class, 'create'])->name('coordonnateur.modules.assign-vacataire');

        Route::get('coordonnateur/modules/{module}/assigner', [ModuleController::class, 'showAssignationPage'])
            ->name('coordonnateur.modules.assigner');
        Route::post('coordonnateur/modules/{module}/assigner', [ModuleController::class, 'processAssignation'])
            ->name('coordonnateur.modules.assigner.process');


        Route::middleware(['auth'])->prefix('coordonnateur/modules/{module}')->group(function () {
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
Route::middleware(['auth'])
    ->group(function () {
        Route::get('/config_semester_suivant', [GroupeController::class, 'configureNextSemester'])
            ->name('config_semester_suivant');
        //saving action tout les moduel du semester
        Route::post('/config-semestre-suivant', [GroupeController::class, 'saveNextSemesterConfig'])
            ->name('save_semester_suivant');

        //saving acon modufication dune seule module groupes
        Route::post('/module_config/update', [GroupeController::class, 'updateModuleConfig'])
            ->name('module_config_update');
    });

# Groupes - Coordinateur
Route::prefix('coordonnateur/groupes')->middleware(['auth'])->group(function () {
    Route::get('/', [GroupeController::class, 'index'])->name('coordonnateur.groupes.index'); //overview of he current semester

});

Route::get('/mohssine', function () {

    return view('professor.dashboard');
});




//////professor//////////////////////////////////////////

Route::middleware(['auth'])
    ->group(function () {

        //notes:upload ,cancel,get
        Route::get('/upload-notes', [NoteController::class, 'showUploadForm'])
            ->name('notes_upload_page');

        Route::post('/upload-notes', [NoteController::class, 'upload'])
            ->name('notes.upload');

        Route::patch('/upload-notes/{Note}/cancel', [NoteController::class, 'cancel'])
            ->name('notes.cancel');



        //les module asssure pour le prof/vacataire
        Route::get('/mesModules', [GroupeController::class, 'mesModules'])
            ->name('mesModules');
        // Route::get('/mesModules', [ProfessorController::class, 'mesModules'])->name('professor.mesModules');



        //modules available pour l'anne suioant
        Route::get('/availableModules', [GroupeController::class, 'availableModules'])->name('availableModules');



        //voir list des requsest 
        Route::get('/requests', [ProfessorController::class, 'myRequests'])->name('professor.myRequests');


        //exprimmer les shouaite
        Route::post('/wish', [ProfessorController::class, 'expressWish'])->name('professor.souhaiteModule');
    });




Route::prefix('professor')->group(function () {
    Route::get('/dashboard', [ProfessorController::class, 'dashboard'])->name('professor.dashboard');






    //cancel request

    Route::delete('/requests/{prof_request}/cancel', [ProfessorController::class, 'cancelRequest'])
        ->name('professor.request.cancel');

    //////notes::
    // Route::post('/upload-notes', [NoteController::class, 'processUpload'])->name('professor.notes.process');
    // Route::get('/download-template', [NoteController::class, 'downloadTemplate'])->name('professor.notes.template');


    // ->middleware('auth:coordinator');


    //test
    // Route::get('upload-notes', function () {
    //     return view('professor.upload_notes');
    // });

    // Route::get('professor/upload-notes', [GradeController::class, 'showUploadForm'])->name('professor.upload_notes');
    // Route::post('professor/upload-notes', [GradeController::class, 'upload'])->name('professor.upload_notes.upload');
});


////////vacataire ///////////////////////////////////

Route::prefix('vacataire')->group(function () {
    Route::get('/dashboard', [vacataireController::class, 'dashboard'])->name('vacataire.dashboard');
});

//////////////////////////////////////////////////////////////////////////////
// routes/web.php

// Routes pour le builder d'emploi du temps
Route::middleware(['auth'])->name('coordinator.')->group(function () {
    Route::get('/schedules/builder', [ScheduleBuilderController::class, 'index'])->name('schedules.builder');
    Route::post('/schedules/create', [ScheduleBuilderController::class, 'createSchedule'])->name('schedules.create');
    Route::post('/schedules/save-session', [ScheduleBuilderController::class, 'saveSession'])->name('schedules.save-session');
    Route::delete('/schedules/delete-session', [ScheduleBuilderController::class, 'deleteSession'])->name('schedules.delete-session');
});

/////////////////////


// Route::middleware(['auth'])->group(function () {
// Route::get('/emploi/create', [EmploiController::class, 'create'])->name('emploi.create');
// Route::post('/emploi', [EmploiController::class, 'store'])->name('emploi.store');


// // Routes pour la gestion des emplois du temps
// Route::middleware(['auth'])->group(function () {
//     Route::get('/emplois', [EmploiController::class, 'create'])->name('emplois.create');
//     Route::post('/emplois', [EmploiController::class, 'store'])->name('emplois.store');
//     Route::get('/api/modules', [EmploiController::class, 'getModules'])->name('api.modules');
// });


Route::get('/emplois', [EmploiController::class, 'index'])->name('emploi.index');

Route::get('/emplois/create', [EmploiController::class, 'create'])->name('emploi.create');
Route::post('/emplois', [EmploiController::class, 'store'])->name('emploi.store');

Route::get('/emplois/{emploi}/edit', [EmploiController::class, 'edit'])->name('emploi.edit');
Route::put('/emplois/{emploi}', [EmploiController::class, 'update'])->name('emploi.update');

Route::delete('/emplois/{emploi}', [EmploiController::class, 'destroy'])->name('emploi.destroy');
















//////////////////////////////////////////////////////////////////////////////////////////
Route::get('/', [homeController::class, 'index']);

Route::get('/signup', [signupController::class, 'index']);

Route::post('/signup', [signupController::class, 'store']);

Route::get('/login', [loginController::class, 'index'])->name('login');
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

Route::patch('admins/add', [adminsController::class, 'choose']);


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


//chef department
Route::get('chef/demandes',[requestsController::class,'index']); 
Route::patch('chef/demandes/{id}',[requestsController::class,'accept']); 
Route::delete('chef/demandes/{id}',[requestsController::class,'decline']); 
 Route::get('chef/professeurs',[ChefProfessorController::class,'index']);
 Route::delete('chef/professeurs/remove/{id}',[ChefProfessorController::class,'removeModule']);
  Route::get('chef/filieres',[cheffiliereController::class,'index']);
Route::PATCH('chef/filieres/modifier/{id}',[cheffiliereController::class,'modify']); 
Route::get('chef/modules',[chefModulesController::class,'index']); 
Route::get('chef/modules_vacantes',[chefModulesController::class,'vacantesList']); 
Route::post('chef/modules_vacantes/affecter/{id}',[chefModulesController::class,'affecter']); 
Route::get('chef/professeur_profile/{id}',[ChefProfessorController::class,'professeur_profile']);
Route::post('chef/professeur_profile/{id}',[ChefProfessorController::class,'edit']);
Route::post('chef/professeurs/affecter', [ChefProfessorController::class,'affecter']);

    Route::get('/logs', [UserLogController::class, 'index'])->name('admin.logs');
    Route::get('/logs/export', [UserLogController::class, 'export'])->name('admin.logs.export');

Route::get('/admin/actions', [AdminActionController::class, 'index'])
    ->name('admin.actions');

  Route::get('/chef/actions', function(){
      $query = chef_action::with('user')->latest();

        // Filters
        if ($search = request('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->whereRaw('LOWER(CONCAT(firstname, " ", lastname)) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        if ($action = request('action')) {
            $query->where('action_type', $action);
        }

        $startDate = request('start_date') ? Carbon::parse(request('start_date')) : Carbon::now()->startOfWeek();
        $endDate = request('end_date') ? Carbon::parse(request('end_date')) : Carbon::now()->endOfWeek();
        $query->whereBetween('created_at', [$startDate, $endDate]);

        // Paginated results
        $actions = $query->paginate(10);

        // Distinct action types for filter dropdown
        $actionTypes = chef_action::distinct()->pluck('action_type');

        // Statistics
        $todayActions = chef_action::whereDate('created_at', Carbon::today())->count();
        $weekActions = chef_action::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $uniqueChefs = chef_action::distinct('chef_id')->count('chef_id');
        $mostActiveDay = chef_action::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('count', 'desc')
            ->first();
        $mostActiveDay = $mostActiveDay ? Carbon::parse($mostActiveDay->date)->format('Y-m-d') : 'N/A';

        return view('chef_departement.actions', compact(
            'actions',
            'actionTypes',
            'startDate',
            'endDate',
            'todayActions',
            'weekActions',
            'uniqueChefs',
            'mostActiveDay'
        ));
    }

  )->name('chef.actions');

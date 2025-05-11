<?php

namespace App\Http\Controllers;

use App\Models\admin_action;
use App\Models\prof_request;
use App\Models\student;
use App\Models\User;
use App\Models\task;
use App\Models\pending_user;
use App\Models\user_log;
use Illuminate\Support\Facades\Auth;

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
use Illuminate\View\ViewServiceProvider;
use PDO;
use PDOException;
use Carbon\Carbon;

class homeController extends Controller
{
    public function index(){
        if(Auth::check()) {
            if(Auth()->user()->role->isadmin) {
    
    
                $studentCount=student::get()->count();
                $professorCount=User::get()->count();
                $adminsHistory=admin_action::latest()->take(4)->get();
                $tasks=task::where('user_id',auth()->user()->id)->latest()->take(5)->get();
                $users_logs=user_log::latest()->take(6)->get();
               
               
 // Get user logs this week
$logs = user_log::whereBetween('created_at', [
    Carbon::now()->startOfWeek(), // Monday
    Carbon::now()->endOfWeek(),   // Sunday
])->get();


$logsByDay = $logs->groupBy(function($log) {
    return ucfirst(Carbon::parse($log->created_at)->locale('fr')->isoFormat('dddd'));
});

// Prepare counts for each day
$days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

// Build login counts
$loginCounts = [];
foreach ($days as $day) {
    $loginCounts[] = isset($logsByDay[$day]) ? $logsByDay[$day]->count() : 0;
}
               
               
                return view('admin.admin_dashboard',['tasks'=>$tasks,'studentCount'=>$studentCount,'professorCount'=>$professorCount,'adminsHistory'=>$adminsHistory,'users_logs' =>$users_logs, 'loginCounts' => $loginCounts]);
            }

            else if(Auth()->user()->role->ischef){
              
                return View('chef_departement.chef_dashboard');


            }
            if (auth()->user()->isCoordonnateur()) {
                return redirect()->route('coordonnateur.dashboard');
            } 


             // if professor
             if (auth()->user()->isProfessor()) {
                return redirect()->route('professor.dashboard');
            } 

    
            else{
                return view('dashboard');
            }
            
        }
        
        else{
            return redirect('login');
        }
    }

}
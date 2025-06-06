<?php

namespace App\Http\Controllers;

use App\Models\admin_action;
use App\Models\chef_action;
use App\Models\prof_request;
use App\Models\Student;

use App\Models\User;
use App\Models\task;
use App\Models\Filiere;
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
    
    public function index()
    {
                // dd(auth()->user()->role);

        if (Auth::check()) {
            if (Auth()->user()->role->isadmin) {


                $studentCount = Student::get()->count();
                $professorCount = User::get()->count();
                $adminsHistory = admin_action::latest()->take(4)->get();
                $tasks = task::where('user_id', auth()->user()->id)->latest()->take(5)->get();
                $users_logs = user_log::latest()->take(6)->get();


                // Get user logs this week
                $logs = user_log::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(), // Monday
                    Carbon::now()->endOfWeek(),   // Sunday
                ])->get();


                $logsByDay = $logs->groupBy(function ($log) {
                    return ucfirst(Carbon::parse($log->created_at)->locale('fr')->isoFormat('dddd'));
                });

                // Prepare counts for each day
                $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

                // Build login counts
                $loginCounts = [];
                foreach ($days as $day) {
                    $loginCounts[] = isset($logsByDay[$day]) ? $logsByDay[$day]->count() : 0;
                }


                return view('admin.admin_dashboard', ['tasks' => $tasks, 'studentCount' => $studentCount, 'professorCount' => $professorCount, 'adminsHistory' => $adminsHistory, 'users_logs' => $users_logs, 'loginCounts' => $loginCounts]);
            } 
            //if chef departement
            
            if (Auth()->user()->role->ischef) {

                  $studentCount = student::get()->count();
                $professorCount = User::get()->count();
                $chefHistory = chef_action::latest()->take(4)->get();
                $tasks = task::where('user_id', auth()->user()->id)->latest()->take(5)->get();
                  
                $departmentName =  auth()->user()->manage->name;
                $professorsMin =user::where('departement',$departmentName)->paginate(15);


               $professorsMin = User::where('departement',$departmentName)->latest()->take(3)->get();
           
                  $FilieretargetIDs = Filiere::where('department_id', auth()->user()->manage->id)
        ->pluck('id'); // Plucks all the IDs into a collection
   
        $module_requests = prof_request::whereIn('module_id', $FilieretargetIDs)->where('status','pending')->latest()->take(3)->get();


                // Get user logs this week
                $logs = user_log::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(), // Monday
                    Carbon::now()->endOfWeek(),   // Sunday
                ])->get();


                $logsByDay = $logs->groupBy(function ($log) {
                    return ucfirst(Carbon::parse($log->created_at)->locale('fr')->isoFormat('dddd'));
                });

                // Prepare counts for each day
                $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

                // Build login counts
                $loginCounts = [];
                foreach ($days as $day) {
                    $loginCounts[] = isset($logsByDay[$day]) ? $logsByDay[$day]->count() : 0;
                }



                return View('chef_departement.chef_dashboard',['tasks' => $tasks, 'studentCount' => $studentCount, 'professorCount' => $professorCount, 'chefHistory' => $chefHistory, 'professorsMin' => $professorsMin, 'loginCounts' => $loginCounts , 'module_requests' => $module_requests]);
            }



            ////////////////////////////




            // if coordinator
            if (auth()->user()->role->iscoordonnateur) {
                return redirect()->route('coordonnateur.dashboard');
            }

            // if vocataire
            if (auth()->user()->role->isvocataire) {
                return redirect()->route('vacataire.dashboard');
            }

            // if professor
            if (auth()->user()->role->isprof) {
                return redirect()->route('professor.dashboard');
            } else {
                return view('dashboard');

            }
        } else {
            return redirect('login');
        }
    }
}

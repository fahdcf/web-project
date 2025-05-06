<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\task;
use App\Models\pending_user;
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
use PDO;
use PDOException;
class homeController extends Controller
{
    public function index(){
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
    }
}

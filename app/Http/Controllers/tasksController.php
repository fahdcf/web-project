<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use PDO;
use PDOException;

class tasksController extends Controller
{
   public function addtask(){
    request()->validate([

        'task'=>'required',
    ]);
    
    $newtask=['description'=>request('task'),'user_id'=>auth()->user()->id];
    task::create($newtask);
    return redirect()->back();

   }

   public function markAsDone($id){
    $task=task::findOrFail($id);
    $task->isdone=1;
    $task->save();
    return redirect()->back();
   }
   
   public function markAsPending($id){
    $task=task::findOrFail($id);
    $task->isdone=0;
    $task->save();
    return redirect()->back();
   }


   public function delete($id){
    $task=task::findOrFail($id);
    $task->delete();
    return redirect()->back();

   }
}

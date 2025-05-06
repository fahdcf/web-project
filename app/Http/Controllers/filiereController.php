<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Departement;
use App\Models\filiere;
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
use PhpParser\Node\Expr\FuncCall;

class filiereController extends Controller
{
   public function index(){
    
    $departements=Departement::all();
    $filieres= filiere::all();

    $professors = User::where('role_column', 'professor')
    ->orWhereHas('role', function ($query) {
        $query->where('isprof', true);
    })->get();

    return view('admin.filieres',['filieres'=>$filieres,'professors'=>$professors, 'departements'=>$departements]);
   }

   public function showadd(){
    
    $professors = User::where('role_column', 'professor')
    ->orWhereHas('role', function ($query) {
        $query->where('isprof', true);
    })->get();    
    
    $departements=Departement::all();

    return view('admin.add_filiere',['professors'=>$professors,'Departements'=>$departements]);
   }


   public function add(){
    
    request()->validate([
        'name'=> 'required|max:255|min:2',
        'user_id'=>'required',
        'departement_id'=>'required'
    ]);

    $newFiliere=['name'=>request('name'), 'department_id'=>request('departement_id'),'coordonnateur_id' =>request(('user_id'))];
    Filiere::create($newFiliere);
    return redirect('/filieres');
 
   }

   public function modify($id){
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
   }

  public  function  delete($id){
      
    filiere::find($id)->delete();
return redirect()->back();
   }


}

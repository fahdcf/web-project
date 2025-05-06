<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Models\Departement;
use App\Models\filiere;
use App\Models\Role;

use Illuminate\Support\Facades\Notification;
use App\Notifications\ProfUnassignedNotification;

class departementController extends Controller
{
    public function index(){
        $departments=Departement::all();

        $professors = User::where('role_column', 'professor')
        ->orWhereHas('role', function ($query) {
            $query->where('isprof', true);
        })->get();
    
    return view('admin.departments',['departements'=>$departments, 'professors'=>$professors]);
    
    }

    public function showadd(){
        
        $professors = User::where('role_column', 'professor')
        ->orWhereHas('role', function ($query) {
            $query->where('isprof', true);
        })->get();
        
    return view('admin.add_department',['professors'=>$professors]);

    }

    public function add(){
        
request()->validate([
    'name'=> 'required|max:255|min:2',
    'user_id'=>'required'
]);
$newDepartement=['name'=>request('name'), 'user_id'=>request(('user_id'))];

Departement::create($newDepartement);
return redirect('/departements');

    }

    public function modify($id){
        request()->validate([
            'name'=>'required',
        ]);
    
        if(auth()->user()->role_column=="admin"){
        
             $dep=Departement::find($id);
             $dep->name=request('name');
             if(request('user_id')==null){
    
                 $dep->save();
    
             }
             else{
                $dep->user_id=request('user_id');
                 $dep->save();
             }
    
    
        }
    
        return redirect()->back();
    
    }

    public function delete($id){
        Departement::find($id)->delete();

        return redirect()->back();
        
        
    }
}

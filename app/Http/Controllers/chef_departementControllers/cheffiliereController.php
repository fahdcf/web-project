<?php

namespace App\Http\Controllers\chef_departementControllers;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\prof_request;

use App\Models\Departement;
use App\Models\Filiere;

 use App\Models\admin_action;
class cheffiliereController extends Controller
{


    public function index(){
          
   

            $professors = User::WhereHas('role', function ($query) {
                $query->where('isprof', true);
            })->get();
            
        $departementID=auth()->user()->manage->id;
         $filieres= Filiere::where('department_id',$departementID)->get();
      
        return view('chef_departement.filieres',['professors'=>$professors,'filieres'=>$filieres]);
    }

     public function modify($id){
    request()->validate([
        'name'=>'required',
    ]);

    if(auth()->user()->role->ischef){

    
         $fil=filiere::find($id);
         $fil->name=request('name');


            if(request('user_id')==null){

                $fil->save();
            }
            else{
                  if($fil->coordonnateur_id){

                    $oldcoor=user::findOrFail($fil->coordonnateur_id);
                    $role=$oldcoor->role;
                    $role->iscoordonnateur=0;
                    $role->save();
                }

                $fil->coordonnateur_id=request('user_id');
                $fil->save();

                 $newcoor=user::findOrFail($fil->coordonnateur_id);
                $role=$newcoor->role;
               $role->iscoordonnateur=1;
                $role->save();

            }

  
    }

  




    return redirect()->back();
   }

}



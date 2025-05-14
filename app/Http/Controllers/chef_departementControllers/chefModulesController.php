<?php

namespace App\Http\Controllers\chef_departementControllers;
use App\Http\Controllers\Controller;

use App\Models\Module;
 use App\Models\User;
use App\Models\prof_request;

use App\Models\Departement;
use App\Models\filiere;

 use App\Models\admin_action;
class chefModulesController extends Controller
{


    public function index(){


            $FilieretargetIDs = Filiere::where('department_id', auth()->user()->manage->id)
        ->pluck('id'); // Plucks all the IDs into a collection

        $filieres=filiere::where('department_id',auth()->user()->manage->id)->get();
        
 $modules = Module::whereIn('filiere_id', $FilieretargetIDs)->get();
       
        return view('chef_departement.modules',['modules'=> $modules ,'filieres'=>$filieres]);
    }

}



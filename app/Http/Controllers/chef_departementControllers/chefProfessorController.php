<?php

namespace App\Http\Controllers\chefDepartementControllers;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\prof_request;

use App\Models\Departement;
use App\Models\filiere;

 use App\Models\admin_action;
class ChefProfessorController extends Controller
{


    public function index(){
        $departmentName=auth()->user()->manage->name;
        $professors=user::where('departement',$departmentName)->simplePaginate(5);

        
        return view('chef_departement.professors',['professors'=>$professors]);
    }

}

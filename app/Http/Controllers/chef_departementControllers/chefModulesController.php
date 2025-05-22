<?php

namespace App\Http\Controllers\chef_departementControllers;
use App\Http\Controllers\Controller;

use App\Models\Assignment;
 use App\Models\chef_action;
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
        
$modules = Module::whereNot('professor_id', null)->whereIn('filiere_id', $FilieretargetIDs)
    ->where(function ($query) {
        $query->whereHas('assignment', function ($q) {
            $q->where('teach_tp', 1);
        })->orWhereDoesntHave('assignment', function ($q) {
            $q->where('teach_td', 1);
        })->orWhereDoesntHave('assignment', function ($q) {
            $q->where('teach_cm', 1);
        });
    })
    ->get();
        return view('chef_departement.modules',['modules'=> $modules ,'filieres'=>$filieres]);
    }


    
    public function vacantesList(){


            $FilieretargetIDs = Filiere::where('department_id', auth()->user()->manage->id)
        ->pluck('id'); // Plucks all the IDs into a collection

        $filieres=filiere::where('department_id',auth()->user()->manage->id)->get();
        
 //$modules = Module::where('professor_id', null)->whereIn('filiere_id', $FilieretargetIDs)->get();

  $modules = Module::whereIn('filiere_id', $FilieretargetIDs)
    ->where(function ($query) {
        $query->whereDoesntHave('assignment', function ($q) {
            $q->where('teach_tp', 1);
        })->orWhereDoesntHave('assignment', function ($q) {
            $q->where('teach_td', 1);
        })->orWhereDoesntHave('assignment', function ($q) {
            $q->where('teach_cm', 1);
        });
    })
    ->get();


        $departmentName=auth()->user()->manage->name;
        $professors=user::where('departement',$departmentName)->simplePaginate(5);

       
        return view('chef_departement.modules_vacantes',['modules'=> $modules ,'filieres'=>$filieres, 'professors'=>$professors]);
    }

    public function affecter($id){
        $module=Module::findOrFail($id);

request()->validate([
    'prof_id' => 'required',
]);

if(request('prof_id')){
    $prof=user::findOrFail(request('prof_id'));
    $module->professor_id=request('prof_id');
    $module->status="active";
    

    $newAssign=[
        'prof_id'=>$prof->id,
        'module_id'=>$module->id,
    ];
    $hours=0;
 

        if(request('isCm')=="cm"){


     $newAssign['teach_cm'] = 1;
$hours=$hours + $module->cm_hours;


        }

       if(request('isTp')=="tp"){
                  $newAssign['teach_tp'] = 1;
           $hours=$hours + $module->tp_hours;


        }

        if(request('isTd')=="td") {
                $newAssign['teach_td'] = 1;
$hours=$hours + $module->td_hours;



        }

        if(request('isAll')){
                $newAssign['teach_cm'] = 1;
                $newAssign['teach_tp'] = 1;
                $newAssign['teach_td'] = 1;

               $hours=$hours + $module->cm_hours + $module->td_hours + $module->tp_hours;

        }
        $newAssign['hours']=$hours;

        Assignment::create($newAssign);
       
        $module->save();


    }





       $chefActionDetails=[
            'chef_id'=>auth()->user()->id,
            'action_type' =>'affecter',
            'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a affecteé le module " . $module->name . " a le professeur " . $prof->firstname . " " . $prof->lastname ,
            'target_table' =>'modules',
            'target_id' => $module->id,
        ];


        
        
        chef_action::create($chefActionDetails);
   

  
    return redirect()->back();
}

   
    }




<?php

namespace App\Http\Controllers\chef_departementControllers;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Module;
use App\Models\user_detail;

use App\Models\chef_action;


class ChefProfessorController extends Controller
{


    public function index(){
        $departmentName=auth()->user()->manage->name;
        $professors=user::where('departement',$departmentName)->paginate(15);

        
        return view('chef_departement.professors',['professors'=>$professors]);
    }

    public function professeur_profile($id){
        $user=User::findOrFail($id);

                    $modules=Module::all();


        return view('chef_departement.professor_profile', ['user'=>$user,'modules'=>$modules]);

    }

     public function edit($id){

         
         if(auth()->user()->role->ischef){
             $prof=User::findOrFail($id);

             request()->validate([
                 'min_hours' => 'nullable|numeric',
                                'max_hours'=>'nullable|numeric',

                            ]);

                    $userDetails = $prof->user_details;  

                if(!$userDetails){
                    $userDetails= user_detail::create(['user_id'=>$prof->id]);
                }

                if (request('min_hours') && $userDetails->min_hours !== request('min_hours')) {
                            $userDetails->min_hours = request('min_hours');
                        }
                        if (request('max_hours') && $userDetails->max_hours !== request('max_hours')) {
                            $userDetails->max_hours = request('max_hours');
                        }
                $userDetails->save();
                
                $chefActionDetails=[

        'chef_id'=>auth()->user()->id,
        'action_type' =>'modifier',
        'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a modifieé la charge horaire du professeur " . $prof->firstname . " " . $prof->lastname ,
        'target_table' =>'users',
        'target_id' => $prof->id,
    ];
    chef_action::create($chefActionDetails);
                return redirect()->back();



        
        
   


                        }


                return redirect()->back();


    }
    
    public function removeModule($id){

        $module= Module::findOrFail($id);
        $profId =$module->professor_id;
              $prof = User::findOrFail($profId);

        $module->professor_id=null;
        $module->status='inactive';


        $module->save();


            $chefActionDetails=[
            'chef_id'=>auth()->user()->id,
            'action_type' =>'retirer',
            'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a retireé le module " . $module->name . " de professeur " . $prof->firstname . " " . $prof->lastname ,
            'target_table' =>'modules',
            'target_id' => $module->id,
        ];


        
        
        chef_action::create($chefActionDetails);
   

        return redirect()->back();
    }

}

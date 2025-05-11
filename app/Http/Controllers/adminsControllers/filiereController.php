<?php

namespace App\Http\Controllers\adminsControllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Departement;
use App\Models\filiere;

 use App\Models\admin_action;
class filiereController extends Controller
{
   public function index(){
    
    $departements=Departement::all();
    $filieres= filiere::all();

    $professors = User::WhereHas('role', function ($query) {
        $query->where('isprof', true);
    })->get();

    return view('admin.filieres',['filieres'=>$filieres,'professors'=>$professors, 'departements'=>$departements]);
   }

   public function showadd(){
    
    $professors = User::WhereHas('role', function ($query) {
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
    $createdFiliere=Filiere::create($newFiliere);

     $newcoordonnateur=user::findOrFail(request('user_id'));
         $role=$newcoordonnateur->role;
               $role->iscoordonnateur=1;
                $role->save();



    $actionDetails=[
        'admin_id'=>auth()->user()->id,
        'action_type' =>'create',
        'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a créé la filière " . $createdFiliere->name ,
        'target_table' =>'filieres',
        'target_id' => $createdFiliere->id,
    ];
    
    
    admin_action::create($actionDetails);
    return redirect('/filieres');
 
   }

   public function modify($id){
    request()->validate([
        'name'=>'required',
    ]);

    if(auth()->user()->role->isadmin){
    
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


    }

    $newcoordonnateur=user::findOrFail(request('user_id'));
       $newcoordonnateur->role->iscoordonnateur=1;
              $newcoordonnateur->save();


    $actionDetails=[
        'admin_id'=>auth()->user()->id,
        'action_type' =>'update',
        'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a modifié la filière " . $fil->name ,
        'target_table' =>'filieres',
        'target_id' => $fil->id,
    ];
    
    
    admin_action::create($actionDetails);

    return redirect()->back();
   }

  public  function  delete($id){
      
      $deletedFiliere=filiere::find($id);
if($deletedFiliere->coordonnateur_id){

    $coordonnateur=user::findOrFail($deletedFiliere->coordonnateur_id);
         $role=$coordonnateur->role;
               $role->iscoordonnateur=0;
                $role->save();
}

    $actionDetails=[
        'admin_id'=>auth()->user()->id,
        'action_type' =>'create',
        'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a supprimé la filière " . $deletedFiliere->name ,
        'target_table' =>'filieres',
        'target_id' => $deletedFiliere->id,
    ];

    $deletedFiliere->delete();
    
    
    admin_action::create($actionDetails);
return redirect()->back();
   }


}

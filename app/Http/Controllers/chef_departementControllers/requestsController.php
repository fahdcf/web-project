<?php

namespace App\Http\Controllers\chef_departementControllers;
use App\Http\Controllers\Controller;

use App\Models\Role;
 use App\Models\User;
use App\Models\prof_request;
use App\Models\Departement;
use App\Models\filiere;

 use App\Models\admin_action;
 use Symfony\Component\HttpKernel\Controller\ArgumentResolver\DateTimeValueResolver;
class requestsController extends Controller
{


   public function index()
{
    $module_requests = prof_request::where('type', 'module')->get();

    $FilieretargetIDs = Filiere::where('department_id', auth()->user()->manage->id)
        ->pluck('id'); // Plucks all the IDs into a collection

    $filiere_requests = prof_request::where('type', 'filiere')
        ->whereIn('target_id', $FilieretargetIDs)
        ->get();

    return view('chef_departement.demandes', [
        'module_requests' => $module_requests,
        'filiere_requests' => $filiere_requests
    ]);
}

 public function decline($id){
    

        $request = prof_request::findOrFail($id);

        $request->status="rejected";
        if(request('rejection_reason')){

            $request->rejection_reason= request('rejection_reason');
        }

        $request->save();
        return redirect()->back(); // ✅ correct



 }

  public function accept($id){
    

        $request = prof_request::findOrFail($id);

        if($request->type=="filiere"){
        $targetFiliereId=$request->target_id;

        $profID=$request->prof_id;
        $targetFiliere=filiere::findOrFail($targetFiliereId);

        $oldcoor=user::findOrFail($targetFiliere->coordonnateur_id) ;
       
               if($oldcoor->role){

       
        $oldcoorRole=$oldcoor->role;
        $oldcoorRole->iscoordonnateur=0;
        $oldcoorRole->save();
    }
    else{
             $newcoorRole=Role::create(['user_id'=> $targetFiliere->coordonnateur_id]);
              $newcoorRole->iscoordonnateur=0;
              $newcoorRole->save();
    }

        $targetFiliere->coordonnateur_id=$profID;
        $targetFiliere->save();
    

       $newcoor=user::findOrFail($profID) ;

       if($newcoor->role){

           $newcoorRole=$newcoor->role;
           
           $newcoorRole->iscoordonnateur=1;
           $newcoorRole->save();
           
        }
        else{
              $newcoorRole=Role::create(['user_id'=>$profID]);
              $newcoorRole->iscoordonnateur=1;
              $newcoorRole->save();



        }
           $request->status="approved";
           $request->save();
           
           return redirect()->back();


        }
        

        return redirect()->back(); 



 }
}

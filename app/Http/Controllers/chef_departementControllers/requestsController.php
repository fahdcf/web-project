<?php

namespace App\Http\Controllers\chef_departementControllers;
use App\Http\Controllers\Controller;

use App\Models\Assignment;
 use App\Models\Role;
 use App\Models\User;
  use App\Models\Module;

use App\Models\prof_request;
use App\Models\Departement;
use App\Models\filiere;

 use App\Models\admin_action;
 use Symfony\Component\HttpKernel\Controller\ArgumentResolver\DateTimeValueResolver;
class requestsController extends Controller
{


   public function index()
{
    $FilieretargetIDs = Filiere::where('department_id', auth()->user()->manage->id)
        ->pluck('id'); // Plucks all the IDs into a collection
   
        $module_requests = prof_request::whereIn('module_id', $FilieretargetIDs)->get();


    return view('chef_departement.demandes', [
        'module_requests' => $module_requests,
        
    ]);
}

 public function decline($id){
    

        $request = prof_request::findOrFail($id);

        $request->status="rejected";
        if(request('rejection_reason')){

            $request->rejection_reason= request('rejection_reason');
        }

        $request->save();
        return redirect()->back(); 



 }

 

  public function accept($id){
    

        $request = prof_request::findOrFail($id);
        
        
        
        $targetModuleId=$request->module_id;
        $module = Module::findOrFail($targetModuleId);


        $profID=$request->prof_id;

       $assign=[
        'module_id'=>$targetModuleId,
        'prof_id'=> $profID,
       ];

       $hours=0;
       if($request->toTeach_cm){
        $assign['teach_cm'] = $request->toTeach_cm;
        $hours=$hours + $module->cm_hours;

       }

        if($request->toTeach_td){
        $assign['teach_td'] = $request->toTeach_td;
        $hours=$hours + $module->td_hours;

       }

        if($request->toTeach_tp){
        $assign['teach_tp'] = $request->toTeach_tp;
        $hours=$hours + $module->tp_hours;

       }

       $assign['hours']=$hours;

        
           $request->status="approved";
            $request->action_by=auth()->user()->id;

           $request->save();
           Assignment::create($assign);
           return redirect()->back();

    

    
        

        




 




}

}

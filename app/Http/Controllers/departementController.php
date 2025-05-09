<?php

namespace App\Http\Controllers;

use App\Models\User;



use App\Models\Departement;
use App\Models\admin_action;



class departementController extends Controller
{
    public function index(){
        $departments=Departement::all();

        $professors = User::WhereHas('role', function ($query) {
            $query->where('isprof', true);
        })->get();
    
    return view('admin.departments',['departements'=>$departments, 'professors'=>$professors]);
    
    }

    public function showadd(){
        
        $professors = User::WhereHas('role', function ($query) {
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

$createdDepartement=Departement::create($newDepartement);


$actionDetails=[
    'admin_id'=>auth()->user()->id,
    'action_type' =>'create',
    'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a créé la departement " . $createdDepartement->name ,
    'target_table' =>'departements',
    'target_id' => $createdDepartement->id,
];


admin_action::create($actionDetails);

return redirect('/departements');

    }

    public function modify($id){
        request()->validate([
            'name'=>'required',
        ]);
    
        if(auth()->user()->role->isadmin){
        
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
        $actionDetails=[
            'admin_id'=>auth()->user()->id,
            'action_type' =>'update',
            'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a modifié la departement " . $dep->name ,
            'target_table' =>'departements',
            'target_id' => $dep->id,
        ];
        
        
        admin_action::create($actionDetails);
    
        return redirect()->back();
    
    }

    public function delete($id){
        $deletedDepartement=Departement::find($id);

        $actionDetails=[
            'admin_id'=>auth()->user()->id,
            'action_type' =>'delete',
            'description'=>auth()->user()->firstname . " " . auth()->user()->lastname ." a supprimé la departement " . $deletedDepartement->name ,
            'target_table' =>'departements',
            'target_id' => $deletedDepartement->id,
        ];
        
        $deletedDepartement->delete();
        
        admin_action::create($actionDetails);

        return redirect()->back();
        
        
    }
}

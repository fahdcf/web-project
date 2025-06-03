<?php

namespace App\Http\Controllers\chef_departementControllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Module;
use App\Models\user_detail;
use App\Models\Filiere;
use App\Models\Assignment;


use Illuminate\Http\Request;

use App\Models\chef_action;


class ChefProfessorController extends Controller
{


    public function index()
    {
        $departmentName = auth()->user()->manage->name;
        $professors = user::where('departement', $departmentName)->paginate(15);


        return view('chef_departement.professors', ['professors' => $professors]);
    }

    public function professeur_profile($id)
    {
        $user = User::findOrFail($id);

        $modules = Module::all();
        $assignement = Assignment::where('prof_id', $user->id)->get();


        $FilieretargetIDs = Filiere::where('department_id', auth()->user()->manage->id)
            ->pluck('id'); // Plucks all the IDs into a collection


        $available_modules = Module::whereIn('filiere_id', $FilieretargetIDs)
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



        return view('chef_departement.professor_profile', ['user' => $user, 'modules' => $modules, 'available_modules' => $available_modules, 'assignement' => $assignement]);
    }

    public function edit($id)
    {


        if (auth()->user()->role->ischef) {
            $prof = User::findOrFail($id);

            request()->validate([
                'min_hours' => 'nullable|numeric',
                'max_hours' => 'nullable|numeric',

            ]);

            $userDetails = $prof->user_details;

            if (!$userDetails) {
                $userDetails = user_detail::create(['user_id' => $prof->id]);
            }

            if (request('min_hours') && $userDetails->min_hours !== request('min_hours')) {
                $userDetails->min_hours = request('min_hours');
            }
            if (request('max_hours') && $userDetails->max_hours !== request('max_hours')) {
                $userDetails->max_hours = request('max_hours');
            }
            $userDetails->save();

            $chefActionDetails = [

                'chef_id' => auth()->user()->id,
                'action_type' => 'modifier',
                'description' => auth()->user()->firstname . " " . auth()->user()->lastname . " a modifieé la charge horaire du professeur " . $prof->firstname . " " . $prof->lastname,
                'target_table' => 'users',
                'target_id' => $prof->id,
            ];
            chef_action::create($chefActionDetails);
            return redirect()->back();
        }


        return redirect()->back();
    }

    public function removeModule($id)
    {

        $assign = Assignment::findOrFail($id);
        $profId = $assign->prof_id;
        $prof = User::findOrFail($profId);



        $chefActionDetails = [
            'chef_id' => auth()->user()->id,
            'action_type' => 'retirer',
            'description' => auth()->user()->firstname . " " . auth()->user()->lastname . " a retireé le module " . $assign->module->name . " de professeur " . $prof->firstname . " " . $prof->lastname,
            'target_table' => 'modules',
            'target_id' => $assign->module->id,
        ];


        Assignment::findOrFail($id)->delete();

        chef_action::create($chefActionDetails);

        return redirect()->back();
    }


    public function affecter()
    {

        $tab = [];
        $i = 0;



        foreach (request('modules') as $assaign) {

            $id = $assaign['module_id'];

            $module = Module::findOrFail($id);


            if ($assaign['prof_id']) {

                $prof = user::findOrFail($assaign['prof_id']);
                // $module->professor_id = $assaign['prof_id'];

                $module->status = "active";


                $newAssign = [
                    'prof_id' => $prof->id,
                    'module_id' => $module->id,
                ];

                $hours = 0;


                if ($assaign['cm'] == "cm") {


                    $newAssign['teach_cm'] = 1;
                    $hours = $hours + $module->cm_hours;
                }

                if ($assaign['tp'] == "tp") {
                    $newAssign['teach_tp'] = 1;
                    $hours = $hours + $module->tp_hours;
                }

                if ($assaign['td'] == "td") {
                    $newAssign['teach_td'] = 1;
                    $hours = $hours + $module->td_hours;
                }


                $newAssign['hours'] = $hours;

                $tab[$i] = $newAssign;
                $i++;

                Assignment::create($newAssign);

                $module->save();


                $chefActionDetails = [
                    'chef_id' => auth()->user()->id,
                    'action_type' => 'affecter',
                    'description' => auth()->user()->firstname . " " . auth()->user()->lastname . " a affecteé le module " . $module->name . " a le professeur " . $prof->firstname . " " . $prof->lastname,
                    'target_table' => 'modules',
                    'target_id' => $module->id,
                ];




                chef_action::create($chefActionDetails);
            }
        }





        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\prof_request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessorController extends Controller
{
    public function dashboard()
    {
        return view('professor.index');
    }

    public function myRequests()
    {

        $FilieretargetIDs =  [1,2,3];

        // $module_requests = prof_request::whereIn('module_id', $FilieretargetIDs)->get();
        $module_requests = prof_request::where('prof_id',auth()->user()->id)->get();

        return view('professor.mes_requests', [
            'module_requests' => $module_requests,

        ]);
    }




    // public function mesModules()
    // {


    //     $user = auth()->user();
    //     $modules = $user->assignedModules()->with('filiere')
    //         ->get();


    //     return view('modules.mesModules', [
    //         'modules' => $modules
    //     ]);
    // }

    public function mesModules()
    {
        $professor = auth()->user();

        $modules = $professor->assignedModules()
            ->with('filiere') // Chargement anticipé de la filière
            ->orderBy('semester')
            ->get();

        // $modules = Module::where('professor_id',$professor->id)
        //     ->with('filiere') // Chargement anticipé de la filière
        //     ->orderBy('semester')
        //     ->get();

        return view('modules.mesModules', [
            'currentSemester' => $this->getCurrentSemester(),
            'modules' => $modules
        ]);
    }


    //helper
    private function getCurrentSemester()
    {
        return (date('n') >= 9 || date('n') <= 2) ? 1 : 2; // S1: Sept-Fév, S2: Mars-Août
    }
}





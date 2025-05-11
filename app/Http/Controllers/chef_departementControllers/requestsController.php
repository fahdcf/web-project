<?php

namespace App\Http\Controllers\chef_departementControllers;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\prof_request;

use App\Models\Departement;
use App\Models\filiere;

 use App\Models\admin_action;
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

}

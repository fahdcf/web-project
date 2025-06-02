<?php

namespace App\Http\Controllers\chef_departementControllers;

use App\Http\Controllers\Controller;

use App\Models\admin_action;
use App\Models\Assignment;
use App\Models\Departement;
use App\Models\Filiere;

use App\Models\Module;
use App\Models\prof_request;
use App\Models\Role;
use Illuminate\Support\Facades\Notification;

use App\Models\User;
use App\Notifications\NewRequestsNotification;
use Illuminate\Http\Request;
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

    public function decline($id)
    {


        $request = prof_request::findOrFail($id);

        $request->status = "rejected";
        if (request('rejection_reason')) {

            $request->rejection_reason = request('rejection_reason');
        }

        $request->save();
        return redirect()->back();
    }



    public function accept($id)
    {


        $request = prof_request::findOrFail($id);



        $targetModuleId = $request->module_id;
        $module = Module::findOrFail($targetModuleId);


        $profID = $request->prof_id;

        $assign = [
            'module_id' => $targetModuleId,
            'prof_id' => $profID,
        ];

        $hours = 0;
        if ($request->toTeach_cm) {
            $assign['teach_cm'] = $request->toTeach_cm;
            $hours = $hours + $module->cm_hours;
        }

        if ($request->toTeach_td) {
            $assign['teach_td'] = $request->toTeach_td;
            $hours = $hours + $module->td_hours;
        }

        if ($request->toTeach_tp) {
            $assign['teach_tp'] = $request->toTeach_tp;
            $hours = $hours + $module->tp_hours;
        }

        $assign['hours'] = $hours;


        $request->status = "approved";
        $request->action_by = auth()->user()->id;

        $request->save();
        Assignment::create($assign);
        return redirect()->back();
    }






    ///////////////////////////
    public function store(Request $request, Module $module)
    {
        $prof = auth()->user();
        $request->validate([
            'isTp' => 'nullable|in:tp',
            'isTd' => 'nullable|in:td',
            'isCm' => 'nullable|in:cm',
        ]);

        if ($request['isTp'] == null && $request['isTd'] == null && $request['isCm'] == null) {
            return back()->with('error', 'demande annulle  choisir au moi un type td/tp/cm');
        }

        $attributes = [];
        if ($request['isTd']) {
            $attributes['toTeach_td'] = true;

            // Check if request already exists
            $existing = prof_request::where('prof_id', auth()->user()->id)
                ->where('module_id', $module->id)
                ->where('toTeach_td', true)->first();

            if ($existing) {
                return back()->with('error', 'Vous avez déjà une demande en cours pour TD de ce module');
            }
        }
        if ($request['isTp']) {
            $attributes['toTeach_tp'] = true;


            // Check if request already exists
            $existing = prof_request::where('prof_id', auth()->user()->id)
                ->where('module_id', $module->id)
                ->where('toTeach_tp', true)->first();

            if ($existing) {
                return back()->with('error', 'Vous avez déjà une demande en cours pour TD de ce module');
            }
        }
        if ($request['isCm']) {
            $attributes['toTeach_cm'] = true;

            // Check if request already exists
            $existing = prof_request::where('prof_id', auth()->user()->id)
                ->where('module_id', $module->id)
                ->where('toTeach_cm', true)->first();

            if ($existing) {
                return back()->with('error', 'Vous avez déjà une demande en cours pour TD de ce module');
            }
        }

        prof_request::create([
            'prof_id' => auth()->user()->id,
            'module_id' => $module->id,

            'status' => 'pending',
            'toTeach_cm' => $attributes['toTeach_cm'] ?? false,
            'toTeach_td' => $attributes['toTeach_td'] ?? false,
            'toTeach_tp' => $attributes['toTeach_tp'] ?? false,

        ]);

        $prof=User::findOrFail(auth()->user()->id);
        

        $department_id=$module->filiere->department_id;
        $departement=Departement::findOrFail($department_id);
        $chefs=User::where('departement',$departement->name)->get();

        Notification::send($chefs, new NewRequestsNotification($prof, $module));


        return back()->with('success', 'Votre souhait a été enregistré !');
    }



    public function cancelRequest(prof_request $prof_request)
    {
        $id = auth()->user()->id;
        // Verify the request belongs to the current user
        if ($prof_request->prof_id != $id) {
            return back()->with('error', 'Unauthorized action. You are not the requester of this request to cancel.');
        }

        // Only allow canceling pending requests
        if ($prof_request->status !== 'pending') {
            return back()->with('error', 'You can only cancel the pending requests.');
        }

        $prof_request->delete();
        return back()->with('success', 'Demande annuler avec succes.');
    }
}

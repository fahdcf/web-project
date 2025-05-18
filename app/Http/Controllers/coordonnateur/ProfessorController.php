<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\prof_request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessorController extends Controller
{
    public function index()
    {
        return view('professor.index');
    }

    public function availableModules()
    {

        $user = auth()->user();

        $modulesDispo = Module::whereNull('professor_id')->with(['requests' => function ($query) use ($user) {

            $query->where('prof_id', $user->id);
        }])->get();

        // dd($modulesDispo);

        // $modulesDispo = Module::where('professor_id', null)->get();
        return view('professor.availableModules', compact('modulesDispo'));
    }

    //     // web.php

    // WishController.php
    public function storeSouhaite(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'user_id' => 'required|exists:users,id'
        ]);

        // Check if request already exists
        $existing = prof_request::where('prof_id', auth()->user()->id)
            ->where('type', 'module')
            ->where(
                'target_id',
                $validated['module_id']
            )
            ->first();

        if ($existing) {
            return back()->with('error', 'Vous avez déjà une demande en cours pour ce module');
        }



        prof_request::create([
            'prof_id' => $validated['user_id'],
            'target_id' => $validated['module_id'],
            'type' => 'module'
        ]);

        return back()->with('success', 'Votre souhait a été enregistré !');
    }

    public function myRequests()
    {
        $requests = prof_request::with(['module'])
            ->where('prof_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // $chargeApproved=reques;

        // dd($requests);
        return view('professor.requestList', compact('requests'));
    }




    public function cancelRequest(prof_request $prof_request)
    {

        $id=auth()->user()->id;
        // dd($id,$prof_request->prof_id);
        // Verify the request belongs to the current user
        if ($prof_request->prof_id != $id) {
            return back()->with('error', 'Unauthorized action. You are not the requester of this request.');
        }

        // Only allow canceling pending requests
        if ($prof_request->status !== 'pending') {
            return back()->with('error', 'You can only cancel pending prof_requests.');
        }

        $prof_request->delete();
        return back()->with('success', 'Request canceled successfully.');
    }

    public function mesModules()
    {
        $professor = auth()->user();

        // $modules = $professor->modules()
        //     ->with('filiere') // Chargement anticipé de la filière
        //     ->orderBy('semester')
        //     ->get();

        $modules = Module::where('professor_id',$professor->id)
            ->with('filiere') // Chargement anticipé de la filière
            ->orderBy('semester')
            ->get();

        return view('professor.mesModules', [
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

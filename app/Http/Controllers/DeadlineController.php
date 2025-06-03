<?php

namespace App\Http\Controllers;

use App\Models\Deadline;
use App\Models\User;
use App\Notifications\DeadlineNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;


class DeadlineController extends Controller
{
    public function index(Request $request)
    {
        $deadlines = Deadline::with('user')->latest()->paginate(10);

        return view('chef_departement.deadline', compact('deadlines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:note,ue_selecion',
            'deadline_date' => 'required|date|after:now',
            'notification_date' => 'required|date|before:deadline_date',
            'status' => 'required|in:active,expired',
        ]);

        $deadline = Deadline::create([
            'type' => $validated['type'],
            'deadline_date' => Carbon::parse($validated['deadline_date']),
            'status' => $validated['status'],
            'notification_date' => Carbon::parse($validated['notification_date']),
            'created_by' => Auth::id(),
        ]);



///////////////////////////////////////////////////////////////////////////////////////////////////////////

        // send notifications to professors and vacataires


        //about note to bothe professors and vacataires
        if ($validated['type'] === 'note') {
            $professors = User::whereHas('role', function ($query) {
                $query->where('isprof', true)
                    ->orWhere('isvocataire', true);
            })->get();

            $message = 'Une nouvelle échéance a été fixée pour la saisie des notes.';
            $url = route('notes_upload_page');
            Notification::send($professors, new DeadlineNotification($message, $deadline, $url));


            //about ue_selecion to professors only
        } else if ($validated['type'] === 'ue_selecion') {
            $vacataires = User::whereHas('role', function ($query) {
                $query->where('isvocataire', true);
            })->get();

            $message = 'Une nouvelle échéance a été fixée pour la sélection des UE.';
            $url = route('availableModules');

        Notification::send($vacataires, new DeadlineNotification($message, $deadline, $url));
        }


        return redirect()->route('deadline.index')->with('success', 'Échéance créée avec succès.');
    }
}

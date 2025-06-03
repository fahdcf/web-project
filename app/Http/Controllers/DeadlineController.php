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
            'notification_date' => Carbon::parse($validated['notification_date']),
            'status' => $validated['status'],
            // 'created_by' => Auth::id(),
            'created_by' => 1,
        ]);

        // Fetch all professor users (assuming a 'role' column exists)
        $professors = User::whereHas('role', function ($query) {
            $query->where('isprof', true)
            ->orWhere('isvocataire', true);
        })->get();

        // Prepare notification message based on deadline type
        $message = $validated['type'] === 'note'
            ? 'Une nouvelle échéance a été fixée pour la saisie des notes.'
            : 'Une nouvelle échéance a été fixée pour la sélection des UE.';

        // Send notification to all professors
        Notification::send($professors, new DeadlineNotification($message, $deadline));



        return redirect()->route('deadline.index')->with('success', 'Échéance créée avec succès.');
    }
}

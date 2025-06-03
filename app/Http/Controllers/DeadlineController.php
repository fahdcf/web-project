<?php

namespace App\Http\Controllers;

use App\Models\Deadline;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        Deadline::create([
            'type' => $validated['type'],
            'deadline_date' => Carbon::parse($validated['deadline_date']),
            'notification_date' => Carbon::parse($validated['notification_date']),
            'status' => $validated['status'],
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('deadline.index')->with('success', 'Échéance créée avec succès.');
    }
}
?>
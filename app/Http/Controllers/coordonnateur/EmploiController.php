<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\Emploi;

use App\Models\Filiere;
use App\Models\Module;
use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmploiController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $filiere = $user->filiere; // Assuming user has one filiere
        $currentYear = date('Y');
        $academicYear = "$currentYear-" . ($currentYear + 1); // e.g., "2024-2025"

        return view('emploi.index', compact('filiere', 'academicYear'));
    }

    public function store(Request $request)
    {
        // dd('hi');
        // Validate the request
        $validated = $request->validate([
            'filiere_id' => 'required|exists:filieres,id',
            'semester' => 'required|integer|between:1,6',
            'academic_year' => 'required|string',
            'name' => 'required|string|max:255',
            'sessions' => 'required|array|min:1',
            'sessions.*.module_id' => 'required|exists:modules,id',
            'sessions.*.type' => 'required|in:CM,TD,TP',
            'sessions.*.jour' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi',
            'sessions.*.heure_debut' => 'required|date_format:H:i',
            'sessions.*.heure_fin' => 'required|date_format:H:i|after:sessions.*.heure_debut',
            'sessions.*.salle' => 'nullable|string|max:50',
            'sessions.*.groupe' => 'nullable|string|max:50',
        ]);

        // Create the Emploi
        $emploi = Emploi::create([
            'filiere_id' => $validated['filiere_id'],
            'semester' => $validated['semester'],
            'academic_year' => $validated['academic_year'],
            'name' => $validated['name'],
        ]);

        // Create Seances
        foreach ($validated['sessions'] as $session) {
            Seance::create([
                'emploi_id' => $emploi->id,
                'module_id' => $session['module_id'],
                'type' => $session['type'],
                'jour' => $session['jour'],
                'heure_debut' => $session['heure_debut'],
                'heure_fin' => $session['heure_fin'],
                'salle' => $session['salle'],
                'groupe' => $session['groupe'],
            ]);
        }

        // Redirect with success message
        return redirect()->route('emploi.create')->with('success', 'Emploi du temps enregistré avec succès !');
    }

    public function getModules(Request $request)
    {
        $filiere_id = $request->query('filiere_id');
        $semester = $request->query('semester');
        $modules = Module::where('filiere_id', $filiere_id)
            ->where('semester', $semester)
            ->get();
        return response()->json($modules);
    }



    // Helper method to determine current year academic
    public static function getCurrentAcademic_year(): string
    {
        $month = now()->month;
        $year = now()->year;

        // Calcul de l'année académique (ex: 2023-2024)
        $academicYear = ($month >= 9)
            ? $year . '-' . ($year + 1)
            : ($year - 1) . '-' . $year;
        return  $academicYear;
    }


    
}

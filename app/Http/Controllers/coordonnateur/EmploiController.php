<?php

namespace App\Http\Controllers\Coordonnateur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Emploi;
use App\Models\Seance;
use App\Models\Module;
use Illuminate\Support\Facades\Log;

class EmploiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filiere = $user->manage;
        $currentYear = date('Y');
        $defaultAcademicYear = "$currentYear-" . ($currentYear + 1);
        $academicYear = $request->query('academic_year', $defaultAcademicYear);

        $emplois = Emploi::where('filiere_id', $filiere->id)
            ->where('academic_year', $academicYear)
            ->get();

        $academicYears = Emploi::where('filiere_id', $filiere->id)
            ->distinct()
            ->pluck('academic_year')
            ->sort()
            ->toArray();

        if (!in_array($defaultAcademicYear, $academicYears)) {
            $academicYears[] = $defaultAcademicYear;
            sort($academicYears);
        }

        return view('emploi.index', compact('filiere', 'emplois', 'academicYear', 'academicYears'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $filiere = $user->manage;
        $currentYear = date('Y');
        $academicYear = "$currentYear-" . ($currentYear + 1);
        $semester = $request->query('semester', 1);

        $modules = Module::where('filiere_id', $filiere->id)
            ->where('semester', $semester)
            ->get();

        return view('emploi.create', compact('filiere', 'academicYear', 'semester', 'modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'filiere_id' => 'required|exists:filieres,id',
            'semester' => 'required|integer|between:1,6',
            'academic_year' => 'required|string|size:9|regex:/^[0-9]{4}-[0-9]{4}$/',
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
            'seances' => 'nullable|array',
            'seances.*.module_id' => 'required|exists:modules,id',
            'seances.*.type' => 'required|in:CM,TD,TP',
            'seances.*.jour' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi',
            'seances.*.heure_debut' => 'required|date_format:H:i:s',
            'seances.*.heure_fin' => 'required|date_format:H:i:s|after:seances.*.heure_debut',
            'seances.*.salle' => 'nullable|string|max:50',
            'seances.*.groupe' => 'nullable|string|max:20',
        ]);

        $existingEmploi = Emploi::where('filiere_id', $validated['filiere_id'])
            ->where('semester', $validated['semester'])
            ->where('academic_year', $validated['academic_year'])
            ->first();

        if ($existingEmploi) {
            return redirect()->route('emploi.index')->with('error', 'Un emploi du temps existe déjà pour ce semestre.');
        }

        $emploi = Emploi::create([
            'filiere_id' => $validated['filiere_id'],
            'semester' => $validated['semester'],
            'academic_year' => $validated['academic_year'],
            'name' => $validated['name'],
            'is_active' => $validated['is_active'] ?? true,
            'file_path' => null,
        ]);

        Log::info('Seances data in store:', ['seances' => $validated['seances'] ?? [], 'emploi_id' => $emploi->id]);

        $successCount = 0;
        $errors = [];

        if (!empty($validated['seances'])) {
            foreach ($validated['seances'] as $index => $seance) {
                try {
                    Seance::create([
                        'emploi_id' => $emploi->id,
                        'module_id' => $seance['module_id'],
                        'type' => $seance['type'],
                        'jour' => $seance['jour'],
                        'heure_debut' => $seance['heure_debut'],
                        'heure_fin' => $seance['heure_fin'],
                        'salle' => $seance['salle'] ?: null,
                        'groupe' => $seance['groupe'] ?: null,
                    ]);
                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Séance $index: Erreur lors de la création - " . $e->getMessage();
                    Log::error("Failed to create seance at index $index", [
                        'seance' => $seance,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        $message = "Emploi du temps créé avec succès ! $successCount séance(s) ajoutée(s).";
        if (!empty($errors)) {
            $message .= ' Cependant, certaines séances n\'ont pas pu être ajoutées : ' . implode('; ', $errors);
            return redirect()->route('emploi.index')->with('warning', $message);
        }

        return redirect()->route('emploi.index')->with('success', $message);
    }

    public function edit(Emploi $emploi)
    {
        $user = Auth::user();
        $filiere = $user->manage;

        if ($emploi->filiere_id !== $filiere->id) {
            return redirect()->route('emploi.index')->with('error', 'Accès non autorisé (only coordoonateur tache).');
        }

        $modules = Module::where('filiere_id', $filiere->id)
            ->where('semester', $emploi->semester)
            ->get();

        return view('emploi.edit', compact('emploi', 'modules'));
    }

    public function update(Request $request, Emploi $emploi)
    {
        $user = Auth::user();
        if ($emploi->filiere_id !== $user->manage->id) {
            return redirect()->route('emploi.index')->with('error', 'Accès non autorisé (only coordoonateur tache).');
        }

        $validated = $request->validate([
            'filiere_id' => 'required|exists:filieres,id',
            'semester' => 'required|integer|between:1,6',
            'academic_year' => 'required|string|size:9|regex:/^[0-9]{4}-[0-9]{4}$/',
            'name' => 'required|string|max:255',
            'seances' => 'nullable|array',
            'seances.*.module_id' => 'required|exists:modules,id',
            'seances.*.type' => 'required|in:CM,TD,TP',
            'seances.*.jour' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi',
            'seances.*.heure_debut' => 'required|date_format:H:i:s',
            'seances.*.heure_fin' => 'required|date_format:H:i:s|after:seances.*.heure_debut',
            'seances.*.salle' => 'nullable|string|max:50',
            'seances.*.groupe' => 'nullable|string|max:20',
        ]);
        $emploi->update([
            'name' => $validated['name'],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        Log::info('Seances data in update:', ['seances' => $validated['seances'] ?? [], 'emploi_id' => $emploi->id]);

        // Delete existing Seance records and replace with new ones
        $emploi->seances()->delete();

        $successCount = 0;
        $errors = [];

        if (!empty($validated['seances'])) {
            foreach ($validated['seances'] as $index => $seance) {
                try {
                    Seance::create([
                        'emploi_id' => $emploi->id,
                        'module_id' => $seance['module_id'],
                        'type' => $seance['type'],
                        'jour' => $seance['jour'],
                        'heure_debut' => $seance['heure_debut'],
                        'heure_fin' => $seance['heure_fin'],
                        'salle' => $seance['salle'] ?: null,
                        'groupe' => $seance['groupe'] ?: null,
                    ]);
                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Séance $index: Erreur lors de la création - " . $e->getMessage();
                    Log::error("Failed to update seance at index $index", [
                        'seance' => $seance,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        $message = "Emploi du temps mis à jour avec succès ! $successCount séance(s) ajoutée(s).";
        if (!empty($errors)) {
            $message .= ' Cependant, certaines séances n\'ont pas pu être ajoutées : ' . implode('; ', $errors);
            return redirect()->route('emploi.index')->with('warning', $message);
        }

        return redirect()->route('emploi.index')->with('success', $message);
    }


    public function destroy(Emploi $emploi)
    {
        $user = Auth::user();
        if ($emploi->filiere_id !== $user->manage->id) {
            return redirect()->route('emploi.index')->with('error', 'Accès non autorisé : pas un coordoonateur');
        }

        try {
            Log::info('Deleting emploi:', ['emploi_id' => $emploi->id, 'name' => $emploi->name]);
            $emploi->delete();
            return redirect()->route('emploi.index')->with('success', 'Emploi du temps supprimé avec succès.');
        } catch (\Exception $e) {
            Log::error('Failed to delete emploi:', [
                'emploi_id' => $emploi->id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('emploi.index')->with('error', 'Erreur lors de la suppression de l\'emploi du temps.');
        }
    }


    // public function export(Emploi $emploi)
    // {
    //     $user = Auth::user();
    //     if ($emploi->filiere_id !== $user->filiere->id) {
    //         return redirect()->route('emploi.index')->with('error', 'Accès non autorisé.');
    //     }

    //     // Organize seances by day and time slot
    //     $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    //     $timeSlots = [
    //         ['start' => '08:30:00', 'end' => '10:30:00'],
    //         ['start' => '10:30:00', 'end' => '12:30:00'],
    //         ['start' => '14:30:00', 'end' => '16:30:00'],
    //         ['start' => '16:30:00', 'end' => '18:30:00']
    //     ];

    //     $schedule = [];
    //     foreach ($days as $day) {
    //         $schedule[$day] = [];
    //         foreach ($timeSlots as $index => $slot) {
    //             $schedule[$day][$index] = $emploi->seances()
    //                 ->where('jour', $day)
    //                 ->where('heure_debut', $slot['start'])
    //                 ->with('module')
    //                 ->get()
    //                 ->map(function ($seance) {
    //                     return [
    //                         'module_name' => addslashes($seance->module->name),
    //                         'module_code' => addslashes($seance->module->code),
    //                         'type' => $seance->type,
    //                         'salle' => $seance->salle ? addslashes($seance->salle) : 'Non défini',
    //                         'groupe' => $seance->groupe ?? ''
    //                     ];
    //                 })->toArray();
    //         }
    //     }

    //     // LaTeX template
    //     $latexContent = view('emploi.pdf', [
    //         'emploi' => $emploi,
    //         'filiere' => $user->filiere,
    //         'schedule' => $schedule,
    //         'timeSlots' => $timeSlots
    //     ])->render();

    //     // Log LaTeX content for debugging
    //     Log::info('Generated LaTeX content for emploi export:', [
    //         'emploi_id' => $emploi->id,
    //         'latex_length' => strlen($latexContent)
    //     ]);

    //     return response($latexContent)
    //         ->header('Content-Type', 'application/pdf')
    //         ->header('Content-Disposition', 'attachment; filename="emploi_' . $emploi->id . '.pdf"');
    // }
}

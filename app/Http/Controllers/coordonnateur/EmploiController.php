<?php

namespace App\Http\Controllers\Coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\Emploi;
use App\Models\Module;
use App\Models\Seance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProfessorTimetableExport;
use App\Exports\FiliereTimetableExport;
use App\Models\coord_action;

class EmploiController extends Controller
{








    public function index(Request $request)
    {
        $user = Auth::user();
        $filiere = $user->manage;
        $emplois = Emploi::where('filiere_id', $filiere->id)->get();
        return view('emploi.index', compact('filiere', 'emplois'));
    }

     public function create(Request $request)
    {
        $user = Auth::user();
        $filiere = $user->manage;
        $semester = $request->query('semester', 1);

        $modules = Module::where('filiere_id', $filiere->id)
            ->where('semester', $semester)
            ->with('tpAssignation', 'tdAssignation', 'cmAssignation')
            ->get();

        return view('emploi.create', compact('filiere', 'semester', 'modules'));
    }

    public function store(Request $request)
    {
        $timeSlots = [
            ['start' => '08:30:00', 'end' => '10:30:00'],
            ['start' => '10:30:00', 'end' => '12:30:00'],
            ['start' => '14:30:00', 'end' => '16:30:00'],
            ['start' => '16:30:00', 'end' => '18:30:00'],
        ];
        $startTimes = array_column($timeSlots, 'start');
        $endTimes = array_column($timeSlots, 'end');

        $validated = $request->validate([
            'filiere_id' => 'required|exists:filieres,id',
            'semester' => 'required|integer|between:1,6',
            'is_active' => 'nullable|boolean',
            'seances' => 'nullable|array',
            'seances.*.module_id' => 'required|exists:modules,id',
            'seances.*.type' => 'required|in:CM,TD,TP',
            'seances.*.jour' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi',
            'seances.*.heure_debut' => ['required', 'date_format:H:i:s', 'in:' . implode(',', $startTimes)],
            'seances.*.heure_fin' => ['required', 'date_format:H:i:s', 'in:' . implode(',', $endTimes), 'after:seances.*.heure_debut'],
            'seances.*.salle' => 'nullable|string|max:50',
            'seances.*.groupe' => 'nullable|string|max:20',
        ]);

        $existingEmploi = Emploi::where('filiere_id', $validated['filiere_id'])
            ->where('semester', $validated['semester'])
            ->first();

        if ($existingEmploi) {
            return back()->withInput()->with('error', 'Un emploi du temps existe déjà pour ce semestre.');
        }



        $month = now()->month;
        $year = now()->year;

        $academicYear = ($month >= 9)
            ? $year . '-' . ($year + 1)
            : ($year - 1) . '-' . $year;

        $emploi = Emploi::create([
            'filiere_id' => $validated['filiere_id'],
            'semester' => $validated['semester'],
            'name' => 'Emploi du Temps S' . $validated['semester'] . " F" . $validated['filiere_id'] . " " . $academicYear,
            'is_active' => $validated['is_active'] ?? true,
            'file_path' => null,
        ]);

        coord_action::create([
            'user_id' => auth()->id(),
            'action_type' => 'create',
            'target_table' => 'emplois',
            'target_id' => $emploi->id,
            'description' => "Création de l'emploi: {$emploi->name}"
        ]);

        $successCount = 0;
        $errors = [];
        $conflictDetails = [];

        if (!empty($validated['seances'])) {
            foreach ($validated['seances'] as $index => $seance) {
                try {
                    // Validate 4-hour session
                    $duration = (strtotime($seance['heure_fin']) - strtotime($seance['heure_debut'])) / 3600;
                    if ($duration == 4 && $seance['heure_debut'] === '16:30:00') {
                        $errors[] = "Séance $index: Une séance de 4 heures ne peut pas commencer à 16:30.";
                        $conflictDetails[] = [
                            'index' => $index,
                            'message' => "Séance de 4 heures ne peut pas commencer à 16:30",
                            'seance' => $seance
                        ];
                        continue;
                    }

                    // Check for conflicts
                    $conflict = Seance::where('emploi_id', $emploi->id)
                        ->where('jour', $seance['jour'])
                        ->where('heure_debut', $seance['heure_debut'])
                        ->where(function ($query) use ($seance) {
                            $query->where('salle', $seance['salle'])
                                ->orWhere('module_id', $seance['module_id']);
                        })
                        ->exists();

                    if ($conflict) {
                        $errors[] = "Séance $index: Conflit détecté pour {$seance['jour']} à {$seance['heure_debut']}";
                        $conflictDetails[] = [
                            'index' => $index,
                            'message' => "Conflit de salle ou module",
                            'seance' => $seance
                        ];
                        continue;
                    }

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
                    $errors[] = "Séance $index: Erreur - " . $e->getMessage();
                    Log::error("Failed to create seance at index $index", [
                        'seance' => $seance,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }
        }

        if (!empty($errors)) {
            // Store the conflicts in session to display them
            return back()
                ->withInput()
                ->with('conflicts', $conflictDetails)
                ->with('warning', "Emploi du temps créé mais avec des erreurs: " . implode('; ', $errors));
        }

        coord_action::create([
            'user_id' => auth()->id(),
            'action_type' => 'create',
            'target_table' => 'seances',
            'target_id' => $emploi->semester,
            'description' => "Création de séances: {$successCount} pour le emploie: {$emploi->name}"
        ]);

        return redirect()->route('emploi.index')->with('success', "Emploi du temps créé avec succès ! $successCount séance(s) ajoutée(s).");
    }

    public function edit(Emploi $emploi)
    {
        $user = Auth::user();
        $filiere = $user->manage;

        if ($emploi->filiere_id !== $filiere->id) {
            return redirect()->route('emploi.index')->with('error', 'Accès non autorisé.');
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
            return redirect()->route('emploi.index')->with('error', 'Accès non autorisé.');
        }

        $timeSlots = [
            ['start' => '08:30:00', 'end' => '10:30:00'],
            ['start' => '10:30:00', 'end' => '12:30:00'],
            ['start' => '14:30:00', 'end' => '16:30:00'],
            ['start' => '16:30:00', 'end' => '18:30:00'],
        ];
        $startTimes = array_column($timeSlots, 'start');
        $endTimes = array_column($timeSlots, 'end');

        $validated = $request->validate([
            'filiere_id' => 'required|exists:filieres,id',
            'semester' => 'required|integer|between:1,6',
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
            'seances' => 'nullable|array',
            'seances.*.module_id' => 'required|exists:modules,id',
            'seances.*.type' => 'required|in:CM,TD,TP',
            'seances.*.jour' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi',
            'seances.*.heure_debut' => ['required', 'date_format:H:i:s', 'in:' . implode(',', $startTimes)],
            'seances.*.heure_fin' => ['required', 'date_format:H:i:s', 'in:' . implode(',', $endTimes), 'after:seances.*.heure_debut'],
            'seances.*.salle' => 'nullable|string|max:50',
            'seances.*.groupe' => 'nullable|string|max:20',
        ]);

        $emploi->update([
            'name' => $validated['name'],
            'is_active' => $validated['is_active'] ?? false,
        ]);

        Log::info('Seances data in update:', ['seances' => $validated['seances'] ?? [], 'emploi_id' => $emploi->id]);

        $emploi->seances()->delete();

        $successCount = 0;
        $errors = [];

        if (!empty($validated['seances'])) {
            foreach ($validated['seances'] as $index => $seance) {
                try {
                    // Validate 4-hour session
                    $duration = (strtotime($seance['heure_fin']) - strtotime($seance['heure_debut'])) / 3600;
                    if ($duration == 4 && $seance['heure_debut'] === '16:30:00') {
                        $errors[] = "Séance $index: Une séance de 4 heures ne peut pas commencer à 16:30.";
                        continue;
                    }

                    // Check for conflicts
                    $conflict = Seance::where('emploi_id', $emploi->id)
                        ->where('jour', $seance['jour'])
                        ->where('heure_debut', $seance['heure_debut'])
                        ->where('salle', $seance['salle'])
                        ->exists();

                    if ($conflict) {
                        $errors[] = "Séance $index: Conflit de salle pour {$seance['jour']} à {$seance['heure_debut']} dans {$seance['salle']}.";
                        continue;
                    }

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
                    $errors[] = "Séance $index: Erreur - " . $e->getMessage();
                    Log::error("Failed to update seance at index $index", [
                        'seance' => $seance,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }
        }

        $message = "Emploi du temps mis à jour avec succès ! $successCount séance(s) ajoutée(s).";
        if (!empty($errors)) {
            $message .= ' Erreurs: ' . implode('; ', $errors);
            return redirect()->route('emploi.index')->with('warning', $message);
        }
        coord_action::create(['user_id' => auth()->id(), 'action_type' => 'update', 'target_table' => 'emplois', 'target_id' => $emploi->id, 'description' => "Mise à jour de séances: {$successCount} pour l'emploi:  {$emploi->name}"]);
        return redirect()->route('emploi.index')->with('success', $message);
    }

    public function destroy(Emploi $emploi)
    {
        $user = Auth::user();
        if ($emploi->filiere_id !== $user->manage->id) {
            return redirect()->route('emploi.index')->with('error', 'Accès non autorisé.');
        }

        $emploi->delete();
        coord_action::create(['user_id' => auth()->id(), 'action_type' => 'delete', 'target_table' => 'emplois', 'target_id' => $emploi->id, 'description' => "Suppression de l'emploi: {$emploi->name}"]);
        return redirect()->route('emploi.index')->with('success', 'Emploi du temps supprimé avec succès.');
    }

    public function prof(Request $request)
    {
        $user = Auth::user();
        $filiere = $user->manage;

        $professors = User::whereHas('assignments', function ($query) use ($filiere) {
            $query->whereHas('module', function ($q) use ($filiere) {
                $q->where('filiere_id', $filiere->id);
            });
        })->orderBy('lastname')->get();

        $prof_id = $request->query('prof_id');
        $seances = collect();

        if ($prof_id) {
            $professor = User::where('id', $prof_id)
                ->whereHas('assignments', function ($query) use ($filiere) {
                    $query->whereHas('module', function ($q) use ($filiere) {
                        $q->where('filiere_id', $filiere->id);
                    });
                })->first();

            if (!$professor) {
                return redirect()->route('emploi.prof')->with('error', 'Professeur non autorisé.');
            }

            $seances = Seance::with(['module.assignments', 'emploi.filiere'])
                ->whereHas('module.assignments', function ($query) use ($prof_id) {
                    $query->where('prof_id', $prof_id)
                        ->where(function ($q) {
                            $q->where('teach_cm', true)
                                ->orWhere('teach_td', true)
                                ->orWhere('teach_tp', true);
                        });
                })
                ->whereHas('emploi', function ($query) use ($filiere) {
                    $query->where('filiere_id', $filiere->id)
                        ->where('is_active', true);
                })
                ->whereHas('module.assignments', function ($query) use ($prof_id) {
                    $query->where('prof_id', $prof_id)
                        ->whereRaw('(seances.type = "CM" AND assignments.teach_cm = true) OR
                                    (seances.type = "TD" AND assignments.teach_td = true) OR
                                    (seances.type = "TP" AND assignments.teach_tp = true)');
                })
                ->get();

            Log::info('Professor seances fetched:', [
                'prof_id' => $prof_id,
                'seance_count' => $seances->count(),
            ]);
        }

        return view('emploi.prof', compact('professors', 'prof_id', 'seances'));
    }

    public function myTimetable(Request $request)
    {
        $user = Auth::user();

        $seances = Seance::with(['module.assignments', 'emploi.filiere'])
            ->whereHas('module.assignments', function ($query) use ($user) {
                $query->where('prof_id', $user->id)
                    ->where(function ($q) {
                        $q->where('teach_cm', true)
                            ->orWhere('teach_td', true)
                            ->orWhere('teach_tp', true);
                    });
            })
            ->whereHas('emploi', function ($query) {
                $query->where('is_active', true);
            })
            ->whereHas('module.assignments', function ($query) use ($user) {
                $query->where('prof_id', $user->id)
                    ->whereRaw('(seances.type = "CM" AND assignments.teach_cm = true) OR
                                (seances.type = "TD" AND assignments.teach_td = true) OR
                                (seances.type = "TP" AND assignments.teach_tp = true)');
            })
            ->get();

        Log::info('Professor seances fetched', [
            'user_id' => $user->id,
            'seance_count' => $seances->count(),
        ]);

        $prof_id = $user->id;

        return view('emploi.prof', compact('seances', 'prof_id'));
    }

    public function myTimetableExport(Request $request)
    {
        $user = Auth::user();
        if (!$user->isProfessor() && !$user->isvacataire()) {
            Log::warning('Unauthorized access to my-timetable export', ['user_id' => $user->id]);
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        Log::info('Starting myTimetableExport', ['user_id' => $user->id]);

        $seances = Seance::with(['module.assignments', 'emploi.filiere'])
            ->whereHas('module.assignments', function ($query) use ($user) {
                $query->where('prof_id', $user->id)
                    ->where(function ($q) {
                        $q->where('teach_cm', true)
                            ->orWhere('teach_td', true)
                            ->orWhere('teach_tp', true);
                    });
            })
            ->whereHas('emploi', function ($query) {
                $query->where('is_active', true);
            })
            ->whereHas('module.assignments', function ($query) use ($user) {
                $query->where('prof_id', $user->id)
                    ->whereRaw('(seances.type = "CM" AND assignments.teach_cm = true) OR
                                (seances.type = "TD" AND assignments.teach_td = true) OR
                                (seances.type = "TP" AND assignments.teach_tp = true)');
            })
            ->get();

        Log::info('Professor seances fetched for export', [
            'user_id' => $user->id,
            'seance_count' => $seances->count(),
        ]);

        return Excel::download(
            new ProfessorTimetableExport($seances, $user),
            'timetable-' . str_replace(' ', '-', $user->fullname) . '.xlsx'
        );
    }

    public function exportFiliereTimetable(Request $request, Emploi $emploi)
    {
        $user = Auth::user();
        if ($emploi->filiere_id !== $user->manage->id) {
            return redirect()->route('emploi.index')->with('error', 'Accès non autorisé.');
        }

        $seances = Seance::with(['module', 'emploi.filiere'])
            ->where('emploi_id', $emploi->id)
            ->get();

        return Excel::download(
            new FiliereTimetableExport($seances, $emploi),
            'timetable-filiere-' . $emploi->filiere->name . '-S' . $emploi->semester . '.xlsx'
        );
    }
}

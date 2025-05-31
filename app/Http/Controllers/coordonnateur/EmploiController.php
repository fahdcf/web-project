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


    public function prof(Request $request)
    {
        $user = Auth::user();
        $filiere = $user->manage;

        // Get professors with assignments in the filiere
        $professors = User::whereHas('assignments', function ($query) use ($filiere) {
            $query->whereHas('module', function ($q) use ($filiere) {
                $q->where('filiere_id', $filiere->id);
            });
        })->orderBy('lastname')->get();

        $prof_id = $request->query('prof_id');
        $seances = collect();

        if ($prof_id) {
            // Validate prof_id belongs to the filiere's assignments
            $professor = User::where('id', $prof_id)
                ->whereHas('assignments', function ($query) use ($filiere) {
                    $query->whereHas('module', function ($q) use ($filiere) {
                        $q->where('filiere_id', $filiere->id);
                    });
                })->first();

            if (!$professor) {
                return redirect()->route('emploi.prof')->with('error', 'Professeur non autorisé.');
            }

            // Fetch seances for the professor's assigned modules
            $seances = Seance::whereHas('module.assignments', function ($query) use ($prof_id) {
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
                        ->whereRaw('
                          (seances.type = "CM" AND assignments.teach_cm = true) OR
                          (seances.type = "TD" AND assignments.teach_td = true) OR
                          (seances.type = "TP" AND assignments.teach_tp = true)
                      ');
                })
                ->with(['module', 'emploi.filiere'])
                ->get();

            Log::info('Professor seances fetched:', [
                'prof_id' => $prof_id,
                'seance_count' => $seances->count(),
                'sql' => Seance::whereHas('module.assignments', function ($query) use ($prof_id) {
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
                            ->whereRaw('
                              (seances.type = "CM" AND assignments.teach_cm = true) OR
                              (seances.type = "TD" AND assignments.teach_td = true) OR
                              (seances.type = "TP" AND assignments.teach_tp = true)
                          ');
                    })
                    ->toSql(),
            ]);
        }

        return view('emploi.prof', compact('professors', 'prof_id', 'seances'));
    }




    public function myTimetable(Request $request)
    {
        $user = Auth::user();

        // Fetch seances for the professor's assigned modules
        $seancesQuery = Seance::whereHas('module.assignments', function ($query) use ($user) {
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
                    ->whereRaw('
                  (seances.type = "CM" AND assignments.teach_cm = true) OR
                  (seances.type = "TD" AND assignments.teach_td = true) OR
                  (seances.type = "TP" AND assignments.teach_tp = true)
              ');
            })
            ->with(['module', 'emploi.filiere']);

        // Log the seances query
        Log::info('My timetable seances query', [
            'sql' => $seancesQuery->toSql(),
            'bindings' => $seancesQuery->getBindings()
        ]);

        $seances = $seancesQuery->get();

        Log::info('Professor seances fetched', [
            'user_id' => $user->id,
            'seance_count' => $seances->count()
        ]);

        // Pass prof_id to view for consistency
        $prof_id = $user->id;

        return view('emploi.prof', compact('seances', 'prof_id'));
    }
    ///////////////////////////////////////////////////////////

    public function myTimetableExport(Request $request)
    {
        $user = Auth::user();

        // Check if user is a professor or vacataire
        if (!$user->isProfessor() && !$user->isvacataire()) {
            Log::warning('Unauthorized access to my-timetable export', ['user_id' => $user->id]);
            return redirect()->route('home')->with('error', 'Accès non autorisé. Seuls les professeurs peuvent exporter leur emploi du temps.');
        }

        // Log start of method
        Log::info('Starting myTimetableExport method', ['user_id' => $user->id]);

        // Fetch seances for the professor's assigned modules
        $seancesQuery = Seance::whereHas('module.assignments', function ($query) use ($user) {
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
                    ->whereRaw('
                  (seances.type = "CM" AND assignments.teach_cm = true) OR
                  (seances.type = "TD" AND assignments.teach_td = true) OR
                  (seances.type = "TP" AND assignments.teach_tp = true)
              ');
            })
            ->with(['module', 'emploi.filiere']);

        // Log the seances query
        Log::info('My timetable export seances query', [
            'sql' => $seancesQuery->toSql(),
            'bindings' => $seancesQuery->getBindings()
        ]);

        $seances = $seancesQuery->get();

        Log::info('Professor seances fetched for export', [
            'user_id' => $user->id,
            'seance_count' => $seances->count()
        ]);

        // Render HTML view
        $html = view('emploi.export_prof', [
            'seances' => $seances,
            'professor' => $user,
            'timeSlots' => [
                ['start' => '08:30:00', 'end' => '10:30:00'],
                ['start' => '10:30:00', 'end' => '12:30:00'],
                ['start' => '14:30:00', 'end' => '16:30:00'],
                ['start' => '16:30:00', 'end' => '18:30:00']
            ],
            'days' => ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']
        ])->render();

        // Return HTML as downloadable file
        return response()->make($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="timetable-' . str_replace(' ', '-', $user->fullname) . '.html"');
    }



    // /////////////////////////////////////////////////////////////////////////////////////


    // public function export(Emploi $emploi)
    // {
    //     $user = Auth::user();
    //     if ($emploi->filiere_id !== $user->manage->id) {
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
    //         'filiere' => $user->manage,
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

<?php

namespace App\Http\Controllers\coordonnateur;

use \Log;
use App\Http\Controllers\Controller;
use App\Models\Emploi;
use App\Models\Module;
use App\Models\Schedule;
use App\Models\ScheduleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as logd;

class ScheduleBuilderController extends Controller
{
    /**
     * Affiche l'interface de création d'emploi du temps
     */
    public function index(Request $request)
    {
        // Récupérer la filière du coordinateur
        $filiere_id = auth()->user()->manage->id;

        // Récupérer le semestre sélectionné ou utiliser 1 par défaut
        $semester = $request->input('semester', 1);

        // Récupérer tous les modules de cette filière pour ce semestre
        $modules = Module::where('filiere_id', $filiere_id)
            ->where('semester', $semester)
            ->get();

        // Créer les plages horaires (de 8h à 18h)
        $timeSlots = [];
        for ($hour = 8; $hour <= 18; $hour++) {
            $timeSlots[] = sprintf('%02d:00', $hour);
        }

        // Jours de la semaine
        $days = [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi',
        ];

        return view('schedules.builder', compact('modules', 'timeSlots', 'days', 'semester'));
    }

    // Modifier la méthode saveSession

    /**
     * Sauvegarde une séance dans l'emploi du temps
     */
    public function saveSession(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'module_id' => 'required|exists:modules,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|numeric|min:0.5',
            'group_type' => 'required|in:cm,td,tp',
            'group_number' => 'nullable|integer',
            'location' => 'nullable|string',
        ]);

        try {
            // Vérifier si une séance existe déjà à cet emplacement
            $existingItem = ScheduleItem::where('schedule_id', $request->schedule_id)
                ->where('day_of_week', $request->day_of_week)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                        ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('start_time', '<=', $request->start_time)
                                ->where('end_time', '>=', $request->end_time);
                        });
                });

            // Exclure l'élément en cours d'édition
            if ($request->item_id) {
                $existingItem->where('id', '!=', $request->item_id);
            }

            $existingItem = $existingItem->first();

            if ($existingItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Il existe déjà une séance à cet horaire.'
                ]);
            }

            // Créer ou mettre à jour la séance
            $item = ScheduleItem::updateOrCreate(
                [
                    'id' => $request->item_id ?? null
                ],
                [
                    'schedule_id' => $request->schedule_id,
                    'module_id' => $request->module_id,
                    'day_of_week' => $request->day_of_week,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'duration' => $request->duration,
                    'group_type' => $request->group_type,
                    'group_number' => $request->group_number,
                    'location' => $request->location,
                ]
            );

            return response()->json([
                'success' => true,
                'item' => $item,
                'message' => 'Séance enregistrée avec succès.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la sauvegarde de la séance: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la sauvegarde de la séance: ' . $e->getMessage()
            ], 500);
        }
    }
    // Modifier la méthode createSchedule

    /**
     * Crée un nouvel emploi du temps
     */

    public function createSchedule(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'semester' => 'required|integer',
            'academic_year' => 'required|string',
        ]);

        try {
            $schedule = Emploi::create([
                'name' => $request->name,
                'semester' => $request->semester,
                'academic_year' => $request->academic_year,
                'filiere_id' => auth()->user()->filiere_id,
                'is_active' => true,
            ]);

            return response()->json([
                'success' => true,
                'schedule' => $schedule,
                'message' => 'Emploi du temps créé avec succès.'
            ]);
        } catch (\Exception $e) {
            logd::error('Erreur lors de la création de l\'emploi du temps: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création de l\'emploi du temps: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprime une séance
     */
    public function deleteSession(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:schedule_items,id',
        ]);

        $item = ScheduleItem::findOrFail($request->item_id);
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Séance supprimée avec succès.'
        ]);
    }
}

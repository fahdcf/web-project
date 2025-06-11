<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\prof_request;
use App\Models\Seance;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessorController extends Controller
{


    public function dashboard()
    {

        $tasks = Task::where('user_id', auth()->user()->id)->latest()->take(5)->get();

        $user = Auth::user();
        $totalStudents = 142; // Replace with query to count students in professor's courses
        $totalCourses = Module::whereHas('assignments', fn($q) => $q->where('prof_id', $user->id))->count();
        $pendingGrades = 3; // Replace with query for pending grade submissions
        $upcomingClasses = Seance::whereHas('module.assignments', fn($q) => $q->where('prof_id', $user->id))
            ->where('jour', '>=', now()->startOfWeek())
            ->count();
        $courses = Module::whereHas('assignments', fn($q) => $q->where('prof_id', $user->id))->get();
        $upcomingSeances = Seance::with('module')
            ->whereHas('module.assignments', fn($q) => $q->where('prof_id', $user->id))
            ->where('jour', '>=', now())
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->take(3)
            ->get();

        $modules = Module::whereHas('assignments', fn($q) => $q->where('prof_id', $user->id))
            ->with('assignments')
            ->get();

        // Initialize schedule data
        $scheduleData = [
            'Lundi' => 0,
            'Mardi' => 0,
            'Mercredi' => 0,
            'Jeudi' => 0,
            'Vendredi' => 0,
            'Samedi' => 0,
        ];

        // Fetch seances for the vacataire
        $seances = Seance::with('module')
            ->whereIn('module_id', $modules->pluck('id'))
            ->whereHas('emploi', fn($q) => $q->where('is_active', true))
            ->whereIn('jour', array_keys($scheduleData))
            ->get();

        // Calculate hours per day
        foreach ($seances as $seance) {
            $day = $seance->jour;
            if (array_key_exists($day, $scheduleData)) {
                $duration = (strtotime($seance->heure_fin) - strtotime($seance->heure_debut)) / 3600;
                $scheduleData[$day] += max($duration, 0); // Prevent negative durations
            }
        }

        // Convert to array for Chart.js
        $scheduleData = array_values($scheduleData);

        return view('professor.index', compact('scheduleData','tasks', 'totalStudents', 'totalCourses', 'pendingGrades', 'upcomingClasses', 'courses', 'upcomingSeances'));
    }



    public function myRequests()
    {
        // $module_requests = prof_request::whereIn('module_id', $FilieretargetIDs)->get();
        $module_requests = prof_request::with('prof')->where('prof_id', auth()->user()->id)->get();

        return view('professor.mes_requests', [
            'module_requests' => $module_requests,

        ]);
    }




    // public function mesModules()
    // {


    //     $user = auth()->user();
    //     $modules = $user->assignedModules()->with('filiere')
    //         ->get();


    //     return view('modules.mesModules', [
    //         'modules' => $modules
    //     ]);
    // }

    public function mesModules()
    {
        $professor = auth()->user();

        $modules = $professor->assignedModules()
            ->with('filiere') // Chargement anticipé de la filière
            ->where('status', true)
            ->orderBy('semester')
            ->get();

        // $modules = Module::where('professor_id',$professor->id)
        //     ->with('filiere') // Chargement anticipé de la filière
        //     ->orderBy('semester')
        //     ->get();

        return view('modules.mesModules', [
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

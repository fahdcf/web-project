<?php

namespace App\Http\Controllers\coordonnateur;

use App\export\GroupesExport;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Deadline;

use App\Models\Filiere;
use App\Models\Group;
use App\Models\Groupe;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GroupeController extends Controller
{
    // Helper method to determine current/next semester (autom , printemps)
    public static function currentSemesterInfo(): array
    {
        $month = now()->month;
        $year = now()->year;

        // Calcul de l'année académique (ex: 2023-2024)
        $academicYear = ($month >= 9)
            ? $year . '-' . ($year + 1)
            : ($year - 1) . '-' . $year;

        // Détermination du semestre actuel
        if ($month >= 9 || $month == 1) {
            // Semestre Automne (S1, S3 ou S5)
            $semesterType = 'AUTOMNE';
        } else {
            // Semestre Printemps (S2, S4 ou S6)
            $semesterType = 'PRINTEMPS';
        }

        return [
            'academic_year' => $academicYear,
            'semester_type' => $semesterType,
            'semester_number' => $semesterType == 'AUTOMNE' ? 1 : 2,
        ];
    }

    private function nextSemesterInfos()
    {
        $current = $this->currentSemesterInfo();

        $yearAca = explode('-', $current['academic_year']); // Nouvelle année académique

        // Logique pour déterminer le semestre suivant
        if ($current['semester_type'] === 'AUTOMNE') {
            return [
                'semester_type' => 'PRINTEMPS',
                'academic_year' => $yearAca[0] . "-" . $yearAca[1], // Même année académique
                'semester_number' => 2,


            ];
        } else {

            $yearAca[0]++;
            $yearAca[1]++;

            return [
                'semester_type' => 'AUTOMNE',
                'academic_year' => $yearAca[0] . "-" . $yearAca[1], //
                'semester_number' => 1,

            ];
        }
    }


    //////////////////////////////////////////////////////////////////////////////////
    //pages
    

    public function next_semester(Request $request)
    {

        $filiere = Auth::user()->manage;
        $semesterData = $this->nextSemesterInfos();

        $targetSemesters = $semesterData['semester_type'] == 'AUTOMNE' ? [1, 3, 5] : [2, 4, 6];

        $query = Module::where('filiere_id', $filiere->id)
            ->whereIn('semester', $targetSemesters)
            ->with(['responsable', 'profTd', 'profTp']);


        $modules = $query->get()->groupBy('semester')->sortKeys();


        $deadline = Deadline::where('type', 'groupes_configuration')
            ->where(fn($q) => $q->where('filiere_id', $filiere->id)->orWhereNull('filiere_id'))
            ->first();
        $progress = $this->calculateProgress($modules, $filiere->id);


        return view('groupes.semester_groupes', compact(
            'deadline',
            'progress',

            
            'filiere',
            'semesterData',
            'modules'
        ));
    }

    public function current_semester(Request 
    
    $request)
    {
        $filiere = Auth::user()->manage;
        $semesterData = $this->currentSemesterInfo();

        $targetSemesters = $semesterData['semester_type'] == 'AUTOMNE' ? [1, 3, 5] : [2, 4, 6];

        $query = Module::where('filiere_id', $filiere->id)
            ->whereIn('semester', $targetSemesters)
            ->with(['responsable', 'profTd', 'profTp']);


        $modules = $query->get()->groupBy('semester')->sortKeys();

        return view('groupes.semester_groupes', compact(
            'filiere',
            'semesterData',
            'modules'
        ));
    }


    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'semester' => 'required|integer|between:1,6',
            'nb_groupes_td' => 'required|integer|min:0|max:10',
            'nb_groupes_tp' => 'required|integer|min:0|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $filiere = Filiere::where('coordonnateur_id', $user->id)->firstOrFail();
        $semester = $request->input('semester');
        $nbGroupesTd = $request->input('nb_groupes_td');
        $nbGroupesTp = $request->input('nb_groupes_tp');

        Module::where('filiere_id', $filiere->id)
            ->where('semester', $semester)
            ->update([
                'nbr_groupes_td' => $nbGroupesTd,
                'nbr_groupes_tp' => $nbGroupesTp,
            ]);

        return redirect()->back()
            ->with('success', 'Configuration des groupes pour le semestre S' . $semester . ' enregistrée.');
    }

    public function saveModule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'module_id' => 'required|exists:modules,id',
            'nb_groupes_td' => 'required|integer|min:0|max:10',
            'nb_groupes_tp' => 'required|integer|min:0|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $filiere = Filiere::where('coordonnateur_id', $user->id)->firstOrFail();
        $module = Module::findOrFail($request->input('module_id'));

        if ($module->filiere_id !== $filiere->id) {
            return redirect()->back()->with('error', 'Accès non autorisé à ce module.');
        }

        $module->update([
            'nbr_groupes_td' => $request->input('nb_groupes_td'),
            'nbr_groupes_tp' => $request->input('nb_groupes_tp'),
        ]);

        return redirect()->back()
            ->with('success', 'Configuration des groupes pour le module ' . $module->name . ' enregistrée.');
    }



    public function export(Request $request)
    {
        $semester = $request->query('semester', 'all');
        $user = Auth::user();
        $filiere = Filiere::where('coordonnateur_id', $user->id)->firstOrFail();

        $query = Module::where('filiere_id', $filiere->id)
            ->with(['responsable', 'profCours', 'profTd', 'profTp']);

        if ($semester !== 'all') {
            $query->where('semester', $semester);
        }

        $modules = $query->get();

        $filename = 'groupes_configuration_' . ($semester === 'all' ? 'all_semesters' : 'S' . $semester) . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new GroupesExport($modules), $filename);
    }




    protected function calculateProgress($modules, $filiereId)
    {
        $total = 0;
        $configured = 0;
        foreach ($modules as $semesterModules) {
            $total += $semesterModules->count();
            $configured += $semesterModules->filter(fn($module) => 
                $module->nbr_groupes_td > 0 || $module->nbr_groupes_tp > 0)->count();
        }
        return ['configured' => $configured, 'total' => $total];
    }

    protected function applyDefaults($filiereId)
    {
        $modules = Module::where('filiere_id', $filiereId)->get();
        foreach ($modules as $module) {
            if ($module->nbr_groupes_td == 0 && $module->nbr_groupes_tp == 0) {
                $module->update([
                    'nbr_groupes_td' => $module->nbr_groupes_td ?? 0,
                    'nbr_groupes_tp' => $module->nbr_groupes_tp ?? 0,
                ]);
            }
        }
    }
}

<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Imports\NotesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Module;

class NoteController extends Controller
{


    public function showUploadForm(){

        $modules=Module::where('professor_id',auth()->user()->id)->get();
        return view('professor.upload_notes',compact('modules'));
    }
    public function upload(Request $request)
    {
        // dd($request);
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'session_type' => 'required|in:normale,rattrapage',
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        try {
            $import = new NotesImport(
                $request->module_id,
                $request->session_type
            );

            Excel::import($import, $request->file('file'));

            // Get module info for success message
            $module = Module::find($request->module_id);
            $semester = $module->semester;

            $message = "Notes importées avec succès pour le module {$module->name} (Semestre {$semester}, Session {$request->session_type})";

            if ($import->getErrors()) {
                $errors = $import->getErrors();
                $errorCount = count($errors);
                $successCount = $import->getRowCount() - $errorCount;
                
                $message .= "<br>{$successCount} réussites, {$errorCount} erreurs";
                
                // Format errors for display
                $errorDetails = array_map(function($error) {
                    return "Ligne {$error['row']} (CNE: {$error['cne']}): {$error['message']}";
                }, $errors);
                
                return back()
                    ->with('success', $message)
                    ->with('error_details', $errorDetails);
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', "Erreur lors de l'importation: " . $e->getMessage());
        }
    }
}
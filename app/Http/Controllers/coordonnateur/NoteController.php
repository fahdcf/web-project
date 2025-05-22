<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Imports\NotesImport;
use App\Models\Groupe;
use App\Models\Module;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class NoteController extends Controller
{


    public function showUploadForm()
    {


        $user = auth()->user();
        $modules = $user->assignedModules()->with('filiere')
            ->get();


        $uploads = Note::where('prof_id', auth()->id())
            ->with(['module'])
            ->latest()
            ->paginate(10);


        return view('modules.upload_notes', compact('modules', 'uploads'));
    }


    public function upload(Request $request)
    {
        // // dd($request);
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'session_type' => 'required|in:normale,rattrapage',
            'file' => 'required|file|mimes:xlsx,xls'
        ]);


        $module = Module::findOrFail($request->module_id);
        $semester = $module->semester;


        $file = $request->file('file');
        $filePath = $file->store('notes_uploads', 'public');


        // Record the upload int notes table
        Note::create([
            'module_id' => $request->module_id,
            'prof_id' => auth()->user()->id,
            'session_type' => $request->session_type,
            'storage_path' => $filePath,
            'original_name' => $file->getClientOriginalName(),
            'semester' => $module->semester,





        ]);


        $message = "Notes importées avec succès pour le module {$module->name} (Semestre {$semester}, Session {$request->session_type})";


        return back()->with('success', $message);
    }


    public function cancel($id)
    {
        $note = Note::where('prof_id', auth()->id())->findOrFail($id);
        $note->update([
            'status' => 'canceled',
            'canceled_at' => now()
        ]);

        return back()->with('success', 'Upload annulé avec succès');
    }
}

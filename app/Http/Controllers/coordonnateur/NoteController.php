<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;
use App\Imports\NotesImport;
use App\Imports\NotesImort;
use App\Models\Groupe;
use App\Models\Module;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class NoteController extends Controller
{

    public function index()
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
    try {
        $request->validate([
            'module_id' => 'required|integer|exists:modules,id',
            'session_type' => 'required|in:normale,rattrapage',
            'file' => 'required|file|mimes:xlsx,xls|max:2048',
        ], [
            'module_id.required' => 'Veuillez sélectionner un module.',
            'module_id.exists' => 'Le module sélectionné n\'existe pas.',
            'session_type.required' => 'Veuillez sélectionner un type de session.',
            'session_type.in' => 'Le type de session doit être "normale" ou "rattrapage".',
            'file.required' => 'Veuillez sélectionner un fichier.',
            'file.mimes' => 'Le fichier doit être au format Excel (.xlsx ou .xls).',
            'file.max' => 'Le fichier ne doit pas dépasser 2 Mo.',
        ]);

        $user = auth()->user();
        if (!$user->role->isprof) {
            return redirect()->back()->with('error', 'Accès non autorisé.');
        }

        $file = $request->file('file');
        $path = $file->store('grades');
        $originalName = $file->getClientOriginalName();

        $semester = Module::findOrFail($request->module_id)->semester;

        $note = Note::create([
            'module_id' => $request->module_id,
            'prof_id' => $user->id,
            'session_type' => $request->session_type,
            'semester' => $semester,
            'storage_path' => $path,
            'original_name' => $originalName,
            'status' => 'active',
        ]);

        Excel::import(new NotesImport($user->id, $note->id, $semester, $request->session_type), $file);

        return redirect()->back()->with('success', 'Notes téléchargées avec succès.');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        $failures = $e->failures();
        $errorMessages = [];

        foreach ($failures as $failure) {
            $row = $failure->row();
            foreach ($failure->errors() as $error) {
                $errorMessages[] = "Ligne $row : $error";
            }
        }

        return redirect()->back()->with('error', implode('; ', $errorMessages));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erreur lors du téléchargement : ' . $e->getMessage());
    }
}
    public function download($id)
    {
        $upload = Note::findOrFail($id);

        // Get the file path from storage
        $path = Storage::path($upload->storage_path);

        // Force download with original filename
        return response()->download($path, $upload->original_name);
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

<?php
namespace App\Imports;

use App\Models\StudentModuleNote;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class NotesImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $professorId;
    protected $noteId;
    protected $semester;
    protected $sessionType;

    public function __construct($professorId, $noteId, $semester, $sessionType)
    {
        $this->professorId = $professorId;
        $this->noteId = $noteId;
        $this->semester = $semester;
        $this->sessionType = $sessionType;
    }

    public function model(array $row)
    {
        $student = Student::where('CNE', $row['cne'])->first();

        if ($student && isset($row['module_id']) && isset($row['note'])) {
            return StudentModuleNote::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'module_id' => $row['module_id'],
                    'session_type' => $this->sessionType,
                    'semester' => $this->semester,
                ],
                [
                    'note_id' => $this->noteId,
                    'note' => $row['note'],
                    'remarque' => $row['remarque'] ?? null, // Nullable remarque
                ]
            );
        }

        return null; // Skip invalid rows
    }

    public function rules(): array
    {
        return [
            'cne' => ['required', 'string'],
            // 'module_id' => ['required', 'integer', Rule::exists('modules', 'id')],
            'note' => ['required', 'numeric', 'between:0,20'],
            'remarque' => ['nullable', 'string', 'max:255'], // Nullable, max length for safety
        ];
    }

    public function customValidationMessages()
    {
        return [
            'cne.required' => 'La colonne CNE est requise.',
            // 'cne.exists' => 'Le CNE :input n\'existe pas dans la liste des étudiants.',
            // 'module_id.required' => 'La colonne module_id est requise.',
            // 'module_id.exists' => 'L\'ID du module :input n\'existe pas.',
            'note.required' => 'La colonne note est requise.',
            'note.numeric' => 'La note doit être un nombre.',
            'note.between' => 'La note doit être comprise entre 0 et 20.',
            'remarque.string' => 'La remarque doit être une chaîne de caractères.',
            'remarque.max' => 'La remarque ne peut pas dépasser 255 caractères.',
        ];
    }
}
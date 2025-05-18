<?php

namespace App\Imports;

use App\Models\Note;
use App\Models\Student;
use App\Models\Module;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;

class NotesImport implements ToCollection, WithHeadingRow
{
    protected $moduleId;
    protected $sessionType;
    protected $errors = [];

    public function __construct($moduleId, $sessionType)
    {
        $this->moduleId = $moduleId;
        $this->sessionType = $sessionType;
    }

    public function collection(Collection $rows)
    {
        // Get semester from module
        $module = Module::findOrFail($this->moduleId);
        $semester = $module->semester;

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +2 because of header row and 0-based index

            try {
                // Validate required fields
                if (!isset($row['cne']) ){
                    throw new \Exception("Colonne CNE manquante");
                }

                if (!isset($row['note'])) {
                    throw new \Exception("Colonne Note manquante");
                }

                // Trim and validate CNE
                $cne = trim($row['cne']);
                if (empty($cne)) {
                    throw new \Exception("CNE ne peut pas être vide");
                }

                // Find student by CNE
                $student = Student::where('cne', $cne)->first();
                
                if (!$student) {
                    throw new \Exception("Étudiant non trouvé");
                }

                // Validate and format note
                $noteValue = $this->validateNote($row['note']);

                // Create or update note
                Note::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'module_id' => $this->moduleId,
                        'semester' => $semester,
                        'session_type' => $this->sessionType
                    ],
                    [
                        'note' => $noteValue,
                        'remarks' => $row['remarques'] ?? $row['remarks'] ?? null
                    ]
                );

            } catch (\Exception $e) {
                $this->errors[] = [
                    'row' => $rowNumber,
                    'cne' => $row['cne'] ?? 'N/A',
                    'message' => $e->getMessage()
                ];
            }
        }

        if (!empty($this->errors)) {
            $errorCount = count($this->errors);
            $successCount = count($rows) - $errorCount;
            
            $message = "{$successCount} notes importées avec succès, {$errorCount} erreurs.";
            throw new \Exception($message);
        }
    }

    protected function validateNote($note)
    {
        if (!is_numeric($note)) {
            throw new \Exception("La note doit être numérique");
        }

        $noteValue = floatval($note);
        
        if ($noteValue < 0 || $noteValue > 20) {
            throw new \Exception("La note doit être entre 0 et 20");
        }

        return $noteValue;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
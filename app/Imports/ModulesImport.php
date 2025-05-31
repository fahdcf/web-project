<?php

namespace App\Imports;

use App\Models\Module;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class ModulesImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $filiereId;

    public function __construct($filiereId)
    {
        $this->filiereId = $filiereId;
    }

    public function collection(Collection $rows)
    {
        // Store created modules with their temporary Excel IDs
        $createdModules = [];

        // First pass: Create modules without parent_id
        foreach ($rows as $index => $row) {
            // Skip empty rows
            if (empty(trim($row['name'] ?? ''))) {
                continue;
            }

            $attributes = [
                'name' => $row['name'],
                'semester' => $row['semester'],
                'description' => $row['description'],
                'specialty' => $row['specialty'] ?? null,
                'cm_hours' => (int) ($row['cm_hours'] ?? 0),
                'td_hours' => (int) ($row['td_hours'] ?? 0),
                'tp_hours' => (int) ($row['tp_hours'] ?? 0),
                'autre_hours' => (int) ($row['autre_hours'] ?? 0),
                'credits' => (int) $row['credits'],
                'evaluation' => (int) $row['evaluation'],
                'type' => $row['type'],
                'filiere_id' => $this->filiereId,
                'responsable_id' => null, // Always null
                'status' => 'active', // Default from schema
                'nbr_groupes_td' => 0, // Ignored
                'nbr_groupes_tp' => 0, // Ignored
            ];

            if ($row['type'] === 'element') {
                // Defer parent_id assignment to second pass
                $attributes['parent_id'] = null;
                $attributes['code'] = 'TEMP-' . uniqid(); // Temporary code
            } else {
                $attributes['parent_id'] = null;
                $attributes['code'] = 'TEMP-' . uniqid(); // Temporary code
            }

            $module = Module::create($attributes);

            // Set code for complet modules
            if ($row['type'] === 'complet') {
                $module->code = "M{$module->semester}-{$module->id}";
                $module->save();
            }

            // Store module with its temporary Excel ID
            $excelId = $row['id'] ?? ($index + 2); // Use row number if id is missing
            $createdModules[$excelId] = $module;
        }

        // Second pass: Update parent_id and code for element modules
        foreach ($rows as $index => $row) {
            if (empty(trim($row['name'] ?? '')) || $row['type'] !== 'element') {
                continue;
            }

            $excelId = $row['id'] ?? ($index + 2);
            $module = $createdModules[$excelId] ?? null;

            if ($module && !empty($row['parent_id'])) {
                $parentExcelId = $row['parent_id'];
                $parentModule = $createdModules[$parentExcelId] ?? null;

                if ($parentModule) {
                    $module->parent_id = $parentModule->id;
                    $module->code = $parentModule->code . '-' . (Module::where('parent_id', $parentModule->id)->count());
                    $module->save();
                }
            }
        }
    }

    public function rules(): array
    {
        return [
            '*.id' => ['required', 'integer', 'min:1'],
            '*.name' => ['required', 'string', 'max:255'],
            '*.semester' => ['required', 'integer', 'between:1,6'],
            '*.description' => ['required', 'string'],
            '*.cm_hours' => ['required', 'integer', 'min:0'],
            '*.td_hours' => ['required', 'integer', 'min:0'],
            '*.tp_hours' => ['required', 'integer', 'min:0'],
            '*.autre_hours' => ['nullable', 'integer', 'min:0'],
            '*.credits' => ['required', 'integer', 'min:1'],
            '*.evaluation' => ['required', 'integer', 'min:1'],
            '*.type' => ['required', Rule::in(['element', 'complet'])],
            '*.parent_id' => [
                function ($attr, $value, $fail) {
                    $rowIndex = explode('.', $attr)[0];
                    $type = $this->data[$rowIndex]['type'] ?? null;
                    if ($type === 'element' && !$value) {
                        $fail('Le champ parent_id est requis pour le type élément à la ligne :row.');
                    }
                },
            ],
            '*.specialty' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.id.required' => 'Le champ ID est requis à la ligne :row.',
            '*.id.integer' => 'Le champ ID doit être un entier à la ligne :row.',
            '*.id.min' => 'Le champ ID doit être supérieur ou égal à 1 à la ligne :row.',
            '*.name.required' => 'Le champ nom est requis à la ligne :row.',
            '*.semester.required' => 'Le champ semestre est requis à la ligne :row.',
            '*.semester.between' => 'Le semestre doit être entre 1 et 6 à la ligne :row.',
            '*.description.required' => 'Le champ description est requis à la ligne :row.',
            '*.cm_hours.required' => 'Le champ cm_hours est requis à la ligne :row.',
            '*.td_hours.required' => 'Le champ td_hours est requis à la ligne :row.',
            '*.tp_hours.required' => 'Le champ tp_hours est requis à la ligne :row.',
            '*.credits.required' => 'Le champ crédits est requis à la ligne :row.',
            '*.evaluation.required' => 'Le champ évaluation est requis à la ligne :row.',
            '*.type.required' => 'Le champ type est requis à la ligne :row.',
            '*.type.in' => 'Le type doit être "élément" ou "complet" à la ligne :row.',
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }
}

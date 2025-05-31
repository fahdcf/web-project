<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ModulesExport implements FromCollection, WithHeadings
{
    protected $modules;

    public function __construct($modules)
    {
        $this->modules = $modules;
    }

    public function collection()
    {
        $index = 1;

        // Second pass: Map data with temporary IDs and parent_id
        return $this->modules->map(function ($module) {
            return [
                'id' => $module->id,
                'name' => $module->name,
                'semester' => $module->semester,
                'description' => $module->description,
                'cm_hours' => $module->cm_hours ?? 0,
                'td_hours' => $module->td_hours ?? 0,
                'tp_hours' => $module->tp_hours ?? 0,
                'credits' => $module->credits,
                'evaluation' => $module->evaluation,
                'type' => $module->type === 'complet' ? 'complet' : 'élément',
                'specialty' => $module->specialty ?? '',
                'autre_hours' => $module->autre_hours ?? 0,
                'parent_id' => $module->parent_id ? ($module->parent_id ?? '') : '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'name',
            'semester',
            'Description',
            'cm_hours',
            'td_hours',
            'tp_hours',
            'Crédits',
            'evaluation',
            'Type',
            'specialty',
            'autre_hours',
            'parent_id',
        ];
    }
}
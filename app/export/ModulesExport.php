<?php

namespace App\export;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Filiere;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ModulesExport implements FromCollection, WithHeadings
{
    protected $modules;

    public function __construct($modules)
    {
        $this->modules = $modules;
    }

    public function collection()
    {
        return $this->modules->map(function ($module) {
            return [
                'Nom' => $module->name,
                'Code' => $module->code,
                'Semestre' => $module->semester,
                'Responsable ID' => $module->responsable_id ?? '',
                'Groupes TD' => $module->nbr_groupes_td ?? 0,
                'Groupes TP' => $module->nbr_groupes_tp ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Code',
            'Semestre',
            'Responsable ID',
            'Groupes TD',
            'Groupes TP',
        ];
    }
}


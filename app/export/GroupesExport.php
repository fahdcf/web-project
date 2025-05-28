<?php
namespace App\export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Filiere;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


// using maatwebsite/excel for Excel export.
class GroupesExport implements FromCollection, WithHeadings
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
                'Semestre' => $module->semester == 1 ? '1er Semestre' : $module->semester . 'ème Semestre',
                'Module' => $module->name,
                'Code' => $module->code,
                'Responsable' => $module->responsable ? $module->responsable->fullname : 'Non assigné',
                'Professeur CM' => $module->profCours ? $module->profCours->fullname : 'Non assigné',
                'Professeur TD' => $module->profTd ? $module->profTd->fullname : 'Non assigné',
                'Professeur TP' => $module->profTp ? $module->profTp->fullname : 'Non assigné',
                'Groupes TD' => $module->nbr_groupes_td ?? 0,
                'Groupes TP' => $module->nbr_groupes_tp ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Semestre',
            'Module',
            'Code',
            'Responsable',
            'Professeur CM',
            'Professeur TD',
            'Professeur TP',
            'Groupes TD',
            'Groupes TP',
        ];
    }

   
}

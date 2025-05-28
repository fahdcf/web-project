<?php
namespace App\Imports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Filiere;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ModulesImport implements ToModel
{
    protected $filiereId;

    public function __construct($filiereId)
    {
        $this->filiereId = $filiereId;
    }

    public function model(array $row)
    {
        // Skip header row or rows with insufficient data
        if (empty($row[0]) || $row[0] === 'Nom') {
            return null;
        }

        return new Module([
            'name' => $row[0],
            'code' => $row[1],
            'semester' => $row[2],
            'filiere_id' => $this->filiereId,
            'responsable_id' => $row[3] ?: null,
            'nbr_groupes_td' => $row[4] ?? 0,
            'nbr_groupes_tp' => $row[5] ?? 0,
        ]);
    }
}

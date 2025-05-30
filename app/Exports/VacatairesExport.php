<?php

namespace App\Exports;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class VacatairesExport implements FromCollection, WithHeadings
{
    protected $vacataires;

    public function __construct($vacataires)
    {
        $this->vacataires = $vacataires;
    }

    public function collection()
    {
        return $this->vacataires->map(function ($vacataire) {
            return [
                'ID' => $vacataire->id,
                'Nom' => $vacataire->lastname . ' ' . $vacataire->firstname,
                'Charge de travail (h)' => $vacataire->hours ?? 0,
                'Statut' => $vacataire->user_details ? ucfirst($vacataire->user_details->status) : 'Inconnu',
                'Email' => $vacataire->email,
                'Créé le' => $vacataire->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nom',
            'Charge de travail (h)',
            'Statut',
            'Email',
            'Créé le',
        ];
    }
}

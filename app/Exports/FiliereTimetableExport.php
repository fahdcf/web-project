<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class FiliereTimetableExport implements FromCollection, WithHeadings, WithStyles
{
    protected $seances;
    protected $emploi;

    public function __construct(Collection $seances, $emploi)
    {
        $this->seances = $seances;
        $this->emploi = $emploi;
    }

    public function collection()
    {
        $data = [];
        foreach ($this->seances as $seance) {
            $data[] = [
                'Jour' => $seance->jour,
                'Heure Début' => substr($seance->heure_debut, 0, 5),
                'Heure Fin' => substr($seance->heure_fin, 0, 5),
                'Module' => $seance->module->name,
                'Code' => $seance->module->code,
                'Type' => $seance->type,
                'Groupe' => $seance->groupe ?? 'N/A',
                'Salle' => $seance->salle ?? 'Non défini',
            ];
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            ['Emploi du Temps - ' . $this->emploi->filiere->name . ' S' . $this->emploi->semester],
            ['Année Académique: ' . ($this->emploi->academic_year ?? '2024-2025')],
            [],
            ['Jour', 'Heure Début', 'Heure Fin', 'Module', 'Code', 'Type', 'Groupe', 'Salle'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        $sheet->getStyle('A4:H4')->getFont()->setBold(true);
        $sheet->getStyle('A4:H4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFE0E0E0');
        $sheet->getStyle('A1:H' . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:H' . $sheet->getHighestRow())->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        return [];
    }
}
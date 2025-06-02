<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class ProfessorTimetableExport implements FromCollection, WithHeadings, WithStyles
{
    protected $seances;
    protected $professor;

    public function __construct(Collection $seances, $professor)
    {
        $this->seances = $seances;
        $this->professor = $professor;
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
                'Filière' => $seance->emploi->filiere->name,
                'Semestre' => 'S' . $seance->emploi->semester,
            ];
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            ['Emploi du Temps - ' . $this->professor->fullname],
            ['Année Académique: ' . ($this->seances->first()->emploi->academic_year ?? '2024-2025')],
            [],
            ['Jour', 'Heure Début', 'Heure Fin', 'Module', 'Code', 'Type', 'Groupe', 'Salle', 'Filière', 'Semestre'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        $sheet->getStyle('A4:J4')->getFont()->setBold(true);
        $sheet->getStyle('A4:J4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFE0E0E0');
        $sheet->getStyle('A1:J' . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:J' . $sheet->getHighestRow())->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        return [];
    }
}
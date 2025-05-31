<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emploi du Temps - {{ $professor->fullname }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #4723d9;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }
        th {
            background-color: #4723d9;
            color: white;
            font-weight: bold;
        }
        td.day {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .session {
            background-color: #e6e9ff;
            padding: 5px;
            border-radius: 4px;
            margin: 2px;
        }
        .session .type {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-size: 10px;
        }
        .session .cm { background-color: #007bff; }
        .session .td { background-color: #17a2b8; }
        .session .tp { background-color: #28a745; }
        .empty { background-color: #fff; }
    </style>
</head>
<body>
    <h1>Emploi du Temps - {{ $professor->fullname }}</h1>
    <table>
        <thead>
            <tr>
                <th>Jour</th>
                @foreach ($timeSlots as $slot)
                    <th>{{ substr($slot['start'], 0, 5) }}-{{ substr($slot['end'], 0, 5) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($days as $day)
                <tr>
                    <td class="day">{{ $day }}</td>
                    @foreach ($timeSlots as $slot)
                        <td class="{{ $seances->filter(fn($s) => $s->jour === $day && $s->heure_debut === $slot['start'])->isEmpty() ? 'empty' : '' }}">
                            @foreach ($seances->filter(fn($s) => $s->jour === $day && $s->heure_debut === $slot['start']) as $seance)
                                <div class="session">
                                    <span class="type {{ strtolower($seance->type) }}">{{ $seance->type }}</span><br>
                                    <strong>{{ $seance->module->name }}</strong><br>
                                    {{ $seance->module->code }}{{ $seance->groupe ? ' - ' . $seance->groupe : '' }}<br>
                                    Salle: {{ $seance->salle ?? 'Non défini' }}<br>
                                    {{ $seance->emploi->filiere->name }} - S{{ $seance->emploi->semester }}
                                </div>
                            @endforeach
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
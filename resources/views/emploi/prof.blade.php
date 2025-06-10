<x-coordonnateur_layout>
    <style>
        .table-container {
            background-color: white;
            width: 100%;
            display: flex;
            justify-content: center;
            overflow-y: auto;
            overflow-x: auto;
            max-height: 80vh;
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .table-container::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background-color: #aaa;
            border-radius: 10px;
        }

        .table-container::-webkit-scrollbar-track {
            background: transparent;
        }

        .schedule-grid {
            min-width: 800px;
            border-collapse: collapse;
        }

        .schedule-grid th {
            text-align: center;
            border-bottom: 1px solid #e0e0e0 !important;
            border-right: 1px solid #e0e0e0 !important;
            color: #4a4a4a;
            font-size: 14px;
            font-weight: 600;
            padding: 8px;
            background-color: #f8f9fa;
        }

        .schedule-grid th:first-child {
            border-left: none;
        }

        .schedule-grid td {
            font-size: 13px;
            color: #585858;
            text-align: center !important;
            vertical-align: top !important;
            min-height: 100px;
            padding: 6px;
            border: 1px solid #e0e0e0;
        }

        .session-card {
            background: #fff;
            border-radius: 6px;
            padding: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 4px;
            cursor: default;
            transition: transform 0.2s;
        }

        .session-card.cm {
            border-left: 3px solid #007bff;
        }

        .session-card.td {
            border-left: 3px solid #17a2b8;
        }

        .session-card.tp {
            border-left: 3px solid #28a745;
        }

        .session-title {
            font-size: 11px;
            font-weight: 600;
            margin: 0;
        }

        .session-details {
            font-size: 9px;
            color: #6c757d;
        }

        .btn-primary {
            background-color: #4723d9;
            border-color: #4723d9;
            font-size: 14px;
            padding: 6px 16px;
        }

        .btn-primary:hover {
            background-color: white;
            color: #4723d9;
            border-color: #4723d9;
        }

        .form-select {
            font-size: 14px;
            padding: 6px 12px;
        }

        .form-select:focus {
            box-shadow: none !important;
            border-color: #4723d9;
        }
    </style>

    <div class="container-fluid p-0 pt-4">

        <x-global_alert />


        {{-- heading --}}
        @if (Route::currentRouteName() === 'emploi.myTimetable')
            @include('components.heading', [
                'icon' => ' <i class="fas fa-table fa-2x" style="color: #330bcf;"></i>',
                'heading' => 'Mon Emploi du Temps :',
                'buttons' => [
                    [
                        'route' => route('emploi.my-timetable.export'),
                        'text' => ' Exporter mon emploi du temps',
                        'bicon' => '<i class="bi bi-download me-2"></i>',
                        'type' => 'primary',
                    ],
                ],
            ])
        @else
            @include('components.heading', [
                'icon' => ' <i class="fas fa-table fa-2x" style="color: #330bcf;"></i>',
                'heading' => 'Emploi du Temps des Professeurs :',
            ])
        @endif


      

{{-- 
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('emploi.my-timetable.export') }}" class="btn btn-primary rounded fw-semibold">
                <i class="bi bi-download me-2"></i> Exporter mon emploi du temps
            </a>
        </div> --}}

        <div class="card border-0 shadow rounded-4 mb-4" style="box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-body p-4">
                @if (Route::currentRouteName() === 'emploi.prof')
                    <div class="mb-4">
                        <label for="prof_id" class="form-label small fw-bold text-muted">Sélectionner un
                            Professeur</label>
                        <select id="prof_id" class="form-select rounded-3"
                            onchange="window.location.href='{{ route('emploi.prof') }}?prof_id=' + this.value">
                            <option value="">Sélectionner</option>
                            @foreach ($professors as $prof)
                                <option value="{{ $prof->id }}"
                                    {{ request('prof_id') == $prof->id ? 'selected' : '' }}>
                                    {{ $prof->fullname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if ($prof_id && $seances->isEmpty())
                    @if (Route::currentRouteName() === 'emploi.myTimetable')
                        Aucune séance trouvée pour vous , (les emploix du temps est pas configuree par les coordonnateur
                        des filieres)
                    @else
                        <p class="text-muted">Aucune séance trouvée pour ce professeur.</p>
                    @endif
                @elseif ($prof_id)
                    <div class="table-container">
                        <div class="table-responsive p-3">
                            <table class="table schedule-grid">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Jour</th>
                                        @php
                                            $timeSlots = [
                                                ['start' => '08:30:00', 'end' => '10:30:00'],
                                                ['start' => '10:30:00', 'end' => '12:30:00'],
                                                ['start' => '14:30:00', 'end' => '16:30:00'],
                                                ['start' => '16:30:00', 'end' => '18:30:00'],
                                            ];
                                        @endphp
                                        @foreach ($timeSlots as $slot)
                                            <th>{{ substr($slot['start'], 0, 5) }}-{{ substr($slot['end'], 0, 5) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $day)
                                        <tr>
                                            <td class="align-middle fw-bold">{{ $day }}</td>
                                            @foreach ($timeSlots as $index => $slot)
                                                <td>
                                                    <div class="sessions">
                                                        @php
                                                            $daySeances = $seances->filter(function ($seance) use (
                                                                $day,
                                                                $slot,
                                                            ) {
                                                                return $seance->jour === $day &&
                                                                    $seance->heure_debut === $slot['start'];
                                                            });
                                                        @endphp
                                                        @foreach ($daySeances as $seance)
                                                            <div class="session-card {{ strtolower($seance->type) }}">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center mb-1">
                                                                    <span
                                                                        class="badge bg-{{ $seance->type === 'CM' ? 'primary' : ($seance->type === 'TD' ? 'info' : 'success') }} text-white">
                                                                        {{ $seance->type }}
                                                                    </span>
                                                                </div>
                                                                <h6 class="session-title">{{ $seance->module->name }}
                                                                </h6>
                                                                <div class="session-details">
                                                                    <div>
                                                                        {{ $seance->module->code }}{{ $seance->groupe ? ' - ' . $seance->groupe : '' }}
                                                                    </div>
                                                                    <div>Salle: {{ $seance->salle ?? 'Non défini' }}
                                                                    </div>
                                                                    <div>{{ $seance->emploi->filiere->name }} -
                                                                        S{{ $seance->emploi->semester }}</div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <p class="text-muted">Aucune séance disponible.</p>
                @endif
            </div>
        </div>
    </div>
</x-coordonnateur_layout>

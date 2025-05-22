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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif











        <div class="header-container mb-4">
            <style>
                .header-container {
                    background: white;
                    border-radius: 8px;
                    padding: 20px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                }

                .header-title {
                    color: #4723d9;
                    font-weight: 600;
                    font-size: 1.75rem;
                    margin: 0;
                }

                .form-select {
                    border-color: #e0e0e0;
                    font-size: 0.9rem;
                    padding: 8px 12px;
                    border-radius: 6px;
                    background-color: #f8f9fa;
                    transition: border-color 0.2s;
                }

                .form-select:focus {
                    border-color: #4723d9;
                    box-shadow: 0 0 0 2px rgba(71, 35, 217, 0.2);
                    outline: none;
                }

                .btn-primary {
                    background-color: #4723d9;
                    border-color: #4723d9;
                    font-size: 0.9rem;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-weight: 500;
                    transition: all 0.2s;
                }

                .btn-primary:hover {
                    background-color: white;
                    color: #4723d9;
                    border-color: #4723d9;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .btn-outline-primary {
                    border-color: #4723d9;
                    color: #4723d9;
                    font-size: 0.9rem;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-weight: 500;
                    transition: all 0.2s;
                    white-space: nowrap;
                }

                .btn-outline-primary:hover {
                    background-color: #4723d9;
                    color: white;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .btn-outline-primary:hover .btn-text-prof {
                    color: white;
                }

                .btn-text-emploi,
                .btn-text-prof {
                    display: inline;
                }

                @media (max-width: 768px) {
                    .header-container {
                        padding: 15px;
                    }

                    .header-title {
                        font-size: 1.5rem;
                        margin-bottom: 15px;
                        text-align: center;
                    }

                    .form-select,
                    .btn-outline-primary {
                        width: 100%;
                        margin-bottom: 10px;
                    }

                    .btn-outline-primary {
                        white-space: normal;
                        text-align: center;
                        padding: 10px 16px;
                    }

                    .btn-text-emploi,
                    .btn-text-prof {
                        display: block;
                    }

                    .btn-text-emploi {
                        margin-bottom: 2px;
                    }
                }

                /* Improved grid layout */
                .header-grid {
                    display: grid;
                    grid-template-columns: 1fr auto auto;
                    gap: 1rem;
                    align-items: center;
                }

                @media (max-width: 992px) {
                    .header-grid {
                        grid-template-columns: 1fr auto;
                    }

                    .header-title {
                        grid-column: 1 / -1;
                        text-align: center;
                        margin-bottom: 10px;
                        text-decoration: underline;
                    }
                }

                @media (max-width: 768px) {
                    .header-grid {
                        grid-template-columns: 1fr;
                        gap: 0.75rem;
                    }

                    .btn-outline-primary {
                        white-space: normal;
                        text-align: center;
                        padding: 10px 16px;
                        line-height: 1.3;
                        /* Add this for better line spacing */
                    }

                    .btn-text-emploi,
                    .btn-text-prof {
                        display: inline;
                        /* Change from 'block' to 'inline' */
                        margin-bottom: 0;
                        /* Remove bottom margin */
                    }

                    .btn-text-emploi:after {
                        content: " ";
                        /* Add space after "Emploi des" */
                    }

                }
            </style>

            <div class="header-grid mt">


                @if (Route::currentRouteName() === 'emploi.myTimetable')
                    <h3 style="color: #330bcf; font-weight: 500;">Emploi du Temps :</h3>
                @else
                    <h3 style="color: #330bcf; font-weight: 500;">Emploi du Temps des Professeurs</h3>
                @endif



                

                <a href="{{ route('emploi.my-timetable.export') }}"
                    class="btn btn-primary rounded fw-semibold my-2 me-2">
                    <i class="bi bi-download me-2"></i> Exporter en HTML
                </a>

            </div>
        </div>





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
                    <p class="text-muted">Aucune séance trouvée pour ce professeur.</p>
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

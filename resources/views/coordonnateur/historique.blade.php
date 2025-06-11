```html
<x-coordonnateur_layout>
    <style>
        .header-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .history-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 2rem;
        }

        .form-label {
            color: #515151;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-select {
            border-color: #e0e0e0;
            border-radius: 6px;
            padding: 10px;
            font-size: 0.9rem;
        }

        .form-select:focus {
            border-color: #4723d9;
            box-shadow: 0 0 0 3px rgba(71, 35, 217, 0.1);
        }

        .table {
            width: 100%;
            table-layout: auto;
            font-size: 0.9rem;
        }

        .table th,
        .table td {
            text-align: left;
            padding: 0.75rem;
            vertical-align: middle;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .nav-tabs {
            border-bottom: 2px solid #e0e0e0;
        }

        .nav-tabs .nav-link {
            color: #555556;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border: none;
        }

        .nav-tabs .nav-link.active {
            color: #4723d9;
            border-bottom: 2px solid #4723d9;
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

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background-color: white;
            color: #6c757d;
            border-color: #6c757d;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        ::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #4723d9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #3a1cb3;
        }

        @media (max-width: 768px) {
            .header-grid {
                grid-template-columns: 1fr;
            }

            .header-grid .d-flex.gap-2 {
                justify-content: center;
                flex-wrap: wrap;
            }

            .history-container {
                padding: 1.5rem;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .nav-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
            }
        }
    </style>

        <div class="header-grid">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-history fa-2x" style="color: #330bcf;"></i>
                <h3 style="color: #330bcf; font-weight: 500;">Historique de la Filière</h3>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('coordonnateur.dashboard') }}"
                    class="btn btn-secondary rounded fw-semibold">
                    <i class="fas fa-arrow-left"></i> Retour au Tableau de Bord
                </a>
                <a href="{{ route('coordonnateur.history.export') }}?tab={{ request('tab', 'modules') }}&academic_year={{ request('academic_year') }}"
                    class="btn btn-primary rounded fw-semibold">
                    <i class="fas fa-file-export"></i> Exporter Excel
                </a>
            </div>
        </div>

        <div class="history-container">
            <p class="text-muted mb-4">Consultez l'historique des modules, assignments et vacataires pour les années académiques passées.</p>

            <form method="GET" action="{{ route('coordonnateur.history') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="academic_year" class="form-label">Année Académique</label>
                        <select name="academic_year" id="academic_year" class="form-select">
                            <option value="">Toutes les années</option>
                            @foreach ($academic_years as $year)
                                <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 align-self-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrer
                        </button>
                    </div>
                </div>
                <input type="hidden" name="tab" value="{{ request('tab', 'modules') }}">
            </form>

            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ request('tab', 'modules') == 'modules' ? 'active' : '' }}" href="?tab=modules&academic_year={{ request('academic_year') }}">Modules</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') == 'assignments' ? 'active' : '' }}" href="?tab=assignments&academic_year={{ request('academic_year') }}">Assignments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') == 'vacataires' ? 'active' : '' }}" href="?tab=vacataires&academic_year={{ request('academic_year') }}">Vacataires</a>
                </li>
            </ul>

            @if (request('tab', 'modules') == 'modules')
                <h5>Modules</h5>
                @if ($modules->isEmpty())
                    <p class="text-muted">Aucun module trouvé.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Semestre</th>
                                    <th>Volume Horaire</th>
                                    <th>Responsable</th>
                                    <th>Année Académique</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modules as $module)
                                    <tr>
                                        <td>{{ $module->name }}</td>
                                        <td>{{ $module->semestre }}</td>
                                        <td>{{ $module->volume_horaire() }} h</td>
                                        <td>{{ $module->responsable ? $module->responsable->fullname : 'N/A' }}</td>
                                        <td>
                                            {{ $module->assignments->pluck('academic_year')->filter()->first() ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $modules->links() }}
                @endif
            @elseif (request('tab') == 'assignments')
                <h5>Assignments</h5>
                @if ($assignments->isEmpty())
                    <p class="text-muted">Aucun assignment trouvé.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th>Vacataire</th>
                                    <th>Type (CM/TD/TP)</th>
                                    <th>Heures</th>
                                    <th>Année Académique</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignments as $assignment)
                                    <tr>
                                        <td>{{ $assignment->module->name }}</td>
                                        <td>{{ $assignment->user->fullname }}</td>
                                        <td>
                                            {{ $assignment->teach_cm ? 'CM' : '' }}
                                            {{ $assignment->teach_td ? 'TD' : '' }}
                                            {{ $assignment->teach_tp ? 'TP' : '' }}
                                        </td>
                                        <td>{{ $assignment->hours }} h</td>
                                        <td>{{ $assignment->academic_year ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $assignments->links() }}
                @endif
            @else
                <h5>Vacataires</h5>
                @if ($vacataires->isEmpty())
                    <p class="text-muted">Aucun vacataire trouvé.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Heures Totales</th>
                                    <th>Date de Création</th>
                                    <th>Année Académique</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vacataires as $vacataire)
                                    <tr>
                                        <td>{{ $vacataire->fullname }}</td>
                                        <td>{{ $vacataire->email }}</td>
                                        <td>{{ $vacataire->hours }} h</td>
                                        <td>{{ $vacataire->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $vacataire->user_details->academic_year ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $vacataires->links() }}
                @endif
            @endif
        </div>
</x-coordonnateur_layout>
```
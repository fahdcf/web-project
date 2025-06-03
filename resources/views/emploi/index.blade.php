<x-coordonnateur_layout>
    <style>
        /* Container */
        .container-fluid {
            padding: 1.5rem;
            min-height: 80vh;
        }

        /* Form Elements */
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #34495e;
        }

        /* Buttons */
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

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-success:hover {
            background-color: white;
            color: #28a745;
            border-color: #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-danger:hover {
            background-color: white;
            color: #dc3545;
            border-color: #dc3545;
        }

        /* Table Section */
        .table-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-top: 1.5rem;
        }

        .table-responsive {
            max-height: 70vh;
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
        }

        .table-responsive::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background-color: #aaa;
            border-radius: 10px;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 600px;
        }

        .table thead th {
            background-color: #4723d9;
            color: white;
            padding: 1rem;
            font-weight: 500;
            position: sticky;
            top: 0;
            z-index: 10;
            text-align: center;
        }

        .table tbody tr {
            transition: background-color 0.2s;
        }

        .table tbody tr:hover {
            background-color: #f9f9ff;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e0e0e0;
            color: #555;
            font-weight: 400;
            text-align: center;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-active {
            background-color: #e6f7ee;
            color: #28a745;
        }

        .status-inactive {
            background-color: #fde8e8;
            color: #dc3545;
        }

        /* Action Buttons */
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            font-size: 1.1rem;
        }

        .view-btn {
            background-color: #4723d9;
            color: white;
        }

        .view-btn:hover {
            background-color: #3a1cb3;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        /* Modal */
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background-color: #4723d9;
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 1rem 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
            font-size: 0.95rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1rem 1.5rem;
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            margin-bottom: 1.5rem;
            padding: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 1rem;
            }

            .action-btn {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }

            .table td,
            .table th {
                font-size: 0.9rem;
                padding: 0.75rem;
            }

            .modal-dialog {
                margin: 0.5rem;
            }



        }

        .export-group {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
    </style>


    <div class="container-fluid">
        <x-global_alert />


        @php
            $options = [];
            foreach ($emplois as $emploi) {
                $options[] = [
                    'route' => route('emploi.filiere.export', $emploi->id),
                    'label' =>
                        'Emploi du ' . ($emploi->semester == 1 ? '1er' : $emploi->semester . 'ème') . ' Semestre',
                ];
            }
        @endphp

        @include('components.heading', [
            'icon' => '<i class="fas fa-calendar-alt fa-2x" style="color: #330bcf;"></i>',
            'heading' => 'Emplois du Temps - ' . $filiere->name,
            'buttons' => [
                [
                    'route' => route('emploi.prof'),
                    'text' => 'Emploi des Profs',
                    'bicon' => '<i class="bi bi-person me-2"></i>',
                    'type' => 'primary',
                ],
            ],
        
            'exportData' => [
                'buttonText' => 'Export',
                'options' => $options,
            ],
        ])










        <!-- Table Section -->
        <div class="table-section">
            <div class="table-responsive">
                <table class="table" id="emploisTable">
                    <thead>
                        <tr>
                            <th>Semestre</th>
                            <th>Emploi du Temps</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (range(1, 6) as $semester)
                            @php
                                $emploi = $emplois->firstWhere('semester', $semester);
                            @endphp
                            <tr>
                                <td>S{{ $semester }}</td>
                                <td>
                                    @if ($emploi)
                                        {{ $emploi->name }}
                                    @else
                                        <span class="text-muted">Non configuré</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($emploi)
                                        <span
                                            class="status-badge status-{{ $emploi->is_active ? 'active' : 'inactive' }}">
                                            {{ $emploi->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    @else
                                        <span class="status-badge text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        @if ($emploi)
                                            <a href="{{ route('emploi.edit', $emploi->id) }}" class="action-btn view-btn"
                                                title="Modifier l'emploi du temps">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button class="action-btn delete-btn" data-bs-toggle="modal"
                                                data-bs-target="#deleteEmploiModal{{ $emploi->id }}"
                                                title="Supprimer l'emploi du temps">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @else
                                            <a href="{{ route('emploi.create', ['semester' => $semester]) }}"
                                                class="action-btn view-btn" title="Créer un emploi du temps">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @if ($emploi)
                                <div class="modal fade" id="deleteEmploiModal{{ $emploi->id }}" tabindex="-1"
                                    aria-labelledby="deleteEmploiModalLabel{{ $emploi->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteEmploiModalLabel{{ $emploi->id }}">
                                                    Confirmer la Suppression
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Voulez-vous vraiment supprimer l'emploi du temps
                                                <strong>{{ $emploi->name }}</strong> (S{{ $semester }}) ?
                                                Cette action est irréversible.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('emploi.destroy', $emploi->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Aucun emploi du temps configuré pour cette filière.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-coordonnateur_layout>

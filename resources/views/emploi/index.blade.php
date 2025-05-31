<x-coordonnateur_layout>

    <style>
        /* Main Container */
        .vacataire-container {
            padding: 2rem;
            min-height: 80vh;
        }

        /* Header */
        .header-grid {
            display: grid;
            grid-template-columns: 1fr auto auto;
            gap: 1rem;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Filter Section */
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #34495e;
        }

        .form-select,
        .form-control {
            border-color: #e0e0e0;
            border-radius: 6px;
            transition: border-color 0.2s;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #4723d9;
            box-shadow: 0 0 0 2px rgba(71, 35, 217, 0.2);
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
            transition: all 0.2s;
        }

        .btn-success:hover {
            background-color: white;
            color: #28a745;
            border-color: #28a745;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-danger:hover {
            background-color: white;
            color: #dc3545;
            border-color: #dc3545;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dropdown-menu {
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #4723d9;
        }

        /* Table Section */
        .table-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
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

        .table-responsive::-webkit-scrollbar-track {
            background: transparent;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 800px;
        }

        .table thead th {
            background-color: #4723d9;
            color: white;
            padding: 1rem;
            font-weight: 500;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table tbody tr {
            transition: all 0.2s;
        }

        .table tbody tr:hover {
            background-color: #f9f9ff !important;
            transform: translateX(4px);
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
            color: #555;
            font-weight: 400;
            text-align: center;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
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
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .view-btn {
            background-color: #4723d9;
            color: white;
        }

        .view-btn:hover {
            background-color: #3a1cb3;
            transform: rotate(5deg);
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c82333;
            transform: rotate(5deg);
        }

        /* Modal */
        .modal-content {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #4723d9;
            color: white;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .modal-footer {
            border-top: none;
        }

        /* Alerts */
        .alert {
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .header-grid {
                grid-template-columns: 1fr;
            }

            .header-grid .d-flex.gap-2 {
                justify-content: center;
            }

            .form-select,
            .btn-primary,
            .btn-success {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>

    <div class="vacataire-container">
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

        <div class="header-grid">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-calendar-alt fa-2x" style="color: #330bcf;"></i>
                <h3 style="color: #330bcf; font-weight: 500;">Emplois du Temps - {{ $filiere->name }}</h3>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <select class="form-select" onchange="window.location.href=this.value">
                    <option value="">Toutes les années</option>
                    @foreach ($academicYears as $year)
                        <option value="{{ route('emploi.index', ['academic_year' => $year]) }}"
                            {{ $academicYear == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
                <a href="{{ route('emploi.prof') }}" class="btn btn-primary rounded fw-semibold">
                    <i class="bi bi-person me-2"></i> Emploi des Profs
                </a>
            </div>
        </div>

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
                                        <span class="status-badge">-</span>
                                    @endif
                                </td>
                                <td class="p-0">
                                    <div class="d-flex justify-content-center gap-3">
                                        @if ($emploi)
                                            <a href="{{ route('emploi.edit', $emploi->id) }}"
                                                class="action-btn view-btn" title="Modifier">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button class="action-btn delete-btn" data-bs-toggle="modal"
                                                data-bs-target="#deleteEmploiModal{{ $emploi->id }}"
                                                title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @else
                                            <a href="{{ route('emploi.create', ['semester' => $semester]) }}"
                                                class="action-btn view-btn" title="Créer">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @if ($emploi)
                                <div class="modal fade" id="deleteEmploiModal{{ $emploi->id }}"
                                    tabindex="-1" aria-labelledby="deleteEmploiModalLabel{{ $emploi->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="deleteEmploiModalLabel{{ $emploi->id }}">
                                                    Confirmation de Suppression
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Voulez-vous supprimer l'emploi du temps
                                                <strong>{{ $emploi->name }}</strong>
                                                (S{{ $semester }}) définitivement ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Fermer</button>
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
                                <td colspan="4" class="text-center text-muted">Aucun emploi du temps trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-coordonnateur_layout>
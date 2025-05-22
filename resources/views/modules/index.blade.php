<x-coordonnateur_layout>
    <div class="container-fluid px-4 py-5">
        <!-- Header Section -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-4 mb-5 p-5 bg-primary-subtle rounded-3 shadow-sm">
            <div class="d-flex flex-column gap-2">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-book-open fa-2x text-primary"></i>
                    <h1 class="h4 mb-0 fw-bold text-dark">Gestion des Unités d'Enseignement</h1>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-light text-dark border border-secondary-subtle">
                        <i class="fas fa-graduation-cap me-1 text-primary"></i>
                        Filière: <strong>{{ $filiere->name }}</strong>
                    </span>
                    <span class="badge bg-light text-dark border border-secondary-subtle">
                        <i class="fas fa-user-tie me-1 text-primary"></i>
                        Coordonnateur: <strong>{{ auth()->user()->lastname }} {{ auth()->user()->firstname }}</strong>
                    </span>
                </div>
            </div>
            <a href="{{ route('coordonnateur.modules.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="fas fa-plus-circle"></i>
                Nouvelle UE
            </a>
        </div>

        <!-- Search and Filter Card -->
        <div class="card mb-5 rounded-3 shadow-sm border-0">
            <div class="card-body p-5">
                <form action="{{ route('coordonnateur.modules.search') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Semestre</label>
                            <select class="form-select" name="filterSemester" id="filterSemester">
                                <option value="all">Tous les semestres</option>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ request('filterSemester') == $i ? 'selected' : '' }}>
                                        Semestre {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-medium text-muted">Statut</label>
                            <select class="form-select" name="filterStatus" id="filterStatus">
                                <option value="all">Tous statuts</option>
                                <option value="active" {{ request('filterStatus') == 'active' ? 'selected' : '' }}>Actif</option>
                                <option value="inactive" {{ request('filterStatus') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-medium text-muted">Recherche</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" placeholder="Code, intitulé ou responsable..." 
                                       name="searchInput" id="searchInput" value="{{ request('searchInput') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-filter"></i>
                                Filtrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Results Section -->
        @if (isset($searchResults))
            <div class="collapse {{ $searchResults->isNotEmpty() ? 'show' : '' }}" id="searchResultsCollapse">
                <div class="card mb-5 rounded-3 shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                            <i class="fas fa-search text-muted"></i>
                            Résultats ({{ $searchResults->count() }})
                        </h6>
                        <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="collapse" data-bs-target="#searchResultsCollapse">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @if ($searchResults->isNotEmpty())
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach ($searchResults as $module)
                                    <div class="list-group-item border-0 py-4 px-4">
                                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                            <div>
                                                <h6 class="mb-1 fw-semibold text-dark">{{ $module->code }} - {{ $module->name }}</h6>
                                                <div class="d-flex flex-wrap gap-3 text-sm text-muted">
                                                    <span><i class="fas fa-calendar me-1"></i> S{{ $module->semester }}</span>
                                                    <span><i class="fas fa-clock me-1"></i> {{ $module->cm_hours + $module->td_hours + $module->tp_hours }}h</span>
                                                    <span class="badge {{ $module->status === 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                        {{ $module->status === 'active' ? 'Actif' : 'Inactif' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('coordonnateur.modules.show', $module->id) }}" 
                                                   class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                                    <i class="fas fa-eye"></i>
                                                    Détails
                                                </a>
                                                <a href="{{ route('coordonnateur.modules.edit', $module->id) }}" 
                                                   class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                                                    <i class="fas fa-edit"></i>
                                                    Modifier
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="card-body p-4">
                            <div class="alert alert-info mb-0 d-flex align-items-center gap-2">
                                <i class="fas fa-info-circle"></i>
                                Aucun résultat ne correspond à votre recherche
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Semester Cards -->
        @foreach ($semesters as $semesterName => $modules)
            <div class="card mb-5 rounded-3 shadow-sm border-0">
                <div class="card-header bg-light border-bottom py-3 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary-subtle p-2 rounded-3">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </div>
                            <h5 class="mb-0 fw-semibold text-dark">Semestre {{ $semesterName }}</h5>
                        </div>
                        <div class="d-flex flex-wrap gap-3 text-sm text-muted">
                            <span class="d-flex align-items-center gap-1">
                                <i class="fas fa-book"></i>
                                {{ $modules->count() }} Modules
                            </span>
                            <span class="d-flex align-items-center gap-1">
                                <i class="fas fa-hourglass-half"></i>
                                {{ $modules->sum('credits') }} ECTS
                            </span>
                            @if ($modules->where('status', 'inactive')->count() > 0)
                                <span class="badge bg-warning-subtle text-warning d-flex align-items-center gap-1">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    {{ $modules->where('status', 'inactive')->count() }} Non assignés
                                </span>
                            @else
                                <span class="badge bg-success-subtle text-success d-flex align-items-center gap-1">
                                    <i class="fas fa-check-circle"></i>
                                    Planification OK
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 text-sm fw-semibold text-muted">Code</th>
                                <th class="px-4 py-3 text-sm fw-semibold text-muted">Intitulé</th>
                                <th class="px-4 py-3 text-sm fw-semibold text-muted">Crédits</th>
                                <th class="px-4 py-3 text-sm fw-semibold text-muted">Volume Horaire</th>
                                <th class="px-4 py-3 text-sm fw-semibold text-muted">Statut</th>
                                <th class="px-4 py-3 text-sm fw-semibold text-muted text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach ($modules as $module)
                                <tr data-semester="{{ $module->semester }}" data-status="{{ $module->status }}">
                                    <td class="px-4 py-3 fw-medium text-primary">{{ $module->code }}</td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium text-dark">{{ $module->name }}</span>
                                            <small class="text-muted">
                                                Resp: 
                                                @if ($module->responsable)
                                                    <span class="fw-medium">{{ $module->responsable->lastname }}</span>
                                                @else
                                                    <span class="text-danger">Non assigné</span>
                                                @endif
                                            </small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-light text-dark border border-secondary-subtle">
                                            {{ $module->credits }} ECTS
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                CM: {{ $module->cm_hours }}h
                                            </span>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                TD: {{ $module->td_hours }}h
                                            </span>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                TP: {{ $module->tp_hours }}h
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge {{ $module->status === 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} d-flex align-items-center gap-1">
                                            <i class="fas {{ $module->status === 'active' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                            {{ $module->status === 'active' ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('coordonnateur.modules.edit', $module->id) }}" 
                                               class="btn btn-sm btn-outline-secondary rounded-circle p-2" 
                                               data-bs-toggle="tooltip" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('coordonnateur.modules.assigner', $module->id) }}" 
                                               class="btn btn-sm btn-outline-success rounded-circle p-2" 
                                               data-bs-toggle="tooltip" title="Assigner">
                                                <i class="fas fa-user-plus"></i>
                                            </a>
                                            <a href="{{ route('coordonnateur.modules.show', $module->id) }}" 
                                               class="btn btn-sm btn-outline-primary rounded-circle p-2" 
                                               data-bs-toggle="tooltip" title="Détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger rounded-circle p-2 delete-module" 
                                                    data-id="{{ $module->id }}" 
                                                    data-name="{{ $module->name }}"
                                                    data-bs-toggle="tooltip" title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModuleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3 border-0 shadow">
                    <div class="modal-header bg-danger text-white border-0 py-3 px-4">
                        <h5 class="modal-title fw-semibold">Confirmer la suppression</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <p class="text-dark">Voulez-vous vraiment supprimer le module <strong id="moduleNameToDelete" class="fw-semibold"></strong> ?</p>
                        <p class="text-danger mt-2 d-flex align-items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            Cette action est irréversible !
                        </p>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                        <form id="deleteModuleForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            body {
                font-family: system-ui, -apple-system, sans-serif;
                background-color: #f8f9fa;
            }

            .card {
                border-radius: 0.5rem;
                overflow: hidden;
            }

            .shadow-sm {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }

            .table th, .table td {
                vertical-align: middle;
            }

            .table-hover tbody tr:hover {
                background-color: #f1f3f5;
            }

            .form-select, .form-control {
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            .btn-close-white {
                filter: invert(1);
            }

            .badge {
                font-weight: 500;
                padding: 0.35em 0.65em;
            }

            .rounded-circle {
                width: 32px;
                height: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .table-responsive {
                    -webkit-overflow-scrolling: touch;
                }
                .table th, .table td {
                    font-size: 0.875rem;
                    padding: 0.5rem;
                }
                .btn-sm {
                    font-size: 0.75rem;
                    padding: 0.25rem 0.5rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Initialize tooltips
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                    new bootstrap.Tooltip(el, {
                        placement: 'top',
                        trigger: 'hover'
                    });
                });

                // Delete module handling
                document.querySelectorAll('.delete-module').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const moduleId = btn.dataset.id;
                        const moduleName = btn.dataset.name;

                        document.getElementById('moduleNameToDelete').textContent = moduleName;
                        document.getElementById('deleteModuleForm').action = `/coordonnateur/modules/${moduleId}`;

                        new bootstrap.Modal(document.getElementById('deleteModuleModal'), {
                            backdrop: 'static',
                            keyboard: false
                        }).show();
                    });
                });

                // Optimized filter functionality
                const applyFilters = debounce(() => {
                    const semester = document.getElementById('filterSemester').value;
                    const status = document.getElementById('filterStatus').value;
                    const search = document.getElementById('searchInput').value.toLowerCase().trim();

                    document.querySelectorAll('.card[data-semester]').forEach(card => {
                        const rows = card.querySelectorAll('tbody tr');
                        let hasVisibleRows = false;

                        rows.forEach(row => {
                            const rowSemester = row.dataset.semester;
                            const rowStatus = row.dataset.status;
                            const rowText = row.textContent.toLowerCase();

                            const semesterMatch = semester === 'all' || rowSemester == semester;
                            const statusMatch = status === 'all' || status == rowStatus;
                            const searchMatch = search === '' || rowText.includes(search);

                            row.style.display = semesterMatch && statusMatch && searchMatch ? '' : 'none';
                            if (semesterMatch && statusMatch && searchMatch) hasVisibleRows = true;
                        });

                        card.style.display = hasVisibleRows ? '' : 'none';
                    });
                }, 300);

                // Debounce utility
                function debounce(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }

                // Event listeners
                document.getElementById('filterSemester').addEventListener('change', applyFilters);
                document.getElementById('filterStatus').addEventListener('change', applyFilters);
                document.getElementById('searchInput').addEventListener('input', applyFilters);

                // Initial filter application
                applyFilters();
            });
        </script>
    @endpush
</x-coordonnateur_layout>
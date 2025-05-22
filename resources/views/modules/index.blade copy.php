<x-coordonnateur_layout>
    <div class="container-fluid p-4">
        <!-- Header Section -->
        <div class="card mb-4 rounded-4 shadow-sm border-0 bg-primary text-white"
            style="background-color: #4723d9 !important;">
            <div
                class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-4">
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fas fa-book-open fa-2x"></i>
                        <h3 class="mb-0 fw-semibold">Gestion des Unités d'Enseignement</h3>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-white text-primary border border-white">
                            <i class="fas fa-graduation-cap me-1"></i>
                            Filière: <strong>{{ $filiere->name }}</strong>
                        </span>
                        <span class="badge bg-white text-primary border border-white">
                            <i class="fas fa-user-tie me-1"></i>
                            Coordonnateur: <strong>{{ auth()->user()->lastname }}
                                {{ auth()->user()->firstname }}</strong>
                        </span>
                    </div>
                </div>
                <a href="{{ route('coordonnateur.modules.create') }}"
                    class="btn btn-outline-light d-flex align-items-center gap-2 rounded-3">
                    <i class="fas fa-plus-circle"></i>
                    Nouvelle UE
                </a>
            </div>
        </div>

        <!-- Search and Filter Card -->
        <div class="card mb-4 rounded-4 shadow-sm border-0">
            <div class="card-header bg-primary text-white rounded-top-4 py-3 px-4">
                <h5 class="mb-0 fw-semibold">Recherche et Filtres</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('coordonnateur.modules.search') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-medium text-muted small">Semestre</label>
                            <select class="form-select rounded-3" name="filterSemester" id="filterSemester">
                                <option value="all">Tous les semestres</option>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}"
                                        {{ request('filterSemester') == $i ? 'selected' : '' }}>
                                        Semestre {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-medium text-muted small">Statut</label>
                            <select class="form-select rounded-3" name="filterStatus" id="filterStatus">
                                <option value="all">Tous statuts</option>
                                <option value="active" {{ request('filterStatus') == 'active' ? 'selected' : '' }}>Actif
                                </option>
                                <option value="inactive" {{ request('filterStatus') == 'inactive' ? 'selected' : '' }}>
                                    Inactif</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium text-muted small">Recherche</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-3">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 rounded-end-3"
                                    placeholder="Code, intitulé ou responsable..." name="searchInput" id="searchInput"
                                    value="{{ request('searchInput') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit"
                                class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2 rounded-3">
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
                <div class="card mb-4 rounded-4 shadow-sm border-0">
                    <div
                        class="card-header bg-primary text-white rounded-top-4 py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold d-flex align-items-center gap-2">
                            <i class="fas fa-search"></i>
                            Résultats ({{ $searchResults->count() }})
                        </h5>
                        <button class="btn btn-link text-white p-0" type="button" data-bs-toggle="collapse"
                            data-bs-target="#searchResultsCollapse">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="card-body p-0">
                        @if ($searchResults->isNotEmpty())
                            <div class="list-group list-group-flush">
                                @foreach ($searchResults as $module)
                                    <div class="list-group-item border-0 py-3 px-4">
                                        <div
                                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                            <div>
                                                <h6 class="mb-1 fw-semibold text-dark">{{ $module->code }} -
                                                    {{ $module->name }}</h6>
                                                <div class="d-flex flex-wrap gap-2 text-muted">
                                                    <span><i class="fas fa-calendar me-1"></i>
                                                        S{{ $module->semester }}</span>
                                                    <span><i class="fas fa-clock me-1"></i>
                                                        {{ $module->cm_hours + $module->td_hours + $module->tp_hours }}h</span>
                                                    <span
                                                        class="badge {{ $module->status === 'active' ? 'bg-success text-white' : 'bg-danger text-white' }} rounded-3">
                                                        {{ $module->status === 'active' ? 'Actif' : 'Inactif' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('coordonnateur.modules.show', $module->id) }}"
                                                    class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1 rounded-3">
                                                    <i class="fas fa-eye"></i>
                                                    Détails
                                                </a>
                                                <a href="{{ route('coordonnateur.modules.edit', $module->id) }}"
                                                    class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 rounded-3">
                                                    <i class="fas fa-edit"></i>
                                                    Modifier
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="card-body p-4 text-center">
                                <i class="fas fa-info-circle fs-3 text-muted"></i>
                                <p class="text-muted mt-2">Aucun résultat ne correspond à votre recherche</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Semester Cards -->
        @foreach ($semesters as $semesterName => $modules)
            <div class="card mb-4 rounded-4 shadow-sm border-0" data-semester="{{ $semesterName }}">
                <div class="card-header bg-primary text-white rounded-top-4 py-3 px-4">
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-calendar-alt"></i>
                            <h5 class="mb-0 fw-semibold">Semestre {{ $semesterName }}</h5>
                        </div>
                        <div class="d-flex flex-wrap gap-2 text-white">
                            <span class="badge bg-white text-primary border border-white">
                                <i class="fas fa-book me-1"></i>
                                {{ $modules->count() }} Modules
                            </span>
                            <span class="badge bg-white text-primary border border-white">
                                <i class="fas fa-hourglass-half me-1"></i>
                                {{ $modules->sum('credits') }} ECTS
                            </span>
                            @if ($modules->where('status', 'inactive')->count() > 0)
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    {{ $modules->where('status', 'inactive')->count() }} Non assignés
                                </span>
                            @else
                                <span class="badge bg-success text-white">
                                    <i class="fas fa-check-circle me-1"></i>
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
                                                    <span
                                                        class="fw-medium">{{ $module->responsable->lastname }}</span>
                                                @else
                                                    <span class="text-danger">Non assigné</span>
                                                @endif
                                            </small>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-light text-dark border border-primary rounded-3">
                                            {{ $module->credits }} ECTS
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-primary text-white rounded-3">
                                                CM: {{ $module->cm_hours }}h
                                            </span>
                                            <span class="badge bg-primary text-white rounded-3">
                                                TD: {{ $module->td_hours }}h
                                            </span>
                                            <span class="badge bg-primary text-white rounded-3">
                                                TP: {{ $module->tp_hours }}h
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="badge {{ $module->status === 'active' ? 'bg-success text-white' : 'bg-danger text-white' }} d-flex align-items-center gap-1 rounded-3">
                                            <i
                                                class="fas {{ $module->status === 'active' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                            {{ $module->status === 'active' ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-link text-primary p-0" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li>
                                                    <a class="dropdown-item py-2"
                                                        href="{{ route('coordonnateur.modules.show', $module->id) }}">
                                                        <i class="fas fa-eye me-2"></i>Détails
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item py-2"
                                                        href="{{ route('coordonnateur.modules.edit', $module->id) }}">
                                                        <i class="fas fa-edit me-2"></i>Modifier
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item py-2"
                                                        href="{{ route('coordonnateur.modules.assigner', $module->id) }}">
                                                        <i class="fas fa-user-plus me-2"></i>Assigner
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider m-0">
                                                </li>
                                                <li>
                                                    <button class="dropdown-item py-2 text-danger delete-module"
                                                        data-id="{{ $module->id }}"
                                                        data-name="{{ $module->name }}">
                                                        <i class="fas fa-trash-alt me-2"></i>Supprimer
                                                    </button>
                                                </li>
                                            </ul>
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
                <div class="modal-content rounded-4 border-0 shadow-sm">
                    <div class="modal-header bg-danger text-white border-0 rounded-top-4 py-3 px-4">
                        <h5 class="modal-title fw-semibold">Confirmer la suppression</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <p class="text-dark">Voulez-vous vraiment supprimer le module <strong id="moduleNameToDelete"
                                class="fw-semibold"></strong> ?</p>
                        <p class="text-danger mt-2 d-flex align-items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            Cette action est irréversible !
                        </p>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-outline-secondary rounded-3"
                            data-bs-dismiss="modal">Annuler</button>
                        <form id="deleteModuleForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-3">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* General Styling */
            body {
                font-family: 'Poppins', 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
                background-color: #f5f6f8;
                color: #2d3748;
            }

            .container-fluid {
                max-width: 1600px;
                padding: 1.5rem;
            }

            /* Cards */
            .card {
                border-radius: 15px;
                background-color: #ffffff;
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .shadow-sm {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            .bg-primary {
                background-color: #4723d9 !important;
            }

            .text-primary {
                color: #4723d9 !important;
            }

            /* Headers */
            .card-header {
                background-color: #4723d9;
                color: #ffffff;
                border-bottom: none;
            }

            .rounded-top-4 {
                border-top-left-radius: 15px !important;
                border-top-right-radius: 15px !important;
            }

            /* Buttons */
            .btn-primary {
                background-color: #4723d9;
                border-color: #4723d9;
                font-weight: 500;
                padding: 0.5rem 1.25rem;
                border-radius: 8px;
                transition: all 0.2s;
            }

            .btn-primary:hover {
                background-color: #ffffff;
                color: #4723d9;
                border-color: #4723d9;
                box-shadow: 0 2px 8px rgba(71, 35, 217, 0.2);
            }

            .btn-outline-light {
                border-color: #ffffff;
                color: #ffffff;
                font-weight: 500;
                border-radius: 8px;
                padding: 0.5rem 1.25rem;
            }

            .btn-outline-light:hover {
                background-color: #ffffff;
                color: #4723d9;
                border-color: #ffffff;
            }

            .btn-outline-primary,
            .btn-outline-secondary {
                border-radius: 8px;
                font-size: 0.8125rem;
                padding: 0.375rem 0.75rem;
                transition: all 0.2s;
            }

            .btn-outline-primary:hover {
                background-color: #4723d9;
                color: #ffffff;
            }

            .btn-outline-secondary:hover {
                background-color: #6c757d;
                color: #ffffff;
            }

            /* Form Elements */
            .form-select,
            .form-control {
                border-radius: 8px;
                border: 1px solid #e9ecef;
                padding: 0.625rem 1rem;
                font-size: 0.875rem;
                transition: border-color 0.2s, box-shadow 0.2s;
            }

            .form-select:focus,
            .form-control:focus {
                border-color: #4723d9;
                box-shadow: 0 0 0 3px rgba(71, 35, 217, 0.1);
                outline: none;
            }

            .input-group-text {
                background-color: #ffffff;
                border: 1px solid #e9ecef;
                color: #868e96;
                border-radius: 8px 0 0 8px;
            }

            .form-label {
                font-weight: 500;
                font-size: 0.8125rem;
                color: #495057;
            }

            /* Table */
            .table {
                border-collapse: separate;
                border-spacing: 0;
            }

            .table th {
                font-weight: 600;
                font-size: 0.8125rem;
                color: #495057;
                background-color: #f8f9fa;
                padding: 1rem 1.5rem;
            }

            .table td {
                padding: 1rem 1.5rem;
                font-size: 0.875rem;
                vertical-align: middle;
                border-bottom: 1px solid #e9ecef;
            }

            .table-hover tbody tr:hover {
                background-color: #f9f8ff;
                transition: background-color 0.2s;
            }

            /* Badges */
            .badge {
                font-weight: 500;
                font-size: 0.8125rem;
                padding: 0.375rem 0.75rem;
                border-radius: 8px;
                transition: background-color 0.2s;
            }

            .bg-success {
                background-color: #28c76f !important;
            }

            .bg-danger {
                background-color: #ea5455 !important;
            }

            .bg-warning {
                background-color: #ff914d !important;
            }

            .bg-light {
                background-color: #f8f9fa !important;
                border: 1px solid #4723d9;
            }

            /* Modal */
            .modal-content {
                border-radius: 15px;
                overflow: hidden;
            }

            .modal-header {
                border-bottom: none;
            }

            .modal-footer {
                border-top: none;
                padding-top: 0;
            }

            .btn-close-white {
                filter: invert(1);
            }

            /* Dropdown */
            .dropdown-menu {
                border-radius: 8px;
                border: 1px solid #e9ecef;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .dropdown-item {
                font-size: 0.875rem;
                padding: 0.5rem 1rem;
                transition: background-color 0.2s;
            }

            .dropdown-item:hover {
                background-color: #f9f8ff;
            }

            /* Responsive Adjustments */
            @media (max-width: 768px) {
                .container-fluid {
                    padding: 1rem;
                }

                .card-body {
                    padding: 1.5rem;
                }

                .table th,
                .table td {
                    font-size: 0.8125rem;
                    padding: 0.75rem;
                }

                .btn-sm {
                    font-size: 0.75rem;
                    padding: 0.375rem 0.75rem;
                }

                .form-select,
                .form-control {
                    font-size: 0.8125rem;
                }

                .badge {
                    font-size: 0.75rem;
                }
            }

            @media (max-width: 576px) {
                .row.g-3 {
                    flex-direction: column;
                    align-items: stretch;
                }

                .col-md-2,
                .col-md-3,
                .col-md-4 {
                    width: 100%;
                }

                .btn {
                    width: 100%;
                    justify-content: center;
                }

                .d-flex.gap-2 {
                    flex-direction: column;
                    gap: 0.5rem;
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
                        document.getElementById('deleteModuleForm').action =
                            `coordonnateur/modules/${moduleId}`;

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

                            row.style.display = semesterMatch && statusMatch && searchMatch ?
                                '' : 'none';
                            if (semesterMatch && statusMatch && searchMatch) hasVisibleRows =
                                true;
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
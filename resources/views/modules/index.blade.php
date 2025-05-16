<x-coordonnateur_layout>
    <div class="container-fluid px-4 py-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Header Section -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4 p-3 bg-white rounded shadow-sm">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-book-open fa-xl text-primary me-3"></i>
                    <h1 class="h3 mb-0 text-gray-800">Gestion des Unités d'Enseignement</h1>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-light text-dark border">
                            <i class="fas fa-graduation-cap me-1 text-primary"></i>
                            Filière: <strong>{{ $filiere->name }}</strong>
                        </span>
                    </div>

                    <div class="d-flex align-items-center">
                        <span class="badge bg-light text-dark border">
                            <i class="fas fa-user-tie me-1 text-primary"></i>
                            Coordonnateur:
                            <strong>{{ auth()->user()->lastname }} {{ auth()->user()->firstname }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            <a href="{{ route('coordonnateur.modules.create') }}" class="btn btn-primary d-flex align-items-center">
                <i class="fas fa-plus-circle me-2"></i>
                <span>Nouvelle UE</span>
            </a>
        </div>

        <!-- Search and Filter Card -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body p-3">
                <form action="{{ route('coordonnateur.modules.search') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4 col-lg-3">
                            <label class="form-label small fw-bold text-muted">Semestre</label>
                            <select class="form-select" name="filterSemester" id="filterSemester">
                                <option value="all">Tous les semestres</option>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}"
                                        {{ request('filterSemester') == $i ? 'selected' : '' }}>
                                        Semestre {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-4 col-lg-3">
                            <label class="form-label small fw-bold text-muted">Statut</label>
                            <select class="form-select" name="filterStatus" id="filterStatus">
                                <option value="all">Tous statuts</option>
                                <option value="active" {{ request('filterStatus') == 'active' ? 'selected' : '' }}>Actif
                                </option>
                                <option value="inactive" {{ request('filterStatus') == 'inactive' ? 'selected' : '' }}>
                                    Inactif</option>

                            </select>
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <label class="form-label small fw-bold text-muted">Recherche</label>
                            <div class="input-group">
                                <input type="text" class="form-control border-end-0"
                                    placeholder="Code, intitulé ou responsable..." name="searchInput" id="searchInput"
                                    value="{{ request('searchInput') }}">
                                <button class="btn btn-outline-secondary border-start-0" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-1"></i> Appliquer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Results Section -->
        @if (isset($searchResults))
            <div class="collapse {{ $searchResults->isNotEmpty() ? 'show' : '' }}" id="searchResultsCollapse">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">
                            <i class="fas fa-search me-2"></i>
                            Résultats ({{ $searchResults->count() }})
                        </h6>
                        <button class="btn btn-sm btn-link text-decoration-none" type="button"
                            data-bs-toggle="collapse" data-bs-target="#searchResultsCollapse">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    @if ($searchResults->isNotEmpty())
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach ($searchResults as $module)
                                    <div class="list-group-item">
                                        <div
                                            class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                            <div class="mb-2 mb-md-0">
                                                <h6 class="mb-1 fw-semibold">{{ $module->code }} - {{ $module->name }}
                                                </h6>
                                                <div class="d-flex flex-wrap gap-3">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i> S{{ $module->semester }}
                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $module->cm_hours + $module->td_hours + $module->tp_hours }}h
                                                    </small>
                                                    <span
                                                        class="badge bg-{{ $module->status === 'active' ? 'success' : 'danger' }}">
                                                        {{ $module->status === 'active' ? 'Actif' : 'Inactif' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('coordonnateur.modules.show', $module->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i> Détails
                                                </a>
                                                <a href="{{ route('coordonnateur.modules.edit', $module->id) }}"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit me-1"></i> Modifier
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Aucun résultat ne correspond à votre recherche
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>


    <div class="container-fluid px-4 py-4">


        @foreach ($semesters as $semesterName => $modules)
            <div class="card shadow-sm mb-4 border-0 p-3">

                {{-- 
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body p-3"> --}}


                <!-- En-tête amélioré -->
                <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap py-2">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-alt text-primary me-2 fs-5"></i>
                        <h5 class="mb-0 fw-semibold">Semestre {{ $semesterName }}</h5>
                    </div>

                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <div class="d-flex align-items-center text-muted">
                            <i class="fas fa-book me-1"></i>
                            <span>{{ $modules->count() }} Modules</span>
                        </div>

                        <div class="d-flex align-items-center text-muted">
                            <i class="fas fa-hourglass-half me-1"></i>
                            <span>{{ $modules->sum('credits') }} ECTS</span>
                        </div>

                        @if ($modules->where('status', 'inactive')->count() > 0)
                            <span class="badge bg-warning rounded-pill py-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ $modules->where('status', 'inactive')->count() }} Non assignés
                            </span>
                        @else
                            <span class="badge bg-success rounded-pill py-2">
                                <i class="fas fa-check-circle me-1"></i>
                                Planification OK
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Tableau optimisé -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="100" class="ps-3">Code</th>
                                <th>Intitulé</th>
                                <th width="90">Crédits</th>
                                <th width="160">Volume Horaire</th>
                                <th width="120">Statut</th>
                                <th width="180" class="pe-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modules as $module)
                                <tr>
                                    <!-- Colonne Code -->
                                    <td class="ps-3 fw-bold text-primary">
                                        {{ $module->code }}
                                    </td>

                                    <!-- Colonne Intitulé améliorée -->
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">{{ $module->name }}</span>
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

                                    <!-- Colonne Crédits -->
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-10 text-white">
                                            {{ $module->credits }} ECTS
                                        </span>
                                    </td>

                                    <!-- Colonne Volume Horaire optimisée -->
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-primary bg-opacity-10 text-white ">
                                                CM: {{ $module->cm_hours }}h
                                            </span>
                                            <span class="badge bg-primary bg-opacity-10 text-white ">
                                                TP: {{ $module->tp_hours }}h
                                            </span>
                                            <span class="badge bg-primary bg-opacity-10 text-white ">
                                                TD: {{ $module->td_hours }}h
                                            </span>
                                            <span class="badge bg-primary bg-opacity-10 text-white ">
                                                Autre: {{ $module->autre_hours }}h
                                            </span>


                                        </div>
                                    </td>

                                    <!-- Colonne Statut améliorée -->
                                    <td>
                                        <span
                                            class="badge rounded-pill py-2 {{ $module->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                            <i
                                                class="fas {{ $module->status === 'active' ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                            {{ $module->status === 'active' ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>

                                    <!-- Colonne Actions optimisée -->
                                    <td class="pe-3 text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!-- Bouton Éditer -->
                                            <a href="{{ route('coordonnateur.modules.edit', $module->id) }}"
                                                class="btn btn-outline-primary px-3" title="Modifier"
                                                data-bs-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Bouton Assigner -->
                                            <a href="{{ route('coordonnateur.modules.assigner', $module->id) }}"
                                                class="btn btn-outline-success px-3" title="Assigner vacataires"
                                                data-bs-toggle="tooltip">
                                                <i class="fas fa-user-plus"></i>
                                            </a>

                                            <!-- Bouton Voir -->
                                            <a href="{{ route('coordonnateur.modules.show', $module->id) }}"
                                                class="btn btn-outline-info px-3" title="Détails"
                                                data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Bouton Supprimer -->
                                            <button class="btn btn-outline-danger px-3 delete-module"
                                                data-id="{{ $module->id }}" data-name="{{ $module->name }}"
                                                title="Supprimer" data-bs-toggle="tooltip">
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

        <!-- Modal de confirmation de suppression -->
        <div class="modal fade" id="deleteModuleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Confirmer la suppression</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Voulez-vous vraiment supprimer le module <strong id="moduleNameToDelete"></strong> ?</p>
                        <p class="text-danger">Cette action est irréversible !</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <form id="deleteModuleForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('styles')
            <style>
                /* Styles optimisés */
                .table th {
                    font-size: 0.85rem;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }

                .badge {
                    font-weight: 500;
                }

                .btn-group-sm .btn {
                    padding: 0.35rem 0.5rem;
                }

                @media (max-width: 768px) {
                    .card-header {
                        flex-direction: column;
                        align-items: flex-start;
                        gap: 0.5rem;
                    }

                    .table-responsive {
                        font-size: 0.9rem;
                    }
                }
            </style>
        @endpush

        @push('scripts')
            <script>
                // Activation des tooltips
                document.addEventListener('DOMContentLoaded', function() {
                    // Tooltips
                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });

                    // Gestion de la suppression
                    document.querySelectorAll('.delete-module').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const moduleId = this.dataset.id;
                            const moduleName = this.dataset.name;

                            document.getElementById('moduleNameToDelete').textContent = moduleName;
                            document.getElementById('deleteModuleForm').action =
                                `/coordonnateur/modules/${moduleId}`;

                            new bootstrap.Modal(document.getElementById('deleteModuleModal')).show();
                        });
                    });
                });
            </script>
        @endpush


    </div>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                // Initialize tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();

                // Filter functionality
                function applyFilters() {
                    const semester = $('#filterSemester').val();
                    const status = $('#filterStatus').val();
                    const search = $('#searchInput').val().toLowerCase();

                    $('.card').each(function() {
                        const card = $(this);
                        const semesterMatch = semester === 'all' || card.find('tbody tr').data('semester') ==
                            semester;
                        const hasVisibleRows = card.find('tbody tr').filter(function() {
                            const rowStatus = $(this).data('status');
                            const rowText = $(this).text().toLowerCase();

                            const statusMatch = status === 'all' || status == rowStatus;
                            const searchMatch = search === '' || rowText.includes(search);

                            return statusMatch && searchMatch;
                        }).toggle(statusMatch && searchMatch).length > 0;

                        card.toggle(semesterMatch && hasVisibleRows);
                    });
                }

                $('#filterSemester, #filterStatus').on('change', applyFilters);
                $('#searchInput').on('keyup', applyFilters);

            });
        </script>
    @endpush
</x-coordonnateur_layout>

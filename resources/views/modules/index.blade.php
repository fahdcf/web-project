<x-coordonnateur_layout>
    <div class="container-fluid px-4 py-4">


        <div class="border d-flex justify-content-between align-items-center mb-4 py-3 border-bottom">
            <div>
                <div>

                    <h1 class="h3 text-gray-800 border"><i class="fas fa-book-open me-2 text-primary"></i> des Unités
                        d'Enseignement</h1>
                    <p class="mb-0 text-muted small border">
                        Filière:
                        <strong>{{ $filiere->name }}</strong>
                        | Coordonnateur:
                        <strong>{{ auth()->user()->lastname }} {{ auth()->user()->firstname }}</strong>
                        .
                    </p>
                </div>

            </div>

            <a class="btn btn-primary border" href="{{ route('coordonnateur.modules.create') }}">
                <i class="fas fa-plus-circle me-1"></i>
                Créer une nouvelle UE
            </a>

        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body py-3">
                <form action="{{ route('coordonnateur.modules.search') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Semestre</label>
                            <select class="form-select form-select-sm" name="filterSemester" id="filterSemester">
                                <option value="all">Tous les semestres</option>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}"
                                        {{ request('filterSemester') == $i ? 'selected' : '' }}>Semestre
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Statut</label>
                            <select class="form-select form-select-sm" name="filterStatus" id="filterStatus">
                                <option value="all">Tous les statuts</option>
                                <option value="active" {{ request('filterStatus') == 'active' ? 'selected' : '' }}>Actif
                                </option>
                                <option value="inactive" {{ request('filterStatus') == 'inactive' ? 'selected' : '' }}>
                                    Inactif</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Recherche</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Code ou intitulé..."
                                    name="searchInput" id="searchInput" value="{{ request('searchInput') }}" />
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            @if (isset($searchResults))
                                <button class="btn btn-sm btn-link" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#searchResultsCollapse"
                                    aria-expanded="{{ isset($searchResults) ? 'true' : 'false' }}"
                                    aria-controls="searchResultsCollapse">
                                    <i class="fas fa-chevron-down me-1"></i>
                                    {{ isset($searchResults) && $searchResults->isNotEmpty() ? 'Masquer les résultats' : 'Afficher les résultats' }}
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="container-fluid px-4 py-4">

        <div class="collapse {{ isset($searchResults) ? 'show' : '' }}" id="searchResultsCollapse">
            @if (isset($searchResults) && $searchResults->isNotEmpty())
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Résultats de la recherche ({{ $searchResults->count() }})</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($searchResults as $module)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $module->name }}</h6>
                                        <small class="text-muted">
                                            Code: {{ $module->code }} | Semestre: S{{ $module->semester }} | Statut:
                                            {{ $module->status ? 'active' : 'inactive' }}
                                        </small>
                                    </div>
                                    <a href="{{ route('coordonnateur.modules.show', $module->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Voir détails
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @elseif (isset($searchResults) && $searchResults->isEmpty())
                <div class="alert alert-info shadow-sm mb-4">Aucun résultat trouvé pour votre recherche.</div>
            @endif
        </div>

        @foreach ($semesters as $semesterName => $modules)
            <div class=" card shadow-lg mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0 py-2">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Semestre: {{ $semesterName }}
                    </h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="text-muted me-2">
                            <i class="fas fa-book me-1"></i>
                            {{ $modules->count() }} Modules
                        </span>
                        <span class="text-muted me-2">
                            <i class="fas fa-hourglass-half me-1"></i>
                            Total: {{ $modules->sum('credits') }} ECTS
                        </span>
                        @if ($modules->where('status', 'inactive')->count() > 0)
                            <span class="badge bg-warning rounded-pill me-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ $modules->where('status', 'inactive')->count() }} Non Assignées
                            </span>
                        @else
                            <span class="badge bg-success rounded-pill me-2">
                                <i class="fas fa-check-circle me-1"></i>
                                Planification OK
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="100">Code UE</th>
                                    <th>Intitulé</th>
                                    <th width="100">Crédits</th>
                                    <th width="150">Volume Horaire</th>
                                    {{-- <th width="200">Assigné à</th> --}}
                                    <th width="100">Statut</th>
                                    <th width="200" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modules as $module)
                                    <tr>
                                        <td class="fw-bold text-primary">{{ $module->code }}</td>
                                        <td>
                                            <div class="d-flex align-items-center fw-bold text-dark">
                                                {{ $module->name }}</div>
                                            <small class="d-flex align-items-center">
                                                <u>respo.:</u>
                                                @if ($module->responsable)
                                                    <strong>
                                                        {{ $module->responsable->lastname }}
                                                        {{ $module->responsable->firstname }}
                                                    </strong>
                                                @endif
                                            </small>
                                        </td>
                                        <td>{{ $module->credits }} ECTS</td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <span class="badge bg-primary-subtle text-primary">
                                                    CM {{ $module->cm_hours }}h
                                                </span>
                                                <span class="badge bg-info-subtle text-info">TD
                                                    {{ $module->td_hours }}h</span>
                                                <span class="badge bg-success-subtle text-success">
                                                    TP {{ $module->tp_hours }}h
                                                </span>
                                            </div>
                                        </td>
                                        {{-- 
                                <td class="align-middle">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        @foreach ($module->users ?? [] as $user)
                                        <div class="position-relative">
                                            <img
                                                src="{{ $user->photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->firstname.'+'.$user->lastname).'&background=random' }}"
                                                class="rounded-circle border border-2 @if ($user->pivot->is_responsible ?? false) border-primary @else border-light @endif"
                                                width="28"
                                                height="28"
                                                alt="{{ $user->firstname }} {{ $user->lastname }}"
                                                data-bs-toggle="tooltip"
                                                data-bs-html="true"
                                                title="<b>{{ $user->firstname }} {{ $user->lastname }}</b><br>
                                                <small>Role: {{ $user->pivot->role ?? 'N/A' }}</small><br>
                                                <small>Charge: {{ $user->pivot->hours ?? 0 }}h</small>">
                                            @if ($user->pivot->is_responsible ?? false)
                                            <span
                                                class="position-absolute bottom-0 end-0 badge bg-primary rounded-circle p-1"
                                                style="width: 12px; height: 12px"></span>
                                            @endif
                                        </div>
                                        @endforeach

                                        <button
                                            class="btn btn-sm btn-action btn-outline-secondary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#assignVacataireModal"
                                            data-module-id="{{ $module->id }}"
                                            data-module-name="{{ $module->name }}"
                                            data-module-code="{{ $module->code }}"
                                            aria-label="Assigner un enseignant">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td> --}}

                                       <td>
    <span
        class="badge rounded-pill 
            @if ($module->status === 'active') bg-success 
            @elseif ($module->status === 'inactive') bg-danger 
            @else bg-secondary @endif">
        <i class="fas 
            @if ($module->status === 'active') fa-check-circle 
            @elseif ($module->status === 'inactive') fa-times-circle 
            @else fa-question-circle @endif me-1">
        </i>
        {{ $module->status }}
    </span>
</td>

                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('coordonnateur.modules.edit', $module->id) }}"
                                                    class="btn btn-outline-primary" title="Modifier"
                                                    aria-label="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('coordonnateur.modules.confirm-delete', $module->id) }}"
                                                    class="btn btn-outline-danger delete-ue"
                                                    data-ue-id="{{ $module->id }}"
                                                    data-ue-name="{{ $module->name }}" title="Supprimer"
                                                    aria-label="Supprimer">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                                <a href="{{ route('coordonnateur.modules.show', $module->id) }}"
                                                    class="btn btn-outline-info" title="Détails"
                                                    aria-label="Détails">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
   {{--  --}}



    <!-- Assign Vacataire Modal -->
    <div class="modal fade" id="assignVacataireModal" tabindex="-1" aria-labelledby="assignVacataireModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="assignVacataireForm" method="POST">
                    @csrf
                    <input type="hidden" name="module_id" id="module_id">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="assignVacataireModalLabel">
                            <i class="fas fa-user-plus me-2"></i>
                            Assigner un enseignant
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Module</label>
                            <input type="text" class="form-control" id="module_name_display" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sélectionner un enseignant</label>
                            <select class="form-select" name="vacataire_id" id="vacataire_id" required>
                                <option value="" selected disabled>Choisir...</option>
                                @foreach ($vacataires as $vacataire)
                                    <option value="{{ $vacataire->id }}">
                                        {{ $vacataire->lastname }} {{ $vacataire->firstname }}
                                        ({{ $vacataire->specialty }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rôle</label>
                            <select class="form-select" name="role" required>
                                <option value="enseignant">Enseignant</option>
                                <option value="responsable">Responsable</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Heures attribuées</label>
                            <input type="number" class="form-control" name="hours" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" id="confirmAssignVacataire">
                            <span class="submit-text">Confirmer</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer l'UE "<span id="ue-name-to-delete"></span>" ?
                    Cette action est irréversible.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteUeForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">
                            <span class="submit-text">Supprimer</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <style>
        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-top: none;
        }

        .table td {
            vertical-align: middle;
        }

        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        .bg-primary-subtle {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .bg-info-subtle {
            background-color: rgba(23, 162, 184, 0.1);
        }

        .bg-success-subtle {
            background-color: rgba(40, 167, 69, 0.1);
        }

        .card {
            border: none;
            border-radius: 0.5rem;
        }

        .btn-action {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .card-header h5 {
                font-size: 1.1rem;
            }

            .btn-group {
                flex-wrap: wrap;
                gap: 0.25rem;
            }
        }
    </style>
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

                // Delete UE confirmation
                $('.delete-ue').click(function(e) {
                    e.preventDefault();
                    const ueId = $(this).data('ue-id');
                    const ueName = $(this).data('ue-name');

                    $('#ue-name-to-delete').text(ueName);
                    $('#deleteUeForm').attr('action', $(this).attr('href'));

                    $('#confirmDeleteModal').modal('show');
                });

                // Assign Vacataire Modal
                $('#assignVacataireModal').on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget);
                    const moduleId = button.data('module-id');
                    const moduleName = button.data('module-name');
                    const moduleCode = button.data('module-code');

                    const modal = $(this);
                    modal.find('#module_id').val(moduleId);
                    modal.find('#module_name_display').val(moduleCode + ' - ' + moduleName);
                });

                // Handle form submission for assigning teacher
                $('#assignVacataireForm').submit(function(e) {
                    e.preventDefault();

                    const submitBtn = $('#confirmAssignVacataire');
                    const submitText = submitBtn.find('.submit-text');
                    const spinner = submitBtn.find('.spinner-border');

                    submitText.addClass('d-none');
                    spinner.removeClass('d-none');
                    submitBtn.prop('disabled', true);

                    $.ajax({
                        url: "{{ route('coordonnateur.modules.assign-vacataire') }}",
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Succès!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Erreur!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'Une erreur est survenue';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                title: 'Erreur!',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        },
                        complete: function() {
                            submitText.removeClass('d-none');
                            spinner.addClass('d-none');
                            submitBtn.prop('disabled', false);
                        }
                    });
                });

                // Handle delete form submission
                $('#deleteUeForm').submit(function(e) {
                    e.preventDefault();

                    const submitBtn = $('#confirmDeleteBtn');
                    const submitText = submitBtn.find('.submit-text');
                    const spinner = submitBtn.find('.spinner-border');

                    submitText.addClass('d-none');
                    spinner.removeClass('d-none');
                    submitBtn.prop('disabled', true);

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Supprimé!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Erreur!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'La suppression a échoué';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                title: 'Erreur!',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        },
                        complete: function() {
                            $('#confirmDeleteModal').modal('hide');
                            submitText.removeClass('d-none');
                            spinner.addClass('d-none');
                            submitBtn.prop('disabled', false);
                        }
                    });
                });
            });
        </script>
    @endpush
</x-coordonnateur_layout>

<x-coordonnateur_layout>
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 py-3 border-bottom">
            <div>
                <h1 class="h3 text-gray-800">
                    <i class="fas fa-book-open me-2 text-primary"></i>
                    Gestion des Unités d'Enseignement
                </h1>
                <p class="mb-0 text-muted small">
                    Filière:
                    <strong>{{ $filiere->name }}</strong>
                    | Coordonnateur:
                    <strong>{{ auth()->user()->lastname }} {{ auth()->user()->firstname }}</strong>
                    .
                </p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUeModal">
                <i class="fas fa-plus-circle me-1"></i>
                Créer une nouvelle UE
            </button>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body py-3">
                <form action="{{ route('coordonnateur.modules.search') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Semestre</label>
                            <select class="form-select form-select-sm" name="filterSemester">
                                <option value="all">Tous les semestres</option>
                                @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}">Semestre {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Statut</label>
                            <select class="form-select form-select-sm" name="filterStatus">
                                <option value="all">Tous les statuts</option>
                                <option value="1">Actif</option>
                                <option value="0">Inactif</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Recherche</label>
                            <div class="input-group input-group-sm">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Code ou intitulé..."
                                    name="searchInput" />
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <button
                                class="btn btn-sm btn-link"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#searchResultsCollapse"
                                aria-expanded="{{ isset($searchResults) }}"
                                aria-controls="searchResultsCollapse">
                                <i class="fas fa-chevron-down me-1"></i>
                                {{ isset($searchResults) && $searchResults->isNotEmpty() ? 'Masquer les résultats' :
                                'Afficher les résultats' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="collapse {{ isset($searchResults) ? 'show' : '' }}" id="searchResultsCollapse">
            @if (isset($searchResults) && $searchResults->isNotEmpty())
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Résultats de la recherche</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($searchResults as $module)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $module->name }}</h6>
                                <small class="text-muted">
                                    Code: {{ $module->code }} | Semestre: S{{ $module->semester }} | Statut: {{
                                    $module->status ? 'Actif' : 'Inactif' }}
                                </small>
                            </div>
                            <a
                                href="{{ route('coordonnateur.modules.show', $module->id) }}"
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

        @foreach ( $semesters as $semesterName=>$modules )

        <div class="card shadow-lg mb-4">
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
                        {{-- Remplacer par le total statique d'ECTS pour ce semestre --}} Total: 30 ECTS
                    </span>
                    @if ($semesterName === 'Semestre 1')
                    <span class="badge bg-warning rounded-pill me-2">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        2 Non Assignées
                    </span>
                    @elseif ($semesterName === 'Semestre 2')
                    <span class="badge bg-success rounded-pill me-2">
                        <i class="fas fa-check-circle me-1"></i>
                        Planification OK
                    </span>
                    @else
                    <span class="text-muted me-2">
                        <i class="fas fa-users me-1"></i>
                        15 Enseignants
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
                                <th width="200">Assignee a</th>
                                {{--
                                <th width="200">Professor assinee</th>
                                --}}

                                <th width="100">Statut</th>
                                <th width="200" class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($modules as $module)

                            <tr>
                                <td class="fw-bold text-primary">{{ $module->code }}</td>
                                <td>
                                    <div class="d-flex align-items-center fw-bold text-dark">{{ $module->name }}</div>
                                    <small class="d-flex align-items-center">
                                        <u>respo.:</u>
                                        @if ($module->responsable)
                                        <strong>
                                            {{ $module->responsable->lastname }} {{ $module->responsable->firstname }}
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
                                        <span class="badge bg-info-subtle text-info">TD {{ $module->td_hours }}h</span>
                                        <span class="badge bg-success-subtle text-success">
                                            TP {{ $module->tp_hours }}h
                                        </span>
                                    </div>
                                </td>
                                {{--
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        @if($module->professor)
                                        <!-- Professeur assigné -->
                                        <div class="d-flex align-items-center flex-grow-1">
                                            <div class="avatar avatar-sm me-3">
                                                <img
                                                    src="{{ $module->professor->photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($module->professor->firstname.'+'.$module->professor->lastname).'&background=4e73df&color=fff' }}"
                                                    class="rounded-circle border border-2 border-white shadow-sm"
                                                    width="36"
                                                    alt="{{ $module->professor->fullname }}"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="{{ $module->professor->email }}" />
                                            </div>
                                            <div>
                                                <span class="d-block fw-semibold text-dark">
                                                    {{ $module->professor->lastname }}
                                                </span>
                                                <small class="text-muted">{{ $module->professor->firstname }}</small>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-icon btn-sm btn-outline-primary ms-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#changeProfessorModal"
                                            data-module-id="{{ $module->id }}"
                                            title="Changer le professeur">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                        @else
                                        <!-- Non assigné -->

                                        <button
                                            class="btn btn-sm btn-success"
                                            data-bs-toggle="modal"
                                            data-bs-target="#assignVacataireModal"
                                            data-module-id="{{ $module->id }}"
                                            title="Assigner un vacataire">
                                            Assigner a un vacataire
                                        </button>
                                        @endif
                                    </div>
                                </td>
                                --}} {{--
                                <th width="200">Assignee a</th>
                                --}}
                                <td class="align-middle">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        @foreach($module->users as $user)
                                        <div class="position-relative">
                                            <img
                                                src="{{ $user->photo_url ?? '...' }}"
                                                class="rounded-circle border border-2 @if($user->pivot->is_responsible) border-primary @else border-light @endif"
                                                width="28"
                                                data-bs-toggle="tooltip"
                                                data-bs-html="true"
                                                title="<b>{{ $user->firstname }}</b><br>
                                                            <small>Role: {{ $user->pivot->role }}</small><br>
                                                            <small>Charge: {{ $user->pivot->hours }}h</small>" />
                                            @if($user->pivot->is_responsible)
                                            <span
                                                class="position-absolute bottom-0 end-0 badge bg-primary rounded-circle p-1"
                                                style="width: 12px; height: 12px"></span>
                                            @endif
                                        </div>
                                        @endforeach

                                        <button
                                            class="btn btn-sm btn-action"
                                            data-bs-toggle="modal"
                                            data-bs-target="#assignVacataireModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>

                                <style>
                                    .btn-action {
                                        width: 28px;
                                        height: 28px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                    }
                                </style>
                                <td>
                                    <span
                                        class="badge rounded-pill @if($module->status === 1) bg-success @elseif($module->status === 0) bg-danger @else bg-warning @endif">
                                        <i
                                            class="fas @if($module->status === 1) fa-check-circle @elseif($module->status === 0) fa-times-circle @else fa-exclamation-circle @endif me-1"></i>
                                        @if($module->status === 1) Actif @elseif($module->status === 0) Inactif @else
                                        Non assigné @endif
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a
                                            href="/coordonnateur/modules/{{ $module->id }}/edit"
                                            class="btn btn-outline-primary"
                                            title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a
                                            href="{{ route('coordonnateur.modules.confirm-delete', $module->id) }}"
                                            class="btn btn-outline-danger delete-ue"
                                            data-ue-id="{{ $module->id }}"
                                            data-ue-name="{{ $module->name }}"
                                            title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>

                                        <a href="/coordonnateur/modules/{{ $module->id }}">
                                            <span class="d-none d-sm-inline "> Details</span>
                                            <span class="d-inline d-sm-none ms-1"> Details</span>
                                        </a>

                                        {{--
                                        <button
                                            class="btn btn-outline-warning assign-vacataire"
                                            data-bs-toggle="modal"
                                            data-bs-target="#assignVacataireModal"
                                            data-ue-id="{{ $module->id }}"
                                            title="Assigner vacataire">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                        --}}
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

        <div class="card shadow-lg mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0 py-2">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Semestre 2
                </h5>
                <div class="d-flex gap-2 flex-wrap">
                    <div class="input-group input-group-sm" style="width: 200px">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Rechercher..." />
                    </div>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus me-1"></i>
                        Ajouter UE a S2
                    </button>
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
                                <th width="200">mohssine</th>
                                <th width="100">Statut</th>
                                <th width="150" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Module Assigné -->
                            <tr>
                                <td class="fw-bold text-primary">GI1-M2</td>
                                <td>
                                    <div class="d-flex align-items-center">Algorithmique et Structures de Données</div>
                                </td>
                                <td>6 ECTS</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        <span class="badge bg-primary-subtle text-primary">CM 35h</span>
                                        <span class="badge bg-info-subtle text-info">TD 15h</span>
                                        <span class="badge bg-success-subtle text-success">TP 20h</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 position-relative">
                                            <img
                                                src="https://ui-avatars.com/api/?name=P+Dupont&background=4e73df&color=fff"
                                                class="rounded-circle"
                                                width="25"
                                                alt="Prof. Dupont" />
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Prof. Dupont</div>
                                        </div>
                                        <button
                                            class="btn btn-sm btn-outline-secondary ms-auto"
                                            data-bs-toggle="modal"
                                            data-bs-target="#changeProfessorModal"
                                            title="Changer professeur">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-success rounded-pill">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Actif
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a
                                            href="/coordonnateur/modules/5/edit"
                                            class="btn btn-outline-primary"
                                            title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <button
                                            class="btn btn-outline-danger delete-ue"
                                            data-ue-id="5"
                                            data-ue-name="Bases de Données"
                                            title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <!-- View Button -->
                                        <button
                                            type="button"
                                            class="btn btn-outline-success d-flex align-items-center justify-content-center px-2 py-1 flex-sm-grow-0 flex-grow-1">
                                            <span class="d-none d-sm-inline">Details</span>
                                            <span class="d-inline d-sm-none ms-1">Details</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Module Non Assigné -->
                            <tr class="table-warning">
                                <td class="fw-bold text-primary">GI2-M4</td>
                                <td>
                                    <div class="d-flex align-items-center">Programmation Web</div>
                                </td>
                                <td>6 ECTS</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        <span class="badge bg-primary-subtle text-primary">CM 30h</span>
                                        <span class="badge bg-info-subtle text-info">TD 15h</span>
                                        <span class="badge bg-success-subtle text-success">TP 15h</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center text-warning">
                                        <i class="fas fa-exclamation-circle fs-5 me-2"></i>
                                        <span class="me-2">Non assigné</span>
                                        <button
                                            class="btn btn-sm btn-success ms-auto"
                                            data-bs-toggle="modal"
                                            data-bs-target="#assignVacataireModal">
                                            <i class="fas fa-user-plus me-1"></i>
                                            Assigner
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-success rounded-pill">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Actif
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a
                                            href="/coordonnateur/modules/5/edit"
                                            class="btn btn-outline-primary"
                                            title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <button
                                            class="btn btn-outline-danger delete-ue"
                                            data-ue-id="5"
                                            data-ue-name="Bases de Données"
                                            title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <!-- View Button -->
                                        <button
                                            type="button"
                                            class="btn btn-outline-success d-flex align-items-center justify-content-center px-2 py-1 flex-sm-grow-0 flex-grow-1">
                                            <span class="d-none d-sm-inline">Details</span>
                                            <span class="d-inline d-sm-none ms-1">Details</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{--
                <div class="card-footer bg-white">
                    <nav aria-label="Pagination">
                        <ul class="pagination justify-content-center mb-0">
                            <li class="page-item disabled">
                                <span class="page-link">Précédent</span>
                            </li>
                            <li class="page-item active">
                                <span class="page-link">1</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Suivant</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                --}}
            </div>
        </div>

        {{-- assignVacataireModal --}}
        <div class="modal fade" id="assignVacataireModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title">
                            <i class="fas fa-user-plus me-2"></i>
                            Assigner un vacataire
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Module</label>
                            <input type="text" class="form-control" value="GI2-M4 - Programmation Web" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sélectionner un vacataire</label>
                            <a href="#">Ajouter un vacataire</a>

                            <select class="form-select">
                                <option selected disabled>Choisir...</option>
                                <option>Prof. Martin (Informatique)</option>
                                <option>Prof. Durand (Développement Web)</option>
                                <option>Prof. Lefèvre (Base de données)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Confirmer</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- changeProfessorModal
        <div class="modal fade" id="changeProfessorModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title">
                            <i class="fas fa-exchange-alt me-2"></i>
                            Changer de professeur
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Actuellement assigné à
                            <strong>Prof. Dupont</strong>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nouveau professeur</label>
                            <select class="form-select">
                                <option selected disabled>Choisir...</option>
                                <option>Prof. Martin (Informatique)</option>
                                <option>Prof. Durand (Développement Web)</option>
                                <option>Prof. Lefèvre (Base de données)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger me-auto">
                            <i class="fas fa-user-minus me-1"></i>
                            Désassigner
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
        --}}

        <style>
            .table-warning {
                --bs-table-bg: rgba(255, 193, 7, 0.05);
            }
            .badge.bg-primary-subtle {
                background-color: rgba(13, 110, 253, 0.1);
            }
            .badge.bg-info-subtle {
                background-color: rgba(13, 202, 240, 0.1);
            }
            .badge.bg-success-subtle {
                background-color: rgba(25, 135, 84, 0.1);
            }
        </style>
        {{-- --}} {{-- --}} {{-- --}}
    </div>
    {{-- modals --}}

    <div
        class="modal fade"
        id="confirmDeleteModal"
        tabindex="-1"
        aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer l'UE "
                    <span id="ue-name-to-delete"></span>
                    " (ID:
                    <span id="ue-id-to-delete"></span>
                    ) ? Cette action est irréversible.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    {{-- createUeModal --}}
    <div class="modal fade" id="createUeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Créer une nouvelle UE</h5>
                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('coordonnateur.modules.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    Code UE
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="code" value="GI-M-TEMP" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    Intitulé
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    value="Nom UE Temporaire"
                                    required />
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Semestre
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="semestre" required>
                                    <option value="1" selected>Semestre 1</option>
                                    <option value="2">Semestre 2</option>
                                    <option value="3">Semestre 3</option>
                                    <option value="4">Semestre 4</option>
                                    <option value="5">Semestre 5</option>
                                    <option value="6">Semestre 6</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">
                                    Crédits ECTS
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" name="credits" value="1" min="1" required />
                            </div>

                            <div class="col-12">
                                <h6 class="border-bottom pb-2 mb-3">Volume Horaire</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            CM (heures)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            name="cm_hours"
                                            value="0"
                                            min="0"
                                            required />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            TD (heures)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            name="td_hours"
                                            value="0"
                                            min="0"
                                            required />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            TP (heures)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            name="tp_hours"
                                            value="0"
                                            min="0"
                                            required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <h6 class="border-bottom pb-2 mb-3">Nombre de groupes</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Groupes TD
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            name="nb_groupes_td"
                                            value="1"
                                            min="1"
                                            required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Groupes TP
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            name="nb_groupes_tp"
                                            value="1"
                                            min="1"
                                            required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Spécialité</label>
                                <input type="text" class="form-control" name="specialty" value="Informatique" />
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Responsable</label>
                                <select class="form-select" name="responsable_id">
                                    <option value="">Sélectionner un enseignant</option>
                                    <option value="1">Nom Enseignant 1 Prénom Enseignant 1</option>
                                    <option value="2">Nom Enseignant 2 Prénom Enseignant 2</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">
                                    Statut
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="statut" required>
                                    <option value="actif" selected>Actif</option>
                                    <option value="inactif">Inactif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer comme brouillon</button>
                        <button type="submit" class="btn btn-primary">Creer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            function applyFilters() {
                const semester = $('#filterSemester').val();
                const status = $('#filterStatus').val();
                const search = $('#searchInput').val().toLowerCase();

                $('tbody tr').each(function () {
                    const rowSemester = $(this).data('semester');
                    const rowStatus = $(this).data('status');
                    const rowText = $(this).text().toLowerCase();

                    const semesterMatch = semester === 'all' || semester == rowSemester;
                    const statusMatch = status === 'all' || status === rowStatus;
                    const searchMatch = rowText.includes(search);

                    $(this)
                        .closest('.card')
                        .toggle(semesterMatch || semester === 'all');
                    $(this).toggle(semesterMatch && statusMatch && searchMatch);
                });

                // Show/hide card headers based on visible content
                $('.card-body tbody').each(function () {
                    const visibleRows = $(this).find('tr:visible').length;
                    $(this)
                        .closest('.card')
                        .find('.card-header')
                        .toggle(visibleRows > 0);
                });
            }

            $('#filterSemester, #filterStatus, #searchInput').on('change keyup', applyFilters);
            $('#searchButton').click(applyFilters);

            $('.delete-ue').click(function () {
                const ueId = $(this).data('ue-id');
                const ueName = $(this).data('ue-name');

                Swal.fire({
                    title: `Supprimer l'UE "${ueName}" ?`,
                    text: 'Cette action est irréversible.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/coordonnateur/modules/${ueId}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function () {
                                Swal.fire('Supprimé!', "L'UE a été supprimée.", 'success').then(() =>
                                    location.reload(),
                                );
                            },
                            error: function () {
                                Swal.fire('Erreur!', 'La suppression a échoué.', 'error');
                            },
                        });
                    }
                });
            });

            $('.assign-vacataire').click(function () {
                const ueId = $(this).data('ue-id');
                const ueName = $(this).closest('tr').find('td:eq(1)').text();

                $('#assigned_ue_id').val(ueId);
                $('#selectedUeName').val(ueName);
                $('#vacataire_id').val('');
            });

            $('#confirmAssignVacataire').click(function () {
                const ueId = $('#assigned_ue_id').val();
                const vacataireId = $('#vacataire_id').val();

                if (!vacataireId) {
                    Swal.fire('Erreur', 'Veuillez sélectionner un vacataire', 'error');
                    return;
                }

                $.ajax({
                    url: `/coordonnateur/ues/${ueId}/assign-vacataire`,
                    type: 'POST',
                    data: {
                        vacataire_id: vacataireId,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Succès!', 'UE assignée avec succès', 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Erreur!', response.message || 'Assignation échouée', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Erreur!', 'Une erreur est survenue', 'error');
                    },
                });
            });
        });
    </script>
    @endpush @push('styles')
    <style>
        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-: 0.5px;
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

        .bg-light-primary {
            background-color: rgba(13, 110, 253, 0.1);
        }
        .bg-light-info {
            background-color: rgba(23, 162, 184, 0.1);
        }
        .bg-light-success {
            background-color: rgba(40, 167, 69, 0.1);
        }
        .bg-light-warning {
            background-color: rgba(255, 193, 7, 0.1);
        }
        .bg-light-danger {
            background-color: rgba(220, 53, 69, 0.1);
        }
        .bg-light-secondary {
            background-color: rgba(108, 117, 125, 0.1);
        }

        .card {
            border: none;
            border-radius: 0.5rem;
        }

        .modal-header {
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
    </style>
    @endpush
</x-coordonnateur_layout>

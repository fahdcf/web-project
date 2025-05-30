<x-coordonnateur_layout>
    <div class="container-fluid px-4 py-5">
        <x-global_alert />
        <!-- Header Section -->
        <div class="header-container mb-4">
            <style>
                .header-container {
                    background: white;
                    border-radius: 8px;
                    padding: 20px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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



                .dropdown-menu {
                    border-radius: 6px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                }

                .dropdown-item:hover {
                    background-color: #f8f9fa;
                    color: #4723d9;
                }

                .modal-content {
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                }

                .modal-header {
                    border-bottom: 1px solid #e0e0e0;
                }

                .modal-footer {
                    border-top: 1px solid #e0e0e0;
                }

                .form-control:focus {
                    border-color: #4723d9;
                    box-shadow: 0 0 0 2px rgba(71, 35, 217, 0.2);
                }

                .header-grid {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 1rem;
                    align-items: center;
                    justify-content: space-between;
                }

                @media (max-width: 992px) {
                    .header-grid {
                        flex-direction: column;
                        align-items: stretch;
                    }

                    .header-title {
                        text-align: center;
                        margin-bottom: 1rem;
                        text-decoration: underline;
                    }
                }

                @media (max-width: 768px) {
                    .header-container {
                        padding: 15px;
                    }

                    .header-title {
                        font-size: 1.5rem;
                    }

                    .header-grid>* {
                        width: 100%;
                    }

                    .btn-primary,
                    .btn-success {
                        width: 100%;
                        text-align: center;
                    }
                }


                .modal-content {
                    max-width: 90%;
                    animation: fadeIn 0.3s;
                }

                @media (max-width: 768px) {
                    .modal-content {
                        max-width: 95%;
                        margin: 1rem;
                    }
                }
            </style>

            <div class="header-grid mt">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-book-open fa-2x" style="color: #330bcf;"></i>
                    <h3 style="color: #330bcf; font-weight: 500;">Gestion des Unités d'Enseignement</h3>
                </div>
                <div class="d-flex  gap-2 flex-wrap  ">
                    <a href="{{ route('coordonnateur.modules.create') }}" class="btn btn-primary rounded fw-semibold">
                        <i class="fas fa-plus-circle"></i> Nouvelle UE
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-success rounded fw-semibold dropdown-toggle" type="button"
                            id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-file-export"></i> Exporter
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('coordonnateur.modules.export', ['semester' => 'all']) }}">
                                    Tous les Semestres
                                </a>
                            </li>
                            @for ($i = 1; $i <= 6; $i++)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('coordonnateur.modules.export', ['semester' => $i]) }}">
                                        {{ $i == 1 ? '1er' : $i . 'ème' }} Semestre
                                    </a>
                                </li>
                            @endfor
                        </ul>
                    </div>
                    <div>
                        <button class="btn btn-success rounded fw-semibold" type="button" id="importDropdown"
                            data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-file-import"></i> Importer
                        </button>
                    </div>
                </div>
            </div>

            
        </div>
        <!-- Add at the bottom of the Blade file, outside any other containers -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-white rounded-3 p-4 shadow-lg">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-primary fw-bold" id="importModalLabel">
                            <i class="fas fa-file-import me-2"></i> Importer des Unités d'Enseignement
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Fermer"></button>
                    </div>
                    <form action="{{ route('coordonnateur.modules.import') }}" method="POST"
                        enctype="multipart/form-data" id="importForm">
                        @csrf
                        <div class="modal-body">
                            @error('excel_file')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="mb-3">
                                <label for="excelFile" class="form-label small fw-medium">Fichier Excel
                                    (.xlsx)</label>
                                <input type="file" class="form-control rounded-3" id="excelFile"
                                    name="excel_file" accept=".xlsx, .xls" required
                                    aria-describedby="excelFileHelp">
                                <small id="excelFileHelp" class="form-text text-muted">
                                    Téléchargez un fichier Excel avec les colonnes : Nom, Code, Semestre,
                                    Responsable ID.
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                data-bs-dismiss="modal" aria-label="Annuler">
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium"
                                aria-label="Importer le fichier">
                                <i class="fas fa-upload me-2"></i> Importer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="header-container mb-4">
            <div class="row g-2">
                <div class="col-md-3 col-sm-6 col-lg-3 filter-dropdown">
                    <label for="semester" class="form-label small fw-bold text-muted">Semestre</label>
                    <select id="semester" class="form-select border border-primary text-primary"
                        style="font-weight: 500;" onchange="applyFilters()">
                        <option value="all" {{ request('semester') == 'all' ? 'selected' : '' }}>Tous</option>
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>
                                {{ $i == 1 ? '1er' : $i . 'ème' }} Semestre
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3  col-sm-6 col-lg-3 filter-dropdown">
                    <label for="status" class="form-label small fw-bold text-muted">Statut</label>
                    <select id="status" class="form-select border border-primary text-primary"
                        style="font-weight: 500;" onchange="applyFilters()">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tous</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                            Actif
                        </option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                            Inactif
                        </option>
                    </select>
                </div>

                <div class="col-md-6 col-sm-12 col-lg-6 search-bar">
                    <label for="moduleSearch" class="form-label small fw-bold text-muted">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0" id="moduleSearch"
                            placeholder="Rechercher par nom ou code...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Import Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Importer des Unités d'Enseignement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('coordonnateur.modules.import') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="file" class="form-label">Sélectionner un fichier CSV</label>
                                <input type="file" class="form-control" id="file" name="file"
                                    accept=".csv" required>
                                <small class="text-muted">Format attendu : Nom, Code, Type, Heures CM, Heures TD,
                                    Heures TP, Semestre, Statut, Crédit, Évaluation, Description, Responsable</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-success">Importer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir supprimer cette unité d'enseignement ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <form id="deleteForm" action="" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Module Grid -->
        <div class="header-container mb-4">
            <div class="module-grid">
                {{-- @forelse ($modules as $module)
                    <div class="module-card" data-semester="{{ $module->semester }}"
                        data-status="{{ $module->status }}">
                        <div class="module-header">
                            <div class="module-title-container">
                                <h3 class="module-name">{{ $module->name }}</h3>
                                <div class="module-hours-badge">{{ $module->code }}</div>
                            </div>
                            <div class="module-workload">
                                <div class="workload-item">
                                    <span class="workload-label">CM</span>
                                    <span class="workload-value">{{ $module->cm_hours }}h</span>
                                </div>
                                <div class="workload-item">
                                    <span class="workload-label">TD</span>
                                    <span class="workload-value">{{ $module->td_hours }}h</span>
                                </div>
                                <div class="workload-item">
                                    <span class="workload-label">TP</span>
                                    <span class="workload-value">{{ $module->tp_hours }}h</span>
                                </div>
                            </div>
                        </div>

                        <div class="module-details">
                            <!-- Crédit -->
                            <div class="detail-item">
                                <i class="bi bi-award-fill detail-icon"></i>
                                <div>
                                    <span class="detail-label">Crédit</span>
                                    <span class="detail-value">{{ $module->credit ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- Évaluation -->
                            <div class="detail-item">
                                <i class="bi bi-clipboard-check detail-icon"></i>
                                <div>
                                    <span class="detail-label">Évaluation</span>
                                    <span class="detail-value">{{ $module->evaluation ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- Responsable -->
                            <div class="detail-item">
                                <i class="bi bi-person-fill detail-icon"></i>
                                <div>
                                    <span class="detail-label">Responsable</span>
                                    <span class="detail-value">
                                        @if ($module->responsable)
                                            {{ $module->responsable->firstname }} {{ $module->responsable->lastname }}
                                        @else
                                            Non assigné
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Filière -->
                            <div class="detail-item">
                                <i class="bi bi-building detail-icon"></i>
                                <div>
                                    <span class="detail-label">Filière</span>
                                    <span class="detail-value">{{ $module->filiere->name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- Semestre & Status -->
                            <div class="detail-item">
                                <i class="bi bi-calendar-week detail-icon"></i>
                                <div>
                                    <span class="detail-label">Semestre</span>
                                    <span class="detail-value">
                                        {{ $module->semester == 1 ? '1er Semestre' : ($module->semester ? $module->semester . 'ème Semestre' : 'N/A') }}
                                        <span
                                            class="badge {{ $module->status == 'active' ? 'bg-success' : 'bg-warning' }} ms-2">
                                            {{ $module->status == 'active' ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <!-- Type -->
                            <div class="detail-item">
                                <i class="bi bi-tag-fill detail-icon"></i>
                                <div>
                                    <span class="detail-label">Type</span>
                                    <span class="detail-value">{{ $module->type }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="module-actions">
                            <a href="{{ route('coordonnateur.modules.show', $module) }}" class="view-btn">
                                <i class="bi bi-eye-fill"></i> Voir plus
                            </a>
                            <button class="remove-btn" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                onclick="setDeleteFormAction('{{ route('coordonnateur.modules.destroy', $module) }}')">
                                <i class="bi bi-trash-fill"></i> Supprimer
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-journal-x"></i>
                        <p>Aucune unité d'enseignement trouvée.</p>
                    </div>
                @endforelse --}}

                @forelse ($modules as $module)
                    <div class="module-card" data-semester="{{ $module->semester }}"
                        data-status="{{ $module->status }}">
                        <div class="module-header">
                            <div class="module-title-container">
                                <h3 class="module-name">{{ $module->name }}</h3>
                                <div class="module-hours-badge">{{ $module->code }}</div>
                            </div>
                            <div class="module-workload">
                                <div class="workload-item">
                                    <span class="workload-label">CM</span>
                                    <span class="workload-value">{{ $module->cm_hours }}h</span>
                                </div>
                                <div class="workload-item">
                                    <span class="workload-label">TD</span>
                                    <span class="workload-value">{{ $module->td_hours }}h</span>
                                </div>
                                <div class="workload-item">
                                    <span class="workload-label">TP</span>
                                    <span class="workload-value">{{ $module->tp_hours }}h</span>
                                </div>
                            </div>
                        </div>

                        <div class="module-details">



                            <!-- Responsable -->
                            <div class="detail-item">
                                <i class="bi bi-person-fill detail-icon"></i>
                                <div>
                                    <span class="detail-label">Responsable</span>
                                    <span class="detail-value">
                                        @if ($module->responsable)
                                            {{ $module->responsable->firstname }} {{ $module->responsable->lastname }}
                                        @else
                                            Non assigné
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <!-- Évaluation -->
                            <div class="detail-item">
                                <i class="bi bi-clipboard-check detail-icon"></i>
                                <div>
                                    <span class="detail-label">Évaluation</span>
                                    <span class="detail-value">{{ $module->evaluation ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- Filière -->
                            <div class="detail-item">
                                <i class="bi bi-building detail-icon"></i>
                                <div>
                                    <span class="detail-label">Filière</span>
                                    <span class="detail-value">{{ $module->filiere->name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- Semester & Status -->
                            <div class="detail-item">
                                <i class="bi bi-calendar-week detail-icon"></i>
                                <div>
                                    <span class="detail-label">Semester</span>
                                    <span class="detail-value">
                                        {{ $module->semester == 1 ? '1er Semestre' : '2ème Semestre' }}
                                        <span
                                            class="badge {{ $module->status == 'active' ? 'bg-success' : 'bg-warning' }} ms-2">
                                            {{ $module->status }}
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <!-- Type -->
                            <div class="detail-item">
                                <i class="bi bi-tag-fill detail-icon"></i>
                                <div>
                                    <span class="detail-label">Type</span>
                                    <span class="detail-value">{{ $module->type }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="module-actions">
                            <button class="view-btn"
                                onclick="showPopup({{ $module->id }}, '{{ $module->name }}')">
                                <i class="bi bi-eye-fill"></i> Voir plus
                            </button>
                             <button class="remove-btn" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                onclick="setDeleteFormAction('{{ route('coordonnateur.modules.destroy', $module) }}')">
                                <i class="bi bi-trash-fill"></i> Supprimer
                            </button>


                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-journal-x"></i>
                        <p>Aucune unité d'enseignement trouvée.</p>
                    </div>
                @endforelse
            </div>




        </div>


        <!-- Popup Template -->
        @foreach ($modules as $module)
            <!-- Details Popup -->
            <div id="popupfor{{ $module->id }}" class="overlay">
                <div class="popup bg-white rounded-3 shadow-lg">
                    <div class="popup-header">
                        <h5 class=" fw-bold mb-0"><i class="bi bi-book me-2"></i>Détails du module</h5>
                        <button type="button" class="btn btn-sm btn-outline-light"
                            onclick="closePopup({{ $module->id }})"> <i class="bi bi-x-lg"></i></button>
                    </div>

                    <div class="popup-body">
                        <div class="module-title mb-4">
                            <h4 class="fw-bold text-dark" id="moduleName{{ $module->id }}">{{ $module->name }}
                            </h4>
                            <span class="text-muted fs-6">Module CODE: {{ $module->code }}</span>
                        </div>

                        <div class="row g-3">
                            <!-- General Information -->
                            <div class="col-12">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <h6 class="fw-semibold text-dark mb-3"><i
                                                class="bi bi-info-circle me-2 text-primary"></i>Informations générales
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <span class="detail-label" style="padding-top: 4px">Type :</span>
                                                    <span class="detail-value ">{{ $module->type }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <span class="detail-label" style="padding-top: 4px">Crédit</span>
                                                    <span class="detail-value">{{ $module->credit }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <span class="detail-label"
                                                        style="padding-top: 4px">Évaluation</span>
                                                    <span class="detail-value">{{ $module->evaluation }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <span class="detail-label" style="padding-top: 4px">Date de
                                                        création</span>
                                                    <span
                                                        class="detail-value">{{ $module->created_at->format('d/m/Y') }}</span>
                                                </div>
                                            </div>
                                            @if ($module->responsable)
                                                <div class="col-12">
                                                    <div class="detail-item">
                                                        <span class="detail-label"
                                                            style="padding-top: 4px">Responsable</span>
                                                        <span
                                                            class="detail-value">{{ $module->responsable->firstname }}
                                                            {{ $module->responsable->lastname }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Teaching Roles -->
                            <div class="col-12">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <h6 class="fw-semibold text-dark mb-3"><i
                                                class="bi bi-person-fill-gear me-2 text-primary"></i>Enseignants</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4 col-6">
                                                <div class="role-item">
                                                    <i class="bi bi-journal-text fs-5 text-info"></i>
                                                    <div>
                                                        <span class="role-label">Cours</span>
                                                        <span class="role-value">
                                                            @if ($module->ProfCours)
                                                                {{ $module->ProfCours->firstname }}
                                                                {{ $module->ProfCours->lastname }}
                                                            @else
                                                                <span style="color: #e74c3c">Non assigné</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <div class="role-item">
                                                    <i class="bi bi-people-fill fs-5 text-warning"></i>
                                                    <div>
                                                        <span class="role-label">TD</span>
                                                        <span class="role-value">
                                                            @if ($module->ProfTd)
                                                                {{ $module->ProfTd->firstname }}
                                                                {{ $module->ProfTd->lastname }}
                                                            @else
                                                                <span style="color: #e74c3c">Non assigné</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-6">
                                                <div class="role-item">
                                                    <i class="bi bi-laptop fs-5 text-success"></i>
                                                    <div>
                                                        <span class="role-label">TP</span>
                                                        <span class="role-value">
                                                            @if ($module->ProfTp)
                                                                {{ $module->ProfTp->firstname }}
                                                                {{ $module->ProfTp->lastname }}
                                                            @else
                                                                <span style="color: #e74c3c">Non assigné</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            @if ($module->description)
                                <div class="col-12">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <h6 class="fw-semibold text-dark mb-3"><i
                                                    class="bi bi-text-paragraph me-2 text-primary"></i>Description</h6>
                                            <p class="mb-0 text-dark">{{ $module->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="popup-footer">
                        <a href="{{ route('coordonnateur.modules.edit', $module) }}"
                            class="btn btn-success px-4 rounded-pill">
                            <i class="bi bi-pencil-square me-1"></i> Modifier
                        </a>
                        <button type="button" style="background:#4723d9; color: white;"
                            class="btn btn-primary px-4 rounded-pill" onclick="closePopup({{ $module->id }})">
                            <i class="bi bi-x-lg me-1"></i>Fermer
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        <style>
            :root {
                --primary: #4723d9;
            }

            body {
                background-color: #f8f9fa;
            }

            .module-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
                padding: 10px;
            }

            .module-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                overflow: hidden;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                border: 1px solid #4723d91e;
                display: flex;
                flex-direction: column;
            }

            .module-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            }

            .module-header {
                padding: 16px 20px;
                background: linear-gradient(135deg, #4723d9 0%, #6047c7 100%);
                border-bottom: 1px solid #e0e0e0;
            }

            .module-title-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
            }

            .module-name {
                margin: 0;
                font-size: 1.2rem;
                font-weight: 600;
                color: #f0f0f0;
                flex: 1;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .module-hours-badge {
                background: #ffffff14;
                color: white;
                padding: 4px 10px;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 600;
                margin-left: 10px;
            }

            .module-workload {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
            }

            .workload-item {
                display: flex;
                align-items: center;
                gap: 4px;
                background: white;
                padding: 4px 10px;
                border-radius: 6px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .workload-label {
                font-weight: 600;
                font-size: 0.8rem;
                color: #5d596e8c;
            }

            .workload-value {
                font-weight: 600;
                font-size: 0.85rem;
                color: #2c3e50;
            }

            .module-details {
                padding: 16px 20px;
                display: grid;
                gap: 14px;
                flex: 1;
            }

            .detail-item {
                display: flex;
                align-items: flex-start;
                gap: 12px;
            }

            .detail-icon {
                color: #4723d9;
                font-size: 1rem;
                margin-top: 2px;
            }

            .detail-label {
                display: block;
                font-size: 0.75rem;
                color: #95a5a6;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .detail-value {
                display: block;
                font-size: 0.95rem;
                font-weight: 500;
                color: #34495e;
                margin-top: 2px;
            }

            .module-actions {
                padding: 12px 20px;
                border-top: 1px solid #f0f0f0;
                display: flex;
                justify-content: space-between;
                gap: 10px;
            }

            .view-btn,
            .remove-btn {
                background: none;
                font-size: 0.9rem;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 8px 12px;
                border-radius: 6px;
                transition: all 0.2s ease;
                flex: 1;
                justify-content: center;
                text-decoration: none;
                border: 1px solid;
                line-height: 1.5;
                height: 38px;
                /* Fixed height for consistency */
            }

            .view-btn {
                border-color: #4723d9;
                color: #4723d9;
            }

            .view-btn:hover {
                background: rgba(71, 35, 217, 0.1);
            }

            .remove-btn {
                border-color: #e74c3c;
                color: #e74c3c;
            }

            .remove-btn:hover {
                background: rgba(231, 76, 60, 0.1);
            }

            .view-btn i,
            .remove-btn i {
                font-size: 0.95rem;
            }

            .badge {
                font-size: 0.75rem;
                font-weight: 500;
                padding: 0.25em 0.6em;
            }

            .empty-state {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 40px 20px;
                text-align: center;
                color: #6c757d;
                font-size: 1.1rem;
            }

            .search-bar {
                min-width: 250px;
                flex-grow: 1;
            }

            @media (max-width: 768px) {
                .search-bar {
                    min-width: 100%;
                    order: -1;
                }

                .module-grid {
                    grid-template-columns: 1fr;
                }

                .module-card {
                    min-width: 100%;
                }

                .module-workload {
                    flex-direction: column;
                    gap: 8px;
                }

                .module-details {
                    grid-template-columns: 1fr;
                }

                .module-actions {
                    flex-direction: column;
                    gap: 8px;
                }

                .view-btn,
                .remove-btn {
                    width: 100%;
                }
            }

            @media (max-width: 576px) {
                .row.g-3 {
                    flex-direction: column;
                }

                .filter-dropdown,
                .search-bar {
                    width: 100%;
                }
            }
        </style>
        <style>
            :root {
                --primary: #4723d9;
            }

            body {
                background-color: #f8f9fa;
            }

            /* Modules Grid with Scroll */

            .module-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 20px;
                padding: 10px;
            }

            .module-card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                overflow: hidden;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                border: 1px solid #4723d91e;
                display: flex;
                flex-direction: column;
            }

            .module-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            }

            .module-header {
                padding: 16px 20px;
                background: linear-gradient(135deg, #4723d9 0%, #6047c7 100%);
                border-bottom: 1px solid #e0e0e0;
            }

            .module-title-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
            }

            .module-name {
                margin: 0;
                font-size: 1.2rem;
                font-weight: 600;
                color: #f0f0f0;
                flex: 1;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .module-hours-badge {
                background: #ffffff14;
                color: white;
                padding: 4px 10px;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 600;
                margin-left: 10px;
            }

            .module-workload {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
            }

            .workload-item {
                display: flex;
                align-items: center;
                gap: 4px;
                background: white;
                padding: 4px 10px;
                border-radius: 6px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .workload-label {
                font-weight: 600;
                font-size: 0.8rem;
                color: #5d596e8c;
            }

            .workload-value {
                font-weight: 600;
                font-size: 0.85rem;
                color: #2c3e50;
            }

            .module-details {
                padding: 16px 20px;
                display: grid;
                gap: 14px;
                flex: 1;
            }

            .detail-item {
                display: flex;
                align-items: flex-start;
                gap: 12px;
            }

            .detail-icon {
                color: #4723d9;
                font-size: 1rem;
                margin-top: 2px;
            }

            .detail-label {
                display: block;
                font-size: 0.75rem;
                color: #95a5a6;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .detail-value {
                display: block;
                font-size: 0.95rem;
                font-weight: 500;
                color: #34495e;
                margin-top: 2px;
            }

            .module-actions {
                padding: 12px 20px;
                border-top: 1px solid #f0f0f0;
                background: #f9f9f9;
                display: flex;
                justify-content: space-between;
                gap: 10px;
            }

            .view-btn {
                background: none;
                border: 1px solid #4723d9;
                color: #4723d9;
                font-size: 0.9rem;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 6px 12px;
                border-radius: 6px;
                transition: all 0.2s ease;
                flex: 1;
                justify-content: center;
            }

            .view-btn:hover {
                background: rgba(71, 35, 217, 0.1);
            }

            .remove-btn {
                background: none;
                border: 1px solid #e74c3c;
                color: #e74c3c;
                font-size: 0.9rem;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 6px 12px;
                border-radius: 6px;
                transition: all 0.2s ease;
                flex: 1;
                justify-content: center;
            }

            .remove-btn:hover {
                background: rgba(231, 76, 60, 0.1);
            }

            .view-btn i,
            .remove-btn i {
                font-size: 0.95rem;
            }

            .badge {
                font-size: 0.75rem;
                font-weight: 500;
                padding: 0.25em 0.6em;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: none;
                justify-content: center;
                align-items: center;
                z-index: 1050;
                backdrop-filter: blur(4px);
            }

            .popup {
                animation: popIn 0.3s ease-out;
                width: 100%;
                max-width: 600px;
                margin: 1rem;
                border-radius: 8px !important;
            }

            .popup-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 1.5rem;
                border-bottom: 1px solid #e9ecef;
                background: #4723d9;
                border-radius: 8px 8px 0 0;
                color: white !important;
            }



            .popup-body {
                padding: 1.5rem;
                max-height: 60vh;
                overflow-y: auto;
            }

            .popup-footer {
                padding: 1rem 1.5rem;
                border-top: 1px solid #e9ecef;
                text-align: right;
                background: #f8f9fa;
                border-radius: 0 0 8px 8px;
            }

            .role-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px;
                background: #fff;
                border-radius: 6px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                transition: transform 0.2s ease;
            }

            .role-item:hover {
                transform: translateY(-2px);
            }

            .role-label {
                display: block;
                font-size: 0.75rem;
                color: #95a5a6;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .role-value {
                display: block;
                font-size: 0.9rem;
                font-weight: 500;
                color: #34495e;
            }



            @media (max-width: 768px) {
                .popup {
                    max-width: 95%;
                    margin: 1rem;
                }
            }

            .btn-close {
                color: white !important;
            }
        </style>



        <script>
            let searchFilter = '';
            let semesterFilter = document.getElementById('semester').value;
            let statusFilter = document.getElementById('status').value;

            document.getElementById('moduleSearch').addEventListener('input', function() {
                searchFilter = this.value.toLowerCase();
                applyFilters();
            });

            function applyFilters() {
                semesterFilter = document.getElementById('semester').value;
                statusFilter = document.getElementById('status').value;

                const moduleCards = document.querySelectorAll('.module-card');

                moduleCards.forEach(card => {
                    const moduleName = card.querySelector('.module-name').textContent.toLowerCase();
                    const moduleCode = card.querySelector('.module-hours-badge').textContent.toLowerCase();
                    const semester = card.getAttribute('data-semester') || '';
                    const status = card.getAttribute('data-status') || '';

                    const searchMatch = searchFilter === '' ||
                        moduleName.includes(searchFilter) ||
                        moduleCode.includes(searchFilter);
                    const semesterMatch = semesterFilter === 'all' || semester === semesterFilter;
                    const statusMatch = statusFilter === 'all' || status === statusFilter;

                    card.style.display = searchMatch && semesterMatch && statusMatch ? 'block' : 'none';
                });
            }

            function setDeleteFormAction(action) {
                document.getElementById('deleteForm').action = action;
            }

            applyFilters();



            // Existing popup functions
            function showPopup(moduleId, moduleName) {
                document.getElementById('moduleName' + moduleId).innerText = moduleName;
                document.getElementById("popupfor" + moduleId).style.display = "flex";
                document.body.style.overflow = 'hidden';
            }

            function closePopup(moduleId) {
                document.getElementById("popupfor" + moduleId).style.display = "none";
                document.body.style.overflow = 'auto';
            }
        </script>
    </div>
</x-coordonnateur_layout>

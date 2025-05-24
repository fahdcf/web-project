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
                    background-color: #e74c3c;
                    border-color: #e74c3c;
                    font-size: 0.9rem;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-weight: 500;
                    transition: all 0.2s;
                }

                .btn-danger:hover {
                    background-color: white;
                    color: #e74c3c;
                    border-color: #e74c3c;
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

                    .header-grid > * {
                        width: 100%;
                    }

                    .btn-primary, .btn-success {
                        width: 100%;
                        text-align: center;
                    }
                }
            </style>

            <div class="header-grid mt">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-book-open fa-2x" style="color: #330bcf;"></i>
                    <h3 style="color: #330bcf; font-weight: 500;">Gestion des Unités d'Enseignement</h3>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('coordonnateur.modules.create') }}"
                        class="btn btn-primary rounded fw-semibold">
                        <i class="fas fa-plus-circle"></i> Nouvelle UE
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-success rounded fw-semibold dropdown-toggle" type="button"
                            id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-file-export"></i> Exporter
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                            @for ($i = 1; $i <= 6; $i++)
                                <li>
                                    <a class="dropdown-item" href="{{ route('coordonnateur.modules.index') }}?export=semester&semester={{ $i }}">
                                        {{ $i == 1 ? '1er' : $i . 'ème' }} Semestre
                                    </a>
                                </li>
                            @endfor
                        </ul>
                    </div>
                    <div>
                        <button class="btn btn-success rounded fw-semibold" type="button"
                            id="importDropdown" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-file-import"></i> Importer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="header-container mb-4">
            <div class="row g-3">
                <div class="col-md-6 col-lg-3 filter-dropdown">
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

                <div class="col-md-6 col-lg-3 filter-dropdown">
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

                <div class="col-md-6 col-lg-6 search-bar">
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
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Importer des Unités d'Enseignement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('coordonnateur.modules.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="file" class="form-label">Sélectionner un fichier CSV</label>
                                <input type="file" class="form-control" id="file" name="file" accept=".csv" required>
                                <small class="text-muted">Format attendu : Nom, Code, Type, Heures CM, Heures TD, Heures TP, Semestre, Statut, Crédit, Évaluation, Description, Responsable</small>
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
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <span class="badge {{ $module->status == 'active' ? 'bg-success' : 'bg-warning' }} ms-2">
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
                            <a href="{{ route('coordonnateur.modules.show', $module) }}"
                                class="view-btn">
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
                @endforelse
            </div>

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

                .view-btn, .remove-btn {
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
                    height: 38px; /* Fixed height for consistency */
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

                .view-btn i, .remove-btn i {
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

                    .view-btn, .remove-btn {
                        width: 100%;
                    }
                }

                @media (max-width: 576px) {
                    .row.g-3 {
                        flex-direction: column;
                    }

                    .filter-dropdown, .search-bar {
                        width: 100%;
                    }
                }
            </style>

            <script>
                let searchFilter = '';
                let semesterFilter = document.getElementById('semester').value;
                let statusFilter = document.getElementById('status').value;

                document.getElementById('moduleSearch').addEventListener('input', function () {
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
            </script>
        </div>
    </div>
</x-coordonnateur_layout>
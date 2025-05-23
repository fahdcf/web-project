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

                .btn-outline-primary {
                    border-color: #4723d9;
                    color: #4723d9;
                    font-size: 0.9rem;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-weight: 500;
                    transition: all 0.2s;
                    /* white-space: nowrap; */
                }

                .btn-outline-primary:hover {
                    background-color: #4723d9;
                    color: white;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .btn-outline-primary:hover .btn-text-prof {
                    color: white;
                }

                .btn-text-emploi,
                .btn-text-prof {
                    display: inline;
                }

                @media (max-width: 768px) {
                    .header-container {
                        padding: 15px;
                    }

                    .header-title {
                        font-size: 1.5rem;
                        margin-bottom: 15px;
                        text-align: center;
                    }

                    .form-select,
                    .btn-outline-primary {
                        width: 100%;
                        margin-bottom: 10px;
                    }

                    .btn-outline-primary {
                        white-space: normal;
                        text-align: center;
                        padding: 10px 16px;
                    }

                }

                /* Improved grid layout */
                .header-grid {
                    display: grid;
                    grid-template-columns: 1fr auto auto;
                    gap: 1rem;
                    align-items: center;
                }

                @media (max-width: 992px) {
                    .header-grid {
                        grid-template-columns: 1fr auto;
                    }

                    .header-title {
                        grid-column: 1 / -1;
                        text-align: center;
                        margin-bottom: 10px;
                        text-decoration: underline;
                    }
                }

                @media (max-width: 768px) {
                    .header-grid {
                        grid-template-columns: 1fr;
                        gap: 0.75rem;
                    }

                    .btn-outline-primary {
                        white-space: normal;
                        text-align: center;
                        padding: 10px 16px;
                        line-height: 1.3;
                        /* Add this for better line spacing */
                    }

                    .btn-text-emploi,
                    .btn-text-prof {
                        display: inline;
                        /* Change from 'block' to 'inline' */
                        margin-bottom: 0;
                        /* Remove bottom margin */
                    }

                    .btn-text-emploi:after {
                        content: " ";
                        /* Add space after "Emploi des" */
                    }

                }
            </style>

            <div class="header-grid mt">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-book-open fa-2x " style="color: #330bcf;"></i>
                    <h3 style="color: #330bcf; font-weight: 500;">Gestion des Unités d'Enseignement</h3>
                </div>

                <a href="{{ route('coordonnateur.modules.create') }}"
                    class="btn btn-primary rounded fw-semibold my-2 me-2">
                    <i class="fas fa-plus-circle"></i>
                    Nouvelle UE
                </a>


            </div>
        </div>



        <div class="header-container mb-4">
            <div class="row g-3 ">
                <!-- semester Filter Dropdown -->
                <div class="col-md-6 col-lg-3 filter-dropdown">

                    <label for="semester" class="form-label small fw-bold text-muted">Semester</label>
                    <select id="semester" class="form-select border border-primary text-primary"
                        style="font-weight: 500;"
                        onchange="window.location.href='{{ route('coordonnateur.modules.index') }}?semester=' + this.value">
                        <option value="all" {{ request('semester') == 'all' ? 'selected' : '' }}>Tous</option>
                        @for ($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>
                                {{ $i == 1 ? '1er' : $i . 'ème' }} Semestre
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Status Filter Dropdown -->
                <div class="col-md-6 col-lg-3 filter-dropdown">
                    <label for="status" class="form-label small fw-bold text-muted">Statut</label>
                    <select id="status" class="form-select border border-primary text-primary"
                        style="font-weight: 500;"
                        onchange="window.location.href='{{ route('coordonnateur.modules.index') }}?status=' + this.value">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tous</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>


                <!-- Barre de Recherche -->
                <div class="col-md-6 col-lg-6 search-bar">
                    <label for="moduleSearch" class="form-label small fw-bold text-muted">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0 " id="moduleSearch"
                            placeholder="Rechercher par nom / code...">
                    </div>
                </div>
            </div>
        </div>

        <style>


        </style>
        <div class="header-container mb-4">
            <div class="module-grid">
                @foreach ($modules as $module)
                    <div class="module-card">
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
                            <!-- Professor -->
                            <div class="detail-item">
                                <i class="bi bi-person-fill detail-icon"></i>
                                <div>
                                    <span class="detail-label">Enseignants vacants</span>
                                    <div class="vacant-roles pt-2">
                                        @if (!$module->ProfCours || !$module->ProfTd || !$module->ProfTp)
                                            @if (!$module->ProfCours)
                                                <span class="vacant-role">Cours</span>
                                            @endif
                                            @if (!$module->ProfTd)
                                                <span class="vacant-role">TD</span>
                                            @endif
                                            @if (!$module->ProfTp)
                                                <span class="vacant-role">TP</span>
                                            @endif
                                        @else
                                            <span class="vacant-role success">Tous les enseignants assignés</span>
                                        @endif
                                    </div>
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
                                <form action="{{ route('coordonnateur.modules.destroy', $module) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-btn"
                                        onclick="return confirm('Supprimer ce module ?')">
                                        <i class="bi bi-trash-fill"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                    </div>
                @endforeach
            </div>


            <!-- Popup Template -->
            @foreach ($modules as $module)
                <div id="popupfor{{ $module->id }}" class="overlay">
                    <div class="popup bg-white rounded-3 p-4 shadow-lg" style="max-width: 600px;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="text-primary fw-bold mb-0">Détails du module</h5>
                            <button type="button" class="btn-close"
                                onclick="closePopup({{ $module->id }})"></button>
                        </div>

                        <div class="module-details">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="bi bi-book fs-4" style="color: white !important;"></i>
                                </div>
                                <h4 class="mb-0 fw-bold" id="moduleName{{ $module->id }}">{{ $module->name }}</h4>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <small class="text-muted d-block">ID du module</small>
                                        <span class="fw-semibold">{{ $module->id }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <small class="text-muted d-block">Type</small>
                                        <span class="fw-semibold">{{ $module->type }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <small class="text-muted d-block">Crédit</small>
                                        <span class="fw-semibold">{{ $module->credit }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <small class="text-muted d-block">Évaluation</small>
                                        <span class="fw-semibold">{{ $module->evaluation }}</span>
                                    </div>
                                </div>

                                @if ($module->description)
                                    <div class="col-12">
                                        <div class="bg-light p-3 rounded">
                                            <small class="text-muted d-block">Description</small>
                                            <p class="mb-0">{{ $module->description }}</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <div class="bg-light p-3 rounded">
                                        <small class="text-muted d-block">Responsable</small>
                                        <span class="fw-semibold">
                                            @if ($module->responsable)
                                                {{ $module->responsable->firstname }}
                                                {{ $module->responsable->lastname }}
                                            @else
                                                Non associé
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="bg-light p-3 rounded">
                                        <small class="text-muted d-block">Date de création</small>
                                        <span class="fw-semibold">{{ $module->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-primary px-4"
                                onclick="closePopup({{ $module->id }})">Fermer</button>
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
                    /* min-width: 300px; */
                    /* margin: 2px; */
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
                    max-width: 90%;
                    animation: fadeIn 0.3s;
                }

                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }


                @media (max-width: 768px) {
                    .popup {
                        max-width: 95%;
                        margin: 1rem;
                    }
                }


                /* Style pour les nouveaux éléments */

                .search-bar {
                    min-width: 250px;
                    flex-grow: 1;
                }


                /* Responsive */
                @media (max-width: 768px) {
                    .search-bar {
                        min-width: 100%;
                        order: -1;
                    }

                    .dropdown {
                        width: 48%;
                    }
                }


             
            </style>


            <script>
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


                // Filtrage 
                let searchFilter = '';

                // Recherche par nom/code
                document.getElementById('moduleSearch').addEventListener('input', function() {
                    searchFilter = this.value.toLowerCase();
                    applyFilters();
                });

                function applyFilters() {
                    const moduleCards = document.querySelectorAll('.module-card');

                    moduleCards.forEach(card => {
                        const moduleName = card.querySelector('.module-name').textContent.toLowerCase();
                        const moduleCode = card.querySelector('.module-hours-badge').textContent.toLowerCase();

                        // Apply search filter
                        const searchMatch = searchFilter === '' ||
                            moduleName.includes(searchFilter) ||
                            moduleCode.includes(searchFilter);

                        // Show or hide based on filter
                        if (searchMatch) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }
            </script>
</x-coordonnateur_layout>

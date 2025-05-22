<x-coordonnateur_layout>
    <div class="container-fluid px-4 py-5">
        <!-- Header Section -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h1 class="display-6 fw-bold  mb-2" style="color: #4723d9">MODULES VACANTS:</h1>
            </div>


        </div>

        <div class="d-flex flex-wrap gap-3 mb-4">
            <!-- Filtre par Semestre -->
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar2-range"></i> Semestre
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item filter-option" data-filter="semester" data-value="all">Tous</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="semester" data-value="1">1er Semestre</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="semester" data-value="2">2ème Semestre</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="semester" data-value="3">3ème Semestre</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="semester" data-value="4">4ème Semestre</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="semester" data-value="5">5ème Semestre</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="semester" data-value="6">6ème Semestre</a></li>

                </ul>
            </div>

            <!-- Filtre par Type d'Heures -->
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-clock-history"></i> Type d'Heures
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item filter-option" data-filter="hour_type" data-value="all">Tous</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="hour_type" data-value="cm">CM</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="hour_type" data-value="td">TD</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="hour_type" data-value="tp">TP</a></li>
                </ul>
            </div>

            <!-- Filtre par Statut -->
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-check-circle"></i> Statut
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item filter-option" data-filter="status" data-value="all">Tous</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="status" data-value="active">Actif</a></li>
                    <li><a class="dropdown-item filter-option" data-filter="status" data-value="inactive">Inactif</a>
                    </li>
                </ul>
            </div>

            <!-- Barre de Recherche -->
            <div class="search-bar">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="moduleSearch" placeholder="Rechercher par nom...">
                </div>
            </div>
        </div>



        <div class="row g-4">
            @foreach ($modules as $module)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="module-card">
                        <div class="module-header">
                            <div class="module-title-container">
                                <h3 class="module-name">{{ $module->name }}</h3>
                                <div class="module-hours-badge">{{ $module->code }}</div>
                            </div>
                            {{-- <div class="module-workload">
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
                            </div> --}}
                            <div class="module-workload">
                                @if (!$module->assignments->where('teach_cm', true)->count())
                                    <div class="workload-item">
                                        <span class="workload-label">CM</span>
                                        <span class="workload-value">{{ $module->cm_hours }}h</span>
                                    </div>
                                @endif

                                @if (!$module->assignments->where('teach_td', true)->count())
                                    <div class="workload-item">
                                        <span class="workload-label">TD</span>
                                        <span class="workload-value">{{ $module->td_hours }}h</span>
                                    </div>
                                @endif

                                @if (!$module->assignments->where('teach_tp', true)->count())
                                    <div class="workload-item">
                                        <span class="workload-label">TP</span>
                                        <span class="workload-value">{{ $module->tp_hours }}h</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="module-details">
                            <!-- Professor -->
                            <div class="detail-item">
                                <i class="bi bi-person-fill detail-icon"></i>
                                <div>
                                    <span class="detail-label">Professeur</span>
                                    <span class="detail-value">
                                        @if ($module->professor)
                                            {{ $module->professor->firstname }} {{ $module->professor->lastname }}
                                        @else
                                            <span style="color: #e74c3c">Non associé</span>
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
                            <button class="view-btn" onclick="showPopup({{ $module->id }}, '{{ $module->name }}')">
                                <i class="bi bi-eye-fill"></i> Voir plus
                            </button>
                            <button class="select-btn"
                                onclick="showSelectionModal(
                    {{ $module->id }}, 
                    '{{ $module->name }}', 
                    { 
                        cm_available: {{ !$module->assignments->where('teach_cm', true)->count() ? 'true' : 'false' }},
                        td_available: {{ !$module->assignments->where('teach_td', true)->count() ? 'true' : 'false' }},
                        tp_available: {{ !$module->assignments->where('teach_tp', true)->count() ? 'true' : 'false' }},
                        cm_hours: {{ $module->cm_hours }},
                        td_hours: {{ $module->td_hours }},
                        tp_hours: {{ $module->tp_hours }}
                    }
                )">
                                <i class="bi bi-check-lg"></i> Choisir
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Nouveau Modal de Sélection -->
        <div id="selectionModal" class="overlay">
            <div class="popup bg-white rounded-3 p-4 shadow-lg" style="max-width: 500px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-primary fw-bold mb-0">Sélectionner les heures disponibles</h5>
                    <button type="button" class="btn-close" onclick="closeSelectionModal()"></button>
                </div>

                <div class="mb-4">
                    <h6 id="selectedModuleName" class="fw-bold"></h6>
                    <p class="text-muted small">Types d'heures non encore assignés</p>
                </div>

                <div class="hour-selection">
                    <div id="allHoursContainer" class="form-check mb-3 d-none">
                        <input class="form-check-input" type="checkbox" id="selectAllHours">
                        <label class="form-check-label fw-bold" for="selectAllHours">
                            Sélectionner tout
                        </label>
                    </div>

                    <div class="ps-4">
                        <div id="cmContainer" class="form-check mb-2 d-none">
                            <input class="form-check-input hour-checkbox" type="checkbox" id="selectCM">
                            <label class="form-check-label" for="selectCM">
                                Heures de CM (<span id="cmHoursValue">0</span>h)
                            </label>
                        </div>

                        <div id="tdContainer" class="form-check mb-2 d-none">
                            <input class="form-check-input hour-checkbox" type="checkbox" id="selectTD">
                            <label class="form-check-label" for="selectTD">
                                Heures de TD (<span id="tdHoursValue">0</span>h)
                            </label>
                        </div>

                        <div id="tpContainer" class="form-check d-none">
                            <input class="form-check-input hour-checkbox" type="checkbox" id="selectTP">
                            <label class="form-check-label" for="selectTP">
                                Heures de TP (<span id="tpHoursValue">0</span>h)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="button" class="btn btn-outline-secondary me-2"
                        onclick="closeSelectionModal()">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="confirmSelection()">Confirmer</button>
                </div>
            </div>
        </div>

        <script>
            // Variables globales
            let currentModuleId = null;

            function showSelectionModal(moduleId, moduleName, moduleData) {
                currentModuleId = moduleId;

                // Afficher le nom du module
                document.getElementById('selectedModuleName').textContent = moduleName;

                // Récupérer les containers
                const cmContainer = document.getElementById('cmContainer');
                const tdContainer = document.getElementById('tdContainer');
                const tpContainer = document.getElementById('tpContainer');
                const allHoursContainer = document.getElementById('allHoursContainer');

                // Réinitialiser l'affichage
                cmContainer.classList.add('d-none');
                tdContainer.classList.add('d-none');
                tpContainer.classList.add('d-none');
                allHoursContainer.classList.add('d-none');

                // Variables pour suivre les types disponibles
                let availableTypes = 0;

                // Vérifier et afficher CM si disponible
                if (moduleData.cm_available) {
                    cmContainer.classList.remove('d-none');
                    document.getElementById('cmHoursValue').textContent = moduleData.cm_hours;
                    document.getElementById('selectCM').checked = true;
                    availableTypes++;
                }

                // Vérifier et afficher TD si disponible
                if (moduleData.td_available) {
                    tdContainer.classList.remove('d-none');
                    document.getElementById('tdHoursValue').textContent = moduleData.td_hours;
                    document.getElementById('selectTD').checked = true;
                    availableTypes++;
                }

                // Vérifier et afficher TP si disponible
                if (moduleData.tp_available) {
                    tpContainer.classList.remove('d-none');
                    document.getElementById('tpHoursValue').textContent = moduleData.tp_hours;
                    document.getElementById('selectTP').checked = true;
                    availableTypes++;
                }

                // Afficher "Sélectionner tout" seulement si plusieurs types disponibles
                if (availableTypes > 1) {
                    allHoursContainer.classList.remove('d-none');
                    document.getElementById('selectAllHours').checked = true;
                }

                // Afficher le modal
                document.getElementById('selectionModal').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }

            function closeSelectionModal() {
                document.getElementById('selectionModal').style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            // Gestion de la case "Toutes les heures"
            document.getElementById('selectAllHours').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.hour-checkbox:not(:disabled)');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Gestion des cases individuelles
            document.querySelectorAll('.hour-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (!this.checked) {
                        document.getElementById('selectAllHours').checked = false;
                    } else {
                        // Vérifier si toutes les cases disponibles sont cochées
                        const allChecked = Array.from(document.querySelectorAll(
                                '.hour-checkbox:not(:disabled)'))
                            .every(cb => cb.checked);
                        document.getElementById('selectAllHours').checked = allChecked;
                    }
                });
            });

            function confirmSelection() {
                const selectedTypes = {
                    cm: document.getElementById('selectCM').checked &&
                        !document.getElementById('cmContainer').classList.contains('d-none'),
                    td: document.getElementById('selectTD').checked &&
                        !document.getElementById('tdContainer').classList.contains('d-none'),
                    tp: document.getElementById('selectTP').checked &&
                        !document.getElementById('tpContainer').classList.contains('d-none')
                };

                // Ici, ajoutez votre logique pour enregistrer la sélection
                console.log('Module ID:', currentModuleId);
                console.log('Types sélectionnés:', selectedTypes);

                closeSelectionModal();
            }
        </script>

        <!-- Popup Template -->
        @foreach ($modules as $module)
            <div id="popupfor{{ $module->id }}" class="overlay">
                <div class="popup bg-white rounded-3 p-4 shadow-lg" style="max-width: 600px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-primary fw-bold mb-0">Détails du module</h5>
                        <button type="button" class="btn-close" onclick="closePopup({{ $module->id }})"></button>
                    </div>

                    <div class="module-details">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="bi bi-book fs-4" style="color: white !important;"></i>
                            </div>
                            <h4 class="mb-0 fw-bold " id="moduleName{{ $module->id }}">{{ $module->name }}</h4>
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

                            @if ($module->responsable)
                                <div class="col-12">
                                    <div class="bg-light p-3 rounded">
                                        <small class="text-muted d-block">Responsable</small>
                                        <span class="fw-semibold">{{ $module->responsable->firstname }}
                                            {{ $module->responsable->lastname }}</span>
                                    </div>
                                </div>
                            @endif

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
                --primary-soft: #e8e5ff;
                --info-soft: #e6f7ff;
                --success-soft: #e6f7ed;
                --warning-soft: #fff8e6;
            }


            .filter-btn {
                color: #4723d9;
                outline: 1px solid #4723d9;

            }

            .filter-btn:hover {
                color: #ffffff;
                background-color: #4723d9;

            }

            .filter-btn:focus {
                color: #ffffff;
                background-color: #4723d9;

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

            .filiere-section:not(:first-child) {
                padding-top: 2rem;
                border-top: 1px solid #4723d923;
            }

            @media (max-width: 768px) {
                .popup {
                    max-width: 95%;
                    margin: 1rem;
                }
            }


            /* Style pour les nouveaux éléments */
            .dropdown-toggle {
                min-width: 120px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 8px;
            }

            .search-bar {
                min-width: 250px;
                flex-grow: 1;
            }

            .select-btn {
                background-color: var(--primary);
                color: white;
                border: none;
                padding: 6px 12px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                gap: 6px;
                transition: all 0.2s;
            }

            .select-btn:hover {
                background-color: #3a1cb3;
                transform: translateY(-1px);
            }

            .select-btn:active {
                transform: translateY(0);
            }

            .hour-selection {
                background-color: #f8f9fa;
                padding: 1rem;
                border-radius: 8px;
                border: 1px solid #eee;
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

            .dropdown-toggle::after {
                margin-left: 0.5em;
                vertical-align: 0.15em;
            }

            .dropdown-menu {
                border: 1px solid rgba(0, 0, 0, 0.1);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .dropdown-item {
                padding: 0.5rem 1.25rem;
                font-size: 0.9rem;
            }

            .dropdown-item:hover,
            .dropdown-item:focus {
                background-color: #f8f9fa;
                color: #4723d9;
            }

            .col-12.col-md-6.col-lg-4 {
                transition: all 0.3s ease;
            }
        </style>

        <style>
            /* Improved Selection Modal Styling */
            #selectionModal .popup {
                max-width: 500px;
                width: 100%;
                border: none;
                animation: fadeIn 0.3s;
            }

            #selectionModal .popup h5 {
                color: #4723d9;
                font-size: 1.25rem;
            }

            #selectedModuleName {
                color: #2c3e50;
                font-size: 1.1rem;
                margin-bottom: 0.5rem;
            }

            .hour-selection {
                background-color: #f8f9fa;
                padding: 1.25rem;
                border-radius: 10px;
                border: 1px solid #e9ecef;
                margin-top: 1rem;
            }

            #selectionModal .form-check {
                padding-left: 2rem;
                margin-bottom: 0.75rem;
            }

            #selectionModal .form-check-input {
                width: 1.2em;
                height: 1.2em;
                margin-top: 0.15em;
                border: 2px solid #adb5bd;
            }

            #selectionModal .form-check-input:checked {
                background-color: #4723d9;
                border-color: #4723d9;
            }

            #selectionModal .form-check-label {
                font-size: 0.95rem;
                color: #495057;
                margin-left: 0.5rem;
                vertical-align: middle;
            }

            #selectionModal .btn-close {
                font-size: 0.8rem;
                padding: 0.5rem;
                background-size: 0.8rem;
            }

            #selectionModal .btn-outline-secondary {
                border-color: #6c757d;
                color: #6c757d;
            }

            #selectionModal .btn-outline-secondary:hover {
                background-color: #6c757d;
                color: white;
            }

            #selectionModal .btn-primary {
                background-color: #4723d9;
                border-color: #4723d9;
                padding: 0.375rem 1.25rem;
            }

            #selectionModal .btn-primary:hover {
                background-color: #3a1cb3;
                border-color: #3a1cb3;
            }

            #allHoursContainer {
                padding-bottom: 0.75rem;
                margin-bottom: 0.75rem;
                border-bottom: 1px solid #dee2e6;
            }

            #allHoursContainer .form-check-label {
                font-weight: 600;
                color: #4723d9;
            }
        </style>

        <script>
            // Show/hide filière sections based on filter
            document.querySelectorAll('[data-filiere]').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Update active state
                    document.querySelectorAll('[data-filiere]').forEach(el => el.classList.remove('active'));
                    this.classList.add('active');

                    const filiereId = this.getAttribute('data-filiere');

                    if (filiereId === 'all') {
                        // Show all sections
                        document.querySelectorAll('.filiere-section').forEach(section => {
                            section.style.display = 'block';
                        });
                    } else {
                        // Hide all sections except the selected one
                        document.querySelectorAll('.filiere-section').forEach(section => {
                            section.style.display = 'none';
                        });
                        document.getElementById(filiereId).style.display = 'block';
                    }
                });
            });

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

            //

            // Filtrage des modules
            let activeFilters = {
                semester: 'all',
                hour_type: 'all',
                status: 'all',
                search: ''
            };

            document.querySelectorAll('.filter-option').forEach(item => {
                item.addEventListener('click', function() {
                    const filterType = this.getAttribute('data-filter');
                    const filterValue = this.getAttribute('data-value');

                    // Update button text
                    const dropdownButton = this.closest('.dropdown').querySelector('.dropdown-toggle');
                    if (filterValue !== 'all') {
                        const icon = dropdownButton.querySelector('i').cloneNode(true);
                        dropdownButton.innerHTML = '';
                        dropdownButton.appendChild(icon);
                        dropdownButton.appendChild(document.createTextNode(this.textContent));
                    } else {
                        const icon = dropdownButton.querySelector('i').cloneNode(true);
                        dropdownButton.innerHTML = '';
                        dropdownButton.appendChild(icon);
                        dropdownButton.appendChild(document.createTextNode(dropdownButton.textContent.split(
                            ' ')[0]));
                    }

                    // Mettre à jour le filtre actif
                    activeFilters[filterType] = filterValue;

                    // Appliquer les filtres
                    applyFilters();
                });
            });

            // Recherche par nom
            document.getElementById('moduleSearch').addEventListener('input', function() {
                activeFilters.search = this.value.toLowerCase();
                applyFilters();
            });

            function applyFilters() {
                const moduleCards = document.querySelectorAll('.col-12.col-md-6.col-lg-4');

                moduleCards.forEach(card => {
                    const semester = card.querySelector('.detail-value').textContent.includes('1er') ? '1' : '2';
                    const status = card.querySelector('.badge').textContent.trim().toLowerCase();
                    const moduleName = card.querySelector('.module-name').textContent.toLowerCase();
                    const moduleCode = card.querySelector('.module-hours-badge').textContent.toLowerCase();

                    // Check for available hours
                    let hasCM = false,
                        hasTD = false,
                        hasTP = false;
                    const workloadItems = card.querySelectorAll('.workload-item');

                    workloadItems.forEach(item => {
                        const label = item.querySelector('.workload-label').textContent.toLowerCase();
                        const value = parseInt(item.querySelector('.workload-value').textContent);
                        if (value > 0) {
                            if (label.includes('cm')) hasCM = true;
                            if (label.includes('td')) hasTD = true;
                            if (label.includes('tp')) hasTP = true;
                        }
                    });

                    // Appliquer chaque filtre
                    const semesterMatch = activeFilters.semester === 'all' || semester === activeFilters.semester;
                    const statusMatch = activeFilters.status === 'all' || status === activeFilters.status;
                    const searchMatch = activeFilters.search === '' ||
                        moduleName.includes(activeFilters.search) ||
                        moduleCode.includes(activeFilters.search);

                    let hourTypeMatch = true;
                    if (activeFilters.hour_type !== 'all') {
                        hourTypeMatch =
                            (activeFilters.hour_type === 'cm' && hasCM) ||
                            (activeFilters.hour_type === 'td' && hasTD) ||
                            (activeFilters.hour_type === 'tp' && hasTP);
                    }

                    // Afficher ou masquer en fonction des filtres
                    if (semesterMatch && statusMatch && searchMatch && hourTypeMatch) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        </script>
</x-coordonnateur_layout>

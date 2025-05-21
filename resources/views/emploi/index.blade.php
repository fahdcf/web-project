<x-coordonnateur_layout>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-fluid py-4">
        <x-global_alert />

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 bg-gradient-primary text-white shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div>
                                <h4 class="fw-bold mb-2 d-flex align-items-center">
                                    <i class="fas fa-calendar-alt me-3 fa-fw"></i>
                                    Création d'Emploi du Temps
                                </h4>
                                <p class="mb-3 opacity-85">
                                    Créez un emploi du temps en faisant glisser les modules dans la grille horaire.
                                </p>
                                <div class="d-flex flex-wrap gap-3 mt-2">
                                    <div
                                        class="d-flex align-items-center bg-white bg-opacity-15 rounded-pill px-3 py-2">
                                        <i class="fas fa-university me-2"></i>
                                        <span class="fw-semibold">{{ $filiere->name ?? 'Filière Informatique' }}</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center bg-white bg-opacity-15 rounded-pill px-3 py-2">
                                        <i class="fas fa-calendar me-2"></i>
                                        <span class="fw-semibold">{{ $academicYear ?? '2024-2025' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Schedule Form -->
        <form id="scheduleForm" action="{{ route('emploi.store') }}" method="POST">
            @csrf
            <input type="hidden" id="filiere_id" name="filiere_id" value="{{ $filiere->id ?? 1 }}">

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger rounded-4 mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Schedule Information -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="semester" class="form-label fw-medium">Semestre</label>
                                    <select class="form-select rounded-3 @error('semester') is-invalid @enderror"
                                        id="semester" name="semester" required>
                                        <option value="">Sélectionner</option>
                                        @for ($i = 1; $i <= 6; $i++)
                                            <option value="{{ $i }}">S{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-8">
                                    <label for="name" class="form-label fw-medium">Nom de l'Emploi du Temps</label>
                                    <input type="text"
                                        class="form-control rounded-3 @error('name') is-invalid @enderror"
                                        id="name" name="name"
                                        placeholder="Ex: EDT S1 {{ $academicYear ?? '2024-2025' }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <input type="hidden" id="academic_year" name="academic_year"
                                    value="{{ $academicYear ?? '2024-2025' }}">
                                <div class="col-12">
                                    <button type="button" id="loadModulesBtn"
                                        class="btn btn-primary rounded-pill px-4">
                                        <i class="fas fa-sync-alt me-2"></i> Charger les Modules
                                    </button>
                                    <button type="submit" id="saveScheduleBtn"
                                        class="btn btn-light btn-lg rounded-pill px-4 shadow-sm">
                                        <i class="fas fa-save me-2"></i> Enregistrer l'Emploi du Temps
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule Creation Area -->
            <div class="row" id="scheduleCreationArea">
                <!-- Available Modules Panel -->
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white p-3 border-0">
                            <h5 class="mb-0 fw-semibold d-flex align-items-center">
                                <i class="fas fa-cubes text-primary me-2"></i>
                                Modules Disponibles
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush modules-list" id="availableModules">
                                <!-- Modules will be loaded here dynamically -->
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                                    <p>Veuillez sélectionner un semestre...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schedule Grid -->
                <div class="col-md-9 mb-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div
                            class="card-header bg-white p-3 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-semibold d-flex align-items-center">
                                <i class="fas fa-calendar-week text-primary me-2"></i>
                                Grille Horaire
                            </h5>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                    id="clearGridBtn">
                                    <i class="fas fa-trash-alt me-1"></i> Vider la Grille
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                    id="previewBtn">
                                    <i class="fas fa-eye me-1"></i> Aperçu
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered schedule-table mb-0" id="scheduleGrid">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" style="width: 10%;">Jour / Heure</th>
                                            <th class="text-center" style="width: 15%;">08:30 - 10:30</th>
                                            <th class="text-center" style="width: 15%;">10:30 - 12:30</th>
                                            <th class="text-center" style="width: 15%;">14:30 - 16:30</th>
                                            <th class="text-center" style="width: 15%;">16:30 - 18:30</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'] as $dayIndex => $day)
                                            <tr>
                                                <td class="text-center align-middle bg-light fw-medium day-slot">
                                                    {{ $day }}
                                                </td>
                                                @foreach ([0, 1, 2, 3] as $timeIndex)
                                                    <td class="schedule-cell position-relative p-0 dropzone"
                                                        data-day="{{ $day }}"
                                                        data-time-index="{{ $timeIndex }}"
                                                        data-row="{{ $dayIndex }}"
                                                        data-col="{{ $timeIndex }}" data-occupied="false">
                                                        <div
                                                            class="empty-slot h-100 d-flex align-items-center justify-content-center">
                                                            <div class="text-muted small">Déposez un module ici</div>
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden Fields for Sessions -->
            <div id="sessionsContainer"></div>
        </form>

        <!-- Schedule Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header bg-gradient-primary text-white">
                        <h5 class="modal-title fw-semibold">
                            <i class="fas fa-eye me-2"></i> Aperçu de l'Emploi du Temps
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div id="previewContent">
                            <p class="text-muted text-center">Aucune séance n'est ajoutée pour le moment.</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" id="continueEditingBtn"
                            class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            Continuer à Modifier
                        </button>
                        <button type="button" class="btn btn-primary rounded-pill px-4 fw-medium"
                            id="confirmSubmitBtn" style="display: none;">
                            <i class="fas fa-check me-2"></i> Confirmer et Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete Session Confirmation Modal -->
        {{-- <div class="modal fade" id="deleteSessionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header bg-gradient-primary text-white">
                        <h5 class="modal-title fw-semibold">
                            <i class="fas fa-trash-alt me-2"></i> Confirmer la Suppression
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4 text-center">
                        <p class="mb-0">Êtes-vous sûr de vouloir supprimer cette séance ?</p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">
                            Annuler
                        </button>
                        <button type="button" class="btn btn-danger rounded-pill px-4 fw-medium"
                            id="confirmDeleteBtn">
                            <i class="fas fa-trash me-2"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Semester Selection Prompt Modal -->
        {{-- <div class="modal fade" id="semesterPromptModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header bg-gradient-primary text-white">
                        <h5 class="modal-title fw-semibold">
                            <i class="fas fa-exclamation-circle me-2"></i> Sélectionner un Semestre
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4 text-center">
                        <p class="mb-0">Veuillez sélectionner un semestre avant de charger les modules.</p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-primary rounded-pill px-4 fw-medium"
                            data-bs-dismiss="modal">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Session Configuration Modal -->
        <div class="modal fade" id="sessionConfigModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header bg-gradient-primary text-white">
                        <h5 class="modal-title fw-semibold">
                            <i class="fas fa-cog me-2"></i> Configuration de la Séance
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <form id="sessionConfigForm">
                            <input type="hidden" id="session_module_id" name="module_id">
                            <input type="hidden" id="session_day" name="jour">
                            <input type="hidden" id="session_time_index" name="time_index">
                            <input type="hidden" id="session_row" name="row">
                            <input type="hidden" id="session_col" name="col">

                            <div class="mb-3">
                                <label class="form-label fw-medium">Module</label>
                                <div class="form-control-plaintext fw-semibold" id="session_module_name"></div>
                            </div>

                            <div class="mb-3">
                                <label for="session_type" class="form-label fw-medium">Type de Séance</label>
                                <select class="form-select rounded-3" id="session_type" name="type" required>
                                    <option value="">Sélectionner un type</option>
                                    <option value="CM">Cours Magistral (CM)</option>
                                    <option value="TD">Travaux Dirigés (TD)</option>
                                    <option value="TP">Travaux Pratiques (TP)</option>
                                </select>
                            </div>

                            <div class="mb-3" id="groupeContainer" style="display: none;">
                                <label for="session_groupe" class="form-label fw-medium">Groupe</label>
                                <select class="form-select rounded-3" id="session_groupe" name="groupe">
                                    <option value="">Sélectionner un groupe</option>
                                    <!-- Will be populated dynamically -->
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="session_salle" class="form-label fw-medium">Salle</label>
                                <input type="text" class="form-control rounded-3" id="session_salle"
                                    name="salle" placeholder="Ex: A101">
                            </div>

                            <div class="mb-3">
                                <label for="session_duration" class="form-label fw-medium">Durée</label>
                                <select class="form-select rounded-3" id="session_duration" name="duration">
                                    <option value="1" selected>2 heures (1 créneau)</option>
                                    <option value="2">4 heures (2 créneaux)</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">
                            Annuler
                        </button>
                        <button type="button" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm"
                            id="confirmSessionBtn">
                            <i class="fas fa-check me-2"></i> Confirmer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Professional color palette */
            :root {
                --primary: #4723D9;
                --primary-dark: #3a1bb3;
                --primary-light: #60a5fa;
                --primary-subtle: rgba(59, 130, 246, 0.1);
                --secondary: #64748b;
                --secondary-subtle: rgba(100, 116, 139, 0.1);
                --success: #10b981;
                --success-subtle: rgba(16, 185, 129, 0.1);
                --info: #0ea5e9;
                --info-subtle: rgba(14, 165, 233, 0.1);
                --warning: #f59e0b;
                --warning-subtle: rgba(245, 158, 11, 0.1);
                --danger: #ef4444;
                --danger-subtle: rgba(239, 68, 68, 0.1);
                --light: #f9fafb;
                --dark: #1e293b;
                --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                --card-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                --transition: all 0.3s ease;
            }

            /* Card styling */
            .card {
                border-radius: 0.75rem;
                box-shadow: var(--card-shadow);
                transition: var(--transition);
                border: none;
            }

            .bg-gradient-primary {
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            }

            /* Schedule table styling */
            .schedule-table {
                border-collapse: separate;
                border-spacing: 0;
                width: 100%;
            }

            .schedule-table th {
                font-weight: 600;
                font-size: 0.9rem;
                padding: 0.75rem;
                border: 1px solid #e5e7eb;
            }

            .schedule-table td {
                border: 1px solid #e5e7eb;
                height: 100px;
                vertical-align: top;
                padding: 0;
            }

            .day-slot {
                font-size: 0.9rem;
                font-weight: 600;
            }

            /* Drag and drop styling */
            .modules-list {
                max-height: 600px;
                overflow-y: auto;
            }

            .module-item {
                cursor: grab;
                transition: all 0.2s ease;
                border-left: 4px solid var(--primary);
                margin-bottom: 0;
            }

            .module-item:hover {
                background-color: var(--primary-subtle);
                transform: translateY(-2px);
            }

            .module-item:active {
                cursor: grabbing;
            }

            .module-item.dragging {
                opacity: 0.5;
            }

            .dropzone {
                transition: all 0.2s ease;
                position: relative;
            }

            .dropzone.drag-over {
                background-color: var(--primary-subtle);
            }

            .dropzone.occupied {
                background-color: var(--light);
            }

            /* Session cards */
            .session-card {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                padding: 0.5rem;
                overflow: hidden;
                cursor: pointer;
                transition: all 0.2s ease;
                z-index: 1;
            }

            .session-card:hover {
                z-index: 2;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .session-card.cm {
                background-color: var(--primary-subtle);
                border-left: 4px solid var(--primary);
            }

            .session-card.td {
                background-color: var(--info-subtle);
                border-left: 4px solid var(--info);
            }

            .session-card.tp {
                background-color: var(--success-subtle);
                border-left: 4px solid var(--success);
            }

            .session-card .badge {
                font-size: 0.7rem;
                padding: 0.25rem 0.5rem;
            }

            .session-card .session-title {
                font-weight: 600;
                font-size: 0.9rem;
                margin-bottom: 0.25rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .session-card .session-details {
                font-size: 0.75rem;
                color: var(--secondary);
            }

            .session-card .session-actions {
                position: absolute;
                top: 0.25rem;
                right: 0.25rem;
                display: flex;
                gap: 0.25rem;
            }

            .session-card .session-actions button {
                font-size: 0.7rem;
                padding: 0.1rem 0.3rem;
                background-color: rgba(255, 255, 255, 0.8);
                border-radius: 0.25rem;
            }

            /* Multi-cell sessions */
            .session-card.multi-col-2 {
                width: 200%;
                /* 2 columns */
                z-index: 2;
            }

            /* Split cells */
            .split-cell .session-card {
                height: 50%;
            }

            .split-cell .session-card:nth-child(2) {
                top: 50%;
            }

            .split-cell.split-3 .session-card {
                height: 33.333%;
            }

            .split-cell.split-3 .session-card:nth-child(2) {
                top: 33.333%;
            }

            .split-cell.split-3 .session-card:nth-child(3) {
                top: 66.666%;
            }

            /* Empty slots */
            .empty-slot {
                height: 100%;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #ccc;
                font-size: 0.8rem;
                transition: all 0.2s ease;
            }

            .dropzone:hover .empty-slot {
                background-color: var(--primary-subtle);
                color: var(--primary);
            }

            /* Module groups badges */
            .module-groups {
                display: flex;
                gap: 0.5rem;
                margin-top: 0.5rem;
            }

            .module-group-badge {
                display: flex;
                align-items: center;
                padding: 0.2rem 0.5rem;
                border-radius: 0.25rem;
                font-size: 0.7rem;
                font-weight: 600;
            }

            .module-group-badge i {
                margin-right: 0.25rem;
                font-size: 0.7rem;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // DOM elements
                const loadModulesBtn = document.getElementById('loadModulesBtn');
                const scheduleCreationArea = document.getElementById('scheduleCreationArea');
                const availableModules = document.getElementById('availableModules');
                const scheduleGrid = document.getElementById('scheduleGrid');
                const clearGridBtn = document.getElementById('clearGridBtn');
                const previewBtn = document.getElementById('previewBtn');
                const scheduleForm = document.getElementById('scheduleForm');
                const sessionConfigModal = new bootstrap.Modal(document.getElementById('sessionConfigModal'));
                const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
                const confirmSessionBtn = document.getElementById('confirmSessionBtn');
                const confirmSubmitBtn = document.getElementById('confirmSubmitBtn');
                const continueEditingBtn = document.getElementById('continueEditingBtn');
                const sessionsContainer = document.getElementById('sessionsContainer');

                // State variables
                let draggedModule = null;
                let currentCell = null;
                let modules = [];
                let schedule = {
                    filiere_id: null,
                    semester: null,
                    academic_year: null,
                    name: '',
                    sessions: []
                };

                // Time slots mapping
                const timeSlots = [{
                        start: '08:30',
                        end: '10:30'
                    },
                    {
                        start: '10:30',
                        end: '12:30'
                    },
                    {
                        start: '14:30',
                        end: '16:30'
                    },
                    {
                        start: '16:30',
                        end: '18:30'
                    }
                ];

                // Event listeners
                loadModulesBtn.addEventListener('click', loadModules);
                clearGridBtn.addEventListener('click', clearGrid);
                confirmSessionBtn.addEventListener('click', confirmSession);
                previewBtn.addEventListener('click', () => showPreview(false));
                scheduleForm.addEventListener('submit', handleFormSubmit);
                confirmSubmitBtn.addEventListener('click', () => {
                    scheduleForm.submit();
                });
                continueEditingBtn.addEventListener('click', () => {
                    previewModal.hide();
                });

                // Initialize drag and drop
                initDragAndDrop();

                // Functions
                function loadModules() {
                    const filiere_id = document.getElementById('filiere_id').value;
                    const semester = document.getElementById('semester').value;
                    const academic_year = document.getElementById('academic_year').value;

                    if (!semester) {
                        alert('Veuillez sélectionner un semestre.');
                        return;
                    }

                    // Save schedule info
                    schedule.filiere_id = filiere_id;
                    schedule.semester = semester;
                    schedule.academic_year = academic_year;
                    schedule.name = '';

                    // Show loading state
                    availableModules.innerHTML = `
            <div class="text-center py-5 text-muted">
                <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
                <p>Chargement des modules...</p>
            </div>
        `;

                    // Fetch modules from the server
                    fetch(`/api/modules?filiere_id=${filiere_id}&semester=${semester}`)
                        .then(response => response.json())
                        .then(data => {
                            modules = data;
                            renderModules();
                        })
                        .catch(error => {
                            console.error('Error fetching modules:', error);
                            availableModules.innerHTML = `
                    <div class="text-center py-5 text-danger">
                        <i class="fas fa-exclamation-circle fa-2x mb-3"></i>
                        <p>Erreur lors du chargement des modules.</p>
                    </div>
                `;
                        });
                }

                function renderModules() {
                    if (modules.length === 0) {
                        availableModules.innerHTML = `
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <p>Aucun module disponible pour ce semestre.</p>
                </div>
            `;
                        return;
                    }

                    let html = '';
                    modules.forEach(module => {
                        html += `
                <div class="list-group-item module-item p-3" draggable="true" data-module-id="${module.id}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span></span>
                            <h6 class="mb-1 fw-semibold">S${module.semester} . ${module.name}</h6>
                            <div class="small text-muted">${module.code}</div>
                        </div>
                        <span class="badge bg-primary rounded-pill">${module.cm_hours + module.td_hours + module.tp_hours}h</span>
                    </div>
                    <div class="d-flex flex-wrap gap-1 mt-2">
                        ${module.cm_hours > 0 ? `<span class="badge bg-primary-subtle text-primary">CM: ${module.cm_hours}h</span>` : ''}
                        ${module.td_hours > 0 ? `<span class="badge bg-info-subtle text-info">TD: ${module.td_hours}h</span>` : ''}
                        ${module.tp_hours > 0 ? `<span class="badge bg-success-subtle text-success">TP: ${module.tp_hours}h</span>` : ''}
                    </div>
                    <div class="module-groups">
                        ${module.nbr_groupes_td > 0 ? 
                            `<span class="module-group-badge bg-info-subtle text-info">
                                                                        <i class="fas fa-users"></i> ${module.nbr_groupes_td} groupes TD
                                                                    </span>` : ''}
                        ${module.nbr_groupes_tp > 0 ? 
                            `<span class="module-group-badge bg-success-subtle text-success">
                                                                        <i class="fas fa-flask"></i> ${module.nbr_groupes_tp} groupes TP
                                                                    </span>` : ''}
                    </div>
                </div>
            `;
                    });

                    availableModules.innerHTML = html;

                    // Add drag event listeners to module items
                    document.querySelectorAll('.module-item').forEach(item => {
                        item.addEventListener('dragstart', handleDragStart);
                        item.addEventListener('dragend', handleDragEnd);
                    });
                }

                function initDragAndDrop() {
                    // Add event listeners to dropzones
                    document.querySelectorAll('.dropzone').forEach(dropzone => {
                        dropzone.addEventListener('dragover', handleDragOver);
                        dropzone.addEventListener('dragleave', handleDragLeave);
                        dropzone.addEventListener('drop', handleDrop);
                        dropzone.addEventListener('click', handleCellClick);
                    });
                }

                function handleDragStart(e) {
                    draggedModule = this;
                    this.classList.add('dragging');
                    e.dataTransfer.setData('text/plain', this.dataset.moduleId);
                    e.dataTransfer.effectAllowed = 'copy';
                }

                function handleDragEnd() {
                    this.classList.remove('dragging');
                    draggedModule = null;
                }

                function handleDragOver(e) {
                    e.preventDefault();
                    this.classList.add('drag-over');
                    e.dataTransfer.dropEffect = 'copy';
                }

                function handleDragLeave() {
                    this.classList.remove('drag-over');
                }

                function handleDrop(e) {
                    e.preventDefault();
                    this.classList.remove('drag-over');

                    const moduleId = e.dataTransfer.getData('text/plain');
                    const module = modules.find(m => m.id == moduleId);

                    if (!module) return;

                    currentCell = this;

                    // Open configuration modal
                    document.getElementById('session_module_id').value = module.id;
                    document.getElementById('session_module_name').textContent = `${module.name} (${module.code})`;
                    document.getElementById('session_day').value = this.dataset.day;
                    document.getElementById('session_time_index').value = this.dataset.timeIndex;
                    document.getElementById('session_row').value = this.dataset.row;
                    document.getElementById('session_col').value = this.dataset.col;

                    // Reset form
                    document.getElementById('session_type').value = '';
                    document.getElementById('session_groupe').value = '';
                    document.getElementById('session_salle').value = '';
                    document.getElementById('session_duration').value = '1';

                    // Show/hide groupe selection based on session type
                    document.getElementById('session_type').addEventListener('change', function() {
                        const groupeContainer = document.getElementById('groupeContainer');
                        const groupeSelect = document.getElementById('session_groupe');

                        // Clear existing options
                        while (groupeSelect.options.length > 1) {
                            groupeSelect.remove(1);
                        }

                        if (this.value === 'TD') {
                            groupeContainer.style.display = 'block';
                            // Add TD groups
                            for (let i = 1; i <= module.nbr_groupes_td; i++) {
                                const option = document.createElement('option');
                                option.value = `TD${i}`;
                                option.textContent = `TD ${i}`;
                                groupeSelect.appendChild(option);
                            }
                        } else if (this.value === 'TP') {
                            groupeContainer.style.display = 'block';
                            // Add TP groups
                            for (let i = 1; i <= module.nbr_groupes_tp; i++) {
                                const option = document.createElement('option');
                                option.value = `TP${i}`;
                                option.textContent = `TP ${i}`;
                                groupeSelect.appendChild(option);
                            }
                        } else {
                            groupeContainer.style.display = 'none';
                        }
                    });

                    sessionConfigModal.show();
                }

                function handleCellClick() {
                    if (this.dataset.occupied === 'true') {
                        alert('Veuillez supprimer et recréer la séance pour modifier.');
                    }
                }

                function confirmSession() {
                    const moduleId = document.getElementById('session_module_id').value;
                    const module = modules.find(m => m.id == moduleId);
                    const type = document.getElementById('session_type').value;
                    const groupe = document.getElementById('session_groupe').value;
                    const salle = document.getElementById('session_salle').value;
                    const duration = parseInt(document.getElementById('session_duration').value);
                    const day = document.getElementById('session_day').value;
                    const timeIndex = parseInt(document.getElementById('session_time_index').value);
                    const row = parseInt(document.getElementById('session_row').value);
                    const col = parseInt(document.getElementById('session_col').value);

                    if (!moduleId || !type) {
                        alert('Veuillez remplir tous les champs obligatoires.');
                        return;
                    }

                    // Get time slot information
                    const timeSlot = timeSlots[timeIndex];
                    const heure_fin = duration > 1 ? timeSlots[timeIndex + duration - 1].end : timeSlot.end;

                    // Create session object
                    const session = {
                        module_id: moduleId,
                        type: type,
                        jour: day,
                        heure_debut: timeSlot.start,
                        heure_fin: heure_fin,
                        salle: salle,
                        groupe: groupe,
                        module: module,
                        row: row,
                        col: col,
                        duration: duration,
                        time_index: timeIndex
                    };

                    // Add session to schedule
                    schedule.sessions.push(session);

                    // Render session in grid
                    renderSession(session);

                    // Update hidden inputs
                    updateHiddenInputs();

                    // Close modal
                    sessionConfigModal.hide();
                }

                function renderSession(session) {
                    const cell = document.querySelector(
                        `.dropzone[data-row="${session.row}"][data-col="${session.col}"]`);

                    if (!cell) return;

                    // Mark cell as occupied
                    cell.dataset.occupied = 'true';
                    cell.innerHTML = '';

                    // Create session card
                    const sessionCard = document.createElement('div');
                    sessionCard.className = `session-card ${session.type.toLowerCase()}`;

                    // Add multi-column class if duration > 1
                    if (session.duration > 1) {
                        sessionCard.classList.add(`multi-col-${session.duration}`);

                        // Mark cells to the right as occupied
                        for (let i = 1; i < session.duration; i++) {
                            const nextCol = session.col + i;
                            const nextCell = document.querySelector(
                                `.dropzone[data-row="${session.row}"][data-col="${nextCol}"]`);
                            if (nextCell) {
                                nextCell.dataset.occupied = 'true';
                                nextCell.innerHTML = '';
                            }
                        }
                    }

                    // Session content
                    sessionCard.innerHTML = `
            <div class="d-flex justify-content-between align-items-start mb-1">
                <span class="badge bg-${getTypeColor(session.type)} text-white">${session.type}</span>
                <div class="session-actions">
                    <button class="btn btn-sm btn-link text-danger p-0 delete-session" data-session-id="${schedule.sessions.length - 1}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <h6 class="session-title">${session.module.name}</h6>
            <div class="session-details">
                <div>${session.module.code} ${session.groupe ? '- ' + session.groupe : ''}</div>
                <div class="d-flex align-items-center mt-1">
                    <i class="fas fa-map-marker-alt me-1"></i>
                    <span>${session.salle || 'Salle non définie'}</span>
                </div>
                <div class="d-flex align-items-center mt-1">
                    <i class="fas fa-clock me-1"></i>
                    <span>${session.heure_debut} - ${session.heure_fin}</span>
                </div>
            </div>
        `;

                    // Add session card to cell
                    cell.appendChild(sessionCard);

                    // Add event listener to delete button
                    sessionCard.querySelector('.delete-session').addEventListener('click', function(e) {
                        e.stopPropagation();
                        const sessionId = this.dataset.sessionId;
                        deleteSession(sessionId);
                    });
                }

                function deleteSession(sessionId) {
                    if (confirm('Êtes-vous sûr de vouloir supprimer cette séance ?')) {
                        const session = schedule.sessions[sessionId];

                        // Remove session from schedule
                        schedule.sessions.splice(sessionId, 1);

                        // Clear the specific cell
                        const cell = document.querySelector(
                            `.dropzone[data-row="${session.row}"][data-col="${session.col}"]`);
                        if (cell) {
                            cell.dataset.occupied = 'false';
                            cell.innerHTML = `
                    <div class="empty-slot h-100 d-flex align-items-center justify-content-center">
                        <div class="text-muted small">Déposez un module ici</div>
                    </div>
                `;
                        }

                        // Clear cells to the right if multi-column
                        if (session.duration > 1) {
                            for (let i = 1; i < session.duration; i++) {
                                const nextCol = session.col + i;
                                const nextCell = document.querySelector(
                                    `.dropzone[data-row="${session.row}"][data-col="${nextCol}"]`);
                                if (nextCell) {
                                    nextCell.dataset.occupied = 'false';
                                    nextCell.innerHTML = `
                            <div class="empty-slot h-100 d-flex align-items-center justify-content-center">
                                <div class="text-muted small">Déposez un module ici</div>
                            </div>
                        `;
                                }
                            }
                        }

                        // Update hidden inputs
                        updateHiddenInputs();

                        // Re-render remaining sessions to update session IDs
                        schedule.sessions.forEach((sess, index) => {
                            if (index >= sessionId) {
                                renderSession(sess);
                            }
                        });
                    }
                }

                function clearGrid() {
                    // Clear all cells
                    document.querySelectorAll('.dropzone').forEach(cell => {
                        cell.dataset.occupied = 'false';
                        cell.innerHTML = `
                <div class="empty-slot h-100 d-flex align-items-center justify-content-center">
                    <div class="text-muted small">Déposez un module ici</div>
                </div>
            `;
                    });

                    // Clear sessions
                    schedule.sessions = [];
                    updateHiddenInputs();
                }

                function updateHiddenInputs() {
                    // Clear existing hidden inputs
                    sessionsContainer.innerHTML = '';

                    // Add hidden inputs for each session
                    schedule.sessions.forEach((session, index) => {
                        const fields = [{
                                name: `sessions[${index}][module_id]`,
                                value: session.module_id
                            },
                            {
                                name: `sessions[${index}][type]`,
                                value: session.type
                            },
                            {
                                name: `sessions[${index}][jour]`,
                                value: session.jour
                            },
                            {
                                name: `sessions[${index}][heure_debut]`,
                                value: session.heure_debut
                            },
                            {
                                name: `sessions[${index}][heure_fin]`,
                                value: session.heure_fin
                            },
                            {
                                name: `sessions[${index}][salle]`,
                                value: session.salle || ''
                            },
                            {
                                name: `sessions[${index}][groupe]`,
                                value: session.groupe || ''
                            }
                        ];

                        fields.forEach(field => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = field.name;
                            input.value = field.value;
                            sessionsContainer.appendChild(input);
                        });
                    });
                }

                function getTypeColor(type) {
                    switch (type) {
                        case 'CM':
                            return 'primary';
                        case 'TD':
                            return 'info';
                        case 'TP':
                            return 'success';
                        default:
                            return 'secondary';
                    }
                }

                function showPreview(isSubmit) {
                    const name = document.getElementById('name').value;
                    const previewContent = document.getElementById('previewContent');

                    if (schedule.sessions.length === 0) {
                        previewContent.innerHTML = `
                <p class="text-muted text-center">Aucune séance n'est ajoutée pour le moment.</p>
            `;
                    } else {
                        let html = `
                <h6 class="mb-3 fw-semibold">Emploi du Temps: ${name || 'Non défini'}</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Jour</th>
                                <th>Horaire</th>
                                <th>Module</th>
                                <th>Type</th>
                                <th>Salle</th>
                                <th>Groupe</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
                        schedule.sessions.forEach(session => {
                            html += `
                    <tr>
                        <td>${session.jour}</td>
                        <td>${session.heure_debut} - ${session.heure_fin}</td>
                        <td>${session.module.name} (${session.module.code})</td>
                        <td>${session.type}</td>
                        <td>${session.salle || 'Non défini'}</td>
                        <td>${session.groupe || '-'}</td>
                    </tr>
                `;
                        });
                        html += `
                        </tbody>
                    </table>
                </div>
            `;
                        previewContent.innerHTML = html;
                    }

                    // Show or hide confirm button based on context
                    confirmSubmitBtn.style.display = isSubmit ? 'inline-block' : 'none';

                    // Show the modal
                    previewModal.show();
                }

                function handleFormSubmit(e) {
                    e.preventDefault();
                    const name = document.getElementById('name').value;

                    if (!name) {
                        alert('Veuillez entrer un nom pour l\'emploi du temps.');
                        return;
                    }

                    if (schedule.sessions.length === 0) {
                        alert('L\'emploi du temps est vide. Veuillez ajouter au moins une séance.');
                        return;
                    }

                    // Show preview before submitting
                    showPreview(true);
                }
            });
        </script>
</x-coordonnateur_layout>

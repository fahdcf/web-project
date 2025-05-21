<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <x-global_alert />

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <!-- Enhanced Header -->
                    <div class="card-header bg-gradient-primary text-white py-4 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 fw-bold d-flex align-items-center">
                                <i class="fas fa-layer-group me-2"></i>
                                Filière: <strong class="ms-2">{{ $filiere->name }}</strong>
                            </h4>
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                <span class="badge bg-white text-primary rounded-pill px-3 py-2">
                                    <i class="fas fa-calendar-alt me-1"></i> {{ $currentYear }}
                                </span>
                                <span class="badge bg-white text-primary rounded-pill px-3 py-2">
                                    <i class="fas fa-clock me-1"></i> Prochain Semestre {{ $nextSemester }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="card-body p-0 bg-light">
                        @foreach ($modules as $semester => $semesterModules)
                            <div class="semester-section p-4 border-bottom bg-white rounded-3 mb-3">
                                <!-- Semester Header -->
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                                    <div class="d-flex align-items-center">
                                        <div class="semester-badge bg-primary text-white rounded-circle p-3 me-3">
                                            <span class="fw-bold fs-5">S{{ $semester }}</span>
                                        </div>
                                        <div>
                                            <h3 class="m-0 fw-bold text-dark">
                                                {{ match ($semester) {
                                                    1 => 'Première Année - S1',
                                                    2 => 'Première Année - S2',
                                                    3 => 'Deuxième Année - S3',
                                                    4 => 'Deuxième Année - S4',
                                                    5 => 'Troisième Année - S5',
                                                    6 => 'Troisième Année - S6',
                                                    default => 'Semestre ' . $semester,
                                                } }}
                                            </h3>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold"
                                            data-bs-toggle="modal" data-bs-target="#configNbGroupesGeneralModal"
                                            data-semester="{{ $semester }}" onclick="prepareModal(this)"
                                            aria-label="Configurer tous les modules du semestre {{ $semester }}">
                                        <i class="fas fa-layer-group me-2"></i> Configurer Tous les Modules
                                    </button>
                                </div>

                                <!-- Modules Cards with Horizontal Scroll -->
                                <div class="position-relative mb-3">
                                    <div class="modules-scroll-container">
                                        <div class="d-flex flex-nowrap overflow-auto pb-3">
                                            @foreach ($semesterModules as $module)
                                                <div class="module-card-container" style="min-width: 320px; width: 320px; max-width: 100%;">
                                                    <div class="card module-card border-0 rounded-4 shadow-sm h-100 me-3 bg-white">
                                                        <!-- Module Header -->
                                                        <div class="card-header bg-transparent border-bottom-0 d-flex align-items-center py-3 px-4">
                                                            <div class="module-icon bg-primary-subtle text-primary rounded-circle p-3 me-3">
                                                                <i class="fas fa-book fs-5"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h5 class="mb-0 fw-bold text-dark text-truncate">{{ $module->name }}</h5>
                                                                <div class="d-flex align-items-center mt-1 gap-2">
                                                                    <small class="text-muted">
                                                                        <i class="fas fa-hashtag me-1"></i>{{ $module->code }}
                                                                    </small>
                                                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1">
                                                                        {{ $module->credits }} ECTS
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Module Body -->
                                                        <div class="card-body px-4 pt-0">
                                                            <!-- Responsable -->
                                                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                                                <div class="avatar bg-secondary-subtle text-secondary rounded-circle p-3 me-3">
                                                                    <i class="fas fa-user-tie fs-5"></i>
                                                                </div>
                                                                <div>
                                                                    <small class="text-muted d-block">Responsable</small>
                                                                    <span class="fw-medium text-dark">
                                                                        {{ $module->responsable ? $module->responsable->fullname : 'Non assigné' }}
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- Groups Summary -->
                                                            <div class="groups-summary">
                                                                <div class="row g-3">
                                                                    @if ($module->nbr_groupes_td > 0)
                                                                        <div class="col-6">
                                                                            <div class="group-type-card bg-info-subtle p-3 rounded-3 text-center h-100">
                                                                                <div class="text-info fw-semibold mb-2">
                                                                                    <i class="fas fa-users me-1"></i> Groupes TD
                                                                                </div>
                                                                                <span class="badge bg-info text-white rounded-pill px-4 py-2 fs-5">
                                                                                    {{ $module->nbr_groupes_td }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if ($module->nbr_groupes_tp > 0)
                                                                        <div class="col-6">
                                                                            <div class="group-type-card bg-success-subtle p-3 rounded-3 text-center h-100">
                                                                                <div class="text-success fw-semibold mb-2">
                                                                                    <i class="fas fa-flask me-1"></i> Groupes TP
                                                                                </div>
                                                                                <span class="badge bg-success text-white rounded-pill px-4 py-2 fs-5">
                                                                                    {{ $module->nbr_groupes_tp }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Module Footer -->
                                                        <div class="card-footer bg-transparent border-top py-3 px-4">
                                                            <div class="d-flex justify-content-between">
                                                                <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 py-2 fw-semibold"
                                                                        data-bs-toggle="modal" data-bs-target="#configModuleModal"
                                                                        data-module-id="{{ $module->id }}"
                                                                        data-module-name="{{ $module->name }}"
                                                                        data-td-count="{{ $module->nbr_groupes_td }}"
                                                                        data-tp-count="{{ $module->nbr_groupes_tp }}"
                                                                        data-td-max="{{ $module->td1_max_students ?? 30 }}"
                                                                        data-tp-max="{{ $module->tp1_max_students ?? 20 }}"
                                                                        onclick="loadModuleConfig(this)"
                                                                        aria-label="Configurer le module {{ $module->name }}">
                                                                    <i class="fas fa-cog me-2"></i> Configurer
                                                                </button>
                                                                <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-4 py-2"
                                                                   aria-label="Consulter les détails du module {{ $module->name }}">
                                                                    <i class="fas fa-eye me-2"></i> Consulter
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Scroll Indicators -->
                                    <div class="scroll-indicators d-none d-md-flex">
                                        <button class="btn btn-light scroll-btn scroll-left shadow-sm rounded-circle p-3"
                                                onclick="scrollModules(this, 'left')"
                                                aria-label="Faire défiler vers la gauche">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button class="btn btn-light scroll-btn scroll-right shadow-sm rounded-circle p-3"
                                                onclick="scrollModules(this, 'right')"
                                                aria-label="Faire défiler vers la droite">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuration Modals -->
    <div class="modal fade" id="configNbGroupesGeneralModal" tabindex="-1" aria-labelledby="configNbGroupesGeneralModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-gradient-primary text-white">
                    <div class="d-flex flex-column w-100">
                        <h5 class="modal-title fw-bold mb-1" id="configNbGroupesGeneralModalLabel">
                            <i class="fas fa-sliders-h me-2"></i> Configuration Globale des Groupes
                        </h5>
                        <p class="mb-0 small opacity-85">
                            Semestre <span class="semester-display">SX</span>
                        </p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('save_semester_suivant') }}" method="POST">
                    @csrf
                    <input type="hidden" name="semester" value="">

                    <div class="modal-body py-4">
                        <div class="alert alert-light border mb-4 rounded-3">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Configuration pour tous les modules du Semestre <strong class="semester-display">SX</strong>
                        </div>

                        <div class="row g-4">
                            <!-- TD Groups Configuration -->
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-header bg-info-subtle border-0">
                                        <h6 class="mb-0 fw-bold d-flex align-items-center">
                                            <i class="fas fa-users text-info me-2"></i> Groupes TD
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label small fw-medium">Nombre de groupes</label>
                                            <input type="number" class="form-control rounded-3" name="nb_groupes_td"
                                                   value="1" min="0" max="10" required aria-describedby="nb_groupes_td_help">
                                            <small id="nb_groupes_td_help" class="form-text text-muted">Nombre de groupes de TD par module.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TP Groups Configuration -->
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-header bg-success-subtle border-0">
                                        <h6 class="mb-0 fw-bold d-flex align-items-center">
                                            <i class="fas fa-flask text-success me-2"></i> Groupes TP
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label small fw-medium">Nombre de groupes</label>
                                            <input type="number" class="form-control rounded-3" name="nb_groupes_tp"
                                                   value="1" min="0" max="10" required aria-describedby="nb_groupes_tp_help">
                                            <small id="nb_groupes_tp_help" class="form-text text-muted">Nombre de groupes de TP par module.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal" aria-label="Annuler">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm" aria-label="Appliquer la configuration">
                            <i class="fas fa-save me-2"></i> Appliquer à S<span class="semester-display-btn">X</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pour configuration individuelle -->
    <div class="modal fade" id="configModuleModal" tabindex="-1" aria-labelledby="configModuleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title fw-bold" id="configModuleModalLabel">
                        <i class="fas fa-cog me-2"></i>
                        <span id="moduleConfigTitle">Configuration du module</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('module_config_update') }}">
                    @csrf
                    <input type="hidden" name="module_id" id="configModuleId">

                    <div class="modal-body py-4">
                        <div class="row g-4">
                            <!-- TD Groups Configuration -->
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-header bg-info-subtle border-0">
                                        <h6 class="mb-0 fw-bold d-flex align-items-center">
                                            <i class="fas fa-users text-info me-2"></i> Groupes TD
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label small fw-medium">Nombre de groupes</label>
                                            <input type="number" class="form-control rounded-3" name="nb_groupes_td"
                                                   id="tdCountInput" min="0" max="10" required aria-describedby="nb_groupes_td_help">
                                            <small id="nb_groupes_td_help" class="form-text text-muted">Nombre de groupes de TD pour ce module.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TP Groups Configuration -->
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100 rounded-4">
                                    <div class="card-header bg-success-subtle border-0">
                                        <h6 class="mb-0 fw-bold d-flex align-items-center">
                                            <i class="fas fa-flask text-success me-2"></i> Groupes TP
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label small fw-medium">Nombre de groupes</label>
                                            <input type="number" class="form-control rounded-3" name="nb_groupes_tp"
                                                   id="tpCountInput" min="0" max="10" required aria-describedby="nb_groupes_tp_help">
                                            <small id="nb_groupes_tp_help" class="form-text text-muted">Nombre de groupes de TP pour ce module.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal" aria-label="Annuler">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm" aria-label="Enregistrer la configuration">
                            <i class="fas fa-save me-2"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Professional color palette */
        :root {
            --primary: #4723D9;
            --primary-dark: #2563eb;
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

        body {
            background-color: var(--light);
            color: var(--dark);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        /* Card styling */
        .card {
            border-radius: 0.75rem;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .bg-light {
            background-color: var(--light) !important;
        }

        /* Badges and icons */
        .semester-badge {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: transform 0.2s ease;
        }

        .semester-badge:hover {
            transform: scale(1.1);
        }

        .module-icon, .avatar {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .group-type-card {
            transition: var(--transition);
            border-radius: 0.75rem;
        }

        .group-type-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .badge {
            font-weight: 600;
            transition: transform 0.2s ease;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        /* Scrollable area */
        .modules-scroll-container {
            position: relative;
            overflow: hidden;
        }

        .modules-scroll-container .d-flex {
            -ms-overflow-style: none;
            scrollbar-width: thin;
            scrollbar-color: var(--secondary) var(--light);
            scroll-behavior: smooth;
        }

        .modules-scroll-container .d-flex::-webkit-scrollbar {
            height: 6px;
            background-color: var(--light);
            border-radius: 3px;
        }

        .modules-scroll-container .d-flex::-webkit-scrollbar-thumb {
            background-color: var(--secondary);
            border-radius: 3px;
        }

        .modules-scroll-container .d-flex::-webkit-scrollbar-thumb:hover {
            background-color: var(--dark);
        }

        .scroll-indicators {
            position: absolute;
            top: 50%;
            width: 100%;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            pointer-events: none;
            z-index: 10;
        }

        .scroll-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: auto;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .scroll-btn:hover {
            opacity: 1;
            transform: scale(1.1);
        }

        .scroll-btn:disabled {
            opacity: 0.5;
            pointer-events: none;
        }

        .scroll-left {
            margin-left: -20px;
        }

        .scroll-right {
            margin-right: -20px;
        }

        /* Button styling */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            transition: var(--transition);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            transition: var(--transition);
        }

        .btn-outline-secondary:hover {
            background-color: var(--secondary-subtle);
            transform: translateY(-2px);
        }

        /* Modal styling */
        .modal-content {
            border-radius: 0.75rem;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
        }

        /* Form controls */
        .form-control {
            border-radius: 0.5rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem var(--primary-subtle);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .semester-section {
                padding: 1.5rem;
            }
            .module-card-container {
                min-width: 300px;
                width: 300px;
            }
        }

        @media (max-width: 576px) {
            .module-card-container {
                min-width: 260px;
                width: 260px;
            }
        }
    </style>

    <script>
        function prepareModal(button) {
            const semester = button.getAttribute('data-semester');
            document.querySelector('#configNbGroupesGeneralModal input[name="semester"]').value = semester;
            document.querySelectorAll(
                '#configNbGroupesGeneralModal .semester-display, #configNbGroupesGeneralModal .semester-display-btn'
            ).forEach(el => el.textContent = semester);
        }

        function loadModuleConfig(button) {
            document.getElementById('moduleConfigTitle').textContent = `Configuration: ${button.dataset.moduleName}`;
            document.getElementById('configModuleId').value = button.dataset.moduleId;
            document.getElementById('tdCountInput').value = button.dataset.tdCount || 1;
            document.getElementById('tpCountInput').value = button.dataset.tpCount || 0;
        }

        function scrollModules(button, direction) {
            const container = button.closest('.position-relative').querySelector('.d-flex');
            const scrollAmount = 320; // Width of a card

            container.scrollTo({
                left: direction === 'left' ? container.scrollLeft - scrollAmount : container.scrollLeft + scrollAmount,
                behavior: 'smooth'
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const scrollContainers = document.querySelectorAll('.modules-scroll-container .d-flex');

            scrollContainers.forEach(container => {
                checkScrollButtons(container);
                container.addEventListener('scroll', () => checkScrollButtons(container));
            });

            function checkScrollButtons(container) {
                const parent = container.closest('.position-relative');
                const leftBtn = parent.querySelector('.scroll-left');
                const rightBtn = parent.querySelector('.scroll-right');

                if (!leftBtn || !rightBtn) return;

                leftBtn.disabled = container.scrollLeft <= 10;
                rightBtn.disabled = container.scrollLeft + container.clientWidth >= container.scrollWidth - 10;
            }

            const moduleCards = document.querySelectorAll('.module-card');
            moduleCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = 'var(--card-hover-shadow)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'var(--card-shadow)';
                });
            });

            const groupTypeCards = document.querySelectorAll('.group-type-card');
            groupTypeCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</x-coordonnateur_layout>
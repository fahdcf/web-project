<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <!-- Enhanced Header -->
                    <div class="card-header bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-semibold d-flex align-items-center">
                                <i class="fas fa-layer-group me-2"></i>
                                Filière: <strong class="ms-1">{{ $filiere->name }}</strong>
                            </h5>
                            <div class="d-flex flex-wrap gap-2 mt-1">
                                <span class="badge bg-white text-primary rounded-pill px-3 py-1">
                                    <i class="fas fa-calendar-alt me-1"></i> {{ $currentYear }}
                                </span>
                                <span class="badge bg-white text-primary rounded-pill px-3 py-1">
                                    <i class="fas fa-clock me-1"></i> Prochain Semestre {{ $nextSemester }}
                                </span>
                            </div>
                        </div>
                       
                    </div>

                    <!-- Main Content -->
                    <div class="card-body p-0">
                        @foreach ($modules as $semester => $semesterModules)
                            <div class="semester-section p-4 border-bottom">
                                <!-- Semester Header -->
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                                    <div class="d-flex align-items-center">
                                        <div class="semester-badge bg-primary-soft text-primary rounded-3 p-2 me-3">
                                            <span class="fw-bold">S{{ $semester }}</span>
                                        </div>
                                        <div>
                                            <h4 class="m-0 fw-semibold">
                                                {{ match($semester) {
                                                    1 => 'Première Année - S1',
                                                    2 => 'Première Année - S2',
                                                    3 => 'Deuxième Année - S3',
                                                    4 => 'Deuxième Année - S4', 
                                                    5 => 'Troisième Année - S5',
                                                    6 => 'Troisième Année - S6',
                                                    default => 'Semestre ' . $semester
                                                } }}
                                            </h4>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-warning btn-sm rounded-pill px-3"
                                        data-bs-toggle="modal" data-bs-target="#configNbGroupesGeneralModal"
                                        data-semester="{{ $semester }}" onclick="prepareModal(this)">
                                        <i class="fas fa-layer-group me-2"></i> Configurer Tous les Modules
                                    </button>
                                </div>

                                <!-- Modules Cards -->
                                <div class="row g-3">
                                    @foreach ($semesterModules as $module)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card module-card border-0 shadow-sm h-100">
                                                <!-- Module Header -->
                                                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                                                    <div class="flex-grow-1 pe-2">
                                                        <h6 class="mb-0 fw-semibold text-truncate">{{ $module->name }}</h6>
                                                        <div class="d-flex align-items-center mt-1">
                                                            <small class="text-muted me-2">
                                                                <i class="fas fa-hashtag me-1"></i>{{ $module->code }}
                                                            </small>
                                                            <span class="badge bg-light text-dark">
                                                                {{ $module->credits }} ECTS
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Module Body -->
                                                <div class="card-body">
                                                    <!-- Responsable -->
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="avatar bg-primary-soft text-primary rounded-circle me-3">
                                                            <i class="fas fa-user-tie"></i>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted d-block">Responsable</small>
                                                            <span class="fw-medium">
                                                                {{ $module->responsable ? $module->responsable->fullname : 'Non assigné' }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Groups Summary -->
                                                    <div class="groups-summary mb-3">
                                                        <div class="row g-2">
                                                            @if($module->tdGroups->count() > 0)
                                                            <div class="col-6">
                                                                <div class="group-type-card bg-primary-soft p-2 rounded text-center">
                                                                    <div class="text-primary fw-semibold mb-1">
                                                                        <i class="fas fa-users me-1"></i> Groupes TD
                                                                    </div>
                                                                    <div>
                                                                        <span class="badge bg-white text-primary rounded-pill px-2">
                                                                            {{ $module->tdGroups->count() }} groupes
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            
                                                            @if($module->tpGroups->count() > 0)
                                                            <div class="col-6">
                                                                <div class="group-type-card bg-success-soft p-2 rounded text-center">
                                                                    <div class="text-success fw-semibold mb-1">
                                                                        <i class="fas fa-flask me-1"></i> Groupes TP
                                                                    </div>
                                                                    <div>
                                                                        <span class="badge bg-white text-success rounded-pill px-2">
                                                                            {{ $module->tpGroups->count() }} groupes
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Detailed Groups -->
                                                    <div class="groups-detailed">
                                                        @if($module->tdGroups->count() > 0)
                                                        <div class="mb-3">
                                                            <h6 class="small fw-semibold text-primary mb-2">
                                                                <i class="fas fa-users me-1"></i> Groupes TD
                                                            </h6>
                                                            <ul class="list-group list-group-flush small">
                                                                @foreach($module->tdGroups as $group)
                                                                <li class="list-group-item px-0 py-1 border-0 d-flex justify-content-between align-items-center">
                                                                    <span class="d-flex align-items-center">
                                                                        <span class="group-badge bg-primary-soft text-primary rounded-circle me-2">
                                                                            {{ $loop->iteration }}
                                                                        </span>
                                                                        <span>TD {{ $loop->iteration }}</span>
                                                                    </span>
                                                                    <span class="text-muted small">
                                                                        <span class="{{ $group->nbr_student >= $group->max_students ? 'text-danger' : 'text-success' }} fw-medium">
                                                                            {{ $group->nbr_student }}
                                                                        </span>
                                                                        <span>/{{ $group->max_students }}</span>
                                                                    </span>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        @endif

                                                        @if($module->tpGroups->count() > 0)
                                                        <div class="mb-2">
                                                            <h6 class="small fw-semibold text-success mb-2">
                                                                <i class="fas fa-flask me-1"></i> Groupes TP
                                                            </h6>
                                                            <ul class="list-group list-group-flush small">
                                                                @foreach($module->tpGroups as $group)
                                                                <li class="list-group-item px-0 py-1 border-0 d-flex justify-content-between align-items-center">
                                                                    <span class="d-flex align-items-center">
                                                                        <span class="group-badge bg-success-soft text-success rounded-circle me-2">
                                                                            {{ $loop->iteration }}
                                                                        </span>
                                                                        <span>TP {{ $loop->iteration }}</span>
                                                                    </span>
                                                                    <span class="text-muted small">
                                                                        <span class="{{ $group->nbr_student >= $group->max_students ? 'text-danger' : 'text-success' }} fw-medium">
                                                                            {{ $group->nbr_student }}
                                                                        </span>
                                                                        <span>/{{ $group->max_students }}</span>
                                                                    </span>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Module Footer -->
                                                <div class="card-footer bg-white border-top py-2">
                                                    <div class="d-flex justify-content-between">
                                                        <button type="button" class="btn btn-info btn-sm px-3"
                                                            data-bs-toggle="modal" data-bs-target="#configModuleModal"
                                                            data-module-id="{{ $module->id }}"
                                                            data-module-name="{{ $module->name }}"
                                                            data-td-count="{{ $module->tdGroups->count() }}"
                                                            data-tp-count="{{ $module->tpGroups->count() }}"
                                                            data-td-max="{{ $module->tdGroups->first()->max_students ?? 30 }}"
                                                            data-tp-max="{{ $module->tpGroups->first()->max_students ?? 20 }}"
                                                            onclick="loadModuleConfig(this)">
                                                            <i class="fas fa-cog me-1"></i> Configurer
                                                        </button>
                                                        <a href="#" class="btn btn-outline-success btn-sm px-3">
                                                            <i class="fas fa-eye me-1"></i> Consulter
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom CSS */
        .semester-badge {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .module-card {
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .module-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .avatar {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .group-type-card {
            transition: all 0.2s ease;
        }
        
        .group-type-card:hover {
            transform: translateY(-2px);
        }
        
        .group-badge {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        .groups-detailed {
            max-height: 200px;
            overflow-y: auto;
            padding-right: 5px;
        }
        
        .groups-detailed::-webkit-scrollbar {
            width: 4px;
        }
        
        .groups-detailed::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.1);
            border-radius: 2px;
        }
        
        /* Soft background colors */
        .bg-primary-soft {
            background-color: rgba(13,110,253,0.08);
        }
        
        .bg-success-soft {
            background-color: rgba(25,135,84,0.08);
        }
        
        /* Professional buttons */
        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .semester-section {
                padding: 1.5rem;
            }
            
            .module-card {
                margin-bottom: 1rem;
            }
        }
    </style>

    <!-- Configuration Modals (keep your existing modal code) -->

     <div class="modal fade" id="configNbGroupesGeneralModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-white rounded-top">
                    <div class="d-flex flex-column w-100">
                        <h5 class="modal-title fw-semibold mb-1">
                            <i class="fas fa-sliders-h me-2"></i> Configuration Globale des Groupes
                        </h5>
                        <p class="mb-0 small opacity-85">
                            Semestre <span class="semester-display">SX</span>
                        </p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form action="{{ route('save_semester_suivant') }}" method="POST">
                    @csrf
                    <input type="hidden" name="semester" value="">

                    <div class="modal-body py-4">
                        <div class="alert alert-info border-0 bg-light-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Configuration pour tous les modules du Semester <strong
                                class="semester-display">SX</strong>
                        </div>

                        <div class="row g-3">
                            <!-- TD Groups Configuration -->
                            <div class="col-md-6">
                                <div class="card border-0 h-100">
                                    <div class="card-header bg-primary-soft border-0">
                                        <h6 class="mb-0 d-flex align-items-center">
                                            <i class="fas fa-users text-primary me-2"></i>
                                            Groupes TD
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label small text-muted">Nombre de groupes</label>
                                            <input type="number" class="form-control" name="nb_groupes_td"
                                                value="1" min="0" max="10" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small text-muted">Étudiants max/groupe</label>
                                            <input type="number" class="form-control" name="max_td" value="30"
                                                min="10" max="50" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TP Groups Configuration -->
                            <div class="col-md-6">
                                <div class="card border-0 h-100">
                                    <div class="card-header bg-success-soft border-0">
                                        <h6 class="mb-0 d-flex align-items-center">
                                            <i class="fas fa-flask text-success me-2"></i>
                                            Groupes TP
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label small text-muted">Nombre de groupes</label>
                                            <input type="number" class="form-control" name="nb_groupes_tp"
                                                value="1" min="0" max="10" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small text-muted">Étudiants max/groupe</label>
                                            <input type="number" class="form-control" name="max_tp" value="20"
                                                min="5" max="30" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-warning rounded-pill px-4 fw-medium">
                            <i class="fas fa-save me-2"></i> Appliquer à S<span class="semester-display-btn">X</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal pour configuration individuelle -->
    <!-- Simplified Individual Module Config Modal -->
<div class="modal fade" id="configModuleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-info text-white rounded-top">
                <h5 class="modal-title fw-semibold">
                    <i class="fas fa-cog me-2"></i>
                    <span id="moduleConfigTitle">Configuration du module</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Changed to standard form submission -->
            <form method="POST" action="{{ route('module_config_update') }}">
                @csrf
                <input type="hidden" name="module_id" id="configModuleId">

                <div class="modal-body py-4">
                    <div class="row g-3">
                        <!-- TD Groups Configuration -->
                        <div class="col-md-6">
                            <div class="card border-0 h-100">
                                <div class="card-header bg-primary-soft border-0">
                                    <h6 class="mb-0 d-flex align-items-center">
                                        <i class="fas fa-users text-primary me-2"></i>
                                        Groupes TD
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre de groupes</label>
                                        <input type="number" class="form-control" name="nb_groupes_td"
                                            id="tdCountInput" min="1" max="10" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Étudiants max/groupe</label>
                                        <input type="number" class="form-control" name="max_td"
                                            id="tdMaxInput" min="10" max="50" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TP Groups Configuration -->
                        <div class="col-md-6">
                            <div class="card border-0 h-100">
                                <div class="card-header bg-success-soft border-0">
                                    <h6 class="mb-0 d-flex align-items-center">
                                        <i class="fas fa-flask text-success me-2"></i>
                                        Groupes TP
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre de groupes</label>
                                        <input type="number" class="form-control" name="nb_groupes_tp"
                                            id="tpCountInput" min="0" max="10" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Étudiants max/groupe</label>
                                        <input type="number" class="form-control" name="max_tp"
                                            id="tpMaxInput" min="5" max="30" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-info rounded-pill px-4 fw-medium">
                        <i class="fas fa-save me-2"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


    <script>
        function prepareModal(button) {
            const semester = button.getAttribute('data-semester');
            document.querySelector('#configNbGroupesGeneralModal input[name="semester"]').value = semester;
            document.querySelectorAll('#configNbGroupesGeneralModal .semester-display, #configNbGroupesGeneralModal .semester-display-btn')
                .forEach(el => el.textContent = semester);
        }

        function loadModuleConfig(button) {
            document.getElementById('moduleConfigTitle').textContent = `Configuration: ${button.dataset.moduleName}`;
            document.getElementById('configModuleId').value = button.dataset.moduleId;
            document.getElementById('tdCountInput').value = button.dataset.tdCount || 1;
            document.getElementById('tpCountInput').value = button.dataset.tpCount || 0;
            document.getElementById('tdMaxInput').value = button.dataset.tdMax || 30;
            document.getElementById('tpMaxInput').value = button.dataset.tpMax || 20;
        }
    </script>
</x-coordonnateur_layout>
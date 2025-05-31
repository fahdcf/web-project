<x-coordonnateur_layout>
    <div class="container-fluid px-4 py-5">
        <x-global_alert />


        <!-- Deadline Banner -->
        @if (Route::is('coordonnateur.groupes.next_semester') && $deadline)
            <div
                class="alert alert-{{ $deadline->deadline_date->diffInDays(now()) <= 3 ? 'danger' : 'warning' }} alert-dismissible mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                Deadline: Configure TD/TP groups by {{ $deadline->deadline_date->format('Y-m-d') }}
                ({{ $deadline->deadline_date->diffInDays(now()) }} days left)
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif



        <!-- Header Section -->
        <div class="header-container mb-4">
            <div class="header-grid">
                <div class="d-flex flex-wrap align-items-center gap-3">

                    <div>
                        <h3 style="color: #330bcf; font-weight: 500;">
                            <i class="fas fa-layer-group " style="color: #330bcf;"></i> Configuration des Groupes TD/TP
                        </h3>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <span class="badge bg-light text-primary border border-primary rounded-pill px-3 py-2">
                                <i class="fas fa-calendar-alt me-1"></i> {{ $semesterData['academic_year'] }}
                            </span>
                            <span class="badge bg-light text-primary border border-primary rounded-pill px-3 py-2">
                                @if (Route::currentRouteName() === 'coordonnateur.groupes.current_semester')
                                    <i class="fas fa-clock me-1"></i> Semestre Actuelle:
                                @else
                                    <i class="fas fa-clock me-1"></i> Prochain Semestre:
                                @endif

                                {{ $semesterData['semester_type'] }}
                            </span>
                        </div>
                    </div>
                </div>

                @if (Route::currentRouteName() === 'coordonnateur.groupes.current_semester')
                    <a href="{{ route('coordonnateur.groupes.next_semester') }}"
                        class="btn btn-primary rounded fw-semibold my-2 me-2">
                        <i class="fas fa-cog"></i> Config. Sém. Suivant
                    </a>
                @endif


            </div>

        </div>

        <!-- Filters and Export -->
        <div class="header-container mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4 col-lg-3 filter-dropdown">
                    <label for="semesterFilter" class="form-label small fw-bold text-muted">Semestre</label>
                    <select id="semesterFilter" class="form-select border border-primary text-primary"
                        style="font-weight: 500;">
                        <option value="all" {{ request('semester') == 'all' ? 'selected' : '' }}>Tous</option>
                        @php
                            $j = $semesterData['semester_number'] == 1 ? 1 : 2;
                        @endphp
                        @for ($i = $j; $i <= 6; $i += 2)
                            <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>
                                {{ $i == 1 ? '1er' : $i . 'ème' }} Semestre
                            </option>
                        @endfor
                    </select>
                </div>


                <div class="col-md-4 col-lg-6 search-bar">
                    <label for="moduleSearch" class="form-label small fw-bold text-muted">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0" id="moduleSearch"
                            placeholder="Rechercher par nom / code..." aria-label="Rechercher des modules">
                    </div>
                </div>


                <div class="col-md-4 col-lg-3 text-md-end">
                    <div class="dropdown">
                        <button class="btn btn-success rounded fw-semibold dropdown-toggle" type="button"
                            id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-file-export"></i> Exporter
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('coordonnateur.groupes.export', ['semester' => 'all']) }}">
                                    Tous les Semestres
                                </a>
                            </li>
                            @for ($i = 1; $i <= 6; $i++)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('coordonnateur.groupes.export', ['semester' => $i]) }}">
                                        {{ $i == 1 ? '1er' : $i . 'ème' }} Semestre
                                    </a>
                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modules by Semester -->
        @foreach ($modules as $semester => $semesterModules)
            <div class="header-container mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="year-badge bg-primary-soft rounded-circle p-3">
                            <span class="text-primary fw-bold fs-5">S{{ $semester }}</span>
                        </div>
                        <div>
                            <h4 class="m-0 fw-bold text-dark">
                                {{ match ($semester) {
                                    1 => 'Première Année - S1',
                                    2 => 'Première Année - S2',
                                    3 => 'Deuxième Année - S3',
                                    4 => 'Deuxième Année - S4',
                                    5 => 'Troisième Année - S5',
                                    6 => 'Troisième Année - S6',
                                    default => 'Semestre ' . $semester,
                                } }}
                            </h4>
                        </div>
                    </div>

                    @if (Route::currentRouteName() === 'coordonnateur.groupes.next_semester')
                        <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold"
                            data-bs-toggle="modal" data-bs-target="#configNbGroupesGeneralModal"
                            data-semester="{{ $semester }}" onclick="prepareModal(this)"
                            aria-label="Configurer tous les modules du semestre {{ $semester }}">
                            <i class="fas fa-layer-group me-2"></i> Configurer Tous les Modules
                        </button>
                    @endif

                </div>

                <div class="position-relative">
                    <div class="modules-scroll-container">
                        <div class="d-flex flex-nowrap overflow-auto pb-3 gap-3">
                            @foreach ($semesterModules as $module)
                                <div class="module-card-container"
                                    style="min-width: 320px; width: 320px; max-width: 100%;">
                                    <div class="module-card">
                                        <div class="module-header">
                                            <div class="module-title-container">
                                                <h3 class="module-name">{{ $module->name }}</h3>
                                                <div class="module-hours-badge">{{ $module->code }}</div>
                                            </div>
                                        </div>

                                        <div class="module-details">
                                            <div class="detail-item">
                                                <i class="bi bi-person-fill detail-icon"></i>
                                                <div>
                                                    <span class="detail-label">Responsable</span>
                                                    <span class=" semesterValue">
                                                        {{ $module->responsable ? $module->responsable->fullname : 'Non assigné' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="detail-item">
                                                <i class="bi bi-calendar-week detail-icon"></i>
                                                <div>
                                                    <span class="detail-label">Semestre</span>
                                                    <span class="detail-value semesterValue">
                                                        @if ($module->semester == 1)
                                                            1er Semestre
                                                        @else
                                                            {{ $module->semester }}ème Semestre
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="detail-item">
                                                <i class="bi bi-grid detail-icon"></i>
                                                <div>
                                                    <span class="detail-label">Groupes</span>
                                                    <div class="groups-container d-flex gap-2 mt-2">
                                                        <div
                                                            class="group-box bg-primary-soft border border-primary rounded-3 p-2 flex-grow-1">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="bi bi-users text-primary"></i>
                                                                <span class="fw-medium">TD</span>
                                                                <span class="badge bg-primary rounded-pill ms-auto">
                                                                    {{ $module->nbr_groupes_td ?? 0 }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="group-box bg-success-soft border border-success rounded-3 p-2 flex-grow-1">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="bi bi-flask text-success"></i>
                                                                <span class="fw-medium">TP</span>
                                                                <span class="badge bg-success rounded-pill ms-auto">
                                                                    {{ $module->nbr_groupes_tp ?? 0 }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="module-actions">
                                            <button class="view-btn" data-bs-toggle="modal"
                                                data-bs-target="#configModuleModal"
                                                data-module-id="{{ $module->id }}"
                                                data-module-name="{{ $module->name }}"
                                                data-td-count="{{ $module->nbr_groupes_td ?? 0 }}"
                                                data-tp-count="{{ $module->nbr_groupes_tp ?? 0 }}"
                                                onclick="loadModuleConfig(this)"
                                                aria-label="Configurer le module {{ $module->name }}">


                                                <i class="bi bi-cog-fill"></i>

                                                @if (Route::currentRouteName() === 'coordonnateur.groupes.next_semester')
                                                    Configurer
                                                @else
                                                    Modifier
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="scroll-indicators d-none d-md-flex">
                        <button class="btn btn-light scroll-btn scroll-left shadow-sm rounded-circle p-3"
                            onclick="scrollModules(this, 'left')" aria-label="Faire défiler vers la gauche">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="btn btn-light scroll-btn scroll-right shadow-sm rounded-circle p-3"
                            onclick="scrollModules(this, 'right')" aria-label="Faire défiler vers la droite">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Global Configuration Modal -->
        <div class="modal fade" id="configNbGroupesGeneralModal" tabindex="-1"
            aria-labelledby="configNbGroupesGeneralModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-white rounded-3 p-4 shadow-lg">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-primary fw-bold" id="configNbGroupesGeneralModalLabel">
                            <i class="fas fa-sliders-h me-2"></i> Configuration Globale des Groupes
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Fermer"></button>
                    </div>
                    <form action="{{ route('coordonnateur.groupes.save') }}" method="POST" id="globalConfigForm">
                        @csrf
                        <div class="modal-body">
                            @error('nb_groupes_td')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @error('nb_groupes_tp')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <input type="hidden" name="semester" id="semesterInput">

                            <div class="alert alert-light border mb-4 rounded-3">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                Appliquer a tous les modules du Semestre <strong
                                    class="semester-display">SX</strong>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <h6 class="fw-bold d-flex align-items-center mb-3">
                                            <i class="bi bi-users text-primary me-2"></i> Groupes TD
                                        </h6>
                                        <div class="mb-3">
                                            <label class="form-label small fw-medium">Nombre de groupes</label>
                                            <input type="number" class="form-control rounded-3" name="nb_groupes_td"
                                                value="0" min="0" max="10" required
                                                aria-describedby="nb_groupes_td_help">
                                            <small id="nb_groupes_td_help" class="form-text text-muted">Nombre de
                                                groupes de TD par module.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <h6 class="fw-bold d-flex align-items-center mb-3">
                                            <i class="bi bi-flask text-success me-2"></i> Groupes TP
                                        </h6>
                                        <div class="mb-3">
                                            <label class="form-label small fw-medium">Nombre de groupes</label>
                                            <input type="number" class="form-control rounded-3" name="nb_groupes_tp"
                                                value="0" min="0" max="10" required
                                                aria-describedby="nb_groupes_tp_help">
                                            <small id="nb_groupes_tp_help" class="form-text text-muted">Nombre de
                                                groupes de TP par module.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                data-bs-dismiss="modal" aria-label="Annuler">
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium"
                                aria-label="Appliquer la configuration">
                                <i class="fas fa-save me-2"></i> Appliquer à S<span
                                    class="semester-display-btn">X</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Module Configuration Modal -->
        <div class="modal fade" id="configModuleModal" tabindex="-1" aria-labelledby="configModuleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-white rounded-3 p-4 shadow-lg">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-primary fw-bold" id="configModuleModalLabel">
                            <i class="fas fa-cog me-2"></i> <span id="moduleConfigTitle">module: </span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Fermer"></button>
                    </div>
                    <form method="POST" action="{{ route('coordonnateur.groupes.save.module') }}"
                        id="moduleConfigForm">
                        @csrf
                        <div class="modal-body">
                            @error('nb_groupes_td')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @error('nb_groupes_tp')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <input type="hidden" name="module_id" id="configModuleId">

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <h6 class="fw-bold d-flex align-items-center mb-3">
                                            <i class="bi bi-users text-primary me-2"></i> Groupes TD
                                        </h6>
                                        <div class="mb-3">
                                            <label class="form-label small fw-medium">Nombre de groupes</label>
                                            <input type="number" class="form-control rounded-3" name="nb_groupes_td"
                                                id="tdCountInput" min="0" max="10" required
                                                aria-describedby="nb_groupes_td_help">
                                            <small id="nb_groupes_td_help" class="form-text text-muted">Nombre de
                                                groupes de TD pour ce module.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded">
                                        <h6 class="fw-bold d-flex align-items-center mb-3">
                                            <i class="bi bi-flask text-success me-2"></i> Groupes TP
                                        </h6>
                                        <div class="mb-3">
                                            <label class="form-label small fw-medium">Nombre de groupes</label>
                                            <input type="number" class="form-control rounded-3" name="nb_groupes_tp"
                                                id="tpCountInput" min="0" max="10" required
                                                aria-describedby="nb_groupes_tp_help">
                                            <small id="nb_groupes_tp_help" class="form-text text-muted">Nombre de
                                                groupes de TP pour ce module.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                data-bs-dismiss="modal" aria-label="Annuler">
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium"
                                aria-label="Enregistrer la configuration">
                                <i class="fas fa-save me-2"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
            :root {
                --primary: #4723d9;
                --primary-soft: #e8e5ff;
                --success: #198754;
                --success-soft: rgba(25, 135, 84, 0.08);
                --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                --card-hover-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            }

            body {
                background-color: #f8f9fa;
            }

            .header-container {
                background: white;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .header-grid {
                display: grid;
                grid-template-columns: 1fr auto;
                gap: 1rem;
                align-items: center;
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

            .btn-outline-secondary {
                border-color: #6c757d;
                color: #6c757d;
                font-size: 0.9rem;
                padding: 8px 16px;
                border-radius: 6px;
                transition: all 0.2s;
            }

            .btn-outline-secondary:hover {
                background-color: #6c757d;
                color: white;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .module-card {
                background: white;
                border-radius: 12px;
                box-shadow: var(--card-shadow);
                overflow: hidden;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                border: 1px solid #4723d91e;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .module-card:hover {
                transform: translateY(-2px);
                box-shadow: var(--card-hover-shadow);
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

            . semesterValue {
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
                justify-content: center;
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
                padding: 8px 12px;
                border-radius: 6px;
                transition: all 0.2s ease;
                flex: 1;
                justify-content: center;
                text-decoration: none;
                height: 38px;
                line-height: 1.5;
            }

            .view-btn:hover {
                background: rgba(71, 35, 217, 0.1);
            }

            .modal-content {
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

            .year-badge {
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: var(--primary-soft);
            }

            .modules-scroll-container .d-flex {
                -ms-overflow-style: none;
                scrollbar-width: thin;
                scrollbar-color: #6c757d #f8f9fa;
                scroll-behavior: smooth;
            }

            .modules-scroll-container .d-flex::-webkit-scrollbar {
                height: 6px;
                background-color: #f8f9fa;
                border-radius: 3px;
            }

            .modules-scroll-container .d-flex::-webkit-scrollbar-thumb {
                background-color: #6c757d;
                border-radius: 3px;
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

            .form-control {
                border-radius: 0.5rem;
                transition: all 0.2s ease;
            }

            .form-control:focus {
                border-color: #4723d9;
                box-shadow: 0 0 0 0.2rem rgba(71, 35, 217, 0.2);
            }

            @media (max-width: 768px) {
                .header-container {
                    padding: 15px;
                }

                .filter-dropdown {
                    width: 100%;
                }

                .modal-content {
                    max-width: 95%;
                    margin: 1rem;
                }

                .module-card-container {
                    min-width: 300px;
                    width: 300px;
                }

                .module-actions {
                    flex-direction: column;
                    gap: 8px;
                }

                .view-btn {
                    width: 100%;
                }
            }

            @media (max-width: 576px) {
                .module-card-container {
                    min-width: 260px;
                    width: 260px;
                }
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
        </style>

        <!-- Update the JavaScript -->
        <script>
            function loadModuleConfig(button) {
                const moduleName = button.dataset.moduleName;
                document.getElementById('moduleConfigTitle').textContent = `Configuration: ${moduleName}`;
                document.getElementById('configModuleId').value = button.dataset.moduleId;
                document.getElementById('tdCountInput').value = button.dataset.tdCount || 0;
                document.getElementById('tpCountInput').value = button.dataset.tpCount || 0;
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Initialize search functionality
                const moduleSearch = document.getElementById('moduleSearch');
                const semesterFilter = document.getElementById('semesterFilter');

                moduleSearch.addEventListener('input', filterModules);
                semesterFilter.addEventListener('change', filterModules);

                function filterModules() {
                    const searchTerm = moduleSearch.value.toLowerCase();
                    const selectedSemester = semesterFilter.value;

                    let hasVisibleModules = false;

                    document.querySelectorAll('.module-card-container').forEach(card => {
                        const moduleName = card.querySelector('.module-name').textContent.toLowerCase();
                        const moduleCode = card.querySelector('.module-hours-badge').textContent.toLowerCase();
                        const semester = card.closest('.header-container').querySelector('.year-badge span')
                            .textContent.replace('S', '');

                        // Check if matches search term and semester filter
                        const matchesSearch = searchTerm === '' ||
                            moduleName.includes(searchTerm) ||
                            moduleCode.includes(searchTerm);
                        const matchesSemester = selectedSemester === 'all' || semester === selectedSemester;

                        if (matchesSearch && matchesSemester) {
                            card.style.display = 'block';
                            hasVisibleModules = true;

                            // Highlight search term in module name
                            if (searchTerm) {
                                const nameElement = card.querySelector('.module-name');
                                const originalText = nameElement.textContent;
                                const highlightedText = originalText.replace(
                                    new RegExp(searchTerm, 'gi'),
                                    match => `<span class="search-highlight">${match}</span>`
                                );
                                nameElement.innerHTML = highlightedText;
                            }
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Show/hide semester sections based on visibility
                    document.querySelectorAll('.header-container').forEach(section => {
                        const semester = section.querySelector('.year-badge span').textContent.replace('S', '');
                        const hasVisibleCards = [...section.querySelectorAll('.module-card-container')]
                            .some(card => card.style.display !== 'none');

                        if (selectedSemester === 'all' || semester === selectedSemester) {
                            section.style.display = hasVisibleCards ? 'block' : 'none';
                        } else {
                            section.style.display = 'none';
                        }
                    });

                    // Add no results message if needed
                    const noResults = document.getElementById('no-results-message');
                    if (!hasVisibleModules) {
                        if (!noResults) {
                            const message = document.createElement('div');
                            message.id = 'no-results-message';
                            message.className = 'no-results';
                            message.textContent = 'Aucun module trouvé avec ces critères de recherche';
                            document.querySelector('.container-fluid').appendChild(message);
                        }
                    } else if (noResults) {
                        noResults.remove();
                    }
                }

                // Rest of your existing JavaScript...
            });
        </script>
</x-coordonnateur_layout>

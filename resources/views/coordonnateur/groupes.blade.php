<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-xs border-0 overflow-hidden">
                    <!-- Enhanced Header -->
                    <div
                        class="card-header position-relative overflow-hidden bg-primary text-white py-3 px-4 d-flex justify-content-between align-items-center rounded-top">
                        <!-- Background pattern overlay (subtle) -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 bg-pattern"
                            style="z-index: 0;"></div>

                        <!-- Left Content -->
                        <div class="position-relative z-1">
                            <h5 class="mb-1 fw-semibold d-flex align-items-center">
                                <i class="fas fa-layer-group me-2 fs-5"></i>
                                Filière: <strong class="ms-1">{{ $filiere->name }}</strong>
                            </h5>
                            <div class="d-flex flex-wrap gap-2 mt-1">
                                <span
                                    class="badge bg-white text-primary rounded-pill d-flex align-items-center px-2 py-1 shadow-sm">
                                    <i class="fas fa-calendar-alt me-1 fs-6"></i> {{ $currentYear }}
                                </span>
                                <span
                                    class="badge bg-white text-primary rounded-pill d-flex align-items-center px-2 py-1 shadow-sm">
                                    <i class="fas fa-clock me-1 fs-6"></i> Semestre {{ $currentSemester }}
                                </span>
                            </div>
                        </div>

                        <!-- Right Button -->
                        <div class="position-relative z-1">
                            <a href="{{ route('config_semester_suivant') }}" class="btn btn-light btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center">
                                <i class="fas fa-cog me-2"></i> Config. Sém. Suivant
                            </a>
                        </div>
                    </div>


                    <!-- Main Content -->
                    <div class="card-body p-0">
                        @foreach ($modules as $semester => $semesterModules)
                            <div class="year-section p-4 border-bottom border-light">
                                <!-- Year Header -->
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <div
                                        class="year-badge bg-primary-soft rounded-3 p-2 d-flex align-items-center justify-content-center">
                                        <span class="text-primary fw-bold fs-5">L{{ ceil($semester / 2) }}</span>
                                    </div>
                                    <div>
                                        <h4 class="m-0 text-dark fw-semibold">
                                            {{ match (true) {
                                                $semester == 1 || $semester == 2 => 'Première Année',
                                                $semester == 3 || $semester == 4 => 'Deuxième Année',
                                                $semester == 5 || $semester == 6 => 'Troisième Année',
                                                default => '',
                                            } }}
                                        </h4>
                                        <small class="text-muted">Semestre {{ $semester }}</small>
                                    </div>
                                </div>

                                <!-- Modules Scrollable Container -->
                                <div class="scroll-container pb-3">
                                    <div class="d-flex flex-row flex-nowrap gap-3 pb-3">
                                        @foreach ($semesterModules as $module)
                                            <div class="card module-card border-0 shadow-xs hover-lift transition-all">
                                                <!-- Module Header -->
                                                <div
                                                    class="card-header bg-white d-flex justify-content-between align-items-center border-bottom py-3 position-relative">
                                                    <div class="w-75 pe-2">
                                                        <h6 class="mb-0 fw-semibold text-truncate text-dark">
                                                            {{ $module->name }}</h6>
                                                        <div class="d-flex align-items-center gap-2 mt-1">
                                                            <small class="text-muted text-truncate d-inline-block">
                                                                <i
                                                                    class="fas fa-hashtag me-1 text-primary"></i>{{ $module->code }}
                                                            </small>
                                                            <small class="text-muted text-truncate d-inline-block">
                                                                <i class="fas fa-user-tie me-1 text-primary"></i>
                                                                {{ $module->responsable ? $module->responsable->fullname : 'Non assigné' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="badge {{ $semester % 2 == 1 ? 'bg-info-soft text-info' : 'bg-success-soft text-success' }} rounded-pill fs-11 fw-semibold">
                                                        S{{ $semester }}
                                                    </span>
                                                </div>

                                                <!-- Module Body -->
                                                <div class="card-body py-3">
                                                    <!-- TD Groups -->
                                                    @if ($module->tdGroups->count() > 0)
                                                        <div class="mb-3">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                <strong
                                                                    class="text-primary d-flex align-items-center fs-13">
                                                                    <i class="fas fa-users me-2 fs-12"></i> Groupes TD
                                                                </strong>
                                                                <span
                                                                    class="badge bg-primary-soft text-primary rounded-pill fs-11">
                                                                    {{ $module->tdGroups->count() }} groupes
                                                                </span>
                                                            </div>
                                                            <ul class="list-group list-group-flush small border-0">
                                                                @foreach ($module->tdGroups as $group)
                                                                    <li
                                                                        class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                                                        <span class="d-flex align-items-center">
                                                                            <span
                                                                                class="group-badge bg-primary-soft text-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                                                {{ $loop->iteration }}
                                                                            </span>
                                                                            <span class="d-flex flex-column">
                                                                                <span class="fw-medium">TD
                                                                                    {{ $loop->iteration }}</span>
                                                                                @if ($group->professor)
                                                                                    <small
                                                                                        class="text-muted fs-11">{{ $group->professor->fullname }}</small>
                                                                                @endif
                                                                            </span>
                                                                        </span>
                                                                        <span class="text-muted fs-12">
                                                                            <span
                                                                                class="{{ $group->nbr_student >= $group->max_students ? 'text-danger' : 'text-success' }} fw-medium">
                                                                                {{ $group->nbr_student }}
                                                                            </span>
                                                                            <span
                                                                                class="text-muted">/{{ $group->max_students }}</span>
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    <!-- TP Groups -->
                                                    @if ($module->tpGroups->count() > 0)
                                                        <div class="mb-2">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                <strong
                                                                    class="text-success d-flex align-items-center fs-13">
                                                                    <i class="fas fa-flask me-2 fs-12"></i> Groupes TP
                                                                </strong>
                                                                <span
                                                                    class="badge bg-success-soft text-success rounded-pill fs-11">
                                                                    {{ $module->tpGroups->count() }} groupes
                                                                </span>
                                                            </div>
                                                            <ul class="list-group list-group-flush small border-0">
                                                                @foreach ($module->tpGroups as $group)
                                                                    <li
                                                                        class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 py-2 border-0">
                                                                        <span class="d-flex align-items-center">
                                                                            <span
                                                                                class="group-badge bg-success-soft text-success rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                                                {{ $loop->iteration }}
                                                                            </span>
                                                                            <span class="d-flex flex-column">
                                                                                <span class="fw-medium">TP
                                                                                    {{ $loop->iteration }}</span>
                                                                                @if ($group->professor)
                                                                                    <small
                                                                                        class="text-muted fs-11">{{ $group->professor->fullname }}</small>
                                                                                @endif
                                                                            </span>
                                                                        </span>
                                                                        <span class="text-muted fs-12">
                                                                            <span
                                                                                class="{{ $group->nbr_student >= $group->max_students ? 'text-danger' : 'text-success' }} fw-medium">
                                                                                {{ $group->nbr_student }}
                                                                            </span>
                                                                            <span
                                                                                class="text-muted">/{{ $group->max_students }}</span>
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Module Footer -->
                                                <div class="card-footer bg-white border-top-0 py-2 text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="#"
                                                            class="btn btn-sm btn-outline-primary rounded-pill px-3 border-1 fs-11 fw-medium">
                                                            <i class="fas fa-edit me-1"></i> Modifier
                                                        </a>
                                                        <a href="#"
                                                            class="btn btn-sm btn-outline-secondary rounded-pill px-3 border-1 fs-11 fw-medium">
                                                            <i class="fas fa-chart-pie me-1"></i> Stats
                                                        </a>
                                                        <a href="#"
                                                            class="btn btn-sm btn-outline-success rounded-pill px-3 border-1 fs-11 fw-medium">
                                                            <i class="fas fa-users me-1"></i> Groupes
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-soft: rgba(13, 110, 253, 0.08);
            --success-soft: rgba(25, 135, 84, 0.08);
            --info-soft: rgba(13, 202, 240, 0.08);
            --white-10: rgba(255, 255, 255, 0.1);
        }

        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54 50.41c0 1.1-.9 2-2 2h-4v-4h4c1.1 0 2 .9 2 2zM6 8h4V4H6c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2zm48 0h4V6c0-1.1-.9-2-2-2h-4v4c0 1.1.9 2 2 2zM6 54h4v-4H6c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        .bg-primary-soft {
            background-color: var(--primary-soft);
        }

        .bg-success-soft {
            background-color: var(--success-soft);
        }

        .bg-info-soft {
            background-color: var(--info-soft);
        }

        .bg-white-10 {
            background-color: var(--white-10);
        }

        .shadow-xs {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .scroll-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #e0e0e0 transparent;
        }

        .scroll-container::-webkit-scrollbar {
            height: 6px;
            background: transparent;
        }

        .scroll-container::-webkit-scrollbar-track {
            background: #f8f9fa;
            border-radius: 10px;
        }

        .scroll-container::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        .module-card {
            min-width: 320px;
            border-radius: 12px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .year-section {
            background-color: #fcfcfc;
        }

        .year-section:nth-child(odd) {
            background-color: #fff;
        }

        .year-badge {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }

        .group-badge {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
            font-size: 11px;
            font-weight: 600;
        }

        .fs-10 {
            font-size: 10px !important;
        }

        .fs-11 {
            font-size: 11px !important;
        }

        .fs-12 {
            font-size: 12px !important;
        }

        .fs-13 {
            font-size: 13px !important;
        }

        .border-light {
            border-color: rgba(0, 0, 0, 0.03) !important;
        }

        .z-1 {
            position: relative;
            z-index: 1;
        }
    </style>
</x-coordonnateur_layout>

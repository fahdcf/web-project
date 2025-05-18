<x-coordonnateur_layout>
    <div class="container-fluid  border py-5 px-4 ">
        {{-- @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif --}}

        <x-global_alert/>


        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-primary mb-0">
                <i class="fas fa-book-open me-2"></i> Modules disponibles
            </h4>
            <a href="{{ route('professor.requests') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-list me-1"></i> Voir mes demandes
            </a>
        </div>




        <div class="row m-0 p-0">
            @foreach ($modulesDispo as $module)
                <div class="col-12 col-sm-6 col-lg-4 mb-4">
                    <div class="card module-card h-100 border-start border-3 border-primary position-relative">
                        <!-- Availability Badge -->
                        <span class="position-absolute top-0 end-0 badge bg-success rounded-0 rounded-bottom">
                            <i class="fas fa-check-circle me-1"></i> Disponible
                        </span>

                        <div class="card-body mb-0 d-flex flex-column justify-content-between ">
                            <!-- Module Title -->
                           <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="card-title text-primary mb-1">{{ $module->name }}</h5>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-info me-2">S{{ $module->semester }}</span>
                                        <span class="text-muted small">{{ $module->filiere->name ?? 'Non spécifié' }}</span>
                                    </div>
                                </div>
                                <span class="badge bg-light text-dark">
                                    {{ $module->code }}
                                </span>
                            </div>

                            <!-- Responsable Info -->
                            <div class="d-flex align-items-center mb-2 border-top ">
                                <div class="icon-circle bg-light-primary me-3">
                                    <i class="fas fa-user-tie text-primary"></i>
                                </div>
                                <div>
                                    <p class="mb-0 small text-muted">Responsable</p>
                                    <p class="mb-0 fw-semibold">
                                        @if ($module->responsable)
                                            {{ $module->responsable->Fullname }}
                                        @else
                                            <span class="text-warning">Non défini</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Hours Info -->
                            <div class="hours-container mb-3">
                                <!-- Header with total hours -->
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="small text-muted">Volume Horaire</span>
                                    <span class="badge bg-light text-dark fw-normal">
                                        Total: {{ $module->cm_hours + $module->td_hours + $module->tp_hours }}h
                                    </span>
                                </div>



                                <!-- Progress Bar -->
                                <div class="progress mb-2" style="height: 8px;">
                                    @php
                                        $totalHours = $module->cm_hours + $module->td_hours + $module->tp_hours;
                                    @endphp
                                    <div class="progress-bar bg-cm"
                                        style="width: {{ $totalHours ? ($module->cm_hours / $totalHours) * 100 : 0 }}%"
                                        title="CM: {{ $module->cm_hours }}h"></div>
                                    <div class="progress-bar bg-td"
                                        style="width: {{ $totalHours ? ($module->td_hours / $totalHours) * 100 : 0 }}%"
                                        title="TD: {{ $module->td_hours }}h"></div>
                                    <div class="progress-bar bg-tp"
                                        style="width: {{ $totalHours ? ($module->tp_hours / $totalHours) * 100 : 0 }}%"
                                        title="TP: {{ $module->tp_hours }}h"></div>
                                </div>



                                <!-- Hour Breakdown -->
                                <div class="d-flex justify-content-between small text-muted">
                                    <div class="d-flex align-items-center">

                                        <div class="bg-cm me-1 rounded-circle" style="width:12px; height:12px;">
                                        </div>
                                        CM:
                                        <span>{{ $module->cm_hours }}h</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-td me-1 rounded-circle" style="width:12px; height:12px;">
                                        </div>
                                        TD:
                                        <span>{{ $module->td_hours }}h</span>

                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-tp me-1 rounded-circle" style="width:12px; height:12px;">
                                        </div>
                                        TP:
                                        <span>{{ $module->tp_hours }}h</span>

                                    </div>
                                </div>
                            </div>

                            <style>

                            </style>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <a href="#" class="text-primary small" data-bs-toggle="modal"
                                    data-bs-target="#moduleDetailsModal" data-module-id="{{ $module->id }}">
                                    <i class="fas fa-info-circle me-1"></i> Détails
                                </a>
                                <!-- Dans votre boucle foreach -->
                                {{-- <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#valideSouhaite" data-module-id="{{ $module->id }}"
                                    data-module-name="{{ $module->name }}"
                                    data-module-semester="{{ $module->semester }}">
                                    <i class="fas fa-plus me-1"></i> choisir
                                </button> --}}

                                @php
                                    $requested = $module->requests->first(); // We assume only one request per user/module
                                @endphp

                                @if ($requested)
                                    @if ($requested->status === 'rejected')
                                        <button class="btn btn-sm btn-danger" disabled>
                                            <i class="fas fa-times-circle me-1"></i> Rejeté
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>
                                            <i class="fas fa-check-circle me-1"></i> Déjà choisi
                                        </button>
                                    @endif
                                @else
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#valideSouhaite" data-module-id="{{ $module->id }}"
                                        data-module-name="{{ $module->name }}"
                                        data-module-semester="{{ $module->semester }}">
                                        <i class="fas fa-plus me-1"></i> Choisir
                                    </button>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <div class="modal fade" id="valideSouhaite" tabindex="-1" aria-labelledby="valideSouhaiteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="assignModuleForm" method="POST" action="{{ route('professor.souhaiteModule') }}">
                    @csrf
                    <input type="hidden" name="module_id" id="modalModuleId" value="">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="valideSouhaiteLabel">Confirmation de souhait</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Vous êtes sur le point d'exprimer un souhait pour l'UE: <strong
                                id="wishModuleName"></strong> (S<strong id="wishModuleSemester"></strong>)
                        </div>
                        <p class="mb-0">Confirmez-vous ce choix ?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check me-1"></i> Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('valideSouhaite');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                document.getElementById('modalModuleId').value = button.getAttribute('data-module-id');
                document.getElementById('wishModuleName').textContent = button.getAttribute(
                    'data-module-name');
                document.getElementById('wishModuleSemester').textContent = button.getAttribute(
                    'data-module-semester');
            });
        });
    </script>

    <style>
        #valideSouhaite .modal-header {
            padding: 1rem 1.5rem;
        }

        #valideSouhaite .modal-body {
            padding: 1.5rem;
        }
    </style>


    {{-- <!-- Dans votre boucle foreach -->
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#chooseModuleModal"
        data-module-id="{{ $module->id }}" data-module-name="{{ $module->name }}">
        <i class="fas fa-plus me-1"></i> Choisir
    </button>

    <!-- Modal de confirmation -->
    <div class="modal fade" id="valideSouhaite" tabindex="-1" aria-labelledby="chooseModuleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="assignModuleForm" method="POST" action="#">
                    @csrf
                    <input type="hidden" name="module_id" id="modalModuleId" value="">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="modal-header">
                        <h5 class="modal-title" id="chooseModuleModalLabel">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Vous êtes sur le point d'exprimer un souhait pour l'UE: <strong
                                id="wishModuleName"></strong> (S<strong id="wishModuleSemester"></strong>)
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chooseModuleModal = document.getElementById('chooseModuleModal');

            chooseModuleModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const moduleId = button.getAttribute('data-module-id');
                const moduleName = button.getAttribute('data-module-name');

                // Mettre à jour les champs du formulaire
                document.getElementById('modalModuleId').value = moduleId;
                document.getElementById('moduleNameDisplay').textContent = moduleName;

                // Charger les groupes disponibles (optionnel)
                fetch(`/api/modules/${moduleId}/groups`)
                    .then(response => response.json())
                    .then(groups => {
                        const select = document.getElementById('group_preference');
                        select.innerHTML = '<option value="">Aucune préférence</option>';

                        groups.forEach(group => {
                            const option = document.createElement('option');
                            option.value = group.id;
                            option.textContent = `${group.name} (${group.type})`;
                            select.appendChild(option);
                        });
                    });
            });
        });
    </script> --}}
    <style>
        .module-card {
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 8px;
            overflow: hidden;
        }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .icon-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* For perfect circles in the col;or indicatroe*/
        .rounded-circle {
            border-radius: 50% !important;
        }

        .bg-cm {
            background-color: #5c7ad4;
        }

        .bg-td {
            background-color: #c8831c;
        }

        .bg-tp {
            background-color: #36b9cc;
        }

        .hours-container {
            background-color: #f8f9fc;
            padding: 12px;
            border-radius: 6px;
        }

        .progress {
            background-color: #e3e6f0;
        }
    </style>


</x-coordonnateur_layout>


{{--  --}}

<style>
    :root {
        --primary-color: #4723D9;
        --secondary-color: #2c3e50;
        --success-color: #2ecc71;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
    }

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: none;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
        background: linear-gradient(135deg, var(--primary-color), #2980b9);
        color: white;
    }

    .unit-card {
        border-left: 4px solid var(--primary-color);
        margin-bottom: 15px;
        position: relative;
    }

    .unit-card.selected {
        border-left: 4px solid var(--success-color);
        background-color: rgba(46, 204, 113, 0.05);
    }

    .disponible-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: var(--success-color);
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .hour-badge {
        background-color: var(--secondary-color);
        font-size: 0.9rem;
    }

    .btn-check-module {
        background-color: var(--warning-color);
        color: white;
        border: none;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-check-module:hover {
        background-color: #e67e22;
        transform: translateY(-1px);
    }
</style>

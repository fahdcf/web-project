<x-coordonnateur_layout>
    <div class="container py-4">
        <x-global_alert />

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-list-check me-2" aria-hidden="true"></i> Mes Demandes</h2>
            <div class="badge bg-primary rounded-pill">
                Total : {{ $requests->count() }}
            </div>
        </div>

        @php
            $chargeApproved = 0;
            $chargePending = 0;

            foreach ($requests as $request) {
                if ($request->module) {
                    // Calculate hours based on selected groups
                    $requestHours = 0;
                    
                    // Decode JSON data
                    $groupTypes = json_decode($request->group_types ?? '[]', true);
                    $tdGroups = json_decode($request->td_groups ?? '[]', true);
                    $tpGroups = json_decode($request->tp_groups ?? '[]', true);
                    
                    // Add CM hours if selected
                    if (in_array('cm', $groupTypes)) {
                        $requestHours += $request->module->cm_hours ?? 0;
                    }
                    
                    // Add TD hours based on selected groups
                    if (in_array('td', $groupTypes) && !empty($tdGroups)) {
                        $tdHoursPerGroup = ($request->module->td_hours ?? 0) / ($request->module->td_groups_available ?: 1);
                        $requestHours += $tdHoursPerGroup * count($tdGroups);
                    }
                    
                    // Add TP hours based on selected groups
                    if (in_array('tp', $groupTypes) && !empty($tpGroups)) {
                        $tpHoursPerGroup = ($request->module->tp_hours ?? 0) / ($request->module->tp_groups_available ?: 1);
                        $requestHours += $tpHoursPerGroup * count($tpGroups);
                    }
                    
                    // Add other hours if applicable
                    if (!empty($request->module->autre_hours)) {
                        $requestHours += $request->module->autre_hours;
                    }
                    
                    if ($request->status == 'approved') {
                        $chargeApproved += $requestHours;
                    } elseif ($request->status == 'pending') {
                        $chargePending += $requestHours;
                    }
                }
            }
        @endphp

        <div class="alert alert-info mx-2 my-3">
            <strong>Charge horaire en attente :</strong> {{ number_format($chargePending, 1) }}h <br>
            <strong>Charge horaire approuvée :</strong> {{ number_format($chargeApproved, 1) }}h
        </div>

        <div class="card shadow">
            <div class="card-body p-0">
                @if ($requests->isEmpty())
                    <div class="alert alert-info m-4">
                        <i class="fas fa-info-circle me-2" aria-hidden="true"></i> Vous n'avez aucune demande pour le moment.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">U.E.</th>
                                    <th scope="col">Groupes Demandés</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Charge</th>
                                    <th scope="col">Date de Demande</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    @if ($request->module)
                                        @php
                                            // Decode JSON data
                                            $groupTypes = json_decode($request->group_types ?? '[]', true);
                                            $tdGroups = json_decode($request->td_groups ?? '[]', true);
                                            $tpGroups = json_decode($request->tp_groups ?? '[]', true);
                                            
                                            // Calculate request hours
                                            $requestHours = 0;
                                            
                                            // Add CM hours if selected
                                            if (in_array('cm', $groupTypes)) {
                                                $requestHours += $request->module->cm_hours ?? 0;
                                            }
                                            
                                            // Add TD hours based on selected groups
                                            if (in_array('td', $groupTypes) && !empty($tdGroups)) {
                                                $tdHoursPerGroup = ($request->module->td_hours ?? 0) / ($request->module->td_groups_available ?: 1);
                                                $requestHours += $tdHoursPerGroup * count($tdGroups);
                                            }
                                            
                                            // Add TP hours based on selected groups
                                            if (in_array('tp', $groupTypes) && !empty($tpGroups)) {
                                                $tpHoursPerGroup = ($request->module->tp_hours ?? 0) / ($request->module->tp_groups_available ?: 1);
                                                $requestHours += $tpHoursPerGroup * count($tpGroups);
                                            }
                                            
                                            // Add other hours if applicable
                                            if (!empty($request->module->autre_hours)) {
                                                $requestHours += $request->module->autre_hours;
                                            }
                                            
                                            // Determine if this is an entire module request
                                            $isEntireModule = 
                                                (in_array('cm', $groupTypes) && $request->module->cm_groups_available > 0) &&
                                                (in_array('td', $groupTypes) && count($tdGroups) == $request->module->td_groups_available) &&
                                                (in_array('tp', $groupTypes) && count($tpGroups) == $request->module->tp_groups_available);
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $request->module->name }}</strong>
                                                <div class="small text-muted">
                                                    <span class="badge bg-info text-white">S{{ $request->module->semester }}</span>
                                                    {{ $request->module->code }}
                                                </div>
                                            </td>
                                            
                                            <td>
                                                @if ($isEntireModule)
                                                    <span class="badge bg-primary">Module Entier</span>
                                                @else
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @if (in_array('cm', $groupTypes))
                                                            <span class="badge bg-info">CM</span>
                                                        @endif
                                                        
                                                        @if (in_array('td', $groupTypes) && !empty($tdGroups))
                                                            @foreach ($tdGroups as $group)
                                                                <span class="badge bg-warning text-dark">TD{{ $group }}</span>
                                                            @endforeach
                                                        @endif
                                                        
                                                        @if (in_array('tp', $groupTypes) && !empty($tpGroups))
                                                            @foreach ($tpGroups as $group)
                                                                <span class="badge bg-danger">TP{{ $group }}</span>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @endif
                                                
                                                @if ($request->comment)
                                                    <button class="btn btn-sm btn-link text-muted p-0 mt-1" 
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-placement="top" 
                                                        title="{{ $request->comment }}">
                                                        <i class="fas fa-comment-dots"></i> Commentaire
                                                    </button>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="badge rounded-pill 
                                                    @if ($request->status == 'approved') bg-success
                                                    @elseif($request->status == 'rejected') bg-danger
                                                    @elseif($request->status == 'pending') bg-warning text-dark
                                                    @else bg-secondary @endif">
                                                    @if ($request->status == 'approved')
                                                        Approuvé
                                                    @elseif($request->status == 'rejected')
                                                        Rejeté
                                                    @elseif($request->status == 'pending')
                                                        En Attente
                                                    @else
                                                        Annulé
                                                    @endif
                                                </span>
                                            </td>
                                            
                                            <td>
                                                <div class="small">
                                                    @if (in_array('cm', $groupTypes))
                                                        <div>
                                                            <i class="fas fa-chalkboard-teacher text-info"></i> 
                                                            CM: {{ $request->module->cm_hours ?? 0 }}h
                                                        </div>
                                                    @endif
                                                    
                                                    @if (in_array('td', $groupTypes) && !empty($tdGroups))
                                                        <div>
                                                            <i class="fas fa-users text-warning"></i> 
                                                            TD: {{ number_format(($request->module->td_hours ?? 0) / ($request->module->td_groups_available ?: 1) * count($tdGroups), 1) }}h
                                                            <span class="text-muted">({{ count($tdGroups) }} groupe(s))</span>
                                                        </div>
                                                    @endif
                                                    
                                                    @if (in_array('tp', $groupTypes) && !empty($tpGroups))
                                                        <div>
                                                            <i class="fas fa-flask text-danger"></i> 
                                                            TP: {{ number_format(($request->module->tp_hours ?? 0) / ($request->module->tp_groups_available ?: 1) * count($tpGroups), 1) }}h
                                                            <span class="text-muted">({{ count($tpGroups) }} groupe(s))</span>
                                                        </div>
                                                    @endif
                                                    
                                                    @if (!empty($request->module->autre_hours))
                                                        <div>
                                                            <i class="fas fa-ellipsis-h text-secondary"></i> 
                                                            Autre: {{ $request->module->autre_hours }}h
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="fw-bold mt-1">
                                                    Total: {{ number_format($requestHours, 1) }}h
                                                </div>
                                            </td>

                                            <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if ($request->status == 'pending')
                                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#cancelRequestModal"
                                                        data-request-id="{{ $request->id }}"
                                                        data-module-name="{{ $request->module->name ?? 'N/A' }}"
                                                        data-cancel-url="{{ route('professor.request.cancel', $request) }}">
                                                        <i class="fas fa-times me-1" aria-hidden="true"></i> Annuler
                                                    </button>
                                                @else
                                                    <span class="text-muted small">Aucune action</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Cancel Request Modal -->
    <div class="modal fade" id="cancelRequestModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2" aria-hidden="true"></i> Confirmer l'Annulation
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="cancelRequestForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir annuler cette demande ?</p>
                        <div class="alert alert-warning">
                            <strong>Module :</strong> <span id="modalRequestName"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1" aria-hidden="true"></i> Fermer
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-1" aria-hidden="true"></i> Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cancelModal = document.getElementById('cancelRequestModal');

            cancelModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const moduleName = button.getAttribute('data-module-name');
                const cancelUrl = button.getAttribute('data-cancel-url');

                const form = document.getElementById('cancelRequestForm');
                form.action = cancelUrl;
                document.getElementById('modalRequestName').textContent = moduleName;
            });
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <style>
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
        }

        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        .btn-outline-danger {
            transition: all 0.2s;
        }

        .btn-outline-danger:hover {
            background-color: var(--bs-danger);
            color: white;
        }
        
        /* Badge styles for group types */
        .badge.bg-info {
            background-color: #0dcaf0 !important;
        }
        
        .badge.bg-warning {
            background-color: #ffc107 !important;
        }
        
        .badge.bg-danger {
            background-color: #dc3545 !important;
        }
        
        /* Comment tooltip */
        .tooltip {
            max-width: 300px;
        }
    </style>
</x-coordonnateur_layout>
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
                    $totalHours = ($request->module->cm_hours ?? 0) 
                                + ($request->module->td_hours ?? 0) 
                                + ($request->module->tp_hours ?? 0) 
                                + ($request->module->autre_hours ?? 0);
                    
                    if ($request->status == 'approved') {
                        $chargeApproved += $totalHours;
                    } elseif ($request->status == 'pending') {
                        $chargePending += $totalHours;
                    }
                }
            }
        @endphp

        <div class="alert alert-info mx-2 my-3">
            <strong>Charge horaire en attente :</strong> {{ $chargePending }}h <br>
            <strong>Charge horaire approuvée :</strong> {{ $chargeApproved }}h
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
                                    <th scope="col">Statut</th>
                                    <th scope="col">Charge</th>
                                    <th scope="col">Date de Demande</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    @if ($request->module)
                                        <tr>
                                            <td>
                                                <strong>{{ $request->module->name }}</strong>
                                                (S{{ $request->module->semester }})
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
                                                <small class="text-muted d-block">
                                                    CM : {{ $request->module->cm_hours ?? 0 }}h |
                                                    TD : {{ $request->module->td_hours ?? 0 }}h |
                                                    TP : {{ $request->module->tp_hours ?? 0 }}h
                                                    @if (!empty($request->module->autre_hours))
                                                        | Autre : {{ $request->module->autre_hours }}h
                                                    @endif
                                                    <br>
                                                    <strong>
                                                        Total : {{ ($request->module->cm_hours ?? 0) + ($request->module->td_hours ?? 0) + ($request->module->tp_hours ?? 0) + ($request->module->autre_hours ?? 0) }}h
                                                    </strong>
                                                </small>
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
    </style>
</x-coordonnateur_layout>
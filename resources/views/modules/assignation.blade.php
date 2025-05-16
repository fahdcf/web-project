<x-coordonnateur_layout>

    @section('content')
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1">Gestion du Module {{ $module->code }} - {{ $module->name }}</h3>
                    <div class="d-flex gap-3">
                        <span class="badge bg-primary">
                            <i class="fas fa-clock me-1"></i>
                            Total: {{ $module->cm_hours + $module->td_hours + $module->tp_hours }}h
                        </span>
                        <span class="badge bg-info">
                            CM: {{ $module->cm_hours }}h
                        </span>
                        <span class="badge bg-success">
                            TD: {{ $module->td_hours }}h
                        </span>
                        <span class="badge bg-warning">
                            TP: {{ $module->tp_hours }}h
                        </span>
                    </div>
                </div>
                <a href="{{ route('coordonnateur.modules.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Colonne des charges horaires -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Charges horaires</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('coordonnateur.modules.update-hours', $module->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Cours Magistraux (CM)</label>
                                    <input type="number" name="cm_hours" class="form-control"
                                        value="{{ $module->cm_hours }}" min="0" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Travaux Dirigés (TD)</label>
                                    <input type="number" name="td_hours" class="form-control"
                                        value="{{ $module->td_hours }}" min="0" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Travaux Pratiques (TP)</label>
                                    <input type="number" name="tp_hours" class="form-control"
                                        value="{{ $module->tp_hours }}" min="0" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-1"></i> Mettre à jour
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Colonne des assignations -->
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Assignations</h5>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addAssignationModal">
                                <i class="fas fa-plus me-1"></i> Ajouter
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Enseignents</th>
                                            <th>Rôle</th>
                                            <th>Heures</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($module->users as $vacataire)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $vacataire->photo_url ?? asset('storage/images/defaultProfile.png') }}"
                                                            class="rounded-circle me-2" width="40" height="40">
                                                        <div>
                                                            <strong>{{ $vacataire->firstname }}</strong>
                                                            <div class="text-muted small">
                                                                @if ($vacataire->isvacataire())
                                                                    Vacataire
                                                                @else
                                                                    Professeur
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge 
                                                @if ($vacataire->pivot->role == 'CM') bg-info
                                                @elseif($vacataire->pivot->role == 'TD') bg-success
                                                @elseif($vacataire->pivot->role == 'TP') bg-warning
                                                @else bg-secondary @endif">
                                                        {{ $vacataire->pivot->role }}
                                                    </span>
                                                </td>
                                                <td>{{ $vacataire->pivot->hours }}h</td>
                                                <td>
                                                    @if ($vacataire->isvacataire())
                                                        <div class="btn-group btn-group-sm ">
                                                            <button class="btn btn-outline-primary edit-assignation mx-2"
                                                                data-id="{{ $vacataire->id }}"
                                                                data-role="{{ $vacataire->pivot->role }}"
                                                                data-hours="{{ $vacataire->pivot->hours }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>



                                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                                data-bs-target="#deleteAssignation{{ $vacataire->id }}"
                                                                title="Supprimer"><i class="bi bi-trash3"></i>
                                                            </button>

                                                            {{-- confirm delet assingnation --}}
                                                            <div class="modal fade"
                                                                id="deleteAssignation{{ $vacataire->id }}" tabindex="-1"
                                                                aria-labelledby="deleteAssignationLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="deleteAssignationLabel">
                                                                                Confirmation de suppression</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Voulez-vous supprimer le l'assignation de ce
                                                                                module a
                                                                                <strong>{{ $vacataire->lastname }}
                                                                                    {{ $vacataire->firstname }}</strong>
                                                                                définitivement?
                                                                            </p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary btn-sm"
                                                                                data-bs-dismiss="modal">Fermer</button>
                                                                            <form
                                                                                action="{{ route('coordonnateur.modules.remove-assignation', [$module->id, $vacataire->id]) }}"
                                                                                method="POST" style="display: inline;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-danger btn-sm">Supprimer</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Modal de modification d'assignation -->
        <div class="modal fade" id="editAssignationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Modifier l'assignation
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form method="POST" id="editAssignationForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Rôle</label>
                                <select class="form-select" name="role" id="editRole" required>
                                    <option value="CM">Cours
                                        Magistral (CM)</option>
                                    <option value="TD">Travaux
                                        Dirigés (TD)</option>
                                    <option value="TP">Travaux
                                        Pratiques (TP)</option>
                                    <option value="Autre">Autre
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Heures
                                    attribuées</label>
                                <input type="number" class="form-control" name="hours" id="editHours" min="1"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Mettre à
                                jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal d'ajout d'assignation -->
        <div class="modal fade" id="addAssignationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Ajouter une assignation</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('coordonnateur.modules.add-assignation', $module->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Vacataire</label>
                                <select class="form-select" name="vacataire_id" required>
                                    <option value="">Sélectionner un vacataire</option>
                                    @foreach ($availableVacataires as $vacataire)
                                        <option value="{{ $vacataire->id }}">{{ $vacataire->firstname }}
                                            ({{ $vacataire->specialty }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Rôle</label>
                                <select class="form-select" name="role" required>
                                    <option value="CM">Cours Magistral (CM)</option>
                                    <option value="TD">Travaux Dirigés (TD)</option>
                                    <option value="TP">Travaux Pratiques (TP)</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Heures attribuées</label>
                                <input type="number" class="form-control" name="hours" min="1" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>






        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Gestion de la modification d'assignation
                document.querySelectorAll('.edit-assignation').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const vacataireId = this.dataset.id;
                        const form = document.getElementById('editAssignationForm');

                        form.action =
                            `/coordonnateur/modules/{{ $module->id }}/assignations/${vacataireId}`;
                        document.getElementById('editRole').value = this.dataset.role;
                        document.getElementById('editHours').value = this.dataset.hours;

                        new bootstrap.Modal(document.getElementById('editAssignationModal')).show();
                    });
                });
            });
        </script>

        <style>
            .badge {
                font-weight: 500;
                padding: 0.5em 0.75em;
            }

            .table td {
                vertical-align: middle;
            }

            .btn-group-sm .btn {
                padding: 0.25rem 0.5rem;
            }
        </style>
    </x-coordonnateur_layout>

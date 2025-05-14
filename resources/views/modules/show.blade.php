<x-coordonnateur_layout>

<div class="container-fluid py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Détails de l'UE: {{ $module->name }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Code:</strong> {{ $module->code }}</p>
                        <p><strong>Intitulé:</strong> {{ $module->name }}</p>
                        <p><strong>Semestre:</strong> S{{ $module->semester }}</p>
                        <p><strong>Crédits ECTS:</strong> {{ $module->credits }}</p>
                        <p><strong>Statut:</strong>
                            @if ($module->status == 1)
                                <span class="badge bg-success">Actif</span>
                            @elseif ($module->status == 0)
                                <span class="badge bg-danger">Inactif</span>
                            @else
                                <span class="badge bg-warning">Non défini</span>
                            @endif
                        </p>
                        @if ($module->description)
                            <p><strong>Description pédagogique:</strong> {{ $module->description }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <p><strong>Volume Horaire:</strong></p>
                        <ul>
                            <li>CM: {{ $module->cm_hours }} heures</li>
                            <li>TD: {{ $module->td_hours }} heures</li>
                            <li>TP: {{ $module->tp_hours }} heures</li>
                        </ul>
                        @if ($module->responsable)
                            <p><strong>Responsable du module:</strong> {{ $module->responsable->lastname }} {{ $module->responsable->firstname }}</p>
                        @endif
                        @if ($module->professor)
                            <p><strong>Professeur assigné:</strong> {{ $module->professor->lastname }} {{ $module->professor->firstname }}</p>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <h5>Enseignants assignés:</h5>
                    @if ($module->users->isNotEmpty())
                        <ul>
                            @foreach ($module->users as $user)
                                <li>{{ $user->lastname }} {{ $user->firstname }}
                                    @if ($user->pivot->is_responsible)
                                        (Responsable)
                                    @endif
                                    <small>(Charge: {{ $user->pivot->hours }}h, Role: {{ $user->pivot->role }})</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Aucun enseignant assigné à cette UE.</p>
                    @endif
                </div>

                <div class="mt-4">
                    <a href="{{ route('coordonnateur.modules.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste des UEs
                    </a>
                    <a href="{{ route('coordonnateur.modules.edit', $module->id) }}" class="btn btn-primary ms-2">
                        <i class="fas fa-edit me-2"></i>Modifier l'UE
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-coordonnateur_layout>
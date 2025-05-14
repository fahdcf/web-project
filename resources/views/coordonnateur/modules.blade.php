@foreach($modules as $module)
<div class="card">
    <h3>{{ $module->nom }}</h3>
    <!-- Affiche le prénom ET le nom + rôle pour plus de clarté -->

    <p>
        Responsable : Pr. @if($module->professor) {{ $module->professor->firstname }} {{ $module->professor->lastname }}
        @else
        <span class="text-danger">À attribuer</span>
        @endif
    </p>

    <p>Charge horaire : {{ $module->volume_horaire }}h</p>

    <a href="{{ route('coordinator.assign', $module) }}" class="btn btn-primary">
        <i class="fas fa-user-edit"></i> Modifier l'affectation
    </a>
</div>
@endforeach

<x-coordonnateur_layout>

    <div class="container py-4">
        <h3 class="mb-4">Validation de l'assignation</h3>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Récapitulatif</h5>
            </div>
            <div class="card-body">
                <p><strong>Vacataire :</strong> {{ $vacataire->firstname }} {{ $vacataire->lastname }}</p>

                <h5 class="mt-4">UE à assigner :</h5>
                <ul class="list-group">
                    @foreach ($selectedModules as $module)
                        <li class="list-group-item">
                            <strong>{{ $module->code }}</strong> - {{ $module->name }}
                        </li>
                    @endforeach
                </ul>

                @if (count($removedModules) > 0)
                    <h5 class="mt-4">UE à désassigner :</h5>
                    <ul class="list-group">
                        @foreach ($removedModules as $module)
                            <li class="list-group-item">
                                <strong>{{ $module->code }}</strong> - {{ $module->name }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('coordonnateur.vacataires.confirm-assign') }}">
            @csrf
            <input type="hidden" name="vacataire_id" value="{{ $vacataire->id }}">
            @foreach ($selectedModules as $module)
                <input type="hidden" name="ues[]" value="{{ $module->id }}">
            @endforeach

            <div class="text-end">
                <a href="{{ route('coordonnateur.vacataires.assign', $vacataire->id) }}"
                    class="btn btn-secondary">Modifier</a>
                <button type="submit" class="btn btn-success">Confirmer l'assignation</button>
            </div>
        </form>
    </div>

</x-coordonnateur_layout>

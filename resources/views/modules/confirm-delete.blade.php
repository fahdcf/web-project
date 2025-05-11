<x-coordonnateur_layout>
        <div class="container-fluid py-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Confirmation de suppression</h5>
                </div>
                <div class="card-body">
                    <p>Êtes-vous sûr de vouloir supprimer l'UE <strong>{{ $module->name }}</strong> (ID: {{ $module->id }}) ?</p>
                    <p class="text-danger"><strong>Attention :</strong> Cette action est irréversible.</p>
                    <form action="{{ route('coordonnateur.modules.destroy', $module->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                        <a href="{{ route('coordonnateur.modules.index') }}" class="btn btn-secondary ms-2">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
</x-coordonnateur_layout>
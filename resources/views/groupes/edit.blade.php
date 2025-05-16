<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Modifier le Groupe - {{ $module->name }} - {{ $group->name ?? $group->type }}</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('groupes.update', [$module->id, $group->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="type" class="form-label">Type de Groupe*</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="TP" {{ $group->type === 'TP' ? 'selected' : '' }}>TP</option>
                                    <option value="TD" {{ $group->type === 'TD' ? 'selected' : '' }}>TD</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom du Groupe (Optionnel)</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $group->name }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="max_students" class="form-label">Nombre Max. d'Étudiants (Optionnel)</label>
                                <input type="number" class="form-control @error('max_students') is-invalid @enderror" id="max_students" name="max_students" min="0" value="{{ $group->max_students }}">
                                @error('max_students')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="annee" class="form-label">Année Académique*</label>
                                <input type="number" class="form-control @error('annee') is-invalid @enderror" id="annee" name="annee" value="{{ $group->annee }}" required>
                                @error('annee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Enregistrer les Modifications</button>
                            <a href="{{ route('groupes.index', $module->id) }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions d-flex justify-content-between mt-4 pt-3 border-top">
                <a href="{{ route('coordonnateur.modules.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-times-circle me-2"></i>Annuler
                </a>
                <a href="{{ route('groupes.index', $module->id) }}" class="btn btn-info px-4 me-2">
                    <i class="fas fa-users me-2"></i>Gérer les Groupes
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i>Modifier l'UE
                </button>
            </div>

</x-coordonnateur_layout>
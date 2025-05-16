<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Créer un Nouveau Groupe - {{ $module->name }}</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('groupes.store', $module->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="type" class="form-label">Type de Groupe*</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Sélectionner le type</option>
                                    <option value="TP">TP</option>
                                    <option value="TD">TD</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom du Groupe (Optionnel)</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="max_students" class="form-label">Nombre Max. d'Étudiants (Optionnel)</label>
                                <input type="number" class="form-control @error('max_students') is-invalid @enderror" id="max_students" name="max_students" min="0">
                                @error('max_students')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="annee" class="form-label">Année Académique*</label>
                                <input type="number" class="form-control @error('annee') is-invalid @enderror" id="annee" name="annee" value="{{ now()->year }}" required>
                                @error('annee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Créer le Groupe</button>
                            <a href="{{ route('groupes.index', $module->id) }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-coordonnateur_layout>
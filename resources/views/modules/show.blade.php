<x-coordonnateur_layout>
        <div class="header-container mb-4">
            <style>
                .header-container {
                    background: white;
                    border-radius: 8px;
                    padding: 20px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                }

                .form-label {
                    font-size: 0.85rem;
                    font-weight: 600;
                    color: #34495e;
                }

                .form-control,
                .form-select {
                    border-color: #e0e0e0;
                    font-size: 0.9rem;
                    padding: 8px 12px;
                    border-radius: 6px;
                    transition: border-color 0.2s;
                }

                .form-control:focus,
                .form-select:focus {
                    border-color: #4723d9;
                    box-shadow: 0 0 0 2px rgba(71, 35, 217, 0.2);
                    outline: none;
                }

                .btn-primary {
                    background-color: #4723d9;
                    border-color: #4723d9;
                    font-size: 0.9rem;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-weight: 500;
                    transition: all 0.2s;
                }

                .btn-primary:hover {
                    background-color: white;
                    color: #4723d9;
                    border-color: #4723d9;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .btn-danger {
                    background-color: #e74c3c;
                    border-color: #e74c3c;
                    font-size: 0.9rem;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-weight: 500;
                    transition: all 0.2s;
                }

                .btn-danger:hover {
                    background-color: white;
                    color: #e74c3c;
                    border-color: #e74c3c;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .detail-item {
                    display: flex;
                    align-items: flex-start;
                    gap: 12px;
                    margin-bottom: 1rem;
                }

                .detail-icon {
                    color: #4723d9;
                    font-size: 1rem;
                    margin-top: 2px;
                }

                .detail-label {
                    display: block;
                    font-size: 0.75rem;
                    color: #95a5a6;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }

                .detail-value {
                    display: block;
                    font-size: 0.95rem;
                    font-weight: 500;
                    color: #34495e;
                    margin-top: 2px;
                }



                .modal-content {
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                }

                .modal-header {
                    border-bottom: 1px solid #e0e0e0;
                }

                .modal-footer {
                    border-top: 1px solid #e0e0e0;
                }

                @media (max-width: 768px) {
                    .header-container {
                        padding: 15px;
                    }

                    .form-group {
                        margin-bottom: 1rem;
                    }

                    .btn-primary,
                    .btn-danger {
                        width: 100%;
                        margin-bottom: 0.5rem;
                    }
                }
            </style>

            <div class="d-flex align-items-center gap-3 mb-4">
                <i class="fas fa-book-open fa-2x" style="color: #330bcf;"></i>
                <h3 style="color: #330bcf; font-weight: 500;">Détails de l'Unité d'Enseignement</h3>
            </div>

            <form action="{{ route('coordonnateur.modules.update', $module) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $module->name) }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code" name="code"
                                value="{{ old('code', $module->code) }}" required>
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="complet" {{ old('type', $module->type) == 'complet' ? 'selected' : '' }}>
                                    Complet</option>
                                <option value="partiel" {{ old('type', $module->type) == 'partiel' ? 'selected' : '' }}>
                                    Partiel</option>
                            </select>
                            @error('type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="semester" class="form-label">Semestre</label>
                            <select class="form-select" id="semester" name="semester" required>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}"
                                        {{ old('semester', $module->semester) == $i ? 'selected' : '' }}>
                                        {{ $i == 1 ? '1er' : $i . 'ème' }} Semestre
                                    </option>
                                @endfor
                            </select>
                            @error('semester')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status" class="form-label">Statut</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active"
                                    {{ old('status', $module->status) == 'active' ? 'selected' : '' }}>Actif</option>
                                <option value="inactive"
                                    {{ old('status', $module->status) == 'inactive' ? 'selected' : '' }}>Inactif
                                </option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="credit" class="form-label">Crédit</label>
                            <input type="number" class="form-control" id="credit" name="credit"
                                value="{{ old('credit', $module->credit) }}" min="0">
                            @error('credit')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="evaluation" class="form-label">Évaluation</label>
                            <input type="text" class="form-control" id="evaluation" name="evaluation"
                                value="{{ old('evaluation', $module->evaluation) }}">
                            @error('evaluation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cm_hours" class="form-label">Heures CM</label>
                            <input type="number" class="form-control" id="cm_hours" name="cm_hours"
                                value="{{ old('cm_hours', $module->cm_hours) }}" min="0" step="0.5">
                            @error('cm_hours')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="td_hours" class="form-label">Heures TD</label>
                            <input type="number" class="form-control" id="td_hours" name="td_hours"
                                value="{{ old('td_hours', $module->td_hours) }}" min="0" step="0.5">
                            @error('td_hours')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tp_hours" class="form-label">Heures TP</label>
                            <input type="number" class="form-control" id="tp_hours" name="tp_hours"
                                value="{{ old('tp_hours', $module->tp_hours) }}" min="0" step="0.5">
                            @error('tp_hours')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="responsable_id" class="form-label">Responsable</label>
                            <select class="form-select" id="responsable_id" name="responsable_id">
                                <option value="">Aucun</option>
                                @foreach ($responsables as $responsable)
                                    <option value="{{ $responsable->id }}"
                                        {{ old('responsable_id', $module->responsable_id) == $responsable->id ? 'selected' : '' }}>
                                        {{ $responsable->firstname }} {{ $responsable->lastname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('responsable_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $module->description) }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="detail-item">
                            <i class="bi bi-calendar-week detail-icon"></i>
                            <div>
                                <span class="detail-label">Date de création</span>
                                <span class="detail-value">{{ $module->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4 flex-wrap">
                    <form action="{{ route('coordonnateur.modules.update', $module) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>
                    <a href="{{ route('coordonnateur.modules.destroy', $module->id) }}"
                        class="btn btn-secondary">Retour</a>
                    <button data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger">
                        <i class="bi bi-trash-fill"></i> Supprimer
                    </button>

                </div>
            </form>
        </div>






    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer cette unité d'enseignement ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteForm" action="{{ route('coordonnateur.modules.destroy', $module->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-coordonnateur_layout>

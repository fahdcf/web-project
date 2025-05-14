<x-coordonnateur_layout>
    <div class="container-fluid mt-5 py-4 shadow-sm">

        <form action="{{ route('coordonnateur.modules.update', $module->id) }}" method="POST" class="border p-4 rounded mt-5">
            @method('PUT')
            @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label for="code_edit" class="form-label small fw-bold text-muted">Code UE*</label>
                <input type="text" class="form-control form-control-sm" id="code_edit" name="code" value="{{ $module->code }}" required />
            </div>
            <div class="col-md-6">
                <label for="name_edit" class="form-label small fw-bold text-muted">Intitulé*</label>
                <input type="text" class="form-control form-control-sm" id="name_edit" name="name" value="{{ $module->name }}" required />
            </div>

            <div class="col-md-4">
                <label for="cm_hours_edit" class="form-label small fw-bold text-muted">CM (heures)*</label>
                <input type="number" class="form-control form-control-sm" id="cm_hours_edit" name="cm_hours" min="0" value="{{ $module->cm_hours }}" required />
            </div>
            <div class="col-md-4">
                <label for="td_hours_edit" class="form-label small fw-bold text-muted">TD (heures)*</label>
                <input type="number" class="form-control form-control-sm" id="td_hours_edit" name="td_hours" min="0" value="{{ $module->td_hours }}" required />
            </div>
            <div class="col-md-4">
                <label for="tp_hours_edit" class="form-label small fw-bold text-muted">TP (heures)*</label>
                <input type="number" class="form-control form-control-sm" id="tp_hours_edit" name="tp_hours" min="0" value="{{ $module->tp_hours }}" required />
            </div>

            <div class="col-md-12">
                <label for="specialty_edit" class="form-label small fw-bold text-muted">Spécialité du module</label>
                <input type="text" class="form-control form-control-sm" id="specialty_edit" name="specialty" value="{{ $module->specialty }}">
            </div>

            <div class="col-md-4">
                <label for="annee_edit" class="form-label small fw-bold text-muted">Année*</label>
                <select class="form-select form-select-sm" id="annee_edit" name="annee" required>
                    <option value="1" {{ $module->annee == 1 ? 'selected' : '' }}>1ère Année</option>
                    <option value="2" {{ $module->annee == 2 ? 'selected' : '' }}>2ème Année</option>
                    <option value="3" {{ $module->annee == 3 ? 'selected' : '' }}>3ème Année</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="semestre_edit" class="form-label small fw-bold text-muted">Semestre*</label>
                <select class="form-select form-select-sm" id="semestre_edit" name="semestre" required>
                    <option value="1" {{ $module->semestre == 1 ? 'selected' : '' }}>Semestre 1</option>
                    <option value="2" {{ $module->semestre == 2 ? 'selected' : '' }}>Semestre 2</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="credits_edit" class="form-label small fw-bold text-muted">Crédits ECTS*</label>
                <input type="number" class="form-control form-control-sm" id="credits_edit" name="credits" min="1" value="{{ $module->credit }}" required />
            </div>

            <div class="col-12">
                <h6 class="mt-3 mb-2 small fw-bold text-muted">Nombre de groupes</h6>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label for="td_groups_edit" class="form-label small fw-bold text-muted">Groupes TD*</label>
                        <input type="number" class="form-control form-control-sm" id="td_groups_edit" name="nb_groupes_td" min="1" value="{{ $module->nb_groupes_td }}" required />
                    </div>
                    <div class="col-md-6">
                        <label for="tp_groups_edit" class="form-label small fw-bold text-muted">Groupes TP*</label>
                        <input type="number" class="form-control form-control-sm" id="tp_groups_edit" name="nb_groupes_tp" min="1" value="{{ $module->nb_groupes_tp }}" required />
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <label for="professor_id_edit" class="form-label small fw-bold text-muted">Responsable</label>
                <select class="form-select form-select-sm" id="professor_id_edit" name="responsable_id">
                    <option value="">Sélectionner un enseignant</option>
                    @foreach($professors as $professor)
                    <option value="{{ $professor->id }}" {{ $module->professor_id == $professor->id ? 'selected' : '' }}>
                        {{ $professor->firstname }} {{ $professor->lastname }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="statut_edit" class="form-label small fw-bold text-muted">Statut*</label>
                <select class="form-select form-select-sm" id="statut_edit" name="statut" required>
                    <option value="actif" {{ $module->statut == 'actif' ? 'selected' : '' }}>Actif</option>
                    <option value="inactif" {{ $module->statut == 'inactif' ? 'selected' : '' }}>Inactif</option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-2"></i> Mettre à jour
            </button>
        </div>

        </form>
    </div>
</x-coordonnateur_layout>
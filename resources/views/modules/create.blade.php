<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <form action="{{ route('coordonnateur.modules.store') }}" method="POST" class="border p-4 rounded mt-5">
            @csrf

            <div class="mb-4 bg-light p-3 rounded">
                <h4 class="mb-0">Filière: {{ $filiere->name ?? 'Non définie' }}</h4>
                <small class="text-muted">Année universitaire: {{ $anneeUniversitaire ?? now()->year }}</small>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
                <h3 class="h5 mb-3 fw-bold border-bottom pb-2">
                    <i class="fas fa-info-circle me-2"></i>Informations essentielles
                </h3>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="code" class="form-label">Code UE*</label>
                        <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" required
                               placeholder="Ex: M1101" pattern="[A-Za-z0-9]{4,6}" value="{{ old('code') }}">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="name" class="form-label">Nom complet*</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required
                               placeholder="Ex: Programmation Web Avancée" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="specialty" class="form-label">Spécialité*</label>
                        <select name="specialty" id="specialty" 
                                    class="form-select @error('specialty') is-invalid @enderror" required>
                                <option value="">Sélectionner...</option>
                                @foreach(['Informatique Fondamentale', 'Génie Logiciel', 'Systèmes d\'Information', 'Intelligence Artificielle'] as $spec)
                                    <option value="{{ $spec }}" {{ old('specialty') == $spec ? 'selected' : '' }}>
                                        {{ $spec }}
                                    </option>
                                @endforeach
                            </select>

                        @error('specialty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="semester" class="form-label">Semestre*</label>
                        <select name="semester" id="semester" class="form-select @error('semester') is-invalid @enderror" required>
                            @for($i=1; $i<=6; $i++)
                                <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>S{{ $i }}</option>
                            @endfor
                        </select>
                        @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="credit" class="form-label">Crédits ECTS*</label>
                        <input type="number" name="credit" id="credit" class="form-control @error('credit') is-invalid @enderror"
                               value="{{ old('credit', 3) }}" min="1" max="6" required>
                        @error('credit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description pédagogique</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                              placeholder="Objectifs d'apprentissage...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <h3 class="h5 mb-3 fw-bold border-bottom pb-2">
                    <i class="fas fa-clock me-2"></i>Volume horaire
                </h3>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="cm_hours" class="form-label">CM (heures)*</label>
                        <input type="number" name="cm_hours" id="cm_hours" class="form-control @error('cm_hours') is-invalid @enderror"
                               value="{{ old('cm_hours', 15) }}" min="0" required>
                        @error('cm_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="td_hours" class="form-label">TD (heures)*</label>
                        <input type="number" name="td_hours" id="td_hours" class="form-control @error('td_hours') is-invalid @enderror"
                               value="{{ old('td_hours', 30) }}" min="0" required>
                        @error('td_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tp_hours" class="form-label">TP (heures)*</label>
                        <input type="number" name="tp_hours" id="tp_hours" class="form-control @error('tp_hours') is-invalid @enderror"
                               value="{{ old('tp_hours', 20) }}" min="0" required>
                        @error('tp_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-info py-2">
                    <small>Total: <span id="total_hours">65</span> heures</small>
                </div>
            </div>

            <div class="mb-4">
                <h3 class="h5 mb-3 fw-bold border-bottom pb-2">
                    <i class="fas fa-user-tie me-2"></i>Responsable du module*
                </h3>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="responsable_id" class="form-label">Sélectionner un responsable</label>
                        <select name="responsable_id" id="responsable_id" class="form-select @error('responsable_id') is-invalid @enderror">
                            <option value="">Sélectionner un professeur responsable</option>
                            @foreach($professeurs as $prof)
                                <option value="{{ $prof->id }}" {{ old('responsable_id') == $prof->id ? 'selected' : '' }}>{{ $prof->fullname }}</option>
                            @endforeach
                            <option value="vacataire" {{ old('responsable_id') == 'vacataire' ? 'selected' : '' }}>Assigner un vacataire comme responsable</option>
                        </select>
                        @error('responsable_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div id="vacataire_fields" style="{{ old('responsable_id') == 'vacataire' ? 'display:block;' : 'display:none;' }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="vacataire_nom" class="form-label">Nom complet du vacataire*</label>
                            <input type="text" name="vacataire_nom" id="vacataire_nom" class="form-control @error('vacataire_nom') is-invalid @enderror" value="{{ old('vacataire_nom') }}">
                            @error('vacataire_nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="vacataire_email" class="form-label">Email du vacataire*</label>
                            <input type="email" name="vacataire_email" id="vacataire_email" class="form-control @error('vacataire_email') is-invalid @enderror" value="{{ old('vacataire_email') }}">
                            @error('vacataire_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary">
                    <i class="fas fa-history me-2"></i>Annuler
                </button>

                <div>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-check-circle me-2"></i>Créer l'UE
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const responsableSelect = document.getElementById('responsable_id');
        const vacataireFields = document.getElementById('vacataire_fields');

        function toggleVacataireFields() {
            if (responsableSelect.value === 'vacataire') {
                vacataireFields.style.display = 'block';
                document.getElementById('vacataire_nom').required = true;
                document.getElementById('vacataire_email').required = true;
            } else {
                vacataireFields.style.display = 'none';
                document.getElementById('vacataire_nom').required = false;
                document.getElementById('vacataire_email').required = false;
            }
        }

        if (responsableSelect) {
            responsableSelect.addEventListener('change', toggleVacataireFields);
            // Afficher/cacher les champs au chargement de la page si 'vacataire' était sélectionné précédemment
            toggleVacataireFields();
        }

        // Calcul du total des heures
        ['cm_hours', 'td_hours', 'tp_hours'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', updateTotalHours);
            }
        });

        function updateTotalHours() {
            const cm = parseInt(document.getElementById('cm_hours')?.value) || 0;
            const td = parseInt(document.getElementById('td_hours')?.value) || 0;
            const tp = parseInt(document.getElementById('tp_hours')?.value) || 0;

            const total = cm + td + tp;
            const totalHoursElement = document.getElementById('total_hours');
            if (totalHoursElement) {
                totalHoursElement.textContent = total;
            }
        }
    </script>
</x-coordonnateur_layout>
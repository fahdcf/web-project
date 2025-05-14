<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <form action="{{ route('coordonnateur.modules.store') }}" method="POST"
            class="module-form border p-4 rounded mt-5">
            @csrf

            <div class="form-header mb-4 bg-light p-3 rounded">
                <h4 class="mb-0">Filière: {{ $filiere->name ?? 'Non définie' }}</h4>
                <small class="text-muted">Année universitaire: {{ $anneeUniversitaire ?? now()->year }}</small>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-section mb-4">
                <h3 class="section-title h5 mb-3 fw-bold border-bottom pb-2">
                    <i class="fas fa-info-circle me-2"></i>Informations essentielles
                </h3>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="type" class="form-label">Type UE*</label>
                        <select name="type" id="type" class="form-select @error('type') is-invalid @enderror"
                            required>
                            <option value="">Sélectionner le type</option>
                            <option value="complet" {{ old('type') == 'complet' ? 'selected' : '' }}>Complet</option>
                            <option value="element" {{ old('type') == 'element' ? 'selected' : '' }}>Élément</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="name" class="form-label">Nom complet*</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" required
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
                            @foreach (['Informatique Fondamentale', 'Génie Logiciel', 'Systèmes d\'Information', 'Intelligence Artificielle'] as $spec)
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
                        <select name="semester" id="semester"
                            class="form-select @error('semester') is-invalid @enderror" required>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>
                                    S{{ $i }}</option>
                            @endfor
                        </select>
                        @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="credit" class="form-label">Crédits ECTS*</label>
                        <input type="number" name="credit" id="credit"
                            class="form-control @error('credit') is-invalid @enderror" value="{{ old('credit', 3) }}"
                            min="1" max="6" required>
                        @error('credit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description pédagogique</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                        rows="3" placeholder="Objectifs d'apprentissage...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- <div id="parent_module_field" class="form-section mb-4"
                style="{{ old('type') == 'element' ? 'display:block;' : 'display:none;' }}">
                <h3 class="section-title h5 mb-3 fw-bold border-bottom pb-2">
                    <i class="fas fa-sitemap me-2"></i>Module Parent
                </h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="parent_id" class="form-label">Sélectionner un module parent*</label>
                        <select name="parent_id" id="parent_id"
                            class="form-select @error('parent_id') is-invalid @enderror">
                            <option value="">Sélectionner un module parent</option>
                            @foreach ($parentModules as $parentModule)
                                <option value="{{ $parentModule->id }}"
                                    {{ old('parent_id') == $parentModule->id ? 'selected' : '' }}>
                                    {{ $parentModule->code }} - {{ $parentModule->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <p>ajouter le parent module first si n'exist pas <a href="#">cree le module parent</a></p>
                    </div>
                </div>
            </div> --}}
            <div id="parent_module_field" class="form-section mb-4" style="{{ old('type') == 'element' ? 'display:block;' : 'display:none;' }}">
    <h3 class="section-title h5 mb-3 fw-bold border-bottom pb-2">
        <i class="fas fa-sitemap me-2"></i>Module Parent
    </h3>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="parent_id" class="form-label">Sélectionner un module parent*</label>
            <select name="parent_id" id="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                <option value="">Sélectionner un module parent</option>
                @foreach ($parentModules as $parentModule)
                    <option value="{{ $parentModule->id }}" {{ old('parent_id') == $parentModule->id ? 'selected' : '' }}>
                        {{ $parentModule->code }} - {{ $parentModule->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <p class="text-muted">
                Sélectionnez le module parent pour cet élément.
                <br>
                Si le module parent souhaité n'existe pas, vous pouvez le créer
                <a href="{{ route('coordonnateur.modules.create') }}" class="alert-link">ici</a>.
            </p>
        </div>
    </div>
</div>




            <div class="form-section mb-4">
                <h3 class="section-title h5 mb-3 fw-bold border-bottom pb-2">
                    <i class="fas fa-clock me-2"></i>Volume horaire
                </h3>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="cm_hours" class="form-label">CM (heures)*</label>
                        <input type="number" name="cm_hours" id="cm_hours"
                            class="form-control @error('cm_hours') is-invalid @enderror"
                            value="{{ old('cm_hours', 15) }}" min="0" required>
                        @error('cm_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="td_hours" class="form-label">TD (heures)*</label>
                        <input type="number" name="td_hours" id="td_hours"
                            class="form-control @error('td_hours') is-invalid @enderror"
                            value="{{ old('td_hours', 30) }}" min="0" required>
                        @error('td_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tp_hours" class="form-label">TP (heures)*</label>
                        <input type="number" name="tp_hours" id="tp_hours"
                            class="form-control @error('tp_hours') is-invalid @enderror"
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

            <div class="form-section mb-4">
                <h3 class="section-title h5 mb-3 fw-bold border-bottom pb-2">
                    <i class="fas fa-user-tie me-2"></i>Responsable du module*
                </h3>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="responsable_id" class="form-label">Sélectionner un responsable</label>
                        <select name="responsable_id" id="responsable_id"
                            class="form-select @error('responsable_id') is-invalid @enderror">
                            <option value="">Sélectionner un professeur responsable</option>
                            @foreach ($professeurs as $prof)
                                <option value="{{ $prof->id }}"
                                    {{ old('responsable_id') == $prof->id ? 'selected' : '' }}>{{ $prof->fullname }}
                                </option>
                            @endforeach
                            <option value="vacataire" {{ old('responsable_id') == 'vacataire' ? 'selected' : '' }}>
                                Assigner un vacataire comme responsable</option>
                        </select>
                        @error('responsable_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div id="vacataire_fields" class="vacataire-fields"
                    style="{{ old('responsable_id') == 'vacataire' ? 'display:block;' : 'display:none;' }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="vacataire_nom" class="form-label">Nom complet du vacataire*</label>
                            <input type="text" name="vacataire_nom" id="vacataire_nom"
                                class="form-control @error('vacataire_nom') is-invalid @enderror"
                                value="{{ old('vacataire_nom') }}">
                            @error('vacataire_nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="vacataire_email" class="form-label">Email du vacataire*</label>
                            <input type="email" name="vacataire_email" id="vacataire_email"
                                class="form-control @error('vacataire_email') is-invalid @enderror"
                                value="{{ old('vacataire_email') }}">
                            @error('vacataire_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions d-flex justify-content-between mt-4">
                <a href="{{ route('coordonnateur.modules.index') }}" class="btn btn-secondary-action">
                    <i class="fas fa-history me-2"></i>Annuler
                </a>

                <div>
                    <button type="submit" class="btn btn-primary-action px-4">
                        <i class="fas fa-check-circle me-2"></i>Créer l'UE
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const typeSelect = document.getElementById('type');
        const parentModuleField = document.getElementById('parent_module_field');
        const responsableSelect = document.getElementById('responsable_id');
        const vacataireFields = document.getElementById('vacataire_fields');

        function toggleTypeSpecificFields() {
            if (typeSelect.value === 'element') {
                parentModuleField.style.display = 'block';
                document.getElementById('parent_id').required = true;
                vacataireFields.style.display = 'none'; // Hide vacataire fields if element
                responsableSelect.value = ''; // Reset responsable select
                vacataireFields.style.display = 'none';
            } else if (typeSelect.value === 'complet') {
                parentModuleField.style.display = 'none';
                document.getElementById('parent_id').required = false;
            } else {
                parentModuleField.style.display = 'none';
                document.getElementById('parent_id').required = false;
            }
            toggleVacataireFields(); // Keep vacataire logic
        }

        if (typeSelect) {
            typeSelect.addEventListener('change', toggleTypeSpecificFields);
            toggleTypeSpecificFields(); // Initial call
        }

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



<style>
    .module-form {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .form-header {
        background-color: #e9ecef;
        border-bottom: 1px solid #dee2e6;
        padding: 1rem;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .section-title {
        font-size: 1.1rem;
        color: #495057;
    }

    .form-section {
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .form-label {
        font-size: 0.9rem;
        color: #495057;
        margin-bottom: 0.25rem;
        display: inline-block;
        /* Ensure label takes full width */
    }

    .form-control,
    .form-select {
        display: block;
        /* Ensure input takes full width */
        width: 100%;
        /* Take full width */
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus,
    .form-select:focus {
        color: #495057;
        background-color: #fff;
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .error-message {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border-radius: 0.25rem;
    }

    .vacataire-fields {
        padding-top: 1rem;
        border-top: 1px solid #dee2e6;
    }

    .form-actions {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 0 0 0.5rem 0.5rem;
    }

    .btn-primary-action,
    .btn-secondary-action {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        transition: all 0.15s ease-in-out;
    }

    .btn-primary-action {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .btn-primary-action:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-secondary-action {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #fff;
    }

    .btn-secondary-action:hover {
        background-color: #545b62;
        border-color: #4e555b;
    }

    .alert-info {
        font-size: 0.875rem;
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }
</style>

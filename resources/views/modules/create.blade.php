<x-coordonnateur_layout>

    <div class="container-fluid py-4">
        <form action="{{ route('coordonnateur.modules.store') }}" method="POST"
            class="module-form border p-4 rounded mt-5 bg-white shadow-sm">
            @csrf

            <div class="form-header mb-4 bg-primary text-white p-3 rounded">
                <h4 class="mb-0"><i class="fas fa-book me-2"></i>Filière: {{ $filiere->name ?? 'Non définie' }}</h4>
                <small class="text-white-50">Année universitaire: {{ $anneeUniversitaire ?? now()->year }}</small>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger error-message">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-section mb-4">
                <h3 class="section-title h5 mb-3 fw-bold border-bottom pb-2 text-primary">
                    <i class="fas fa-info-circle me-2"></i>Informations essentielles
                </h3>

                <div class="row g-3">
                    <div class="col-md-4">
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

                    <div class="col-md-8">
                        <label for="name" class="form-label">Nom complet*</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" required
                            placeholder="Ex: Programmation Web Avancée" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
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

                    <div class="col-md-3">
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

                    <div class="col-md-3">
                        <label for="credits" class="form-label">Crédits ECTS*</label>
                        <input type="number" name="credits" id="credits"
                            class="form-control @error('credits') is-invalid @enderror" value="{{ old('credits', 3) }}"
                            min="1" max="6" required>
                        @error('credits')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="evaluation" class="form-label">Évaluation*</label>
                        <input type="number" name="evaluation" id="evaluation"
                            class="form-control @error('evaluation') is-invalid @enderror"
                            value="{{ old('evaluation', 1) }}" min="1" max="10" required>
                        @error('evaluation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Coefficient d'évaluation (1-10)</small>
                    </div>





                    <div class="col-12">
                        <label for="description" class="form-label">Description pédagogique</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                            rows="3" placeholder="Objectifs d'apprentissage...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="parent_module_field" class="form-section mb-4"
                style="{{ old('type') == 'element' ? 'display:block;' : 'display:none;' }}">
                <h3 class="section-title h5 mb-3 fw-bold border-bottom pb-2 text-primary">
                    <i class="fas fa-sitemap me-2"></i>Module Parent
                </h3>
                <div class="row g-3">
                    <div class="col-md-6">
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

                    <div class="col-md-6 d-flex align-items-end">
                        <div class="alert alert-info p-2 mb-0 w-100">
                            <small>
                                <i class="fas fa-info-circle me-1"></i>
                                Si le module parent souhaité n'existe pas, vous pouvez le créer
                                <a href="{{ route('coordonnateur.modules.create') }}" class="alert-link">ici</a>.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section mb-4">
                <h3 class="section-title h5 mb-3 fw-bold border-bottom pb-2 text-primary">
                    <i class="fas fa-clock me-2"></i>Volume horaire
                </h3>

                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="cm_hours" class="form-label">CM (heures)*</label>
                        <input type="number" name="cm_hours" id="cm_hours"
                            class="form-control @error('cm_hours') is-invalid @enderror"
                            value="{{ old('cm_hours', 20) }}" min="0" required>
                        @error('cm_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="td_hours" class="form-label">TD (heures)*</label>
                        <input type="number" name="td_hours" id="td_hours"
                            class="form-control @error('td_hours') is-invalid @enderror"
                            value="{{ old('td_hours', 0) }}" min="0" required>
                        @error('td_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="tp_hours" class="form-label">TP (heures)*</label>
                        <input type="number" name="tp_hours" id="tp_hours"
                            class="form-control @error('tp_hours') is-invalid @enderror"
                            value="{{ old('tp_hours', 0) }}" min="0" required>
                        @error('tp_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="autre_hours" class="form-label">Autre (heures)*</label>
                        <input type="number" name="autre_hours" id="autre_hours"
                            class="form-control @error('autre_hours') is-invalid @enderror"
                            value="{{ old('autre_hours', 0) }}" min="0" required>
                        @error('autre_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="alert alert-info py-2 d-flex justify-content-between align-items-center">
                            <small class="fw-bold"><i class="fas fa-calculator me-1"></i>Total heures:</small>
                            <span id="total_hours" class="badge bg-primary rounded-pill">0</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="form-section mb-4">
                <h3 class="section-title h5 mb-3 fw-bold border-bottom pb-2 text-primary">
                    <i class="fas fa-user-tie me-2"></i>Responsable du module*
                </h3>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="responsable_id" class="form-label">Sélectionner un responsable</label>
                        <select name="responsable_id" id="responsable_id"
                            class="form-select @error('responsable_id') is-invalid @enderror">
                            <option value="">Sélectionner un professeur responsable</option>
                            @foreach ($professeurs as $prof)
                                <option value="{{ $prof->id }}"
                                    {{ old('responsable_id') == $prof->id ? 'selected' : '' }}>
                                    {{ $prof->fullname }}
                                </option>
                            @endforeach
                            <option value="vacataire" {{ old('responsable_id') == 'vacataire' ? 'selected' : '' }}>
                                Assigner un vacataire comme responsable
                            </option>
                        </select>
                        @error('responsable_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div id="vacataire_fields" class="vacataire-fields mt-3"
                    style="{{ old('responsable_id') == 'vacataire' ? 'display:block;' : 'display:none;' }}">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="vacataire_nom" class="form-label">Nom complet du vacataire*</label>
                            <input type="text" name="vacataire_nom" id="vacataire_nom"
                                class="form-control @error('vacataire_nom') is-invalid @enderror"
                                value="{{ old('vacataire_nom') }}">
                            @error('vacataire_nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="vacataire_email" class="form-label">Email du vacataire*</label>
                            <input type="email" name="vacataire_email" id="vacataire_email"
                                class="form-control @error('vacataire_email') is-invalid @enderror"
                                value="{{ old('vacataire_email') }}">
                            @error('vacataire_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="vacataire_telephone" class="form-label">Téléphone</label>
                            <input type="tel" name="vacataire_telephone" id="vacataire_telephone"
                                class="form-control @error('vacataire_telephone') is-invalid @enderror"
                                value="{{ old('vacataire_telephone') }}">
                            @error('vacataire_telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="vacataire_specialite" class="form-label">Spécialité</label>
                            <input type="text" name="vacataire_specialite" id="vacataire_specialite"
                                class="form-control @error('vacataire_specialite') is-invalid @enderror"
                                value="{{ old('vacataire_specialite') }}">
                            @error('vacataire_specialite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions d-flex justify-content-between mt-4 pt-3 border-top">
                <a href="{{ route('coordonnateur.modules.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-times-circle me-2"></i>Annuler
                </a>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i>Créer l'UE
                </button>
            </div>
        </form>
    </div>

    <script>
        const typeSelect = document.getElementById('type');
        const parentModuleField = document.getElementById('parent_module_field');
        const responsableSelect = document.getElementById('responsable_id');
        const vacataireFields = document.getElementById('vacataire_fields');

        // Toggle parent module field based on UE type
        function toggleTypeSpecificFields() {
            if (typeSelect.value === 'element') {
                parentModuleField.style.display = 'block';
                document.getElementById('parent_id').required = true;
                vacataireFields.style.display = 'none';
                responsableSelect.value = '';
            } else if (typeSelect.value === 'complet') {
                parentModuleField.style.display = 'none';
                document.getElementById('parent_id').required = false;
            } else {
                parentModuleField.style.display = 'none';
                document.getElementById('parent_id').required = false;
            }
            toggleVacataireFields();
        }

        if (typeSelect) {
            typeSelect.addEventListener('change', toggleTypeSpecificFields);
            toggleTypeSpecificFields();
        }

        // Toggle vacataire fields
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
            toggleVacataireFields();
        }

        // Calculate total hours
        ['cm_hours', 'td_hours', 'tp_hours', 'autre_hours'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', updateTotalHours);
            }
        });

        function updateTotalHours() {
            const cm = parseInt(document.getElementById('cm_hours')?.value) || 0;
            const td = parseInt(document.getElementById('td_hours')?.value) || 0;
            const tp = parseInt(document.getElementById('tp_hours')?.value) || 0;
            const autre = parseInt(document.getElementById('autre_hours')?.value) || 0;

            const total = cm + td + tp + autre;
            const totalHoursElement = document.getElementById('total_hours');
            if (totalHoursElement) {
                totalHoursElement.textContent = total;
            }
        }

        // Initialize total hours calculation
        document.addEventListener('DOMContentLoaded', function() {
            updateTotalHours();
        });
    </script>

    <style>
        .module-form {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .form-header {
            background-color: #4e73df;
            background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            border: none;
            color: white;
            padding: 1.25rem;
            border-radius: 8px 8px 0 0;
        }

        .form-header h4 {
            font-weight: 600;
        }

        .form-header small {
            opacity: 0.9;
        }

        .section-title {
            font-size: 1.1rem;
            color: #4e73df;
            letter-spacing: 0.5px;
        }

        .form-section {
            padding: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
            background-color: #fff;
            border-radius: 6px;
            margin-bottom: 1.25rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .form-label {
            font-size: 0.85rem;
            color: #5a5c69;
            font-weight: 500;
            margin-bottom: 0.35rem;
        }

        .form-control,
        .form-select {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            line-height: 1.5;
            color: #6e707e;
            background-color: #fff;
            border: 1px solid #d1d3e2;
            border-radius: 0.35rem;
            transition: all 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            color: #6e707e;
            background-color: #fff;
            border-color: #bac8f3;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1.5rem;
            border-radius: 0.35rem;
            font-size: 0.85rem;
        }

        .vacataire-fields {
            background-color: #f8f9fc;
            padding: 1.25rem;
            border-radius: 6px;
            border: 1px solid #e3e6f0;
        }

        .form-actions {
            padding: 1.25rem 1.5rem;
            background-color: #f8f9fc;
            border-radius: 0 0 8px 8px;
            border-top: 1px solid #e3e6f0;
        }

        .btn {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            border-radius: 0.35rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #3a5bc7;
            border-color: #3758bd;
        }

        .btn-outline-secondary {
            color: #858796;
            border-color: #d1d3e2;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fc;
            border-color: #bac8f3;
            color: #4e73df;
        }

        .alert-info {
            background-color: #f0f7fd;
            border-color: #d0e3f0;
            color: #3a87ad;
            font-size: 0.85rem;
        }

        .badge {
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        .input-group-text {
            background-color: #f8f9fc;
            color: #6e707e;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .form-section {
                padding: 1rem;
            }

            .form-header {
                padding: 1rem;
            }
        }
    </style>

</x-coordonnateur_layout>

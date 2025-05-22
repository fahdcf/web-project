<x-coordonnateur_layout>
    <div class="container-fluid p-0 pt-4">
        <!-- Alerts -->
        <x-global_alert />

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        <div class="header-container mb-4 mt-3">
            <style>
                .header-container {
                    background: white;
                    border-radius: 8px;
                    padding: 20px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                }

                .header-title {
                    color: #4723d9;
                    font-weight: 600;
                    font-size: 1.75rem;
                    margin: 0;
                }

                .form-select {
                    border-color: #e0e0e0;
                    font-size: 0.9rem;
                    padding: 8px 12px;
                    border-radius: 6px;
                    background-color: #f8f9fa;
                    transition: border-color 0.2s;
                }

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

                .btn-outline-primary {
                    border-color: #4723d9;
                    color: #4723d9;
                    font-size: 0.9rem;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-weight: 500;
                    transition: all 0.2s;
                    /* white-space: nowrap; */
                }

                .btn-outline-primary:hover {
                    background-color: #4723d9;
                    color: white;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .btn-outline-primary:hover .btn-text-prof {
                    color: white;
                }

                .btn-text-emploi,
                .btn-text-prof {
                    display: inline;
                }

                @media (max-width: 768px) {
                    .header-container {
                        padding: 15px;
                    }

                    .header-title {
                        font-size: 1.5rem;
                        margin-bottom: 15px;
                        text-align: center;
                    }

                    .form-select,
                    .btn-outline-primary {
                        width: 100%;
                        margin-bottom: 10px;
                    }

                    .btn-outline-primary {
                        white-space: normal;
                        text-align: center;
                        padding: 10px 16px;
                    }

                }

                /* Improved grid layout */
                .header-grid {
                    display: grid;
                    grid-template-columns: 1fr auto auto;
                    gap: 1rem;
                    align-items: center;
                }

                @media (max-width: 992px) {
                    .header-grid {
                        grid-template-columns: 1fr auto;
                    }

                    .header-title {
                        grid-column: 1 / -1;
                        text-align: center;
                        margin-bottom: 10px;
                        text-decoration: underline;
                    }
                }

                @media (max-width: 768px) {
                    .header-grid {
                        grid-template-columns: 1fr;
                        gap: 0.75rem;
                    }

                    .btn-outline-primary {
                        white-space: normal;
                        text-align: center;
                        padding: 10px 16px;
                        line-height: 1.3;
                        /* Add this for better line spacing */
                    }

                    .btn-text-emploi,
                    .btn-text-prof {
                        display: inline;
                        /* Change from 'block' to 'inline' */
                        margin-bottom: 0;
                        /* Remove bottom margin */
                    }

                    .btn-text-emploi:after {
                        content: " ";
                        /* Add space after "Emploi des" */
                    }

                }
            </style>

            <div class="header-grid mt-">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-book-open fa-2x " style="color: #330bcf;"></i>
                    <h3 style="color: #330bcf; font-weight: 500;"> Modifier l'UE: {{ $module->name }}</h3>

                </div>

                <a href="{{ route('coordonnateur.modules.index') }}"
                class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Reteur
                </a>


            </div>
        </div>


        <!-- Form Card -->
        <div class="card border-0 shadow rounded-4 mb-4" style="box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-body p-4">
                <form action="{{ route('coordonnateur.modules.update', $module->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Informations essentielles -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-primary mb-3" style="color: #4723d9;">
                            <i class="bi bi-info-circle me-2"></i> Informations essentielles
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="type" class="form-label small fw-bold text-muted">Type UE*</label>
                                <select name="type" id="type"
                                    class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="">Sélectionner le type</option>
                                    <option value="complet"
                                        {{ old('type', $module->type) == 'complet' ? 'selected' : '' }}>Complet</option>
                                    <option value="element"
                                        {{ old('type', $module->type) == 'element' ? 'selected' : '' }}>Élément</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label for="name" class="form-label small fw-bold text-muted">Nom complet*</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" required
                                    placeholder="Ex: Programmation Web Avancée"
                                    value="{{ old('name', $module->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="specialty" class="form-label small fw-bold text-muted">Spécialité*</label>
                                <select name="specialty" id="specialty"
                                    class="form-select @error('specialty') is-invalid @enderror" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach (['Informatique Fondamentale', 'Génie Logiciel', 'Systèmes d\'Information', 'Intelligence Artificielle'] as $spec)
                                        <option value="{{ $spec }}"
                                            {{ old('specialty', $module->specialty) == $spec ? 'selected' : '' }}>
                                            {{ $spec }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('specialty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="semester" class="form-label small fw-bold text-muted">Semestre*</label>
                                <select name="semester" id="semester"
                                    class="form-select @error('semester') is-invalid @enderror" required>
                                    @for ($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('semester', $module->semester) == $i ? 'selected' : '' }}>
                                            S{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="credits" class="form-label small fw-bold text-muted">Crédits ECTS*</label>
                                <input type="number" name="credits" id="credits"
                                    class="form-control @error('credits') is-invalid @enderror"
                                    value="{{ old('credits', $module->credits) }}" min="1" max="6"
                                    required>
                                @error('credits')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="evaluation" class="form-label small fw-bold text-muted">Évaluation*</label>
                                <input type="number" name="evaluation" id="evaluation"
                                    class="form-control @error('evaluation') is-invalid @enderror"
                                    value="{{ old('evaluation', $module->evaluation) }}" min="1" max="10"
                                    required>
                                @error('evaluation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Coefficient d'évaluation (1-10)</small>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label small fw-bold text-muted">Description
                                    pédagogique</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="3" placeholder="Objectifs d'apprentissage...">{{ old('description', $module->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Module Parent -->
                    <div id="parent_module_field" class="mb-4"
                        style="{{ old('type', $module->type) == 'element' ? 'display:block;' : 'display:none;' }}">
                        <h5 class="fw-bold text-primary mb-3" style="color: #4723d9;">
                            <i class="bi bi-sitemap me-2"></i> Module Parent
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="parent_id" class="form-label small fw-bold text-muted">Sélectionner un
                                    module parent*</label>
                                <select name="parent_id" id="parent_id"
                                    class="form-select @error('parent_id') is-invalid @enderror">
                                    <option value="">Sélectionner un module parent</option>
                                    @foreach ($parentModules as $parentModule)
                                        <option value="{{ $parentModule->id }}"
                                            {{ old('parent_id', $module->parent_id) == $parentModule->id ? 'selected' : '' }}>
                                            {{ $parentModule->code }} - {{ $parentModule->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="alert alert-info p-2 mb-0 w-100"
                                    style="background-color: #e6e9ff; border-color: #d0e3f0;">
                                    <small><i class="bi bi-info-circle me-1"></i> Si vous souhaitez changer le module
                                        parent, sélectionnez-en un nouveau.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Volume horaire -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-primary mb-3" style="color: #4723d9;">
                            <i class="bi bi-clock me-2"></i> Volume horaire
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="cm_hours" class="form-label small fw-bold text-muted">CM (heures)*</label>
                                <input type="number" name="cm_hours" id="cm_hours"
                                    class="form-control @error('cm_hours') is-invalid @enderror"
                                    value="{{ old('cm_hours', $module->cm_hours) }}" min="0" required>
                                @error('cm_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="td_hours" class="form-label small fw-bold text-muted">TD (heures)*</label>
                                <input type="number" name="td_hours" id="td_hours"
                                    class="form-control @error('td_hours') is-invalid @enderror"
                                    value="{{ old('td_hours', $module->td_hours) }}" min="0" required>
                                @error('td_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="tp_hours" class="form-label small fw-bold text-muted">TP (heures)*</label>
                                <input type="number" name="tp_hours" id="tp_hours"
                                    class="form-control @error('tp_hours') is-invalid @enderror"
                                    value="{{ old('tp_hours', $module->tp_hours) }}" min="0" required>
                                @error('tp_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="autre_hours" class="form-label small fw-bold text-muted">Autre
                                    (heures)*</label>
                                <input type="number" name="autre_hours" id="autre_hours"
                                    class="form-control @error('autre_hours') is-invalid @enderror"
                                    value="{{ old('autre_hours', $module->autre_hours) }}" min="0" required>
                                @error('autre_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="alert alert-info py-2 d-flex justify-content-between align-items-center"
                                    style="background-color: #e6e9ff; border-color: #d0e3f0;">
                                    <small class="fw-bold"><i class="bi bi-calculator me-1"></i> Total heures:</small>
                                    <span id="total_hours" class="badge bg-primary rounded-pill"
                                        style="background-color: #4723d9;">
                                        {{ $module->cm_hours + $module->td_hours + $module->tp_hours + $module->autre_hours }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Responsable et Status -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-primary mb-3" style="color: #4723d9;">
                            <i class="bi bi-person-fill me-2"></i> Responsable du module et Status*
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="responsable_id" class="form-label small fw-bold text-muted">Sélectionner
                                    un responsable</label>
                                <select name="responsable_id" id="responsable_id"
                                    class="form-select @error('responsable_id') is-invalid @enderror">
                                    <option value="">Sélectionner un professeur responsable</option>
                                    @foreach ($professeurs as $prof)
                                        <option value="{{ $prof->id }}"
                                            {{ old('responsable_id', $module->responsable_id) == $prof->id ? 'selected' : '' }}>
                                            {{ $prof->fullname }}
                                        </option>
                                    @endforeach
                                    <option value="vacataire"
                                        {{ old('responsable_id', $module->responsable_id) == 'vacataire' ? 'selected' : '' }}>
                                        Assigner un vacataire comme responsable
                                    </option>
                                </select>
                                @error('responsable_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="status" class="form-label small fw-bold text-muted">Status*</label>
                                <select name="status" id="status"
                                    class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">Sélectionner le status</option>
                                    <option value="active"
                                        {{ old('status', $module->status) == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive"
                                        {{ old('status', $module->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Vacataire Fields -->
                        <div id="vacataire_fields" class="mt-3"
                            style="{{ old('responsable_id', $module->responsable_id) == 'vacataire' ? 'display:block;' : 'display:none;' }}">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="vacataire_nom" class="form-label small fw-bold text-muted">Nom complet
                                        du vacataire*</label>
                                    <input type="text" name="vacataire_nom" id="vacataire_nom"
                                        class="form-control @error('vacataire_nom') is-invalid @enderror"
                                        value="{{ old('vacataire_nom', $module->vacataire_nom) }}">
                                    @error('vacataire_nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="vacataire_email" class="form-label small fw-bold text-muted">Email du
                                        vacataire*</label>
                                    <input type="email" name="vacataire_email" id="vacataire_email"
                                        class="form-control @error('vacataire_email') is-invalid @enderror"
                                        value="{{ old('vacataire_email', $module->vacataire_email) }}">
                                    @error('vacataire_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="vacataire_telephone"
                                        class="form-label small fw-bold text-muted">Téléphone</label>
                                    <input type="tel" name="vacataire_telephone" id="vacataire_telephone"
                                        class="form-control @error('vacataire_telephone') is-invalid @enderror"
                                        value="{{ old('vacataire_telephone', $module->vacataire_telephone) }}">
                                    @error('vacataire_telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="vacataire_specialite"
                                        class="form-label small fw-bold text-muted">Spécialité</label>
                                    <input type="text" name="vacataire_specialite" id="vacataire_specialite"
                                        class="form-control @error('vacataire_specialite') is-invalid @enderror"
                                        value="{{ old('vacataire_specialite', $module->vacataire_specialite) }}">
                                    @error('vacataire_specialite')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a href="{{ route('coordonnateur.modules.index') }}"
                            class="btn btn-outline-secondary rounded fw-semibold px-4">
                            <i class="bi bi-x-circle me-2"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary rounded fw-semibold px-4"
                            style="background-color: #4723d9; border-color: #4723d9;">
                            <i class="bi bi-save me-2"></i> Modifier l'UE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Match emploi.prof styling */
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6e707e;
        }

        .form-control,
        .form-select {
            font-size: 0.9rem;
            border-radius: 6px;
            border: 1px solid #d1d3e2;
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
        }

        .btn-primary:hover {
            background-color: #fff;
            color: #4723d9;
            border-color: #4723d9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-secondary {
            border-color: #d1d3e2;
            color: #6e707e;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-outline-secondary:hover {
            background-color: #4723d9;
            color: #fff;
            border-color: #4723d9;
        }

        .alert-info {
            background-color: #e6e9ff;
            border-color: #d0e3f0;
            color: #3a87ad;
            font-size: 0.85rem;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.25em 0.6em;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }

            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <script>
        const typeSelect = document.getElementById('type');
        const parentModuleField = document.getElementById('parent_module_field');
        const responsableSelect = document.getElementById('responsable_id');
        const vacataireFields = document.getElementById('vacataire_fields');
        const cmHoursInput = document.getElementById('cm_hours');
        const tdHoursInput = document.getElementById('td_hours');
        const tpHoursInput = document.getElementById('tp_hours');
        const autreHoursInput = document.getElementById('autre_hours');
        const totalHoursSpan = document.getElementById('total_hours');

        // Toggle parent module field based on UE type
        function toggleTypeSpecificFields() {
            if (typeSelect.value === 'element') {
                parentModuleField.style.display = 'block';
                document.getElementById('parent_id').required = true;
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
        function updateTotalHours() {
            const cm = parseInt(cmHoursInput?.value) || 0;
            const td = parseInt(tdHoursInput?.value) || 0;
            const tp = parseInt(tpHoursInput?.value) || 0;
            const autre = parseInt(autreHoursInput?.value) || 0;
            const total = cm + td + tp + autre;
            if (totalHoursSpan) {
                totalHoursSpan.textContent = total;
            }
        }

        if (cmHoursInput && tdHoursInput && tpHoursInput && autreHoursInput) {
            cmHoursInput.addEventListener('input', updateTotalHours);
            tdHoursInput.addEventListener('input', updateTotalHours);
            tpHoursInput.addEventListener('input', updateTotalHours);
            autreHoursInput.addEventListener('input', updateTotalHours);
        }

        // Initialize total hours calculation on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateTotalHours();
        });
    </script>
</x-coordonnateur_layout>

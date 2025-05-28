<x-coordonnateur_layout>
    <div class="container-fluid p-0 pt-4">
        <!-- Alerts -->
        <x-global_alert />

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
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
                    <h3 style="color: #330bcf; font-weight: 500;">Modifier: {{ $module->name }}</h3>

                </div>

                <a href="{{ route('coordonnateur.modules.index') }}"
                class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Annuler
                </a>


            </div>
        </div>

        

        <!-- Form Card -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <form action="{{ route('coordonnateur.modules.update', $module->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card-body p-4">
                    <!-- Informations essentielles -->
                    <div class="mb-5">
                        <div class="section-header mb-4">
                            <h5 class="mb-0">Informations essentielles</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="type" class="form-label">Type UE <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-select form-select-lg" required>
                                    <option value="">Sélectionner le type</option>
                                    <option value="complet" {{ old('type', $module->type) == 'complet' ? 'selected' : '' }}>Complet</option>
                                    <option value="element" {{ old('type', $module->type) == 'element' ? 'selected' : '' }}>Élément</option>
                                </select>
                            </div>

                            <div class="col-md-8">
                                <label for="name" class="form-label">Nom complet <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg" 
                                       placeholder="Ex: Programmation Web Avancée" required
                                       value="{{ old('name', $module->name) }}">
                            </div>

                            <div class="col-md-3">
                                <label for="specialty" class="form-label">Spécialité <span class="text-danger">*</span></label>
                                <select name="specialty" id="specialty" class="form-select form-select-lg" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach (['Informatique Fondamentale', 'Génie Logiciel', 'Systèmes d\'Information', 'Intelligence Artificielle'] as $spec)
                                        <option value="{{ $spec }}" {{ old('specialty', $module->specialty) == $spec ? 'selected' : '' }}>
                                            {{ $spec }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="semester" class="form-label">Semestre <span class="text-danger">*</span></label>
                                <select name="semester" id="semester" class="form-select form-select-lg" required>
                                    @for ($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ old('semester', $module->semester) == $i ? 'selected' : '' }}>
                                            S{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="credits" class="form-label">Crédits ECTS <span class="text-danger">*</span></label>
                                <input type="number" name="credits" id="credits" class="form-control form-control-lg"
                                       value="{{ old('credits', $module->credits) }}" min="1" max="6" required>
                            </div>

                            <div class="col-md-3">
                                <label for="evaluation" class="form-label">Évaluation <span class="text-danger">*</span></label>
                                <input type="number" name="evaluation" id="evaluation" class="form-control form-control-lg"
                                       value="{{ old('evaluation', $module->evaluation) }}" min="1" max="10" required>
                                <small class="text-muted">Coefficient d'évaluation (1-10)</small>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description pédagogique</label>
                                <textarea name="description" id="description" class="form-control" rows="3" 
                                          placeholder="Objectifs d'apprentissage...">{{ old('description', $module->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Module Parent -->
                    <div id="parent_module_field" class="mb-5" style="{{ old('type', $module->type) == 'element' ? 'display:block;' : 'display:none;' }}">
                        <div class="section-header mb-4">
                            <h5 class="mb-0">Module Parent</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="parent_id" class="form-label">Sélectionner un module parent <span class="text-danger">*</span></label>
                                <select name="parent_id" id="parent_id" class="form-select form-select-lg">
                                    <option value="">Sélectionner un module parent</option>
                                    @foreach ($parentModules as $parentModule)
                                        <option value="{{ $parentModule->id }}" {{ old('parent_id', $module->parent_id) == $parentModule->id ? 'selected' : '' }}>
                                            {{ $parentModule->code }} - {{ $parentModule->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-light d-flex align-items-center h-100">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    <small class="mb-0">Si vous souhaitez changer le module parent, sélectionnez-en un nouveau.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Volume horaire -->
                    <div class="mb-5">
                        <div class="section-header mb-4">
                            <h5 class="mb-0">Volume horaire</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="cm_hours" class="form-label">CM (heures) <span class="text-danger">*</span></label>
                                <input type="number" name="cm_hours" id="cm_hours" class="form-control form-control-lg"
                                       value="{{ old('cm_hours', $module->cm_hours) }}" min="0" required>
                            </div>

                            <div class="col-md-3">
                                <label for="td_hours" class="form-label">TD (heures) <span class="text-danger">*</span></label>
                                <input type="number" name="td_hours" id="td_hours" class="form-control form-control-lg"
                                       value="{{ old('td_hours', $module->td_hours) }}" min="0" required>
                            </div>

                            <div class="col-md-3">
                                <label for="tp_hours" class="form-label">TP (heures) <span class="text-danger">*</span></label>
                                <input type="number" name="tp_hours" id="tp_hours" class="form-control form-control-lg"
                                       value="{{ old('tp_hours', $module->tp_hours) }}" min="0" required>
                            </div>

                            <div class="col-md-3">
                                <label for="autre_hours" class="form-label">Autre (heures) <span class="text-danger">*</span></label>
                                <input type="number" name="autre_hours" id="autre_hours" class="form-control form-control-lg"
                                       value="{{ old('autre_hours', $module->autre_hours) }}" min="0" required>
                            </div>

                            <div class="col-12">
                                <div class="alert alert-primary py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-calculator me-2"></i>
                                            <strong>Total heures:</strong>
                                        </div>
                                        <span id="total_hours" class="badge bg-white text-primary rounded-pill fs-6 px-3 py-2">
                                            {{ $module->cm_hours + $module->td_hours + $module->tp_hours + $module->autre_hours }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Responsable et Status -->
                    <div class="mb-4">
                        <div class="section-header mb-4">
                            <h5 class="mb-0">Responsable du module et Status</h5>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="responsable_id" class="form-label">Sélectionner un responsable <span class="text-danger">*</span></label>
                                <select name="responsable_id" id="responsable_id" class="form-select form-select-lg">
                                    <option value="">Sélectionner un professeur responsable</option>
                                    @foreach ($professeurs as $prof)
                                        <option value="{{ $prof->id }}" {{ old('responsable_id', $module->responsable_id) == $prof->id ? 'selected' : '' }}>
                                            {{ $prof->fullname }}
                                        </option>
                                    @endforeach
                                    <option value="vacataire" {{ old('responsable_id', $module->responsable_id) == 'vacataire' ? 'selected' : '' }}>
                                        Assigner un vacataire comme responsable
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select form-select-lg" required>
                                    <option value="">Sélectionner le status</option>
                                    <option value="active" {{ old('status', $module->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $module->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Vacataire Fields -->
                        <div id="vacataire_fields" class="mt-4" style="{{ old('responsable_id', $module->responsable_id) == 'vacataire' ? 'display:block;' : 'display:none;' }}">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="vacataire_nom" class="form-label">Nom complet du vacataire <span class="text-danger">*</span></label>
                                    <input type="text" name="vacataire_nom" id="vacataire_nom" class="form-control form-control-lg"
                                           value="{{ old('vacataire_nom', $module->vacataire_nom) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="vacataire_email" class="form-label">Email du vacataire <span class="text-danger">*</span></label>
                                    <input type="email" name="vacataire_email" id="vacataire_email" class="form-control form-control-lg"
                                           value="{{ old('vacataire_email', $module->vacataire_email) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="vacataire_telephone" class="form-label">Téléphone</label>
                                    <input type="tel" name="vacataire_telephone" id="vacataire_telephone" class="form-control form-control-lg"
                                           value="{{ old('vacataire_telephone', $module->vacataire_telephone) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="vacataire_specialite" class="form-label">Spécialité</label>
                                    <input type="text" name="vacataire_specialite" id="vacataire_specialite" class="form-control form-control-lg"
                                           value="{{ old('vacataire_specialite', $module->vacataire_specialite) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="card-footer bg-light p-4 border-top">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('coordonnateur.modules.index') }}" class="btn btn-lg btn-outline-secondary">
                            <i class="fas fa-times me-2"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-lg btn-primary">
                            <i class="fas fa-save me-2"></i> Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Base Styles */
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        /* Form Elements */
        .form-label {
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-control-lg, .form-select-lg {
            padding: 0.875rem 1.25rem;
            font-size: 1rem;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s;
        }

        .btn-lg {
            padding: 0.875rem 1.75rem;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        .btn-primary:hover {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .btn-outline-secondary {
            border-color: #e2e8f0;
            color: #4a5568;
        }

        .btn-outline-secondary:hover {
            background-color: #f1f5f9;
            color: #4a5568;
        }

        /* Section Headers */
        .section-header {
            display: flex;
            align-items: center;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 1.5rem;
        }

        .section-header i {
            color: #6366f1;
            font-size: 1.25rem;
        }

        .section-header h5 {
            font-weight: 600;
            color: #2d3748;
            margin: 0;
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            padding: 1rem 1.25rem;
        }

        .alert-light {
            background-color: #f8fafc;
            border-color: #f1f5f9;
        }

        .alert-primary {
            background-color: #eef2ff;
            border-color: #e0e7ff;
            color: #4338ca;
        }

        /* Badges */
        .badge {
            font-weight: 600;
            padding: 0.5em 1em;
        }

        /* Icon Circle */
        .icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        /* Required Field Indicator */
        .text-danger {
            color: #ef4444;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 0.75rem;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
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

            // Event Listeners
            if (typeSelect) {
                typeSelect.addEventListener('change', toggleTypeSpecificFields);
                toggleTypeSpecificFields();
            }

            if (responsableSelect) {
                responsableSelect.addEventListener('change', toggleVacataireFields);
                toggleVacataireFields();
            }

            if (cmHoursInput && tdHoursInput && tpHoursInput && autreHoursInput) {
                cmHoursInput.addEventListener('input', updateTotalHours);
                tdHoursInput.addEventListener('input', updateTotalHours);
                tpHoursInput.addEventListener('input', updateTotalHours);
                autreHoursInput.addEventListener('input', updateTotalHours);
            }

            // Initialize
            updateTotalHours();
        });
    </script>
</x-coordonnateur_layout>
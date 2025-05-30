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

        <!-- Header Section -->
        <div class="header-container mb-4 mt-3">
            <style>
                .header-container {
                    background: white;
                    border-radius: 12px;
                    padding: 24px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                    border: 1px solid #e9ecef;
                }

                .header-title {
                    color: #4723d9;
                    font-weight: 600;
                    font-size: 1.75rem;
                    margin: 0;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                }

                .header-title i {
                    font-size: 1.5rem;
                }

                .header-actions {
                    display: flex;
                    gap: 12px;
                    align-items: center;
                }

                @media (max-width: 768px) {
                    .header-container {
                        padding: 16px;
                    }
                    
                    .header-title {
                        font-size: 1.5rem;
                        flex-direction: column;
                        align-items: flex-start;
                        gap: 8px;
                    }
                    
                    .header-actions {
                        flex-direction: column;
                        width: 100%;
                        gap: 8px;
                    }
                }
            </style>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-book-open fa-lg" style="color: #4723d9;"></i>
                    <h1 class="header-title">Modifier: {{ $module->name }}</h1>
                </div>

                <div class="header-actions">
                    <a href="{{ route('coordonnateur.modules.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-5">
            <form action="{{ route('coordonnateur.modules.update', $module->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card-body p-4">
                    <!-- Informations essentielles -->
                    <div class="mb-5">
                        <div class="section-header mb-4">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            <h5 class="mb-0">Informations essentielles</h5>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label for="type" class="form-label">Type UE <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-select" required>
                                    <option value="">Sélectionner le type</option>
                                    <option value="complet" {{ old('type', $module->type) == 'complet' ? 'selected' : '' }}>Complet</option>
                                    <option value="element" {{ old('type', $module->type) == 'element' ? 'selected' : '' }}>Élément</option>
                                </select>
                            </div>

                            <div class="col-md-8">
                                <label for="name" class="form-label">Nom complet <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" 
                                       placeholder="Ex: Programmation Web Avancée" required
                                       value="{{ old('name', $module->name) }}">
                            </div>

                            <div class="col-md-3">
                                <label for="specialty" class="form-label">Spécialité <span class="text-danger">*</span></label>
                                <select name="specialty" id="specialty" class="form-select" required>
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
                                <select name="semester" id="semester" class="form-select" required>
                                    @for ($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ old('semester', $module->semester) == $i ? 'selected' : '' }}>
                                            S{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="credits" class="form-label">Crédits ECTS <span class="text-danger">*</span></label>
                                <input type="number" name="credits" id="credits" class="form-control"
                                       value="{{ old('credits', $module->credits) }}" min="1" max="6" required>
                            </div>

                            <div class="col-md-3">
                                <label for="evaluation" class="form-label">Évaluation <span class="text-danger">*</span></label>
                                <input type="number" name="evaluation" id="evaluation" class="form-control"
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
                            <i class="fas fa-sitemap me-2 text-primary"></i>
                            <h5 class="mb-0">Module Parent</h5>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="parent_id" class="form-label">Sélectionner un module parent <span class="text-danger">*</span></label>
                                <select name="parent_id" id="parent_id" class="form-select">
                                    <option value="">Sélectionner un module parent</option>
                                    @foreach ($parentModules as $parentModule)
                                        <option value="{{ $parentModule->id }}" {{ old('parent_id', $module->parent_id) == $parentModule->id ? 'selected' : '' }}>
                                            {{ $parentModule->code }} - {{ $parentModule->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-light d-flex align-items-center h-100 mb-0">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    <small class="mb-0">Si vous souhaitez changer le module parent, sélectionnez-en un nouveau.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Volume horaire -->
                    <div class="mb-5">
                        <div class="section-header mb-4">
                            <i class="fas fa-clock me-2 text-primary"></i>
                            <h5 class="mb-0">Volume horaire</h5>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-3">
                                <label for="cm_hours" class="form-label">CM (heures) <span class="text-danger">*</span></label>
                                <input type="number" name="cm_hours" id="cm_hours" class="form-control"
                                       value="{{ old('cm_hours', $module->cm_hours) }}" min="0" required>
                            </div>

                            <div class="col-md-3">
                                <label for="td_hours" class="form-label">TD (heures) <span class="text-danger">*</span></label>
                                <input type="number" name="td_hours" id="td_hours" class="form-control"
                                       value="{{ old('td_hours', $module->td_hours) }}" min="0" required>
                            </div>

                            <div class="col-md-3">
                                <label for="tp_hours" class="form-label">TP (heures) <span class="text-danger">*</span></label>
                                <input type="number" name="tp_hours" id="tp_hours" class="form-control"
                                       value="{{ old('tp_hours', $module->tp_hours) }}" min="0" required>
                            </div>

                            <div class="col-md-3">
                                <label for="autre_hours" class="form-label">Autre (heures) <span class="text-danger">*</span></label>
                                <input type="number" name="autre_hours" id="autre_hours" class="form-control"
                                       value="{{ old('autre_hours', $module->autre_hours) }}" min="0" required>
                            </div>

                            <div class="col-12">
                                <div class="alert alert-primary py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
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
                            <i class="fas fa-user-tie me-2 text-primary"></i>
                            <h5 class="mb-0">Responsable du module et Status</h5>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="responsable_id" class="form-label">Sélectionner un responsable <span class="text-danger">*</span></label>
                                <select name="responsable_id" id="responsable_id" class="form-select">
                                    <option value="">Sélectionner un professeur responsable</option>
                                    @foreach ($professeurs as $prof)
                                        <option value="{{ $prof->id }}" {{ old('responsable_id', $module->responsable_id) == $prof->id ? 'selected' : '' }}>
                                            {{ $prof->fullname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="">Sélectionner le status</option>
                                    <option value="active" {{ old('status', $module->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $module->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="card-footer bg-light p-4 border-top">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <a href="{{ route('coordonnateur.modules.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i> Annuler
                        </a>

                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                            <i class="fas fa-save me-2"></i> Modifier l'UE
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Base Styles */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8f9fa;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        /* Form Elements */
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.625rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s;
            background-color: #fff;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4723d9;
            box-shadow: 0 0 0 3px rgba(71, 35, 217, 0.1);
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.625rem 1.25rem;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: #4723d9;
            border-color: #4723d9;
        }

        .btn-primary:hover {
            background-color: #3a1cb8;
            border-color: #3a1cb8;
        }

        .btn-outline-secondary {
            border-color: #dee2e6;
            color: #495057;
        }

        .btn-outline-secondary:hover {
            background-color: #f1f3f5;
        }

        /* Section Headers */
        .section-header {
            display: flex;
            align-items: center;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 1.5rem;
        }

        .section-header i {
            font-size: 1.1rem;
            margin-right: 0.75rem;
        }

        .section-header h5 {
            font-weight: 600;
            color: #343a40;
            margin: 0;
            font-size: 1.1rem;
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            padding: 1rem;
        }

        .alert-light {
            background-color: #f8f9fa;
            border-color: #e9ecef;
        }

        .alert-primary {
            background-color: #f0f3ff;
            border-color: #d9e0ff;
            color: #343a40;
        }

        /* Badges */
        .badge {
            font-weight: 600;
            padding: 0.35em 0.75em;
        }

        /* Required Field Indicator */
        .text-danger {
            color: #dc3545;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .row.g-4 > [class^="col-"] {
                margin-bottom: 1rem;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const typeSelect = document.getElementById('type');
            const parentModuleField = document.getElementById('parent_module_field');
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

            if (cmHoursInput && tdHoursInput && tpHoursInput && autreHoursInput) {
                [cmHoursInput, tdHoursInput, tpHoursInput, autreHoursInput].forEach(input => {
                    input.addEventListener('input', updateTotalHours);
                });
            }

            // Initialize
            updateTotalHours();
        });
    </script>
</x-coordonnateur_layout>
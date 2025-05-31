<x-coordonnateur_layout>
    <div class="container-fluid px-4 py-5">
        <!-- Header Section -->
        <div class="header-container mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-container bg-primary-light rounded-circle p-3">
                    <i class="fas fa-book-open fa-lg" style="color: #4723d9;"></i>
                </div>
                <div>
                    <h3 class="mb-0" style="color: #4723d9; font-weight: 500;">Créer une Nouvelle Unité d'Enseignement
                    </h3>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('coordonnateur.modules.store') }}" method="POST"
            class="module-form bg-white rounded-3 shadow">
            @csrf

            <!-- Form Header -->
            <div class="form-header p-3 text-white rounded-top">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div class="context-info">
                        <h4 class="mb-0"><i class="fas fa-book me-2"></i>Filière:
                            {{ $filiere->name ?? 'Non définie' }}</h4>
                    </div>
                    <div class="form-progress">
                        <div class="progress" style="height: 8px; width: 150px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%;"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-white-75">Étape 1 sur 4</small>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger m-3 rounded-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <div>
                            <strong>Veuillez corriger les erreurs suivantes :</strong>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Steps Navigation -->
            <div class="form-steps-nav bg-light border-bottom">
                <div class="step active" data-step="1">
                    <span class="step-number">1</span>
                    <span class="step-title">Informations de base</span>
                </div>
                <div class="step" data-step="2">
                    <span class="step-number">2</span>
                    <span class="step-title">Structure</span>
                </div>
                <div class="step" data-step="3">
                    <span class="step-number">3</span>
                    <span class="step-title">Volume horaire</span>
                </div>
                <div class="step" data-step="4">
                    <span class="step-number">4</span>
                    <span class="step-title">Responsable</span>
                </div>
            </div>

            <!-- Step 1: Essential Information -->
            <div class="form-step active" id="step-1">
                <div class="form-section p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="type" class="form-label">Type d'UE*</label>
                            <select name="type" id="type"
                                class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Sélectionner le type</option>
                                <option value="complet" {{ old('type') == 'complet' ? 'selected' : '' }}>Module complet
                                </option>
                                <option value="element" {{ old('type') == 'element' ? 'selected' : '' }}>Élément de
                                    module</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nom complet*</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Ex: Programmation Web Avancée" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="specialty" class="form-label">Spécialité*</label>
                            <select name="specialty" id="specialty"
                                class="form-select @error('specialty') is-invalid @enderror" required>
                                <option value="">Sélectionner...</option>
                                @foreach (['Informatique Fondamentale', 'Génie Logiciel', 'Systèmes d\'Information', 'Intelligence Artificielle'] as $spec)
                                    <option value="{{ $spec }}"
                                        {{ old('specialty') == $spec ? 'selected' : '' }}>
                                        {{ $spec }}
                                    </option>
                                @endforeach
                            </select>
                            @error('specialty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="semester" class="form-label">Semestre*</label>
                            <select name="semester" id="semester"
                                class="form-select @error('semester') is-invalid @enderror" required>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>
                                        S{{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="credits" class="form-label">Crédits ECTS*</label>
                            <input type="number" name="credits" id="credits"
                                class="form-control @error('credits') is-invalid @enderror"
                                value="{{ old('credits', 3) }}" min="1" max="6" required>
                            @error('credits')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="evaluation" class="form-label">Coefficient*</label>
                            <input type="number" name="evaluation" id="evaluation"
                                class="form-control @error('evaluation') is-invalid @enderror"
                                value="{{ old('evaluation', 1) }}" min="1" max="10" required>
                            <small class="text-muted">Coefficient d'évaluation (1-10)</small>
                            @error('evaluation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description pédagogique</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                rows="4" placeholder="Objectifs d'apprentissage...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-actions p-3 border-top bg-light rounded-bottom d-flex justify-content-end gap-2">
                    <button type="button" class="view-btn rounded-pill px-4" disabled>
                        <i class="fas fa-chevron-left me-2"></i>Précédent
                    </button>
                    <button type="button" class="btn-primary rounded-pill px-4 next-step" data-next="2">
                        Suivant <i class="fas fa-chevron-right ms-2"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Module Structure -->
            <div class="form-step" id="step-2">
                <div class="form-section p-4">
                    <div id="parent_module_field"
                        style="{{ old('type') == 'element' ? 'display:block;' : 'display:none;' }}">
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label for="parent_id" class="form-label">Module parent</label>
                                <div class="input-group">
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

                                </div>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="alert alert-info mt-3 rounded-3">
                            <i class="bi bi-info-circle me-2"></i>
                            Un élément de module doit être associé à un module parent.
                            <br>
                            NB:Si le module parent n'est pas encore créé, créez-le d'abord, puis ajoutez ses éléments.
                        </div>

                    </div>
                    <div id="independent_module_info"
                        style="{{ old('type') != 'element' ? 'display:block;' : 'display:none;' }}">
                        <div class="alert alert-success mt-3 rounded-3">
                            <i class="bi bi-check-circle me-2"></i>
                            Ce module sera créé comme une unité d'enseignement indépendante.
                        </div>
                    </div>
                </div>
                <div class="form-actions p-3 border-top bg-light rounded-bottom d-flex justify-content-end gap-2">
                    <button type="button" class="view-btn rounded-pill px-4 prev-step" data-prev="1">
                        <i class="fas fa-chevron-left me-2"></i>Précédent
                    </button>
                    <button type="button" class="btn-primary rounded-pill px-4 next-step" data-next="3">
                        Suivant <i class="fas fa-chevron-right ms-2"></i>
                    </button>
                </div>
            </div>

            <!-- Step 3: Volume Horaire -->
            <div class="form-step" id="step-3">
                <div class="form-section p-4">
                    <div class="row g-4">
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
                            <div class="d-flex justify-content-between align-items-center rounded-3 p-3 bg-light">
                                <span class="fw-bold"><i class="bi bi-calculator me-1"></i>Total heures:</span>
                                <span id="total_hours" class="badge bg-primary fs-6 px-3 py-2">0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions p-3 border-top bg-light rounded-bottom d-flex justify-content-end gap-2">
                    <button type="button" class="view-btn rounded-pill px-4 prev-step" data-prev="2">
                        <i class="fas fa-chevron-left me-2"></i>Précédent
                    </button>
                    <button type="button" class="btn-primary rounded-pill px-4 next-step" data-next="4">
                        Suivant <i class="fas fa-chevron-right ms-2"></i>
                    </button>
                </div>
            </div>

            <!-- Step 4: Responsable -->
            <div class="form-step" id="step-4">
                <div class="form-section p-4">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label for="responsable_id" class="form-label">Responsable du module</label>
                            <select name="responsable_id" id="responsable_id"
                                class="form-select @error('responsable_id') is-invalid @enderror">
                                <option value="">Sélectionner un professeur responsable</option>
                                <option value="vacataire"
                                    {{ old('responsable_id') == 'vacataire' ? 'selected' : '' }}>
                                    Vacataire (Saisir manuellement)
                                </option>
                                @foreach ($professeurs as $prof)
                                    <option value="{{ $prof->id }}"
                                        {{ old('responsable_id') == $prof->id ? 'selected' : '' }}>
                                        {{ $prof->fullname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('responsable_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="alert alert-warning mt-3 rounded-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Le responsable aura accès à toutes les fonctionnalités de gestion.
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-actions p-3 border-top bg-light rounded-bottom d-flex justify-content-end gap-2">
                    <button type="button" class="view-btn rounded-pill px-4 prev-step" data-prev="3">
                        <i class="fas fa-chevron-left me-2"></i>Précédent
                    </button>
                    <button type="submit" class="btn-primary rounded-pill px-4">
                        <i class="bi bi-save me-2"></i>Créer
                    </button>
                </div>
            </div>
        </form>

        <!-- Styles -->
        <style>
            :root {
                --primary: #4723d9;
                --secondary: #6c757d;
                --success: #28a745;
                --light: #f8f9fa;
                --border: #e0e0e0;
            }

            .header-container {
                background: white;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .icon-container {
                width: 48px;
                height: 48px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(71, 35, 217, 0.1);
            }

            .breadcrumb {
                font-size: 0.85rem;
                background: transparent;
            }

            .module-form {
                border: 1px solid var(--border);
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            }

            .form-header {
                background: var(--primary);
                border-bottom: 2px solid var(--border);
            }

            .form-progress .progress {
                background: rgba(255, 255, 255, 0.3);
                border-radius: 4px;
            }

            .form-steps-nav {
                display: flex;
                border-bottom: 1px solid var(--border);
            }

            .step {
                flex: 1;
                text-align: center;
                padding: 1rem;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .step.active {
                background: var(--light);
            }

            .step.active .step-number {
                background: var(--primary);
                color: white;
            }

            .step.active .step-title {
                color: var(--primary);
                font-weight: 600;
            }

            .step-number {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 24px;
                height: 24px;
                border-radius: 50%;
                background: var(--border);
                color: var(--secondary);
                font-size: 0.9rem;
                margin-right: 0.5rem;
            }

            .step-title {
                font-size: 0.9rem;
                color: var(--secondary);
            }

            .form-step {
                display: none;
            }

            .form-step.active {
                display: block;
            }

            .form-section {
                background: white;
                border-bottom: 1px solid var(--border);
                padding: 2rem;
            }

            .section-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--primary);
                display: flex;
                align-items: center;
            }

            .form-label {
                font-size: 0.9rem;
                font-weight: 600;
                color: #495057;
                margin-bottom: 0.5rem;
            }

            .form-control,
            .form-select {
                border: 2px solid var(--border);
                border-radius: 8px;
                font-size: 1rem;
                padding: 0.75rem;
                color: #333;
                transition: all 0.3s ease;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(71, 139, 217, 0.2);
            }

            .form-control.is-invalid,
            .form-select.is-invalid {
                border-color: #dc3545;
            }

            .invalid-feedback {
                font-size: 0.85rem;
            }

            .alert {
                font-size: 0.9rem;
                padding: 1rem;
                border-radius: 8px;
            }

            .alert-danger {
                background: #f8d7da;
                border: none;
                color: #721c24;
            }

            .alert-info {
                background: #e6f7fa;
                border: none;
                color: #0c5460;
            }

            .alert-success {
                background: #d4edda;
                border: none;
                color: #155724;
            }

            .alert-warning {
                background: #fff3cd;
                border: none;
                color: #856404;
            }

            .btn-primary {
                background: var(--primary);
                border: none;
                font-weight: 600;
                padding: 0.75rem 1.5rem;
                border-radius: 8px;
                color: white;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background: #3b1eb0;
            }

            .view-btn {
                border: 2px solid var(--secondary);
                color: var(--secondary);
                font-weight: 600;
                padding: 0.75rem 1.5rem;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .view-btn:hover {
                background: var(--light);
                border-color: var(--primary);
                color: var(--primary);
            }

            .view-btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            .badge {
                font-size: 1rem;
                font-weight: 600;
                padding: 0.5rem 1rem;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .input-group .btn {
                border: 2px solid var(--border);
                border-left: none;
                border-radius: 0 8px 8px 0;
                padding: 0.75rem;
            }

            .card {
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .form-actions {
                background: var(--light);
                padding: 1.5rem;
                border-top: 1px solid var(--border);
            }

            @media (max-width: 768px) {
                .form-steps-nav {
                    flex-direction: column;
                }

                .step {
                    text-align: left;
                    padding: 0.75rem 1rem;
                }

                .form-section {
                    padding: 1.5rem;
                }

                .form-header {
                    padding: 1rem;
                }

                .form-actions {
                    flex-direction: column;
                    gap: 1rem;
                }

                .btn {
                    width: 100%;
                    text-align: center;
                }

                .row.g-4 {
                    flex-direction: column;
                }

                .col-md-2,
                .col-md-3,
                .col-md-4,
                .col-md-6,
                .col-md-8 {
                    width: 100%;
                }
            }
        </style>

        <!-- JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Step Navigation
                const steps = document.querySelectorAll('.form-step');
                const stepNavs = document.querySelectorAll('.step');

                // Initialize first step
                showStep(1);
                updateProgress(1);

                // Next step buttons
                document.querySelectorAll('.next-step').forEach(button => {
                    button.addEventListener('click', function() {
                        const currentStep = this.closest('.form-step').id.split('-')[1];
                        const nextStep = this.dataset.next;

                        if (validateStep(currentStep)) {
                            showStep(nextStep);
                            updateProgress(nextStep);
                        }
                    });
                });

                // Previous step buttons
                document.querySelectorAll('.prev-step').forEach(button => {
                    button.addEventListener('click', function() {
                        const prevStep = this.dataset.prev;
                        showStep(prevStep);
                        updateProgress(prevStep);
                    });
                });

                // Step navigation clicks
                stepNavs.forEach(nav => {
                    nav.addEventListener('click', function() {
                        const step = this.dataset.step;
                        const currentStep = document.querySelector('.form-step.active').id.split('-')[
                            1];
                        if (validateStep(currentStep) || step < currentStep) {
                            showStep(step);
                            updateProgress(step);
                        }
                    });
                });

                function showStep(stepNumber) {
                    steps.forEach(step => step.classList.remove('active'));
                    document.getElementById(`step-${stepNumber}`).classList.add('active');
                }

                function updateProgress(currentStep) {
                    stepNavs.forEach(nav => nav.classList.remove('active'));
                    document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');

                    const progress = (currentStep / 4) * 100;
                    const progressBar = document.querySelector('.progress-bar');
                    progressBar.style.width = `${progress}%`;
                    progressBar.style.transition = 'width 0.3s ease';
                    document.querySelector('.form-progress small').textContent = `Étape ${currentStep} sur 4`;
                }

                function validateStep(stepNumber) {
                    let isValid = true;
                    const step = document.getElementById(`step-${stepNumber}`);
                    const requiredFields = step.querySelectorAll('[required]');
                    requiredFields.forEach(field => {
                        if (!field.value) {
                            field.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            field.classList.remove('is-invalid');
                            field.classList.add('is-valid');
                        }
                    });

                    if (stepNumber == 2 && document.getElementById('type').value === 'element') {
                        const parentId = document.getElementById('parent_id');
                        if (!parentId.value) {
                            parentId.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            parentId.classList.remove('is-invalid');
                            parentId.classList.add('is-valid');
                        }
                    }

                    if (!isValid) {
                        const firstInvalid = step.querySelector('.is-invalid');
                        firstInvalid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        const errorAlert = document.createElement('div');
                        errorAlert.className = 'alert alert-danger m-3 rounded-3';
                        errorAlert.innerHTML = `
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>Veuillez remplir tous les champs obligatoires.</div>
                            </div>
                        `;

                        const existingAlert = step.querySelector('.alert-danger');
                        if (!existingAlert) {
                            step.insertBefore(errorAlert, step.querySelector('.form-section'));
                        }
                    }

                    return isValid;
                }

                // Toggle parent module field
                const typeSelect = document.getElementById('type');
                if (typeSelect) {
                    typeSelect.addEventListener('change', function() {
                        if (this.value === 'element') {
                            document.getElementById('parent_module_field').style.display = 'block';
                            document.getElementById('independent_module_info').style.display = 'none';
                            document.getElementById('parent_id').required = true;
                        } else {
                            document.getElementById('parent_module_field').style.display = 'none';
                            document.getElementById('independent_module_info').style.display = 'block';
                            document.getElementById('parent_id').required = false;
                        }
                    });
                }

                // Toggle vacataire fields
                const responsableSelect = document.getElementById('responsable_id');
                const vacataireFields = document.getElementById('vacataire_fields');
                if (responsableSelect) {
                    responsableSelect.addEventListener('change', function() {
                        if (this.value === 'vacataire') {
                            vacataireFields.style.display = 'block';
                            document.getElementById('vacataire_nom').required = true;
                            document.getElementById('vacataire_email').required = true;
                        } else {
                            vacataireFields.style.display = 'none';
                            document.getElementById('vacataire_nom').required = false;
                            document.getElementById('vacataire_email').required = false;
                        }

                        const selectedOption = this.options[this.selectedIndex];
                        if (selectedOption.value && selectedOption.value !== 'vacataire') {
                            document.getElementById('selected-prof-name').textContent = selectedOption.text;
                            document.getElementById('selected-prof-email').textContent =
                                'email@example.com'; // Mock
                        } else {
                            document.getElementById('selected-prof-name').textContent = 'Aucun sélectionné';
                            document.getElementById('selected-prof-email').textContent = '-';
                        }
                    });
                }

                // Update total hours
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
                        totalHoursElement.style.transform = 'scale(1.1)';
                        setTimeout(() => totalHoursElement.style.transform = 'scale(1)', 200);
                    }
                }

                // Initialize
                updateTotalHours();
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
            });
        </script>
    </div>
</x-coordonnateur_layout>

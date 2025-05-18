<x-coordonnateur_layout>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --card-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
            border: none;
            padding: 0.75rem 1.5rem;
            position: relative;
            margin-right: 0.5rem;
        }

        .nav-tabs .nav-link:before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        .nav-tabs .nav-link:hover:before {
            width: 100%;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: transparent;
            font-weight: 600;
            border: none;
        }

        .nav-tabs .nav-link.active:before {
            width: 100%;
        }

        .form-select,
        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        .select2-container .select2-selection--single {
            height: 48px;
            padding-top: 8px;
            border-radius: 8px;
            border: 1px solid #ced4da;
        }

        .form-text {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            font-size: 0.85rem;
            color: #dc3545;
            margin-top: 0.25rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .card-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--success-color);
        }

        .file-upload-container {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 1rem;
        }

        .file-upload-container:hover {
            border-color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.05);
        }

        .file-upload-container.dragover {
            border-color: var(--success-color);
            background-color: rgba(76, 201, 240, 0.1);
        }

        .file-upload-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .file-info {
            display: none;
            margin-top: 1rem;
            padding: 0.75rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid var(--primary-color);
        }

        .template-download {
            display: inline-block;
            margin-top: 1rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .template-download:hover {
            text-decoration: underline;
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: var(--card-shadow);
        }

        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }

        .modal-title {
            color: var(--primary-color);
            font-weight: 600;
        }

        .modal-footer {
            border-top: none;
        }

        .progress {
            height: 8px;
            border-radius: 4px;
            margin-top: 1rem;
        }

        .progress-bar {
            background-color: var(--primary-color);
        }
    </style>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-semibold mb-0" style="color: var(--primary-color);">Gestion des Notes</h2>
            <div>
                <a href="#" class="btn btn-outline-primary me-2">
                    <i class="fas fa-history me-2"></i>Historique des Uploads
                </a>
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>Télécharger le Modèle
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <ul class="nav nav-tabs mb-4" id="noteTabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="normale-tab" data-bs-toggle="tab" href="#normale">
                            <i class="fas fa-calendar-check me-2"></i>Session Normale
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rattrapage-tab" data-bs-toggle="tab" href="#rattrapage">
                            <i class="fas fa-redo me-2"></i>Session Rattrapage
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Normale -->
                    <div class="tab-pane fade show active" id="normale">
                        <div class="card border-0">
                            <div class="card-body p-4">
                                <h5 class="card-title">Upload des Notes - Session Normale</h5>
                                <form id="uploadFormNormale" enctype="multipart/form-data">
                                    <input type="hidden" name="session_type" value="normale">

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="module_id_normale" class="form-label">Module</label>
                                            <select class="form-select select2" id="module_id_normale" name="module_id" required>
                                                <option value="" disabled selected>Sélectionner un module</option>
                                                <option value="6">Développement Web</option>
                                            </select>
                                            <div id="module_id_normale-error" class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="semester_normale" class="form-label">Semestre</label>
                                            <select class="form-select" id="semester_normale" name="semester" required>
                                                <option value="" disabled selected>Sélectionner un semestre</option>
                                                <option value="S1">Semestre 1</option>
                                                <option value="S2">Semestre 2</option>
                                                <option value="S3">Semestre 3</option>
                                                <option value="S4">Semestre 4</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div id="fileUploadNormale" class="file-upload-container">
                                            <div class="file-upload-icon">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <h5>Glissez-déposez votre fichier ici</h5>
                                            <p class="text-muted">ou</p>
                                            <button type="button" class="btn btn-outline-primary">
                                                <i class="fas fa-folder-open me-2"></i>Parcourir les fichiers
                                            </button>
                                            <input type="file" id="file_normale" name="file" accept=".xlsx" class="d-none" required>
                                            <div class="form-text mt-3">Formats supportés: .xlsx (Excel)</div>
                                        </div>
                                        <div id="fileInfoNormale" class="file-info">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-file-excel text-success me-2"></i>
                                                    <span id="fileNameNormale"></span>
                                                    <span id="fileSizeNormale" class="text-muted ms-2"></span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger" id="removeFileNormale">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="file_normale-error" class="invalid-feedback"></div>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Le fichier Excel doit contenir les colonnes obligatoires: 
                                        <strong>CNE</strong>, <strong>Note</strong> (entre 0 et 20). 
                                        Optionnellement: <strong>Remarques</strong>.
                                    </div>

                                    <div class="progress d-none" id="progressBarNormale">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="reset" class="btn btn-outline-secondary me-3">
                                            <i class="fas fa-undo me-2"></i>Réinitialiser
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="submitBtnNormale">
                                            <i class="fas fa-upload me-2"></i> Envoyer les Notes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Rattrapage -->
                    <div class="tab-pane fade" id="rattrapage">
                        <div class="card border-0">
                            <div class="card-body p-4">
                                <h5 class="card-title">Upload des Notes - Session Rattrapage</h5>
                                <form id="uploadFormRattrapage" enctype="multipart/form-data">
                                    <input type="hidden" name="session_type" value="rattrapage">

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="module_id_rattrapage" class="form-label">Module</label>
                                            <select class="form-select select2" id="module_id_rattrapage" name="module_id" required>
                                                <option value="" disabled selected>Sélectionner un module</option>
                                                <option value="1">Algorithmique et Programmation</option>
                                                <option value="2">Bases de Données</option>
                                                <option value="3">Réseaux Informatiques</option>
                                                <option value="4">Systèmes d'Exploitation</option>
                                                <option value="5">Mathématiques Appliquées</option>
                                                <option value="6">Développement Web</option>
                                            </select>
                                            <div id="module_id_rattrapage-error" class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="semester_rattrapage" class="form-label">Semestre</label>
                                            <select class="form-select" id="semester_rattrapage" name="semester" required>
                                                <option value="" disabled selected>Sélectionner un semestre</option>
                                                <option value="S1">Semestre 1</option>
                                                <option value="S2">Semestre 2</option>
                                                <option value="S3">Semestre 3</option>
                                                <option value="S4">Semestre 4</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div id="fileUploadRattrapage" class="file-upload-container">
                                            <div class="file-upload-icon">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <h5>Glissez-déposez votre fichier ici</h5>
                                            <p class="text-muted">ou</p>
                                            <button type="button" class="btn btn-outline-primary">
                                                <i class="fas fa-folder-open me-2"></i>Parcourir les fichiers
                                            </button>
                                            <input type="file" id="file_rattrapage" name="file" accept=".xlsx" class="d-none" required>
                                            <div class="form-text mt-3">Formats supportés: .xlsx (Excel)</div>
                                        </div>
                                        <div id="fileInfoRattrapage" class="file-info">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-file-excel text-success me-2"></i>
                                                    <span id="fileNameRattrapage"></span>
                                                    <span id="fileSizeRattrapage" class="text-muted ms-2"></span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger" id="removeFileRattrapage">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="file_rattrapage-error" class="invalid-feedback"></div>
                                    </div>

                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Pour la session de rattrapage, veuillez inclure uniquement les étudiants 
                                        qui ont passé cette session. Les notes doivent être entre 0 et 20.
                                    </div>

                                    <div class="progress d-none" id="progressBarRattrapage">
                                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="reset" class="btn btn-outline-secondary me-3">
                                            <i class="fas fa-undo me-2"></i>Réinitialiser
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="submitBtnRattrapage">
                                            <i class="fas fa-upload me-2"></i> Envoyer les Notes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body" id="modalMessage"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h4 class="mb-3" id="successTitle">Succès!</h4>
                    <p class="mb-4" id="successMessage"></p>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary me-3" data-bs-dismiss="modal">
                            <i class="fas fa-check me-2"></i>OK
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="viewDetailsBtn">
                            <i class="fas fa-list me-2"></i>Voir les détails
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Sélectionner un module",
                allowClear: true,
                width: '100%'
            });

            // File upload handling for both forms
            function setupFileUpload(formType) {
                const container = $(`#fileUpload${formType}`);
                const fileInput = $(`#file_${formType.toLowerCase()}`);
                const fileInfo = $(`#fileInfo${formType}`);
                const fileName = $(`#fileName${formType}`);
                const fileSize = $(`#fileSize${formType}`);
                const removeBtn = $(`#removeFile${formType}`);

                // Click handler for the container
                container.on('click', function() {
                    fileInput.trigger('click');
                });

                // Button click handler
                container.find('button').on('click', function(e) {
                    e.stopPropagation();
                    fileInput.trigger('click');
                });

                // Drag and drop handlers
                container.on('dragover', function(e) {
                    e.preventDefault();
                    container.addClass('dragover');
                });

                container.on('dragleave', function() {
                    container.removeClass('dragover');
                });

                container.on('drop', function(e) {
                    e.preventDefault();
                    container.removeClass('dragover');
                    if (e.originalEvent.dataTransfer.files.length) {
                        fileInput[0].files = e.originalEvent.dataTransfer.files;
                        handleFileSelection(formType);
                    }
                });

                // File input change handler
                fileInput.on('change', function() {
                    handleFileSelection(formType);
                });

                // Remove file handler
                removeBtn.on('click', function(e) {
                    e.stopPropagation();
                    fileInput.val('');
                    fileInfo.hide();
                    container.show();
                });
            }

            // Handle file selection
            function handleFileSelection(formType) {
                const fileInput = $(`#file_${formType.toLowerCase()}`);
                const fileInfo = $(`#fileInfo${formType}`);
                const fileName = $(`#fileName${formType}`);
                const fileSize = $(`#fileSize${formType}`);
                const container = $(`#fileUpload${formType}`);

                if (fileInput[0].files && fileInput[0].files[0]) {
                    const file = fileInput[0].files[0];
                    const fileExtension = file.name.split('.').pop().toLowerCase();

                    if (fileExtension !== 'xlsx') {
                        showModal('Erreur', 'Seuls les fichiers Excel (.xlsx) sont acceptés.');
                        fileInput.val('');
                        return;
                    }

                    fileName.text(file.name);
                    fileSize.text(formatFileSize(file.size));
                    container.hide();
                    fileInfo.show();
                }
            }

            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Show modal
            function showModal(title, message, isSuccess = false) {
                if (isSuccess) {
                    $('#successTitle').text(title);
                    $('#successMessage').html(message);
                    const modal = new bootstrap.Modal(document.getElementById('successModal'));
                    modal.show();
                } else {
                    $('#modalTitle').text(title);
                    $('#modalMessage').html(message);
                    const modal = new bootstrap.Modal(document.getElementById('messageModal'));
                    modal.show();
                }
            }

            // Initialize file upload for both forms
            setupFileUpload('Normale');
            setupFileUpload('Rattrapage');

            // Form submission
            $('#uploadFormNormale, #uploadFormRattrapage').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const formData = new FormData(this);
                const sessionType = form.find('input[name="session_type"]').val();
                const formType = sessionType === 'normale' ? 'Normale' : 'Rattrapage';
                const moduleName = form.find('select[name="module_id"] option:selected').text();
                const semester = form.find('select[name="semester"]').val();
                const progressBar = $(`#progressBar${formType}`);
                const submitBtn = $(`#submitBtn${formType}`);

                // Reset validation
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').text('');
                submitBtn.prop('disabled', true);
                progressBar.removeClass('d-none');
                progressBar.find('.progress-bar').css('width', '0%');

                // Simulate progress (in a real app, this would be actual upload progress)
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += 5;
                    progressBar.find('.progress-bar').css('width', `${progress}%`);
                    if (progress >= 100) {
                        clearInterval(progressInterval);
                        validateAndSubmit();
                    }
                }, 100);

                function validateAndSubmit() {
                    const errors = {};
                    let success = true;

                    // Validate module
                    if (!formData.get('module_id')) {
                        errors['module_id'] = 'Veuillez sélectionner un module.';
                        success = false;
                    }

                    // Validate semester
                    if (!formData.get('semester')) {
                        errors['semester'] = 'Veuillez sélectionner un semestre.';
                        success = false;
                    }

                    // Validate file
                    if (!formData.get('file')) {
                        errors['file'] = 'Veuillez choisir un fichier.';
                        success = false;
                    } else {
                        const file = formData.get('file');
                        const fileExtension = file.name.split('.').pop().toLowerCase();
                        if (fileExtension !== 'xlsx') {
                            errors['file'] = 'Le fichier doit être au format .xlsx.';
                            success = false;
                        }
                    }

                    if (success) {
                        // Simulate successful upload
                        setTimeout(() => {
                            progressBar.addClass('d-none');
                            submitBtn.prop('disabled', false);
                            
                            const successMessage = `
                                <p>Les notes pour le module <strong>${moduleName}</strong> (${semester}) ont été enregistrées avec succès.</p>
                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>${Math.floor(Math.random() * 50) + 20}</strong> notes ont été importées.
                                </div>
                            `;
                            
                            showModal('Succès', successMessage, true);
                            form[0].reset();
                            form.find('select').val('').trigger('change');
                            $(`#fileInfo${formType}`).hide();
                            $(`#fileUpload${formType}`).show();
                        }, 500);
                    } else {
                        clearInterval(progressInterval);
                        progressBar.addClass('d-none');
                        submitBtn.prop('disabled', false);
                        
                        // Show errors
                        for (const field in errors) {
                            const input = form.find(`[name="${field}"]`);
                            input.addClass('is-invalid');
                            const errorElement = $(`#${field}_${sessionType}-error`);
                            if (errorElement.length) {
                                errorElement.text(errors[field]);
                            } else {
                                input.next('.invalid-feedback').text(errors[field]);
                            }
                        }
                        
                        showModal('Erreur', 'Veuillez corriger les erreurs dans le formulaire avant de soumettre.');
                    }
                }
            });

            // View details button handler
            $('#viewDetailsBtn').on('click', function() {
                $('#successModal').modal('hide');
                // In a real app, this would redirect to the details page
                showModal('Détails de l\'importation', `
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th>Semestre</th>
                                    <th>Session</th>
                                    <th>Notes importées</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Algorithmique et Programmation</td>
                                    <td>S1</td>
                                    <td>${$('#normale-tab').hasClass('active') ? 'Normale' : 'Rattrapage'}</td>
                                    <td>42</td>
                                    <td>${new Date().toLocaleString()}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                `);
            });
        });
    </script>
</x-coordonnateur_layout>
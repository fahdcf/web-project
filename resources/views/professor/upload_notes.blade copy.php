<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload des Notes - Coordinateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-semibold mb-0" style="color: var(--primary-color);">Gestion des Notes</h2>
            <a href="#" class="btn btn-primary" id="downloadTemplate">
                <i class="fas fa-download me-2"></i>Télécharger le Modèle
            </a>
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
                                <form id="uploadFormNormale" action="{{ route('notes.upload') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="session_type" value="normale">
                                    <div class="mb-4">
                                        <label for="module_id_normale" class="form-label">Module</label>
                                        <select class="form-select select2" id="module_id_normale" name="module_id"
                                            required>


                                            <option value="" disabled selected>Sélectionner un module</option>

                                            @foreach ($modules as $module)
                                                <option value="{{ $module->id }}"
                                                    data-semester="{{ $module->semester }}">{{ $module->name }}
                                                </option>;
                                            @endforeach

                                        </select>
                                        <div id="module_id_normale-error" class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="file_normale" class="form-label">Fichier Excel (.xlsx)</label>
                                        <div id="fileUploadNormale" class="file-upload-container"
                                            onclick="document.getElementById('file_normale').click()">
                                            <div class="file-upload-icon">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <h5>Cliquez pour sélectionner un fichier</h5>
                                            <p class="text-muted">Formats supportés: .xlsx (Excel)</p>
                                        </div>
                                        <input type="file" id="file_normale" name="file" accept=".xlsx"
                                            class="d-none" required onchange="displayFileInfo(this, 'fileInfoNormale')">
                                        <div id="fileInfoNormale" class="file-info">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-file-excel text-success me-2"></i>
                                                    <span id="fileNameNormale"></span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="clearFileInput('file_normale', 'fileInfoNormale', 'fileUploadNormale')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="file_normale-error" class="invalid-feedback"></div>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Le fichier Excel doit contenir les colonnes: <strong>CNE</strong>,
                                        <strong>Note</strong> (entre 0 et 20).
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="reset" class="btn btn-outline-secondary me-3"
                                            onclick="clearFileInput('file_normale', 'fileInfoNormale', 'fileUploadNormale')">
                                            <i class="fas fa-undo me-2"></i>Réinitialiser
                                        </button>
                                        <button type="submit" class="btn btn-primary">
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
                                <form id="uploadFormRattrapage" action="upload_notes.php" method="POST"
                                    enctype="multipart/form-data">
                                    <input type="hidden" name="session_type" value="rattrapage">

                                    @csrf

                                    <div class="mb-4">
                                        <label for="module_id_rattrapage" class="form-label">Module</label>
                                        <select class="form-select select2" id="module_id_rattrapage"
                                            name="module_id" required>
                                            <option value="" disabled selected>Sélectionner un module</option>

                                            @foreach ($modules as $module)
                                                <option value="{{ $module->id }}"
                                                    data-semester="{{ $module->semester }}">{{ $module->name }}
                                                </option>;
                                            @endforeach
                                        </select>
                                        <div id="module_id_rattrapage-error" class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="file_rattrapage" class="form-label">Fichier Excel (.xlsx)</label>
                                        <div id="fileUploadRattrapage" class="file-upload-container"
                                            onclick="document.getElementById('file_rattrapage').click()">
                                            <div class="file-upload-icon">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <h5>Cliquez pour sélectionner un fichier</h5>
                                            <p class="text-muted">Formats supportés: .xlsx (Excel)</p>
                                        </div>
                                        <input type="file" id="file_rattrapage" name="file" accept=".xlsx"
                                            class="d-none" required
                                            onchange="displayFileInfo(this, 'fileInfoRattrapage')">
                                        <div id="fileInfoRattrapage" class="file-info">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-file-excel text-success me-2"></i>
                                                    <span id="fileNameRattrapage"></span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="clearFileInput('file_rattrapage', 'fileInfoRattrapage', 'fileUploadRattrapage')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="file_rattrapage-error" class="invalid-feedback"></div>
                                    </div>

                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Pour la session de rattrapage, veuillez inclure uniquement les étudiants ayant
                                        passé cette session.
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="reset" class="btn btn-outline-secondary me-3"
                                            onclick="clearFileInput('file_rattrapage', 'fileInfoRattrapage', 'fileUploadRattrapage')">
                                            <i class="fas fa-undo me-2"></i>Réinitialiser
                                        </button>
                                        <button type="submit" class="btn btn-primary">
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

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h4 class="mb-3">Succès!</h4>
                    <p class="mb-4" id="successMessage"></p>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        <i class="fas fa-check me-2"></i>OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-circle text-danger" style="font-size: 5rem;"></i>
                    </div>
                    <h4 class="mb-3">Erreur!</h4>
                    <p class="mb-4" id="errorMessage"></p>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        <i class="fas fa-check me-2"></i>OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Initialize Select2
        document.addEventListener('DOMContentLoaded', function() {
            $('.select2').select2({
                placeholder: "Sélectionner un module",
                allowClear: true,
                width: '100%'
            });
        });

        // File upload functions
        function displayFileInfo(input, infoElementId) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileExtension = file.name.split('.').pop().toLowerCase();

                if (fileExtension !== 'xlsx') {
                    showError('Erreur', 'Seuls les fichiers Excel (.xlsx) sont acceptés.');
                    input.value = '';
                    return;
                }

                const infoElement = document.getElementById(infoElementId);
                const fileNameElement = infoElement.querySelector('span');
                fileNameElement.textContent = file.name;

                document.getElementById('fileUpload' + infoElementId.replace('fileInfo', '')).style.display = 'none';
                infoElement.style.display = 'block';
            }
        }

        function clearFileInput(inputId, infoElementId, containerId) {
            document.getElementById(inputId).value = '';
            document.getElementById(infoElementId).style.display = 'none';
            document.getElementById(containerId).style.display = 'block';
        }

        // Modal functions
        function showSuccess(message) {
            document.getElementById('successMessage').textContent = message;
            new bootstrap.Modal(document.getElementById('successModal')).show();
        }

        function showError(title, message) {
            document.getElementById('errorMessage').textContent = message;
            new bootstrap.Modal(document.getElementById('errorModal')).show();
        }

        // Template download
        document.getElementById('downloadTemplate').addEventListener('click', function(e) {
            e.preventDefault();
            // In a real app, this would download an actual template file
            showSuccess('Le modèle Excel a été téléchargé avec succès.');
        });

        // Form submission handling
        document.getElementById('uploadFormNormale').addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });

        document.getElementById('uploadFormRattrapage').addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });

        function validateForm(form) {
            let isValid = true;

            // Validate module selection
            const moduleSelect = form.querySelector('select[name="module_id"]');
            if (!moduleSelect.value) {
                moduleSelect.classList.add('is-invalid');
                const errorElement = document.getElementById(moduleSelect.id + '-error');
                errorElement.textContent = 'Veuillez sélectionner un module.';
                isValid = false;
            } else {
                moduleSelect.classList.remove('is-invalid');
            }

            // Validate file
            const fileInput = form.querySelector('input[name="file"]');
            if (!fileInput.value) {
                fileInput.classList.add('is-invalid');
                const errorElement = document.getElementById(fileInput.id + '-error');
                errorElement.textContent = 'Veuillez sélectionner un fichier.';
                isValid = false;
            } else {
                fileInput.classList.remove('is-invalid');
            }

            if (!isValid) {
                showError('Erreur', 'Veuillez remplir tous les champs obligatoires.');
            }

            return isValid;
        }
    </script>


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
        }

        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
            border: none;
            padding: 0.75rem 1.5rem;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: transparent;
            font-weight: 600;
            border-bottom: 2px solid var(--primary-color);
        }

        .form-select,
        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
        }

        .select2-container .select2-selection--single {
            height: 48px;
            padding-top: 8px;
            border-radius: 8px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 8px;
        }

        .card-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
            border-bottom: 3px solid var(--success-color);
            padding-bottom: 0.75rem;
            display: inline-block;
        }

        .file-upload-container {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            margin-bottom: 1rem;
        }

        .file-upload-container:hover {
            border-color: var(--primary-color);
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
    </style>




</body>

</html>

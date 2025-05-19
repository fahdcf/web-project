<x-coordonnateur_layout>
    <x-global_alert />





    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --card-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .upload-container {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .upload-card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        .session-tabs {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 1.5rem;
        }

        .session-tabs .nav-link {
            color: #495057;
            font-weight: 500;
            border: none;
            padding: 0.75rem 1.5rem;
        }

        .session-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: transparent;
            font-weight: 600;
            border-bottom: 2px solid var(--primary-color);
        }

        .file-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            margin-bottom: 1rem;
            transition: border-color 0.3s ease;
        }

        .file-upload-area:hover {
            border-color: var(--primary-color);
        }

        .file-info-display {
            display: none;
            margin-top: 1rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid var(--primary-color);
        }

        .upload-title {
            color: var(--primary-color);
            font-weight: 600;
            border-bottom: 3px solid var(--success-color);
            padding-bottom: 0.75rem;
            display: inline-block;
        }

        .file-details {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #6c757d;
        }

        .file-detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.25rem;
        }

        .file-detail-label {
            font-weight: 500;
        }
    </style>

    <div class="container py-5 upload-container">
        @if ($errors->any())
            <div class="alert alert-danger error-message">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-semibold mb-0" style="color: var(--primary-color);">Gestion des Notes</h2>

            <a href="{{ asset('templates/modele_notes.xlsx') }}" class="btn btn-primary" download="Modele_Notes.xlsx">
                <i class="fas fa-download me-2"></i>Télécharger le Modèle
            </a>

        </div>

        <div class="upload-card">
            <div class="card-body p-4">
                <form id="notesUploadForm" action="{{ route('notes.upload') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="session-tabs mb-4">
                        <h5 class="upload-title me-3">Session :</h5>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="session_type" id="session_normale"
                                value="normale" checked>
                            <label class="form-check-label" for="session_normale">Normale</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="session_type" id="session_rattrapage"
                                value="rattrapage">
                            <label class="form-check-label" for="session_rattrapage">Rattrapage</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="module_id" class="form-label">Module</label>
                        <select class="form-select" id="module_id" name="module_id" required>
                            <option value="" disabled selected>Sélectionner un module</option>
                            @foreach ($modules as $module)
                                <option value="{{ $module->id }}" data-semester="{{ $module->semester }}">
                                    S{{ $module->semester }}: {{ $module->name }}
                                </option>
                            @endforeach
                        </select>
                        <div id="module_id-error" class="invalid-feedback"></div>
                    </div>

                    <div class="mb-4">
                        <label for="notes_file" class="form-label">Fichier Excel (.xlsx)</label>
                        <div id="fileUploadArea" class="file-upload-area">
                            <div class="file-upload-icon">
                                <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: var(--primary-color);"></i>
                            </div>
                            <h5>Glissez-déposez votre fichier ici</h5>
                            <p class="text-muted">ou cliquez pour parcourir</p>
                            <p class="small text-muted mt-2">Formats acceptés: .xlsx (Excel)</p>
                        </div>
                        <input type="file" id="notes_file" name="file" accept=".xlsx" class="d-none" required
                            onchange="handleFileSelect(this)">
                        <div id="fileInfoDisplay" class="file-info-display">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-excel text-success me-2"></i>
                                    <span id="selectedFileName" class="fw-semibold"></span>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="resetFileInput()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="file-details" id="fileDetails">
                                <!-- File details will be inserted here by JavaScript -->
                            </div>
                        </div>
                        <div id="file_error" class="invalid-feedback"></div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Le fichier doit contenir les colonnes: <strong>CNE</strong> et <strong>Note</strong> (entre 0 et
                        20).
                        Optionnel: <strong>Remarque</strong>.
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="reset" class="btn btn-outline-secondary me-3" onclick="resetForm()">
                            <i class="fas fa-undo me-2"></i>Réinitialiser
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-upload me-2"></i> Envoyer les Notes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="upload-card mt-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Historique des Uploads</h5>
            </div>
            <div class="card-body">
                @if ($uploads->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Module</th>
                                    <th>Session</th>
                                    <th>Fichier</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($uploads as $upload)
                                    <tr>
                                        <td>{{ $upload->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $upload->module->name }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $upload->session_type === 'normale' ? 'primary' : 'warning' }}">
                                                {{ ucfirst($upload->session_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $upload->original_name ?? 'Nom inconnu' }}
                                            <a href="{{ Storage::url($upload->storage_path) }}" target="_blank"
                                                class="ms-2">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if ($upload->status == 'active')
                                                <span class="badge bg-success">Actif</span>
                                            @else
                                                <span class="badge bg-danger">Annulé</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($upload->status == 'active')
                                                <form method="POST"
                                                    action="{{ route('notes.cancel', $upload->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Voulez-vous vraiment annuler cet upload ?')">
                                                        <i class="fas fa-times"></i> Annuler
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Aucun upload enregistré pour le moment.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <i id="modalIcon" class="fas fa-3x"></i>
                    </div>
                    <h4 class="mb-3" id="modalTitle"></h4>
                    <p class="mb-4" id="modalMessage"></p>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        <i class="fas fa-check me-2"></i>OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du drag and drop
            const fileUploadArea = document.getElementById('fileUploadArea');
            const fileInput = document.getElementById('notes_file');

            fileUploadArea.addEventListener('click', () => {
                fileInput.click();
            });

            fileUploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadArea.style.borderColor = 'var(--primary-color)';
                fileUploadArea.style.backgroundColor = 'rgba(67, 97, 238, 0.05)';
            });

            fileUploadArea.addEventListener('dragleave', () => {
                fileUploadArea.style.borderColor = '#dee2e6';
                fileUploadArea.style.backgroundColor = '';
            });

            fileUploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUploadArea.style.borderColor = '#dee2e6';
                fileUploadArea.style.backgroundColor = '';

                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    handleFileSelect(fileInput);
                }
            });

            // Gestion de la soumission du formulaire
            document.getElementById('notesUploadForm').addEventListener('submit', function(e) {
                e.preventDefault();

                if (validateForm()) {
                    // Afficher l'indicateur de chargement
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Envoi en cours...';

                    // Soumission AJAX optionnelle
                    this.submit();
                }
            });
        });

        function handleFileSelect(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileExtension = file.name.split('.').pop().toLowerCase();

                if (fileExtension !== 'xlsx') {
                    showModal('error', 'Format non supporté', 'Seuls les fichiers Excel (.xlsx) sont acceptés.');
                    resetFileInput();
                    return;
                }

                // Display file name
                document.getElementById('selectedFileName').textContent = file.name;

                // Display file details
                const fileDetails = document.getElementById('fileDetails');
                fileDetails.innerHTML = `
                    <div class="file-detail-item">
                        <span class="file-detail-label">Taille:</span>
                        <span>${formatFileSize(file.size)}</span>
                    </div>
                    <div class="file-detail-item">
                        <span class="file-detail-label">Type:</span>
                        <span>${file.type || 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'}</span>
                    </div>
                    <div class="file-detail-item">
                        <span class="file-detail-label">Dernière modification:</span>
                        <span>${new Date(file.lastModified).toLocaleString()}</span>
                    </div>
                `;

                document.getElementById('fileUploadArea').style.display = 'none';
                document.getElementById('fileInfoDisplay').style.display = 'block';
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function resetFileInput() {
            document.getElementById('notes_file').value = '';
            document.getElementById('fileInfoDisplay').style.display = 'none';
            document.getElementById('fileUploadArea').style.display = 'block';
        }

        function resetForm() {
            resetFileInput();
            document.getElementById('module_id').value = '';
            document.getElementById('session_normale').checked = true;
        }

        function validateForm() {
            let isValid = true;

            // Validation module
            const moduleSelect = document.getElementById('module_id');
            if (!moduleSelect.value) {
                moduleSelect.classList.add('is-invalid');
                document.getElementById('module_id-error').textContent = 'Veuillez sélectionner un module.';
                isValid = false;
            } else {
                moduleSelect.classList.remove('is-invalid');
            }

            // Validation fichier
            const fileInput = document.getElementById('notes_file');
            if (!fileInput.value) {
                document.getElementById('file_error').textContent = 'Veuillez sélectionner un fichier.';
                isValid = false;
            } else {
                document.getElementById('file_error').textContent = '';
            }

            if (!isValid) {
                showModal('error', 'Formulaire incomplet', 'Veuillez remplir tous les champs obligatoires.');
            }

            return isValid;
        }

        function showModal(type, title, message) {
            const modalIcon = document.getElementById('modalIcon');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');

            modalIcon.className =
                `fas fa-3x fa-${type === 'success' ? 'check-circle text-success' : 'exclamation-circle text-danger'}`;
            modalTitle.textContent = title;
            modalMessage.textContent = message;

            const modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        }

        // Affichage des messages de session
        @if (session('success'))
            showModal('success', 'Succès', '{{ session('success') }}');
        @endif

        @if (session('error'))
            showModal('error', 'Erreur', '{{ session('error') }}');
        @endif


       
    </script>
</x-coordonnateur_layout>

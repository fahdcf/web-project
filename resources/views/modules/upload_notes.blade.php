<x-coordonnateur_layout>
    @vite(['resources/css/notes.css'])

    {{-- upload-container --}}
    <div class="container-fluid px-4 py-5 ">
        <x-global_alert />

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger error-message" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Heading Component -->
        @include('components.heading', [
            'icon' => '<i class="fas fa-edit fa-2x" style="color: #330bcf;"></i>',
            'heading' => 'Gestion des Notes',
            'buttons' => [
                [
                    'route' => asset('templates/modele_note.xlsx'),
                    'text' => 'Télécharger le Modèle',
                    'type' => 'primary',
                ],
            ],
        ])

        <!-- Upload Card -->
        <div class="upload-card">
            <div class="card-body p-4">
                <form id="notesUploadForm" action="{{ route('notes.upload') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="session-tabs mb-4">
                        <h5 class="upload-title me-3">Session :</h5>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="session_type" id="session_normale"
                                value="normale" checked aria-label="Session normale">
                            <label class="form-check-label" for="session_normale">Normale</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="session_type" id="session_rattrapage"
                                value="rattrapage" aria-label="Session rattrapage">
                            <label class="form-check-label" for="session_rattrapage">Rattrapage</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="module_id" class="form-label">Module</label>
                        <select class="form-select" id="module_id" name="module_id" required
                            aria-label="Sélectionner un module">
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
                        <label for="notes_file" class="form-label">Fichier Excel (.xlsx, .xls)</label>
                        <div id="fileUploadArea" class="file-upload-area" role="button"
                            aria-label="Zone de téléchargement de fichiers Excel" tabindex="0">
                            <div class="file-upload-icon">
                                <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
                            </div>
                            <h5>Glissez-déposez votre fichier ici</h5>
                            <p class="text-muted">ou cliquez pour parcourir</p>
                            <p class="small text-muted mt-2">Formats acceptés : .xlsx, .xls</p>
                        </div>
                        <input type="file" id="notes_file" name="file" accept=".xlsx,.xls" class="d-none" required
                            aria-describedby="file_error">
                        <div id="fileInfoDisplay" class="file-info-display">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-excel text-success me-2"></i>
                                    <span id="selectedFileName" class="fw-semibold"></span>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="resetFileInput()"
                                    aria-label="Supprimer le fichier sélectionné">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="file-details" id="fileDetails"></div>
                        </div>
                        <div id="file_error" class="invalid-feedback"></div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Le fichier doit contenir les colonnes : <strong>CNE</strong> et <strong>Note</strong> (entre 0
                        et 20). Optionnel : <strong>Remarque</strong>.
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="reset" class="btn btn-outline-secondary me-3" onclick="resetForm()"
                            aria-label="Réinitialiser le formulaire">
                            <i class="fas fa-undo me-2"></i>Réinitialiser
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn" aria-label="Envoyer les notes">
                            <i class="fas fa-upload me-2"></i>Envoyer les Notes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- History Card -->
        <div class="upload-card mt-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Historique des Uploads</h5>
                <div class="input-group search-box" style="width: 300px;">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="historySearch" class="form-control border-start-0"
                        placeholder="Rechercher..." aria-label="Rechercher dans l'historique">
                </div>
            </div>
            <div class="card-body p-0">
                @if ($uploads->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="uploadsTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sortable" data-sort="date" aria-sort="none">
                                        <div class="d-flex align-items-center">
                                            <span>Date</span>
                                            <i class="fas fa-sort ms-2"></i>
                                        </div>
                                    </th>
                                    <th scope="col" class="sortable" data-sort="module" aria-sort="none">
                                        <div class="d-flex align-items-center">
                                            <span>Module</span>
                                            <i class="fas fa-sort ms-2"></i>
                                        </div>
                                    </th>
                                    <th scope="col" class="sortable" data-sort="session" aria-sort="none">
                                        <div class="d-flex align-items-center">
                                            <span>Session</span>
                                            <i class="fas fa-sort ms-2"></i>
                                        </div>
                                    </th>
                                    <th scope="col">Fichier</th>
                                    <th scope="col" class="sortable" data-sort="status" aria-sort="none">
                                        <div class="d-flex align-items-center">
                                            <span>Statut</span>
                                            <i class="fas fa-sort ms-2"></i>
                                        </div>
                                    </th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($uploads as $upload)
                                    <tr>
                                        <td data-date="{{ $upload->created_at->format('Y-m-d H:i') }}"
                                            class="text-nowrap">
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="fw-medium">{{ $upload->created_at->format('d/m/Y') }}</span>
                                                <small
                                                    class="text-muted">{{ $upload->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td data-module="{{ $upload->module->name }}">
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="badge bg-light text-dark me-2">S{{ $upload->module->semester }}</span>
                                                <span>{{ Str::limit($upload->module->name, 30) }}</span>
                                            </div>
                                        </td>
                                        <td data-session="{{ $upload->session_type }}">
                                            <span
                                                class="badge rounded-pill bg-{{ $upload->session_type === 'normale' ? 'primary' : 'warning' }}">
                                                {{ ucfirst($upload->session_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('notes.download', $upload->id) }}"
                                                class="d-flex align-items-center text-decoration-none"
                                                aria-label="Télécharger {{ $upload->original_name }}">
                                                <i class="fas fa-file-excel text-success me-2"></i>
                                                <span class="text-truncate"
                                                    style="max-width: 150px;">{{ $upload->original_name ?? 'Nom inconnu' }}</span>
                                            </a>
                                        </td>
                                        <td data-status="{{ $upload->status }}">
                                            <span
                                                class="badge rounded-pill bg-{{ $upload->status == 'active' ? 'success' : 'danger' }}">
                                                <i
                                                    class="fas fa-{{ $upload->status == 'active' ? 'check' : 'times' }} me-1"></i>
                                                {{ $upload->status == 'active' ? 'Actif' : 'Annulé' }}
                                            </span>
                                        </td>
                                        <td class="text-nowrap">
                                            @if ($upload->status == 'active')
                                                <button class="btn btn-sm btn-outline-danger rounded-pill"
                                                    data-bs-toggle="modal" data-bs-target="#cancelModal"
                                                    onclick="document.getElementById('cancelForm').action = '{{ route('notes.cancel', $upload->id) }}'"
                                                    aria-label="Annuler l'upload de {{ $upload->original_name }}">
                                                    <i class="fas fa-ban me-1"></i> Annuler
                                                </button>
                                            @else
                                                <span class="text-muted small">Aucune action</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 border-top">
                        {{ $uploads->links() }}
                    </div>
                @else
                    <div class="p-5 text-center">
                        <div class="empty-state">
                            <i class="fas fa-file-excel fa-4x text-muted mb-4"></i>
                            <h5 class="mb-3">Aucun upload enregistré</h5>
                            <p class="text-muted mb-4">Vous n'avez encore uploadé aucun fichier de notes.</p>
                            <button class="btn btn-primary" onclick="document.getElementById('notes_file').click()">
                                <i class="fas fa-upload me-2"></i>Uploader un fichier
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Status Modal -->
        <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <div class="mb-4">
                            <i id="modalIcon" class="fas fa-3x"></i>
                        </div>
                        <h4 class="mb-3" id="modalTitle"></h4>
                        <p class="mb-4" id="modalMessage"></p>
                        <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal"
                            aria-label="Fermer">
                            <i class="fas fa-check me-2"></i>OK
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancel Confirmation Modal -->
        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="cancelModalLabel">Confirmer l'annulation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="d-flex align-items-center mb-4">
                            <i class="fas fa-exclamation-triangle text-warning me-3 fa-2x"></i>
                            <p class="mb-0">Voulez-vous vraiment annuler cet upload ? Cette action est irréversible.
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                            data-bs-dismiss="modal" aria-label="Annuler">Non</button>
                        <form id="cancelForm" method="POST" action="">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger rounded-pill px-4"
                                aria-label="Confirmer l'annulation">
                                <i class="fas fa-check me-1"></i> Oui, annuler
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CSS -->
    <style>
        :root {
            --primary: #4723d9;
            --primary-light: rgba(71, 35, 217, 0.1);
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --border-radius: 10px;
        }

        .upload-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .upload-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: none;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .upload-card .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.5rem;
        }

        .upload-card .card-body {
            padding: 1.5rem;
        }

        .upload-title {
            color: var(--primary);
            font-weight: 600;
            font-size: 1.5rem;
            border-bottom: 3px solid var(--success);
            padding-bottom: 0.5rem;
            display: inline-block;
        }

        .session-tabs {
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 2rem;
        }

        .form-check-label {
            color: #495057;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-select,
        .form-control {
            border-radius: 6px;
            font-size: 0.9rem;
            padding: 0.75rem;
            border-color: #e0e0e0;
            background-color: #f8f9fa;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(71, 35, 217, 0.2);
            outline: none;
        }

        .file-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .file-upload-area:hover,
        .file-upload-area.dragging {
            border-color: var(--primary);
            background-color: var(--primary-light);
            transform: translateY(-2px);
        }

        .file-upload-icon i {
            color: var(--primary);
            transition: transform 0.3s ease;
        }

        .file-upload-area:hover .file-upload-icon i {
            transform: scale(1.1);
        }

        .file-info-display {
            display: none;
            margin-top: 1rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid var(--primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .file-details {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .file-detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .file-detail-label {
            font-weight: 500;
            color: #495057;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            font-size: 0.9rem;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #fff;
            color: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-secondary,
        .btn-outline-danger {
            font-size: 0.9rem;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            transition: all 0.2s;
        }

        /* Table Styles */
        #uploadsTable {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        #uploadsTable thead th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            padding: 1rem;
            border-bottom: 2px solid #e9ecef;
            vertical-align: middle;
        }

        #uploadsTable tbody tr {
            transition: background-color 0.2s;
        }

        #uploadsTable tbody tr:hover {
            background-color: var(--primary-light);
        }

        #uploadsTable tbody td {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        #uploadsTable tbody tr:last-child td {
            border-bottom: none;
        }

        .sortable {
            cursor: pointer;
            user-select: none;
            transition: color 0.2s;
        }

        .sortable:hover {
            color: var(--primary);
        }

        .sortable.asc i::before {
            content: '\f0de';
            /* FontAwesome sort-up */
        }

        .sortable.desc i::before {
            content: '\f0dd';
            /* FontAwesome sort-down */
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.35em 0.65em;
            border-radius: 6px;
        }

        .search-box {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .search-box .input-group-text {
            border-right: none;
            background-color: white;
        }

        .search-box .form-control {
            border-left: none;
            background-color: white;
        }

        .empty-state {
            max-width: 400px;
            margin: 0 auto;
        }

        .modal-content {
            border-radius: var(--border-radius);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            border: none;
        }

        .modal-header {
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
        }

        @media (max-width: 768px) {
            .upload-container {
                padding: 1rem;
            }

            .upload-card {
                margin-bottom: 1rem;
            }

            .session-tabs {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-primary,
            .btn-outline-secondary {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            #uploadsTable thead {
                display: none;
            }

            #uploadsTable tbody tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: var(--border-radius);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            #uploadsTable tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid #f0f0f0;
            }

            #uploadsTable tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #495057;
                margin-right: 1rem;
            }

            #uploadsTable tbody td:last-child {
                border-bottom: none;
            }

            .search-box {
                width: 100% !important;
                margin-top: 1rem;
            }
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize elements
            const fileUploadArea = document.getElementById('fileUploadArea');
            const fileInput = document.getElementById('notes_file');
            const historySearch = document.getElementById('historySearch');
            let debounceTimeout;

            // Drag and Drop functionality
            fileUploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadArea.classList.add('dragging');
            });

            fileUploadArea.addEventListener('dragleave', () => {
                fileUploadArea.classList.remove('dragging');
            });

            fileUploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUploadArea.classList.remove('dragging');
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    handleFileSelect(fileInput);
                }
            });

            fileUploadArea.addEventListener('click', () => fileInput.click());
            fileUploadArea.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    fileInput.click();
                }
            });

            // File input change handler
            fileInput.addEventListener('change', function() {
                handleFileSelect(this);
            });

            // Search functionality with debounce
            historySearch.addEventListener('input', function() {
                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(() => {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('#uploadsTable tbody tr');

                    rows.forEach(row => {
                        const rowText = row.textContent.toLowerCase();
                        row.style.display = searchTerm === '' || rowText.includes(
                            searchTerm) ? '' : 'none';
                    });
                }, 300);
            });

            // Table Sorting
            document.querySelectorAll('.sortable').forEach(header => {
                header.addEventListener('click', () => {
                    const sortKey = header.dataset.sort;
                    const currentSort = header.getAttribute('aria-sort');
                    const newSort = currentSort === 'ascending' ? 'descending' : 'ascending';

                    // Update sort indicators
                    document.querySelectorAll('.sortable').forEach(h => {
                        h.setAttribute('aria-sort', 'none');
                        h.classList.remove('asc', 'desc');
                    });
                    header.setAttribute('aria-sort', newSort);
                    header.classList.add(newSort === 'ascending' ? 'asc' : 'desc');

                    // Sort rows
                    const table = document.getElementById('uploadsTable');
                    const rows = Array.from(table.querySelectorAll('tbody tr'));
                    rows.sort((a, b) => {
                        let valA = a.querySelector(`[data-${sortKey}]`).dataset[sortKey];
                        let valB = b.querySelector(`[data-${sortKey}]`).dataset[sortKey];

                        if (sortKey === 'date') {
                            valA = new Date(valA).getTime();
                            valB = new Date(valB).getTime();
                        }

                        if (newSort === 'ascending') {
                            return valA > valB ? 1 : -1;
                        } else {
                            return valA < valB ? 1 : -1;
                        }
                    });

                    // Reattach sorted rows
                    const tbody = table.querySelector('tbody');
                    rows.forEach(row => tbody.appendChild(row));
                });
            });

            // Form Submission
            document.getElementById('notesUploadForm').addEventListener('submit', function(e) {
                e.preventDefault();
                if (validateForm()) {
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Envoi en cours...';
                    this.submit();
                }
            });

            // Responsive table setup
            setupResponsiveTable();
        });

        function setupResponsiveTable() {
            if (window.innerWidth < 768) {
                const headers = Array.from(document.querySelectorAll('#uploadsTable thead th'));
                const rows = document.querySelectorAll('#uploadsTable tbody tr');

                rows.forEach(row => {
                    const cells = Array.from(row.querySelectorAll('td'));
                    cells.forEach((cell, index) => {
                        cell.setAttribute('data-label', headers[index].textContent.trim());
                    });
                });
            }
        }

        function handleFileSelect(input) {
            const fileInfoDisplay = document.getElementById('fileInfoDisplay');
            const fileDetails = document.getElementById('fileDetails');
            const fileError = document.getElementById('file_error');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileExtension = file.name.split('.').pop().toLowerCase();

                if (fileExtension !== 'xlsx' && fileExtension !== 'xls') {
                    showModal('error', 'Format non supporté', 'Seuls les fichiers Excel (.xlsx, .xls) sont acceptés.');
                    resetFileInput();
                    return;
                }

                document.getElementById('selectedFileName').textContent = file.name;
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
                        <span>${new Date(file.lastModified).toLocaleString('fr-FR')}</span>
                    </div>
                `;
                document.getElementById('fileUploadArea').style.display = 'none';
                fileInfoDisplay.style.display = 'block';
                fileError.textContent = '';
            } else {
                fileError.textContent = 'Veuillez sélectionner un fichier.';
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
            document.getElementById('file_error').textContent = '';
        }

        function resetForm() {
            resetFileInput();
            document.getElementById('module_id').value = '';
            document.getElementById('session_normale').checked = true;
            document.getElementById('module_id').classList.remove('is-invalid');
            document.getElementById('module_id-error').textContent = '';
        }

        function validateForm() {
            let isValid = true;
            const moduleSelect = document.getElementById('module_id');
            const fileInput = document.getElementById('notes_file');

            if (!moduleSelect.value) {
                moduleSelect.classList.add('is-invalid');
                document.getElementById('module_id-error').textContent = 'Veuillez sélectionner un module.';
                isValid = false;
            } else {
                moduleSelect.classList.remove('is-invalid');
                document.getElementById('module_id-error').textContent = '';
            }

            if (!fileInput.files || !fileInput.files[0]) {
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
                `fas fa-3x ${type === 'success' ? 'fa-check-circle text-success' : 'fa-exclamation-circle text-danger'}`;
            modalTitle.textContent = title;
            modalMessage.textContent = message;

            const modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        }

        // Session Messages
        @if (session('success'))
            showModal('success', 'Succès', '{{ session('success') }}');
        @endif
        @if (session('error'))
            showModal('error', 'Erreur', '{{ session('error') }}');
        @endif

        // Responsive table on resize
        window.addEventListener('resize', setupResponsiveTable);
    </script>
</x-coordonnateur_layout>

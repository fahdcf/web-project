<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 text-gray-800">
                    <i class="fas fa-chalkboard-teacher text-primary me-2"></i>
                    Espace Professeur
                </h1>
                <p class="mb-0 text-muted small">
                    <i class="fas fa-user-tie me-1"></i>
                    Pr. Ahmed Benali | 
                    <i class="fas fa-calendar-alt me-1"></i>
                    Année académique: 2023/2024
                </p>
            </div>
            <div class="badge bg-primary">
                <i class="fas fa-clock me-1"></i>
                Charge totale: 210h
            </div>
        </div>

        <!-- Main Cards -->
        <div class="row mb-4">
            <!-- UE Selection Card -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0">
                        <h5 class="mb-0">
                            <i class="fas fa-list-check text-success me-2"></i>
                            Sélection des UE pour 2024/2025
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Charge minimale requise: <strong>192h</strong> | 
                            Charge maximale: <strong>384h</strong>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th width="50"></th>
                                        <th>Code UE</th>
                                        <th>Intitulé</th>
                                        <th>Volume Horaire</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input ue-checkbox" type="checkbox" value="1" data-heures="60" id="ue-1" checked>
                                            </div>
                                        </td>
                                        <td>INF101</td>
                                        <td>Algorithmique et programmation</td>
                                        <td><span class="badge bg-light-primary">60h</span></td>
                                        <td><span class="badge bg-success">Validé</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input ue-checkbox" type="checkbox" value="2" data-heures="45" id="ue-2" checked>
                                            </div>
                                        </td>
                                        <td>INF102</td>
                                        <td>Structures de données</td>
                                        <td><span class="badge bg-light-primary">45h</span></td>
                                        <td><span class="badge bg-warning">En attente</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input ue-checkbox" type="checkbox" value="3" data-heures="75" id="ue-3">
                                            </div>
                                        </td>
                                        <td>INF201</td>
                                        <td>Bases de données</td>
                                        <td><span class="badge bg-light-primary">75h</span></td>
                                        <td><span class="badge bg-secondary">Disponible</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input ue-checkbox" type="checkbox" value="4" data-heures="30" id="ue-4">
                                            </div>
                                        </td>
                                        <td>INF202</td>
                                        <td>Réseaux informatiques</td>
                                        <td><span class="badge bg-light-primary">30h</span></td>
                                        <td><span class="badge bg-secondary">Disponible</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="fw-bold">Total sélectionné: <span id="total-heures">105</span>h</div>
                            <button class="btn btn-sm btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>
                                Soumettre mes choix
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current UE Card -->
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0">
                        <h5 class="mb-0">
                            <i class="fas fa-book-open text-info me-2"></i>
                            Mes UE actuelles (2023/2024)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">INF101 - Algorithmique</h6>
                                    <small class="text-muted">S1 | 60h (30CM + 20TD + 10TP)</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">2 groupes</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">INF102 - Structures données</h6>
                                    <small class="text-muted">S2 | 45h (20CM + 15TD + 10TP)</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">1 groupe</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Upload Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="mb-0">
                    <i class="fas fa-upload text-warning me-2"></i>
                    Dépôt des notes
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>UE</th>
                                <th>Session</th>
                                <th>Fichier</th>
                                <th>Date dépôt</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>INF101 - Algorithmique</td>
                                <td>Normale</td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>
                                        notes_inf101_normale.xlsx
                                    </span>
                                </td>
                                <td>15/06/2024</td>
                                <td><span class="badge bg-success">Validé</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>INF101 - Algorithmique</td>
                                <td>Rattrapage</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Non déposé
                                    </span>
                                </td>
                                <td>-</td>
                                <td><span class="badge bg-warning">En attente</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary">
                                        <i class="fas fa-upload me-1"></i>
                                        Uploader
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>INF102 - Structures données</td>
                                <td>Normale</td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>
                                        notes_inf102_normale.xlsx
                                    </span>
                                </td>
                                <td>18/06/2024</td>
                                <td><span class="badge bg-success">Validé</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- History Section -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="mb-0">
                    <i class="fas fa-history text-secondary me-2"></i>
                    Historique des années précédentes
                </h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="historyAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2023">
                                2022/2023
                            </button>
                        </h2>
                        <div id="collapse2023" class="accordion-collapse collapse show" data-bs-parent="#historyAccordion">
                            <div class="accordion-body">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        INF101 - Algorithmique
                                        <span class="badge bg-primary rounded-pill">60h</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        MATH201 - Algèbre linéaire
                                        <span class="badge bg-primary rounded-pill">45h</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2022">
                                2021/2022
                            </button>
                        </h2>
                        <div id="collapse2022" class="accordion-collapse collapse" data-bs-parent="#historyAccordion">
                            <div class="accordion-body">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        INF102 - Structures données
                                        <span class="badge bg-primary rounded-pill">45h</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        MATH101 - Analyse
                                        <span class="badge bg-primary rounded-pill">60h</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadNotesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Uploader les notes</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">UE</label>
                            <input type="text" class="form-control" value="INF101 - Algorithmique" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Session</label>
                            <input type="text" class="form-control" value="Rattrapage" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fichier Excel</label>
                            <input class="form-control" type="file" accept=".xlsx,.xls">
                        </div>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Vérifiez bien le format du fichier avant soumission
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary">Uploader</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Calculate total hours
            function calculateTotalHours() {
                let total = 0;
                document.querySelectorAll('.ue-checkbox:checked').forEach(checkbox => {
                    total += parseInt(checkbox.dataset.heures);
                });
                document.getElementById('total-heures').textContent = total;
                
                // Show warning if below minimum
                if (total < 192) {
                    alert('Attention: Votre charge horaire est inférieure au minimum requis (192h)');
                }
            }
            
            // Initialize calculation
            calculateTotalHours();
            
            // Update on checkbox change
            document.querySelectorAll('.ue-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', calculateTotalHours);
            });
            
            // Initialize upload modal
            const uploadModal = new bootstrap.Modal(document.getElementById('uploadNotesModal'));
            
            document.querySelectorAll('[data-action="upload"]').forEach(button => {
                button.addEventListener('click', function() {
                    uploadModal.show();
                });
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .card {
            border: none;
            border-radius: 0.5rem;
        }
        
        .list-group-item {
            border-left: none;
            border-right: none;
        }
        
        .list-group-item:first-child {
            border-top: none;
        }
        
        .accordion-button:not(.collapsed) {
            background-color: rgba(13, 110, 253, 0.05);
            color: #0d6efd;
        }
        
        .badge {
            font-weight: 500;
        }
        
        .table th {
            font-weight: 600;
            font-size: 0.85rem;
        }
    </style>
    @endpush
</x-coordonnateur_layout>
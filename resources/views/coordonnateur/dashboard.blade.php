<x-coordonnateur_layout>
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Tableau de Bord - Coordonnateur</h2>
                <small class="text-muted">Filière: Informatique | A.U: 2023/2024</small>
            </div>
            <div class="d-flex">
                <button class="btn btn-sm btn-outline-primary me-2">
                    <i class="fas fa-sync-alt me-1"></i> Actualiser
                </button>
                <button class="btn btn-sm btn-primary">
                    <i class="fas fa-file-export me-1"></i> Exporter
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start border-primary border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-primary fw-normal mb-2">UE Total</h6>
                                <h3 class="mb-0">24</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-book text-primary"></i>
                            </div>
                        </div>
                        <a href="{{ route('coordonnateur.modules.index') }}" class="small text-decoration-none mt-2 d-block">Voir détails <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start border-success border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-success fw-normal mb-2">Vacataires Actifs</h6>
                                <h3 class="mb-0">15</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-user-tie text-success"></i>
                            </div>
                        </div>
                        <a href="#vacataires-section" class="small text-decoration-none mt-2 d-block">Gérer <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start border-warning border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-warning fw-normal mb-2">Validations en attente</h6>
                                <h3 class="mb-0">8</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-clock text-warning"></i>
                            </div>
                        </div>
                        <a href="#validations-section" class="small text-decoration-none mt-2 d-block">Vérifier <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start border-info border-4 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-info fw-normal mb-2">Cours cette semaine</h6>
                                <h3 class="mb-0">42</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-calendar-alt text-info"></i>
                            </div>
                        </div>
                        <a href="#edt-section" class="small text-decoration-none mt-2 d-block">Voir EDT <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- UE Management Section -->
        <div class="card shadow-sm mb-4" id="ue-section">
            <div class="card-header bg-white border-bottom-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="h5 mb-0">
                        <i class="fas fa-book text-primary me-2"></i>Unités d'Enseignement
                    </h3>
                    <div>
                        <button class="btn btn-sm btn-outline-secondary me-2">
                            <i class="fas fa-filter me-1"></i> Filtrer
                        </button>
                        <a href="#" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i> Ajouter UE
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th width="100">Code</th>
                                <th>Nom</th>
                                <th width="100">Semestre</th>
                                <th>Responsable</th>
                                <th width="120">Statut</th>
                                <th width="100" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>INF101</td>
                                <td>Algorithmique et programmation</td>
                                <td>S1</td>
                                <td>Pr. Ahmed Benali</td>
                                <td><span class="badge bg-success">Validé</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>INF102</td>
                                <td>Structures de données</td>
                                <td>S2</td>
                                <td>Pr. Leila Mohamed</td>
                                <td><span class="badge bg-success">Validé</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>INF201</td>
                                <td>Bases de données</td>
                                <td>S3</td>
                                <td><span class="text-warning">À affecter</span></td>
                                <td><span class="badge bg-warning text-dark">Brouillon</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>INF202</td>
                                <td>Réseaux informatiques</td>
                                <td>S4</td>
                                <td>Vac. Karim Doudou</td>
                                <td><span class="badge bg-success">Validé</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">Affichage 1 à 4 sur 24 UEs</div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Précédent</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Suivant</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Vacataires Management Section -->
        <div class="card shadow-sm mb-4" id="vacataires-section">
            <div class="card-header bg-white border-bottom-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="h5 mb-0">
                        <i class="fas fa-user-tie text-success me-2"></i>Gestion des Vacataires
                    </h3>
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Nouveau vacataire
                    </button>
                </div>
            </div>
            <div class="card-body pt-0">
                <ul class="nav nav-tabs nav-tabs-custom mb-3" id="vacataireTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="affectations-tab" data-bs-toggle="tab" data-bs-target="#affectations" type="button">
                            <i class="fas fa-tasks me-1"></i> Affectations
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="comptes-tab" data-bs-toggle="tab" data-bs-target="#comptes" type="button">
                            <i class="fas fa-users me-1"></i> Liste des vacataires
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content" id="vacataireTabsContent">
                    <div class="tab-pane fade show active" id="affectations">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>UE</th>
                                        <th>Type</th>
                                        <th>Vacataire</th>
                                        <th>Contact</th>
                                        <th>Heures</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>INF101 (Algo)</td>
                                        <td><span class="badge bg-info">TD</span></td>
                                        <td>M. Samir Ali</td>
                                        <td>samir.ali@example.com</td>
                                        <td>24h</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>INF102 (SD)</td>
                                        <td><span class="badge bg-primary">CM</span></td>
                                        <td>Mme. Nadia Hamid</td>
                                        <td>nadia.h@example.com</td>
                                        <td>36h</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="comptes">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="w-50">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="Rechercher un vacataire...">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="fas fa-file-export me-1"></i> Exporter
                                </button>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-filter me-1"></i> Filtrer
                                </button>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nom complet</th>
                                        <th>Email</th>
                                        <th>Spécialité</th>
                                        <th>Statut</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>M. Samir Ali</td>
                                        <td>samir.ali@example.com</td>
                                        <td>Algorithmique</td>
                                        <td><span class="badge bg-success">Actif</span></td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary me-1">
                                                <i class="fas fa-key"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mme. Nadia Hamid</td>
                                        <td>nadia.h@example.com</td>
                                        <td>Bases de données</td>
                                        <td><span class="badge bg-success">Actif</span></td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary me-1">
                                                <i class="fas fa-key"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Section -->
        <div class="card shadow-sm mb-4" id="edt-section">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h3 class="h5 mb-0">
                    <i class="fas fa-calendar-alt text-info me-2"></i>Emploi du Temps
                </h3>
            </div>
            <div class="card-body pt-0">
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Semestre</label>
                        <select class="form-select form-select-sm">
                            <option>Tous</option>
                            <option selected>S1</option>
                            <option>S2</option>
                            <option>S3</option>
                            <option>S4</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Type de cours</label>
                        <select class="form-select form-select-sm">
                            <option>Tous</option>
                            <option>CM</option>
                            <option selected>TD</option>
                            <option>TP</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Semaine du</label>
                        <input type="date" class="form-control form-control-sm" value="2023-10-02">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-sm btn-primary w-100">
                            <i class="fas fa-filter me-1"></i> Appliquer
                        </button>
                    </div>
                </div>
                
                <!-- Simplified Schedule -->
                <div class="edt-visualisation">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-edt">
                            <thead>
                                <tr>
                                    <th width="100">Heure</th>
                                    <th>Lundi</th>
                                    <th>Mardi</th>
                                    <th>Mercredi</th>
                                    <th>Jeudi</th>
                                    <th>Vendredi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>08:00 - 10:00</td>
                                    <td class="bg-primary bg-opacity-10">
                                        <div class="edt-event">
                                            <strong>INF101 - CM</strong>
                                            <div>Salle A12</div>
                                            <div class="text-muted small">Pr. Ahmed</div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="bg-info bg-opacity-10">
                                        <div class="edt-event">
                                            <strong>INF101 - TD</strong>
                                            <div>Salle B05</div>
                                            <div class="text-muted small">Vac. Samir</div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>10:15 - 12:15</td>
                                    <td></td>
                                    <td class="bg-success bg-opacity-10">
                                        <div class="edt-event">
                                            <strong>INF102 - TP</strong>
                                            <div>Labo Info 3</div>
                                            <div class="text-muted small">Vac. Nadia</div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Validations Section -->
        <div class="card shadow-sm" id="validations-section">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h3 class="h5 mb-0">
                    <i class="fas fa-check-circle text-warning me-2"></i>Validations en Attente
                </h3>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Element</th>
                                <th>Demandé par</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>02/10/2023</td>
                                <td><span class="badge bg-primary">UE</span></td>
                                <td>INF201 - Bases de données</td>
                                <td>Pr. Leila</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-success me-1">
                                        <i class="fas fa-check"></i> Valider
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-times"></i> Rejeter
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>01/10/2023</td>
                                <td><span class="badge bg-info">Emploi du temps</span></td>
                                <td>S1 - Semaine 40</td>
                                <td>Sec. Pédagogique</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-success me-1">
                                        <i class="fas fa-check"></i> Valider
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-times"></i> Rejeter
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .nav-tabs-custom .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }
        .nav-tabs-custom .nav-link.active {
            color: #0d6efd;
            border-bottom: 2px solid #0d6efd;
            background: transparent;
        }
        .table-edt th {
            background-color: #f8f9fa;
            text-align: center;
        }
        .table-edt td {
            height: 100px;
            vertical-align: top;
        }
        .edt-event {
            padding: 0.25rem;
            font-size: 0.85rem;
        }
        .card-header {
            border-bottom: 1px solid rgba(0,0,0,.05);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                .forEach(function (tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });
            
            // Tab functionality
            const tabElms = document.querySelectorAll('button[data-bs-toggle="tab"]');
            tabElms.forEach(tabElm => {
                tabElm.addEventListener('click', event => {
                    event.preventDefault();
                    const tab = new bootstrap.Tab(event.target);
                    tab.show();
                });
            });
        });
    </script>

</x-coordonnateur_layout>
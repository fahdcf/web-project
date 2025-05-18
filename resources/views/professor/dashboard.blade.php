<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Professeur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            color: white;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .card-stat {
            border-radius: 15px;
            border: none;
            box-shadow: 0 6px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        
        .card-stat:hover {
            transform: translateY(-5px);
        }
        
        .card-stat i {
            font-size: 2.5rem;
            opacity: 0.7;
        }
        
        .module-card {
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s;
        }
        
        .module-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .progress {
            height: 8px;
            border-radius: 4px;
        }
        
        .badge-pill {
            padding: 5px 10px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="dashboard-header p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2><i class="fas fa-chalkboard-teacher me-2"></i> Tableau de Bord</h2>
                    <p class="mb-0">Bienvenue, Pr. Ahmed ZEROUAL</p>
                </div>
                <div class="col-md-6 text-end">
                    <span class="badge bg-light text-dark p-2">
                        <i class="fas fa-calendar-alt me-1"></i> Année 2023/2024 - Semestre 2
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card card-stat bg-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-2">Modules</h6>
                                <h3 class="mb-0">4</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-book-open text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card card-stat bg-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-2">Charge Horaire</h6>
                                <h3 class="mb-0">128h</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clock text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card card-stat bg-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-2">Étudiants</h6>
                                <h3 class="mb-0">142</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card card-stat bg-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted mb-2">Notes à saisir</h6>
                                <h3 class="mb-0">2/4</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-edit text-warning"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="row">
            <!-- Modules List -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-list-ul me-2"></i> Mes Modules</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Module</th>
                                        <th>Filière</th>
                                        <th>Charge</th>
                                        <th>Statut Notes</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="module-card">
                                        <td>
                                            <strong>Algorithmique Avancée</strong>
                                            <div class="text-muted small">S4 - GROUPE A</div>
                                        </td>
                                        <td>Informatique</td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                CM: 20h | TD: 30h | TP: 15h
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <i class="fas fa-check-circle me-1"></i> Validées
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="module-card">
                                        <td>
                                            <strong>Base de Données</strong>
                                            <div class="text-muted small">S2 - GROUPE B</div>
                                        </td>
                                        <td>Informatique</td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                CM: 15h | TD: 25h | TP: 10h
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                                <i class="fas fa-exclamation-circle me-1"></i> En attente
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="module-card">
                                        <td>
                                            <strong>Programmation Web</strong>
                                            <div class="text-muted small">S4 - GROUPE C</div>
                                        </td>
                                        <td>Informatique</td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                CM: 10h | TD: 20h | TP: 30h
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger bg-opacity-10 text-danger">
                                                <i class="fas fa-times-circle me-1"></i> Manquantes
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-upload"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions & Calendar -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i> Actions Rapides</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2 mb-4">
                            <button class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i> Saisir les notes
                            </button>
                            <button class="btn btn-outline-success">
                                <i class="fas fa-download me-2"></i> Télécharger liste étudiants
                            </button>
                            <button class="btn btn-outline-info">
                                <i class="fas fa-calendar-plus me-2"></i> Ajouter disponibilité
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-file-pdf me-2"></i> Fiches module
                            </button>
                        </div>
                        
                        <hr>
                        
                        <h6 class="mb-3"><i class="fas fa-calendar-day me-2"></i> Prochains Événements</h6>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action border-0 rounded mb-2">
                                <div class="d-flex justify-content-between">
                                    <strong>Réunion département</strong>
                                    <span class="text-muted small">15 Mars</span>
                                </div>
                                <small class="text-muted">10:00 - Salle B12</small>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 rounded mb-2">
                                <div class="d-flex justify-content-between">
                                    <strong>Date limite notes</strong>
                                    <span class="text-muted small">20 Mars</span>
                                </div>
                                <small class="text-muted">Session normale</small>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 rounded">
                                <div class="d-flex justify-content-between">
                                    <strong>Commission pédagogique</strong>
                                    <span class="text-muted small">25 Mars</span>
                                </div>
                                <small class="text-muted">14:00 - Salle des profs</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i> Activité Récente</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-icon bg-success">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <span class="float-end text-muted small">Aujourd'hui, 10:30</span>
                                    <h6>Notes validées</h6>
                                    <p class="mb-0">Algorithmique Avancée - Session normale</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-info">
                                    <i class="fas fa-upload"></i>
                                </div>
                                <div class="timeline-content">
                                    <span class="float-end text-muted small">Hier, 14:15</span>
                                    <h6>Documents partagés</h6>
                                    <p class="mb-0">Support de cours - Programmation Web</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-warning">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div class="timeline-content">
                                    <span class="float-end text-muted small">12 Mars, 09:00</span>
                                    <h6>Rappel important</h6>
                                    <p class="mb-0">Date limite saisie notes approche</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .timeline {
            position: relative;
            padding-left: 50px;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }
        
        .timeline-icon {
            position: absolute;
            left: -40px;
            top: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .timeline-content {
            padding: 10px 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
        }
        
        .timeline-item:not(:last-child):before {
            content: '';
            position: absolute;
            left: -25px;
            top: 30px;
            height: 100%;
            width: 2px;
            background: #e9ecef;
        }
    </style>
</body>
</html>
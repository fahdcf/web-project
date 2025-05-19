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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .card-stat {
            border-radius: 15px;
            border: none;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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

{{-- 
<!-- Dashboard Overview Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Vue d'ensemble</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Charge horaire Card -->
                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-subtitle text-muted">Charge horaire</h6>
                                            <i class="fas fa-clock text-primary"></i>
                                        </div>
                                        <h3 class="mb-1">168h / 192h</h3>
                                        <p class="text-muted small">Heures sélectionnées</p>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 87%;" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modules en attente Card -->
                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-subtitle text-muted">Modules en attente</h6>
                                            <i class="fas fa-exclamation-circle text-warning"></i>
                                        </div>
                                        <h3 class="mb-1">3</h3>
                                        <p class="text-muted small">En attente d'approbation</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modules approuvés Card -->
                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-subtitle text-muted">Modules approuvés</h6>
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        <h3 class="mb-1">5</h3>
                                        <p class="text-muted small">Affectations confirmées</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Date limite Card -->
                            <div class="col-md-6 col-lg-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-subtitle text-muted">Date limite</h6>
                                            <i class="fas fa-calendar text-primary"></i>
                                        </div>
                                        <h3 class="mb-1">15 Juin 2025</h3>
                                        <p class="text-muted small">Pour les souhaits d'enseignement</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Warning Alert -->
                        <div class="alert alert-warning mt-4" role="alert">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <div>
                                    <h6 class="alert-heading mb-1">Attention</h6>
                                    <p class="mb-0">Votre charge horaire actuelle (168h) est inférieure au minimum requis (192h). Veuillez sélectionner des unités d'enseignement supplémentaires.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




<div class="card mt-3 bg-light">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-8 mb-3 mb-md-0">
                                            <h6 class="mb-2">Charge horaire sélectionnée</h6>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 87%;" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="d-flex justify-content-between mt-1">
                                                <small>168h sélectionnées</small>
                                                <small>Minimum requis: 192h</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <button class="btn btn-outline-secondary me-2">Réinitialiser</button>
                                            <button class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                             <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Instructions</h6>
                                    <ul class="mb-0">
                                        <li>Utilisez le modèle fourni dans l'onglet "Modèles"</li>
                                        <li>Assurez-vous que tous les champs obligatoires sont remplis</li>
                                        <li>Les notes doivent être comprises entre 0 et 20</li>
                                        <li>Formats acceptés : Excel (.xlsx, .xls) ou CSV</li>
                                        <li>Taille maximale du fichier : 5 Mo</li>
                                    </ul>
                                </div>
                            </div>




                             <!-- Teaching History Content -->
                        <div id="history" class="tab-content">
                            <div class="row mb-3">
                                <div class="col-md-8 mb-3 mb-md-0">
                                    <h5>Historique des enseignements</h5>
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <select class="form-select">
                                        <option selected>Toutes les années</option>
                                        <option>2023-2024</option>
                                        <option>2022-2023</option>
                                        <option>2021-2022</option>
                                    </select>
                                    <button class="btn btn-outline-primary">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Nom de l'unité</th>
                                            <th>Département</th>
                                            <th>Année</th>
                                            <th>Semestre</th>
                                            <th>Heures</th>
                                            <th>Étudiants</th>
                                            <th>Note moyenne</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>UE-2023-101</td>
                                            <td>Programmation Web</td>
                                            <td>Informatique</td>
                                            <td>2023-2024</td>
                                            <td>S1</td>
                                            <td>36h</td>
                                            <td>42</td>
                                            <td>14.2/20</td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-file-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>UE-2023-203</td>
                                            <td>Bases de données</td>
                                            <td>Informatique</td>
                                            <td>2023-2024</td>
                                            <td>S2</td>
                                            <td>48h</td>
                                            <td>38</td>
                                            <td>13.5/20</td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-file-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>UE-2022-101</td>
                                            <td>Programmation Web</td>
                                            <td>Informatique</td>
                                            <td>2022-2023</td>
                                            <td>S1</td>
                                            <td>36h</td>
                                            <td>45</td>
                                            <td>13.8/20</td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-file-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>UE-2022-203</td>
                                            <td>Bases de données</td>
                                            <td>Informatique</td>
                                            <td>2022-2023</td>
                                            <td>S2</td>
                                            <td>48h</td>
                                            <td>40</td>
                                            <td>12.9/20</td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-file-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>UE-2022-305</td>
                                            <td>Intelligence Artificielle</td>
                                            <td>Informatique</td>
                                            <td>2022-2023</td>
                                            <td>S3</td>
                                            <td>24h</td>
                                            <td>35</td>
                                            <td>14.5/20</td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-file-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>UE-2021-101</td>
                                            <td>Programmation Web</td>
                                            <td>Informatique</td>
                                            <td>2021-2022</td>
                                            <td>S1</td>
                                            <td>36h</td>
                                            <td>48</td>
                                            <td>13.2/20</td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-file-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-header bg-white">
                                    <h6 class="mb-0">Évolution de la charge d'enseignement</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="teachingChart" height="150"></canvas>
                                </div>
                            </div>
                            
                            <div class="card mt-4 bg-light">
                                <div class="card-body">
                                    <h6 class="mb-3">Résumé</h6>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card border-0 bg-white h-100">
                                                <div class="card-body text-center">
                                                    <h3 class="mb-1">228h</h3>
                                                    <p class="text-muted mb-0">Total des heures enseignées</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card border-0 bg-white h-100">
                                                <div class="card-body text-center">
                                                    <h3 class="mb-1">6</h3>
                                                    <p class="text-muted mb-0">Nombre total de modules</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card border-0 bg-white h-100">
                                                <div class="card-body text-center">
                                                    <h3 class="mb-1">248</h3>
                                                    <p class="text-muted mb-0">Nombre total d'étudiants</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

 <!-- Dashboard JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            const tabLinks = document.querySelectorAll('#dashboardTabs .nav-link');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all tabs
                    tabLinks.forEach(tab => tab.classList.remove('active'));
                    
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => content.classList.remove('active'));
                    
                    // Show the corresponding tab content
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
            
            // Select all checkbox functionality
            const selectAllCheckbox = document.getElementById('selectAll');
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('tbody .form-check-input');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });
            }
            
            // Initialize the teaching history chart
            const ctx = document.getElementById('teachingChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['2021-2022', '2022-2023', '2023-2024'],
                        datasets: [
                            {
                                label: 'Heures d\'enseignement',
                                data: [84, 144, 84],
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Nombre de modules',
                                data: [2, 3, 2],
                                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Heures'
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                grid: {
                                    drawOnChartArea: false
                                },
                                title: {
                                    display: true,
                                    text: 'Modules'
                                }
                            }
                        }
                    }
                });
            }
            
            // Add event listeners for the plus/minus buttons
            const addButtons = document.querySelectorAll('.btn-outline-success');
            const removeButtons = document.querySelectorAll('.btn-outline-danger');
            
            addButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const checkbox = row.querySelector('.form-check-input');
                    checkbox.checked = true;
                    row.classList.add('bg-light');
                    this.classList.remove('btn-outline-success');
                    this.classList.add('btn-outline-danger');
                    this.innerHTML = '<i class="fas fa-minus"></i>';
                    
                    // In a real application, you would update the total hours here
                    updateTotalHours();
                });
            });
            
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const checkbox = row.querySelector('.form-check-input');
                    checkbox.checked = false;
                    row.classList.remove('bg-light');
                    this.classList.remove('btn-outline-danger');
                    this.classList.add('btn-outline-success');
                    this.innerHTML = '<i class="fas fa-plus"></i>';
                    
                    // In a real application, you would update the total hours here
                    updateTotalHours();
                });
            });
            
            // Function to update total hours (mock implementation)
            function updateTotalHours() {
                // In a real application, this would calculate the actual total
                console.log('Updating total hours...');
            }
            
            // Search functionality for teaching units
            const searchInput = document.querySelector('.input-group input[type="text"]');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#teaching-units tbody tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
            
            // Department filter functionality
            const departmentSelect = document.querySelector('.form-select');
            if (departmentSelect) {
                departmentSelect.addEventListener('change', function() {
                    const department = this.value;
                    const rows = document.querySelectorAll('#teaching-units tbody tr');
                    
                    if (department === 'Tous les départements') {
                        rows.forEach(row => {
                            row.style.display = '';
                        });
                    } else {
                        rows.forEach(row => {
                            const deptCell = row.cells[3]; // Department is in the 4th column (index 3)
                            if (deptCell && deptCell.textContent === department) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    }
                });
            }
        });
    </script>

--}}

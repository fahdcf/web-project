





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

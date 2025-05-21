<!-- resources/views/coordinator/emploi/create.blade.php -->
<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <x-global_alert />

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-calendar-alt me-2"></i> Création d'Emploi du Temps - Semestre {{ $semester }}</h2>
            <div class="d-flex gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="semesterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Semestre {{ $semester }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="semesterDropdown">
                        @for ($i = 1; $i <= 6; $i++)
                            <li><a class="dropdown-item {{ $i == $semester ? 'active' : '' }}" 
                                  href="{{ route('emploi.create', ['semester' => $i]) }}">Semestre {{ $i }}</a></li>
                        @endfor
                    </ul>
                </div>
                <button type="button" class="btn btn-primary" id="saveEmploiBtn">
                    <i class="fas fa-save me-1"></i> Enregistrer
                </button>
            </div>
        </div>

        <div class="row">
            <!-- Panneau des modules -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Modules disponibles</h5>
                        <span class="badge bg-primary">S{{ $semester }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush module-list">
                            @if($modules->isEmpty())
                                <div class="text-center p-4">
                                    <i class="fas fa-info-circle text-muted mb-2" style="font-size: 2rem;"></i>
                                    <p class="mb-0">Aucun module disponible pour ce semestre</p>
                                </div>
                            @else
                                @foreach ($modules as $module)
                                    <div class="list-group-item module-item draggable" 
                                         data-module-id="{{ $module->id }}" 
                                         data-module-name="{{ $module->name }}"
                                         draggable="true">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $module->name }}</h6>
                                                <p class="mb-1 text-muted small">{{ $module->code ?? 'Code N/A' }}</p>
                                            </div>
                                            <div class="module-badges">
                                                    <span class="badge bg-info">CM: 1</span>
                                                    <span class="badge bg-success">TD: {{ $module->nbr_groupes_td }}</span>
                                                    <span class="badge bg-danger">TP: {{ $module->nbr_groupes_tp }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Glisser-déposer les modules</small>
                            <div>
                                <span class="badge bg-info me-1">CM</span>
                                <span class="badge bg-success me-1">TD</span>
                                <span class="badge bg-danger">TP</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grille d'emploi du temps -->
            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0" id="emploiTitle">Nouvel Emploi du Temps</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="showRoomSwitch" checked>
                                <label class="form-check-label" for="showRoomSwitch">Afficher les salles</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="timetable-container">
                            <div id="calendar-grid" class="table-responsive"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire caché pour la soumission -->
        <form id="emploi-form" method="POST" action="{{ route('emploi.store') }}" class="d-none">
            @csrf
            <input type="hidden" name="filiere_id" value="{{ $filiere->id }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            <input type="hidden" name="academic_year" value="{{ now()->year }}-{{ now()->year + 1 }}">
            <input type="hidden" name="name" id="emploi_name" value="Emploi du temps S{{ $semester }} {{ now()->year }}-{{ now()->year + 1 }}">
            <div id="seances-container"></div>
        </form>
    </div>

    <!-- Modal de configuration de séance -->
    <div class="modal fade" id="sessionModal" tabindex="-1" aria-labelledby="sessionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="sessionModalLabel">
                        <i class="fas fa-plus-circle me-2"></i> Ajouter une séance
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info" id="moduleInfo">
                        <h6 class="alert-heading" id="moduleName"></h6>
                    </div>

                    <div class="mb-3">
                        <label for="sessionType" class="form-label">Type de séance</label>
                        <select class="form-select" id="sessionType" required>
                            <option value="CM">Cours Magistral (CM)</option>
                            <option value="TD">Travaux Dirigés (TD)</option>
                            <option value="TP">Travaux Pratiques (TP)</option>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sessionJour" class="form-label">Jour</label>
                            <select class="form-select" id="sessionJour" required>
                                <option value="Lundi">Lundi</option>
                                <option value="Mardi">Mardi</option>
                                <option value="Mercredi">Mercredi</option>
                                <option value="Jeudi">Jeudi</option>
                                <option value="Vendredi">Vendredi</option>
                                <option value="Samedi">Samedi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="sessionGroupe" class="form-label">Groupe</label>
                            <input type="text" class="form-control" id="sessionGroupe" placeholder="ex: TD1, TP2">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sessionHeureDebut" class="form-label">Heure de début</label>
                            <input type="time" class="form-control" id="sessionHeureDebut" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sessionHeureFin" class="form-label">Heure de fin</label>
                            <input type="time" class="form-control" id="sessionHeureFin" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="sessionSalle" class="form-label">Salle</label>
                        <input type="text" class="form-control" id="sessionSalle" placeholder="ex: Amphi A, Salle 101">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="saveSessionBtn">Ajouter</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Styles pour les modules */
        .module-list {
            max-height: 500px;
            overflow-y: auto;
        }
        
        .module-item {
            cursor: grab;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        
        .module-item:hover {
            background-color: #f8f9fa;
            border-left-color: #0d6efd;
        }
        
        .module-item.dragging {
            opacity: 0.5;
            background-color: #e9ecef;
        }
        
        .module-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }
        
        /* Styles pour la grille d'emploi du temps */
        .timetable-container {
            overflow-x: auto;
        }
        
        .timetable {
            min-width: 900px;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .timetable th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 10;
            padding: 0.75rem;
            text-align: center;
            font-weight: 600;
            border: 1px solid #dee2e6;
        }
        
        .timetable td {
            border: 1px solid #dee2e6;
            padding: 0;
            height: 30px; /* Hauteur réduite pour les créneaux de 30 minutes */
            vertical-align: top;
            position: relative;
        }
        
        .time-cell {
            width: 80px;
            text-align: center;
            font-weight: 500;
            background-color: #f8f9fa;
            position: sticky;
            left: 0;
            z-index: 5;
        }
        
        .dropzone {
            height: 100%;
            width: 100%;
            min-height: 30px;
            transition: background 0.2s;
            position: relative;
        }
        
        .dropzone.drop-hover {
            background-color: rgba(13, 110, 253, 0.1);
        }
        
        .dropzone.occupied {
            background-color: rgba(0, 0, 0, 0.03);
        }
        
        .dropzone.shared {
            display: flex;
            flex-direction: row;
        }
        
        /* Styles pour les séances */
        .seance {
            position: absolute;
            left: 0;
            right: 0;
            padding: 5px;
            border-radius: 4px;
            margin: 2px;
            font-size: 0.8rem;
            overflow: hidden;
            cursor: move;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            z-index: 1;
            user-select: none;
        }
        
        .seance:hover {
            z-index: 2;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .seance.CM {
            background-color: rgba(13, 202, 240, 0.2);
            border-left: 3px solid #0dcaf0;
        }
        
        .seance.TD {
            background-color: rgba(25, 135, 84, 0.2);
            border-left: 3px solid #198754;
        }
        
        .seance.TP {
            background-color: rgba(220, 53, 69, 0.2);
            border-left: 3px solid #dc3545;
        }
        
        .seance-title {
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .seance-time {
            font-size: 0.75rem;
            color: #6c757d;
        }
        
        .seance-location {
            font-size: 0.75rem;
            color: #6c757d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .seance-actions {
            position: absolute;
            top: 2px;
            right: 2px;
            display: none;
        }
        
        .seance:hover .seance-actions {
            display: block;
        }
        
        .seance-delete {
            background: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            line-height: 1;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        /* Styles pour les badges */
        .badge {
            font-weight: normal;
            font-size: 0.7rem;
        }
        
        /* Styles pour le redimensionnement */
        .resize-handle {
            position: absolute;
            width: 100%;
            height: 8px;
            bottom: 0;
            left: 0;
            cursor: ns-resize;
            background: rgba(0, 0, 0, 0.05);
            border-radius: 0 0 4px 4px;
        }
        
        .resize-handle:hover, .resize-handle.active {
            background: rgba(0, 0, 0, 0.1);
        }
        
        /* Styles pour les séances partagées */
        .shared-container {
            display: flex;
            width: 100%;
            height: 100%;
        }
        
        .shared-slot {
            flex: 1;
            height: 100%;
            position: relative;
            border-right: 1px dashed #dee2e6;
        }
        
        .shared-slot:last-child {
            border-right: none;
        }
        
        /* Indicateur de temps lors du redimensionnement */
        .time-indicator {
            position: absolute;
            right: 5px;
            bottom: 5px;
            background: rgba(255, 255, 255, 0.8);
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 0.7rem;
            color: #495057;
            z-index: 3;
            display: none;
        }
        
        .seance:hover .time-indicator {
            display: block;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables globales
            let seances = [];
            let currentModuleId = null;
            let currentCell = null;
            let resizing = false;
            let resizeStartY = 0;
            let resizeStartHeight = 0;
            let resizeElement = null;
            let resizeSeanceId = null;
            let cellHeight = 30; // Hauteur d'une cellule en pixels
            
            // Initialiser la grille
            initializeGrid();
            
            // Initialiser le drag & drop
            initializeDragAndDrop();
            
            // Gestionnaire pour le bouton de sauvegarde
            document.getElementById('saveEmploiBtn').addEventListener('click', function() {
                if (seances.length === 0) {
                    alert('Veuillez ajouter au moins une séance à l\'emploi du temps.');
                    return;
                }
                
                // Demander le nom de l'emploi du temps
                const defaultName = `Emploi du temps S{{ $semester }} {{ now()->year }}-{{ now()->year + 1 }}`;
                const name = prompt('Nom de l\'emploi du temps:', defaultName);
                
                if (!name) return;
                
                // Mettre à jour le nom
                document.getElementById('emploi_name').value = name;
                
                // Générer les inputs pour les séances
                const container = document.getElementById('seances-container');
                container.innerHTML = '';
                
                seances.forEach((seance, index) => {
                    const moduleIdInput = document.createElement('input');
                    moduleIdInput.type = 'hidden';
                    moduleIdInput.name = `seances[${index}][module_id]`;
                    moduleIdInput.value = seance.moduleId;
                    container.appendChild(moduleIdInput);
                    
                    const typeInput = document.createElement('input');
                    typeInput.type = 'hidden';
                    typeInput.name = `seances[${index}][type]`;
                    typeInput.value = seance.type;
                    container.appendChild(typeInput);
                    
                    const jourInput = document.createElement('input');
                    jourInput.type = 'hidden';
                    jourInput.name = `seances[${index}][jour]`;
                    jourInput.value = seance.jour;
                    container.appendChild(jourInput);
                    
                    const heureDebutInput = document.createElement('input');
                    heureDebutInput.type = 'hidden';
                    heureDebutInput.name = `seances[${index}][heure_debut]`;
                    heureDebutInput.value = seance.heureDebut;
                    container.appendChild(heureDebutInput);
                    
                    const heureFinInput = document.createElement('input');
                    heureFinInput.type = 'hidden';
                    heureFinInput.name = `seances[${index}][heure_fin]`;
                    heureFinInput.value = seance.heureFin;
                    container.appendChild(heureFinInput);
                    
                    const salleInput = document.createElement('input');
                    salleInput.type = 'hidden';
                    salleInput.name = `seances[${index}][salle]`;
                    salleInput.value = seance.salle || '';
                    container.appendChild(salleInput);
                    
                    const groupeInput = document.createElement('input');
                    groupeInput.type = 'hidden';
                    groupeInput.name = `seances[${index}][groupe]`;
                    groupeInput.value = seance.groupe || '';
                    container.appendChild(groupeInput);
                    
                    // Ajouter la position pour les séances partagées
                    if (seance.position !== undefined) {
                        const positionInput = document.createElement('input');
                        positionInput.type = 'hidden';
                        positionInput.name = `seances[${index}][position]`;
                        positionInput.value = seance.position;
                        container.appendChild(positionInput);
                    }
                });
                
                // Soumettre le formulaire
                document.getElementById('emploi-form').submit();
            });
            
            // Gestionnaire pour le bouton de sauvegarde de séance
            document.getElementById('saveSessionBtn').addEventListener('click', function() {
                const type = document.getElementById('sessionType').value;
                const jour = document.getElementById('sessionJour').value;
                const heureDebut = document.getElementById('sessionHeureDebut').value;
                const heureFin = document.getElementById('sessionHeureFin').value;
                const salle = document.getElementById('sessionSalle').value;
                const groupe = document.getElementById('sessionGroupe').value;
                
                // Validation
                if (!type || !jour || !heureDebut || !heureFin) {
                    alert('Veuillez remplir tous les champs obligatoires.');
                    return;
                }
                
                if (heureDebut >= heureFin) {
                    alert('L\'heure de fin doit être postérieure à l\'heure de début.');
                    return;
                }
                
                // Vérifier les chevauchements
                const existingSeances = getSeancesInCell(jour, heureDebut);
                
                // Créer la séance
                const moduleElement = document.querySelector(`.module-item[data-module-id="${currentModuleId}"]`);
                const moduleName = moduleElement.dataset.moduleName;
                
                const seance = {
                    id: Date.now(), // ID temporaire
                    moduleId: currentModuleId,
                    moduleName: moduleName,
                    type: type,
                    jour: jour,
                    heureDebut: heureDebut,
                    heureFin: heureFin,
                    salle: salle,
                    groupe: groupe
                };
                
                // Si la cellule est déjà occupée, configurer le partage
                if (existingSeances.length > 0) {
                    // Ajouter la position pour le partage
                    seance.position = existingSeances.length;
                    
                    // Mettre à jour les séances existantes si nécessaire
                    existingSeances.forEach((existingSeance, index) => {
                        if (existingSeance.position === undefined) {
                            existingSeance.position = index;
                        }
                    });
                }
                
                // Ajouter à la liste
                seances.push(seance);
                
                // Fermer le modal
                bootstrap.Modal.getInstance(document.getElementById('sessionModal')).hide();
                
                // Rafraîchir l'affichage
                renderSeances();
            });
            
            // Fonction pour initialiser la grille
            function initializeGrid() {
                const grid = document.getElementById('calendar-grid');
                const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                const hours = [];
                
                // Générer les heures de 8h à 19h avec des intervalles de 30 minutes
                for (let h = 8; h < 19; h++) {
                    hours.push(`${h.toString().padStart(2, '0')}:00`);
                    hours.push(`${h.toString().padStart(2, '0')}:30`);
                }
                
                // Créer la table
                let table = document.createElement('table');
                table.className = 'table table-bordered timetable';
                
                // Créer l'en-tête
                let thead = document.createElement('thead');
                let headerRow = document.createElement('tr');
                
                // Cellule vide pour le coin supérieur gauche
                let cornerCell = document.createElement('th');
                cornerCell.className = 'time-cell';
                headerRow.appendChild(cornerCell);
                
                // Cellules pour les jours
                days.forEach(day => {
                    let th = document.createElement('th');
                    th.textContent = day;
                    headerRow.appendChild(th);
                });
                
                thead.appendChild(headerRow);
                table.appendChild(thead);
                
                // Créer le corps
                let tbody = document.createElement('tbody');
                
                hours.forEach(hour => {
                    let row = document.createElement('tr');
                    
                    // Cellule pour l'heure
                    let timeCell = document.createElement('td');
                    timeCell.className = 'time-cell';
                    timeCell.textContent = hour;
                    row.appendChild(timeCell);
                    
                    // Cellules pour les jours
                    days.forEach(day => {
                        let cell = document.createElement('td');
                        let dropzone = document.createElement('div');
                        dropzone.className = 'dropzone';
                        dropzone.dataset.jour = day;
                        dropzone.dataset.heure = hour;
                        cell.appendChild(dropzone);
                        row.appendChild(cell);
                    });
                    
                    tbody.appendChild(row);
                });
                
                table.appendChild(tbody);
                grid.appendChild(table);
            }
            
            // Fonction pour initialiser le drag & drop
            function initializeDragAndDrop() {
                const modules = document.querySelectorAll('.draggable');
                const dropzones = document.querySelectorAll('.dropzone');
                
                modules.forEach(module => {
                    module.addEventListener('dragstart', function(e) {
                        e.dataTransfer.setData('moduleId', this.dataset.moduleId);
                        this.classList.add('dragging');
                    });
                    
                    module.addEventListener('dragend', function() {
                        this.classList.remove('dragging');
                    });
                });
                
                dropzones.forEach(zone => {
                    zone.addEventListener('dragover', function(e) {
                        e.preventDefault();
                        this.classList.add('drop-hover');
                    });
                    
                    zone.addEventListener('dragleave', function() {
                        this.classList.remove('drop-hover');
                    });
                    
                    zone.addEventListener('drop', function(e) {
                        e.preventDefault();
                        this.classList.remove('drop-hover');
                        
                        const moduleId = e.dataTransfer.getData('moduleId');
                        currentModuleId = moduleId;
                        currentCell = this;
                        
                        // Ouvrir le modal
                        openSessionModal(moduleId, this.dataset.jour, this.dataset.heure);
                    });
                });
                
                // Gestionnaires pour le redimensionnement
                document.addEventListener('mousedown', function(e) {
                    if (e.target.classList.contains('resize-handle')) {
                        resizing = true;
                        resizeStartY = e.clientY;
                        resizeElement = e.target.parentElement;
                        resizeSeanceId = resizeElement.dataset.id;
                        resizeStartHeight = resizeElement.offsetHeight;
                        resizeElement.classList.add('resizing');
                        
                        // Afficher l'indicateur de temps
                        const timeIndicator = resizeElement.querySelector('.time-indicator');
                        if (timeIndicator) {
                            timeIndicator.style.display = 'block';
                        }
                        
                        e.preventDefault();
                    }
                });
                
                document.addEventListener('mousemove', function(e) {
                    if (resizing) {
                        const deltaY = e.clientY - resizeStartY;
                        const newHeight = Math.max(cellHeight, resizeStartHeight + deltaY);
                        
                        // Arrondir à la hauteur de cellule la plus proche
                        const cellsCount = Math.round(newHeight / cellHeight);
                        const snappedHeight = cellsCount * cellHeight;
                        
                        resizeElement.style.height = snappedHeight + 'px';
                        
                        // Mettre à jour l'indicateur de temps
                        updateTimeIndicator(resizeElement, snappedHeight);
                        
                        e.preventDefault();
                    }
                });
                
                document.addEventListener('mouseup', function() {
                    if (resizing) {
                        resizing = false;
                        
                        // Mettre à jour l'heure de fin de la séance
                        const seance = seances.find(s => s.id == resizeSeanceId);
                        if (seance) {
                            const cellsCount = Math.round(resizeElement.offsetHeight / cellHeight);
                            const durationMinutes = cellsCount * 30; // 30 minutes par cellule
                            
                            // Calculer la nouvelle heure de fin
                            const startTime = new Date(`2000-01-01T${seance.heureDebut}`);
                            const endTime = new Date(startTime.getTime() + durationMinutes * 60 * 1000);
                            
                            const hours = endTime.getHours().toString().padStart(2, '0');
                            const minutes = endTime.getMinutes().toString().padStart(2, '0');
                            seance.heureFin = `${hours}:${minutes}`;
                            
                            // Rafraîchir l'affichage
                            renderSeances();
                        }
                        
                        resizeElement.classList.remove('resizing');
                        resizeElement = null;
                    }
                });
            }
            
            // Fonction pour mettre à jour l'indicateur de temps
            function updateTimeIndicator(element, height) {
                const timeIndicator = element.querySelector('.time-indicator');
                if (!timeIndicator) return;
                
                const seanceId = element.dataset.id;
                const seance = seances.find(s => s.id == seanceId);
                if (!seance) return;
                
                const cellsCount = Math.round(height / cellHeight);
                const durationMinutes = cellsCount * 30; // 30 minutes par cellule
                
                // Calculer la nouvelle heure de fin
                const startTime = new Date(`2000-01-01T${seance.heureDebut}`);
                const endTime = new Date(startTime.getTime() + durationMinutes * 60 * 1000);
                
                const hours = endTime.getHours().toString().padStart(2, '0');
                const minutes = endTime.getMinutes().toString().padStart(2, '0');
                
                timeIndicator.textContent = `${seance.heureDebut} - ${hours}:${minutes}`;
            }
            
            // Fonction pour ouvrir le modal de séance
            function openSessionModal(moduleId, jour, heure) {
                const modal = document.getElementById('sessionModal');
                const moduleElement = document.querySelector(`.module-item[data-module-id="${moduleId}"]`);
                const moduleName = moduleElement.dataset.moduleName;
                
                // Mettre à jour les informations du module
                document.getElementById('moduleName').textContent = moduleName;
                
                // Pré-remplir les champs
                document.getElementById('sessionJour').value = jour;
                document.getElementById('sessionHeureDebut').value = heure;
                
                // Calculer l'heure de fin (par défaut, 1h30 après)
                const [hours, minutes] = heure.split(':').map(Number);
                let endHours = hours;
                let endMinutes = minutes + 90; // 1h30 en minutes
                
                if (endMinutes >= 60) {
                    endHours += Math.floor(endMinutes / 60);
                    endMinutes = endMinutes % 60;
                }
                
                const endTime = `${endHours.toString().padStart(2, '0')}:${endMinutes.toString().padStart(2, '0')}`;
                document.getElementById('sessionHeureFin').value = endTime;
                
                // Ouvrir le modal
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            }
            
            // Fonction pour obtenir les séances dans une cellule
            function getSeancesInCell(jour, heure) {
                return seances.filter(seance => 
                    seance.jour === jour && 
                    seance.heureDebut === heure
                );
            }
            
            // Fonction pour afficher les séances
            function renderSeances() {
                // Supprimer toutes les séances affichées
                document.querySelectorAll('.seance').forEach(el => el.remove());
                document.querySelectorAll('.shared-container').forEach(el => el.remove());
                
                // Réinitialiser les classes des dropzones
                document.querySelectorAll('.dropzone').forEach(zone => {
                    zone.classList.remove('occupied', 'shared');
                });
                
                // Regrouper les séances par cellule
                const seancesByCell = {};
                
                seances.forEach(seance => {
                    const cellKey = `${seance.jour}-${seance.heureDebut}`;
                    if (!seancesByCell[cellKey]) {
                        seancesByCell[cellKey] = [];
                    }
                    seancesByCell[cellKey].push(seance);
                });
                
                // Afficher chaque groupe de séances
                for (const cellKey in seancesByCell) {
                    const cellSeances = seancesByCell[cellKey];
                    const [jour, heure] = cellKey.split('-');
                    
                    // Trouver la cellule correspondante
                    const cell = document.querySelector(`.dropzone[data-jour="${jour}"][data-heure="${heure}"]`);
                    if (!cell) continue;
                    
                    // Marquer la cellule comme occupée
                    cell.classList.add('occupied');
                    
                    if (cellSeances.length === 1) {
                        // Cas simple: une seule séance dans la cellule
                        renderSingleSeance(cellSeances[0], cell);
                    } else {
                        // Cas complexe: plusieurs séances dans la cellule
                        renderSharedSeances(cellSeances, cell);
                    }
                }
            }
            
            // Fonction pour afficher une seule séance
            function renderSingleSeance(seance, cell) {
                // Calculer la hauteur en fonction de la durée
                const startTime = new Date(`2000-01-01T${seance.heureDebut}`);
                const endTime = new Date(`2000-01-01T${seance.heureFin}`);
                const durationMinutes = (endTime - startTime) / (1000 * 60);
                const cellsCount = Math.ceil(durationMinutes / 30); // Nombre de cellules de 30 minutes
                const heightPixels = cellsCount * cellHeight;
                
                // Créer l'élément de séance
                const seanceElement = document.createElement('div');
                seanceElement.className = `seance ${seance.type}`;
                seanceElement.style.height = `${heightPixels}px`;
                seanceElement.dataset.id = seance.id;
                
                // Contenu de la séance
                let content = `
                    <div class="seance-title">${seance.moduleName} - ${seance.type}${seance.groupe ? ' ' + seance.groupe : ''}</div>
                    <div class="seance-time">${seance.heureDebut} - ${seance.heureFin}</div>
                `;
                
                if (seance.salle) {
                    content += `<div class="seance-location"><i class="fas fa-map-marker-alt me-1"></i>${seance.salle}</div>`;
                }
                
                // Bouton de suppression
                content += `
                    <div class="seance-actions">
                        <button type="button" class="seance-delete" data-id="${seance.id}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="time-indicator">${seance.heureDebut} - ${seance.heureFin}</div>
                    <div class="resize-handle"></div>
                `;
                
                seanceElement.innerHTML = content;
                
                // Ajouter à la cellule
                cell.parentNode.appendChild(seanceElement);
                
                // Ajouter les gestionnaires d'événements pour la suppression
                seanceElement.querySelector('.seance-delete').addEventListener('click', function(e) {
                    e.stopPropagation();
                    const id = this.dataset.id;
                    
                    if (confirm('Êtes-vous sûr de vouloir supprimer cette séance ?')) {
                        // Supprimer la séance
                        seances = seances.filter(seance => seance.id != id);
                        
                        // Rafraîchir l'affichage
                        renderSeances();
                    }
                });
                
                // Ajouter la possibilité de déplacer la séance
                seanceElement.addEventListener('mousedown', function(e) {
                    // Ne pas déclencher le déplacement si on clique sur la poignée de redimensionnement
                    if (e.target.classList.contains('resize-handle') || e.target.classList.contains('seance-delete')) {
                        return;
                    }
                    
                    const seanceId = this.dataset.id;
                    const seance = seances.find(s => s.id == seanceId);
                    if (!seance) return;
                    
                    // Créer un élément fantôme pour le drag
                    const ghost = this.cloneNode(true);
                    ghost.style.opacity = '0.5';
                    ghost.style.position = 'absolute';
                    ghost.style.zIndex = '1000';
                    ghost.style.pointerEvents = 'none';
                    document.body.appendChild(ghost);
                    
                    // Position initiale
                    const startX = e.clientX;
                    const startY = e.clientY;
                    ghost.style.left = (e.clientX - 20) + 'px';
                    ghost.style.top = (e.clientY - 20) + 'px';
                    
                    // Fonction de déplacement
                    const moveHandler = function(e) {
                        ghost.style.left = (e.clientX - 20) + 'px';
                        ghost.style.top = (e.clientY - 20) + 'px';
                        
                        // Trouver la dropzone sous le curseur
                        const elementsUnderCursor = document.elementsFromPoint(e.clientX, e.clientY);
                        const dropzone = elementsUnderCursor.find(el => el.classList.contains('dropzone'));
                        
                        // Réinitialiser les surlignages
                        document.querySelectorAll('.dropzone.drop-hover').forEach(zone => {
                            zone.classList.remove('drop-hover');
                        });
                        
                        // Surligner la dropzone cible
                        if (dropzone) {
                            dropzone.classList.add('drop-hover');
                        }
                    };
                    
                    // Fonction de fin de déplacement
                    const upHandler = function(e) {
                        document.removeEventListener('mousemove', moveHandler);
                        document.removeEventListener('mouseup', upHandler);
                        
                        // Supprimer le fantôme
                        document.body.removeChild(ghost);
                        
                        // Trouver la dropzone sous le curseur
                        const elementsUnderCursor = document.elementsFromPoint(e.clientX, e.clientY);
                        const dropzone = elementsUnderCursor.find(el => el.classList.contains('dropzone'));
                        
                        // Réinitialiser les surlignages
                        document.querySelectorAll('.dropzone.drop-hover').forEach(zone => {
                            zone.classList.remove('drop-hover');
                        });
                        
                        // Si on a trouvé une dropzone, déplacer la séance
                        if (dropzone) {
                            const newJour = dropzone.dataset.jour;
                            const newHeure = dropzone.dataset.heure;
                            
                            // Mettre à jour la séance
                            seance.jour = newJour;
                            seance.heureDebut = newHeure;
                            
                            // Recalculer l'heure de fin
                            const startTime = new Date(`2000-01-01T${newHeure}`);
                            const durationMinutes = (new Date(`2000-01-01T${seance.heureFin}`) - new Date(`2000-01-01T${seance.heureDebut}`)) / (1000 * 60);
                            const endTime = new Date(startTime.getTime() + durationMinutes * 60 * 1000);
                            
                            const hours = endTime.getHours().toString().padStart(2, '0');
                            const minutes = endTime.getMinutes().toString().padStart(2, '0');
                            seance.heureFin = `${hours}:${minutes}`;
                            
                            // Rafraîchir l'affichage
                            renderSeances();
                        }
                    };
                    
                    document.addEventListener('mousemove', moveHandler);
                    document.addEventListener('mouseup', upHandler);
                });
            }
            
            // Fonction pour afficher des séances partagées
            function renderSharedSeances(seances, cell) {
                // Marquer la cellule comme partagée
                cell.classList.add('shared');
                
                // Créer un conteneur pour les séances partagées
                const container = document.createElement('div');
                container.className = 'shared-container';
                
                // Calculer la hauteur maximale nécessaire
                let maxDurationMinutes = 0;
                
                seances.forEach(seance => {
                    const startTime = new Date(`2000-01-01T${seance.heureDebut}`);
                    const endTime = new Date(`2000-01-01T${seance.heureFin}`);
                    const durationMinutes = (endTime - startTime) / (1000 * 60);
                    maxDurationMinutes = Math.max(maxDurationMinutes, durationMinutes);
                });
                
                const cellsCount = Math.ceil(maxDurationMinutes / 30);
                const containerHeight = cellsCount * cellHeight;
                
                // Créer un slot pour chaque séance
                seances.forEach((seance, index) => {
                    const slot = document.createElement('div');
                    slot.className = 'shared-slot';
                    
                    // Créer l'élément de séance
                    const seanceElement = document.createElement('div');
                    seanceElement.className = `seance ${seance.type}`;
                    seanceElement.style.height = `${containerHeight}px`;
                    seanceElement.style.width = `100%`;
                    seanceElement.dataset.id = seance.id;
                    
                    // Contenu de la séance (version simplifiée pour l'espace réduit)
                    let content = `
                        <div class="seance-title">${seance.type}${seance.groupe ? ' ' + seance.groupe : ''}</div>
                        <div class="seance-time">${seance.heureDebut} - ${seance.heureFin}</div>
                    `;
                    
                    if (seance.salle) {
                        content += `<div class="seance-location">${seance.salle}</div>`;
                    }
                    
                    // Bouton de suppression
                    content += `
                        <div class="seance-actions">
                            <button type="button" class="seance-delete" data-id="${seance.id}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    
                    seanceElement.innerHTML = content;
                    slot.appendChild(seanceElement);
                    container.appendChild(slot);
                    
                    // Ajouter les gestionnaires d'événements pour la suppression
                    seanceElement.querySelector('.seance-delete').addEventListener('click', function(e) {
                        e.stopPropagation();
                        const id = this.dataset.id;
                        
                        if (confirm('Êtes-vous sûr de vouloir supprimer cette séance ?')) {
                            // Supprimer la séance
                            seances = seances.filter(seance => seance.id != id);
                            
                            // Rafraîchir l'affichage
                            renderSeances();
                        }
                    });
                });
                
                // Ajouter le conteneur à la cellule
                cell.parentNode.appendChild(container);
            }
            
            // Gestionnaire pour l'affichage des salles
            document.getElementById('showRoomSwitch').addEventListener('change', function() {
                const showRooms = this.checked;
                document.querySelectorAll('.seance-location').forEach(el => {
                    el.style.display = showRooms ? 'block' : 'none';
                });
            });
        });
    </script>
</x-coordonnateur_layout>
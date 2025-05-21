<!-- resources/views/coordinator/schedules/builder.blade.php -->
<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <x-global_alert />

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-calendar-alt me-2"></i> Créer un Emploi du Temps</h2>
            <div>
                <button class="btn btn-primary" id="createScheduleBtn">
                    <i class="fas fa-save me-1"></i> Enregistrer l'Emploi du Temps
                </button>
            </div>
        </div>

        <div class="row">
            <!-- Panneau des modules -->
            <div class="col-md-3">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Modules (S{{ $semester }})</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                id="semesterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Semestre {{ $semester }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="semesterDropdown">
                                @for ($i = 1; $i <= 6; $i++)
                                    <li>
                                        <a class="dropdown-item {{ $i == $semester ? 'active' : '' }}"
                                            href="{{ route('coordinator.schedules.builder', ['semester' => $i]) }}">
                                            Semestre {{ $i }}
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="card-body module-list">
                        @if ($modules->isEmpty())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> Aucun module trouvé pour ce semestre.
                            </div>
                        @else
                            @foreach ($modules as $module)
                                <div class="module-item" data-module-id="{{ $module->id }}"
                                    data-module-name="{{ $module->name }}" data-module-code="{{ $module->code }}"
                                    data-cm-hours="{{ $module->cm_hours }}" data-td-hours="{{ $module->td_hours }}"
                                    data-tp-hours="{{ $module->tp_hours }}">
                                    <div class="module-header">
                                        <strong>{{ $module->code }}</strong>
                                        <div class="module-hours">
                                            @if ($module->cm_hours)
                                                <span class="badge bg-info">CM: {{ $module->cm_hours }}h</span>
                                            @endif
                                            @if ($module->td_hours)
                                                <span class="badge bg-warning text-dark">TD:
                                                    {{ $module->td_hours }}h</span>
                                            @endif
                                            @if ($module->tp_hours)
                                                <span class="badge bg-danger">TP: {{ $module->tp_hours }}h</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="module-name">{{ $module->name }}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Informations</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <i class="fas fa-info-circle me-1 text-primary"></i>
                            Faites glisser les modules vers la grille d'emploi du temps.
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-info-circle me-1 text-primary"></i>
                            Cliquez sur une séance pour la modifier ou la supprimer.
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-info-circle me-1 text-primary"></i>
                            N'oubliez pas d'enregistrer votre emploi du temps.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Grille d'emploi du temps -->
            <div class="col-md-9">
                <div class="card shadow">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <span id="scheduleTitle">Nouvel Emploi du Temps</span>
                        </h5>
                        <div id="scheduleInfo" class="small text-muted" style="display: none;">
                            Semestre <span id="scheduleSemester">{{ $semester }}</span> |
                            <span id="scheduleYear"></span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="timetable-container">
                            <table class="table table-bordered timetable">
                                <thead>
                                    <tr>
                                        <th width="8%">Horaire</th>
                                        @foreach ($days as $dayKey => $dayName)
                                            <th width="15.3%">{{ $dayName }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($timeSlots as $timeSlot)
                                        <tr>
                                            <td class="time-slot">{{ $timeSlot }}</td>
                                            @foreach ($days as $dayKey => $dayName)
                                                <td class="schedule-cell" data-day="{{ $dayKey }}"
                                                    data-time="{{ $timeSlot }}"></td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de création d'emploi du temps -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-plus me-2"></i> Créer un Emploi du Temps
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="scheduleName" class="form-label">Nom de l'emploi du temps</label>
                        <input type="text" class="form-control" id="scheduleName" required>
                        <div class="form-text">Exemple: "Emploi du temps S{{ $semester }} Informatique 2023-2024"
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="scheduleSemesterInput" class="form-label">Semestre</label>
                        <select class="form-select" id="scheduleSemesterInput" required>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ $i == $semester ? 'selected' : '' }}>
                                    S{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="scheduleYear" class="form-label">Année Académique</label>
                        <select class="form-select" id="scheduleYearInput" required>
                            <option value="2023-2024">2023-2024</option>
                            <option value="2024-2025">2024-2025</option>
                            <option value="2025-2026">2025-2026</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="saveScheduleBtn">
                        <i class="fas fa-save me-1"></i> Créer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de session -->
    <!-- Remplacer la partie du modal de session dans la vue -->
    <div class="modal fade" id="sessionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i> <span id="sessionModalTitle">Ajouter une Séance</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="sessionItemId">
                    <input type="hidden" id="sessionModuleId">

                    <div class="alert alert-info" id="sessionModuleInfo">
                        <strong>Module:</strong> <span id="sessionModuleName"></span>
                        <div id="sessionModuleHours" class="mt-1"></div>
                        <div class="mt-1 small text-muted">
                            <i class="fas fa-info-circle"></i> Les heures affichées sont le volume total du module pour
                            le semestre.
                            Vous pouvez définir librement la durée de chaque séance ci-dessous.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="sessionDay" class="form-label">Jour</label>
                        <select class="form-select" id="sessionDay" required>
                            @foreach ($days as $dayKey => $dayName)
                                <option value="{{ $dayKey }}">{{ $dayName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="sessionStartTime" class="form-label">Heure de début</label>
                            <input type="time" class="form-control" id="sessionStartTime" required>
                        </div>
                        <div class="col">
                            <label for="sessionEndTime" class="form-label">Heure de fin</label>
                            <input type="time" class="form-control" id="sessionEndTime" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="sessionDuration" class="form-label">Durée de la séance (heures)</label>
                        <input type="number" class="form-control" id="sessionDuration" min="0.5"
                            max="8" step="0.5" value="1.5">
                        <div class="form-text">Cette durée sera comptabilisée dans le volume horaire total du module.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="sessionGroupType" class="form-label">Type de groupe</label>
                        <select class="form-select" id="sessionGroupType" required>
                            <option value="cm">Cours Magistral (CM)</option>
                            <option value="td">Travaux Dirigés (TD)</option>
                            <option value="tp">Travaux Pratiques (TP)</option>
                        </select>
                    </div>

                    <div class="mb-3" id="sessionGroupNumberContainer" style="display: none;">
                        <label for="sessionGroupNumber" class="form-label">Numéro de groupe</label>
                        <input type="number" class="form-control" id="sessionGroupNumber" min="1"
                            value="1">
                    </div>

                    <div class="mb-3">
                        <label for="sessionLocation" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="sessionLocation"
                            placeholder="Salle, Amphi, etc.">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger me-auto" id="deleteSessionBtn"
                        style="display: none;">
                        <i class="fas fa-trash me-1"></i> Supprimer
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="saveSessionBtn">
                        <i class="fas fa-save me-1"></i> Enregistrer
                    </button>
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
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
            cursor: grab;
            transition: all 0.2s;
        }

        .module-item:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .module-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .module-hours {
            display: flex;
            gap: 5px;
        }

        .module-name {
            font-size: 0.9rem;
            color: #495057;
        }

        /* Styles pour la grille d'emploi du temps */
        .timetable-container {
            overflow-x: auto;
        }

        .timetable {
            min-width: 900px;
        }

        .timetable th {
            text-align: center;
            background-color: #f8f9fa;
        }

        .time-slot {
            text-align: center;
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .schedule-cell {
            height: 60px;
            padding: 0;
            position: relative;
            vertical-align: top;
            border: 1px dashed #dee2e6;
            transition: all 0.2s;
        }

        .schedule-cell:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        .schedule-cell.highlight {
            background-color: rgba(13, 110, 253, 0.1);
            border: 1px dashed #0d6efd;
        }

        /* Styles pour les séances */
        .session-item {
            position: absolute;
            left: 0;
            right: 0;
            padding: 5px;
            border-radius: 4px;
            font-size: 0.8rem;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .session-item:hover {
            z-index: 2;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .session-cm {
            background-color: rgba(13, 202, 240, 0.2);
            border-left: 3px solid #0dcaf0;
        }

        .session-td {
            background-color: rgba(255, 193, 7, 0.2);
            border-left: 3px solid #ffc107;
        }

        .session-tp {
            background-color: rgba(220, 53, 69, 0.2);
            border-left: 3px solid #dc3545;
        }

        .session-title {
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .session-time {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .session-location {
            font-size: 0.75rem;
            color: #6c757d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Styles pour le drag and drop */
        .module-item.dragging {
            opacity: 0.5;
        }

        /* Styles pour les badges */
        .badge {
            font-weight: normal;
            font-size: 0.7rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables globales
            let currentScheduleId = null;
            let sessions = [];

            // Initialiser le drag and drop
            const moduleItems = document.querySelectorAll('.module-item');
            const scheduleCells = document.querySelectorAll('.schedule-cell');

            // Ajouter les événements de drag pour les modules
            moduleItems.forEach(module => {
                module.addEventListener('dragstart', function(e) {
                    e.dataTransfer.setData('text/plain', module.dataset.moduleId);
                    module.classList.add('dragging');
                });

                module.addEventListener('dragend', function() {
                    module.classList.remove('dragging');
                });

                // Rendre les modules draggable
                module.setAttribute('draggable', 'true');
            });

            // Ajouter les événements de drop pour les cellules
            scheduleCells.forEach(cell => {
                cell.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    cell.classList.add('highlight');
                });

                cell.addEventListener('dragleave', function() {
                    cell.classList.remove('highlight');
                });

                cell.addEventListener('drop', function(e) {
                    e.preventDefault();
                    cell.classList.remove('highlight');

                    if (!currentScheduleId) {
                        alert('Veuillez d\'abord créer un emploi du temps.');
                        return;
                    }

                    const moduleId = e.dataTransfer.getData('text/plain');
                    const moduleItem = document.querySelector(
                        `.module-item[data-module-id="${moduleId}"]`);

                    if (moduleItem) {
                        // Ouvrir le modal de session avec les informations pré-remplies
                        openSessionModal({
                            moduleId: moduleId,
                            moduleName: moduleItem.dataset.moduleName,
                            moduleCode: moduleItem.dataset.moduleCode,
                            day: cell.dataset.day,
                            time: cell.dataset.time,
                            cmHours: moduleItem.dataset.cmHours,
                            tdHours: moduleItem.dataset.tdHours,
                            tpHours: moduleItem.dataset.tpHours
                        });
                    }
                });
            });

            // Fonction pour ouvrir le modal de session
            function openSessionModal(data, existingSession = null) {
                const modal = document.getElementById('sessionModal');
                const modalTitle = document.getElementById('sessionModalTitle');
                const moduleInfo = document.getElementById('sessionModuleInfo');
                const moduleName = document.getElementById('sessionModuleName');
                const moduleHours = document.getElementById('sessionModuleHours');
                const daySelect = document.getElementById('sessionDay');
                const startTime = document.getElementById('sessionStartTime');
                const endTime = document.getElementById('sessionEndTime');
                const groupType = document.getElementById('sessionGroupType');
                const groupNumber = document.getElementById('sessionGroupNumber');
                const groupNumberContainer = document.getElementById('sessionGroupNumberContainer');
                const location = document.getElementById('sessionLocation');
                const deleteBtn = document.getElementById('deleteSessionBtn');

                // Réinitialiser le formulaire
                document.getElementById('sessionItemId').value = '';

                if (existingSession) {
                    // Mode édition
                    modalTitle.textContent = 'Modifier la Séance';
                    document.getElementById('sessionItemId').value = existingSession.id;
                    document.getElementById('sessionModuleId').value = existingSession.module_id;

                    // Remplir les champs avec les données existantes
                    daySelect.value = existingSession.day_of_week;
                    startTime.value = existingSession.start_time;
                    endTime.value = existingSession.end_time;
                    groupType.value = existingSession.group_type;
                    groupNumber.value = existingSession.group_number || 1;
                    location.value = existingSession.location || '';

                    // Afficher le bouton de suppression
                    deleteBtn.style.display = 'block';

                    // Récupérer les informations du module
                    const moduleItem = document.querySelector(
                        `.module-item[data-module-id="${existingSession.module_id}"]`);
                    if (moduleItem) {
                        moduleName.textContent =
                            `${moduleItem.dataset.moduleCode} - ${moduleItem.dataset.moduleName}`;

                        // Afficher les heures du module
                        let hoursHtml = '';
                        if (moduleItem.dataset.cmHours) {
                            hoursHtml += `<span class="badge bg-info">CM: ${moduleItem.dataset.cmHours}h</span> `;
                        }
                        if (moduleItem.dataset.tdHours) {
                            hoursHtml +=
                                `<span class="badge bg-warning text-dark">TD: ${moduleItem.dataset.tdHours}h</span> `;
                        }
                        if (moduleItem.dataset.tpHours) {
                            hoursHtml += `<span class="badge bg-danger">TP: ${moduleItem.dataset.tpHours}h</span>`;
                        }
                        moduleHours.innerHTML = hoursHtml;
                    }
                } else {
                    // Mode création
                    modalTitle.textContent = 'Ajouter une Séance';
                    document.getElementById('sessionModuleId').value = data.moduleId;

                    // Pré-remplir les champs avec les données du drag and drop
                    daySelect.value = data.day;
                    startTime.value = data.time;

                    // Calculer l'heure de fin (par défaut, 1h30 après)
                    const startHour = parseInt(data.time.split(':')[0]);
                    const endHour = startHour + 1;
                    const endMinutes = startHour === parseInt(data.time.split(':')[0]) ? '30' : '00';
                    endTime.value = `${endHour.toString().padStart(2, '0')}:${endMinutes}`;

                    // Déterminer le type de groupe par défaut en fonction des heures disponibles
                    if (data.cmHours && data.cmHours > 0) {
                        groupType.value = 'cm';
                    } else if (data.tdHours && data.tdHours > 0) {
                        groupType.value = 'td';
                    } else if (data.tpHours && data.tpHours > 0) {
                        groupType.value = 'tp';
                    }

                    // Masquer le bouton de suppression
                    deleteBtn.style.display = 'none';

                    // Afficher les informations du module
                    moduleName.textContent = `${data.moduleCode} - ${data.moduleName}`;

                    // Afficher les heures du module
                    let hoursHtml = '';
                    if (data.cmHours) {
                        hoursHtml += `<span class="badge bg-info">CM: ${data.cmHours}h</span> `;
                    }
                    if (data.tdHours) {
                        hoursHtml += `<span class="badge bg-warning text-dark">TD: ${data.tdHours}h</span> `;
                    }
                    if (data.tpHours) {
                        hoursHtml += `<span class="badge bg-danger">TP: ${data.tpHours}h</span>`;
                    }
                    moduleHours.innerHTML = hoursHtml;
                }

                // Afficher/masquer le champ de numéro de groupe en fonction du type
                groupType.addEventListener('change', function() {
                    groupNumberContainer.style.display = this.value === 'cm' ? 'none' : 'block';
                });

                // Déclencher l'événement change pour initialiser l'affichage
                const event = new Event('change');
                groupType.dispatchEvent(event);

                // Ouvrir le modal
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            }

            // Événement pour le bouton de sauvegarde de session
            // Modifier la fonction de sauvegarde de session
            document.getElementById('saveSessionBtn').addEventListener('click', function() {
                const itemId = document.getElementById('sessionItemId').value;
                const moduleId = document.getElementById('sessionModuleId').value;
                const day = document.getElementById('sessionDay').value;
                const startTime = document.getElementById('sessionStartTime').value;
                const endTime = document.getElementById('sessionEndTime').value;
                const duration = document.getElementById('sessionDuration').value;
                const groupType = document.getElementById('sessionGroupType').value;
                const groupNumber = groupType === 'cm' ? null : document.getElementById(
                    'sessionGroupNumber').value;
                const location = document.getElementById('sessionLocation').value;

                // Valider les données
                if (!moduleId || !day || !startTime || !endTime || !duration || !groupType) {
                    alert('Veuillez remplir tous les champs obligatoires.');
                    return;
                }

                if (startTime >= endTime) {
                    alert('L\'heure de fin doit être postérieure à l\'heure de début.');
                    return;
                }

                // Créer un objet FormData pour envoyer les données
                const formData = new FormData();
                formData.append('item_id', itemId || '');
                formData.append('schedule_id', currentScheduleId);
                formData.append('module_id', moduleId);
                formData.append('day_of_week', day);
                formData.append('start_time', startTime);
                formData.append('end_time', endTime);
                formData.append('duration', duration);
                formData.append('group_type', groupType);
                if (groupNumber) formData.append('group_number', groupNumber);
                if (location) formData.append('location', location);
                formData.append('_token', '{{ csrf_token() }}');

                // Envoyer les données au serveur
                fetch('{{ route('coordinator.schedules.save-session') }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Fermer le modal
                            bootstrap.Modal.getInstance(document.getElementById('sessionModal')).hide();

                            // Mettre à jour la session dans le tableau
                            if (itemId) {
                                // Mise à jour
                                const index = sessions.findIndex(s => s.id == itemId);
                                if (index !== -1) {
                                    sessions[index] = data.item;
                                }
                            } else {
                                // Création
                                sessions.push(data.item);
                            }

                            // Rafraîchir l'affichage
                            renderSessions();

                            // Afficher un message de succès
                            alert(data.message);
                        } else {
                            alert(data.message ||
                                'Une erreur est survenue lors de l\'enregistrement de la séance.');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de l\'enregistrement de la séance.');
                    });
            });

            // Événement pour le bouton de suppression de session
            document.getElementById('deleteSessionBtn').addEventListener('click', function() {
                const itemId = document.getElementById('sessionItemId').value;

                if (!itemId) {
                    return;
                }

                if (!confirm('Êtes-vous sûr de vouloir supprimer cette séance ?')) {
                    return;
                }

                // Envoyer la demande de suppression au serveur
                fetch('{{ route('coordinator.schedules.delete-session') }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            item_id: itemId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Fermer le modal
                            bootstrap.Modal.getInstance(document.getElementById('sessionModal')).hide();

                            // Supprimer la session du tableau
                            sessions = sessions.filter(s => s.id != itemId);

                            // Rafraîchir l'affichage
                            renderSessions();

                            // Afficher un message de succès
                            alert(data.message);
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de la suppression de la séance.');
                    });
            });

            // Fonction pour afficher les sessions dans la grille
            function renderSessions() {
                // Nettoyer la grille
                document.querySelectorAll('.session-item').forEach(item => item.remove());

                // Ajouter les sessions
                sessions.forEach(session => {
                    // Trouver la cellule correspondante
                    const startHour = session.start_time.split(':')[0];
                    const cell = document.querySelector(
                        `.schedule-cell[data-day="${session.day_of_week}"][data-time="${startHour}:00"]`
                    );

                    if (!cell) return;

                    // Calculer la hauteur en fonction de la durée
                    const startTime = new Date(`2000-01-01T${session.start_time}`);
                    const endTime = new Date(`2000-01-01T${session.end_time}`);
                    const durationHours = (endTime - startTime) / (1000 * 60 * 60);
                    const heightPercent = durationHours * 100;

                    // Créer l'élément de session
                    const sessionItem = document.createElement('div');
                    sessionItem.className = `session-item session-${session.group_type}`;
                    sessionItem.style.height = `${heightPercent}%`;

                    // Trouver le module correspondant
                    const moduleItem = document.querySelector(
                        `.module-item[data-module-id="${session.module_id}"]`);
                    const moduleCode = moduleItem ? moduleItem.dataset.moduleCode : 'Module';
                    const moduleName = moduleItem ? moduleItem.dataset.moduleName : 'Inconnu';

                    // Déterminer le texte du groupe
                    let groupText = '';
                    if (session.group_type === 'cm') {
                        groupText = 'CM';
                    } else if (session.group_type === 'td') {
                        groupText = `TD${session.group_number}`;
                    } else if (session.group_type === 'tp') {
                        groupText = `TP${session.group_number}`;
                    }

                    // Remplir le contenu
                    sessionItem.innerHTML = `
                        <div class="session-title">${moduleCode} - ${groupText}</div>
                        <div class="session-time">${session.start_time} - ${session.end_time}</div>
                        <div class="session-location">${session.location || 'Lieu non défini'}</div>
                    `;

                    // Ajouter l'événement de clic pour l'édition
                    sessionItem.addEventListener('click', function() {
                        openSessionModal(null, session);
                    });

                    // Ajouter à la cellule
                    cell.appendChild(sessionItem);
                });
            }

            // Événement pour le bouton de création d'emploi du temps
            document.getElementById('createScheduleBtn').addEventListener('click', function() {
                const modal = document.getElementById('scheduleModal');
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            });

            // Événement pour le bouton de sauvegarde d'emploi du temps
            document.getElementById('saveScheduleBtn').addEventListener('click', function() {
                const name = document.getElementById('scheduleName').value;
                const semester = document.getElementById('scheduleSemesterInput').value;
                const academicYear = document.getElementById('scheduleYearInput').value;

                if (!name || !semester || !academicYear) {
                    alert('Veuillez remplir tous les champs.');
                    return;
                }

                // Créer un objet FormData pour envoyer les données
                const formData = new FormData();
                formData.append('name', name);
                formData.append('semester', semester);
                formData.append('academic_year', academicYear);

                // Ajouter le token CSRF
                formData.append('_token', '{{ csrf_token() }}');

                // Envoyer les données au serveur
                fetch('{{ route('coordinator.schedules.create') }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Fermer le modal
                            bootstrap.Modal.getInstance(document.getElementById('scheduleModal'))
                                .hide();

                            // Mettre à jour l'ID de l'emploi du temps courant
                            currentScheduleId = data.schedule.id;

                            // Mettre à jour l'interface
                            document.getElementById('scheduleTitle').textContent = data.schedule.name;
                            document.getElementById('scheduleSemester').textContent = data.schedule
                                .semester;
                            document.getElementById('scheduleYear').textContent = data.schedule
                                .academic_year;
                            document.getElementById('scheduleInfo').style.display = 'block';

                            // Afficher un message de succès
                            alert(data.message);
                        } else {
                            alert(data.message ||
                                'Une erreur est survenue lors de la création de l\'emploi du temps.'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de la création de l\'emploi du temps.');
                    });
            });
        });


        // Ajouter ce code dans la partie script

        // Calculer automatiquement la durée en fonction des heures de début et de fin
        document.getElementById('sessionStartTime').addEventListener('change', updateDuration);
        document.getElementById('sessionEndTime').addEventListener('change', updateDuration);

        function updateDuration() {
            const startTime = document.getElementById('sessionStartTime').value;
            const endTime = document.getElementById('sessionEndTime').value;

            if (startTime && endTime) {
                const start = new Date(`2000-01-01T${startTime}`);
                const end = new Date(`2000-01-01T${endTime}`);

                if (end > start) {
                    const durationHours = (end - start) / (1000 * 60 * 60);
                    document.getElementById('sessionDuration').value = durationHours.toFixed(1);
                }
            }
        }

        // Mettre à jour les heures de fin lorsque la durée change
        document.getElementById('sessionDuration').addEventListener('change', function() {
            const startTime = document.getElementById('sessionStartTime').value;
            if (startTime) {
                const start = new Date(`2000-01-01T${startTime}`);
                const durationHours = parseFloat(this.value);
                const end = new Date(start.getTime() + durationHours * 60 * 60 * 1000);

                const hours = end.getHours().toString().padStart(2, '0');
                const minutes = end.getMinutes().toString().padStart(2, '0');
                document.getElementById('sessionEndTime').value = `${hours}:${minutes}`;
            }
        });
    </script>
</x-coordonnateur_layout>

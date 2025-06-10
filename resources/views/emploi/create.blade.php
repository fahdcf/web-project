<x-coordonnateur_layout>
    <style>
        .table-container {
            background-color: white;
            width: 100%;
            display: flex;
            justify-content: center;
            overflow-y: auto;
            overflow-x: auto;
            max-height: 80vh;
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .table-container::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background-color: #aaa;
            border-radius: 10px;
        }

        .table-container::-webkit-scrollbar-track {
            background: transparent;
        }

        .schedule-grid {
            min-width: 800px;
            border-collapse: collapse;
        }

        .schedule-grid th {
            text-align: center;
            border-bottom: 1px solid #e0e0e0 !important;
            border-right: 1px solid #e0e0e0 !important;
            color: #4a4a4a;
            font-size: 14px;
            font-weight: 600;
            padding: 8px;
            background-color: #f8f9fa;
        }

        .schedule-grid th:first-child {
            border-left: none;
        }

        .schedule-grid td {
            font-size: 13px;
            color: #585858;
            text-align: center !important;
            vertical-align: top !important;
            min-height: 100px;
            padding: 6px;
            border: 1px solid #e0e0e0;
        }

        .drop-cell {
            min-height: 100px;
            position: relative;
            transition: background-color 0.2s;
        }

        .drop-cell.highlight {
            background-color: #f0f7ff;
        }

        .session-card {
            background: #fff;
            border-radius: 6px;
            padding: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 4px;
            cursor: move;
            transition: transform 0.2s;
        }

        .session-card:hover {
            transform: translateY(-1px);
        }

        .session-card.cm {
            border-left: 3px solid #007bff;
        }

        .session-card.td {
            border-left: 3px solid #17a2b8;
        }

        .session-card.tp {
            border-left: 3px solid #28a745;
        }

        .session-title {
            font-size: 11px;
            font-weight: 600;
            margin: 0;
        }

        .session-details {
            font-size: 9px;
            color: #6c757d;
        }

        .module-pool {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .module-item {
            background-color: white;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .module-name {
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .session-types {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .session-type {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            cursor: move;
            user-select: none;
        }

        .session-type.cm {
            background-color: #e7f1ff;
            color: #0062cc;
            border: 1px dashed #007bff;
        }

        .session-type.td {
            background-color: #e2f3f7;
            color: #0c5460;
            border: 1px dashed #17a2b8;
        }

        .session-type.tp {
            background-color: #e6f7ec;
            color: #218838;
            border: 1px dashed #28a745;
        }

        .conflict-warning {
            position: absolute;
            top: 2px;
            right: 2px;
            font-size: 10px;
            color: #dc3545;
        }

        .modal-content {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #4723d9;
            color: white;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .modal-footer {
            border-top: none;
        }

        .btn-primary {
            background-color: #4723d9;
            border-color: #4723d9;
            font-size: 14px;
            padding: 6px 16px;
        }

        .btn-primary:hover {
            background-color: white;
            color: #4723d9;
            border-color: #4723d9;
        }

        .btn-secondary,
        .btn-danger {
            font-size: 14px;
            padding: 6px 16px;
        }

        .form-control,
        .form-select {
            font-size: 14px;
            padding: 6px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: none !important;
            border-color: #4723d9;
        }

        .form-label {
            font-size: 13px;
        }
    </style>

    <div class="container-fluid p-0 pt-4">
        <x-global_alert />

        @include('components.heading', [
            'icon' => '<i class="fas fa-calendar-alt fa-2x" style="color: #330bcf;"></i>',
            'heading' => 'Créer l\'Emploi du Temps du S' . $semester,
        ])

        @if ($errors->any())
            <div class="alert alert-danger error-message">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="emploiForm" action="{{ route('emploi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="filiere_id" value="{{ $filiere->id }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            <input type="hidden" name="is_active" value="1">
            <input type="hidden" id="serverConflicts" value="{{ json_encode(session('conflicts') ?? []) }}">
            <div id="sessionsContainer"></div>

            <!-- Module Pool Section -->
            <style>
                .module-pool {
                    display: flex;
                    overflow-x: auto;
                    gap: 1rem;
                    padding-bottom: 1rem;
                }

                .module-item {
                    min-width: 260px;
                    background-color: #ffffff;
                    border-radius: 1rem;
                    padding: 1rem;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                    flex-shrink: 0;
                    border: 1px solid #dee2e6;
                }

                .module-name {
                    font-weight: 600;
                    font-size: 1.1rem;
                    margin-bottom: 0.75rem;
                    color: #343a40;
                }

                .session-types {
                    display: flex;
                    flex-direction: column;
                    gap: 0.5rem;
                }

                .session-type {
                    padding: 6px 12px;
                    border-radius: 6px;
                    font-size: 13px;
                    cursor: grab;
                    user-select: none;
                    transition: all 0.2s ease;
                    border: 1px dashed;
                    display: flex;
                    flex-direction: column;
                    background-color: #f8f9fa;
                }

                .session-type:hover {
                    background-color: #f1f1f1;
                }

                .session-type .type-label {
                    font-weight: 600;
                }

                .session-type .prof-name {
                    font-size: 11px;
                    color: #666;
                    margin-top: 2px;
                }

                .session-type.cm {
                    background-color: #e7f1ff;
                    color: #0254ac;
                    border-color: #007bff;
                }

                .session-type.td {
                    background-color: #e2f3f7;
                    color: #0c5460;
                    border-color: #17a2b8;
                }

                .session-type.tp {
                    background-color: #e6f7ec;
                    color: #218838;
                    border-color: #28a745;
                }
            </style>

            <div class="card border-0 shadow rounded-4 mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Modules Disponibles</h5>
                    <div class="module-pool">
                        @foreach ($modules as $module)
                            <div class="module-item" data-module-id="{{ $module->id }}">
                                <div class="module-name">{{ $module->name }} ({{ $module->code }})</div>
                                <div class="session-types">
                                    <div class="session-type cm" draggable="true" data-module-id="{{ $module->id }}"
                                        data-type="CM" data-prof-id="{{ $module->cmAssignation->user->id ?? '' }}"
                                        data-prof-firstname="{{ $module->cmAssignation->user->firstname ?? 'Non défini' }}"
                                        data-prof-lastname="{{ $module->cmAssignation->user->lastname ?? '' }}">
                                        <div class="type-label">CM</div>
                                        <div class="prof-name">
                                            @if ($module->cmAssignation)
                                                {{ $module->cmAssignation->user->firstname }}
                                                {{ $module->cmAssignation->user->lastname }}
                                            @else
                                                Non défini
                                            @endif
                                        </div>
                                    </div>
                                    @for ($i = 1; $i <= $module->nbr_groupes_td; $i++)
                                        <div class="session-type td" draggable="true"
                                            data-module-id="{{ $module->id }}" data-type="TD"
                                            data-groupe="TD{{ $i }}"
                                            data-prof-id="{{ $module->tdAssignation->user->id ?? '' }}"
                                            data-prof-firstname="{{ $module->tdAssignation->user->firstname ?? 'Non défini' }}"
                                            data-prof-lastname="{{ $module->tdAssignation->user->lastname ?? '' }}">
                                            <div class="type-label">TD{{ $i }}</div>
                                            <div class="prof-name">
                                                @if ($module->tdAssignation)
                                                    {{ $module->tdAssignation->user->firstname }}
                                                    {{ $module->tdAssignation->user->lastname }}
                                                @else
                                                    Non défini
                                                @endif
                                            </div>
                                        </div>
                                    @endfor
                                    @for ($i = 1; $i <= $module->nbr_groupes_tp; $i++)
                                        <div class="session-type tp" draggable="true"
                                            data-module-id="{{ $module->id }}" data-type="TP"
                                            data-groupe="TP{{ $i }}"
                                            data-prof-id="{{ $module->tpAssignation->user->id ?? '' }}"
                                            data-prof-firstname="{{ $module->tpAssignation->user->firstname ?? 'Non défini' }}"
                                            data-prof-lastname="{{ $module->tpAssignation->user->lastname ?? '' }}">
                                            <div class="type-label">TP{{ $i }}</div>
                                            <div class="prof-name">
                                                @if ($module->tpAssignation)
                                                    {{ $module->tpAssignation->user->firstname }}
                                                    {{ $module->tpAssignation->user->lastname }}
                                                @else
                                                    Non défini
                                                @endif
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Timetable Grid -->
            <div class="card border-0 shadow rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="table-container">
                        <div class="table-responsive p-3">
                            <table class="table schedule-grid">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Jour</th>
                                        @php
                                            $timeSlots = [
                                                ['start' => '08:30:00', 'end' => '10:30:00'],
                                                ['start' => '10:30:00', 'end' => '12:30:00'],
                                                ['start' => '14:30:00', 'end' => '16:30:00'],
                                                ['start' => '16:30:00', 'end' => '18:30:00'],
                                            ];
                                        @endphp
                                        @foreach ($timeSlots as $slot)
                                            <th>{{ substr($slot['start'], 0, 5) }}-{{ substr($slot['end'], 0, 5) }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $day)
                                        <tr>
                                            <td class="align-middle fw-bold">{{ $day }}</td>
                                            @foreach ($timeSlots as $index => $slot)
                                                <td class="drop-cell" data-day="{{ $day }}"
                                                    data-time-index="{{ $index }}">
                                                    <div class="sessions" data-day="{{ $day }}"
                                                        data-time-index="{{ $index }}"></div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary rounded fw-semibold">
                            <i class="bi bi-check-circle me-2"></i> Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="modal fade" id="sessionConfigModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-plus-circle me-2"></i> Configurer la Séance
                        </h5>
                        <button type="button" class="btn-close btn-close-white" id="colseSessionBtn2"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <form id="sessionForm">
                            <input type="hidden" id="session_temp_id">
                            <input type="hidden" id="session_day">
                            <input type="hidden" id="session_time_index">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Module</label>
                                <input type="text" id="session_module_name" class="form-control rounded-3" readonly>
                                <input type="hidden" id="session_module_id">
                                <input type="hidden" id="session_prof_id">
                                <input type="hidden" id="session_prof_firstname">
                                <input type="hidden" id="session_prof_lastname">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Type</label>
                                <input type="text" id="session_type_display" class="form-control rounded-3"
                                    readonly>
                                <input type="hidden" id="session_type">
                            </div>
                            <div class="mb-3" id="groupeContainer">
                                <label class="form-label small fw-bold text-muted">Groupe</label>
                                <input type="text" id="session_groupe_display" class="form-control rounded-3"
                                    readonly>
                                <input type="hidden" id="session_groupe">
                            </div>
                            <div class="mb-3">
                                <label for="session_salle" class="form-label small fw-bold text-muted">Salle</label>
                                <input type="text" id="session_salle" class="form-control rounded-3"
                                    placeholder="Ex: A101" autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="session_duration"
                                    class="form-label small fw-bold text-muted">Durée</label>
                                <select id="session_duration" class="form-select rounded-3">
                                    <option value="2">2 heures</option>
                                    <option value="4">4 heures</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded fw-semibold" id="colseSessionBtn">
                            Annuler
                        </button>
                        <button type="button" class="btn btn-danger rounded fw-semibold" id="deleteSessionBtn">
                            <i class="bi bi-trash3 me-2"></i> Supprimer
                        </button>
                        <button type="button" id="confirmSessionBtn" class="btn btn-primary rounded fw-semibold">
                            <i class="bi bi-check-circle me-2"></i> Confirmer
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="conflictErrorModal" tabindex="-1" aria-labelledby="conflictErrorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="conflictErrorModalLabel">
                            <i class="bi bi-exclamation-triangle me-2"></i> Conflits détectés
                        </h5>
                        <button type="button" class="btn-close btn-close-white" id="closeconflitBtn2"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="conflictMessage">Résolvez tous les conflits de salle ou de professeur avant de soumettre
                            l'emploi du temps.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary rounded fw-semibold" id="closeconflitBtn">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize modals
            const sessionConfigModal = new bootstrap.Modal(document.getElementById('sessionConfigModal'));
            const conflictErrorModal = new bootstrap.Modal(document.getElementById('conflictErrorModal'), {
                backdrop: true,
                keyboard: true
            });
            // Functions to open and close error modal
            function openErrorModal(message) {
                document.getElementById('conflictMessage').textContent = message;
                conflictErrorModal.show();
            }

            function closeErrorModal() {
                conflictErrorModal.hide();
            }

            // Check for conflicts returned from server
            const serverConflicts = JSON.parse(document.getElementById('serverConflicts').value || '[]');
            if (serverConflicts.length > 0) {
                // Recreate the sessions from the form data
                sessions = serverConflicts.map(conflict => conflict.seance);

                // Highlight the conflicts
                renderSessions();

                // Show modal with conflict messages
                const conflictMessages = serverConflicts.map(c => c.message).join('; ');
                openErrorModal("Conflits détectés: " + conflictMessages);
            }

            const dropCells = document.querySelectorAll('.drop-cell');
            const sessionTypes = document.querySelectorAll('.session-type');
            const emploiForm = document.getElementById('emploiForm');
            const deleteSessionBtn = document.getElementById('deleteSessionBtn');
            const confirmSessionBtn = document.getElementById('confirmSessionBtn');
            const sessionsContainer = document.getElementById('sessionsContainer');

            const colseSessionBtn = document.getElementById('colseSessionBtn');
            const closeconflitBtn = document.getElementById('closeconflitBtn');

            const colseSessionBtn2 = document.getElementById('colseSessionBtn2');
            const closeconflitBtn2 = document.getElementById('closeconflitBtn2');


            let sessions = [];
            let draggedSession = null;
            let currentDropCell = null;
            let hasConflicts = false;

            const timeSlots = [{
                    start: '08:30:00',
                    end: '10:30:00'
                },
                {
                    start: '10:30:00',
                    end: '12:30:00'
                },
                {
                    start: '14:30:00',
                    end: '16:30:00'
                },
                {
                    start: '16:30:00',
                    end: '18:30:00'
                }
            ];

            // Make session types draggable
            sessionTypes.forEach(type => {
                type.addEventListener('dragstart', function(e) {
                    draggedSession = {
                        module_id: this.dataset.moduleId,
                        module_name: this.closest('.module-item').querySelector('.module-name')
                            .textContent,
                        module_code: this.dataset.moduleCode,
                        type: this.dataset.type,
                        prof_id: this.dataset.profId || null,
                        prof_firstname: this.dataset.profFirstname || 'Non défini',
                        prof_lastname: this.dataset.profLastname || '',
                        groupe: this.dataset.groupe || null
                    };
                    e.dataTransfer.setData('text/plain', this.dataset.type);
                    this.style.opacity = '0.4';
                });

                type.addEventListener('dragend', function() {
                    this.style.opacity = '1';
                });
            });
            // Set up drop cells
            dropCells.forEach(cell => {
                cell.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('highlight');
                });

                cell.addEventListener('dragleave', function() {
                    this.classList.remove('highlight');
                });

                cell.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('highlight');

                    if (draggedSession) {
                        currentDropCell = this;

                        document.getElementById('session_module_id').value = draggedSession
                            .module_id;
                        document.getElementById('session_module_name').value = draggedSession
                            .module_name;
                        document.getElementById('session_type').value = draggedSession.type;
                        document.getElementById('session_type_display').value = draggedSession.type;
                        document.getElementById('session_groupe').value = draggedSession.groupe ||
                            '';
                        document.getElementById('session_groupe_display').value = draggedSession
                            .groupe || 'Aucun';
                        document.getElementById('session_prof_id').value = draggedSession.prof_id ||
                            '';
                        document.getElementById('session_prof_firstname').value = draggedSession
                            .prof_firstname;
                        document.getElementById('session_prof_lastname').value = draggedSession
                            .prof_lastname;
                        document.getElementById('session_salle').value = '';
                        document.getElementById('session_duration').value = '2';
                        document.getElementById('session_day').value = this.dataset.day;
                        document.getElementById('session_time_index').value = this.dataset
                            .timeIndex;
                        document.getElementById('session_temp_id').value = '';

                        deleteSessionBtn.style.display = 'none';

                        sessionConfigModal.show();
                    }
                });
            });

            // Handle session confirmation
            confirmSessionBtn.addEventListener('click', function() {
                const tempId = document.getElementById('session_temp_id').value || `session_${Date.now()}`;
                const moduleId = document.getElementById('session_module_id').value;
                const moduleName = document.getElementById('session_module_name').value;
                const type = document.getElementById('session_type').value;
                
                const salle = document.getElementById('session_salle').value || null;
                const groupe = document.getElementById('session_groupe').value || null;
                const duration = parseInt(document.getElementById('session_duration').value);
                const day = document.getElementById('session_day').value;
                const timeIndex = parseInt(document.getElementById('session_time_index').value);
                const profId = document.getElementById('session_prof_id').value || null;
                const profFirstname = document.getElementById('session_prof_firstname').value || null;
                const profLastname = document.getElementById('session_prof_lastname').value || null;

                if (!moduleId || !type || !day || timeIndex < 0 || timeIndex > 3) {
                    alert('Veuillez remplir tous les champs requis.');
                    return;
                }

                if (duration === 4 && timeIndex >= 3) {
                    alert('Une séance de 4 heures ne peut pas être placée à la dernière plage horaire.');
                    return;
                }

                if (duration === 4) {
                    const conflict = sessions.some(s =>
                        s.temp_id !== tempId &&
                        s.jour === day &&
                        (s.heure_debut === timeSlots[timeIndex].start || s.heure_debut === timeSlots[
                            timeIndex + 1].start) &&
                        s.salle === salle &&
                        s.salle
                    );
                    if (conflict) {
                        alert('Conflit de salle détecté dans les plages horaires sélectionnées.');
                        return;
                    }
                }

                const startTime = timeSlots[timeIndex].start;
                const endTime = duration === 2 ? timeSlots[timeIndex].end : timeSlots[timeIndex + 1].end;

                const sessionData = {
                    temp_id: tempId,
                    module_id: moduleId,
                    type,
                    jour: day,
                    heure_debut: startTime,
                    heure_fin: endTime,
                    salle,
                    groupe,
                    duration,
                    time_index: timeIndex,
                    prof: {
                        id: profId,
                        firstname: profFirstname,
                        lastname: profLastname
                    },
                    module: {
                        name: moduleName,
                        code: moduleName.match(/\((.*?)\)/)[1]
                    }
                };

                const index = sessions.findIndex(s => s.temp_id === tempId);
                if (index >= 0) {
                    sessions[index] = sessionData;
                    sessions = sessions.filter(s => s.temp_id !== `${tempId}_paired`);
                } else {
                    sessions.push(sessionData);
                }

                if (duration === 4 && timeIndex < 3) {
                    sessions.push({
                        ...sessionData,
                        temp_id: `${tempId}_paired`,
                        heure_debut: timeSlots[timeIndex + 1].start,
                        heure_fin: timeSlots[timeIndex + 1].end,
                        time_index: timeIndex + 1
                    });
                }

                renderSessions();
                sessionConfigModal.hide();
            });

            // Handle session deletion
            deleteSessionBtn.addEventListener('click', function() {
                const tempId = document.getElementById('session_temp_id').value;
                sessions = sessions.filter(s => s.temp_id !== tempId && s.temp_id !== `${tempId}_paired`);
                renderSessions();
                sessionConfigModal.hide();
            });

            // Handle session deletion
            colseSessionBtn.addEventListener('click', function() {
                sessionConfigModal.hide();
            });
            closeconflitBtn.addEventListener('click', function() {
                conflictErrorModal.hide();
            });


            colseSessionBtn2.addEventListener('click', function() {
                sessionConfigModal.hide();
            });
            closeconflitBtn2.addEventListener('click', function() {
                conflictErrorModal.hide();
            });


            // Handle form submission
            emploiForm.addEventListener('submit', function(e) {
                sessionsContainer.innerHTML = '';

                sessions.forEach((session, index) => {
                    const prefix = `seances[${index}]`;
                    sessionsContainer.insertAdjacentHTML('beforeend', `
                    <input type="hidden" name="${prefix}[module_id]" value="${session.module_id}">
                    <input type="hidden" name="${prefix}[type]" value="${session.type}">
                    <input type="hidden" name="${prefix}[jour]" value="${session.jour}">
                    <input type="hidden" name="${prefix}[heure_debut]" value="${session.heure_debut}">
                    <input type="hidden" name="${prefix}[heure_fin]" value="${session.heure_fin}">
                    <input type="hidden" name="${prefix}[salle]" value="${session.salle || ''}">
                    <input type="hidden" name="${prefix}[groupe]" value="${session.groupe || ''}">
                    <input type="hidden" name="${prefix}[prof_id]" value="${session.prof?.id || ''}">
                `);
                });

                if (hasConflicts) {
                    e.preventDefault();
                    openErrorModal("Résolvez tous les conflits avant de soumettre !");
                    return false;
                }

                return true;
            });
            // Render sessions in the timetable
            function renderSessions() {
                document.querySelectorAll('.sessions').forEach(container => {
                    container.innerHTML = '';
                });

                hasConflicts = false;

                sessions.forEach(session => {
                    const container = document.querySelector(
                        `.sessions[data-day="${session.jour}"][data-time-index="${session.time_index}"]`
                    );

                    if (container) {
                        const salleConflict = sessions.some(s =>
                            s.temp_id !== session.temp_id &&
                            s.jour === session.jour &&
                            s.heure_debut === session.heure_debut &&
                            s.salle === session.salle &&
                            s.salle
                        );

                        const profConflict = sessions.some(s =>
                            s.temp_id !== session.temp_id &&
                            s.jour === session.jour &&
                            s.heure_debut === session.heure_debut &&
                            s.prof.id === session.prof.id &&
                            s.prof.id
                        );

                        if (salleConflict || profConflict) {
                            hasConflicts = true;
                        }

                        const sessionCard = document.createElement('div');
                        sessionCard.className =
                            `session-card ${session.type.toLowerCase()} ${salleConflict ? 'border-danger' : ''} ${profConflict ? 'border-danger' : ''}`;
                        sessionCard.dataset.sessionId = session.temp_id;
                        sessionCard.draggable = true;

                        sessionCard.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-${session.type === 'CM' ? 'primary' : (session.type === 'TD' ? 'info' : 'success')} text-white">
                                ${session.type}
                            </span>
                            ${(salleConflict || profConflict) ? `
                                                                    <span class="badge bg-danger">
                                                                        conflit: ${salleConflict ? 'salle' : ''}${salleConflict && profConflict ? ', ' : ''}${profConflict ? 'professeur' : ''}
                                                                    </span>` : ''}
                        </div>
                        <h6 class="session-title">${session.module.name}</h6>
                        <div class="session-details">
                            <div>${session.module.code}${session.groupe ? ' - ' + session.groupe : ''}</div>
                            <div ${profConflict ? 'class="text-danger"' : ''}> <strong>Prof: ${session.prof.firstname} ${session.prof.lastname}</strong></div>
                            <div ${salleConflict ? 'class="text-danger"' : ''}>Salle: ${session.salle || 'Non défini'}</div>
                            <div>${session.heure_debut.slice(0, 5)}-${session.heure_fin.slice(0, 5)}</div>
                        </div>
                    `;

                        sessionCard.addEventListener('dragstart', function(e) {
                            const sessionId = this.dataset.sessionId;
                            const sessionData = sessions.find(s => s.temp_id === sessionId);
                            if (sessionData) {
                                draggedSession = {
                                    module_id: sessionData.module_id,
                                    module_name: sessionData.module.name,
                                    module_code: sessionData.module.code,
                                    type: sessionData.type,
                                    groupe: sessionData.groupe,
                                    prof_id: sessionData.prof.id,
                                    prof_firstname: sessionData.prof.firstname,
                                    prof_lastname: sessionData.prof.lastname
                                };
                                e.dataTransfer.setData('text/plain', sessionData.type);
                                this.style.opacity = '0.4';
                            }
                        });

                        sessionCard.addEventListener('dragend', function() {
                            this.style.opacity = '1';
                        });

                        sessionCard.addEventListener('click', function() {
                            const sessionId = this.dataset.sessionId;
                            const sessionData = sessions.find(s => s.temp_id === sessionId);
                            if (sessionData) {
                                document.getElementById('session_temp_id').value = sessionData
                                    .temp_id;
                                document.getElementById('session_module_id').value = sessionData
                                    .module_id;
                                document.getElementById('session_module_name').value = sessionData
                                    .module.name;
                                document.getElementById('session_type').value = sessionData.type;
                                document.getElementById('session_type_display').value = sessionData
                                    .type;
                                document.getElementById('session_groupe').value = sessionData
                                    .groupe || '';
                                document.getElementById('session_groupe_display').value =
                                    sessionData.groupe || 'Aucun';
                                document.getElementById('session_salle').value = sessionData
                                    .salle || '';
                                document.getElementById('session_duration').value = sessionData
                                    .duration;
                                document.getElementById('session_day').value = sessionData.jour;
                                document.getElementById('session_time_index').value = sessionData
                                    .time_index;
                                document.getElementById('session_prof_id').value = sessionData.prof
                                    .id || '';
                                document.getElementById('session_prof_firstname').value =
                                    sessionData.prof.firstname;
                                document.getElementById('session_prof_lastname').value = sessionData
                                    .prof.lastname;

                                deleteSessionBtn.style.display = 'inline-block';
                                sessionConfigModal.show();
                            }
                        });

                        container.appendChild(sessionCard);
                    }
                });

                function updateSubmitButton() {
                    const submitBtn = document.querySelector('button[type="submit"]');

                    if (hasConflicts) {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('btn-danger');
                        submitBtn.classList.remove('btn-primary');
                        submitBtn.innerHTML =
                            '<i class="bi bi-exclamation-triangle me-2"></i> Corrigez les conflits';
                    } else {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('btn-danger');
                        submitBtn.classList.add('btn-primary');
                        submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i> Enregistrer';
                    }

                    emploiForm.onsubmit = function(e) {
                        if (hasConflicts) {
                            e.preventDefault();
                            openErrorModal("Résolvez tous les conflits avant de soumettre !");
                            return false;
                        }
                        return true;
                    };
                }
            }
        });
    </script>


    <style>
        .btn-primary:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
    </style>
</x-coordonnateur_layout>

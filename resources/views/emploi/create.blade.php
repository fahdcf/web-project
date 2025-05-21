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

        .clickable-cell {
            cursor: pointer;
            position: relative;
        }

        .clickable-cell:hover {
            background-color: #f5f5f5;
        }

        .session-card {
            background: #fff;
            border-radius: 6px;
            padding: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 4px;
            cursor: pointer;
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

        .add-session-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            background-color: #4723d9;
            color: white;
            border-radius: 50%;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            margin: 4px auto;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .add-session-btn:hover {
            background-color: #330bcf;
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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger error-message">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
            <h3 style="color: #330bcf; font-weight: 500;">Créer un Emploi du Temps - S{{ $semester }}</h3>
            <a href="{{ route('emploi.index') }}" class="btn btn-outline-secondary rounded fw-semibold my-2">
                <i class="bi bi-arrow-left me-2"></i> Retour
            </a>
        </div>

        <form id="emploiForm" action="{{ route('emploi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="filiere_id" value="{{ $filiere->id }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            <input type="hidden" name="academic_year" value="{{ $academicYear }}">
            <input type="hidden" name="is_active" value="1">
            <div id="sessionsContainer"></div>

            <div class="card border-0 shadow rounded-4 mb-4" style="box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label for="name" class="form-label small fw-bold text-muted">Nom de l'Emploi du
                            Temps</label>
                        <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
                                                <td class="clickable-cell" data-day="{{ $day }}"
                                                    data-time-index="{{ $index }}">
                                                    <div class="sessions" data-day="{{ $day }}"
                                                        data-time-index="{{ $index }}"></div>
                                                    <div class="add-session-btn" title="Ajouter une séance">+</div>
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

        <!-- Session Configuration Modal -->
        <div class="modal fade" id="sessionConfigModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-plus-circle me-2"></i> Configurer la Séance
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <form id="sessionForm">
                            <input type="hidden" id="session_temp_id">
                            <input type="hidden" id="session_day">
                            <input type="hidden" id="session_time_index">
                            <div class="mb-3">
                                <label for="session_module_id"
                                    class="form-label small fw-bold text-muted">Module</label>
                                <select id="session_module_id" class="form-select rounded-3" required>
                                    <option value="">Sélectionner</option>
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id }}" data-name="{{ $module->name }}"
                                            data-code="{{ $module->code }}"
                                            data-nbr-groupes-td="{{ $module->nbr_groupes_td }}"
                                            data-nbr-groupes-tp="{{ $module->nbr_groupes_tp }}">
                                            {{ $module->name }} ({{ $module->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="session_type" class="form-label small fw-bold text-muted">Type</label>
                                <select id="session_type" class="form-select rounded-3" required>
                                    <option value="">Sélectionner</option>
                                    <option value="CM">CM</option>
                                    <option value="TD">TD</option>
                                    <option value="TP">TP</option>
                                </select>
                            </div>
                            <div id="groupeContainer" class="mb-3" style="display: none;">
                                <label for="session_groupe" class="form-label small fw-bold text-muted">Groupe</label>
                                <select id="session_groupe" class="form-select rounded-3">
                                    <option value="">Aucun</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="session_salle" class="form-label small fw-bold text-muted">Salle</label>
                                <input type="text" id="session_salle" class="form-control rounded-3"
                                    placeholder="Ex: A101">
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
                        <button type="button" class="btn btn-secondary rounded fw-semibold" data-bs-dismiss="modal">
                            Annuler
                        </button>
                        <button type="button" class="btn btn-danger rounded fw-semibold" id="deleteSessionBtn"
                            style="display: none;">
                            <i class="bi bi-trash3 me-2"></i> Supprimer
                        </button>
                        <button type="button" id="confirmSessionBtn" class="btn btn-primary rounded fw-semibold">
                            <i class="bi bi-check-circle me-2"></i> Confirmer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sessionConfigModal = new bootstrap.Modal(document.getElementById('sessionConfigModal'));
            const cells = document.querySelectorAll('.clickable-cell');
            const sessionForm = document.getElementById('sessionForm');
            const emploiForm = document.getElementById('emploiForm');
            const deleteSessionBtn = document.getElementById('deleteSessionBtn');
            const confirmSessionBtn = document.getElementById('confirmSessionBtn');
            const sessionsContainer = document.getElementById('sessionsContainer');
            let sessions = [];

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

            cells.forEach(cell => {
                cell.addEventListener('click', function(e) {
                    if (e.target.closest('.session-card') || e.target.closest('.add-session-btn')) {
                        if (e.target.closest('.session-card')) {
                            const sessionId = e.target.closest('.session-card').dataset.sessionId;
                            const sessionData = sessions.find(s => s.temp_id === sessionId);
                            if (sessionData) {
                                document.getElementById('session_temp_id').value = sessionData
                                    .temp_id;
                                document.getElementById('session_module_id').value = sessionData
                                    .module_id;
                                document.getElementById('session_type').value = sessionData.type;
                                document.getElementById('session_salle').value = sessionData
                                    .salle || '';
                                document.getElementById('session_groupe').value = sessionData
                                    .groupe || '';
                                document.getElementById('session_duration').value = sessionData
                                    .duration;
                                document.getElementById('session_day').value = sessionData.jour;
                                document.getElementById('session_time_index').value = sessionData
                                    .time_index;
                                deleteSessionBtn.style.display = 'inline-block';
                                updateGroupeOptions();
                                sessionConfigModal.show();
                            }
                        }
                        return;
                    }

                    document.getElementById('session_day').value = this.dataset.day;
                    document.getElementById('session_time_index').value = this.dataset.timeIndex;
                    document.getElementById('session_temp_id').value = '';
                    document.getElementById('session_module_id').value = '';
                    document.getElementById('session_type').value = '';
                    document.getElementById('session_salle').value = '';
                    document.getElementById('session_groupe').value = '';
                    document.getElementById('session_duration').value = '2';
                    deleteSessionBtn.style.display = 'none';
                    updateGroupeOptions();
                    sessionConfigModal.show();
                });
            });

            confirmSessionBtn.addEventListener('click', function() {
                const tempId = document.getElementById('session_temp_id').value || `session_${Date.now()}`;
                const moduleId = document.getElementById('session_module_id').value;
                const type = document.getElementById('session_type').value;
                const salle = document.getElementById('session_salle').value || null;
                const groupe = document.getElementById('session_groupe').value || null;
                const duration = document.getElementById('session_duration').value;
                const day = document.getElementById('session_day').value;
                const timeIndex = parseInt(document.getElementById('session_time_index').value);

                if (!moduleId || !type || !day || timeIndex < 0 || timeIndex > 3) {
                    alert('Veuillez remplir tous les champs requis.');
                    return;
                }

                if (duration === '4' && timeIndex >= 3) {
                    alert('Une séance de 4 heures ne peut pas être placée à la dernière plage horaire.');
                    return;
                }

                const moduleOption = document.getElementById('session_module_id').querySelector(
                    `option[value="${moduleId}"]`);
                const startTime = timeSlots[timeIndex].start;
                const endTime = duration === '2' ? timeSlots[timeIndex].end : (timeIndex < 3 ? timeSlots[
                    timeIndex + 1].end : timeSlots[timeIndex].end);

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
                    module: {
                        name: moduleOption.dataset.name,
                        code: moduleOption.dataset.code
                    }
                };

                const index = sessions.findIndex(s => s.temp_id === tempId);
                if (index >= 0) {
                    sessions[index] = sessionData;
                } else {
                    sessions.push(sessionData);
                    if (duration === '4' && timeIndex < 3) {
                        sessions.push({
                            ...sessionData,
                            temp_id: `session_${Date.now() + 1}`,
                            heure_debut: timeSlots[timeIndex + 1].start,
                            time_index: timeIndex + 1
                        });
                    }
                }

                renderSessions();
                sessionConfigModal.hide();
            });

            deleteSessionBtn.addEventListener('click', function() {
                const tempId = document.getElementById('session_temp_id').value;
                sessions = sessions.filter(s => s.temp_id !== tempId);
                renderSessions();
                sessionConfigModal.hide();
            });

            emploiForm.addEventListener('submit', function() {
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
            `);
                });
            });

            document.getElementById('session_type').addEventListener('change', updateGroupeOptions);
            document.getElementById('session_module_id').addEventListener('change', updateGroupeOptions);

            function updateGroupeOptions() {
                const type = document.getElementById('session_type').value;
                const moduleId = document.getElementById('session_module_id').value;
                const groupeContainer = document.getElementById('groupeContainer');
                const groupeSelect = document.getElementById('session_groupe');

                // Clear existing options except 'Aucun'
                while (groupeSelect.options.length > 1) {
                    groupeSelect.remove(1);
                }

                if (type === 'TD' || type === 'TP') {
                    const moduleOption = document.getElementById('session_module_id').querySelector(
                        `option[value="${moduleId}"]`);
                    if (moduleOption) {
                        const maxGroups = type === 'TD' ? parseInt(moduleOption.dataset.nbrGroupesTd) : parseInt(
                            moduleOption.dataset.nbrGroupesTp);
                        if (maxGroups > 0) {
                            for (let i = 1; i <= maxGroups; i++) {
                                const option = document.createElement('option');
                                option.value = `${type}${i}`;
                                option.textContent = `${type} ${i}`;
                                groupeSelect.appendChild(option);
                            }
                            groupeContainer.style.display = 'block';
                            groupeSelect.setAttribute('required', 'required');
                        } else {
                            groupeContainer.style.display = 'none';
                            groupeSelect.removeAttribute('required');
                        }
                    } else {
                        groupeContainer.style.display = 'none';
                        groupeSelect.removeAttribute('required');
                    }
                } else {
                    groupeContainer.style.display = 'none';
                    groupeSelect.removeAttribute('required');
                }
            }

            function renderSessions() {
                document.querySelectorAll('.sessions').forEach(container => {
                    container.innerHTML = '';
                });

                sessions.forEach(session => {
                    const container = document.querySelector(
                        `.sessions[data-day="${session.jour}"][data-time-index="${session.time_index}"]`
                    );
                    if (container) {
                        container.insertAdjacentHTML('beforeend', `
                    <div class="session-card ${session.type.toLowerCase()}" data-session-id="${session.temp_id}">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-${session.type === 'CM' ? 'primary' : (session.type === 'TD' ? 'info' : 'success')} text-white">
                                ${session.type}
                            </span>
                        </div>
                        <h6 class="session-title">${session.module.name}</h6>
                        <div class="session-details">
                            <div>${session.module.code}${session.groupe ? ' - ' + session.groupe : ''}</div>
                            <div>${session.salle || 'Non défini'}</div>
                            <div>${session.heure_debut.slice(0, 5)}-${session.heure_fin.slice(0, 5)}</div>
                        </div>
                    </div>
                `);
                    }
                });
            }
        });
    </script>
</x-coordonnateur_layout>

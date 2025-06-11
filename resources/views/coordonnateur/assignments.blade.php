<x-coordonnateur_layout>
        <div class="profile-container ">
            <h1 class="profile-name text-center pb-2">Affectations des Modules</h1>

            <!-- Filters -->
            <div class="module-filters mb-4">
                <div class="semester-item">
                    <label for="semester-filter" class="semester-label">Filtrer par Semestre</label>
                    <select id="semester-filter" onchange="filterAssignments()" class="form-select">
                        <option value="">Tous les Semestres</option>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester }}" {{ $semester == request('semester') ? 'selected' : '' }}>
                                Semestre {{ $semester }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="semester-item">
                    <label for="name-search" class="semester-label">Rechercher par Nom de Professeur</label>
                    <input type="text" id="name-search" class="form-control" placeholder="Entrez le nom du professeur" value="{{ request('name-search') }}" oninput="filterAssignments()">
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="nav-tabs">
                <div class="nav-tab active" onclick="showTab('modules-tab')" data-tab="modules-tab">
                    <i class="bi bi-book me-2"></i>Modules
                </div>
                <div class="nav-tab" onclick="showTab('professors-tab')" data-tab="professors-tab">
                    <i class="bi bi-person me-2"></i>Professeurs
                </div>
            </div>

            <!-- Modules Tab -->
            <div id="modules-tab" class="tab-content active">
                @if ($modules->count() > 0)
                    <div class="module-grid-container">
                        <div class="module-grid">
                            @foreach ($modules as $moduleData)
                                <div class="module-card" data-semester="{{ $moduleData['module']->semester }}" data-professors="{{ \Illuminate\Support\Str::lower($moduleData['cm_profs']->pluck('name')->concat($moduleData['td_profs']->pluck('name'))->concat($moduleData['tp_profs']->pluck('name'))->unique()->join(',')) }}">
                                    <div class="module-header">
                                        <div class="module-title-container">
                                            <h3 class="module-name">{{ $moduleData['module']->name }}</h3>
                                            <div class="module-hours-badge">{{ $moduleData['module']->type }}</div>
                                        </div>
                                    </div>
                                    <div class="module-details">
                                        <div class="detail-item">
                                            <i class="bi bi-building detail-icon"></i>
                                            <div>
                                                <span class="detail-label">Filière</span>
                                                <span class="detail-value">{{ $moduleData['module']->filiere ? $moduleData['module']->filiere->name : 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bi bi-calendar-week detail-icon"></i>
                                            <div>
                                                <span class="detail-label">Semestre</span>
                                                <span class="detail-value">{{ $moduleData['module']->semester ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bi bi-person detail-icon"></i>
                                            <div>
                                                <span class="detail-label">Professeurs CM</span>
                                                <span class="detail-value">
                                                    {{ $moduleData['cm_profs']->isEmpty() ? 'Aucun' : $moduleData['cm_profs']->map(fn($prof) => "{$prof['name']} ({$prof['role']})")->join(', ') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bi bi-person detail-icon"></i>
                                            <div>
                                                <span class="detail-label">Professeurs TD</span>
                                                <span class="detail-value">
                                                    {{ $moduleData['td_profs']->isEmpty() ? 'Aucun' : $moduleData['td_profs']->map(fn($prof) => "{$prof['name']} ({$prof['role']})")->join(', ') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bi bi-person detail-icon"></i>
                                            <div>
                                                <span class="detail-label">Professeurs TP</span>
                                                <span class="detail-value">
                                                    {{ $moduleData['tp_profs']->isEmpty() ? 'Aucun' : $moduleData['tp_profs']->map(fn($prof) => "{$prof['name']} ({$prof['role']})")->join(', ') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bi bi-clock detail-icon"></i>
                                            <div>
                                                <span class="detail-label">Total Heures</span>
                                                <span class="detail-value">{{ $moduleData['total_hours'] ?? 'N/A' }}h</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-journal-x"></i>
                        <p>Aucune affectation de module trouvée.</p>
                    </div>
                @endif
            </div>

            <!-- Professors Tab -->
            <div id="professors-tab" class="tab-content">
                <div class="professor-selector mb-4">
                    <label for="professor-select" class="semester-label">Sélectionner un Professeur</label>
                    <select id="professor-select" class="form-select" onchange="displayProfessorModules(this.value)">
                        <option value="">Sélectionnez un professeur</option>
                        @foreach ($professors as $prof)
                            <option value="{{ $prof['id'] }}" {{ $selected_prof == $prof['id'] ? 'selected' : '' }}>
                                {{ $prof['name'] }} ({{ $prof['role'] }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="professor-details" class="professor-details">
                    @if ($selected_professor)
                        <h3 class="professor-name">{{ $selected_professor['name'] }} ({{ $selected_professor['role'] }})</h3>
                        @if ($selected_professor['modules']->count() > 0)
                            <div class="module-grid-container">
                                <div class="module-grid" id="professor-modules">
                                    @foreach ($selected_professor['modules'] as $module)
                                        <div class="module-card" data-semester="{{ $module['semester'] }}" data-professor="{{ \Illuminate\Support\Str::lower($selected_professor['name']) }}">
                                            <div class="module-header">
                                                <div class="module-title-container">
                                                    <h3 class="module-name">{{ $module['module_name'] }}</h3>
                                                    <div class="module-hours-badge">{{ $module['type'] }}</div>
                                                </div>
                                            </div>
                                            <div class="module-details">
                                                <div class="detail-item">
                                                    <i class="bi bi-book detail-icon"></i>
                                                    <div>
                                                        <span class="detail-label">Types d'Enseignement</span>
                                                        <span class="detail-value">
                                                            @foreach ($module['teaching_types'] as $type)
                                                                <span class="teaching-badge {{ strtolower($type) }}-badge">{{ $type }} ({{ $module[strtolower($type) . '_hours'] }}h)</span>
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="detail-item">
                                                    <i class="bi bi-building detail-icon"></i>
                                                    <div>
                                                        <span class="detail-label">Filière</span>
                                                        <span class="detail-value">{{ $module['filiere'] }}</span>
                                                    </div>
                                                </div>
                                                <div class="detail-item">
                                                    <i class="bi bi-calendar-week detail-icon"></i>
                                                    <div>
                                                        <span class="detail-label">Semestre</span>
                                                        <span class="detail-value">{{ $module['semester'] }}</span>
                                                    </div>
                                                </div>
                                                <div class="detail-item">
                                                    <i class="bi bi-clock detail-icon"></i>
                                                    <div>
                                                        <span class="detail-label">Heures</span>
                                                        <span class="detail-value">{{ ($module['cm_hours'] + $module['td_hours'] + $module['tp_hours']) }}h</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="bi bi-journal-x"></i>
                                <p>Aucune affectation trouvée pour ce professeur.</p>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <i class="bi bi-person-x"></i>
                            <p>Veuillez sélectionner un professeur pour voir ses affectations.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    <script>
        // Store professors data for client-side rendering
        const professorsData = @json($professors);

        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            document.querySelectorAll('.nav-tab').forEach(tab => tab.classList.remove('active'));
            document.querySelector(`.nav-tab[data-tab="${tabId}"]`).classList.add('active');
            filterAssignments();
        }

        function filterAssignments() {
            const semesterFilter = document.getElementById('semester-filter').value;
            const nameSearch = document.getElementById('name-search').value.toLowerCase();
            const activeTab = document.querySelector('.tab-content.active').id;

            if (activeTab === 'modules-tab') {
                const moduleCards = document.querySelectorAll('.module-card');
                moduleCards.forEach(card => {
                    const semester = card.getAttribute('data-semester') || '';
                    const professors = card.getAttribute('data-professors') || '';
                    const matchesSemester = semesterFilter ? semester === semesterFilter : true;
                    const matchesName = nameSearch ? professors.includes(nameSearch) : true;
                    card.style.display = matchesSemester && matchesName ? 'block' : 'none';
                });
            } else if (activeTab === 'professors-tab') {
                const selectedProfId = document.getElementById('professor-select').value;
                if (selectedProfId) {
                    displayProfessorModules(selectedProfId);
                }
            }
        }

        function displayProfessorModules(profId) {
            const professor = professorsData.find(p => p.id == profId);
            const professorDetails = document.getElementById('professor-details');
            const semesterFilter = document.getElementById('semester-filter').value;
            const nameSearch = document.getElementById('name-search').value.toLowerCase();

            if (!professor) {
                professorDetails.innerHTML = `
                    <div class="empty-state">
                        <i class="bi bi-person-x"></i>
                        <p>Veuillez sélectionner un professeur pour voir ses affectations.</p>
                    </div>`;
                return;
            }

            let modules = professor.modules;
            if (semesterFilter) {
                modules = modules.filter(m => m.semester == semesterFilter);
            }
            if (nameSearch && !professor.name.toLowerCase().includes(nameSearch)) {
                modules = [];
            }

            professorDetails.innerHTML = `
                <h3 class="professor-name">${professor.name} (${professor.role})</h3>
                ${modules.length > 0 ? `
                    <div class="module-grid-container">
                        <div class="module-grid" id="professor-modules">
                            ${modules.map(module => `
                                <div class="module-card" data-semester="${module.semester}" data-professor="${professor.name.toLowerCase()}">
                                    <div class="module-header">
                                        <div class="module-title-container">
                                            <h3 class="module-name">${module.module_name}</h3>
                                            <div class="module-hours-badge">${module.type}</div>
                                        </div>
                                    </div>
                                    <div class="module-details">
                                        <div class="detail-item">
                                            <i class="bi bi-book detail-icon"></i>
                                            <div>
                                                <span class="detail-label">Types d'Enseignement</span>
                                                <span class="detail-value">
                                                    ${module.teaching_types.map(type => `
                                                        <span class="teaching-badge ${type.toLowerCase()}-badge">${type} (${module[`${type.toLowerCase()}_hours`]}h)</span>
                                                    `).join('')}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bi bi-building detail-icon"></i>
                                            <div>
                                                <span class="detail-label">Filière</span>
                                                <span class="detail-value">${module.filiere}</span>
                                            </div>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bi bi-calendar-week detail-icon"></i>
                                            <div>
                                                <span class="detail-label">Semestre</span>
                                                <span class="detail-value">${module.semester}</span>
                                            </div>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bi bi-clock detail-icon"></i>
                                            <div>
                                                <span class="detail-label">Heures</span>
                                                <span class="detail-value">${(module.cm_hours + module.td_hours + module.tp_hours)}h</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                ` : `
                    <div class="empty-state">
                        <i class="bi bi-journal-x"></i>
                        <p>Aucune affectation trouvée pour ce professeur.</p>
                    </div>
                `}
            `;
        }
    </script>

    <style>
        :root {
            --primary-color: #4723d9;
            --danger-color: #e74c3c;
            --success-color: #21b524;
            --neutral-color: #6c757d;
            --cm-color: #3498db;
            --td-color: #e67e22;
            --tp-color: #9b59b6;
        }

        .profile-container {
            background-color: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin: 0 auto;
        }

        .profile-name {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .module-filters {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .semester-item {
            flex: 1;
            min-width: 200px;
        }

        .semester-label {
            display: block;
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .semester-item select,
        .semester-item input,
        .professor-selector select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .semester-item input {
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>') no-repeat right 10px center;
            background-size: 16px;
        }

        .nav-tabs {
            display: flex;
            border-bottom: 1px solid #eee;
            margin-bottom: 25px;
        }

        .nav-tab {
            padding: 12px 20px;
            cursor: pointer;
            font-weight: 500;
            color: var(--neutral-color);
            position: relative;
        }

        .nav-tab.active {
            color: var(--primary-color);
        }

        .nav-tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary-color);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .module-grid-container {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .module-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .module-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #4723d91e;
        }

        .module-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .module-header {
            padding: 16px 20px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #6047c7 100%);
            border-bottom: 1px solid #e0e0e0;
        }

        .module-title-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .module-name {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
            color: #f0f0f0;
        }

        .module-hours-badge {
            background: #ffffff14;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .module-details {
            padding: 16px 20px;
            display: grid;
            gap: 14px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .detail-icon {
            color: var(--primary-color);
            font-size: 1rem;
        }

        .detail-label {
            display: block;
            font-size: 0.75rem;
            color: #95a5a6;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            display: block;
            font-size: 0.95rem;
            font-weight: 500;
            color: #34495e;
            margin-top: 2px;
        }

        .professor-selector {
            max-width: 400px;
        }

        .professor-details .professor-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .teaching-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
            color: white;
            margin-right: 8px;
        }

        .cm-badge {
            background-color: var(--cm-color);
        }

        .td-badge {
            background-color: var(--td-color);
        }

        .tp-badge {
            background-color: var(--tp-color);
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            text-align: center;
            color: var(--neutral-color);
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .module-grid {
                grid-template-columns: 1fr;
            }

            .module-filters {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</x-coordonnateur_layout>
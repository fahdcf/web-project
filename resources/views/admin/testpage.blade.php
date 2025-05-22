@php
    $layout = 'layout'; // default layout

    if (auth()->user()->role->isadmin) {
        $layout = 'components.admin_layout';
    } elseif (auth()->user()->role->ischef) {
        $layout = 'components.chef_layout';
    } else {
        $layout = 'components.layout';
    }
@endphp

@component($layout)
    <div class="container-fluid p-0">
        <div class="profile-container">
            <!-- Profile Header -->
            <div class="profile-header">
                @if ($user->user_details && $user->user_details->profile_img)
                    <img class="profile-image" src="{{ asset('storage/' . $user->user_details->profile_img) }}" alt="Profile Image">
                @else
                    <img class="profile-image" src="{{ asset('storage/images/default_profile_img.png') }}" alt="Profile Image">
                @endif
                <h1 class="profile-name">{{ $user->firstname }} {{ $user->lastname }}</h1>
                <p class="profile-role">{{ $user->role_column }}</p>
            </div>

            @php
                // Calculate hours percentages and status
                $current_hours = $user->hours ?? 0;
                $min_hours = $user->user_details->min_hours ?? 0;
                $max_hours = $user->user_details->max_hours ?? 0;
                
                // Calculate positions (0-100% scale)
                $min_marker_pos = ($min_hours / max(1, $max_hours)) * 100;
                $max_marker_pos = 100; // Always at the end
                
                // Current progress percentage (capped at 100)
                $progress_percentage = min(100, ($current_hours / max(1, $max_hours)) * 100);
                
                // Progress color logic
                $progress_color = ($current_hours < $min_hours || $current_hours > $max_hours) ? '#ea5455' : '#21b524';
            @endphp

            <!-- Hours Progress Bar -->
            <div class="hours-progress-container mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="hours-label">Current Hours: {{ $current_hours }}</span>
                    <span class="hours-range">
                        Min: {{ $min_hours }} | Max: {{ $max_hours }}
                    </span>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar-background">
                        <div class="progress-bar" 
                             style="width: {{ $progress_percentage }}%; background-color: {{ $progress_color }};">
                        </div>
                        <div class="min-marker" style="left: {{ $min_marker_pos }}%; background-color: {{ $min_marker_pos <= $progress_percentage ? "rgba(255, 255, 255, 0.462);" : "rgba(226, 21, 21, 0.582);" }}"></div>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="nav-tabs">
                <div class="nav-tab active" onclick="showTab('assigned-modules')" data-tab="assigned-modules">
                    <i class="bi bi-book me-2"></i>Assigned Modules
                </div>
                <div class="nav-tab" onclick="showTab('basic-info')" data-tab="basic-info">
                    <i class="bi bi-person me-2"></i>Basic Information
                </div>
                <div class="nav-tab" onclick="showTab('available-modules')" data-tab="available-modules">
                    <i class="bi bi-grid me-2"></i>Available Modules
                </div>
            </div>
            
            <!-- Basic Information Tab -->
            <div id="basic-info" class="tab-content">
                <form action="{{ url('chef/professeur_profile/' .  $user->id )}}" method="post">
                    @csrf
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">First Name</div>
                            <div class="info-value">{{ $user->firstname }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Last Name</div>
                            <div class="info-value">{{ $user->lastname }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Department</div>
                            <div class="info-value">{{ $user->departement }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">{{ $user->user_details->status ?? 'N/A' }}</div>
                        </div>
                        
                        @if (auth()->user()->role->ischef)
                            <div class="info-item">
                                <div class="info-label">Min Hours</div>
                                <input type="number" class="editable-field" name="min_hours" value="{{ $user->user_details->min_hours ?? '' }}">
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">Max Hours</div>
                                <input type="number" class="editable-field" name="max_hours" value="{{ $user->user_details->max_hours ?? '' }}">
                            </div>
                            
                            <div class="info-item m-0">
                                <button type="submit" class="save-btn mt-md-4">Save Changes</button>
                            </div>
                        @else
                            <div class="info-item">
                                <div class="info-label">Min Hours</div>
                                <div class="info-value">{{ $user->user_details->min_hours ?? 'N/A' }}</div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">Max Hours</div>
                                <div class="info-value">{{ $user->user_details->max_hours ?? 'N/A' }}</div>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
            
            <!-- Assigned Modules Tab -->
            <div id="assigned-modules" class="tab-content active">
                @if($modules->where('professor_id', $user->id)->count() > 0)
                    <div class="module-grid-container">
                        <div class="module-grid">
                            @foreach($modules->where('professor_id', $user->id) as $module)
                                <div class="module-card">
                                    <div class="module-header">
                                        <div class="module-title-container">
                                            <h3 class="module-name">{{ $module->name }}</h3>
                                            <div class="module-hours-badge">{{ $module->type }}</div>
                                        </div>
                                        <div class="module-workload">
                                            <div class="workload-item">
                                                <span class="workload-label">CM</span>
                                                <span class="workload-value">{{ $module->cm_hours }}h</span>
                                            </div>
                                            <div class="workload-item">
                                                <span class="workload-label">TD</span>
                                                <span class="workload-value">{{ $module->td_hours }}h</span>
                                            </div>
                                            <div class="workload-item">
                                                <span class="workload-label">TP</span>
                                                <span class="workload-value">{{ $module->tp_hours }}h</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="module-details">
                                        <div class="detail-item">
                                            <i class="bi bi-building detail-icon"></i>
                                            <div>
                                                <span class="detail-label">Filière</span>
                                                <span class="detail-value">{{ $module->filiere->name ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="detail-item">
                                            <i class="bi bi-calendar-week detail-icon"></i>
                                            <div>
                                                <span class="detail-label">Semester</span>
                                                <span class="detail-value">{{ $module->semester }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="module-actions">
                                        <button class="remove-btn" data-toggle="modal" data-target="#removemoduleId{{ $module->id }}">
                                            <i class="bi bi-trash3"></i> Remove Module
                                        </button>
                                    </div>
                                </div>

                                <!-- Remove Modal -->
                                <div class="modal fade" id="removemoduleId{{ $module->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color:#333; font-weight:500">Remove module</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p style="color: #585858">Vous voulez remover le module <strong>{{ $module->name }}</strong> de le professeur <strong>{{ $user->firstname }} {{ $user->lastname }}</strong> ?</p>
                                                <form action="{{ url('/chef/professeurs/remove/' . $module->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn ml-1 btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn ml-1 btn-danger btn-sm">Remove</button>
                                                    </div>
                                                </form>
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
                        <p>No modules assigned to this professor</p>
                    </div>
                @endif
            </div>

            <!-- Available Modules Tab -->
            <div id="available-modules" class="tab-content">
                <form id="assign-modules-form" method="POST" action="{{ url('/chef/professeurs/affecter') }}">
                    @csrf
                    <div class="drop-area" ondragover="allowDrop(event)" ondrop="dropModule(event)">
                        <p>Drop Here</p>
                        <div id="dropped-modules" class="dropped-modules"></div>
                    </div>
                    <button type="submit" class="save-btn mt-3">Submit Assignments</button>
                </form>
                <div class="module-filters">
                    <div class="filter-item">
                        <label for="filiere-filter" class="filter-label">Filter by Filière</label>
                        <select id="filiere-filter" onchange="filterModules()">
                            <option value="">All Filières</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Mathematics">Mathematics</option>
                            <option value="Physics">Physics</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="name-search" class="filter-label">Search by Name</label>
                        <input type="text" id="name-search" placeholder="Enter module name" oninput="filterModules()">
                    </div>
                </div>
                <div class="module-grid-container">
                    <div class="module-grid" id="available-modules-grid">
                        @foreach($available_modules as $module)
                            <div class="module-card" draggable="true" data-module-id="{{ $module->id }}" ondragstart="dragStart(event)">
                                <div class="module-header">
                                    <div class="module-title-container">
                                        <h3 class="module-name">{{ $module->name }}</h3>
                                        <div class="module-hours-badge">{{ $module->type }}</div>
                                    </div>
                                    <div class="module-workload">
                                        <div class="workload-item">
                                            <span class="workload-label">CM</span>
                                            <span class="workload-value">{{ $module->cm_hours }}h</span>
                                        </div>
                                        <div class="workload-item">
                                            <span class="workload-label">TD</span>
                                            <span class="workload-value">{{ $module->td_hours }}h</span>
                                        </div>
                                        <div class="workload-item">
                                            <span class="workload-label">TP</span>
                                            <span class="workload-value">{{ $module->tp_hours }}h</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="module-details">
                                    <div class="detail-item">
                                        <i class="bi bi-building detail-icon"></i>
                                        <div>
                                            <span class="detail-label">Filière</span>
                                            <span class="detail-value">{{ $module->filiere ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <i class="bi bi-calendar-week detail-icon"></i>
                                        <div>
                                            <span class="detail-label">Semester</span>
                                            <span class="detail-value">{{ $module->semester }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Teaching Type Modal -->
                <div class="modal fade" id="teachingTypeModal" tabindex="-1" role="dialog" aria-labelledby="teachingTypeModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="teachingTypeModalLabel" style="color:#333; font-weight:500">Select Teaching Types</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p style="color: #585858">Select the teaching types for <strong id="modal-module-name"></strong>:</p>
                                <div class="teaching-type-options">
                                    <label><input type="checkbox" name="teaching_types" value="cm" class="teaching-type-checkbox"> CM (Cours Magistraux)</label>
                                    <label><input type="checkbox" name="teaching_types" value="td" class="teaching-type-checkbox"> TD (Travaux Dirigés)</label>
                                    <label><input type="checkbox" name="teaching_types" value="tp" class="teaching-type-checkbox"> TP (Travaux Pratiques)</label>
                                    <label><input type="checkbox" name="teaching_types" value="all" id="all-teaching-type" onchange="toggleAllTeachingTypes()"> All</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary btn-sm" onclick="confirmTeachingTypes()">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching
        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            
            document.querySelectorAll('.nav-tab').forEach(tab => tab.classList.remove('active'));
            document.querySelector(`.nav-tab[data-tab="${tabId}"]`).classList.add('active');
        }

        // Track dropped modules with teaching types
        let droppedModules = [];
        let currentModuleId = null;

        // Filter modules
        function filterModules() {
            const filiereFilter = document.getElementById('filiere-filter').value;
            const nameSearch = document.getElementById('name-search').value.toLowerCase();
            const moduleCards = document.querySelectorAll('#available-modules-grid .module-card');
            
            moduleCards.forEach(card => {
                const filiere = card.querySelector('.detail-value').textContent;
                const name = card.querySelector('.module-name').textContent.toLowerCase();
                const matchesFiliere = filiereFilter ? filiere === filiereFilter : true;
                const matchesName = name.includes(nameSearch);
                card.style.display = matchesFiliere && matchesName ? 'block' : 'none';
            });
        }

        // Toggle all teaching types when "All" is checked
        function toggleAllTeachingTypes() {
            const allCheckbox = document.getElementById('all-teaching-type');
            const checkboxes = document.querySelectorAll('.teaching-type-checkbox:not(#all-teaching-type)');
            checkboxes.forEach(checkbox => {
                checkbox.checked = allCheckbox.checked;
            });
        }

        // Drag and Drop
        function dragStart(event) {
            event.dataTransfer.setData('text/plain', event.target.getAttribute('data-module-id'));
        }

        function allowDrop(event) {
            event.preventDefault();
        }

        function dropModule(event) {
            event.preventDefault();
            currentModuleId = event.dataTransfer.getData('text');
            const moduleCard = document.querySelector(`.module-card[data-module-id="${currentModuleId}"]`);
            if (moduleCard && !droppedModules.some(m => m.id == currentModuleId)) {
                const moduleName = moduleCard.querySelector('.module-name').textContent;
                // Show modal
                document.getElementById('modal-module-name').textContent = moduleName;
                const modal = document.getElementById('teachingTypeModal');
                modal.classList.add('show');
                modal.style.display = 'block';
                document.body.classList.add('modal-open');
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
            }
        }

        function confirmTeachingTypes() {
            const checkboxes = document.querySelectorAll('input[name="teaching_types"]:checked');
            if (checkboxes.length === 0) {
                alert('Please select at least one teaching type.');
                return;
            }
            const moduleCard = document.querySelector(`.module-card[data-module-id="${currentModuleId}"]`);
            if (moduleCard) {
                const moduleName = moduleCard.querySelector('.module-name').textContent;
                const teachingTypes = Array.from(checkboxes).map(checkbox => checkbox.value);
                const isAllSelected = teachingTypes.includes('all');
                const effectiveTypes = isAllSelected ? ['cm', 'td', 'tp'] : teachingTypes.filter(type => type !== 'all');
                
                droppedModules.push({
                    id: currentModuleId,
                    name: moduleName,
                    teachingTypes: effectiveTypes
                });
                renderDroppedModules();
            }
            // Close modal
            closeModal();
        }

        function closeModal() {
            const modal = document.getElementById('teachingTypeModal');
            modal.classList.remove('show');
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
            // Reset checkboxes
            document.querySelectorAll('input[name="teaching_types"]').forEach(input => input.checked = false);
            currentModuleId = null;
        }

        function renderDroppedModules() {
            const droppedContainer = document.getElementById('dropped-modules');
            droppedContainer.innerHTML = '';
            droppedModules.forEach(module => {
                const moduleItem = document.createElement('div');
                moduleItem.className = 'dropped-module-item';
                const typeLabels = module.teachingTypes.map(type => 
                    type === 'cm' ? 'CM' : type === 'td' ? 'TD' : 'TP'
                ).join(', ');
                moduleItem.innerHTML = `
                    <span>${module.name} (${typeLabels})</span>
                    <button type="button" class="cancel-btn" onclick="removeDroppedModule(${module.id})">×</button>
                    <input type="hidden" name="modules[${module.id}][module_id]" value="${module.id}">
                    <input type="hidden" name="modules[${module.id}][prof_id]" value="{{ $user->id }}">
                    <input type="hidden" name="modules[${module.id}][cm]" value="${module.teachingTypes.includes('cm') ? 'cm' : ''}">
                    <input type="hidden" name="modules[${module.id}][td]" value="${module.teachingTypes.includes('td') ? 'td' : ''}">
                    <input type="hidden" name="modules[${module.id}][tp]" value="${module.teachingTypes.includes('tp') ? 'tp' : ''}">
                `;
                droppedContainer.appendChild(moduleItem);
            });
        }

        function removeDroppedModule(moduleId) {
            droppedModules = droppedModules.filter(m => m.id !== moduleId);
            renderDroppedModules();
        }

        // Close modal on cancel button click
        document.querySelector('#teachingTypeModal .btn-secondary').addEventListener('click', closeModal);

        // Close modal on close button (×) click
        document.querySelector('#teachingTypeModal .close').addEventListener('click', closeModal);
    </script>

    <style>
        :root {
            --primary-color: #4723d9;
            --danger-color: #e74c3c;
            --success-color: #21b524;
            --neutral-color: #6c757d;
        }

        .progress-bar-container {
            width: 100%;
            height: 24px;
            background-color: #f0f0f0;
            border-radius: 12px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            border-radius: 12px;
            position: relative;
            transition: width 0.4s ease, background-color 0.4s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .min-marker, .max-marker {
            position: absolute;
            top: 0;
            width: 2px;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .min-marker::after, .max-marker::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: -3px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid rgba(0, 0, 0, 0.7);
        }

        .max-marker::after {
            bottom: auto;
            top: -4px;
        }

        .profile-container {
            background-color: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .profile-image {
            height: 150px;
            width: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid var(--primary-color);
            margin-bottom: 15px;
        }
        
        .profile-name {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .profile-role {
            color: var(--neutral-color);
            font-size: 16px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            color: #6f6f6f;
        }
        
        .info-item {
            margin-bottom: 15px;
        }
        
        .info-label {
            font-weight: 500;
            color: #555;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .info-value {
            padding: 10px 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            font-size: 15px;
        }
        
        .editable-field {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
        }
        
        .save-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
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
            max-height: 400px;
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

        .module-workload {
            display: flex;
            gap: 12px;
        }

        .workload-item {
            display: flex;
            align-items: center;
            gap: 4px;
            background: white;
            padding: 4px 10px;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .workload-label {
            font-weight: 600;
            font-size: 0.8rem;
            color: #5d596e8c;
        }

        .workload-value {
            font-weight: 600;
            font-size: 0.85rem;
            color: #2c3e50;
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

        .module-actions {
            padding: 12px 20px;
            border-top: 1px solid #f0f0f0;
            background: #f9f9f9;
        }

        .remove-btn {
            background: none;
            border: none;
            color: var(--danger-color);
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .remove-btn:hover {
            background: rgba(231, 76, 60, 0.1);
        }

        .remove-btn i {
            font-size: 0.95rem;
        }
        
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            text-align: center;
            color: var(--neutral-color);
        }
        
        .hours-progress-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .progress-bar-container {
            height: 10px;
            background: #f0f0f0;
            border-radius: 5px;
            position: relative;
        }
        
        .progress-bar {
            height: 100%;
            border-radius: 5px;
        }
        
        .min-marker, .max-marker {
            position: absolute;
            top: -5px;
            width: 2px;
            height: 20px;
            background: #333;
        }

        /* Styles for Available Modules Tab */
        .drop-area {
            border: 2px dashed var(--primary-color);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            margin-bottom: 20px;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .drop-area p {
            margin: 0;
            font-size: 1.2rem;
            color: var(--neutral-color);
            font-weight: 500;
        }

        .dropped-modules {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .dropped-module-item {
            display: flex;
            align-items: center;
            background-color: #e8ecef;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            color: #34495e;
        }

        .cancel-btn {
            background: none;
            border: none;
            color: var(--danger-color);
            font-size: 1rem;
            cursor: pointer;
            margin-left: 8px;
        }

        .cancel-btn:hover {
            color: #c0392b;
        }

        .module-filters {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-item {
            flex: 1;
            min-width: 200px;
        }

        .filter-label {
            display: block;
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .filter-item select,
        .filter-item input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .filter-item input {
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>') no-repeat right 10px center;
            background-size: 16px;
        }

        /* Teaching Type Modal */
        .teaching-type-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .teaching-type-options label {
            font-size: 0.95rem;
            color: #34495e;
        }

        .teaching-type-options input {
            margin-right: 8px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .profile-image {
                height: 100px;
                width: 100px;
            }
            .module-grid {
                grid-template-columns: 1fr;
            }
            .module-filters {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
@endcomponent
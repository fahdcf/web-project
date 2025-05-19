<x-chef_layout>
    <div class="container-fluid px-4 py-5">
        <!-- Header Section -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h1 class="display-6 fw-bold  mb-2" style="color: #4723d9">Liste des Modules</h1>
                <p class="text-muted mb-0">Explorez tous les modules disponibles par filière</p>
            </div>
            
            <!-- Filière Filter -->
            <div class="dropdown">
                <button class="btn filter-btn dropdown-toggle" type="button" id="filiereFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-funnel-fill me-2"></i>Filtrer par Filière
                </button>
                <ul class="dropdown-menu shadow" aria-labelledby="filiereFilterDropdown">
                    <li><a class="dropdown-item active" href="#" data-filiere="all">Toutes les filières</a></li>
                    @foreach ($filieres as $filiere)
                    <li><a class="dropdown-item" href="#" data-filiere="filiere-{{$filiere->id}}">{{$filiere->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

  <!-- Modules Listing -->
@foreach ($filieres as $filiere)
<div class="filiere-section mb-5" id="filiere-{{$filiere->id}}">
    <div class="d-flex align-items-center gap-3 mb-4">
        <h4 class="m-0 text-dark fw-semibold">Modules de {{$filiere->name}}</h4>
        <span class="badge bg-primary-soft text-primary rounded-pill px-3 py-2">
            {{ count($modules->where('filiere_id', $filiere->id)) }} module(s)
        </span>
    </div>

    @php
        $filiereModules = $modules->where('filiere_id', $filiere->id);
    @endphp

    @if($filiereModules->count() > 0)
        <div class="module-grid-container">
            <div class="module-grid">
                @foreach ($filiereModules as $module)
                <div class="module-card">
                    <div class="module-header">
                        <div class="module-title-container">
                            <h3 class="module-name">{{ $module->name }}</h3>
                            <div class="module-hours-badge">{{ $module->code }}</div>
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
                        <!-- Professor -->
                        <div class="detail-item">
                            <i class="bi bi-person-fill detail-icon"></i>
                            <div>
                                <span class="detail-label">Professeur</span>
                                <span class="detail-value">
                                    @if($module->professor)
                                        {{ $module->professor->firstname }} {{ $module->professor->lastname }}
                                    @else
                                        <span style="color: #e74c3c">Non associé</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <!-- Filière -->
                        <div class="detail-item">
                            <i class="bi bi-building detail-icon"></i>
                            <div>
                                <span class="detail-label">Filière</span>
                                <span class="detail-value">{{ $module->filiere->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        
                        <!-- Semester & Status -->
                        <div class="detail-item">
                            <i class="bi bi-calendar-week detail-icon"></i>
                            <div>
                                <span class="detail-label">Semester</span>
                                <span class="detail-value">
                                    {{ $module->semester == 1 ? '1er Semestre' : '2ème Semestre' }}
                                    <span class="badge {{ $module->status == 'active' ? 'bg-success' : 'bg-warning' }} ms-2">
                                        {{ $module->status }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Type -->
                        <div class="detail-item">
                            <i class="bi bi-tag-fill detail-icon"></i>
                            <div>
                                <span class="detail-label">Type</span>
                                <span class="detail-value">{{ $module->type }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="module-actions">
                        <button class="view-btn" onclick="showPopup({{$module->id}}, '{{$module->name}}')">
                            <i class="bi bi-eye-fill"></i> Voir plus
                        </button>
                       
                        
                    </div>
                </div>

      
                @endforeach
            </div>
        </div>
    @else
        <div class="alert alert-info bg-info-soft border-0">
            <i class="bi bi-info-circle-fill me-2"></i> Aucun module disponible pour cette filière
        </div>
    @endif
</div>
@endforeach



    <!-- Popup Template -->
    @foreach ($modules as $module)
    <div id="popupfor{{$module->id}}" class="overlay">
        <div class="popup bg-white rounded-3 p-4 shadow-lg" style="max-width: 600px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="text-primary fw-bold mb-0">Détails du module</h5>
                <button type="button" class="btn-close" onclick="closePopup({{$module->id}})"></button>
            </div>
            
            <div class="module-details">
                <div class="d-flex align-items-center mb-4">
                      <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-book fs-4" style="color: white !important;"></i>
                    </div>
                    <h4 class="mb-0 fw-bold " id="moduleName{{$module->id}}">{{ $module->name }}</h4>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted d-block">ID du module</small>
                            <span class="fw-semibold">{{ $module->id }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted d-block">Type</small>
                            <span class="fw-semibold">{{ $module->type }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted d-block">Crédit</small>
                            <span class="fw-semibold">{{ $module->credit }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted d-block">Évaluation</small>
                            <span class="fw-semibold">{{ $module->evaluation }}</span>
                        </div>
                    </div>
                    
                    @if($module->description)
                    <div class="col-12">
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted d-block">Description</small>
                            <p class="mb-0">{{ $module->description }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($module->responsable)
                    <div class="col-12">
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted d-block">Responsable</small>
                            <span class="fw-semibold">{{ $module->responsable->firstname }} {{ $module->responsable->lastname }}</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="col-12">
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted d-block">Date de création</small>
                            <span class="fw-semibold">{{ $module->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-end mt-4">
                <button type="button" class="btn btn-primary px-4" onclick="closePopup({{$module->id}})">Fermer</button>
            </div>
        </div>
    </div>
    @endforeach

    <style>
        :root {
            --primary: #4723d9;
            --primary-soft: #e8e5ff;
            --info-soft: #e6f7ff;
            --success-soft: #e6f7ed;
            --warning-soft: #fff8e6;
        }
        
        
            .filter-btn{
                color: #4723d9; 
                outline: 1px solid #4723d9;

            }

             .filter-btn:hover{
                color: #ffffff; 
                background-color: #4723d9;

            }

            .filter-btn:focus{
                color: #ffffff; 
                background-color: #4723d9;

            }


        body {
            background-color: #f8f9fa;
        }
        /* Modules Grid with Scroll */

.module-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    padding: 10px;
}

.module-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid #4723d91e;
    display: flex;
    flex-direction: column;
}

.module-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
}

.module-header {
    padding: 16px 20px;
    background: linear-gradient(135deg, #4723d9 0%, #6047c7 100%);
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
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.module-hours-badge {
    background: #ffffff14;
    color: white;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-left: 10px;
}

.module-workload {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
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
    flex: 1;
}

.detail-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.detail-icon {
    color: #4723d9;
    font-size: 1rem;
    margin-top: 2px;
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
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.view-btn {
    background: none;
    border: 1px solid #4723d9;
    color: #4723d9;
    font-size: 0.9rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 6px;
    transition: all 0.2s ease;
    flex: 1;
    justify-content: center;
}

.view-btn:hover {
    background: rgba(71, 35, 217, 0.1);
}

.remove-btn {
    background: none;
    border: 1px solid #e74c3c;
    color: #e74c3c;
    font-size: 0.9rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 6px;
    transition: all 0.2s ease;
    flex: 1;
    justify-content: center;
}

.remove-btn:hover {
    background: rgba(231, 76, 60, 0.1);
}

.view-btn i, .remove-btn i {
    font-size: 0.95rem;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.25em 0.6em;
}
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1050;
            backdrop-filter: blur(4px);
        }
        
        .popup {
            max-width: 90%;
            animation: fadeIn 0.3s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .filiere-section:not(:first-child) {
            padding-top: 2rem;
            border-top: 1px solid #4723d923;
        }
        
        @media (max-width: 768px) {
            .popup {
                max-width: 95%;
                margin: 1rem;
            }
        }
    </style>

    <script>
        // Show/hide filière sections based on filter
        document.querySelectorAll('[data-filiere]').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Update active state
                document.querySelectorAll('[data-filiere]').forEach(el => el.classList.remove('active'));
                this.classList.add('active');
                
                const filiereId = this.getAttribute('data-filiere');
                
                if(filiereId === 'all') {
                    // Show all sections
                    document.querySelectorAll('.filiere-section').forEach(section => {
                        section.style.display = 'block';
                    });
                } else {
                    // Hide all sections except the selected one
                    document.querySelectorAll('.filiere-section').forEach(section => {
                        section.style.display = 'none';
                    });
                    document.getElementById(filiereId).style.display = 'block';
                }
            });
        });
        
        // Existing popup functions
        function showPopup(moduleId, moduleName) {
            document.getElementById('moduleName' + moduleId).innerText = moduleName;
            document.getElementById("popupfor" + moduleId).style.display = "flex";
            document.body.style.overflow = 'hidden';
        }
        
        function closePopup(moduleId) {
            document.getElementById("popupfor" + moduleId).style.display = "none";
            document.body.style.overflow = 'auto';
        }
    </script>
</x-chef_layout>
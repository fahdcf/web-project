<!-- resources/views/coordinator/groups/manage.blade.php -->
<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-users me-2"></i>
                                Gestion des groupes - {{ $module->name }} ({{ $module->code }})
                            </h6>
                            <a href="{{ route('coordonnateur.groupes.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Retour
                            </a>
                        </div>
                        <div class="mt-2 small">
                            <span class="badge bg-secondary me-2">
                                Filière: {{ $module->filiere->name }}
                            </span>
                            <span class="badge bg-info">
                                Semestre: {{ $module->semester }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Onglets -->
                        <ul class="nav nav-tabs mb-4" id="groupsTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="td-tab" data-bs-toggle="tab" 
                                        data-bs-target="#td-groups" type="button">
                                    Groupes TD ({{ $tdGroups->count() }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tp-tab" data-bs-toggle="tab" 
                                        data-bs-target="#tp-groups" type="button">
                                    Groupes TP ({{ $tpGroups->count() }})
                                </button>
                            </li>
                        </ul>
                        
                        <!-- Contenu des onglets -->
                        <div class="tab-content" id="groupsTabContent">
                            <!-- Onglet TD -->
                            <div class="tab-pane fade show active" id="td-groups" role="tabpanel">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5>Groupes de Travaux Dirigés</h5>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" 
                                            data-bs-target="#addTdGroupModal">
                                        <i class="fas fa-plus me-1"></i> Ajouter groupe TD
                                    </button>
                                </div>
                                
                                @if($tdGroups->isEmpty())
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Aucun groupe TD n'a été créé pour ce module
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nom du groupe</th>
                                                    <th>Nombre d'étudiants</th>
                                                    <th>Capacité max</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($tdGroups as $group)
                                                    <tr>
                                                        <td>{{ $module->code }}-TD-{{ $group->id }}</td>
                                                        <td>{{ $group->nbr_student }}</td>
                                                        <td>{{ $group->max_students }}</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary edit-group"
                                                                    data-id="{{ $group->id }}"
                                                                    data-type="TD"
                                                                    data-max="{{ $group->max_students }}"
                                                                    data-current="{{ $group->nbr_student }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <form action="{{ route('coordonnateur.groupes.delete', $group->id) }}" 
                                                                  method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                        onclick="return confirm('Supprimer ce groupe?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Onglet TP -->
                            <div class="tab-pane fade" id="tp-groups" role="tabpanel">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5>Groupes de Travaux Pratiques</h5>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" 
                                            data-bs-target="#addTpGroupModal">
                                        <i class="fas fa-plus me-1"></i> Ajouter groupe TP
                                    </button>
                                </div>
                                
                                @if($tpGroups->isEmpty())
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Aucun groupe TP n'a été créé pour ce module
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nom du groupe</th>
                                                    <th>Nombre d'étudiants</th>
                                                    <th>Capacité max</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($tpGroups as $group)
                                                    <tr>
                                                        <td>{{ $module->code }}-TP-{{ $group->id }}</td>
                                                        <td>{{ $group->nbr_student }}</td>
                                                        <td>{{ $group->max_students }}</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary edit-group"
                                                                    data-id="{{ $group->id }}"
                                                                    data-type="TP"
                                                                    data-max="{{ $group->max_students }}"
                                                                    data-current="{{ $group->nbr_student }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <form action="{{ route('coordonnateur.groupes.delete', $group->id) }}" 
                                                                  method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                        onclick="return confirm('Supprimer ce groupe?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    {{-- @include('coordonnateur.groupes.modals.add-td')
    @include('coordonnateur.groupes.modals.add-tp')
    @include('coordonnateur.groupes.modals.edit-group') --}}

    @push('scripts')
    <script>
        // Gestion de l'édition de groupe
        document.querySelectorAll('.edit-group').forEach(btn => {
            btn.addEventListener('click', function() {
                const groupId = this.getAttribute('data-id');
                const groupType = this.getAttribute('data-type');
                const maxStudents = this.getAttribute('data-max');
                const currentStudents = this.getAttribute('data-current');
                
                // Remplir le modal d'édition
                document.getElementById('editGroupId').value = groupId;
                document.getElementById('editGroupType').value = groupType;
                document.getElementById('editMaxStudents').value = maxStudents;
                document.getElementById('editCurrentStudents').value = currentStudents;
                
                // Afficher le modal
                new bootstrap.Modal(document.getElementById('editGroupModal')).show();
            });
        });
    </script>
    @endpush
</x-coordonnateur_layout>
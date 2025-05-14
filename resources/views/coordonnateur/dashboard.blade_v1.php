<x-coordonnateur_layout>
    <!-- Styles spécifiques -->
    <style>
        .stat-card {
            transition: all 0.3s ease;
            border-left: 4px solid #0d6efd;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .module-item {
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }
        .module-item:hover {
            background-color: #f8f9fa;
            border-left-color: #0d6efd;
        }
    </style>





    <div class="border container-fluid py-4">
        <!-- En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-0">Tableau de Bord</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Coordonnateur</li>
                    </ol>
                </nav>
            </div>
            {{-- <a href="{{ route('coordinator.modules.create') }}" class="btn btn-primary"> --}}
                <i class="fas fa-plus me-2"></i>Nouveau Module
            {{-- </a> --}}
        </div>

        <!-- Cartes de statistiques -->
        <div class="row mb-4 border ">
            <div class="col-md-4">
                <div class="card stat-card h-100 ">
                    <div class="card-body ">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                <i class="fas fa-book text-primary fs-4"></i>
                            </div>
                            <div >
                                <h3 class="h6 mb-1">Modules Actifs</h3>
                                <p class="fs-3 fw-bold mb-0">{{ $stats['module_count'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card stat-card h-100" style="border-left-color: #198754;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                                <i class="fas fa-users text-success fs-4"></i>
                            </div>
                            <div>
                                <h3 class="h6 mb-1">Enseignants</h3>
                                <p class="fs-3 fw-bold mb-0">{{ $stats['teacher_count'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card stat-card h-100" style="border-left-color: #ffc107;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                                <i class="fas fa-check-circle text-warning fs-4"></i>
                            </div>
                            <div>
                                <h3 class="h6 mb-1">À Valider</h3>
                                <p class="fs-3 fw-bold mb-0">{{ $stats['pending_count'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Derniers modules -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">Derniers Modules</h2>
                {{-- <a href="{{ route('coordinator.modules.index') }}" class="btn btn-sm btn-outline-primary"> --}}
                    Voir tout <i class="fas fa-arrow-right ms-1"></i>
                {{-- </a> --}}
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentModules as $module)
                        <x-module-item :$module/>
                    @empty
                    <div class="list-group-item text-center py-4 text-muted">
                        Aucun module créé
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-light">
                <h3 class="h5 mb-0">Affectations à Valider</h3>
            </div>
            <div class="card-body">
                @if($pendingAssignments->isEmpty())
                    <p class="text-muted mb-0">Aucune affectation en attente</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th>Enseignant</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingAssignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->module->name }}</td>
                                    <td>{{ $assignment->professor->firstname }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('coordinator.assignments.validate', $assignment) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i> Valider
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

    <!-- Scripts spécifiques -->
    @push('scripts')
    <script>
        $(document).ready(function() {
            console.log('Dashboard coordonnateur prêt');
            // Ici vous pouvez ajouter du JS personnalisé
        });
    </script>
    @endpush
</x-coordonnateur_layout>
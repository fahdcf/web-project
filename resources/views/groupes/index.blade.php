<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-users me-2"></i>Gestion des Groupes - {{ $module->name }}</h6>
                        <div>
                            <a href="{{ route('groupes.create', $module->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus me-2"></i>Nouveau Groupe
                            </a>
                            <a href="{{ route('coordonnateur.modules.edit', $module->id) }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-arrow-left me-2"></i>Retour au Module
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($groupes->isEmpty())
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>Aucun groupe n'a été créé pour ce module.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="groups-table">
                                    <thead class="bg-light text-secondary">
                                        <tr>
                                            <th>Nom du Groupe</th>
                                            <th>Type</th>
                                            <th class="text-center">Capacité</th>
                                            <th class="text-center">Inscrits</th>
                                            <th class="text-center">Année</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($groupes as $groupe)
                                            <tr>
                                                <td>{{ $groupe->name ?? 'Groupe sans nom' }}</td>
                                                <td class="text-center">
                                                    @if ($groupe->type === 'TP')
                                                        <span class="badge bg-info text-white">TP</span>
                                                    @elseif ($groupe->type === 'TD')
                                                        <span class="badge bg-warning text-dark">TD</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $groupe->max_students ?? '-' }}</td>
                                                <td class="text-center">{{ $groupe->nbr_student ?? '-' }}</td>
                                                <td class="text-center">{{ $groupe->annee }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('groupes.edit', [$module->id, $groupe->id]) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('groupes.destroy', [$module->id, $groupe->id]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce groupe ?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#groups-table').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
                    },
                    // Optionnel: Autres options de DataTables pour un tableau plus riche
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "lengthChange": true,
                    "pageLength": 10 // Nombre d'éléments par page par défaut
                });
            });
        </script>
    @endpush

    @section('css')
        {{-- Optionnel: Styles CSS personnalisés pour cette page --}}
        <style>
            .card-header h6 {
                font-size: 1.1rem;
            }
            .table th, .table td {
                vertical-align: middle;
            }
            .btn-group .btn {
                margin-right: 0.2rem;
            }
            .btn-group .btn:last-child {
                margin-right: 0;
            }
        </style>
    @endsection
</x-coordonnateur_layout>
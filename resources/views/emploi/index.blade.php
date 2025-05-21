<x-coordonnateur_layout>
    <style>
        .accordion {
            background-color: white;
            box-shadow: 1px 1px 10px 2px #33333314;
        }

        .accordion-button {
            color: #333;
            box-shadow: none;
            transition: background-color 0.3s ease;
            border: none;
            border-radius: 5px;
            background-color: transparent;
        }

        .accordion-button:hover,
        .accordion-button:focus {
            border: none;
            outline: none;
            box-shadow: none;
            background-color: transparent;
            color: #333;
        }

        .accordion-button:not(.collapsed) {
            background-color: transparent;
            border: none;
            outline: none;
            box-shadow: none;
        }

        .accordion-body {
            padding: 1rem;
            font-size: 0.95rem;
            color: #555;
        }

        #collapsefilters {
            border: none;
        }

        select.form-select:focus {
            box-shadow: none !important;
        }

        .accordion-body button {
            margin-top: 32px;
            border: 1px solid #4723d9;
            border-radius: 4px;
            background-color: #4723d9;
            color: white;
            width: 100%;
            font-weight: 500;
            height: 37px;
            transition: 0.3s;
        }

        .accordion-body button:hover {
            background-color: white;
            color: #4723d9;
        }

        .table-container {
            background-color: white;
            width: 100%;
            display: flex;
            justify-content: center;
            overflow-y: hidden;
            overflow-x: auto;
            max-height: 80vh;
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
            box-shadow: 1px 1px 10px 2px #33333314;
        }

        table {
            min-width: 800px;
        }

        td {
            font-size: 14px;
            color: #585858;
            font-weight: 500;
            text-align: center !important;
            vertical-align: middle !important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(248, 248, 252, 0.006) !important;
            cursor: pointer;
        }

        .table-container::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background-color: #aaa;
            border-radius: 10px;
        }

        .table-container::-webkit-scrollbar-track {
            background: transparent;
        }

        th {
            text-align: center;
            border-bottom: 1px solid #3737375a !important;
            border-top: none !important;
            color: rgb(80, 79, 79);
            font-size: 15px;
            font-weight: 600;
        }

        table thead {
            box-shadow: 0 7px 5px -6px rgba(0, 0, 0, 0.1);
        }

        .modal-content {
            border-radius: 8px;
            box-shadow: 1px 1px 10px 2px #33333314;
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
    </style>

    <div class="container-fluid p-0 pt-5">
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


        <div class="pt-5 pb-2">
            <div class="accordion rounded" id="accordionFilters">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapsefilters" aria-expanded="false" aria-controls="collapsefilters">
                            <i class="bi bi-funnel-fill me-2"></i> Filtres avancés
                        </button>
                    </h2>
                    <div id="collapsefilters" class="accordion-collapse collapse" data-bs-parent="#accordionFilters">
                        <div class="accordion-body pt-0">
                            <form id="filterForm" action="{{ route('emploi.index') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-6 col-lg-4">
                                        <label for="academic_year" class="form-label small fw-bold text-muted">Année
                                            Académique</label>
                                        <select class="form-select" id="academic_year" name="academic_year">
                                            <option value="">Toutes les années</option>
                                            @foreach ($academicYears as $year)
                                                <option value="{{ $year }}"
                                                    {{ request('academic_year') == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-lg-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="bi bi-filter-circle me-1"></i> Filtrer
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-container mt-4 mb-5 flex-column">
            <div class="table-responsive p-3">
                <table class="table bg-white table-hover">
                    <thead>
                        <tr>
                            <th>Semestre</th>
                            <th>Emploi du Temps</th>
                            <th>is_active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($semester = 1; $semester <= 6; $semester++)
                            @php
                                $emploi = $emplois->firstWhere('semester', $semester);
                            @endphp
                            <tr>
                                <td>S{{ $semester }}</td>
                                <td>
                                    @if ($emploi)
                                        {{ $emploi->name }}
                                    @else
                                        <span class="text-muted">Non configuré</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($emploi)
                                        <span
                                            class="badge rounded-pill bg-{{ $emploi->is_active  == true ? 'success' : 'danger' }}">
                                            {{ $emploi->is_active  == true ? 'Actif' : 'Inactif' }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif





                                </td>

                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        @if ($emploi)
                                            <a href="{{ route('emploi.edit', $emploi->id) }}" class="btn btn-sm"
                                                style="background-color:#4723d9; color:#ffffff;" title="Modifier">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteEmploiModal{{ $emploi->id }}"
                                                title="Supprimer">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        @else
                                            <a href="{{ route('emploi.create', ['semester' => $semester]) }}"
                                                class="btn btn-sm" style="background-color:#4723d9; color:#ffffff;"
                                                title="Créer">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                        @endif
                                    </div>

                                    @if ($emploi)
                                        <div class="modal fade" id="deleteEmploiModal{{ $emploi->id }}"
                                            tabindex="-1" aria-labelledby="deleteEmploiModalLabel{{ $emploi->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteEmploiModalLabel{{ $emploi->id }}">
                                                            Confirmation de Suppression
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Voulez-vous supprimer l'emploi du temps
                                                            <strong>{{ $emploi->name }}</strong>
                                                            (S{{ $semester }}) définitivement ?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">Fermer</button>
                                                        <form action="{{ route('emploi.destroy', $emploi->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                Supprimer
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-coordonnateur_layout>

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

        .pagehead button {
            border: none;
            background: none;
        }

        .pagehead input:focus {
            outline: none;
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
            min-width: 1100px;
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
            z-index: 1000;
        }

        .popup {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 400px;
        }

        .popup button {
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

    <div class="container-fluid p-0 pt-5">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <h3 style="color: #330bcf; font-weight: 500;">Liste des vacataires</h3>
            <a type="submit" href="{{ route('coordonnateur.vacataires.create') }}"
                class="btn text-white rounded  fw-semibold my-2"
                style=" background-color: #4723d9; color:#ebebec !important;vertical-align: middle ;">
                Ajouter un vacataire
            </a>
        </div>


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
                            <form id="filterForm" action="{{ route('coordonnateur.vacataires.index') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-6 col-lg-4">
                                        <label for="search"
                                            class="form-label small fw-bold text-muted">Recherche</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i
                                                    class="bi bi-search"></i></span>
                                            <input type="text" id="search" name="search"
                                                class="form-control border-start-0" placeholder="Nom, ID ou email"
                                                value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <label for="statusFilter"
                                            class="form-label small fw-bold text-muted">Statut</label>
                                        <select class="form-select" id="statusFilter" name="status">
                                            <option value="">Tous les statuts</option>
                                            <option value="active"
                                                {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                                            <option value="inactive"
                                                {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <label for="rowsPerPage"
                                            class="form-label small fw-bold text-muted">Affichage</label>
                                        <select id="rowsPerPage" name="rows" class="form-select">
                                            <option value="5" {{ request('rows') == '5' ? 'selected' : '' }}>5
                                                lignes</option>
                                            <option value="15" {{ request('rows') == '15' ? 'selected' : '' }}>15
                                                lignes</option>
                                            <option value="30" {{ request('rows') == '30' ? 'selected' : '' }}>30
                                                lignes</option>
                                            <option value="100" {{ request('rows') == '100' ? 'selected' : '' }}>100
                                                lignes</option>
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
            <div class="table-responsive p-3 ">
                <table class="table bg-white  table-hover">
                    <thead>
                        <tr class="text-light">
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Nom complet</th>
                            <th>État</th>
                            <th>Email</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($vacataires as $vacataire)
                            <tr>
                                <td>{{ $vacataire->id }}</td>
                                <td>
                                    <a href="{{ route('coordonnateur.vacataires.show', $vacataire->id) }}">
                                        @if ($vacataire->userDetails && $vacataire->userDetails->profile_img)
                                            <img style="height: 40px;width: 40px;object-fit:cover;border-radius:50%;"
                                                src="{{ asset('storage/' . $vacataire->userDetails->profile_img) }}">
                                        @else
                                            <img style="height: 40px;width: 40px;object-fit:cover;border-radius:50%;"
                                                src="{{ asset('storage/images/default_profile_img.png') }}">
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ $vacataire->lastname }}
                                            {{ $vacataire->firstname }}</span>
                                        <small class="text-muted">Vacataire</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($vacataire->userDetails)
                                        <span
                                            class="badge rounded-pill bg-{{ $vacataire->userDetails->status == 'active' ? 'success' : 'danger' }}">
                                            {{ $vacataire->userDetails->status == 'active' ? 'Actif' : 'Inactif' }}
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="mailto:{{ $vacataire->email }}"
                                        class="text-primary">{{ $vacataire->email }}</a>
                                </td>
                                <td class="text-center">{{ $vacataire->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('assign', $vacataire->id) }}" class="btn btn-sm btn-primary"
                                            title="Assigner UE">
                                            <i class="bi bi-journal-plus"></i>
                                        </a>
                                        <a href="{{ route('coordonnateur.vacataires.edit', $vacataire->id) }}"
                                            class="btn btn-sm" style="background-color:#4723d9;color: #ffffff;">
                                            <i class="bi bi-pencil-square"></i>

                                        </a>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteVacataireModal{{ $vacataire->id }}"
                                            title="Supprimer"><i class="bi bi-trash3"></i>
                                        </button>


                                        <div class="modal fade" id="deleteVacataireModal{{ $vacataire->id }}"
                                            tabindex="-1" aria-labelledby="deleteVacataireModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteVacataireModalLabel">
                                                            Confirmation de suppression</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Voulez-vous supprimer le vacataire
                                                            <strong>{{ $vacataire->lastname }}
                                                                {{ $vacataire->firstname }}</strong>
                                                            définitivement?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">Fermer</button>
                                                        <form
                                                            action="{{ route('coordonnateur.vacataires.destroy', $vacataire->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Supprimer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{--  --}}

            {{-- pagination --}}
            <div class="d-flex justify-content-center my-4">
                @if ($vacataires->onFirstPage())
                    <span class="btn btn-secondary mx-1 disabled">Précédent</span>
                @else
                    <a href="{{ $vacataires->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                        class="btn mx-1" style="background-color:#4723d9;color:white;">
                        Précédent
                    </a>
                @endif

                @if ($vacataires->hasMorePages())
                    <a href="{{ $vacataires->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                        class="btn mx-1" style="background-color:#4723d9;color:white;">
                        Suivant
                    </a>
                @else
                    <span class="btn btn-secondary mx-1 disabled">Suivant</span>
                @endif
            </div>
        </div>


    </div>

</x-coordonnateur_layout>

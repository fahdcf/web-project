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

        <x-global_alert />

        <div class="header-container mb-4">
            <style>
                .header-container {
                    background: white;
                    border-radius: 8px;
                    padding: 20px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                }

                .header-title {
                    color: #4723d9;
                    font-weight: 600;
                    font-size: 1.75rem;
                    margin: 0;
                }

                .form-select {
                    border-color: #e0e0e0;
                    font-size: 0.9rem;
                    padding: 8px 12px;
                    border-radius: 6px;
                    background-color: #f8f9fa;
                    transition: border-color 0.2s;
                }

                .form-select:focus {
                    border-color: #4723d9;
                    box-shadow: 0 0 0 2px rgba(71, 35, 217, 0.2);
                    outline: none;
                }

                /* .btn-primary {
                    background-color: #4723d9;
                    border-color: #4723d9;
                    font-size: 0.9rem;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-weight: 500;
                    transition: all 0.2s;
                } */

                .btn-primary:hover {
                    background-color: white;
                    color: #4723d9;
                    border-color: #4723d9;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .btn-outline-primary {
                    border-color: #4723d9;
                    color: #4723d9;
                    font-size: 0.9rem;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-weight: 500;
                    transition: all 0.2s;
                    white-space: nowrap;
                }

                .btn-outline-primary:hover {
                    background-color: #4723d9;
                    color: white;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .btn-outline-primary:hover .btn-text-prof {
                    color: white;
                }

                .btn-text-emploi,
                .btn-text-prof {
                    display: inline;
                }

                @media (max-width: 768px) {
                    .header-container {
                        padding: 15px;
                    }

                    .header-title {
                        font-size: 1.5rem;
                        margin-bottom: 15px;
                        text-align: center;
                    }

                    .form-select,
                    .btn-outline-primary {
                        width: 100%;
                        margin-bottom: 10px;
                    }

                    .btn-outline-primary {
                        white-space: normal;
                        text-align: center;
                        padding: 10px 16px;
                    }

                    .btn-text-emploi,
                    .btn-text-prof {
                        display: block;
                    }

                    .btn-text-emploi {
                        margin-bottom: 2px;
                    }
                }

                /* Improved grid layout */
                .header-grid {
                    display: grid;
                    grid-template-columns: 1fr auto auto;
                    gap: 1rem;
                    align-items: center;
                }

                @media (max-width: 992px) {
                    .header-grid {
                        grid-template-columns: 1fr auto;
                    }

                    .header-title {
                        grid-column: 1 / -1;
                        text-align: center;
                        margin-bottom: 10px;
                        text-decoration: underline;
                    }
                }

                @media (max-width: 768px) {
                    .header-grid {
                        grid-template-columns: 1fr;
                        gap: 0.75rem;
                    }

                    .btn-outline-primary {
                        white-space: normal;
                        text-align: center;
                        padding: 10px 16px;
                        line-height: 1.3;
                        /* Add this for better line spacing */
                    }

                    .btn-text-emploi,
                    .btn-text-prof {
                        display: inline;
                        /* Change from 'block' to 'inline' */
                        margin-bottom: 0;
                        /* Remove bottom margin */
                    }

                    .btn-text-emploi:after {
                        content: " ";
                        /* Add space after "Emploi des" */
                    }

                }

                .btn-primary {
                    background-color: #4723d9;
                    border-color: #4723d9;
                    font-size: 0.9rem;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-weight: 500;
                    transition: all 0.2s;
                    display: inline-flex;
                    /* Changed from default */
                    align-items: center;
                    /* Vertically center items */
                    gap: 8px;
                    /* Space between icon and text */
                }

                .btn-primary i {
                    font-size: 1em;
                    /* Match icon size with text */
                    line-height: 1;
                    /* Fix vertical alignment */
                }
            </style>

            <div class="header-grid mt">
                <div class="d-flex align-items-center gap-3">
                    <h3 style="color: #330bcf; font-weight: 500;">Gestion des vacataires du filiere :</h3>
                </div>

                <a href="{{ route('coordonnateur.vacataires.create') }}"
                    class="btn btn-primary rounded fw-semibold my-2 me-2">
                    <i class="bx bx-user-plus nav_icon"></i>
                    Ajouter un vacataire
                </a>
            </div>

        </div>


        <div class="header-container mb-4">
            <div class="row g-3">
                <div class="col-md-6 col-lg-6">
                    <label for="search" class="form-label small fw-bold text-muted">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="bi bi-search"></i></span>
                        <input type="text" id="search" name="search" class="form-control border-start-0"
                            placeholder="Nom, ID ou email" value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Status Filter Dropdown -->
                <div class="col-md-6 col-lg-3 filter-dropdown">
                    <label for="statusFilter" class="form-label small fw-bold text-muted">Statut</label>
                    <select id="statusFilter" class="form-select border border-primary text-primary"
                        style=" font-weight: 500;"
                        onchange="window.location.href='{{ route('coordonnateur.vacataires.index') }}?status=' + this.value">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>
                            Tous</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>


                <div class="col-md-6 col-lg-3 filter-dropdown">
                    <label for="rowsFilter" class="form-label small fw-bold text-muted">Affichage</label>
                    <select id="rowsFilter" class="form-select border border-primary text-primary"
                        style=" font-weight: 500;"
                        onchange="window.location.href='{{ route('coordonnateur.vacataires.index') }}?rows=' + this.value">
                        <option value="5" {{ request('rows') == '5' ? 'selected' : '' }}>5
                            lignes</option>
                        <option value="15" {{ request('rows') == '15' ? 'selected' : '' }}>
                            15
                            lignes</option>
                        <option value="30" {{ request('rows') == '30' ? 'selected' : '' }}>
                            30
                            lignes</option>
                        <option value="100" {{ request('rows') == '100' ? 'selected' : '' }}>100
                            lignes</option>
                    </select>
                </div>
            </div>

        </div>
       

        <style>
            /* Custom styling for better appearance */
            .filter-dropdown select {
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .filter-dropdown select:hover {
                border-color: #4723d9 !important;
                box-shadow: 0 0 0 2px rgba(71, 35, 217, 0.1);
            }

            .search-bar .input-group {
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            }

            .search-bar .form-control:focus {
                box-shadow: none;
                border-color: #ced4da;
            }

            .search-bar .input-group-text {
                transition: all 0.3s ease;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .d-flex.flex-wrap {
                    gap: 12px !important;
                }

                .filter-dropdown select,
                .search-bar {
                    width: 100% !important;
                    max-width: 100% !important;
                }
            }
        </style>

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
                                    @if ($vacataire->user_details)
                                        <span
                                            class="status-indicator status-{{ $vacataire->user_details->status == 'active' ? 'active' : 'inactive' }}">
                                            {{ $vacataire->user_details->status == 'active' ? 'Actif' : 'Inactif' }}
                                        </span>
                                    @else
                                        <span class="status-undefined">-</span>
                                    @endif


                                    <style>
                                        /* Status indicator styling */
                                        .status-indicator {
                                            display: inline-block;
                                            padding: 4px 8px;
                                            border-radius: 12px;
                                            font-size: 0.85rem;
                                            font-weight: 500;
                                        }

                                        .status-active {
                                            background-color: #e6f7ee;
                                            color: #0a7b4c;
                                        }

                                        .status-inactive {
                                            background-color: #feeceb;
                                            color: #d92d20;
                                        }

                                        .status-undefined {
                                            color: #6c757d;
                                        }

                                        /* Action buttons styling */
                                        .action-btn {
                                            padding: 0.25rem 0.5rem;
                                            font-size: 0.875rem;
                                            border-radius: 4px;
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 4px;
                                        }

                                        .btn-create {
                                            background-color: #4723d9;
                                            color: white;
                                        }

                                        .btn-create:hover {
                                            background-color: #3a1cb3;
                                        }
                                    </style>


                                </td>
                                <td>
                                    <a href="mailto:{{ $vacataire->email }}"
                                        class="text-primary">{{ $vacataire->email }}</a>
                                </td>
                                <td class="text-center">{{ $vacataire->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('assign', $vacataire->id) }}"
                                            class="btn btn-sm btn-primary" title="Assigner UE">
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

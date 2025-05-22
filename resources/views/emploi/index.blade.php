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

                .btn-primary {
                    background-color: #4723d9;
                    border-color: #4723d9;
                    font-size: 0.9rem;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-weight: 500;
                    transition: all 0.2s;
                }

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
            </style>

            <div class="header-grid">
                <h3 class="header-title">Emplois du Temps - {{ $filiere->name }}</h3>

                <select class="form-select" onchange="window.location.href=this.value">
                    <option value="">Toutes les années</option>
                    @foreach ($academicYears as $year)
                        <option value="{{ route('emploi.index', ['academic_year' => $year]) }}"
                            {{ $academicYear == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>

                <a href="{{ route('emploi.prof') }}" class="btn btn-outline-primary">
                    <i class="bi bi-person me-2"></i>
                    <span class="btn-text-emploi">Emploi des</span>
                    <span class="btn-text-prof">Profs</span>
                </a>
            </div>
        </div>




        <div class="table-container mt-4 mb-5 flex-column">
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

            <div class="table-responsive p-3">
                <table class="table bg-white table-hover">
                    <thead>
                        <tr>
                            <th>Semestre</th>
                            <th>Emploi du Temps</th>
                            <th>Statut</th>
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
                                            class="status-indicator status-{{ $emploi->is_active ? 'active' : 'inactive' }}">
                                            {{ $emploi->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    @else
                                        <span class="status-undefined">-</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        @if ($emploi)
                                            <a href="{{ route('emploi.edit', $emploi->id) }}"
                                                class="btn btn-sm action-btn"
                                                style="background-color:#4723d9; color:#ffffff;" title="Modifier">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm action-btn" data-bs-toggle="modal"
                                                data-bs-target="#deleteEmploiModal{{ $emploi->id }}"
                                                title="Supprimer">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        @else
                                            <a href="{{ route('emploi.create', ['semester' => $semester]) }}"
                                                class="btn btn-sm action-btn btn-create" title="Créer">
                                                <i class="bi bi-plus-circle"></i>
                                                <span>Créer</span>
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

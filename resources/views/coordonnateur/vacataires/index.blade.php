<x-coordonnateur_layout>

    <style>
        /* Main Container */
        .vacataire-container {
            padding: 2rem;
            min-height: 80vh;
        }

        /* Header */
        .header-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Filter Section */
        .header-grid.mb-4 {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #34495e;
        }

        .form-select,
        .form-control {
            border-color: #e0e0e0;
            border-radius: 6px;
            transition: border-color 0.2s;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #4723d9;
            box-shadow: 0 0 0 2px rgba(71, 35, 217, 0.2);
        }

        .input-group-text {
            border-color: #e0e0e0;
            background: transparent;
        }

        /* Buttons */
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

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-success:hover {
            background-color: white;
            color: #28a745;
            border-color: #28a745;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-danger:hover {
            background-color: white;
            color: #dc3545;
            border-color: #dc3545;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dropdown-menu {
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #4723d9;
        }

        /* Table Section */
        .table-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
        }

        .table-responsive::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background-color: #aaa;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: transparent;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 1100px;
        }

        .table thead th {
            background-color: #4723d9;
            color: white;
            padding: 1rem;
            font-weight: 500;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table tbody tr {
            transition: all 0.2s;
        }

        .table tbody tr:hover {
            background-color: #f9f9ff !important;
            transform: translateX(4px);
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
            color: #555;
            font-weight: 400;
        }

        /* Professor Card Elements */
        .professor-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #eee;
            transition: all 0.3s;
        }

        .professor-avatar:hover {
            transform: scale(1.1);
            border-color: #4723d9;
        }

        .professor-name {
            font-weight: 500;
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background-color: #e6f7ee;
            color: #28a745;
        }

        .status-inactive {
            background-color: #fde8e8;
            color: #dc3545;
        }

        /* Hours Progress Bar */
        .hours-container {
            min-width: 150px;
        }

        .hours-label {
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
            color: #666;
            display: flex;
            justify-content: space-between;
        }

        .hours-progress {
            height: 8px;
            background-color: #f0f0f0;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        .hours-filled {
            height: 100%;
            border-radius: 4px;
            position: absolute;
            left: 0;
            top: 0;
        }

        .hours-min-marker {
            position: absolute;
            top: 0;
            height: 100%;
            width: 3px;
            background-color: #ff6b6b;
        }

        .hours-max-marker {
            position: absolute;
            top: 0;
            height: 100%;
            width: 3px;
            background-color: #4723d9;
        }

        /* Action Buttons */
        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .view-btn {
            background-color: #4723d9;
            color: white;
        }

        .view-btn:hover {
            background-color: #3a1cb3;
            transform: rotate(5deg);
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c82333;
            transform: rotate(5deg);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #666;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .header-grid {
                grid-template-columns: 1fr;
            }

            .header-grid .d-flex.gap-2 {
                justify-content: center;
            }

            .row.g-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="vacataire-container">
        <div class="header-grid">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-user-graduate fa-2x" style="color: #330bcf;"></i>
                <h3 style="color: #330bcf; font-weight: 500;">Gestion des Vacataires</h3>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('coordonnateur.vacataires.create') }}" class="btn btn-primary rounded fw-semibold">
                    <i class="fas fa-plus-circle"></i> Ajouter un compte vacataire
                </a>
                <div class="dropdown">
                    <button class="btn btn-success rounded fw-semibold dropdown-toggle" type="button"
                        id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-file-export"></i> Exporter
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('coordonnateur.vacataires.export') }}">
                                Tous les Vacataires
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="header-grid mb-4">
            <div class="row g-2">
                <div class="col-md-3 col-sm-6 col-lg-3 filter-dropdown">
                    <label for="status" class="form-label small fw-bold text-muted">Statut</label>
                    <select id="status" class="form-select border border-primary text-primary"
                        style="font-weight: 500;">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tous</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                            Actif
                        </option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                            Inactif
                        </option>
                    </select>
                </div>

                <div class="col-md-6 col-sm-12 col-lg-6 search-bar">
                    <label for="moduleSearch" class="form-label small fw-bold text-muted">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0" id="moduleSearch"
                            placeholder="Rechercher par nom ou email...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <div class="table-responsive">
                <table class="table" id="vacatairesTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Charge de travail</th>
                            <th>Professeur</th>
                            <th>Statut</th>
                            <th>Email</th>
                            <th>Créé le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="vacatairesTableBody">
                        @forelse ($vacataires as $vacataire)
                            <tr class="professor-row" data-id="{{ $vacataire['id'] }}"
                                data-name="{{ strtolower($vacataire->lastname . ' ' . $vacataire->firstname) }}"
                                data-email="{{ strtolower($vacataire['email']) }}"
                                data-status="{{ $vacataire->user_details ? $vacataire->user_details->status : '' }}">
                                <td>#{{ $vacataire['id'] }}</td>

                                <td>
                                    <a href="{{ url('profile/' . $vacataire->id) }}">
                                        @if ($vacataire->user_details && $vacataire->user_details->profile_img)
                                            <img class="professor-avatar"
                                                src="{{ asset('storage/' . $vacataire->user_details->profile_img) }}">
                                        @else
                                            <img class="professor-avatar"
                                                src="{{ asset('storage/images/default_profile_img.png') }}">
                                        @endif
                                    </a>
                                </td>

                                <td class="hours-container">
                                    @php
                                        $min = $vacataire->user_details->min_hours ?? 0;
                                        $max = $vacataire->user_details->max_hours ?? 0;
                                        $current = $vacataire->hours ?? 0;

                                        $current_percent = $max > 0 ? round(($current / $max) * 100) : 0;
                                        $min_percent = $max > 0 ? round(($min / $max) * 100) : 0;

                                        if ($current < $min) {
                                            $color = '#ff6b6b'; // Rouge pour sous le minimum
                                        } elseif ($current > $max) {
                                            $color = '#ff922b'; // Orange pour au-dessus du maximum
                                        } else {
                                            $color = '#51cf66'; // Vert pour adéquat
                                        }
                                    @endphp

                                    <div class="hours-label">
                                        <span>{{ $current }}h</span>
                                        <span>Min: {{ $min }}h / Max: {{ $max }}h</span>
                                    </div>

                                    <div class="hours-progress">
                                        <div class="hours-filled"
                                            style="width: {{ $current_percent }}%; background-color: {{ $color }};">
                                        </div>
                                        <div class="hours-min-marker" style="left: {{ $min_percent }}%;"></div>
                                        <div class="hours-max-marker" style="left: 100%;"></div>
                                    </div>
                                </td>

                                <td class="professor-name">{{ $vacataire->lastname }} {{ $vacataire->firstname }}
                                </td>

                                <td>
                                    @if ($vacataire->user_details)
                                        <span class="status-badge status-{{ $vacataire->user_details->status }}">
                                            {{ ucfirst($vacataire->user_details->status) }}
                                        </span>
                                    @else
                                        <span class="status-badge">Inconnu</span>
                                    @endif
                                </td>

                                <td>{{ $vacataire['email'] }}</td>

                                <td>{{ $vacataire->created_at->format('Y-m-d') }}</td>

                                <td class="p-0">
                                    <div class="d-flex justify-content-center gap-3">
                                        <a href="{{ route('coordonnateur.vacataire.assignemts_profile', $vacataire->id) }}"
                                            class="action-btn view-btn" title="Voir le profil">
                                            <i class="bi bi-file-earmark-plus"></i>
                                        </a>
                                        <a href="{{ url('profile/' . $vacataire->id) }}" class="action-btn view-btn"
                                            title="Voir le profil">
                                            <i class="bi bi-person-square"></i>
                                        </a>
                                        <form action="{{ route('coordonnateur.vacataires.destroy', $vacataire->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn" title="Supprimer"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce vacataire ?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Rien n'est affiché si la liste est vide -->
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Cache des éléments DOM
            const searchInput = document.getElementById('moduleSearch');
            const statusFilter = document.getElementById('status');
            const vacataireRows = document.querySelectorAll('.professor-row');

            // Initialisation
            filterVacataires();

            // Écouteurs d'événements
            searchInput.addEventListener('input', filterVacataires);
            statusFilter.addEventListener('change', filterVacataires);

            // Fonction de filtrage
            function filterVacataires() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const statusValue = statusFilter.value;

                vacataireRows.forEach(row => {
                    const name = row.dataset.name;
                    const email = row.dataset.email;
                    const status = row.dataset.status;

                    // Recherche par nom ou email
                    const matchesSearch = searchTerm === '' ||
                        name.includes(searchTerm) ||
                        email.includes(searchTerm);

                    // Filtrage par statut
                    const matchesStatus = statusValue === 'all' ||
                        status === statusValue;

                    // Afficher/masquer la ligne
                    row.style.display = matchesSearch && matchesStatus ? '' : 'none';
                });
            }
        });
    </script>

</x-coordonnateur_layout>
<x-admin_layout>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js" onerror="console.error('Failed to load Flatpickr')"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js" onerror="console.error('Failed to load Chart.js')"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js" onerror="console.error('Failed to load ExcelJS')"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js" onerror="console.error('Failed to load FileSaver.js')"></script>
</head>

<div class="requests-container">
    <!-- Header -->
    <div class="header-grid mb-5">
        <div class="d-flex align-items-center gap-3">
            <i class="fas fa-book-open fa-2x" style="color: #4723d9;"></i>
            <h2 class="fw-bold" style="color: #1a1a1a;">Gestion des Connexions</h2>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button onclick="exportStyledExcel()" class="btn btn-outline-success">
                <i class="bi bi-file-excel"></i> Exporter Excel
            </button>
         
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card overview-card">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-sign-in-alt fa-2x me-3" style="color: #4723d9;"></i>
                    <div>
                        <h6 class="card-title mb-1 text-muted fw-medium">Connexions Aujourd'hui</h6>
                        <h3 class="card-text fw-bold" style="color: #1a1a1a;">{{ $todayLogins }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card overview-card">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-calendar-week fa-2x me-3" style="color: #4723d9;"></i>
                    <div>
                        <h6 class="card-title mb-1 text-muted fw-medium">Connexions Semaine</h6>
                        <h3 class="card-text fw-bold" style="color: #1a1a1a;">{{ $weekLogins }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card overview-card">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-users fa-2x me-3" style="color: #4723d9;"></i>
                    <div>
                        <h6 class="card-title mb-1 text-muted fw-medium">Utilisateurs Uniques</h6>
                        <h3 class="card-text fw-bold" style="color: #1a1a1a;">{{ $uniqueUsers }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card overview-card">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-chart-line fa-2x me-3" style="color: #4723d9;"></i>
                    <div>
                        <h6 class="card-title mb-1 text-muted fw-medium">Jour le Plus Actif</h6>
                        <h3 class="card-text fw-bold" style="color: #1a1a1a;">{{ $mostActiveDay }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card filter-card mb-5">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-3 align-items-center">
                <div class="search-container">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="logSearchInput" class="form-control log-search-input" placeholder="Rechercher par utilisateur..." value="{{ request()->input('search') }}">
                </div>
                <div class="search-container">
                    <select id="actionFilter" class="form-select">
                        <option value="">-- Type d'action --</option>
                        @foreach ($actions as $action)
                            <option value="{{ $action }}" {{ request()->input('action') == $action ? 'selected' : '' }}>{{ $action }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="search-container">
                    <input type="text" id="dateRange" class="form-control" placeholder="Sélectionner la plage de dates">
                </div>
                <div class="search-container">
                    <select id="timePreset" class="form-select">
                        <option value="">Période</option>
                        <option value="today">Aujourd'hui</option>
                        <option value="week">Cette Semaine</option>
                        <option value="month">Ce Mois</option>
                    </select>
                </div>
                <button class="btn btn-outline-secondary fw-medium" onclick="resetFilters()">
                    <i class="bi bi-arrow-counterclockwise"></i> Réinitialiser
                </button>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="card chart-card mb-5">
        <div class="card-body">
            <h5 class="card-title fw-semibold text-center mb-4" style="color: #1a1a1a;">Nombre de connexions par jour</h5>
            <div class="chart-container">
                <canvas id="loginChart" style="width: 100%;"></canvas>
                <div id="chartError" style="display: none; text-align: center; color: #6b7280; padding: 1rem;">Aucune donnée disponible ou erreur de chargement</div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-semibold mb-0" style="color: #1a1a1a;">Historique des Connexions</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm fw-medium" onclick="toggleSort()">
                        <i class="bi bi-sort-down"></i> <span id="sortText">Trier par Date ↓</span>
                    </button>
                  
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless" id="exportTable">
                    <thead>
                        <tr style="color: #1a1a1a; font-weight: 600;">
                            <th>Utilisateur</th>
                            <th>Action</th>
                            <th>Date</th>
                            <th class="ip-column">Adresse IP</th>
                        </tr>
                    </thead>
                    <tbody id="logTableBody">
                        @foreach ($users_logs as $user_log)
                            <tr class="log-row custom-row-wrapper"
                                data-id="{{ $user_log->id }}"
                                data-user="{{ $user_log->user ? strtolower($user_log->user->firstname . ' ' . $user_log->user->lastname) : 'unknown' }}"
                                data-action="{{ strtolower($user_log->action) }}"
                                data-date="{{ $user_log->created_at->format('Y-m-d H:i:s') }}">
                                <td class="m-3">
                                    <div class="custom-row d-flex align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ url('profile/' . $user_log->user->id) }}">
                                                @if ($user_log->user->user_details && $user_log->user->user_details->profile_img)
                                                    <img style="height: 40px; width: 40px; object-fit: cover; border-radius: 50%; background-color: #e5e7eb;" src="{{ asset('storage/' . $user_log->user->user_details->profile_img) }}">
                                                @else
                                                    <img style="height: 40px; width: 40px; object-fit: cover; border-radius: 50%;" src="{{ asset('storage/images/default_profile_img.png') }}">
                                                @endif
                                            </a>
                                            <p>
                                                <a href="{{ url('profile/' . $user_log->user->id) }}" class="text-decoration-none">
                                                    <strong style="color: #1a1a1a">{{ $user_log->user->firstname }} {{ $user_log->user->lastname }}</strong>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-row d-flex align-items-center">
                                        <p>{{ $user_log->action }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-row d-flex align-items-center">
                                        <p>{{ $user_log->created_at->format('Y-m-d H:i:s') }}</p>
                                    </div>
                                </td>
                                <td class="ip-column">
                                    <div class="custom-row d-flex align-items-center">
                                        <p>{{ $user_log->ip_address ?? 'N/A' }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $users_logs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Main Container */
        .requests-container {
            padding: 2.5rem;
            min-height: 100vh;
            background-color: #f7f7fb;
            font-family: 'Inter', sans-serif;
        }

        /* Header */
        .header-grid {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .btn-primary,
        .btn-outline-success,
        .btn-outline-secondary,
        .btn-outline-primary {
            padding: 0.75rem 1.25rem;
            border-radius: 10px;
            font-weight: 500;
            font-size: 1rem;
            height: 44px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4723d9, #3b1cb3);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3b1cb3, #2e1590);
            transform: translateY(-2px);
        }

        .btn-outline-success {
            border: 2px solid #28a745;
            color: #28a745;
            background: transparent;
        }

        .btn-outline-success:hover {
            background: #28a745;
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            border: 2px solid #6b7280;
            color: #6b7280;
        }

        .btn-outline-secondary:hover {
            background: #6b7280;
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            border: 2px solid #4723d9;
            color: #4723d9;
        }

        .btn-outline-primary:hover {
            background: #4723d9;
            color: white;
            transform: translateY(-2px);
        }

        /* Overview Cards */
        .overview-card {
            background: linear-gradient(145deg, #ffffff, #f8fafc);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .overview-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
        }

        /* Filters */
        .filter-card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .search-container {
            height: 44px;
            min-width: 220px;
            max-width: 260px;
            border: 2px solid #4723d9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            background: white;
            transition: border-color 0.3s ease;
        }

        .search-container:focus-within {
            border-color: #3b1cb3;
        }

        .log-search-input,
        .form-select,
        #dateRange {
            height: 44px;
            font-size: 0.95rem;
            padding: 0.75rem 1rem;
            padding-left: 2.5rem;
            border: none;
            border-radius: 10px;
            color: #1a1a1a;
            background: transparent;
        }

        .form-select {
            padding: 0.75rem 1rem;
        }

        .log-search-input:focus,
        .form-select:focus,
        #dateRange:focus {
            box-shadow: none;
            outline: none;
        }

        .log-search-input::placeholder,
        #dateRange::placeholder {
            color: #9ca3af;
        }

        .search-icon {
            color: #4723d9;
            margin-left: 0.75rem;
            line-height: 44px;
        }

        /* Chart */
        .chart-card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .chart-container {
            width: 100%;
            height: 400px;
            position: relative;
        }

        /* Table */
        .table-card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .table {
            width: 100%;
            max-width: 100%;
        }

        thead tr th {
            padding: 1rem;
            text-align: center;
            width: 25%;
        }

        .custom-row {
            display: flex;
            padding: 0.75rem;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .custom-row p {
            color: #1a1a1a;
            font-weight: 500;
            text-align: center;
            min-width: 200px;
            padding: 0.75rem;
            margin: 0;
            flex: 1;
        }

        .custom-row .d-flex {
            flex: 1;
            justify-content: center;
        }

        .custom-row-wrapper {
            outline: 1px solid #4723d929;
            border-radius: 10px;
            background: white;
            transition: all 0.2s ease-in-out;
          
        }

        .custom-row-wrapper:hover {
            outline: 1px solid #4723d9;
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6b7280;
            font-size: 1.1rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .custom-row p {
                min-width: 180px;
            }
        }

        @media (max-width: 992px) {
            .header-grid {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-container {
                width: 100%;
                max-width: none;
            }

            .chart-container {
                height: 300px;
            }
        }

        @media (max-width: 768px) {
            .requests-container {
                padding: 1.5rem;
            }

            .custom-row p {
                min-width: 140px;
                font-size: 0.9rem;
                padding: 0.5rem;
            }

            .btn-primary,
            .btn-outline-success,
            .btn-outline-secondary,
            .btn-outline-primary {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
                height: 38px;
            }

            .ip-column {
                display: none;
            }

            .chart-container {
                height: 200px;
            }

            .search-container,
            .log-search-input,
            .form-select,
            #dateRange {
                height: 38px;
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
                padding-left: 2rem;
            }

            .form-select {
                padding: 0.5rem 1rem;
            }

            .search-icon {
                margin-left: 0.5rem;
                line-height: 38px;
            }
        }

        @media (max-width: 576px) {
            .custom-row p {
                min-width: 100px;
                font-size: 0.85rem;
                padding: 0.4rem;
            }

            .btn-primary,
            .btn-outline-success,
            .btn-outline-secondary,
            .btn-outline-primary {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
                height: 34px;
            }

            .search-container {
                min-width: 100%;
            }

            img {
                height: 32px;
                width: 32px;
            }
        }
    </style>

    <script>
        // Normalize string for search (remove accents, lowercase)
        function normalizeString(str) {
            return str ? str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').trim().toLowerCase() : '';
        }

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // All initialization in one DOMContentLoaded listener
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Flatpickr
            if (typeof flatpickr === 'undefined') {
                console.error('Flatpickr not loaded');
            } else {
                flatpickr("#dateRange", {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    defaultDate: ["{{ $startDate->format('Y-m-d') }}", "{{ $endDate->format('Y-m-d') }}"],
                    maxDate: "{{ Carbon\Carbon::today()->format('Y-m-d') }}",
                    onChange: function(selectedDates) {
                        if (selectedDates.length === 2) {
                            const startDate = selectedDates[0].toISOString().split('T')[0];
                            const endDate = selectedDates[1].toISOString().split('T')[0];
                            updateFilters({ start_date: startDate, end_date: endDate });
                        }
                    }
                });
            }

            // Chart Initialization
            console.log('DOM loaded, initializing chart');
            const canvas = document.getElementById('loginChart');
            const errorDiv = document.getElementById('chartError');

            if (!canvas) {
                console.error('Canvas element with ID "loginChart" not found');
                errorDiv.style.display = 'block';
            } else if (typeof Chart === 'undefined') {
                console.error('Chart.js not loaded');
                errorDiv.style.display = 'block';
            } else {
                const ctx = canvas.getContext('2d');
                if (!ctx) {
                    console.error('Failed to get 2D context for canvas');
                    errorDiv.style.display = 'block';
                } else {
                    const values = @json($loginCounts);
                    console.log('Chart values:', values);

                    if (!Array.isArray(values) || values.length !== 7) {
                        console.warn('Invalid chart data');
                        errorDiv.style.display = 'block';
                        canvas.style.display = 'none';
                    } else {
                        errorDiv.style.display = 'none';
                        canvas.style.display = 'block';

                        function getShadedColors(data) {
                            const max = Math.max(...data);
                            const min = Math.min(...data);
                            return data.map(value => {
                                const lightness = max === min ? 70 : 70 - ((value - min) / (max - min)) * 50;
                                return `hsl(255, 100%, ${lightness}%)`;
                            });
                        }

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
                                datasets: [{
                                    label: 'Nombre de connexions',
                                    data: values,
                                    fill: true,
                                    backgroundColor: 'rgba(71,35,217, 0.1)',
                                    borderColor: '#4723d9',
                                    pointBackgroundColor: 'rgba(71,35,170, 1)',
                                    pointBorderColor: '#fff',
                                    tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 5,
                                            font: { size: 12 }
                                        },
                                        title: {
                                            display: true,
                                            text: 'Connexions',
                                            font: { size: 14, weight: '600' }
                                        },
                                        grid: {
                                            color: 'rgba(0,0,0,0.05)'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Jours de la semaine',
                                            font: { size: 14, weight: '600' }
                                        },
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            maxTicksLimit: 7,
                                            font: { size: 12 }
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });
                    }
                }
            }

            // Search and Filter
            const logSearchInput = document.getElementById('logSearchInput');
            const actionFilter = document.getElementById('actionFilter');
            const timePreset = document.getElementById('timePreset');
            const logTableBody = document.getElementById('logTableBody');

            if (!logSearchInput || !logTableBody) {
                console.error('Log search input or table body not found', { logSearchInput, logTableBody });
                alert('Erreur: Éléments de recherche introuvables.');
                return;
            }

            console.log('Log search input initialized, value:', logSearchInput.value);

            function performSearch() {
                console.log('Performing search with term:', logSearchInput.value);
                const searchTerm = normalizeString(logSearchInput.value);
                const actionTerm = normalizeString(actionFilter.value);
                const logRows = document.querySelectorAll('.log-row');
                let visibleCount = 0;

                logRows.forEach(row => {
                    const user = normalizeString(row.dataset.user || '');
                    const action = normalizeString(row.dataset.action || '');

                    console.log('Checking row:', { user, action, searchTerm, actionTerm });

                    const matchesSearch = !searchTerm || user.includes(searchTerm);
                    const matchesAction = !actionTerm || action === actionTerm;

                    if (matchesSearch && matchesAction) {
                        row.style.display = '';
                        visibleCount++;
                        console.log('Row visible:', user);
                    } else {
                        row.style.display = 'none';
                        console.log('Row hidden:', user);
                    }
                });

                console.log('Visible rows:', visibleCount);

                const emptyState = document.getElementById('emptyState');
                if (visibleCount === 0) {
                    if (!emptyState) {
                        const emptyRow = document.createElement('tr');
                        emptyRow.id = 'emptyState';
                        emptyRow.innerHTML = `
                            <td colspan="4">
                                <div class="empty-state">Aucun résultat trouvé</div>
                            </td>
                        `;
                        logTableBody.appendChild(emptyRow);
                        console.log('Empty state added');
                    }
                } else if (emptyState) {
                    emptyState.remove();
                    console.log('Empty state removed');
                }
            }

            // Initialize search on load
            performSearch();

            // Debounced search for input
            const debouncedSearch = debounce(performSearch, 300);
            logSearchInput.addEventListener('input', () => {
                console.log('Search input changed:', logSearchInput.value);
                debouncedSearch();
            });

            // Update URL on Enter
            logSearchInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    console.log('Enter pressed, updating URL with search:', logSearchInput.value);
                    updateFilters({ search: logSearchInput.value.trim() });
                }
            });

            actionFilter.addEventListener('change', () => {
                console.log('Action filter changed:', actionFilter.value);
                updateFilters({ action: actionFilter.value });
                performSearch();
            });

            timePreset.addEventListener('change', () => {
                console.log('Time preset changed:', timePreset.value);
                const preset = timePreset.value;
                const today = new Date();
                let startDate, endDate;
                if (preset === 'today') {
                    startDate = endDate = today.toISOString().split('T')[0];
                } else if (preset === 'week') {
                    startDate = new Date(today.setDate(today.getDate() - today.getDay() + 1)).toISOString().split('T')[0];
                    endDate = new Date(today.setDate(today.getDate() - today.getDay() + 7)).toISOString().split('T')[0];
                } else if (preset === 'month') {
                    startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
                    endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
                }
                if (startDate && endDate) {
                    updateFilters({ start_date: startDate, end_date: endDate });
                }
            });

            function updateFilters(params = {}) {
                const url = new URL(window.location);
                if (logSearchInput.value.trim()) params.search = logSearchInput.value.trim();
                if (actionFilter.value) params.action = actionFilter.value;
                Object.keys(params).forEach(key => url.searchParams.set(key, params[key]));
                console.log('Updating URL:', url.toString());
                window.location = url;
            }

            function resetFilters() {
                console.log('Resetting filters');
                logSearchInput.value = '';
                actionFilter.value = '';
                timePreset.value = '';
                flatpickr("#dateRange").clear();
                updateFilters({});
                performSearch();
            }
        });

        // Table Sort and Column Toggle
        let sortAscending = false;
        function toggleSort() {
            console.log('Toggling sort, ascending:', sortAscending);
            const logTableBody = document.getElementById('logTableBody');
            const rows = Array.from(logTableBody.querySelectorAll('.log-row'));
            rows.sort((a, b) => {
                const dateA = new Date(a.dataset.date);
                const dateB = new Date(b.dataset.date);
                return sortAscending ? dateA - dateB : dateB - dateA;
            });
            logTableBody.innerHTML = '';
            rows.forEach(row => logTableBody.appendChild(row));
            sortAscending = !sortAscending;
            document.getElementById('sortText').textContent = sortAscending ? 'Trier par Date ↑' : 'Trier par Date ↓';
            document.dispatchEvent(new Event('DOMContentLoaded')); // Reapply search after sorting
        }

        function toggleColumn() {
            console.log('Toggling IP column');
            const ipColumns = document.querySelectorAll('.ip-column');
            ipColumns.forEach(col => {
                col.style.display = col.style.display === 'none' ? '' : 'none';
            });
        }

        // Excel Export
        function exportStyledExcel() {
            if (typeof ExcelJS === 'undefined') {
                console.error('ExcelJS not loaded');
                alert('Erreur: Impossible de générer le fichier Excel.');
                return;
            }

            const table = document.getElementById('exportTable');
            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet('User Logs');

            worksheet.addRow(['Utilisateur', 'Action', 'Date', 'Adresse IP']);
            worksheet.getRow(1).eachCell(cell => {
                cell.font = { bold: true, color: { argb: 'FFFFFFFF' } };
                cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '4F81BD' } };
                cell.alignment = { horizontal: 'center' };
            });

            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    const rowData = [
                        row.cells[0].querySelector('.custom-row p a strong')?.innerText || 'Unknown',
                        row.cells[1].querySelector('.custom-row p')?.innerText || '',
                        row.cells[2].querySelector('.custom-row p')?.innerText || '',
                        row.cells[3].querySelector('.custom-row p')?.innerText || 'N/A'
                    ];
                    const newRow = worksheet.addRow(rowData);
                    newRow.eachCell(cell => {
                        cell.alignment = { horizontal: 'center' };
                    });
                }
            });

            worksheet.columns = [
                { width: 25 }, { width: 15 }, { width: 20 }, { width: 15 }
            ];

            workbook.xlsx.writeBuffer().then(buffer => {
                const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                saveAs(blob, 'User_Logs_Styled.xlsx');
            }).catch(err => {
                console.error('Excel export failed:', err);
                alert('Erreur lors de l’exportation Excel.');
            });
        }
    </script>
</x-admin_layout>
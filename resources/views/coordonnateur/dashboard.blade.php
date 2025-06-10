<x-coordonnateur_layout>
    <style>
        :root {
            --primary: #4723d9;
            --secondary: #e1ecff;
            --text-dark: #252525;
            --text-muted: #8a8a8a;
            --shadow: 0 3px 15px rgba(56, 56, 56, 0.11);
            --border-radius: 15px;
        }

        * {
            box-sizing: border-box;
        }

        .container-fluid {
            padding: 1.5rem 1rem !important;
        }

        .welcome {
            background: linear-gradient(135deg, var(--primary) 70%, transparent 100%), url('{{ asset('storage/images/adminavatar.png') }}') no-repeat right center / 120px auto;
            color: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            min-height: 140px;
        }

        .welcome-content {
            max-width: 60%;
        }

        .welcome h3 {
            font-weight: 500;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .buttons-wrapper {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .addbtn {
            background: white !important;
            color: var(--primary);
            border: 1px solid white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: background 0.2s;
        }

        .addbtn:hover {
            background: rgba(255, 255, 255, 0.8) !important;
        }

        .seebtn {
            background: transparent;
            color: white;
            border: 1px solid white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: background 0.2s;
        }

        .seebtn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .numbers-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s;
        }

        .numbers-card:hover {
            transform: translateY(-2px);
        }

        .numbers-card img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        .numbers-card .title {
            color: var(--text-dark);
            font-size: 0.875rem;
            margin: 0;
            font-weight: 600;
        }

        .numbers-card .num {
            color: var(--text-dark);
            font-size: 0.875rem;
            margin: 0.25rem 0;
        }

        .numbers-card .seemore {
            color: var(--primary);
            font-size: 0.75rem;
            text-decoration: none;
            font-weight: 500;
        }

        .numbers-card .seemore:hover {
            text-decoration: underline;
        }

        .chart-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 90%;
        }

        .chart-container h6 {
            color: var(--text-dark);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: center;
        }

        .chart-container canvas {
            max-height: 250px;
            width: 100% !important;
        }

        .tasks-container,
        .history-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            height: 100%;
        }

        .tasks-header,
        .history-header {
            background: var(--primary);
            color: white;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tasks-header p,
        .history-header p {
            margin: 0;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .tasks-content,
        .history-content {
            padding: 1rem;
            max-height: 300px;
            overflow-y: auto;
        }

        .task-item,
        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e8e8e8;
        }

        .task-item:last-child,
        .history-item:last-child {
            border-bottom: none;
        }

        .task-desc,
        .history-desc {
            margin: 0;
            font-size: 0.875rem;
            word-break: break-word;
        }

        .task-time,
        .history-time {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin: 0;
        }

        #task-add {
            border: 1px solid var(--primary);
            border-radius: 7px;
            padding: 0.5rem;
            margin-bottom: 1rem;
        }

        #task-input {
            border: none;
            background: #f8f9fa;
            border-radius: 7px;
            padding: 0.5rem;
            font-size: 0.875rem;
        }

        #task-add-button {
            background: white !important;
            color: var(--primary);
            width: 24px;
            height: 24px;
            font-size: 1rem;
            line-height: 1;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-menu {
            border-radius: 7px;
            box-shadow: var(--shadow);
            font-size: 0.875rem;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
        }

        .tasks-history-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1rem;
        }

        @media (max-width: 1400px) {
            .numbers-card img {
                width: 50px;
                height: 50px;
            }

            .numbers-card .title,
            .numbers-card .num {
                font-size: 0.8rem;
            }

            .numbers-card .seemore {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 992px) {
            .welcome {
                background-size: 100px auto;
                min-height: 120px;
            }

            .welcome-content {
                max-width: 70%;
            }

            .buttons-wrapper {
                flex-direction: column;
                gap: 0.5rem;
            }

            .addbtn,
            .seebtn {
                width: auto;
                font-size: 0.8rem;
            }

            .chart-container {
                height: 300px;
            }

            .tasks-history-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .welcome {
                background: var(--primary);
                background-image: none;
            }

            .welcome-content {
                max-width: 100%;
            }

            .numbers-card {
                flex-direction: column;
                text-align: center;
                padding: 1rem;
            }

            .numbers-card img {
                width: 40px;
                height: 40px;
            }

            .tasks-header p,
            .history-header p {
                font-size: 0.8rem;
            }

            .task-desc,
            .history-desc {
                font-size: 0.8rem;
            }

            .task-time,
            .history-time {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 576px) {
            .container-fluid {
                padding: 1rem 0.5rem !important;
            }

            .welcome h3 {
                font-size: 1rem;
            }

            .chart-container h6 {
                font-size: 0.8rem;
            }

            .dropdown-menu {
                font-size: 0.8rem;
            }
        }
    </style>

    <div class="container-fluid border">
        <!-- Welcome Section -->
        <div class="welcome">
            <div class="welcome-content">
                <h3>
                    Filiere: {{ auth()->user()->manage->name }}:
                    <strong>{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}</strong>
                </h3>
                <div class="buttons-wrapper">
                    <a href="{{ route('coordonnateur.modules.index') }}" class="addbtn">Gérer Modules</a>
                    <a href="{{ route('coordonnateur.assignments') }}" class="addbtn">Gérer Heures</a>
                    <a href="{{ route('emploi.index') }}" class="addbtn">Gérer Emplois</a>
                    {{-- <a href="{{ route('seances.index') }}" class="addbtn">Gérer Séances</a> --}}
                    <a href="{{ route('coordonnateur.vacataires.index') }}" class="addbtn">Gérer Vacataires</a>
                </div>
            </div>
        </div>

        <!-- Numbers Cards -->
        <div class="row g-3 mt-3">
            <div class="col-6 col-md-4">
                <div class="numbers-card">
                    <img src="{{ asset('storage/images/1.png') }}" alt="Etudiants">
                    <div>
                        <p class="title">Etudiants</p>
                        <p class="num">Total: <strong>{{ $studentCount }}</strong></p>
                        <a href="#" class="seemore">> Voir Plus</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="numbers-card">
                    <img src="{{ asset('storage/images/2.png') }}" alt="Vacataires">
                    <div>
                        <p class="title">Vacataires</p>
                        <p class="num">Total: <strong>{{ $vacataireCount }}</strong></p>
                        <a href="{{ route('coordonnateur.vacataires.index') }}" class="seemore">> Voir Plus</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="numbers-card">
                    <img src="{{ asset('storage/images/3.png') }}" alt="Modules">
                    <div>
                        <p class="title">Modules</p>
                        <p class="num">Total: <strong>{{ $moduleCount }}</strong></p>
                        <a href="{{ route('coordonnateur.modules.index') }}" class="seemore">> Voir Plus</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row g-3 mt-3">
            <div class="col-12 col-md-4">
                <div class="chart-container">
                    <h6>Répartition des Groupes TD/TP/CM</h6>
                    <canvas id="groupesChart"></canvas>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="chart-container">
                    <h6>Nombre de Séances par Jour</h6>
                    <canvas id="seancesChart"></canvas>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4">
                <div class="chart-container">
                    <h6>Modules Vacants/Non Vacants</h6>
                    <canvas id="modulesVacantChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tasks and History Side by Side -->
        <div class="tasks-history-container">
            <!-- Tasks Section -->
            <div class="tasks-container">
                <div class="tasks-header">
                    <p>Vos tâches</p>
                    <button id="task-add-button" onclick="addtask()">+</button>
                </div>
                <div class="tasks-content">
                    <div id="task-add" style="display: none">
                        <form action="{{ url('/addtask') }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <input id="task-input" name="task" type="text" class="flex-grow-1"
                                placeholder="Ajouter une tâche...">
                            <button type="submit" class="btn btn-sm">+</button>
                        </form>
                    </div>
                    @forelse ($tasks as $task)
                        <div class="task-item bg-light" style="border-radius: 10px;">
                            <div class="d-flex gap-2 align-items-center">
                                @if ($task['isdone'])
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                @else
                                    <i class="bi bi-clock-fill text-warning"></i>
                                @endif
                                <div>
                                    <p
                                        class="task-desc @if ($task['isdone']) text-decoration-line-through text-muted @endif">
                                        {{ $task['description'] }}</p>
                                    <p class="task-time">{{ $task->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-secondary p-0" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if ($task->isdone)
                                        <li>
                                            <form action="{{ url('mark-task-aspending/' . $task->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item"><i
                                                        class="bi bi-clock me-2"></i>Marquer en attente</button>
                                            </form>
                                        </li>
                                    @else
                                        <li>
                                            <form action="{{ url('mark-task-asdone/' . $task->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item"><i
                                                        class="bi bi-check-circle me-2"></i>Marquer comme
                                                    fait</button>
                                            </form>
                                        </li>
                                    @endif
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ url('delete-task/' . $task->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger"><i
                                                    class="bi bi-trash me-2"></i>Supprimer</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-clipboard2-check fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">Aucune tâche pour le moment</p>
                            <small class="text-muted">Cliquez sur "+" pour ajouter une tâche</small>
                        </div>
                    @endforelse
                    @if ($tasks->count() > 0)
                        <div class="text-center mt-2">
                            <a href="#" class="text-primary text-decoration-none small">Voir tous</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- History Section -->
            <div class="history-container">
                <div class="history-header">
                    <p>Historique des actions</p>
                </div>
                <div class="history-content">
                    @forelse ($coordActions as $history)
                        <div class="history-item">
                            <div class="d-flex gap-2 align-items-center">
                                @switch($history['action_type'])
                                    @case('affecter')
                                        <i style="color: #21b524" class="bi bi-plus-circle-fill"></i>
                                    @break

                                    @case('retirer')
                                        <i style="color: #ee5951" class="bi bi-trash3-fill"></i>
                                    @break

                                    @case('modifier')
                                        <i style="color: #5e3de3" class="bi bi-pencil-square"></i>
                                    @break

                                    @default
                                        <i style="color: #ff914d" class="bi bi-check-circle-fill"></i>
                                @endswitch
                                <div>
                                    <p class="history-desc">{{ $history['description'] }}</p>
                                    <p class="history-time">{{ $history->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-secondary p-0" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <p class="m-0 px-3 py-1">Date: <strong>{{ $history->created_at }}</strong>
                                        </p>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <p class="m-0 px-3 py-1">Admin: <strong>{{ $history->user->firstname }}
                                                {{ $history->user->lastname }}</strong></p>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <p class="m-0 px-3 py-1">Table:
                                            <strong>{{ $history->target_table }}</strong>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @empty
                            <p class="text-center text-muted">Aucun historique disponible</p>
                        @endforelse
                        <div class="text-center mt-2">
                            <a href="#" class="text-primary text-decoration-none small">Voir tous</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Répartition des Groupes TD/TP/CM Chart
            const groupesCtx = document.getElementById('groupesChart').getContext('2d');
            new Chart(groupesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['TD', 'TP', 'CM'],
                    datasets: [{
                        data: @json($groupesData),
                        backgroundColor: ['#a48de8', '#4723d9', '#6f58d8'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 10,
                                padding: 15,
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Get dynamic data from Blade variables
            const totalModules = @json($totalModules);
            const moduleVacantes = @json($moduleVacantes);
            const moduleNonVacantes = totalModules - moduleVacantes;

            const modulesVacantCtx = document.getElementById('modulesVacantChart').getContext('2d');
            new Chart(modulesVacantCtx, {
                type: 'pie',
                data: {
                    labels: ['Vacants', 'Non Vacants'],
                    datasets: [{
                        data: [moduleVacantes, moduleNonVacantes],
                        backgroundColor: ['#ff6b6b', '#4ade80'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 10,
                                padding: 15,
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${percentage}% (${value})`;
                                }
                            }
                        }
                    }
                }
            });

            // Nombre de Séances par Jour Chart
            const seancesCtx = document.getElementById('seancesChart').getContext('2d');
            new Chart(seancesCtx, {
                type: 'bar',
                data: {
                    labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                    datasets: [{
                        label: 'Nombre de séances',
                        data: @json($seancesParJour),
                        backgroundColor: ['#4723d9', '#6f58d8', '#a48de8', '#4723d9', '#6f58d8', '#a48de8'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            title: {
                                display: true,
                                text: 'Nombre de séances'
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.06)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Jours de la semaine'
                            },
                            grid: {
                                display: false
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

            function addtask() {
                const taskAddButton = document.getElementById('task-add-button');
                const taskAdd = document.getElementById('task-add');
                if (taskAddButton.innerHTML === 'x') {
                    taskAdd.style.display = 'none';
                    taskAddButton.innerHTML = '+';
                } else {
                    taskAddButton.innerHTML = 'x';
                    taskAdd.style.display = 'block';
                    document.getElementById('task-input').focus();
                }
            }
        </script>
    </x-coordonnateur_layout>

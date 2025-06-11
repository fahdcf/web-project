<x-coordonnateur_layout>
    <style>
        * {
            box-sizing: border-box;
        }

        .row div {
            background: none;
        }

        .main-section .welcome {
            border-radius: 15px;
            background-color: #4723d9;
            color: white;
            padding: 0;
            box-shadow: 0px 3px 15px 1px #3838381d;
            background-image: url('{{ asset('storage/images/professor_avatar.png') }}');
            background-repeat: no-repeat;
            background-position: right center;
            background-size: 150px auto;
            padding: 15px;
            width: 100%;
        }

         

        .welcome,
        .tasks,
        .courses,
        .upcoming-classes {
            border-radius: 15px;
            background-color: white;
            padding: 15px;
            box-shadow: 0px 3px 15px 1px #3838381d;
        }

        .tasks,
        .courses,
        .upcoming-classes {
            padding: 7px;
            border-radius: 5px;
            font-size: 15px;
            height: auto;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            box-shadow: none;
        }

        .tasks .task-desc,
        .courses .course-desc,
        .upcoming-classes .class-desc {
            text-wrap: wrap;
        }

        .tasks .task-time,
        .courses .course-time,
        .upcoming-classes .class-time {
            font-size: 12px;
            color: #8a8a8a;
        }

        .btn {
            background-color: #e1ecff;
            color: #03346e;
            font-weight: 600;
            font-size: 12px;
            padding: 5px;
            border-radius: 3px;
            width: 100%;
        }

        .buttons-wrapper button {
            border-radius: 5px;
            padding: 8px 10px;
            font-weight: 500;
            text-wrap: nowrap;
        }

        .addbtn {
            background-color: white !important;
            color: #4723d9;
            border: none;
        }

        .seebtn {
            background: none;
            color: #ffffff;
            border: 1px solid white;
        }

        .tasks-header,
        .courses-header,
        .upcoming-header {
            padding: 10px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .tasks-header button,
        .courses-header button {
            border: none;
            background: none;
            color: white;
            font-size: 20px;
            padding: 0 8px;
        }

        .tasks-header button:hover,
        .courses-header button:hover {
            background-color: #5029ef;
        }

        .task-item,
        .course-item,
        .class-item {
            border-bottom: 1px solid #e8e8e8d3;
            color: #252525;
        }

        .task-item button,
        .course-item button,
        .class-item button {
            border: none;
            background: none;
        }

        #task-input {
            border-radius: 15px !important;
        }

        .numbers-card {
            border-radius: 15px;
            box-shadow: 0px 3px 15px 1px #3838381d;
        }

        .numbers-card img {
            height: 80px;
            width: 80px;
            border-radius: 50%;
        }

        .numbers-card .title {
            color: #252525;
        }

        .numbers-card .num {
            color: #252525;
            font-size: 14px;
        }

        .numbers-card .seemore {
            border: none;
            background: none;
            font-size: 14px;
            color: #4723d9;
        }

        .chart-container {
            box-shadow: 0px 3px 15px 1px #3838381d;
            border-radius: 15px;
        }

        @media (max-width: 900px) {
            .buttons-wrapper button {
                font-size: small;
            }
        }

        @media (max-width: 1400px) {
            .numbers-card {
                gap: 8px !important;
            }

            .numbers-card img {
                height: 50px;
                width: 50px;
                border-radius: 50%;
            }

            .numbers-card .title {
                color: #252525;
                font-size: 13px;
            }

            .numbers-card .num {
                color: #252525;
                font-size: 14px;
            }

            .numbers-card .seemore {
                border: none;
                background: none;
                font-size: 11px;
                color: #4723d9;
            }
        }

        @media (max-width: 800px) {
            .numbers-card img {
                height: 60px;
                width: 60px;
                border-radius: 50%;
            }

            .numbers-card .title {
                color: #252525;
                font-size: 14px;
            }

            .numbers-card .num {
                color: #252525;
                font-size: 14px;
            }

            .numbers-card .seemore {
                border: none;
                background: none;
                font-size: 12px;
                color: #4723d9;
            }
        }


        .tasks-container,
        .history-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            height: 100%;
            flex: 1;
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
            transition: background 0.2s, transform 0.2s;
        }

        #task-add-button:hover {
            background: #f8f9fa !important;
            transform: scale(1.1);
        }

        .dropdown-menu {
            border-radius: 7px;
            box-shadow: var(--shadow);
            font-size: 0.875rem;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            transition: background 0.2s;
        }

        .dropdown-item:hover {
            background: var(--secondary);
        }

        .tasks-history-container {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

         .chart-container {
            box-shadow: 0px 3px 15px 1px #3838381d;
            border-radius: 15px;
        }
    </style>






    <section class="border main-section ">
        <div class="welcome p-4">
            <div class="d-flex flex-column justify-content-between col-8">
                <h3 style="font-weight: 500; padding-bottom: 10px;">Bienvenue
                    <strong>{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}</strong>
                </h3>
                <p style="font-size: 14px;">Gérez vos cours, saisissez les notes et consultez votre emploi du
                    temps.</p>
                <div class="buttons-wrapper d-flex gap-3">
                    <a href="{{ route('emploi.myTimetable') }}" class="addbtn btn">Voir mon emploi du temps</a>
                    <a href="#" class="seebtn btn">Saisir les notes</a>
                </div>
            </div>
        </div>

        <div class="numbers row w-100 m-0 mt-4">
            <div class="p-2 col-6 col-lg-4">
                <div class="numbers-card bg-white d-flex p-2 gap-3 gap-md-4 align-items-center">
                    <img src="{{ asset('storage/images/1.png') }}" alt="Etudiants">
                    <div class="d-flex flex-column justify-content-start align-items-start">
                        <p class="title">Étudiants</p>
                        <p class="num">Total: <strong>{{ $totalStudents ?? 142 }}</strong></p>
                        <a href="#" class="seemore">> Voir Plus</a>
                    </div>
                </div>
            </div>

            <div class="p-2 col-6 col-lg-4">
                <div class="numbers-card bg-white d-flex p-2 gap-3 gap-md-4 align-items-center">
                    <img src="{{ asset('storage/images/3.png') }}" alt="Modules">
                    <div class="d-flex flex-column justify-content-start align-items-start">
                        <p class="title">Mes cours</p>
                        <p class="num">Total: <strong>{{ $totalCourses }}</strong></p>
                        <a href="#" class="seemore">> Voir Plus</a>
                    </div>
                </div>
            </div>

            <div class="p-2 col-6 col-lg-4">
                <div class="numbers-card bg-white d-flex p-2 gap-3 gap-md-4 align-items-center">
                    <img src="{{ asset('storage/images/grades_icon.png') }}" alt="Grades Icon">
                    <div class="d-flex flex-column justify-content-start align-items-start">
                        <p class="title">Notes à saisir</p>
                        <p class="num">En attente: <strong>{{ $pendingGrades ?? 3 }}</strong></p>
                        <a href="#" class="seemore">> Voir Plus</a>
                    </div>
                </div>
            </div>


        </div>

        <div class="row m-0 mt-4">
            <!-- Weekly Schedule Chart -->
            <div class="col-12 mb-4 p-2">
                <div class="chart-container p-3 bg-white d-flex flex-column justify-content-start align-items-center"
                    style="height: 350px; width: 100%;">
                    <h6 class="pt-1 pb-4 m-0 text-center" style="color: #252525">Emploi du temps hebdomadaire
                    </h6>
                    <canvas id="scheduleChart" style="width: 90%; max-height: 250px;"></canvas>
                </div>
            </div>
        </div>


    </section>

    <section class="row">
        <div class="upcoming-classes  col-12 col-lg-6 " style="background-color: white">
            <div style="border: none; background-color: #4723d9;"
                class="upcoming-header d-flex justify-content-between align-items-center">
                <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin: 0">Prochains cours:</p>
            </div>

            <div class="upcoming-content px-3 px-md-4 pt-0">
                @forelse ($upcomingSeances as $seance)
                    <div class="class-item mt-3 d-flex justify-content-between align-items-center pb-3">
                        <div class="d-flex gap-3 align-items-center">
                            <i style="color: #4723d9" class="bi bi-book-fill"></i>
                            <div>
                                <p class="class-desc m-0"><strong>{{ $seance->module->name }}</strong> - Salle
                                    {{ $seance->salle ?? 'Non défini' }}</p>
                                <p class="class-time m-0">{{ $seance->jour }},
                                    {{ substr($seance->heure_debut, 0, 5) }} -
                                    {{ substr($seance->heure_fin, 0, 5) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('emploi.myTimetable') }}"><i class="bi bi-arrow-right-circle-fill"></i></a>
                    </div>
                @empty
                    <div class="class-item mt-3 d-flex justify-content-between align-items-center pb-3">
                        <div class="d-flex gap-3 align-items-center">
                            <i style="color: #4723d9" class="bi bi-book-fill"></i>
                            <div>
                                <p class="class-desc m-0"><strong>Algèbre Linéaire</strong> - Salle A12</p>
                                <p class="class-time m-0">Aujourd'hui, 10:00 - 12:00</p>
                            </div>
                        </div>
                        <a href="{{ route('emploi.myTimetable') }}"><i class="bi bi-arrow-right-circle-fill"></i></a>
                    </div>
                    <div class="class-item mt-3 d-flex justify-content-between align-items-center pb-3">
                        <div class="d-flex gap-3 align-items-center">
                            <i style="color: #4723d9" class="bi bi-book-fill"></i>
                            <div>
                                <p class="class-desc m-0"><strong>Analyse Numérique</strong> - Salle B05</p>
                                <p class="class-time m-0">Aujourd'hui, 14:00 - 16:00</p>
                            </div>
                        </div>
                        <a href="{{ route('emploi.myTimetable') }}"><i class="bi bi-arrow-right-circle-fill"></i></a>
                    </div>
                @endforelse
                <a href="{{ route('emploi.myTimetable') }}" class="text-center">
                    <p class="pt-2 m-0">Voir tous</p>
                </a>
            </div>
        </div>

        <div class="tasks  col-12 col-lg-6" style="background-color: white">
            <div style="border: none; background-color: #4723d9;"
                class="tasks-header d-flex justify-content-between align-items-center">
                <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin: 0">Tâches:</p>
                <button id="task-add-button" onclick="addTask()">+</button>
            </div>

            <div class="task-content p-3 p-md-4 pt-0">
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
                                        <form action="{{ url('mark-task-aspending/' . $task->id) }}" method="POST">
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


    </section>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Weekly Schedule Chart
        const scheduleCtx = document.getElementById('scheduleChart').getContext('2d');
        new Chart(scheduleCtx, {
            type: 'bar',
            data: {
                labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                datasets: [{
                    label: 'Heures enseignées',
                    data: {!! json_encode($scheduleData ?? [4, 0, 2, 0, 2, 0]) !!},
                    backgroundColor: ['#4723d9', '#8a72e0', '#a48de8', '#6f57d8', '#5029ef', '#3b2a91'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Heures',
                            color: '#252525',
                            font: {
                                size: 12
                            }
                        },
                        ticks: {
                            color: '#252525'
                        },
                        grid: {
                            color: '#e8e8e8'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Jours',
                            color: '#252525',
                            font: {
                                size: 12
                            }
                        },
                        ticks: {
                            color: '#252525'
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false
                    }
                }
            }
        });

        function addTask() {
            const taskAddButton = document.getElementById('task-add-button');
            const taskAdd = document.getElementById('task-add');

            if (taskAddButton.innerHTML === "x") {
                taskAdd.style.display = "none";
                taskAddButton.innerHTML = "+";
            } else {
                taskAddButton.innerHTML = "x";
                taskAdd.style.display = "block";
                document.getElementById('task-input').focus();
            }
        }
    </script>
</x-coordonnateur_layout>

<!-- Tasks Section -->

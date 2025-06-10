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
    </style>


    {{-- <div class="notifications">
        <div class="notifications-header">Notifications</div>
        <div class="notifications-content">
            @forelse (auth()->user()->unreadNotifications as $notification)
                <div class="notification-item">
                    <div>
                        <p class="notification-desc">{{ $notification->data['message'] }}</p>
                        <p class="notification-time">Échéance: {{ $notification->data['deadline_date'] }}</p>
                    </div>
                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"><i class="bi bi-check-circle"></i></button>
                    </form>
                </div>
            @empty
                <div class="notification-item">
                    <p class="notification-desc">Aucune nouvelle notification</p>
                </div>
            @endforelse
            <a href="#" class="text-center">Voir toutes les notifications</a>
        </div>
    </div> --}}



    <div class="container-fluid p-0 pt-5 d-flex flex-column">
            <section class="main-section col-12 col-md-8 col-lg-9 p-0 pr-md-4">
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
                    <div class="p-2 col-6 col-lg-3">
                        <div class="numbers-card bg-white d-flex p-2 gap-3 gap-md-4 align-items-center">
                            <img src="{{ asset('storage/images/students_icon.png') }}" alt="Students Icon">
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <p class="title">Étudiants</p>
                                <p class="num">Total: <strong>{{ $totalStudents ?? 142 }}</strong></p>
                                <a href="#" class="seemore">> Voir Plus</a>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 col-6 col-lg-3">
                        <div class="numbers-card bg-white d-flex p-2 gap-3 gap-md-4 align-items-center">
                            <img src="{{ asset('storage/images/courses_icon.png') }}" alt="Courses Icon">
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <p class="title">Cours</p>
                                <p class="num">Total: <strong>{{ $totalCourses }}</strong></p>
                                <a href="#" class="seemore">> Voir Plus</a>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 col-6 col-lg-3">
                        <div class="numbers-card bg-white d-flex p-2 gap-3 gap-md-4 align-items-center">
                            <img src="{{ asset('storage/images/grades_icon.png') }}" alt="Grades Icon">
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <p class="title">Notes à saisir</p>
                                <p class="num">En attente: <strong>{{ $pendingGrades ?? 3 }}</strong></p>
                                <a href="#" class="seemore">> Voir Plus</a>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 col-6 col-lg-3">
                        <div class="numbers-card bg-white d-flex p-2 gap-3 gap-md-4 align-items-center">
                            <img src="{{ asset('storage/images/schedule_icon.png') }}" alt="Schedule Icon">
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <p class="title">Prochains cours</p>
                                <p class="num">Cette semaine: <strong>{{ $upcomingClasses }}</strong></p>
                                <a href="{{ route('emploi.myTimetable') }}" class="seemore">> Voir Plus</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-0 mt-3">
                    <!-- Grades Chart -->
                    <div class="col-12 col-lg-6 mb-4 p-2">
                        <div class="chart-container p-3 bg-white d-flex flex-column justify-content-start align-items-center"
                            style="height: 350px; width: 100%;">
                            <h6 class="pt-1 pb-4 m-0 text-center" style="color: #252525">Répartition des notes (Algèbre)
                            </h6>
                            <canvas id="gradesChart" style="width: 90%; max-height: 250px;"></canvas>
                        </div>
                    </div>

                    <!-- Course Load Chart -->
                    <div class="col-12 col-lg-6 mb-4 p-2">
                        <div class="chart-container p-3 bg-white d-flex flex-column justify-content-start align-items-center"
                            style="height: 350px; width: 100%;">
                            <h6 class="pt-1 pb-4 text-center" style="color: #252525">Charge horaire par cours</h6>
                            <canvas id="courseLoadChart" style="width: 90%; max-height: 250px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="upcoming-classes p-0" style="background-color: white">
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
                                <a href="{{ route('emploi.myTimetable') }}"><i
                                        class="bi bi-arrow-right-circle-fill"></i></a>
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
                                <a href="{{ route('emploi.myTimetable') }}"><i
                                        class="bi bi-arrow-right-circle-fill"></i></a>
                            </div>
                            <div class="class-item mt-3 d-flex justify-content-between align-items-center pb-3">
                                <div class="d-flex gap-3 align-items-center">
                                    <i style="color: #4723d9" class="bi bi-book-fill"></i>
                                    <div>
                                        <p class="class-desc m-0"><strong>Analyse Numérique</strong> - Salle B05</p>
                                        <p class="class-time m-0">Aujourd'hui, 14:00 - 16:00</p>
                                    </div>
                                </div>
                                <a href="{{ route('emploi.myTimetable') }}"><i
                                        class="bi bi-arrow-right-circle-fill"></i></a>
                            </div>
                        @endforelse
                        <a href="{{ route('emploi.myTimetable') }}" class="text-center">
                            <p class="pt-2 m-0">Voir tous</p>
                        </a>
                    </div>
                </div>
            </section>

            <section class="side-section col-12 col-md-4 col-lg-3 p-0 pt-4 p-md-0">
                <div class="courses p-0" style="background-color: white">
                    <div style="border: none; background-color: #4723d9;"
                        class="courses-header d-flex justify-content-between align-items-center">
                        <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin: 0">Mes cours:</p>
                    </div>

                    <div class="courses-content p-3 p-md-4 pt-0">
                        @forelse ($courses as $course)
                            <div class="course-item mt-3 d-flex justify-content-between align-items-center pb-3">
                                <div class="d-flex gap-3 align-items-center">
                                    <i style="color: #4723d9" class="bi bi-book-fill"></i>
                                    <div>
                                        <p class="course-desc m-0">{{ $course->name }}</p>
                                        <p class="course-time m-0">S{{ $course->semester }} -
                                            {{ $course->groupe ?? 'Tous' }}</p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                                        <li><a class="dropdown-item" href="#">Voir les étudiants</a></li>
                                        <li><a class="dropdown-item" href="#">Saisir les notes</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="#">Détails</a></li>
                                    </ul>
                                </div>
                            </div>
                        @empty
                            <div class="course-item mt-3 d-flex justify-content-between align-items-center pb-3">
                                <div class="d-flex gap-3 align-items-center">
                                    <i style="color: #4723d9" class="bi bi-book-fill"></i>
                                    <div>
                                        <p class="course-desc m-0">Algèbre Linéaire</p>
                                        <p class="course-time m-0">S1 - Groupe A</p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                                        <li><a class="dropdown-item" href="#">Voir les étudiants</a></li>
                                        <li><a class="dropdown-item" href="#">Saisir les notes</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="#">Détails</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="course-item mt-3 d-flex justify-content-between align-items-center pb-3">
                                <div class="d-flex gap-3 align-items-center">
                                    <i style="color: #4723d9" class="bi bi-book-fill"></i>
                                    <div>
                                        <p class="course-desc m-0">Analyse Numérique</p>
                                        <p class="course-time m-0">S2 - Groupe B</p>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                                        <li><a class="dropdown-item" href="#">Voir les étudiants</a></li>
                                        <li><a class="dropdown-item" href="#">Saisir les notes</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="#">Détails</a></li>
                                    </ul>
                                </div>
                            </div>
                        @endforelse
                        <a href="#" class="text-center">
                            <p class="pt-2 m-0">Voir tous</p>
                        </a>
                    </div>
                </div>

                <div class="tasks p-0 mt-4" style="background-color: white">
                    <div style="border: none; background-color: #4723d9;"
                        class="tasks-header d-flex justify-content-between align-items-center">
                        <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin: 0">Tâches:</p>
                        <button id="task-add-button" onclick="addTask()">+</button>
                    </div>

                    <div class="task-content p-3 p-md-4 pt-0">
                        <div id="task-add" style="display: none">
                            <form action="#" method="post">
                                @csrf
                                <input id="task-input" name="task" type="text"
                                    placeholder="Ajouter une tâche...">
                            </form>
                        </div>

                        <div class="task-item mt-3 d-flex justify-content-between align-items-center pb-3">
                            <div class="d-flex gap-3 align-items-center">
                                <i style="color: #ff914d" class="bi bi-clock-fill"></i>
                                <div>
                                    <p class="task-desc m-0">Saisir les notes d'Algèbre</p>
                                    <p class="task-time m-0">Date limite: 15/06/2025</p>
                                </div>
                            </div>
                            <button><i class="bi bi-check-circle"></i></button>
                        </div>

                        <div class="task-item mt-3 d-flex justify-content-between align-items-center pb-3">
                            <div class="d-flex gap-3 align-items-center">
                                <i style="color: #21b524" class="bi bi-check-circle-fill"></i>
                                <div>
                                    <p class="task-desc m-0">Préparer le TP d'Analyse</p>
                                    <p class="task-time m-0">Terminé</p>
                                </div>
                            </div>
                            <button><i class="bi bi-trash"></i></button>
                        </div>

                        <div class="task-item mt-3 d-flex justify-content-between align-items-center pb-3">
                            <div class="d-flex gap-3 align-items-center">
                                <i style="color: #ff914d" class="bi bi-clock-fill"></i>
                                <div>
                                    <p class="task-desc m-0">Corriger les examens</p>
                                    <p class="task-time m-0">Date limite: 20/06/2025</p>
                                </div>
                            </div>
                            <button><i class="bi bi-check-circle"></i></button>
                        </div>

                        <a href="#" class="text-center">
                            <p class="pt-2 m-0">Voir tous</p>
                        </a>
                    </div>
                </div>
            </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Grades Distribution Chart
        const gradesCtx = document.getElementById('gradesChart').getContext('2d');
        new Chart(gradesCtx, {
            type: 'bar',
            data: {
                labels: ['0-5', '5-10', '10-15', '15-20'],
                datasets: [{
                    label: 'Nombre d\'étudiants',
                    data: [2, 8, 25, 15],
                    backgroundColor: ['#a48de8', '#8a72e0', '#6f58d8', '#4723d9'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre d\'étudiants'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Intervalles de notes'
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

        // Course Load Chart
        const courseLoadCtx = document.getElementById('courseLoadChart').getContext('2d');
        new Chart(courseLoadCtx, {
            type: 'pie',
            data: {
                labels: ['Algèbre Linéaire', 'Analyse Numérique', 'Structures de Données'],
                datasets: [{
                    label: 'Heures par cours',
                    data: [20, 15, 10],
                    backgroundColor: ['#4723d9', '#8a72e0', '#a48de8'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
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

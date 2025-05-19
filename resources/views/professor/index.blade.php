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
        .courses {
            border-radius: 15px;
            background-color: white;
            padding: 15px;
            box-shadow: 0px 3px 15px 1px #3838381d;
        }

        .tasks,
        .courses {
            padding: 7px;
            border-radius: 5px;
            font-size: 15px;
            height: auto;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            box-shadow: none;
        }

        .tasks .task-desc,
        .courses .course-desc {
            text-wrap: wrap;
        }

        .tasks .task-time,
        .courses .course-time {
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
        .courses-header {
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
        .course-item {
            border-bottom: 1px solid #e8e8e8d3;
            color: #252525;
        }

        .task-item button,
        .course-item button {
            border: none;
            background: none;
        }

        #task-input,
        #course-input {
            border-radius: 15px !important;
        }

        #task-add,
        #course-add {
            border: 1px solid #1777ec;
            border-radius: 7px;
            padding: 12px;
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

        .upcoming-classes {
            padding: 7px;
            border-radius: 5px;
            font-size: 15px;
            height: auto;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            box-shadow: none;
        }

        .upcoming-header {
            padding: 10px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .class-item {
            border-bottom: 1px solid #e8e8e8d3;
            color: #252525;
        }

        .class-item button {
            border: none;
            background: none;
        }

        .upcoming-classes .class-desc {
            text-wrap: wrap;
        }

        .upcoming-classes .class-time {
            font-size: 12px;
            color: #8a8a8a;
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

    <div class="container-fluid p-0 pt-5 d-flex flex-column">
        <div class="page-wrapper w-100 row m-0">
            <section class="main-section col-12 col-md-8 col-lg-9 p-0 pr-md-4">
                <div class="welcome p-4">
                    <div class="d-flex flex-column justify-content-between col-8">
                        <h3 style="font-weight: 500; padding-bottom: 10px;">Bienvenue
                            <strong>{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}</strong></h3>
                        <p style="font-size: 14px;">Consultez vos cours, étudiants et notes.</p>

                        <div class="buttons-wrapper d-flex gap-3">
                            <button class="addbtn">Ajouter des notes</button>
                            <button class="seebtn">Voir mes cours</button>
                        </div>
                    </div>
                </div>

                <div class="numbers row w-100 m-0 mt-4">
                    <div class="p-2 col-6 col-lg-3">
                        <div class="numbers-card bg-white d-flex p-2 gap-3 gap-md-4 align-items-center">
                            <img src="{{ asset('storage/images/students_icon.png') }}" alt="">
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <p class="title">Étudiants</p>
                                <p class="num">Total: <strong>142</strong></p>
                                <button class="seemore">> Voir Plus</button>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 col-6 col-lg-3">
                        <div class="numbers-card bg-white d-flex p-2 gap-3 gap-md-4 align-items-center">
                            <img src="{{ asset('storage/images/courses_icon.png') }}" alt="">
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <p class="title">Cours</p>
                                <p class="num">Total: <strong>5</strong></p>
                                <button class="seemore">> Voir Plus</button>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 col-6 col-lg-3">
                        <div class="numbers-card bg-white d-flex p-2 gap-3 gap-md-4 align-items-center">
                            <img src="{{ asset('storage/images/grades_icon.png') }}" alt="">
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <p class="title">Notes à saisir</p>
                                <p class="num">En attente: <strong>3</strong></p>
                                <button class="seemore">> Voir Plus</button>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 col-6 col-lg-3">
                        <div class="numbers-card bg-white d-flex p-2 gap-3 gap-md-4 align-items-center">
                            <img src="{{ asset('storage/images/schedule_icon.png') }}" alt="">
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <p class="title">Prochains cours</p>
                                <p class="num">Aujourd'hui: <strong>2</strong></p>
                                <button class="seemore">> Voir Plus</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-0 mt-3">
                    <!-- Courses Chart -->
                    <div class="col-12 col-lg-6 mb-4 p-2">
                        <div class="chart-container p-3 bg-white d-flex flex-column justify-content-start align-items-center"
                            style="height: 350px; width:500px;">
                            <h6 class="pt-1 pb-4 m-0 text-center" style="color: #252525">Répartition des notes (Algèbre)
                            </h6>
                            <canvas id="gradesChart" style="width: 90%; max-height: 250px;"></canvas>
                        </div>
                    </div>

                    <!-- Attendance Chart -->
                    <div class="col-12 col-lg-6 mb-4 p-2">
                        <div class="chart-container p-3 bg-white d-flex flex-column justify-content-start align-items-center"
                            style="height: 350px; width:500px;">
                            <h6 class="pt-1 pb-4 text-center" style="color: #252525">Taux de présence (Dernier mois)
                            </h6>
                            <canvas id="attendanceChart" style="width: 100%; height: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="upcoming-classes p-0" style="background-color: white">
                        <div style="border: none; background-color: #4723d9;"
                            class="upcoming-header d-flex justify-content-between align-items-center">
                            <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin: 0">Prochains cours:</p>
                        </div>

                        <div class="upcoming-content px-3 px-md-4 pt-0">
                            <div class="class-item mt-3 d-flex justify-content-between align-items-center pb-3">
                                <div class="d-flex gap-3 align-items-center">
                                    <i style="color: #4723d9" class="bi bi-book-fill"></i>
                                    <div>
                                        <p class="class-desc m-0"><strong>Algèbre Linéaire</strong> - Salle A12</p>
                                        <p class="class-time m-0">Aujourd'hui, 10:00 - 12:00</p>
                                    </div>
                                </div>
                                <button><i class="bi bi-arrow-right-circle-fill"></i></button>
                            </div>

                            <div class="class-item mt-3 d-flex justify-content-between align-items-center pb-3">
                                <div class="d-flex gap-3 align-items-center">
                                    <i style="color: #4723d9" class="bi bi-book-fill"></i>
                                    <div>
                                        <p class="class-desc m-0"><strong>Analyse Numérique</strong> - Salle B05</p>
                                        <p class="class-time m-0">Aujourd'hui, 14:00 - 16:00</p>
                                    </div>
                                </div>
                                <button><i class="bi bi-arrow-right-circle-fill"></i></button>
                            </div>

                            <div class="class-item mt-3 d-flex justify-content-between align-items-center pb-3">
                                <div class="d-flex gap-3 align-items-center">
                                    <i style="color: #4723d9" class="bi bi-book-fill"></i>
                                    <div>
                                        <p class="class-desc m-0"><strong>Structures de Données</strong> - Salle C03</p>
                                        <p class="class-time m-0">Demain, 09:00 - 11:00</p>
                                    </div>
                                </div>
                                <button><i class="bi bi-arrow-right-circle-fill"></i></button>
                            </div>

                            <a href="#" class="text-center">
                                <p class="pt-2 m-0">Voir tous</p>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="side-section col-12 col-md-4 col-lg-3 p-0 pt-4 p-md-0">
                <div class="">
                    <div class="courses p-0" style="background-color: white">
                        <div style="border: none; background-color: #4723d9;"
                            class="courses-header d-flex justify-content-between align-items-center">
                            <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin: 0">Mes cours:</p>
                            <button id="course-add-button" onclick="addCourse()">+</button>
                        </div>

                        <div class="courses-content p-3 p-md-4 pt-0">
                            <div id="course-add" style="display: none">
                                <form action="#" method="post">
                                    @csrf
                                    <input id="course-input" name="course" type="text"
                                        placeholder="Ajouter un cours...">
                                </form>
                            </div>

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

                            <div class="course-item mt-3 d-flex justify-content-between align-items-center pb-3">
                                <div class="d-flex gap-3 align-items-center">
                                    <i style="color: #4723d9" class="bi bi-book-fill"></i>
                                    <div>
                                        <p class="course-desc m-0">Structures de Données</p>
                                        <p class="course-time m-0">S3 - Groupe C</p>
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

                            <a href="#" class="text-center">
                                <p class="pt-2 m-0">Voir tous</p>
                            </a>
                        </div>
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
                                    <p class="task-time m-0">Date limite: 15/05/2023</p>
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
                                    <p class="task-time m-0">Date limite: 20/05/2023</p>
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

        // Attendance Chart
        const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(attendanceCtx, {
            type: 'line',
            data: {
                labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'],
                datasets: [{
                    label: 'Taux de présence (%)',
                    data: [85, 78, 92, 88],
                    fill: true,
                    backgroundColor: 'rgba(71,35,217, 0.1)',
                    borderColor: '#4723d9',
                    pointBackgroundColor: 'rgba(71,35,170, 1)',
                    pointBorderColor: '#fff',
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 50,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        title: {
                            display: true,
                            text: 'Taux de présence'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Semaines'
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

        function addTask() {
            const taskAddButton = document.getElementById('task-add-button');
            const taskAdd = document.getElementById('task-add');

            if (taskAddButton.innerHTML == "x") {
                taskAdd.style.display = "none";
                taskAddButton.innerHTML = "+";
            } else {
                taskAddButton.innerHTML = "x";
                taskAdd.style.display = "block";
                document.getElementById('task-input').focus();
            }
        }

        function addCourse() {
            const courseAddButton = document.getElementById('course-add-button');
            const courseAdd = document.getElementById('course-add');

            if (courseAddButton.innerHTML == "x") {
                courseAdd.style.display = "none";
                courseAddButton.innerHTML = "+";
            } else {
                courseAddButton.innerHTML = "x";
                courseAdd.style.display = "block";
                document.getElementById('course-input').focus();
            }
        }
    </script>
</x-coordonnateur_layout>

{{-- 
<x-admin_layout>

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
            background-image: url('{{ asset('storage/images/adminavatar.png') }}');
            background-repeat: no-repeat;
            background-position: right center;
            background-size: 150px auto;
            padding: 15px;
            width: 100%;
            /* or your preferred width */
        }

        .welcome,
        .tasks {
            border-radius: 15px;
            background-color: white;
            padding: 15px;
            box-shadow: 0px 3px 15px 1px #3838381d;

        }

        .tasks {
            padding: 7px;
            border-radius: 5px;
            font-size: 15px;
            height: auto;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            box-shadow: none;
        }

        .tasks .task-desc {
            text-wrap: wrap;

        }

        .tasks .task-time {
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

        .tasks-header {
            padding: 10px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;

        }

        .tasks-header button {
            border: none;
            background: none;
            color: white;
            font-size: 20px;
            padding: 0 8px;


        }

        .tasks-header button:hover {
            background-color: #5029ef;
        }

        .task-item {
            border-bottom: 1px solid #e8e8e8d3;
            color: #252525;
        }

        .task-item button {
            border: none;
            background: none;

        }

        #task-input {
            border-radius: 15px !important;

        }

        #task-add {
            border: 1px solid #1777ec;
            border-radius: 7px;
            padding: 12px;
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

        @media (max-width:900px) {
            .buttons-wrapper button {
                font-size: small;
            }

        }

        @media (max-width:1400px) {
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

        @media (max-width:800px) {

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

        .shart-container {
            box-shadow: 0px 3px 15px 1px #3838381d;
            border-radius: 15px;

        }

        .history {
            padding: 7px;
            border-radius: 5px;
            font-size: 15px;
            height: auto;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            box-shadow: none;
        }

        .history-header {
            padding: 10px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;

        }



        .history-item {
            border-bottom: 1px solid #e8e8e8d3;
            color: #252525;
        }

        .history-item button {
            border: none;
            background: none;

        }


        .history .history-desc {
            text-wrap: wrap;

        }

        .history .history-time {
            font-size: 12px;
            color: #8a8a8a;

        }




        .logs {
            padding: 7px;
            border-radius: 5px;
            font-size: 15px;
            height: auto;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            box-shadow: none;
        }

        .logs-header {
            padding: 10px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;

        }



        .logs-item {
            border-bottom: 1px solid #e8e8e8d3;
            color: #252525;
        }

        .logs-item button {
            border: none;
            background: none;

        }


        .logs .logs-desc {
            text-wrap: wrap;

        }

        .logs .logs-time {
            font-size: 12px;
            color: #8a8a8a;

        }
    </style>



    <div class="container-fluid p-0 pt-5 d-flex flex-column ">



        <div class="page-wrapper w-100 row m-0">


            <section class="main-section col-12 col-md-8 col-lg-9 p-0 pr-md-4">

                <div class="welcome p-4 ">

                    <div class="d-flex flex-column justify-content-between col-8">
                        <h3 style="font-weight: 500; padding-bottom: 10px;">Welcome
                            <strong>{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}</strong> to the
                            Dashboard</h3>
                        <p style="font-size: 14px;">Unlock All Premium Songs, no Ads, and more.</p>

                        <div class="buttons-wrapper d-flex  gap-3"><button class="addbtn">Ajeuter un
                                utilisateur</button> <button class="seebtn">voir tous les utilisateurs</button> </div>

                    </div>


                </div>

                <div class="numbers row w-100 m-0 mt-4 ">

                    <div class="p-2 col-6 col-lg-3">

                        <div class="numbers-card  bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
                            <img src="{{ asset('storage/images/1.png') }}" alt="">

                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <p class="title">Etudiants</p>
                                <p class="num">Total: <strong>{{ $studentCount }}</strong></p>
                                <button class="seemore">> Voir Plus</button>

                            </div>

                        </div>

                    </div>


                    <div class="p-2 col-6 col-lg-3">

                        <div class="numbers-card bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
                            <img src="{{ asset('storage/images/2.png') }}" alt="">

                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <p class="title">Professeurs</p>
                                <p class="num">Total: <strong>27</strong></p>
                                <button class="seemore">> Voir Plus</button>

                            </div>

                        </div>

                    </div>


                    <div class="p-2 col-6 col-lg-3">

                        <div class="numbers-card bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
                            <img src="{{ asset('storage/images/3.png') }}" alt="">

                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <p class="title">departements</p>
                                <p class="num">Total: <strong>4</strong></p>
                                <button class="seemore">> Voir Plus</button>

                            </div>

                        </div>

                    </div>


                    <div class="p-2 col-6 col-lg-3">

                        <div class="numbers-card bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
                            <img src="{{ asset('storage/images/4.png') }}" alt="">

                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <p class="title">Filieres</p>
                                <p class="num">Total: <strong>7</strong></p>
                                <button class="seemore">> Voir Plus</button>

                            </div>

                        </div>

                    </div>




                </div>

                <div class="row m-0 mt-3">
                    <!-- Doughnut Chart -->
                    <div class="col-12 col-lg-6 mb-4 p-2">
                        <div class=" shart-container p-3 bg-white d-flex flex-column justify-content-start align-items-center"
                            style="height: 350px;">

                            <h6 class="pt-1 pb-4 m-0 text-center" style="color: #252525">Répartition des Etudiants
                            </h6>
                            <canvas id="genderChart" style="width: 90%; max-height: 250px;"></canvas>
                        </div>
                    </div>


                    <!-- Bar Chart -->
                    <div class="col-12 col-lg-6 mb-4 p-2">
                        <div class="shart-container p-3 bg-white d-flex flex-column justify-content-start align-items-center"
                            style="height: 350px;">
                            <h6 class="pt-1 pb-4  text-center" style="color: #252525">Nombre de connexions par jour
                            </h6>
                            <canvas id="loginChart" style="width: 100%; height: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="history p-0 " style="background-color:white ">

                        <div style=" border:none; background-color:#4723d9; "
                            class="history-header d-flex justify-content-between align-items-center ">
                            <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin:0">History des actions:
                            </p>

                        </div>

                        <div class="history-content px-3 px-md-4 pt-0 ">




                            @foreach ($adminsHistory as $History)
                                <div class="history-item mt-3 d-flex justify-content-between align-items-center pb-3">
                                    <div class="d-flex gap-3 align-items-center">

                                        @switch($History['action_type'])
                                            @case('create')
                                                <i style="color: #21b524" class="bi bi-plus-circle-fill"></i>
                                            @break

                                            @case('delete')
                                                <i style="color: #ee5951" class="bi bi-trash3-fill"></i>
                                            @break

                                            @case('update')
                                                <i style="color:#5e3de3" class="bi bi-pencil-square"></i>
                                            @break

                                            @default
                                                <i style="color:#ff914d" class="bi bi-check-circle-fill"> </i>
                                        @endswitch




                                        <div>

                                            <p class="history-desc m-0"> {{ $History['description'] }}</p>
                                            <p class="history-time m-0"> {{ $History->created_at->diffForHumans() }}
                                            </p>

                                        </div>

                                    </div>

                                    <div class="dropdown">

                                        <button data-bs-toggle="dropdown" aria-expanded="false"><i
                                                class="bi bi-three-dots-vertical"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="Dropdown"
                                            data-bs-display="static" style="width: 250px">

                                            <li>
                                                <p class="m-0 py-1 pl-3"> Date :
                                                    <strong>{{ $History->created_at }}</strong></p>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>

                                            <li>
                                                <p class="m-0 py-1 pl-3"> Admin :
                                                    <strong>{{ $History->user->firstname }}
                                                        {{ $History->user->lastname }}</strong></p>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>

                                            <li>
                                                <p class="m-0 py-1 pl-3"> Table :
                                                    <strong>{{ $History->target_table }}</strong></p>
                                            </li>


                                        </ul>



                                    </div>

                                </div>
                            @endforeach

                            <a href="#" class="text-center">
                                <p class="pt-2 m-0">Voir tous</p>
                            </a>

                        </div>
                    </div>

                </div>

            </section>

            <section class="side-section col-12 col-md-4 col-lg-3  p-0 pt-4 p-md-0">


                <div class="">
                    <div class="logs p-0 " style="background-color:white ">

                        <div style=" border:none; background-color:#4723d9; "
                            class="logs-header d-flex justify-content-between align-items-center ">
                            <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin:0">History des
                                Connexions:</p>

                        </div>

                        <div class="logs-content p-3 p-md-4 pt-0">




                            @foreach ($users_logs as $user_log)
                                <div class="logs-item mt-3 d-flex align-items-center pb-3">
                                    <div class="d-flex gap-3 align-items-center">
                                        <a href="{{ url('profile/' . $user_log->user->id) }}">
                                            @if ($user_log->user->user_details)
                                                @if ($user_log->user->user_details->profile_img != null)
                                                    <img style="height: 40px;width: 40px;object-fit:cover;border-radius:50%; background-color: #c7c1e1;"
                                                        src="{{ asset('storage/' . $user_log->user->user_details->profile_img) }}">
                                                @else
                                                    <img style="height: 40px;width: 40px;object-fit:cover;border-radius:50%;"
                                                        src="{{ asset('storage/images/default_profile_img.png') }}">
                                                @endif
                                            @else
                                                <img style="width: 35px; border-radius:50%;"
                                                    src="{{ asset('storage/images/default_profile_img.png') }}">
                                            @endif
                                        </a>

                                        <div>

                                            <a href="{{ url('profile/' . $user_log->user->id) }}"
                                                class="text-decoration-none">
                                                <p class="logs-desc m-0"> <strong
                                                        style="color: #252525">{{ $user_log->user->firstname }}
                                                        {{ $user_log->user->lastname }}</strong>
                                            </a> {{ $user_log['action'] }}</p>

                                            <p class="logs-time m-0"> {{ $user_log->created_at->diffForHumans() }}</p>

                                        </div>

                                    </div>



                                </div>
                            @endforeach

                            <a href="#" class="text-center">
                                <p class="pt-2 m-0">Voir tous</p>
                            </a>

                        </div>
                    </div>

                </div>






                <div class="tasks p-0 mt-4" style="background-color:white ">

                    <div style=" border:none; background-color:#4723d9; "
                        class="tasks-header d-flex justify-content-between align-items-center ">
                        <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin:0">Your tasks:</p>
                        <button id="task-add-button" onclick="addtask()">+</button>

                    </div>
                    <div class="task-content p-3 p-md-4 pt-0">


                        <div id="task-add" style="display: none">
                            <form action="{{ url('/addtask') }}" method="post">
                                @csrf
                                <input id="task-input" name="task" type="text" placeholder="Ajeuter...">
                            </form>
                        </div>

                        @foreach ($tasks as $task)
                            <div class="task-item mt-3 d-flex justify-content-between align-items-center pb-3">
                                <div class="d-flex gap-3 align-items-center">
                                    @if ($task['isdone'])
                                        <i style="color: #21b524" class="bi bi-check-circle-fill"> </i>
                                    @else
                                        <i style="color: #ff914d" class="bi bi-clock-fill"></i>
                                    @endif

                                    <div>

                                        <p class="task-desc m-0"> {{ $task['description'] }}</p>
                                        <p class="task-time m-0"> {{ $task->created_at->diffForHumans() }}</p>

                                    </div>

                                </div>

                                <div class="dropdown">

                                    <button data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="bi bi-three-dots-vertical"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="Dropdown"
                                        data-bs-display="static">


                                        @if ($task->isdone)
                                            <li>

                                                <form action="{{ url('mark-task-aspending/' . $task->id) }}"
                                                    method="post">
                                                    @csrf

                                                    <button type="submit" class="dropdown-item">Marquer en
                                                        attente</button>
                                                </form>

                                            </li>
                                        @else
                                            <li>

                                                <form action="{{ url('mark-task-asdone/' . $task->id) }}"
                                                    method="post">
                                                    @csrf

                                                    <button type="submit" class="dropdown-item">Marquer comme
                                                        fait</button>
                                                </form>

                                            </li>
                                        @endif

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>


                                        <li>

                                            <form action="{{ url('delete-task/' . $task->id) }}" method="post">
                                                @csrf

                                                <button type="submit" class="dropdown-item">Supprimer</button>
                                            </form>

                                        </li>


                                    </ul>



                                </div>

                            </div>
                        @endforeach

                        <a href="#" class="text-center">
                            <p class="pt-2 m-0">Voir tous</p>
                        </a>

                    </div>
                </div>



            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function getShadedColors(data) {
            const max = Math.max(...data);
            const min = Math.min(...data);
            return data.map(value => {
                // Scale darkness from 20% (dark) to 70% (light)
                const lightness = 70 - ((value - min) / (max - min)) * 50;
                return `hsl(255, 100%, ${lightness}%)`; // Purple hue
            });
        }

        // Doughnut Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Filles', 'Garçons'],
                datasets: [{
                    data: [55, 45],
                    backgroundColor: ['#a48de8', '#4723d9'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 10, // smaller size
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

        const values = @json($loginCounts);
        console.log(values);

        const loginCtx = document.getElementById('loginChart').getContext('2d');
        new Chart(loginCtx, {
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
                    tension: 0.4, // smooth curve
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        },
                        title: {
                            display: true,
                            text: 'Connexions'
                        },
                        grid: {
                            display: true,
                            drawBorder: false,
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
            const taskaddButton = document.getElementById('task-add-button');
            const taskadd = document.getElementById('task-add');

            if (taskaddButton.innerHTML == "x") {
                taskadd.style.display = "none";
                taskaddButton.innerHTML = "+";

            } else {
                taskaddButton.innerHTML = "x";
                taskadd.style.display = "block";
                document.getElementById('task-input').focus();
            }

        }
    </script>

</x-admin_layout> --}}

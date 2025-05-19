<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 text-gray-800">
                    <i class="fas fa-chalkboard-teacher text-primary me-2"></i>
                    Espace Professeur
                </h1>
                <p class="mb-0 text-muted small">
                    <i class="fas fa-user-tie me-1"></i>
                    Pr. Ahmed Benali |
                    <i class="fas fa-calendar-alt me-1"></i>
                    Année académique: 2023/2024
                </p>
            </div>
            <div class="badge bg-primary">
                <i class="fas fa-clock me-1"></i>
                Charge totale: 210h
            </div>
        </div>

        <!-- Main Cards -->
        <div class="row mb-4">
            <!-- UE Selection Card -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0">
                        <h5 class="mb-0">
                            <i class="fas fa-list-check text-success me-2"></i>
                            Sélection des UE pour 2024/2025
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Charge minimale requise: <strong>192h</strong> |
                            Charge maximale: <strong>384h</strong>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th width="50"></th>
                                        <th>Code UE</th>
                                        <th>Intitulé</th>
                                        <th>Volume Horaire</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input ue-checkbox" type="checkbox"
                                                    value="1" data-heures="60" id="ue-1" checked>
                                            </div>
                                        </td>
                                        <td>INF101</td>
                                        <td>Algorithmique et programmation</td>
                                        <td><span class="badge bg-light-primary">60h</span></td>
                                        <td><span class="badge bg-success">Validé</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input ue-checkbox" type="checkbox"
                                                    value="2" data-heures="45" id="ue-2" checked>
                                            </div>
                                        </td>
                                        <td>INF102</td>
                                        <td>Structures de données</td>
                                        <td><span class="badge bg-light-primary">45h</span></td>
                                        <td><span class="badge bg-warning">En attente</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input ue-checkbox" type="checkbox"
                                                    value="3" data-heures="75" id="ue-3">
                                            </div>
                                        </td>
                                        <td>INF201</td>
                                        <td>Bases de données</td>
                                        <td><span class="badge bg-light-primary">75h</span></td>
                                        <td><span class="badge bg-secondary">Disponible</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input ue-checkbox" type="checkbox"
                                                    value="4" data-heures="30" id="ue-4">
                                            </div>
                                        </td>
                                        <td>INF202</td>
                                        <td>Réseaux informatiques</td>
                                        <td><span class="badge bg-light-primary">30h</span></td>
                                        <td><span class="badge bg-secondary">Disponible</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="fw-bold">Total sélectionné: <span id="total-heures">105</span>h</div>
                            <button class="btn btn-sm btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>
                                Soumettre mes choix
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current UE Card -->
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0">
                        <h5 class="mb-0">
                            <i class="fas fa-book-open text-info me-2"></i>
                            Mes UE actuelles (2023/2024)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">INF101 - Algorithmique</h6>
                                    <small class="text-muted">S1 | 60h (30CM + 20TD + 10TP)</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">2 groupes</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">INF102 - Structures données</h6>
                                    <small class="text-muted">S2 | 45h (20CM + 15TD + 10TP)</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">1 groupe</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Upload Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="mb-0">
                    <i class="fas fa-upload text-warning me-2"></i>
                    Dépôt des notes
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>UE</th>
                                <th>Session</th>
                                <th>Fichier</th>
                                <th>Date dépôt</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>INF101 - Algorithmique</td>
                                <td>Normale</td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>
                                        notes_inf101_normale.xlsx
                                    </span>
                                </td>
                                <td>15/06/2024</td>
                                <td><span class="badge bg-success">Validé</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>INF101 - Algorithmique</td>
                                <td>Rattrapage</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Non déposé
                                    </span>
                                </td>
                                <td>-</td>
                                <td><span class="badge bg-warning">En attente</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary">
                                        <i class="fas fa-upload me-1"></i>
                                        Uploader
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>INF102 - Structures données</td>
                                <td>Normale</td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>
                                        notes_inf102_normale.xlsx
                                    </span>
                                </td>
                                <td>18/06/2024</td>
                                <td><span class="badge bg-success">Validé</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- History Section -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="mb-0">
                    <i class="fas fa-history text-secondary me-2"></i>
                    Historique des années précédentes
                </h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="historyAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse2023">
                                2022/2023
                            </button>
                        </h2>
                        <div id="collapse2023" class="accordion-collapse collapse show"
                            data-bs-parent="#historyAccordion">
                            <div class="accordion-body">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        INF101 - Algorithmique
                                        <span class="badge bg-primary rounded-pill">60h</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        MATH201 - Algèbre linéaire
                                        <span class="badge bg-primary rounded-pill">45h</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse2022">
                                2021/2022
                            </button>
                        </h2>
                        <div id="collapse2022" class="accordion-collapse collapse"
                            data-bs-parent="#historyAccordion">
                            <div class="accordion-body">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        INF102 - Structures données
                                        <span class="badge bg-primary rounded-pill">45h</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        MATH101 - Analyse
                                        <span class="badge bg-primary rounded-pill">60h</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadNotesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Uploader les notes</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">UE</label>
                            <input type="text" class="form-control" value="INF101 - Algorithmique" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Session</label>
                            <input type="text" class="form-control" value="Rattrapage" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fichier Excel</label>
                            <input class="form-control" type="file" accept=".xlsx,.xls">
                        </div>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Vérifiez bien le format du fichier avant soumission
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary">Uploader</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Calculate total hours
                function calculateTotalHours() {
                    let total = 0;
                    document.querySelectorAll('.ue-checkbox:checked').forEach(checkbox => {
                        total += parseInt(checkbox.dataset.heures);
                    });
                    document.getElementById('total-heures').textContent = total;

                    // Show warning if below minimum
                    if (total < 192) {
                        alert('Attention: Votre charge horaire est inférieure au minimum requis (192h)');
                    }
                }

                // Initialize calculation
                calculateTotalHours();

                // Update on checkbox change
                document.querySelectorAll('.ue-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', calculateTotalHours);
                });

                // Initialize upload modal
                const uploadModal = new bootstrap.Modal(document.getElementById('uploadNotesModal'));

                document.querySelectorAll('[data-action="upload"]').forEach(button => {
                    button.addEventListener('click', function() {
                        uploadModal.show();
                    });
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .card {
                border: none;
                border-radius: 0.5rem;
            }

            .list-group-item {
                border-left: none;
                border-right: none;
            }

            .list-group-item:first-child {
                border-top: none;
            }

            .accordion-button:not(.collapsed) {
                background-color: rgba(13, 110, 253, 0.05);
                color: #0d6efd;
            }

            .badge {
                font-weight: 500;
            }

            .table th {
                font-weight: 600;
                font-size: 0.85rem;
            }
        </style>
    @endpush
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

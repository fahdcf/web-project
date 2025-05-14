<x-coordonnateur_layout>


    <style>
        /* ... vos styles CSS ... */
    </style>


    <div class="container-fluid p-0 pt-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">

            <h3 style="color: #330bcf; font-weight: 500;">La liste des vacataires</h3>


            <a type="submit" href="{{ route('coordonnateur.vacataires.create') }}"
                class="btn text-white rounded  fw-semibold my-2"
                style=" background-color: #4723d9; color:#ebebec !important;vertical-align: middle ;">
                Ajouter un vacataire
            </a>
        </div>

        <div class="pt-5 pb-2">
            <div class="accordion rounded" id="accordionFilters">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapsefilters" aria-expanded="false" aria-controls="collapsefilters">
                            Filtres
                        </button>
                    </h2>

                    <div id="collapsefilters" class="accordion-collapse collapse" data-bs-parent="#accordionFilters">
                        <div class="accordion-body">


                            <form id="filterForm" action="{{ route('coordonnateur.vacataires.index') }}" method="GET">
                                <div class="row mt-3">
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <label for="search" class="form-label">Rechercher</label>
                                        <input type="text" id="search" name="search" class="form-control"
                                            placeholder="Rechercher par nom ou ID" value="{{ request('search') }}">
                                    </div>

                                    {{-- Si vous avez une relation avec les départements --}}
                                    {{-- <div class="col-md-6 col-lg-3 mb-3">
                                        <label for="departementFilter" class="form-label">Département</label>
                                        <select class="form-select" id="departementFilter" name="departement" style="color:rgb(126, 124, 140); ">
                                            <option value="">Tous</option>
                                            @if (isset($Departements))
                                                @foreach ($Departements as $Departement)
                                                    <option value="{{ $Departement->name }}" {{ request('departement') == $Departement->name ? 'selected' : '' }}>{{ $Departement->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div> --}}

                                    <div class="col-md-6 col-lg-2 mb-3">
                                        <label for="statusFilter" class="form-label">Statut</label>
                                        <select class="form-select" id="statusFilter" name="status">
                                            <option value="">Tous</option>
                                            <option value="active"
                                                {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                                            <option value="inactive"
                                                {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-lg-2 mb-3">
                                        <label for="rowsPerPage" class="form-label">Lignes par page</label>
                                        <select id="rowsPerPage" name="rows" class="form-select">
                                            <option value="5" {{ request('rows') == '5' ? 'selected' : '' }}>5
                                            </option>
                                            <option value="15" {{ request('rows') == '15' ? 'selected' : '' }}>15
                                            </option>
                                            <option value="30" {{ request('rows') == '30' ? 'selected' : '' }}>30
                                            </option>
                                            <option value="100" {{ request('rows') == '100' ? 'selected' : '' }}>100
                                            </option>
                                            <option value="300" {{ request('rows') == '300' ? 'selected' : '' }}>300
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-12 col-lg-2 d-flex justify-content-center ">
                                        <button type="submit" class="btn btn-secondary w-100">Appliquer</button>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vacataires as $vacataire)
                            <tr>
                                <td>{{ $vacataire->id }}</td>

                                <td>
                                    <a href="{{ route('coordonnateur.vacataires.show', $vacataire->id) }}">
                                        {{-- Route de détails si vous en avez une --}}
                                        @if ($vacataire->userDetails && $vacataire->userDetails->profile_img)
                                            <img style="height: 40px;width: 40px;object-fit:cover;border-radius:50%;"
                                                src="{{ asset('storage/' . $vacataire->userDetails->profile_img) }}">
                                        @else
                                            <img style="height: 40px;width: 40px;object-fit:cover;border-radius:50%;"
                                                src="{{ asset('storage/images/default_profile_img.png') }}">
                                        @endif
                                    </a>
                                </td>

                                <td>{{ $vacataire->lastname }} {{ $vacataire->firstname }}</td>

                                <td>
                                    @if ($vacataire->user_details)
                                        <p
                                            style="{{ $vacataire->user_details->status == 'active' ? 'background-color:#28c76f; color:white;' : 'background-color:#ea5455; color:white;' }} padding:2px 5px;border-radius:15px; margin:0;">
                                            {{ $vacataire->user_details->status }}
                                        </p>
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td>{{ $vacataire->email }}</td>

                                <td class="text-center">{{ $vacataire->created_at->format('Y-m-d') }}</td>


                                <td>
                                    <div class="d-flex  justify-content-center align-items-center gap-2">
                                        <a href="{{ route('coordonnateur.vacataires.edit', $vacataire->id) }}"
                                            class="btn  btn-sm" style="background-color:#4723d9;color: #ffffff;"><i
                                                class="bi bi-pencil-square"></i></a>

                                        <button class="btn ml-1 btn-danger btn-sm" data-toggle="modal"
                                            data-target="#Modalforid{{ $vacataire->id }}"><i class="bi bi-trash3"></i>
                                        </button>

                                        <div class="modal fade" id="Modalforid{{ $vacataire->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Confirmation de
                                                            suppression</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Voulez-vous supprimer le vacataire
                                                            <strong>{{ $vacataire->lastname }}</strong> définitivement?
                                                        </p>
                                                        <form
                                                            action="{{ route('coordonnateur.vacataires.destroy', $vacataire->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="btn ml-1 btn-secondary btn-sm"
                                                                    data-dismiss="modal">Fermer</button>
                                                                <button type="submit"
                                                                    class="btn ml-1 btn-danger btn-sm">Supprimer</button>
                                                            </div>
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
            {{-- pagination --}}
            <div class="d-flex justify-content-center my-4 ">
                @if ($vacataires->onFirstPage())
                    <span class="btn btn-secondary mx-1 disabled">Précédent</span>
                @else
                    <a href="{{ $vacataires->previousPageUrl() }}" class="btn  mx-1"
                        style="background-color:#4723d9;color:white;">Précédent</a>
                @endif

                @if ($vacataires->hasMorePages())
                    <a href="{{ $vacataires->nextPageUrl() }}" class="btn  mx-1"
                        style="background-color:#4723d9;color:white;">Suivant</a>
                @else
                    <span class="btn btn-secondary mx-1 disabled">Suivant</span>
                @endif
            </div>
        </div>

    </div>


    <script>
        function showPopup(vacataiareId, vacataiareName) {
            document.getElementById('vacataireName').innerText = vacataiareName;
            var vacataiareIdInput = document.getElementById('vacataire_id');
            vacataiareIdInput.value = vacataiareId;
            form.action = `/coordonnateur/vacataires/${vacataiareId}`;

            // Récupérer les informations actuelles du vacataire via AJAX et remplir le formulaire si nécessaire
            fetch(`/coordonnateur/vacataires/${vacataiareId}/edit`) // Créez cette route pour récupérer les détails
                .then(response => response.json())
                .then(data => {
                    document.getElementById('email').value = data.email;
                    document.getElementById('status').value = data.userDetails
                    .status; // Assurez-vous que le chemin est correct
                    // Remplissez d'autres champs si nécessaire
                })
                .catch(error => console.error('Erreur lors de la récupération des détails du vacataire:', error));


            document.getElementById("overlay").style.display = "flex";
        }

        function closePopup() {
            document.getElementById("overlay").style.display = "none";
        }
    </script>

</x-coordonnateur_layout>

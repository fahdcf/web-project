<x-coordonnateur_layout>
    <div class="container-fluid p-0 pt-5">
        <div class="bg-white rounded p-4" style="box-shadow: 1px 1px 10px 2px #33333314;">
            <h3 class="fw-bold mb-0" style="color:#3819b2;">Ajouter un Nouveau vacataire</h3>
            <p class="text-muted mt-2">Remplissez les champs ci-dessous pour créer un compte vacataire</p>
            <form action="{{ route('coordonnateur.vacataires.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mt-3">
                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="firstname"
                            class="form-label fw-bold">Prénom</label>
                        <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                            id="firstname" name="firstname" placeholder="Prénom.." value="{{ old('firstname') }}">
                        @error('firstname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="lastname"
                            class="form-label fw-bold">Nom</label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                            id="lastname" name="lastname" placeholder="Nom.." value="{{ old('lastname') }}">
                        @error('lastname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="email"
                            class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Email.." value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="password" class="form-label fw-bold">Mot de
                            passe</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Mot de passe">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="min_hours"
                            class="form-label fw-bold">Charge horaire minimale</label>
                        <input type="number" class="form-control @error('min_hours') is-invalid @enderror"
                            id="min_hours" name="min_hours" placeholder="Charge horaire minimale"
                            value="{{ old('min_hours') }}">
                        @error('min_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="max_hours"
                            class="form-label fw-bold">Charge horaire maximale</label>
                        <input type="number" class="form-control @error('max_hours') is-invalid @enderror"
                            id="max_hours" name="max_hours" placeholder="Charge horaire maximale"
                            value="{{ old('max_hours') }}">
                        @error('max_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="status"
                            class="form-label fw-bold">Statut</label>
                        <select type="text" class="form-select @error('status') is-invalid @enderror" id="status"
                            name="status">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactif
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="profile_img"
                            class="form-label fw-bold">Photo de profil</label>
                        <input type="file" class="form-control @error('profile_img') is-invalid @enderror"
                            id="profile_img" name="profile_img">
                        @error('profile_img')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                                                            <div class="col-md-6 col-lg-4 mt-3">
    <span style="color:#515151; font-weight: 700;">Sexe <span class="text-danger">*</span>:</span>
    <div class="d-flex gap-4 mt-2">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="sexe" id="sexe_male" 
                   value="male" {{ old('sexe') == 'male' ? 'checked' : '' }} required>
            <label class="form-check-label" for="sexe_male">Homme</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="sexe" id="sexe_female" 
                   value="female" {{ old('sexe') == 'female' ? 'checked' : '' }} required>
            <label class="form-check-label" for="sexe_female">Femme</label>
        </div>
    </div>
    @error('sexe')
        <div class="text-danger small mt-1">Veuillez sélectionner un sexe</div>
    @enderror
</div>

                </div>

                <div class="py-2 pb-4 mt-4">
                    <div class="accordion rounded" id="accordionFilters">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapsefilters" aria-expanded="false"
                                    aria-controls="collapsefilters">
                                    Plus d'informations (optionnel)
                                </button>
                            </h2>

                            <div id="collapsefilters" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFilters">
                                <div class="accordion-body">
                                    <div class="row mt-3">
                                        <div class="col-md-6 col-lg-4 mt-3">
                                            <label style="color:#515151; font-weight: 700;" for="date"
                                                class="form-label">Date de Naissance</label>
                                            <input type="date" id="date" name="date"
                                                class="form-control @error('date') is-invalid @enderror"
                                                value="{{ old('date') }}">
                                            @error('date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-lg-4 mt-3">
                                            <label style="color:#515151; font-weight: 700;" for="adresse"
                                                class="form-label">Adresse</label>
                                            <input type="text" id="adresse" name="adresse"
                                                class="form-control @error('adresse') is-invalid @enderror"
                                                placeholder="Votre adresse.." value="{{ old('adresse') }}">
                                            @error('adresse')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-lg-4 mt-3">
                                            <label style="color:#515151; font-weight: 700;" for="tele"
                                                class="form-label">Téléphone</label>
                                            <input type="number" id="tele" name="tele"
                                                class="form-control @error('tele') is-invalid @enderror"
                                                placeholder="Numéro de téléphone.." value="{{ old('tele') }}">
                                            @error('tele')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        

                                        <div class="col-md-6 col-lg-4 mt-3">
                                            <label style="color:#515151; font-weight: 700;" for="cin"
                                                class="form-label">CIN</label>
                                            <input type="text" id="cin" name="cin"
                                                class="form-control @error('cin') is-invalid @enderror"
                                                placeholder="Numéro de carte nationale.."
                                                value="{{ old('cin') }}">
                                            @error('cin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>






                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn text-white  px-4 py-2 fw-semibold shadow-sm"
                        style="background-color: #4723d9;">
                        + Créer le compte
                    </button>
                </div>
            </form>

            <style>
                /* Styles pour l'accordéon (informations optionnelles) */
                .accordion-button {
                    color: #333;
                    box-shadow: none;
                    transition: background-color 0.3s ease;
                    border-radius: 5px;
                    background-color: transparent;
                }

                .accordion-button:hover,
                .accordion-button:focus {
                    box-shadow: none;
                    background-color: transparent;
                    color: #333;
                }

                .accordion-button:not(.collapsed) {
                    background-color: transparent;
                    box-shadow: none;
                }

                .accordion-body {
                    padding: 1rem;
                    font-size: 0.95rem;
                    color: #555;
                }
            </style>
        </div>
    </div>
</x-coordonnateur_layout>

<x-coordonnateur_layout>
    <div class="container-fluid p-0 pt-5">
        <div class="bg-white rounded p-4" style="box-shadow: 1px 1px 10px 2px #33333314;">
            <h3 class="fw-bold mb-0" style="color:#3819b2;">Modifier le Vacataire</h3>
            <p class="text-muted mt-2">Modifiez les informations du vacataire ci-dessous.</p>
            <form action="{{ route('coordonnateur.vacataires.update', $vacataire->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mt-3">
                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="firstname"
                            class="form-label fw-bold">Prénom</label>
                        <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname"
                            placeholder="Prénom.." value="{{ old('firstname', $vacataire->firstname) }}">
                        @error('firstname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="lastname"
                            class="form-label fw-bold">Nom</label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" placeholder="Nom.." value="{{ old('lastname', $vacataire->lastname) }}">
                        @error('lastname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="email"
                            class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email.." value="{{ old('email', $vacataire->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="password" class="form-label fw-bold">Nouveau Mot de
                            passe <small class="text-muted">(laisser vide pour ne pas changer)</small></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                            placeholder="Nouveau Mot de passe">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="min_hours"
                            class="form-label fw-bold">Charge horaire minimale</label>
                        <input type="number" class="form-control @error('min_hours') is-invalid @enderror" id="min_hours" name="min_hours"
                            placeholder="Charge horaire minimale" value="{{ old('min_hours', $vacataire->min_hours) }}">
                        @error('min_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="max_hours"
                            class="form-label fw-bold">Charge horaire maximale</label>
                        <input type="number" class="form-control @error('max_hours') is-invalid @enderror" id="max_hours" name="max_hours"
                            placeholder="Charge horaire maximale" value="{{ old('max_hours', $vacataire->max_hours) }}">
                        @error('max_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="status"
                            class="form-label fw-bold">Statut</label>
                        <select type="text" class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="active" {{ old('status', $vacataire->status) == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="inactive" {{ old('status', $vacataire->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6  mt-4">
                        <label style="color:#515151; font-weight: 700;" for="profile_img"
                            class="form-label fw-bold">Photo de profil</label>
                        <input type="file" class="form-control @error('profile_img') is-invalid @enderror" id="profile_img" name="profile_img">
                        <small class="text-muted">Laissez vide pour conserver la photo actuelle.</small>
                        @error('profile_img')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($vacataire->profile_img)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $vacataire->profile_img) }}" alt="Photo de profil actuelle" style="max-width: 100px; border-radius: 5px;">
                            </div>
                        @endif
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
                                                class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $vacataire->user_details->date) }}">
                                            @error('date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-lg-4 mt-3">
                                            <label style="color:#515151; font-weight: 700;" for="adresse"
                                                class="form-label">Adresse</label>
                                            <input type="text" id="adresse" name="adresse" class="form-control @error('adresse') is-invalid @enderror"
                                                placeholder="Votre adresse.." value="{{ old('adresse', $vacataire->user_details->adresse) }}">
                                            @error('adresse')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-lg-4 mt-3">
                                            <label style="color:#515151; font-weight: 700;" for="tele"
                                                class="form-label">Téléphone</label>
                                            <input type="number" id="tele" name="tele" class="form-control @error('tele') is-invalid @enderror"
                                                placeholder="Numéro de téléphone.." value="{{ old('tele', $vacataire->user_details->number) }}">
                                            @error('tele')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-lg-4 mt-3">
                                            <label style="color:#515151; font-weight: 700;" for="cin"
                                                class="form-label">CIN</label>
                                            <input type="text" id="cin" name="cin" class="form-control @error('cin') is-invalid @enderror"
                                                placeholder="Numéro de carte nationale.." value="{{ old('cin', $vacataire->user_details->cin) }}">
                                            @error('cin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 col-lg-4 mt-3">
                                            <span style="color:#515151; font-weight: 700;">Sexe:</span>
                                            <div class="sex-group d-flex gap-4 mt-1">
                                                <label class="sex-label">
                                                    <input type="radio" name="sexe" value="male"
                                                        class="sex-input" {{ old('sexe', $vacataire->user_details->sexe) == 'male' ? 'checked' : '' }} />
                                                    <span class="sex-circle"></span>
                                                    Homme
                                                </label>
                                                <label class="sex-label">
                                                    <input type="radio" name="sexe" value="female"
                                                        class="sex-input" {{ old('sexe', $vacataire->user_details->sexe) == 'female' ? 'checked' : '' }} />
                                                    <span class="sex-circle"></span>
                                                    Femme
                                                </label>
                                                @error('sexe')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
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
                        <i class="fas fa-save me-1"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('coordonnateur.vacataires.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-arrow-left me-1"></i> Annuler
                    </a>
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
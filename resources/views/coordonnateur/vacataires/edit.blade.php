```html
<x-coordonnateur_layout>
    <style>
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

        /* Form Container */
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 2rem;
        }

        /* Form Elements */
        .form-label {
            color: #515151;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            border-color: #e0e0e0;
            border-radius: 6px;
            padding: 10px;
            font-size: 0.9rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4723d9;
            box-shadow: 0 0 0 3px rgba(71, 35, 217, 0.1);
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            font-size: 0.8rem;
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

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background-color: white;
            color: #6c757d;
            border-color: #6c757d;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Accordion */
        .accordion-button {
            color: #333;
            box-shadow: none;
            border-radius: 6px;
            background-color: #f8f9fa;
            font-weight: 500;
        }

        .accordion-button:hover,
        .accordion-button:focus {
            background-color: #e9ecef;
            color: #333;
        }

        .accordion-button:not(.collapsed) {
            background-color: #e9ecef;
            color: #4723d9;
        }

        .accordion-body {
            padding: 1.5rem;
            font-size: 0.95rem;
            color: #555;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-grid {
                grid-template-columns: 1fr;
            }

            .header-grid .d-flex.gap-2 {
                justify-content: center;
            }

            .form-container {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="container-fluid px-4 py-5">
        <div class="header-grid">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-user-graduate fa-2x" style="color: #330bcf;"></i>
                <h3 style="color: #330bcf; font-weight: 500;">Modifier le Vacataire</h3>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('coordonnateur.vacataires.index') }}"
                    class="btn btn-secondary rounded fw-semibold">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <div class="form-container">
            <p class="text-muted mb-4">Modifiez les champs ci-dessous pour mettre à jour le compte vacataire</p>
            <form action="{{ route('coordonnateur.vacataires.update', $vacataire->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="firstname" class="form-label">Prénom</label>
                        <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                            id="firstname" name="firstname" placeholder="Prénom" value="{{ old('firstname', $vacataire->firstname) }}">
                        @error('firstname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="lastname" class="form-label">Nom</label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                            id="lastname" name="lastname" placeholder="Nom" value="{{ old('lastname', $vacataire->lastname) }}">
                        @error('lastname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Email" value="{{ old('email', $vacataire->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Mot de passe (laisser vide pour ne pas modifier)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Nouveau mot de passe">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="min_hours" class="form-label">Charge horaire minimale</label>
                        <input type="number" class="form-control @error('min_hours') is-invalid @enderror"
                            id="min_hours" name="min_hours" placeholder="Heures minimales"
                            value="{{ old('min_hours', $vacataire->user_details->min_hours ?? '') }}">
                        @error('min_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="max_hours" class="form-label">Charge horaire maximale</label>
                        <input type="number" class="form-control @error('max_hours') is-invalid @enderror"
                            id="max_hours" name="max_hours" placeholder="Heures maximales"
                            value="{{ old('max_hours', $vacataire->user_details->max_hours ?? '') }}">
                        @error('max_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Statut</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                            name="status">
                            <option value="active" {{ old('status', $vacataire->user_details->status ?? '') == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="inactive" {{ old('status', $vacataire->user_details->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="profile_img" class="form-label">Photo de profil</label>
                        <input type="file" class="form-control @error('profile_img') is-invalid @enderror"
                            id="profile_img" name="profile_img" accept="image/*">
                        @if ($vacataire->user_details && $vacataire->user_details->profile_img)
                            <small class="form-text text-muted">Photo actuelle : {{ basename($vacataire->user_details->profile_img) }}</small>
                        @endif
                        @error('profile_img')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Sexe <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sexe" id="sexe_male"
                                    value="male" {{ old('sexe', $vacataire->sexe) == 'male' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="sexe_male">Homme</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sexe" id="sexe_female"
                                    value="female" {{ old('sexe', $vacataire->sexe) == 'female' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="sexe_female">Femme</label>
                            </div>
                        </div>
                        @error('sexe')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <div class="accordion" id="accordionFilters">
                        <div class="accordion-item border-0">
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
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="date" class="form-label">Date de naissance</label>
                                            <input type="date" class="form-control @error('date') is-invalid @enderror"
                                                id="date" name="date" value="{{ old('date', $vacataire->user_details->date ?? '') }}">
                                            @error('date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="adresse" class="form-label">Adresse</label>
                                            <input type="text" class="form-control @error('adresse') is-invalid @enderror"
                                                id="adresse" name="adresse" placeholder="Adresse"
                                                value="{{ old('adresse', $vacataire->user_details->adresse ?? '') }}">
                                            @error('adresse')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="tele" class="form-label">Téléphone</label>
                                            <input type="text" class="form-control @error('tele') is-invalid @enderror"
                                                id="tele" name="tele" placeholder="Numéro de téléphone"
                                                value="{{ old('tele', $vacataire->user_details->tele ?? '') }}">
                                            @error('tele')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="cin" class="form-label">CIN</label>
                                            <input type="text" class="form-control @error('cin') is-invalid @enderror"
                                                id="cin" name="cin" placeholder="Numéro de carte nationale"
                                                value="{{ old('cin', $vacataire->user_details->cin ?? '') }}">
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

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('coordonnateur.vacataires.index') }}"
                        class="btn btn-secondary rounded fw-semibold">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary rounded fw-semibold">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-coordonnateur_layout>
```
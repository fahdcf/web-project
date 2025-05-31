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

        /* Profile Container */
        .profile-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 2rem;
        }

        /* Form Elements */
        .form-label {
            color: #515151;
            font-weight: 600;
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

        /* Buttons Section */
        .buttons-section {
            display: flex;
            gap: 1rem;
            border-bottom: 1px solid #e0e0e0;
        }

        .buttons-section button {
            background: none;
            border: none;
            color: #555556;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            position: relative;
        }

        .buttons-section .active-btn button {
            color: #4723d9;
        }

        .buttons-section .line {
            height: 2px;
            background-color: #4723d9;
            position: absolute;
            bottom: -1px;
            left: 0;
            transition: width 0.3s ease;
        }

        .buttons-section .active-btn .line {
            width: 100%;
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

        .btn-danger {
            background-color: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-danger:hover {
            background-color: #dc3545;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Checkbox */
        #myCheckbox {
            width: 16px;
            height: 16px;
            accent-color: #4723d9;
            cursor: pointer;
        }

        /* Sex Radio Buttons */
        .sex-group {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            margin-top: 0.5rem;
        }

        .sex-input {
            display: none;
        }

        .sex-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .sex-circle {
            width: 16px;
            height: 16px;
            border: 2px solid #4723d9;
            border-radius: 50%;
            margin-right: 8px;
            position: relative;
        }

        .sex-input:checked + .sex-circle::after {
            content: "";
            width: 8px;
            height: 8px;
            background-color: #4723d9;
            border-radius: 50%;
            position: absolute;
            top: 2px;
            left: 2px;
        }

        /* Table */
        table {
            width: 100%;
            table-layout: auto;
        }

        table th,
        table td {
            text-align: center;
            padding: 0.5rem;
            font-size: 0.85rem;
        }

        table th label {
            font-weight: 500;
            font-size: 0.8rem;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #4723d9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #3a1cb3;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-grid {
                grid-template-columns: 1fr;
            }

            .header-grid .d-flex.gap-2 {
                justify-content: center;
            }

            .profile-container {
                padding: 1.5rem;
            }

            .buttons-section {
                flex-wrap: wrap;
            }
        }
    </style>

    <div class="container-fluid px-4 py-5">
        <div class="header-grid">
            <div class="d-flex align-items-center gap-3">
                <i class="fas fa-user-graduate fa-2x" style="color: #330bcf;"></i>
                <h3 style="color: #330bcf; font-weight: 500;">Profil du Vacataire</h3>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('coordonnateur.vacataires.index') }}"
                    class="btn btn-secondary rounded fw-semibold">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
                <a href="{{ route('coordonnateur.vacataires.create') }}"
                    class="btn btn-primary rounded fw-semibold">
                    <i class="fas fa-plus-circle"></i> Ajouter un compte vacataire
                </a>
                <a href="{{ route('coordonnateur.vacataires.edit', $vacataire->id) }}"
                    class="btn btn-primary rounded fw-semibold">
                    <i class="fas fa-pencil-alt"></i> Modifier
                </a>
                <button class="btn btn-danger rounded fw-semibold" data-bs-toggle="modal"
                    data-bs-target="#deleteVacataireModal">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </div>
        </div>

        <div class="profile-container">
            <section class="buttons-section">
                <div id="line1" class="active-btn">
                    <button onclick="togglebtnforcompte()"><i class="bi bi-person"></i> Compte</button>
                    <div class="line"></div>
                </div>
                <div id="line2">
                    <button onclick="togglebtnforoldinfo()"><i class="bx bx-info-circle"></i> Informations</button>
                    <div class="line"></div>
                </div>
                <div id="line3">
                    <button onclick="togglebtnforsecurite()"><i class="bx bx-lock-alt"></i> Sécurité</button>
                    <div class="line"></div>
                </div>
            </section>

            <form action="{{ route('coordonnateur.vacataires.update', $vacataire->id) }}" method="POST">
                @csrf
                @method('PUT')

                <section id="compte">
                    <div class="picture-container mt-5 d-flex align-items-center">
                        @if ($vacataire->user_details && $vacataire->user_details->profile_img)
                            <img style="height: 80px; width: 80px; object-fit: cover; border-radius: 15%; border: 2px solid #1e0a6e;"
                                src="{{ asset('storage/' . $vacataire->user_details->profile_img) }}">
                        @else
                            <img style="height: 80px; width: 80px; object-fit: cover; border-radius: 15%; border: 2px solid #1e0a6e;"
                                src="{{ asset('storage/images/default_profile_img.png') }}">
                        @endif

                        <div class="p-3">
                            <p style="color: rgb(29, 29, 29); font-weight: 600;">{{ $vacataire->firstname }} {{ $vacataire->lastname }}</p>
                            <button type="button" class="btn btn-primary mr-2" data-bs-toggle="modal"
                                data-bs-target="#changerModal">Changer</button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#supprimerModal">Supprimer</button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="firstname" class="form-label">Prénom</label>
                            <input type="text" id="firstname" name="firstname" class="form-control"
                                value="{{ $vacataire->firstname }}">
                            @error('firstname')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="lastname" class="form-label">Nom</label>
                            <input type="text" id="lastname" name="lastname" class="form-control"
                                value="{{ $vacataire->lastname }}">
                            @error('lastname')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ $vacataire->email }}">
                            @error('email')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="statusFilter" class="form-label">Statut</label>
                            <select class="form-select" id="statusFilter" name="status">
                                <option value="active" {{ optional($vacataire->user_details)->status == 'active' ? 'selected' : '' }}>Actif</option>
                                <option value="inactive" {{ optional($vacataire->user_details)->status == 'inactive' ? 'selected' : '' }}>Inactif</option>
                            </select>
                            @error('status')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="min_hours" class="form-label">Charge horaire minimale</label>
                            <input type="number" id="min_hours" name="min_hours" class="form-control"
                                value="{{ optional($vacataire->user_details)->min_hours }}">
                            @error('min_hours')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="max_hours" class="form-label">Charge horaire maximale</label>
                            <input type="number" id="max_hours" name="max_hours" class="form-control"
                                value="{{ optional($vacataire->user_details)->max_hours }}">
                            @error('max_hours')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="rounded border p-3 mt-4">
                        <p style="color: #272727; font-weight: 600;"><i class="bi bi-shield-lock"></i> Permissions</p>
                        <hr>
                        <div class="d-flex">
                            <p style="color: #4723d9; font-weight: 600; margin-right: 1rem;">Rôles :</p>
                            <div style="overflow-x: auto; width: 100%;">
                                <table>
                                    <thead>
                                        <tr>
                                            <th><label>Admin</label></th>
                                            <th><label>Coordonnateur</label></th>
                                            <th><label>Chef de Département</label></th>
                                            <th><label>Professeur</label></th>
                                            <th><label>Vacataire</label></th>
                                            <th><label>Étudiant</label></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input id="myCheckbox" type="checkbox" name="isadmin" value="1"
                                                    {{ optional($vacataire->role)->isadmin ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input id="myCheckbox" type="checkbox" name="iscoordonnateur" value="1"
                                                    {{ optional($vacataire->role)->iscoordonnateur ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input id="myCheckbox" type="checkbox" name="ischef" value="1"
                                                    {{ optional($vacataire->role)->ischef ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input id="myCheckbox" type="checkbox" name="isprof" value="1"
                                                    {{ optional($vacataire->role)->isprof ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input id="myCheckbox" type="checkbox" name="isVacataire" value="1"
                                                    {{ optional($vacataire->role)->isVacataire ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <input id="myCheckbox" type="checkbox" name="isstudent" value="1"
                                                    {{ optional($vacataire->role)->isstudent ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="informations" class="hidden mt-5">
                    <div class="row mt-3">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="date" class="form-label">Date de naissance</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ optional($vacataire->user_details)->date }}">
                            @error('date')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" id="adresse" name="adresse" class="form-control"
                                value="{{ optional($vacataire->user_details)->adresse }}"
                                placeholder="Votre adresse..">
                            @error('adresse')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="tele" class="form-label">Téléphone</label>
                            <input type="text" id="tele" name="tele" class="form-control"
                                value="{{ optional($vacataire->user_details)->tele }}"
                                placeholder="Numéro de téléphone..">
                            @error('tele')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="cin" class="form-label">CIN</label>
                            <input type="text" id="cin" name="cin" class="form-control"
                                value="{{ optional($vacataire->user_details)->cin }}"
                                placeholder="Numéro de carte nationale..">
                            @error('cin')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 col-lg-4 mb-3">
                            <span class="form-label">Sexe</span>
                            <div class="sex-group">
                                <label class="sex-label">
                                    <input type="radio" name="sexe" value="male" class="sex-input"
                                        {{ optional($vacataire->user_details)->sexe == 'male' ? 'checked' : '' }} />
                                    <span class="sex-circle"></span>
                                    Homme
                                </label>
                                <label class="sex-label">
                                    <input type="radio" name="sexe" value="female" class="sex-input"
                                        {{ optional($vacataire->user_details)->sexe == 'female' ? 'checked' : '' }} />
                                    <span class="sex-circle"></span>
                                    Femme
                                </label>
                            </div>
                            @error('sexe')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="rounded border p-3 mt-4">
                        <p style="color: #272727; font-weight: 600;"><i class="bi bi-info-square"></i> Détails</p>
                        <hr>
                        <div>
                            <p><strong>Rôle :</strong> Vacataire</p>
                            <p><strong>Date de création du compte :</strong> {{ $vacataire->created_at->format('Y-m-d H:i:s') }}</p>
                            <p><strong>Date de mise à jour du compte :</strong> {{ $vacataire->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </section>

                <section id="sécurité" class="hidden mt-5">
                    <h3 style="color: #3d3d3d;" class="mb-5">Changer le mot de passe</h3>
                    <div class="row mt-3 justify-content-center">
                        <div class="col-md-8 mb-3">
                            <label for="old_password" class="form-label">Mot de passe actuel</label>
                            <input id="old_password" type="password" name="old_password" class="form-control">
                            @error('old_password')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input id="password" type="password" name="password" class="form-control">
                            @error('password')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                class="form-control">
                            @error('password_confirmation')
                                <small class="text-danger pt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </section>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-danger">Réinitialiser</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>

            <!-- Modals -->
            <!-- Modal for Changer (Upload Picture) -->
            <div class="modal fade" id="changerModal" tabindex="-1" aria-labelledby="changerModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changerModalLabel">Changer l'image de profil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('coordonnateur.vacataires.update.image', $vacataire->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="fileInput" class="form-label">Choisissez une nouvelle image</label>
                                    <input class="form-control" type="file" id="fileInput" name="profile_img"
                                        accept="image/*">
                                    @error('profile_img')
                                        <small class="text-danger pt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Supprimer (Delete Picture Confirmation) -->
            <div class="modal fade" id="supprimerModal" tabindex="-1" aria-labelledby="supprimerModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="supprimerModalLabel">Confirmer la suppression de l'image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Êtes-vous sûr de vouloir supprimer cette image de profil ?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('coordonnateur.vacataires.delete.image', $vacataire->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Delete Vacataire Confirmation -->
            <div class="modal fade" id="deleteVacataireModal" tabindex="-1" aria-labelledby="deleteVacataireModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteVacataireModalLabel">Confirmer la suppression du vacataire</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Êtes-vous sûr de vouloir supprimer le compte de {{ $vacataire->firstname }} {{ $vacataire->lastname }} ? Cette action est irréversible.</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('coordonnateur.vacataires.destroy', $vacataire->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglebtnforcompte() {
            document.getElementById('line1').classList.add('active-btn');
            document.getElementById('line2').classList.remove('active-btn');
            document.getElementById('line3').classList.remove('active-btn');
            document.getElementById('compte').classList.remove('hidden');
            document.getElementById('informations').classList.add('hidden');
            document.getElementById('sécurité').classList.add('hidden');
        }

        function togglebtnforoldinfo() {
            document.getElementById('line1').classList.remove('active-btn');
            document.getElementById('line2').classList.add('active-btn');
            document.getElementById('line3').classList.remove('active-btn');
            document.getElementById('compte').classList.add('hidden');
            document.getElementById('informations').classList.remove('hidden');
            document.getElementById('sécurité').classList.add('hidden');
        }

        function togglebtnforsecurite() {
            document.getElementById('line1').classList.remove('active-btn');
            document.getElementById('line2').classList.remove('active-btn');
            document.getElementById('line3').classList.add('active-btn');
            document.getElementById('compte').classList.add('hidden');
            document.getElementById('informations').classList.add('hidden');
            document.getElementById('sécurité').classList.remove('hidden');
        }
    </script>
</x-coordonnateur_layout>
```
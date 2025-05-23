<x-admin_layout>
  <style>
    .hidden {
      display: none;
    }
    .buttons-section button {
      background: none;
      color: #555556;
      border: none;
      font-weight: 600;
      font-size: 14px;
    }
    #line {
      height: 2px;
      width: 2px;
      transition: width 0.5s ease; /* Transition for width from left to right */
    }
    .active-btn #line {
      width: 100% !important; /* Full width when active */
      background-color: #4723d9; /* Set the background color when active */
    }
    .active-btn button {
      color: #4723d9;
    }
    /* Ensure error messages are visible and styled consistently */
    .invalid-feedback {
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }
    /* Style for radio buttons to show error state */
    .sex-group .is-invalid + .sex-circle {
      border-color: #dc3545;
    }
  </style>

  <script>
    function togglebtnforchoose() {
      document.getElementById('line1').classList.add('active-btn');
      document.getElementById('line2').classList.remove('active-btn');
      document.getElementById('choose').classList.remove('hidden');
      document.getElementById('addnew').classList.add('hidden');
    }
    function togglebtnforaddnew() {
      document.getElementById('line1').classList.remove('active-btn');
      document.getElementById('line2').classList.add('active-btn');
      document.getElementById('choose').classList.add('hidden');
      document.getElementById('addnew').classList.remove('hidden');
    }
  </script>

  <div class="container-fluid p-0 pt-5">
    <div class="bg-white rounded p-4" style="box-shadow: 1px 1px 10px 2px #33333314;">
      <section class="buttons-section d-flex gap-2">
        <div id="line1" class="active-btn">
          <button onclick="togglebtnforchoose()"><i class="bi bi-list-check"></i> Choisir de la liste</button>
          <div id="line"></div>
        </div>
        <div id="line2">
          <button onclick="togglebtnforaddnew()"><i class='bi bi-plus-square'></i> Ajouter un Nouveau</button>
          <div id="line"></div>
        </div>
      </section>

      <div id="choose" class="mt-5">
        <h3 class="fw-bold mb-0" style="color:#3819b2;">Choisir de la liste des professeurs</h3>
        <form action="{{ url('admins/add') }}" method="POST" novalidate>
          @csrf
          @method('patch')

          <!-- list des professeur -->
          <div class="col-md-12 my-5">
            <label style="color:#515151; font-weight: 700;" for="professeur_id" class="form-label fw-bold">La liste des professeurs</label>
            <select class="form-select @error('professeur_id') is-invalid @enderror" id="professeur_id" name="professeur_id">
              <option value="">Sélectionner un professeur</option>
              @foreach ($professeurs as $professeur)
                <option value="{{ $professeur['id'] }}" {{ old('professeur_id') == $professeur['id'] ? 'selected' : '' }}>{{ $professeur->firstname }} {{ $professeur->lastname }}</option>
              @endforeach
            </select>
            @error('professeur_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Submit Button -->
          <div class="text-end mt-4">
            <button type="submit" class="btn text-white px-4 py-2 fw-semibold shadow-sm" style="background-color: #4723d9;">
              + Confirmer
            </button>
          </div>
        </form>
      </div>

      <div id="addnew" class="hidden mt-5">
        <h3 class="fw-bold mb-0" style="color:#3819b2;">Ajouter un Nouveau professeur</h3>
        <p class="text-muted mt-2">Remplissez les champs ci-dessous pour créer un professeur</p>
        <form action="{{ url('admins/add') }}" method="POST" enctype="multipart/form-data" novalidate>
          @csrf

          <!-- professeur firstName -->
          <div class="row mt-3">
            <div class="col-md-6 mt-4">
              <label style="color:#515151; font-weight: 700;" for="firstname" class="form-label fw-bold">Prénom</label>
              <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" placeholder="Prénom.." value="{{ old('firstname') }}">
              @error('firstname')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- professeur lastName -->
            <div class="col-md-6 mt-4">
              <label style="color:#515151; font-weight: 700;" for="lastname" class="form-label fw-bold">Nom</label>
              <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" placeholder="Nom.." value="{{ old('lastname') }}">
              @error('lastname')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- professeur email -->
            <div class="col-md-6 mt-4">
              <label style="color:#515151; font-weight: 700;" for="email" class="form-label fw-bold">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email.." value="{{ old('email') }}">
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- professeur password -->
            <div class="col-md-6 mt-4">
              <label style="color:#515151; font-weight: 700;" for="password" class="form-label fw-bold">Mot de passe</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Mot de passe">
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- professeur departement -->
            <div class="col-md-6 mt-4">
              <label style="color:#515151; font-weight: 700;" for="departement" class="form-label fw-bold">Département</label>
              <select class="form-select @error('departement') is-invalid @enderror" id="departement" name="departement">
                <option value="">Sélectionner un Département</option>
                @foreach ($Departements as $Departement)
                  <option value="{{ $Departement->name }}" {{ old('departement') == $Departement->name ? 'selected' : '' }}>{{ $Departement->name }}</option>
                @endforeach
              </select>
              @error('departement')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- professeur min_hours -->
            <div class="col-md-6 mt-4">
              <label style="color:#515151; font-weight: 700;" for="min_hours" class="form-label fw-bold">Charge horaire minimale</label>
              <input type="number" class="form-control @error('min_hours') is-invalid @enderror" id="min_hours" name="min_hours" placeholder="Charge horaire minimale" value="{{ old('min_hours') }}">
              @error('min_hours')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- professeur max_hours -->
            <div class="col-md-6 mt-4">
              <label style="color:#515151; font-weight: 700;" for="max_hours" class="form-label fw-bold">Charge horaire maximale</label>
              <input type="number" class="form-control @error('max_hours') is-invalid @enderror" id="max_hours" name="max_hours" placeholder="Charge horaire maximale" value="{{ old('max_hours') }}">
              @error('max_hours')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- professeur status -->
            <div class="col-md-6 mt-4">
              <label style="color:#515151; font-weight: 700;" for="status" class="form-label fw-bold">Status</label>
              <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
              @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- professeur profile -->
            <div class="col-md-6 mt-4">
              <label style="color:#515151; font-weight: 700;" for="profile_img" class="form-label fw-bold">Photo de profil</label>
              <input type="file" class="form-control @error('profile_img') is-invalid @enderror" id="profile_img" name="profile_img">
              @error('profile_img')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- professeur sexe -->
            <div class="col-md-6 mt-4">
              <label style="color:#515151; font-weight: 700;" class="form-label fw-bold">Sexe</label>
              <div class="sex-group d-flex gap-4 mt-1">
                <label class="sex-label">
                  <input type="radio" name="sexe" value="male" class="sex-input @error('sexe') is-invalid @enderror" {{ old('sexe') == 'male' ? 'checked' : '' }}>
                  <span class="sex-circle"></span> Homme
                </label>
                <label class="sex-label">
                  <input type="radio" name="sexe" value="female" class="sex-input @error('sexe') is-invalid @enderror" {{ old('sexe') == 'female' ? 'checked' : '' }}>
                  <span class="sex-circle"></span> Femme
                </label>
              </div>
              @error('sexe')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Accordion for optional fields -->
          <div class="py-2 pb-4 mt-4">
            <div class="accordion rounded" id="accordionFilters">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefilters" aria-expanded="false" aria-controls="collapsefilters">
                    Plus des Informations (optionnel)
                  </button>
                </h2>
                <div id="collapsefilters" class="accordion-collapse collapse" data-bs-parent="#accordionFilters">
                  <div class="accordion-body">
                    <div class="row mt-3">
                      <div class="col-md-6 col-lg-4 mb-3">
                        <label style="color:#515151; font-weight: 700;" for="date" class="form-label">Date de Naissance</label>
                        <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
                        @error('date')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="col-md-6 col-lg-4 mb-3">
                        <label style="color:#515151; font-weight: 700;" for="adresse" class="form-label">Adresse</label>
                        <input type="text" id="adresse" name="adresse" class="form-control @error('adresse') is-invalid @enderror" placeholder="Votre adresse.." value="{{ old('adresse') }}">
                        @error('adresse')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="col-md-6 col-lg-4 mb-3">
                        <label style="color:#515151; font-weight: 700;" for="tele" class="form-label">Téléphone</label>
                        <input type="number" id="tele" name="tele" class="form-control @error('tele') is-invalid @enderror" placeholder="Numéro de téléphone.." value="{{ old('tele') }}">
                        @error('tele')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="col-md-6 col-lg-4 mb-3">
                        <label style="color:#515151; font-weight: 700;" for="cin" class="form-label">CIN</label>
                        <input type="text" id="cin" name="cin" class="form-control @error('cin') is-invalid @enderror" placeholder="Numéro de carte nationale.." value="{{ old('cin') }}">
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

          <!-- Submit Button -->
          <div class="text-end">
            <button type="submit" class="btn text-white px-4 py-2 fw-semibold shadow-sm" style="background-color: #4723d9;">
              + Ajouter l'Admin
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <style>
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
</x-admin_layout>
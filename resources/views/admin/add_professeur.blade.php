<x-admin_layout>
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

  <div class="container-fluid p-0 pt-5">
    <div class="bg-white rounded p-4" style="box-shadow: 1px 1px 10px 2px #33333314;">
      <h3 class="fw-bold mb-0" style="color:#3819b2;">Ajouter un Nouveau Professeur</h3>
      <p class="text-muted mt-2">Remplissez les champs ci-dessous pour créer un professeur</p>
      <form action="{{ url('professeurs/add') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <!-- Professeur firstName -->
        <div class="row mt-3">
          <div class="col-md-6 mt-4">
            <label style="color:#515151; font-weight: 700;" for="firstname" class="form-label fw-bold">Prénom</label>
            <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" placeholder="Prénom.." value="{{ old('firstname') }}">
            @error('firstname')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Professeur lastName -->
          <div class="col-md-6 mt-4">
            <label style="color:#515151; font-weight: 700;" for="lastname" class="form-label fw-bold">Nom</label>
            <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" placeholder="Nom.." value="{{ old('lastname') }}">
            @error('lastname')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Professeur email -->
          <div class="col-md-6 mt-4">
            <label style="color:#515151; font-weight: 700;" for="email" class="form-label fw-bold">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email.." value="{{ old('email') }}">
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Professeur departement -->
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

          <!-- Professeur min_hours -->
          <div class="col-md-6 mt-4">
            <label style="color:#515151; font-weight: 700;" for="min_hours" class="form-label fw-bold">Charge horaire minimale</label>
            <input type="number" class="form-control @error('min_hours') is-invalid @enderror" id="min_hours" name="min_hours" placeholder="Charge horaire minimale" value="{{ old('min_hours') }}">
            @error('min_hours')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Professeur max_hours -->
          <div class="col-md-6 mt-4">
            <label style="color:#515151; font-weight: 700;" for="max_hours" class="form-label fw-bold">Charge horaire maximale</label>
            <input type="number" class="form-control @error('max_hours') is-invalid @enderror" id="max_hours" name="max_hours" placeholder="Charge horaire maximale" value="{{ old('max_hours') }}">
            @error('max_hours')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Professeur status -->
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

        

          <!-- Professeur sexe -->
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

                      <!-- Professeur profile -->
                      <div class="col-md-6 Col-lg-4 mt-3">
                        <label style="color:#515151; font-weight: 700;" for="profile_img" class="form-label fw-bold">Photo de profil</label>
                        <input type="file" class="form-control @error('profile_img') is-invalid @enderror" id="profile_img" name="profile_img">
                        @error('profile_img')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      
                    <div class="col-md-6 col-lg-4 mt-3">
                      <label style="color:#515151; font-weight: 700;" for="date" class="form-label">Date de Naissance</label>
                      <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
                      @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-md-6 col-lg-4 mt-3">
                      <label style="color:#515151; font-weight: 700;" for="adresse" class="form-label">Adresse</label>
                      <input type="text" id="adresse" name="adresse" class="form-control @error('adresse') is-invalid @enderror" placeholder="Votre adresse.." value="{{ old('adresse') }}">
                      @error('adresse')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-md-6 col-lg-4 mt-3">
                      <label style="color:#515151; font-weight: 700;" for="tele" class="form-label">Téléphone</label>
                      <input type="number" id="tele" name="tele" class="form-control @error('tele') is-invalid @enderror" placeholder="Numéro de téléphone.." value="{{ old('tele') }}">
                      @error('tele')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-md-6 col-lg-4 mt-3">
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
            + Ajouter Professeur
          </button>
        </div>
      </form>
    </div>
  </div>
</x-admin_layout>
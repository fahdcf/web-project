<x-admin_layout>
  <style>
    .page-wrapper {
      margin: 0 auto;
      background-color: white;
      padding: 20px;
      border-radius: 15px;
      max-width: 900px;
    }
    /* Ensure error messages are visible and styled consistently */
    .invalid-feedback {
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }
  </style>

  <div class="container-fluid p-0 pt-5">
    <div class="page-wrapper">
      <h3 class="fw-bold mb-0" style="color: #381cab;">Ajouter un Nouveau Département</h3>
      <p class="text-muted mt-2">Remplissez les champs ci-dessous pour créer un département</p>
      <form action="{{ url('departements/add') }}" method="POST" novalidate>
        @csrf

        <!-- Department Name -->
        <div class="mb-4">
          <label style="color:#515151; font-weight: 700;" for="name" class="form-label fw-bold">Nom du Département</label>
          <input type="text" class="form-control rounded @error('name') is-invalid @enderror" id="name" name="name" placeholder="Ex: Informatique" value="{{ old('name') }}">
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Select Professor -->
        <div class="mb-4 d-flex flex-column">
          <label style="color:#515151; font-weight: 700;" for="user_id" class="form-label fw-bold">Chef de Département</label>
          <select class="form-select py-2 rounded @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
            <option value="">-- Sélectionner un professeur --</option>
            @foreach ($professors as $professor)
              <option value="{{ $professor->id }}" {{ old('user_id') == $professor->id ? 'selected' : '' }}>{{ $professor->lastname }} {{ $professor->firstname }}</option>
            @endforeach
          </select>
          @error('user_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Submit Button -->
        <div class="text-end">
          <button type="submit" class="btn text-white rounded px-4 py-2 fw-semibold shadow-sm" style="background-color: #4723d9;">
            + Ajouter Département
          </button>
        </div>
      </form>
    </div>
  </div>
</x-admin_layout>
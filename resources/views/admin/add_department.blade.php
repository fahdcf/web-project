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
    /* Styles for tags input */
    .tags-input {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem;
      border: 1px solid #ced4da;
      border-radius: 0.375rem;
      background-color: #fff;
    }
    .tags-input:focus-within {
      border-color: #86b7fe;
      box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .tags-input input {
      flex: 1;
      border: none;
      outline: none;
      padding: 0.5rem 0;
    }
    .tag {
      display: inline-flex;
      align-items: center;
      background-color: #e9ecef;
      padding: 0.25rem 0.75rem;
      border-radius: 1rem;
      font-size: 0.875rem;
    }
    .tag-remove {
      display: inline-flex;
      margin-left: 0.5rem;
      cursor: pointer;
      color: #6c757d;
    }
    .tag-remove:hover {
      color: #dc3545;
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



        <!-- Specialties Tags Input -->
        <div class="mb-4">
          <label style="color:#515151; font-weight: 700;" class="form-label fw-bold">Spécialités</label>
          <div class="tags-input rounded @error('specialties') is-invalid @enderror" id="specialties-container">
            <input type="text" id="specialties-input" placeholder="Ajouter une spécialité et appuyez sur Entrée">
            <input type="hidden" name="specialties" id="specialties-hidden" value="{{ old('specialties') }}">
          </div>
          @error('specialties')
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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const container = document.getElementById('specialties-container');
      const input = document.getElementById('specialties-input');
      const hiddenInput = document.getElementById('specialties-hidden');
      
      // Initialize with existing values if any
      if (hiddenInput.value) {
        const specialties = hiddenInput.value.split(',');
        specialties.forEach(specialty => {
          if (specialty.trim()) {
            addTag(specialty.trim());
          }
        });
      }
      
      input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          const value = input.value.trim();
          if (value && document.querySelectorAll('.tag').length < 5) {
            addTag(value);
            input.value = '';
            updateHiddenInput();
          }
        }
      });
      
      function addTag(value) {
        const tag = document.createElement('span');
        tag.className = 'tag';
        tag.innerHTML = `
          ${value}
          <span class="tag-remove">&times;</span>
        `;
        
        const removeBtn = tag.querySelector('.tag-remove');
        removeBtn.addEventListener('click', function() {
          tag.remove();
          updateHiddenInput();
        });
        
        container.insertBefore(tag, input);
      }
      
      function updateHiddenInput() {
        const tags = Array.from(document.querySelectorAll('.tag'))
          .map(tag => tag.textContent.replace('×', '').trim());
        hiddenInput.value = tags.join(',');
      }
    });
  </script>
</x-admin_layout>
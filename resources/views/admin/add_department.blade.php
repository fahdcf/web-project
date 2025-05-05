<x-admin_layout>
    <div class="container py-5">
     
                        <h3 class="fw-bold mb-0" style="color: #124d96;">Ajouter un Nouveau Département</h3>
                        <p class="text-muted mt-2">Remplissez les champs ci-dessous pour créer un département</p>
                        <form action="{{ url('departements/add') }}" method="POST">
                            @csrf

                            <!-- Department Name -->
                            <div class="mb-4">
                                <label style="color:#515151; font-weight: 700;" for="name" class="form-label fw-bold">Nom du Département</label>
                                <input type="text" class="form-control rounded-pill" id="name" name="name" placeholder="Ex: Informatique">
                            </div>

                            <!-- Select Professor -->
                            <div class="mb-4 d-flex flex-column">
                                <label style="color:#515151; font-weight: 700;" for="professor" class="form-label fw-bold">Chef de Département</label>
                                <select class="form-select py-2 rounded-pill" id="professor" name="user_id">
                                    <option value="">-- Sélectionner un professeur --</option>
                                    @foreach ($professors as $professor)
                                        <option value="{{ $professor->id }}">{{ $professor->lastname }} {{ $professor->firstname }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit"
                                        class="btn text-white rounded-pill px-4 py-2 fw-semibold shadow-sm"
                                        style="background-color: #124d96;">
                                  + Ajouter Département
                                </button>
                            </div>
                        </form>
          
        </div>
</x-admin_layout>

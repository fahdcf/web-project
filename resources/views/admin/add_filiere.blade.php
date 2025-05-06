<x-admin_layout>

    <style>
        .page-wrapper{
            margin:0 auto;
            background-color: white;
            padding: 20px;
            border-radius:15px;
            max-width: 900px;
        }
    </style>
    <div class="container-fluid p-0 pt-5">
        <div class="page-wrapper">

      
     
                        <h3 class="fw-bold mb-0" style="color:#3919b8;">Ajouter un Nouveau filière</h3>
                        <p class="text-muted mt-2">Remplissez les champs ci-dessous pour créer un filière</p>
                        <form action="{{ url('filieres/add') }}" method="POST">
                            @csrf

                            <!-- filiere Name -->
                            <div class="mb-4">
                                <label style="color:#515151; font-weight: 700;" for="name" class="form-label fw-bold">Nom du Filiere</label>
                                <input type="text" class="form-control rounded" id="name" name="name" placeholder="Ex: Informatique">
                            </div>

                             <!-- Select depatement -->
                             <div class="mb-4 d-flex flex-column">
                                <label style="color:#515151; font-weight: 700;" for="Department" class="form-label fw-bold">Depatement</label>
                                <select class="form-select py-2 rounded" id="Depatement" name="departement_id">
                                    <option value="">-- Sélectionner une Departement --</option>
                                    @foreach ($Departements as $Departement)
                                        <option value="{{ $Departement->id }}">{{ $Departement->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select Cordonnateur -->
                            <div class="mb-4 d-flex flex-column">
                                <label style="color:#515151; font-weight: 700;" for="professor" class="form-label fw-bold">Coordonnateur de Filiere</label>
                                <select class="form-select py-2 rounded" id="professor" name="user_id">
                                    <option value="">-- Sélectionner un professeur --</option>
                                    @foreach ($professors as $professor)
                                        <option value="{{ $professor->id }}">{{ $professor->lastname }} {{ $professor->firstname }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit"
                                        class="btn text-white rounded px-4 py-2 fw-semibold shadow-sm"
                                        style="background-color: #4723d9;">
                                  + Ajouter le filière
                                </button>
                            </div>
                        </form>
            </div>
          
        </div>
</x-admin_layout>

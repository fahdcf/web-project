<x-chef_layout>
    <div class="container-fluid p-0 pt-5">
  
 <!-- Header Section -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h1 class="display-6 fw-bold  mb-2" style="color: #4723d9">Liste des Modules</h1>
                <p class="text-muted mb-0">Explorez tous les modules de la departement {{auth()->user()->manage->name}}</p>
            </div>
            
                <!-- Search Input -->
                <div class="search-container ">
                  <i class="bi bi-search search-icon pl-2"></i>
                    <input type="text" id="searchInput" class="form-control search-inputt pl-2" placeholder="Rechercher par nom ou coordonnateur...">
                </div>
                
              
        
        </div>

      <!-- Overlay -->
      <div id="overlay" class="overlay">
        <div class="popup">
          <h5 style="color: #202020">Modifier la filière <span id="filiereName"></span></h5>
          <form id="popupForm" action="" method="POST">
            @csrf
            @method('PATCH')
            <input hidden type="text" id="filiere_id" name="filiere_id">
            <div class="mb-4">
              <label style="color:#515151; width: 100%; font-weight: 700; text-align: start;" for="name" class="mt-4 form-label fw-bold">Nom du filière</label>
              <input style="color:#202020" type="text" class="form-control rounded" id="name" name="name" placeholder="Ex: Informatique">
            </div>
           
            <!-- Select Professor -->
            <div class="mb-4 d-flex flex-column">
              <label style="color:#515151; width: 100%; font-weight: 700; text-align: start;" for="professor" class="form-label fw-bold">Coordonnateur de filière</label>
              <select style="border-color:#3028893b;" class="form-select py-2 rounded" id="professor" name="user_id">
                <option value="">-- Sélectionner un professeur --</option>
                @foreach ($professors as $professor)
                  <option value="{{ $professor->id }}">{{ $professor->lastname }} {{ $professor->firstname }}</option>
                @endforeach
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn ml-1 btn-secondary btn-sm" onclick="closePopup()">Close</button>
              <button type="submit" class="btn ml-1 btn-success btn-sm">Update</button>
            </div>
          </form>
        </div>
      </div>

      <section class="table-container">
        <div class="table-responsive mt-4">
          <table class="table table-borderless">
            <thead>
              <tr style="color: #535050; font-weight: 600;font-size:15px;">
                <th>Name</th>
                <th>Département</th>
                <th>Coordonnateur de filière</th>
                <th>Date de création</th>
                <th class="pAlso">Action</th>
              </tr>
            </thead>
            <tbody id="filiereTableBody">
              @foreach ($filieres as $filiere)
                <tr class="filiere-row" 
                    data-name="{{ strtolower($filiere->name) }}"
                    data-coordonnateur="{{ $filiere->coordonnateur ? strtolower($filiere->coordonnateur->firstname.' '.$filiere->coordonnateur->lastname) : 'non associé' }}"
                    data-filiere="filiere-{{$filiere->id}}">
                  <td colspan="6" style="padding: 0;">
                    <div class="custom-row-wrapper" style="width: 100%">
                      <div class="custom-row d-flex" style="width: 100%">
                        <p>{{$filiere->name}}</p>
                        <p>{{$filiere->departement->name}}</p>
                        
                        @if ($filiere->coordonnateur)
                          <p>{{ $filiere->coordonnateur->firstname }} {{ $filiere->coordonnateur->lastname }}</p>
                        @else
                          <p><span style="background-color: #ea5455; color: white;padding:4px 5px;border-radius:15px;">Non associé</span></p>
                        @endif
                        
                        <p>{{ $filiere->created_at->format('Y-m-d') }}</p>
                       
                        <div class="pAlso d-flex justify-content-center">
                          <button style="background-color: #4723d9;color:white;" class="btn btn-sm" onclick="showPopup({{ $filiere['id'] }}, '{{ $filiere['name'] }}')" data-toggle="modal" data-target="#Modalformodifying">
                            <i class="bi bi-pencil-square"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </td>            
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </section>
    </div>
    
    <style>
        .filter-btn {
            color: #4723d9; 
            outline: 1px solid #4723d9;
        }

        .filter-btn:hover {
            color: #ffffff; 
            background-color: #4723d9;
        }

        .filter-btn:focus {
            color: #ffffff; 
            background-color: #4723d9;
        }

        /* Search Input Styling */
        .search-container {
          background:none;
         padding: 0px !important;
            min-width: 350px;
            border: 1px solid #4723d9;
        }

        .search-inputt {
          font-size: 14px;
            padding-left: 35px;
            border-radius: 8px;
            border:none;
            transition: all 0.3s;
            color: #270e8c !important;
            background:none;
        }
        .search-inputt::placeholder{
          color: #4723d99b !important;
        }

        .search-inputt:focus {
            border:none !important;
            box-shadow:none !important;
            outline: none;
            background:none;
        }

        .search-icon {
           
            color:#4723d9;
        }

        /* Main Container */
        .requests-container {
            padding: 2rem;
            min-height: 100vh;
        }
        
        /* Header */
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-title {
            color: #4723d9;
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        /* Table Container */
        .table-container{
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        thead tr {
            display: flex;
        }
        
        thead tr th{
            padding: 0.75rem;
            width: 100%;
            margin: 2px;
            text-align: center;
        }
        
        .custom-row {
            background-color: #ffffff;
            display: flex;
            padding: 10px;
        }
        
        .custom-row p{
            color: #3f3f3f;
            font-weight: 500;
        }
        
        .custom-row p, .pAlso {
            text-align: center;
            min-width: 200px;
            padding: 0.75rem;
            margin: 0;
            vertical-align: middle;
            text-wrap: wrap;
            word-break: break-all;
            width: 100%;
        }
        
        .pAlso{
            min-width: 100px;
            max-width: 100px;
        }
        
        .table-responsive {
            border-radius: 6px;
            width: 100%;
        }
    
        .filiere-row td .custom-row-wrapper {
            overflow-x: auto;
            width: 100%;
            margin: 2px;
            margin-bottom: 7px;
            outline:1px solid #4723d929;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease-in-out;
        }
    
        .filiere-row td .custom-row-wrapper:hover {
            outline:1px solid #4723d9;
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
   
        table{
            max-width: 1250px;
            margin: 0 auto;
        }
  
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
    
        .popup {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 400px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #666;
        }
    </style>
    
    <script>
        function showPopup(filiereId, filiereName) {
            document.getElementById('filiereName').innerText = filiereName;
            document.getElementById('filiere_id').value = filiereId;
            document.getElementById("name").value = filiereName;
            document.getElementById('popupForm').action = "{{ url('/chef/filieres/modifier') }}/" + filiereId;
            document.getElementById("overlay").style.display = "flex";
        }
    
        function closePopup() {
            document.getElementById("overlay").style.display = "none";
        }

        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filiereRows = document.querySelectorAll('.filiere-row');
            const filiereFilterItems = document.querySelectorAll('[data-filiere]');

            // Search function
            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase();
                
                filiereRows.forEach(row => {
                    const name = row.dataset.name;
                    const coordonnateur = row.dataset.coordonnateur;
                    const filiereId = row.dataset.filiere;
                    const currentFiliereFilter = document.querySelector('.dropdown-item.active[data-filiere]');
                    
                    // Check if row matches search term and current filter
                    const matchesSearch = searchTerm === '' || 
                        name.includes(searchTerm) || 
                        coordonnateur.includes(searchTerm);
                    
                    const matchesFilter = !currentFiliereFilter || 
                        currentFiliereFilter.dataset.filiere === 'all' || 
                        filiereId === currentFiliereFilter.dataset.filiere;
                    
                    if (matchesSearch && matchesFilter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show empty state if no results
                const visibleRows = Array.from(filiereRows).filter(row => row.style.display !== 'none');
                if (visibleRows.length === 0) {
                    if (!document.getElementById('emptyState')) {
                        const emptyState = document.createElement('tr');
                        emptyState.id = 'emptyState';
                        emptyState.innerHTML = `
                            <td colspan="6">
                                <div class="empty-state">Aucun résultat trouvé</div>
                            </td>
                        `;
                        document.getElementById('filiereTableBody').appendChild(emptyState);
                    }
                } else {
                    const emptyState = document.getElementById('emptyState');
                    if (emptyState) {
                        emptyState.remove();
                    }
                }
            }

            // Filter by filière
            filiereFilterItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Update active state
                    filiereFilterItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Trigger search
                    performSearch();
                });
            });

            // Search input event
            searchInput.addEventListener('input', performSearch);
        });
    </script>
</x-chef_layout>
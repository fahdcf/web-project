<x-admin_layout>
    <div class="container-fluid p-0 pt-5">
  
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
        <h1 style="color: #330bcf; font-weight: 500;">The list of filières</h1>
    
        
        <a type="submit" href="{{ url('filieres/add') }}"
        class="btn text-white rounded px-4 pt-2 fw-semibold shadow-sm"
        style=" height:44px; ;background-color: #4723d9; vertical-align: middle;text-align: center;">
        Ajouter une nouvelle filière
      </a>
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
              <label style="color:#515151; width: 100%; font-weight: 700; text-align: start;" for="name" class="mt-4 form-label fw-bold">Nom du Département</label>
              <input style="color:#202020" type="text" class="form-control rounded" id="name" name="name" placeholder="Ex: Informatique">
            </div>
            <!-- Select Département -->
            <div class="mb-4 d-flex flex-column">
              <label style="color:#515151; width: 100%; font-weight: 700; text-align: start;" for="departement" class="form-label fw-bold">Département</label>
              <select style="border-color:#3028893b;" class="form-select py-2 rounded" id="departement" name="departement_id">
                <option value="">-- Sélectionner un département --</option>
                @foreach ($departements as $departement)
                  <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                @endforeach
              </select>
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
  
      <div class="table-responsive mt-4 ">
        <table class="table table-borderless">
          <thead >
            <tr style="color: #535050; font-weight: 600;font-size:15px;">
              <th>Name</th>
              <th>Département</th>
              <th>Coordonnateur de filière</th>
              <th>Date de création</th>
              <th class="pAlso">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($filieres as $filiere)
              <tr class="filiere-row">
                <td colspan="6" style="padding: 0; background:#f5f5f5;">
                  <div class="custom-row-wrapper" style="width: 100%">
                    <div class="custom-row d-flex" style="width: 100%">
                      <p>{{$filiere->name}}</p>
                      <p>{{$filiere->departement->name}}</p>

                      
                      @if ($filiere->coordonnateur)
                          
                      <p>{{ $filiere->coordonnateur ? $filiere->coordonnateur->firstname : 'null' }} {{ $filiere->coordonnateur ? $filiere->coordonnateur->lastname : 'null' }}</p>
                      
                      @else
                      <p><span style="background-color: #ea5455; color: white;padding:4px 5px;border-radius:15px;" >Non associé</span></p>
                      @endif
                      
                      <p>{{ $filiere->created_at->format('Y-m-d') }}</p>
                     
                      <div class="pAlso d-flex align-items-center gap-2">
                        <input type="number" hidden id="pending_user_id_{{ $filiere['id'] }}" value="{{ $filiere['id'] }}">
                        <button style="background-color: #4723d9;color:white;" class="btn btn-sm" onclick="showPopup({{ $filiere['id'] }}, '{{ $filiere['name'] }}')" data-toggle="modal" data-target="#Modalformodifying"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn ml-1 btn-danger btn-sm" data-toggle="modal" data-target="#Modalforid{{ $filiere['id'] }}"><i class="bi bi-trash3"></i></button>
      
                      
                      </div>
  
                    </div>
                  </div>
                </td>            
              </tr>
  
    <!-- Modal -->
    <div class="modal fade" id="Modalforid{{ $filiere['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Vous voulez supprimer la filière <strong>{{ $filiere['name'] }}</strong> définitivement?</p>
            <form action="{{ url('/filieres/' . $filiere['id']) }}" method="POST">
              @csrf
              @method('DELETE')
              <div class="modal-footer">
                <button type="button" class="btn ml-1 btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn ml-1 btn-danger btn-sm">Delete</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
              @endforeach
          </tbody>
        </table>
      </div>
   
    
      <style>
  
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
  .custom-row p,.pAlso {
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
    widows: 100px;
  }
  
  
  thead {
      display: table-header-group;
      
      vertical-align: middle;
      unicode-bidi: isolate;
      border-color: inherit;
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
        }
      </style>
    
      <script>
        function showPopup(filiereId, filiereName) {
          document.getElementById('filiereName').innerText = filiereName;
          document.getElementById('filiere_id').value = filiereId;
          document.getElementById("name").value = filiereName;
          document.getElementById('popupForm').action = "{{ url('/filieres') }}/" + filiereId;
          document.getElementById("overlay").style.display = "flex";
        }
    
        function closePopup() {
          document.getElementById("overlay").style.display = "none";
        }
      </script>
    </x-admin_layout>

<x-admin_layout>
    <div class="container-fluid p-0 pt-5">
  
     

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
        <h1 style="color: #330bcf; font-weight: 500; text-align: center;">The list of departements</h1>
    
        
        <a type="submit" href="{{ url('departements/add') }}"
        class="btn text-white rounded px-4 pt-2 fw-semibold shadow-sm"
        style=" height:44px; ;background-color: #4723d9; vertical-align: middle;">
         <strong>+ </strong> Ajouter
      </a>
    </div>
    
  
  
    
    
  <!-- Overlay -->
  <div id="overlay" class="overlay">
    <div class="popup">
        <h5 style="color: #202020">Modifier la departement <span id="departementName"></span></h5>
 
                                               
        <form id="popupForm" action="" method="POST">
         @csrf
         @method('PATCH')
 
        <input hidden type="text" id="departement_id" name="departement_id"> 
 
        <div class="mb-4">
          <label style="color:#515151; width: 100%; font-weight: 700; text-align: start;" for="name" class=" mt-4 form-label fw-bold">Nom du Département</label>
          <input type="text" class="form-control rounded-pill" id="name" name="name">
      </div>
 
      <!-- Select Professor -->
      <div class="mb-4 d-flex flex-column">
          <label style=" color:#515151 ;width: 100%; font-weight: 700;text-align: start;" for="professor" class=" form-label fw-bold">Chef de Département</label>
          <select style="border-color:#3028893b;" class="form-select py-2 rounded-pill" id="professor" name="user_id">
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
              <th>Chef de departement</th>
              <th>Date de création</th>
              <th class="pAlso">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($departements as $departement)
              <tr class="departement-row">
                <td colspan="6" style="padding: 0; background:#f5f5f5;">
                  <div class="custom-row-wrapper" style="width: 100%">
                    <div class="custom-row d-flex" style="width: 100%">
                      <p>{{$departement->name}}</p>
                      @if ($departement->chef)
                          
                      <p>{{ $departement->chef ? $departement->chef->firstname : 'null' }} {{ $departement->chef ? $departement->chef->lastname : 'null' }}</p>
                      
                      @else
                      <p><span style="background-color: #ea5455; color: white;padding:4px 5px;border-radius:15px;" >Non associé</span></p>
                      @endif

                      <p>{{ $departement->created_at->format('Y-m-d') }}</p>
                      <div class="pAlso d-flex align-items-center gap-2">
                        <input type="number" hidden id="pending_user_id_{{ $departement['id'] }}" value="{{ $departement['id'] }}">
                        <button style="background-color: #4723d9;color:white;" class="btn btn-sm" onclick="showPopup({{ $departement['id'] }}, '{{ $departement['name'] }}')" data-toggle="modal" data-target="#Modalformodifying"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn ml-1 btn-danger btn-sm" data-toggle="modal" data-target="#Modalforid{{ $departement['id'] }}"><i class="bi bi-trash3"></i></button>
      
                      
                      </div>
  
                    </div>
                  </div>
                </td>            
              </tr>
  
    <!-- Modal -->
    <div class="modal fade" id="Modalforid{{ $departement['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Vous voulez supprimer la departement <strong>{{ $departement['name'] }}</strong> définitivement?</p>
            <form action="{{ url('/departements/' . $departement['id']) }}" method="POST">
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
    
        .departement-row td .custom-row-wrapper {
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
    
        .departement-row td .custom-row-wrapper:hover {
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
        // Function to show the popup and set the hidden input's value for the user id
        function showPopup(departementId, departementName) {
     
         document.getElementById('departementName').innerText=departementName;
         document.getElementById('name').value=departementName;
                var departementIdInput = document.getElementById('departement_id');
            departementIdInput.value=departementId;
            var form = document.getElementById('popupForm');
            form.action = "{{ url('/departements') }}/" + departementId;
            
            document.getElementById("overlay").style.display = "flex";
        }
     
        function closePopup(){
         document.getElementById("overlay").style.display = "none";
     
        }
     </script>
    </x-admin_layout>
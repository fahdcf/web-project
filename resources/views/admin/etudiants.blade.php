<x-admin_layout>  

      


    <style>
    
    .accordion {
    
      background-color: white;
      box-shadow: 1px 1px 10px 2px #33333314;
    
    }
    
    .accordion-button {
      color: #333;
      box-shadow: none;
      transition: background-color 0.3s ease;
      border: none;
      border-radius: 5px;
      background-color: transparent;
    }
    
    .accordion-button:hover,
    .accordion-button:focus {
      border: none;
      outline: none;
      box-shadow: none;
      background-color: transparent;
      color: #333;
    }
    
    /* Remove background/border when expanded */
    .accordion-button:not(.collapsed) {
      background-color: transparent;
      border: none;
      outline: none;
      box-shadow: none;
    }
    
    
    
    .accordion-body {
     
      padding: 1rem;
      font-size: 0.95rem;
      color: #555;
    }
    #collapsefilters{
        border:none;
    }
    
    .pagehead button{
    border:none;
    background:none;
    }
    
    .pagehead input:focus{
        outline: none;
    
    }
    select.form-select:focus {
      box-shadow: none !important;
    }
    
    .accordion-body button{
        margin-top: 32px;
        border:1px solid #4723d9;
        border-radius: 4px;
       
        background-color:  #4723d9;
        color: white;
        width: 100%;
        font-weight: 500;
        height: 37px;
        transition: 0.3s;
    }
    .accordion-body button:hover{
       
        background-color: white;
        color: #4723d9;
    }
    
    </style>
    
    
    
        
        <div class="container-fluid p-0 pt-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">

                <h3 style="color: #330bcf; font-weight: 500;">The list of etudiants</h3>
                
                
                
                <a type="submit" href="{{url('etudiants/add')}}"
                class="btn text-white rounded  fw-semibold my-2"
                style=" background-color: #4723d9; color:#ebebec !important;vertical-align: middle ;">
                Ajeuter un etudiant
                
            </a>
        </div>
            
        <div class="pt-5 pb-2">
            <div class="accordion rounded" id="accordionFilters">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefilters" aria-expanded="false" aria-controls="collapsefilters">
                            Filters
                        </button>
                    </h2>
        
                    <div id="collapsefilters" class="accordion-collapse collapse" data-bs-parent="#accordionFilters">
                        <div class="accordion-body">
        
    
                            
                            <!-- Filter Form -->
                            <form id="filterForm" action="{{url('/etudiants')}}" method="post">
                            @csrf
                            @method('patch')
                            
                                <div class="row mt-3">
    
                                    <!-- Search & Row Count Form -->
                            <div class="col-md-6 col-lg-3 mb-3">
                                <label for="search" class="form-label">Search</label>
                                        <input type="text" id="search" name="search" class="form-control" placeholder="Search by name or ID">
                                    </div>
    
    
                                 
        
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <label for="filiereFilter" class="form-label">filiere</label>
                                        <select class="form-select" id="filiere" name="filiere">
                                            <option value="">All</option>
                                            @foreach ($filieres as $filiere)
                                                <option value="{{ $filiere->name }}">{{ $filiere->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
        
                                
                                    <div class="col-md-6 col-lg-2 mb-3">
                                        <label for="statusFilter" class="form-label">Status</label>
                                        <select class="form-select" id="statusFilter" name="status">
                                            <option value="">All</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
        
                            
        
                                    <div class="col-md-6 col-lg-2 mb-3">
                                        <label for="rowsPerPage" class="form-label">Rows per page</label>
                                        <select id="rowsPerPage" name="rows" class="form-select">
                                            <option value="5">5</option>
                                            <option value="15">15</option>
                                            <option value="30">30</option>
                                            <option value="100">100</option>
                                            <option value="300">300</option>
    
                                        </select>
                                    </div>
        
                                    <div class="col-md-12 col-lg-2 d-flex justify-content-center ">
                                        <button type="submit" class="btn btn-secondary w-100">Apply</button>
                                    </div>
                                </div>
                            </form>
        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
          
          
    
            <div class="table-container mt-4 mb-5 flex-column" >
                
                <div class="table-responsive p-3 ">
                  
                    <table class="table bg-white  table-hover">
                        <thead >
                            <tr class="text-light">
                                <th>id</th>
                                <th>Photo</th>
                                <th>Nom complet</th>
                                <th>Etat</th>
                                <th>Email</th>
                                <th>Date de creation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($etudiants as $etudiant)
                          <tr>
                                <td>{{ $etudiant['id'] }}</td>
                                
                                <td>
                                    <a href="{{url('etudiant-profile/'. $etudiant->id)}}">
                                    @if ($etudiant->user_details)
                                    @if ($etudiant->user_details->profile_img!=null)
                                    
                                        
                                        <img  style="height: 40px;width: 40px;object-fit:cover;border-radius:50%;" src="{{asset('storage/' . $etudiant->user_details->profile_img)}}">
                                        @else
                                        <img style="height: 40px;width: 40px;object-fit:cover;border-radius:50%;" src="{{asset('storage/images/default_profile_img.png')}}">
                                        
                                        @endif
                                        
                                        
                                        @else
                                        <img style="width: 35px; border-radius:50%;" src="{{asset('storage/images/default_profile_img.png')}}">
                                        
                                        @endif
                                    </a>
                               
                                    
                                </td>
                                
                                <td>{{ $etudiant->lastname }} {{ $etudiant->firstname }}</td>
                              
                                <td>@if ($etudiant->user_details)
    
                                   <p style="{{$etudiant->user_details->status=='active' ? 'background-color:#28c76f; color:white;': 'background-color:#ea5455; color:white;'}} padding:2px 5px;border-radius:15px; margin:0;">
                                       {{$etudiant->user_details->status}}
                                    </p>
                                    
                                    
                                    @else
                                    Null
                                    @endif
                                </td>
                               
                                <td>{{ $etudiant['email'] }}</td>
                            
                                <td class="text-center">{{ $etudiant->created_at->format('Y-m-d') }}</td>
                                
                                
                                
                                <td>
                                    <div  class="d-flex  justify-content-center align-items-center gap-2" >
                                        
                                            <a href="{{url('etudiant-profile/'. $etudiant->id)}}" class="btn btn-sm" style="background-color: #4723d9; color: white;"><i class="bi bi-pencil-square"></i></a>
                                        
                                        
                                        <button class="btn ml-1 btn-danger btn-sm" data-toggle="modal" data-target="#Modalforid{{$etudiant['id']}}"><i class="bi bi-trash3"></i>
                                        </button>
                                        
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="Modalforid{{$etudiant['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>TVous voulez supprimer la etudiant <strong>{{$etudiant['lastname']}}</strong> definitivement?</p>         
                                                        
                                                        <form action="{{ url('/etudiants/' . $etudiant['id']) }}" method="POST">
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
                                        
                                    </div>
                                </td>
                            
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center my-4 ">
                    @if ($etudiants->onFirstPage())
                        <span class="btn btn-secondary mx-1 disabled">Previous</span>
                    @else
                        <a href="{{ $etudiants->previousPageUrl() }}" class="btn  mx-1" style="background-color:#4723d9;color:white;">Previous</a>
                    @endif
                
                    @if ($etudiants->hasMorePages())
                        <a href="{{ $etudiants->nextPageUrl() }}" class="btn  mx-1" style="background-color:#4723d9;color:white;">Next</a>
                    @else
                        <span class="btn btn-secondary mx-1 disabled">Next</span>
                    @endif
                </div>
            </div>
    
            </div>
     
    
     
      <style>
    
    .table-container {
        background-color: white;
        width: 100%;
        display: flex;
        justify-content: center;
        overflow-y:hidden;       
        overflow-x: auto; 
        max-height: 80vh;
        scrollbar-width: thin;  /* Firefox */
        scrollbar-color: #ccc transparent;
        box-shadow: 1px 1px 10px 2px #33333314;
    
        
        
    }
    table{
        min-width: 1100px;
    }
    
        td{
            font-size: 14px;
            color: #585858;
            font-weight: 500;
            text-align: center !important;
            vertical-align: middle !important; /* Vertically center content */
    
        }
    
        .table-hover tbody tr:hover {
        background-color: rgba(248, 248, 252, 0.006) !important; 
        cursor: pointer; 
    }
    
    /* For WebKit-based browsers (Chrome, Safari, Edge) */
    .table-container::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }
    
    .table-container::-webkit-scrollbar-thumb {
        background-color: #aaa;
        border-radius: 10px;
    }
    
    .table-container::-webkit-scrollbar-track {
        background: transparent;
    }
    
        
        th{
            text-align: center;
    
          border-bottom:1px solid #3737375a !important;
            border-top:none !important;
            color: rgb(80, 79, 79);
            font-size: 15px;
            font-weight: 600;
        }
         table thead{
            box-shadow: 0 7px 5px -6px rgba(0, 0, 0, 0.1);
        }
       
           /* Overlay background darkening */
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
    
           /* Popup style */
           .popup {
               background-color: white;
               padding: 20px;
               border-radius: 8px;
               text-align: center;
               width: 400px;
           }
    
         
    
           .popup button {
               padding: 10px 20px;
               color: white;
               border: none;
               border-radius: 5px;
               cursor: pointer;
           }
    
         
       </style>
    
      <!-- Overlay -->
      <div id="overlay" class="overlay">
       <div class="popup">
           <h5 style="color: #202020">Modifier la etudiant<span id="etudiantName"></span></h5>
    
                                                  
           <form id="popupForm" action="" method="POST">
            @csrf
            @method('PATCH')
    
           <input hidden type="text" id="etudiant_id" name="etudiant_id"> 
    
           <div class="mb-4">
             <label style="color:#515151; width: 100%; font-weight: 700; text-align: start;" for="name" class=" mt-4 form-label fw-bold">Nom du Département</label>
             <input type="text" class="form-control rounded-pill" id="name" name="name" placeholder="Ex: Informatique">
         </div>
    
         <!-- Select etudiant -->
         <div class="mb-4 d-flex flex-column">
             <label style=" color:#515151 ;width: 100%; font-weight: 700;text-align: start;" for="etudiant" class=" form-label fw-bold">Chef de Département</label>
             <select style="border-color:#3028893b;" class="form-select py-2 rounded-pill" id="etudiant" name="user_id">
                 <option value="">-- Sélectionner un etudiant --</option>
                 @foreach ($etudiants as $etudiant)
                     <option value="{{ $etudiant->id }}">{{ $etudiant->lastname }} {{ $etudiant->firstname }}</option>
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
    
    
    
    <script>
       // Function to show the popup and set the hidden input's value for the user id
       function showPopup(etudiantId, etudiantName) {
    
        document.getElementById('etudiantName').innerText=etudiantName;
           var etudiantIdInput = document.getElementById('etudiant_id');
           etudiantIdInput.value=etudiantId;
           var form = document.getElementById('popupForm');
           form.action = "{{ url('/etudiants') }}/" + etudiantId;
           
           document.getElementById("overlay").style.display = "flex";
       }
    
       function closePopup(){
        document.getElementById("overlay").style.display = "none";
    
       }
    </script>
    
    </x-admin_layout>
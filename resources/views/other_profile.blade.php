@php
    $layout = 'layout'; // default layout

    if (auth()->user()->role->isadmin) {
        $layout = 'components.admin_layout';
    } elseif (auth()->user()->role->ischef) {
        $layout = 'components.chef_layout';
    } elseif (auth()->user()->role->iscoordonnateur) {
        $layout = 'components.coordonnateur_layout';
    } elseif (auth()->user()->role->isprof) {
        $layout = 'components.professor_layout';
    } elseif (auth()->user()->role->isvocataire) {
        $layout = 'components.vacataire_layout';
    } else {
        $layout = 'components.layout';
    }

@endphp

@component($layout)
    
    <style>
    
    .container{
        display: flex;
    flex-direction: column;
    align-items: center;
    }
    
    
        .input:focus {
            outline: 1px solid #cccfe100;
    }
    
        button{
            background-color: #3169ad;
            border: 1px solid #265894;
            border-radius: 4px;
            padding: 5px 10px 5px 10px;
            color: rgb(236, 236, 236);
            text-wrap: nowrap;
    
        }
    
    
    
         
      button:disabled{
        background-color: white;
        border: 1px solid #cccfe1a6;
        color: #cccfe1a6;
        
        
    }
    
    .profile-container{
        background-color: white;
        border-radius: 7px;
        padding: 20px;
        box-shadow: 1px 1px 10px 2px #33333314;
    
    
    }
    .hidden{
        display: none;
    }
    
    
    th label{
        font-weight: 500;
        font-size: 13px;   
    
    
    }
    table{
        width: 100%;
        overflow-x: auto;
        max-width: 100%;
      
    }
    
    ::-webkit-scrollbar {
      height: 3px;
      width: 5px;
    }
    
    /* Track */
    ::-webkit-scrollbar-track {
      background: #f1f1f1; 
      border-radius: 15px
    }
     
    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #3300ff8e; 
      border-radius: 10px;
    }
    
    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #7a5af9; 
    }
    
    
    table td{
        padding-bottom:20px; 
    }
    
    table td, table th {
        width: 158px;
       text-align: center;
    }
    .buttons-section button{
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
    
    .goodBtn{
        background-color: #4723d9;
    }
    .goodBtn:hover{
        box-shadow:2px 5px 9px -2px #4e2adac3;
    }
    
    .dangerBtn{
        background: transparent;
        border: 1px solid #ef7d7e;
        color: #ef7d7e;
    }
    .dangerBtn:hover{
        box-shadow:2px 5px 9px -2px #ef7d7f7a;
    }
    
    #myCheckbox {
        width: 15px;
        height: 15px;
        accent-color: #4723d9; /* Modern approach for changing checkbox color */
        cursor: pointer;
    }

    .sex-group {
          display: flex;
          gap: 1.5rem;
          align-items: center;
          margin-top: 1rem;
        }
        
        .sex-input {
          display: none;
        }
        
        .sex-label {
          display: flex;
          align-items: center;
          cursor: pointer;
          font-weight: 500;
        }
        
        .sex-circle {
          width: 16px;
          height: 16px;
          border: 2px solid #4723d9;
          border-radius: 50%;
          margin-right: 8px;
          position: relative;
        }
        
        .sex-input:checked + .sex-circle::after {
          content: "";
          width: 8px;
          height: 8px;
          background-color: #4723d9;
          border-radius: 50%;
          position: absolute;
          top: 2px;
          left: 2px;
        }

        
   
        </style>
    
 


    
    <div class="container-fluid p-0 py-5">
        <div class="profile-container d-flex flex-column">
            <section class="buttons-section d-flex gap-2">
    
               
              <div id="line1" class="active-btn">
                <button onclick="togglebtnforcompte()"><i class="bi bi-person"></i> Compte</button>
                <div id="line"></div>
              </div>
    
                 <div id="line2">
                <button onclick="togglebtnforoldinfo()"><i class='bx bx-info-circle' ></i> Informations</button>
                <div id="line"></div>
              </div>
                
          
    
    
            </section>
    
    
            
            <form action="{{ route('profile.edit', ['id' => $user->id]) }}" method="post">
                @csrf
    
            <section id="compte">
            <div class="picture-container mt-5 d-flex flex-column align-items-center">
    
                @if ($user->user_details)
                @if ($user->user_details->profile_img!=null)
                

                <img style="height: 130px;width: 130px;object-fit:cover;border-radius:50%; border: 2px solid #1e0a6e;" src="{{asset('storage/' . $user->user_details->profile_img)}}">
                @else
                <img style="height: 130px;width: 130px;object-fit:cover;border-radius:50%;  border: 2px solid #1e0a6e;" src="{{asset('storage/images/default_profile_img.png')}}">
                
                @endif
                
                
                @else
                <img style="height: 80px;width: 80px;object-fit:cover;border-radius:15%;  border: 2px solid #1e0a6e;" src="{{asset('storage/images/default_profile_img.png')}}">
                
                @endif
    
                <div class="p-3" >
                    <p  style="font-size:19px ;color: rgb(67, 66, 66); font-weight:600">{{$user->firstname}} {{$user->lastname}}</p>
      
                </div>
            </div>
    
            <div>
                <div class="row mt-3">
    
            <div class="col-md-6 col-lg-4 mb-3">
                <label for="firstname" class="form-label">Prenom</label>
                <p class="form-control">{{$user->firstname}}</p>
            </div>
                                    
            <div class="col-md-6 col-lg-4 mb-3">
                <label for="lastname" class="form-label">Nom</label>
                <p class="form-control">{{$user->lastname}}</p>
            </div>
    
                 
                    <div class="col-md-6 col-lg-4 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <p class="form-control">{{$user->email}}</p>
                    </div>
            
    
                    <div class="col-md-6 col-lg-4 mb-3">
                        <label for="departementFilter" class="form-label">Departement</label>
                     <p class="form-control">{{$user->departement}}</p>
                    </div>
    
                  
            

    
                    <div class="col-md-6 col-lg-4 mb-3">
                        <label for="rowsPerPage" class="form-label">charge horaire minimale</label>
                        <p class="form-control">{{$user->user_details->min_hours}}</p>
                        
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <label for="rowsPerPage" class="form-label">charge horaire maximale</label>
                        <p class="form-control">{{$user->user_details->max_hours}}</p>
                        
                    </div>
                   
            </div>
        </div>
    
        <div class="rounded border p-3">
            <p style="color: #272727; font-weight: 600;">
                <i class="bi bi-shield-lock"></i> Permissions
            </p>
            <hr>
        
            <div class="d-flex">
                <p class="pr-4 nowrap" style="text-wrap: nowrap;color: #4723d9; font-weight: 600;">Roles :</p>
                <div style="overflow-x: auto; width: 100%;">
                    <table style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr>
                                <th><label>Admin</label></th>
                                <th><label>Coordonnateur</label></th>
                                <th><label>Chef de Departement</label></th>
                                <th><label>Professeur</label></th>
                                <th><label>Vocataire</label></th>
                                <th><label>Student</label></th>
                            </tr>
                        </thead>  
                        <tbody>
                            <tr>
                                <td>
                                    <input type="checkbox" value="1"
                                        {{ optional($user->role)->isadmin ? 'checked' : '' }} disabled>
                                </td>
                                <td>
                                    <input type="checkbox" value="1"
                                        {{ optional($user->role)->iscoordonnateur ? 'checked' : '' }} disabled>
                                </td>
                                <td>
                                    <input type="checkbox" value="1"
                                        {{ optional($user->role)->ischef ? 'checked' : '' }} disabled>
                                </td>
                                <td>
                                    <input type="checkbox" value="1"
                                        {{ optional($user->role)->isprof ? 'checked' : '' }} disabled>
                                </td>
                                <td>
                                    <input type="checkbox" value="1"
                                        {{ optional($user->role)->isvocataire ? 'checked' : '' }} disabled>
                                </td>
                                <td>
                                    <input type="checkbox" value="1"
                                        {{ optional($user->role)->isstudent ? 'checked' : '' }} disabled>
                                </td>
                            </tr>
                        </tbody>  
                    </table>
                </div>
            </div>
        </div>
        </form>
        
    </section>
    
 
        
    <section id="informations" class="hidden mt-5">
       

        <div>
            <div class="row mt-3">

        <div class="col-md-6 col-lg-4 mb-3">
            <label for="date" class="form-label">Date de Naissance</label>
            <p class="form-control">{{$user->user_details->date_of_birth}}</p>
        </div>


                <div class="col-md-6 col-lg-4 mb-3">
                    <label for="adresse" class="form-label">Address</label>
                    <p class="form-control">{{$user->user_details->adresse}}</p>
                </div>
        
             
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="tele" class="form-label">Telephone</label>
                            <p class="form-control">{{$user->user_details->number}}</p>
                        </div>
                
                     
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <label for="cin" class="form-label">CIN</label>
                                    <p class="form-control">{{$user->user_details->cin}}</p>
                                </div>
                        
                                        <div class="col-md-6 col-lg-4 mb-3">
                                           
                                            <span >Sexe:</span>
                                           <strong> {{$user->user_details->sexe ==="male"? 'Home':'Femme' }}</strong>
                                            </div>
                             
            
        </div>
    </div>


    <div class="rounded border p-3" >
        <p style="color: #272727; font-weight: 600;"><i class="bi bi-info-square"></i> Details</p>
        <hr>


<div class="pl-4">


                    
        <p ><strong>Role: </strong>{{$user->role_column}}</p>
        <p ><strong>Date de creation de compte: </strong>{{$user->created_at}}</p>
        <p ><strong>Date de mise a jour de compte: </strong>{{$user->updated_at}}</p>



    </div>
</div>
</section>


    
    
    
    
     <script>
        function togglebtnforoldinfo(){
            document.getElementById('line1').classList.remove('active-btn');
            document.getElementById('line2').classList.add('active-btn');
        
            document.getElementById('informations').classList.remove('hidden');
            document.getElementById('compte').classList.add('hidden');
          
        
        }
        function togglebtnforcompte(){
            document.getElementById('line1').classList.add('active-btn');
            document.getElementById('line2').classList.remove('active-btn');
        
            document.getElementById('informations').classList.add('hidden');
            document.getElementById('compte').classList.remove('hidden');
    
        
        
        }
     
                
            </script>    
    
    
    
    
    
    
    
@endcomponent
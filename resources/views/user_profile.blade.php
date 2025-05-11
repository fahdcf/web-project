@php
    $layout = 'layout'; // default layout

    if (auth()->user()->role->isadmin) {
        $layout = 'components.admin_layout';
    } elseif (auth()->user()->role->ischef) {
        $layout = 'components.chef_layout';
    }
    else{
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
                    
                  <div id="line3">
                    <button onclick="togglebtnforsecurite()"><i class='bx bx-lock-alt'></i> sécurité</button>
                    <div id="line"></div>
                  </div>
        
        
                </section>
        
        
                
                <form action="{{ route('profile.edit', ['id' => auth()->user()->id]) }}" method="post">
                    @csrf
        
                <section id="compte">
                <div class="picture-container mt-5 d-flex align-items-center">
        
                    @if (Auth()->user()->user_details)
                    @if (Auth()->user()->user_details->profile_img!=null)
                    
    
                    <img style="height: 80px;width: 80px;object-fit:cover;border-radius:15%; border: 2px solid #1e0a6e;" src="{{asset('storage/' . Auth()->user()->user_details->profile_img)}}">
                    @else
                    <img style="height: 80px;width: 80px;object-fit:cover;border-radius:15%;  border: 2px solid #1e0a6e;" src="{{asset('storage/images/default_profile_img.png')}}">
                    
                    @endif
                    
                    
                    @else
                    <img style="height: 80px;width: 80px;object-fit:cover;border-radius:15%;  border: 2px solid #1e0a6e;" src="{{asset('storage/images/default_profile_img.png')}}">
                    
                    @endif
        
                    <div class="p-3">
                        <p style="color: rgb(29, 29, 29); font-weight:600">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</p>
                       <!-- Changer Button -->
        <button type="button" class="goodBtn mr-2" data-bs-toggle="modal" data-bs-target="#changerModal">Changer</button>
        
        <!-- Supprimer Button -->
        <button type="button" class="dangerBtn" data-bs-toggle="modal" data-bs-target="#supprimerModal">Supprimer</button>
        
                    </div>
                </div>
        
                <div>
                    <div class="row mt-3">
        
                <div class="col-md-6 col-lg-4 mb-3">
                    <label for="firstname" class="form-label">Prenom</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="{{auth()->user()->firstname}}">
                </div>
                                        
                <div class="col-md-6 col-lg-4 mb-3">
                    <label for="lastname" class="form-label">Nom</label>
                            <input type="text" id="lastname" name="lastname" class="form-control" value="{{auth()->user()->lastname}}">
                        </div>
        
                     
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="email" class="form-label">Email</label>
                                    <input type="text" id="email" name="email" class="form-control" value="{{auth()->user()->email}}">
                                </div>
                
        
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="departementFilter" class="form-label">Departement</label>
                         <p class="form-control">{{auth()->user()->departement}}</p>
                        </div>
        
                      
                
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="statusFilter" class="form-label">Status</label>
                            <p class="form-control">{{auth()->user()->user_details->status}}</p>
                        </div>
        
        
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label for="rowsPerPage" class="form-label">charge horaire minimale</label>
                            <p class="form-control">{{auth()->user()->user_details->min_hours}}</p>
                            
                        </div>
                         <div class="col-md-6 col-lg-4 mb-3">
                            <label for="rowsPerPage" class="form-label">charge horaire maximale</label>
                            <p class="form-control">{{auth()->user()->user_details->max_hours}}</p>
                            
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
                                            {{ optional(auth()->user()->role)->isadmin ? 'checked' : '' }} disabled>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1"
                                            {{ optional(auth()->user()->role)->iscoordonnateur ? 'checked' : '' }} disabled>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1"
                                            {{ optional(auth()->user()->role)->ischef ? 'checked' : '' }} disabled>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1"
                                            {{ optional(auth()->user()->role)->isprof ? 'checked' : '' }} disabled>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1"
                                            {{ optional(auth()->user()->role)->isvocataire ? 'checked' : '' }} disabled>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1"
                                            {{ optional(auth()->user()->role)->isstudent ? 'checked' : '' }} disabled>
                                    </td>
                                </tr>
                            </tbody>  
                        </table>
                    </div>
                </div>
            </div>
            
        </section>
        
     
            
        <section id="informations" class="hidden mt-5">
           
    
            <div>
                <div class="row mt-3">
    
            <div class="col-md-6 col-lg-4 mb-3">
                <label for="date" class="form-label">Date de Naissance</label>
                        <input type="date" id="date" name="date" class="form-control" value="{{auth()->user()->user_details->date_of_birth}}">
                    </div>
    
    
                    <div class="col-md-6 col-lg-4 mb-3">
                        <label for="adresse" class="form-label">Address</label>
                                <input type="text" id="adresse" name="adresse" class="form-control" value="{{auth()->user()->user_details->adresse}}" placeholder="Votre adress..">
                            </div>
            
                 
                            <div class="col-md-6 col-lg-4 mb-3">
                                <label for="tele" class="form-label">Telephone</label>
                                        <input type="number" id="tele" name="tele" class="form-control" value="{{auth()->user()->user_details->number}}" placeholder="numero de telephone..">
                                    </div>
                    
                         
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <label for="cin" class="form-label">CIN</label>
                                                <input type="text" id="cin" name="cin" class="form-control" value="{{auth()->user()->user_details->cin}}" placeholder="numero de carte nationale..">
                                            </div>
                            
                                            <div class="col-md-6 col-lg-4 mb-3">
                                               
                                                <span >Sexe:</span>
                                                <div class="sex-group d-flex gap-4 mt-1">
    
                                                    <label class="sex-label">
                                                      <input type="radio" name="sexe" value="male" class="sex-input" {{auth()->user()->user_details->sexe ==='male'? 'checked' : ''}} />
                                                      <span class="sex-circle"></span>
                                                      Homme
                                                    </label>
                                                  
                                                    <label class="sex-label">
                                                      <input type="radio" name="sexe" value="female" class="sex-input" {{auth()->user()->user_details->sexe ==='female'? 'checked' : ''}}/>
                                                      <span class="sex-circle"></span>
                                                      Femme
                                                    </label>
                                                  </div>
                                                </div>
                                 
                
            </div>
        </div>
    
    
        <div class="rounded border p-3" >
            <p style="color: #272727; font-weight: 600;"><i class="bi bi-info-square"></i> Details</p>
            <hr>
    
    
    <div class="pl-4">
    
    
                        
            <p ><strong>Role: </strong>{{Auth::user()->role_column}}</p>
            <p ><strong>Date de creation de compte: </strong>{{Auth::user()->created_at}}</p>
            <p ><strong>Date de mise a jour de compte: </strong>{{Auth::user()->updated_at}}</p>
    
    
    
        </div>
    </div>
    </section>
    
    <section id="sécurité" class="hidden mt-5">
        <h3 style="color: #3d3d3d ;" class="mb-5">Changer le mot de passe</h3>
    
        <div class="row mt-3 justify-content-center">
    
              
         <div class="col-md-8 mb-3">
            <label for="old_password" class="form-label">Mot de passe actuel:</label>
            <input  id="old_password"  type="password" name="old_password" class="form-control">
         </div>
    
          <div class="col-md-8 mb-3">
    
          <label for="new_password" class="form-label">Nouveau mot de passe:</label>
          <input id="new_password" class="form-control" type="password" name="password">
          
        </div>
    
          <div class="col-md-8  mb-3">
    
          <label for="password_confirmation" class="form-label">Confirmation du mot de passe:</label>
          <input id="password_confirmation" class="form-control" type="password" name="password_confirmation">
         </div>
       
        </div>
    
    </section>
    
        
            <div class="d-flex justify-content-end gap-3 mt-4">
                <button class="goodBtn" type="submit">Enregistrer</button>
                
                <button class="dangerBtn">Reset</button>
            </div>
            </form>
            </div>  
        
        
            <!-- modaaaals -->
        
            <!-- Modal for Changer (Upload Picture) -->
        <div class="modal fade" id="changerModal" tabindex="-1" aria-labelledby="changerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="changerModalLabel">Changer le Profil</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
        
                  <form action="{{url('/profile/modifier-image/'.auth()->user()->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
        
                    <div class="mb-3">
                      <label for="fileInput" class="form-label">Choisissez une nouvelle image</label>
                      <input class="form-control" type="file" id="fileInput" name="profile_img">
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Modal for Supprimer (Delete Picture Confirmation) -->
          <div class="modal fade" id="supprimerModal" tabindex="-1" aria-labelledby="supprimerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="supprimerModalLabel">Confirmer la suppression</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
        
                  <p>Êtes-vous sûr de vouloir supprimer cette image de profil ?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{url('/profile/modifier-image/'.auth()->user()->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                    @method('DELETE')
        
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                  <button type="submit" class="btn btn-danger">Supprimer</button>
              
                </form>
                </div>
              </div>
            </div>
          </div>
         </div>
        
        
        
        
        
         <script>
            function togglebtnforoldinfo(){
                document.getElementById('line1').classList.remove('active-btn');
                document.getElementById('line2').classList.add('active-btn');
                document.getElementById('line3').classList.remove('active-btn');
            
                document.getElementById('informations').classList.remove('hidden');
                document.getElementById('compte').classList.add('hidden');
                document.getElementById('sécurité').classList.add('hidden');
        
            
            }
            function togglebtnforcompte(){
                document.getElementById('line1').classList.add('active-btn');
                document.getElementById('line2').classList.remove('active-btn');
                document.getElementById('line3').classList.remove('active-btn');
            
                document.getElementById('informations').classList.add('hidden');
                document.getElementById('compte').classList.remove('hidden');
                document.getElementById('sécurité').classList.add('hidden');
        
            
            
            }
            
            function togglebtnforsecurite(){
                document.getElementById('line1').classList.remove('active-btn');
                document.getElementById('line2').classList.remove('active-btn');
                document.getElementById('line3').classList.add('active-btn');
            
                document.getElementById('informations').classList.add('hidden');
                document.getElementById('compte').classList.add('hidden');
                document.getElementById('sécurité').classList.remove('hidden');
        
            }
        
                    
                </script>    
        
        
@endcomponent
        
        
        
        

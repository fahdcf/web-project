<x-admin_layout>
  <div class="container-fluid p-0 pt-5">
    <div class="bg-white rounded p-4" style="box-shadow: 1px 1px 10px 2px #33333314;">
                        <h3 class="fw-bold mb-0" style="color:#3819b2;">Ajouter un Nouveau professeur</h3>
                        <p class="text-muted mt-2">Remplissez les champs ci-dessous pour créer un professeur</p>
                        <form action="{{ url('professeurs/add') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- professeur firstName -->
                            <div class="row mt-3">

                              <div class="col-md-6  mb-4">
                                <label style="color:#515151; font-weight: 700;" for="firstname" class="form-label fw-bold">Prenom</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prenom..">
                            </div>

                              <!-- professeur lastName -->
                              <div class="col-md-6  mb-4">
                                <label style="color:#515151; font-weight: 700;" for="lastname" class="form-label fw-bold">Nom</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom..">
                            </div>

                            <div class="col-md-6  mb-4">
                              <label style="color:#515151; font-weight: 700;" for="email" class="form-label fw-bold">Email</label>
                              <input type="text" class="form-control" id="eamil" name="email" placeholder="Email..">
                          </div>

                            <!-- professeur modepass -->
                            <div class="col-md-6  mb-4">
                              <label style="color:#515151; font-weight: 700;" for="password" class="form-label fw-bold">Mot de passe</label>
                               <input type="text" class="form-control" id="password" name="password" placeholder="Mot de passe">
                          </div>


                           <!-- professeur departement -->
                        
                        <div class="col-md-6  mb-4">
                          <label style="color:#515151; font-weight: 700;" for="status" class="form-label fw-bold">Status</label>
                          <select class="form-select" id="Depatement" name="departement">
                            <option value="">Sélectionner une Departement</option>
                            @foreach ($Departements as $Departement)
                                <option value="{{ $Departement->name }}">{{ $Departement->name }}</option>
                            @endforeach
                        </select>
                        </div>

  

                           <!-- professeur hours -->
                           <div class="col-md-6  mb-4">
                            <label style="color:#515151; font-weight: 700;" for="hours" class="form-label fw-bold">Charge horaire</label>
                             <input type="number" class="form-control" id="hours" name="hours" placeholder="charge horaire">
                        </div>

                          
                        
                        <!-- professeur status -->
                        
                        <div class="col-md-6  mb-4">
                          <label style="color:#515151; font-weight: 700;" for="status" class="form-label fw-bold">Status</label>
                          <select type="text" class="form-select" id="status" name="status" >
                            <option value="active">Active</option>
                            <option value="inactive">inactive</option>
                            
                          </select>
                        </div>


                        
                        <!-- professeur profile -->
                       <div class="col-md-6  mb-4">
                           <label style="color:#515151; font-weight: 700;" for="profile_img" class="form-label fw-bold">Photo de profile</label>
                           <input type="file" class="form-control " id="profile_img" name="profile_img">
                         </div>

                         
                          </div>

                   

                          <div class="py-2 pb-4">
                            <div class="accordion rounded" id="accordionFilters">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefilters" aria-expanded="false" aria-controls="collapsefilters">
                                            Plus des Informations (optionnel)
                                        </button>
                                    </h2>
                        
                                    <div id="collapsefilters" class="accordion-collapse collapse" data-bs-parent="#accordionFilters">
                                        <div class="accordion-body">

                         
                                              
                                              <div class="row mt-3">

                                                <div class="col-md-6 col-lg-4 mb-3">
                                                    <label style="color:#515151; font-weight: 700;" for="date" class="form-label">Date de Naissance</label>
                                                            <input type="date" id="date" name="date" class="form-control" >
                                                        </div>
                                        
                                        
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <label style="color:#515151; font-weight: 700;" for="adresse" class="form-label">Address</label>
                                                                    <input type="text" id="adresse" name="adresse" class="form-control"  placeholder="Votre adress..">
                                                                </div>
                                                
                                                     
                                                                <div class="col-md-6 col-lg-4 mb-3">
                                                                    <label style="color:#515151; font-weight: 700;" for="tele" class="form-label">Telephone</label>
                                                                            <input type="number" id="tele" name="tele" class="form-control"  placeholder="numero de telephone..">
                                                                        </div>
                                                        
                                                             
                                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                                            <label style="color:#515151; font-weight: 700;" for="cin" class="form-label">CIN</label>
                                                                                    <input type="text" id="cin" name="cin" class="form-control"  placeholder="numero de carte nationale..">
                                                                                </div>
                                                                
                                                                                <div class="col-md-6 col-lg-4 mb-3">
                                                                                   
                                                                                    <span  style="color:#515151; font-weight: 700;">Sexe:</span>
                                                                                    <div class="sex-group d-flex gap-4 mt-1">
                                        
                                                                                        <label class="sex-label">
                                                                                          <input type="radio" name="sexe" value="male" class="sex-input"  />
                                                                                          <span class="sex-circle"></span>
                                                                                          Homme
                                                                                        </label>
                                                                                      
                                                                                        <label class="sex-label">
                                                                                          <input type="radio" name="sexe" value="female" class="sex-input"/>
                                                                                          <span class="sex-circle"></span>
                                                                                          Femme
                                                                                        </label>
                                                                                      </div>
                                                                                    </div>
                                                                     
                                                    
                                                </div>
                                            
                                          </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                           
                        
                        


                    

                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit"
                                        class="btn text-white  px-4 py-2 fw-semibold shadow-sm"
                                        style="background-color: #4723d9;">
                                  + Ajouter Professor
                                </button>
                            </div>
                        </form>
          </div>
        </div>
        <style>
          


.accordion-button {
color: #333;
box-shadow: none;
transition: background-color 0.3s ease;
border-radius: 5px;
background-color: transparent;
}

.accordion-button:hover,
.accordion-button:focus {

box-shadow: none;
background-color: transparent;
color: #333;
}

.accordion-button:not(.collapsed) {
background-color: transparent;

box-shadow: none;
}



.accordion-body {

padding: 1rem;
font-size: 0.95rem;
color: #555;
}


        </style>
</x-admin_layout>

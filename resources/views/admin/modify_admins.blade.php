<x-admin_layout>
    <div class="container pt-4 ">
     
                        <h3 class="fw-bold mb-0" style="color: #124d96;">Modifier les informations de l'admin {{$admin->firstname}} {{$admin->lastname}}</h3>
                        <p class="text-muted mt-2">Remplissez les champs ci-dessous pour créer un admin</p>
                        <form action="{{ url('admins/modifier/' . $admin->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- admin firstName -->
                            <div class="mb-4">
                                <label style="color:#515151; font-weight: 700;" for="firstname" class="form-label fw-bold">Prenom</label>
                                <input type="text" class="form-control rounded-pill" id="firstname" name="firstname" value="{{$admin->firstname}}">
                            </div>

                              <!-- admin lastName -->
                              <div class="mb-4">
                                <label style="color:#515151; font-weight: 700;" for="lastname" class="form-label fw-bold">Nom</label>
                                <input type="text" class="form-control rounded-pill" id="lastname" name="lastname" value="{{$admin->lastname}}">
                            </div>
                              <!-- admin profile -->
                              <div class="mb-4">
                                <label style="color:#515151; font-weight: 700;" for="profile_img" class="form-label fw-bold">Photo de profile</label>
                                <input type="file" class="form-control rounded-pill" id="profile_img" name="profile_img">
                            </div>

                              <!-- admin email -->
                              <div class="mb-4">
                                <label style="color:#515151; font-weight: 700;" for="email" class="form-label fw-bold">Email</label>
                                <input type="text" class="form-control rounded-pill" id="eamil" name="email" value="{{$admin->email}}">
                            </div>

                              <!-- admin modepass -->
                            <div class="mb-4">
                                 <label style="color:#515151; font-weight: 700;" for="password" class="form-label fw-bold">Mot de passe</label>
                                 <input type="text" class="form-control rounded-pill" id="password" name="password" placeholder="Mot de passe">
                            </div>
        
                            <!-- admin status -->
                            <div class="mb-4">
                                <label style="color:#515151; font-weight: 700;" for="status" class="form-label fw-bold">Status</label>
                                <select type="text" class="form-control rounded-pill" id="status" name="status" >
                              
                                    @if ($admin->user_details)
                                        @if ($admin->user_details->status=="active")

                                        <option value="active">Active</option>
                                        <option value="inactive">inactive</option>
         
                                        
                                        @else
                                        <option value="inactive">inactive</option>
                                        <option value="active">active</option>
         

                                    @endif

                                    @else

                              <option value="active">Active</option>
                               <option value="inactive">inactive</option>
                                @endif
                                </select>
                            </div>



                    

                            <!-- Submit Button -->
                            <div class="text-end " style="margin-bottom: 70px;">
                                <button type="submit"
                                        class="btn text-white rounded-pill px-4 py-2 fw-semibold shadow-sm"
                                        style="background-color: #124d96;">
                                  Enregistrer
                                </button>
                            </div>
                        </form>
          
        </div>
</x-admin_layout>

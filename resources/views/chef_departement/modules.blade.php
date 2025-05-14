<x-chef_layout>
    <div class="container-fluid p-0 pt-5">
  
        <h1 style="color: #330bcf; font-weight: 500;">The list of Modules</h1>
    
        

    
  
  
    
      <!-- Overlay -->
      <div id="overlay" class="overlay">
        <div class="popup">
          <h5 style="color: #202020">Modifier la filière <span id="moduleName"></span></h5>
          <form id="popupForm" action="" method="POST">
            @csrf
            @method('PATCH')
            <input hidden type="text" id="module_id" name="module_id">
            <div class="mb-4">
              <label style="color:#515151; width: 100%; font-weight: 700; text-align: start;" for="name" class="mt-4 form-label fw-bold">Nom du filière</label>
              <input style="color:#202020" type="text" class="form-control rounded" id="name" name="name" placeholder="Ex: Informatique">
            </div>
           
          
            <div class="modal-footer">
              <button type="button" class="btn ml-1 btn-secondary btn-sm" onclick="closePopup()">Close</button>
              <button type="submit" class="btn ml-1 btn-success btn-sm">Update</button>
            </div>
          </form>
        </div>
      </div>
  
@foreach ($filieres as $filiere)
  
<div class="d-flex flex-column flex-md-row align-items-center justify-content-between mt-5">

  <h4 class=" m-0" >Les modules du filière {{$filiere->name}}:</h4>
  <button class="btn text-white m-0" style="background-color:#4723d9 ;">Ajouter un module pour ce filière</button>
</div>

<div class="row p-4">
  
  @php
  $modulesCount=0;
@endphp

              @foreach ($modules as $module)
@if ($module->filiere_id==$filiere->id)
  


 <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
  <div class="module-container  shadow-sm bg-white h-100 d-flex flex-column align-items-center p-3 text-center position-relative" style="border-radius: 10px;">

  

    <!-- Module Code Badge -->
    <span class="position-absolute top-0 end-0 text-white bg-primary px-3 py-1 " style="font-size: 0.8rem; font-weight: 600; border-bottom-left-radius:10px ;border-top-right-radius:10px;">
      {{ $module->code }}
    </span>

  
    <!-- Module Name -->
    <h5 class="fw-bold text-dark mb-4 mt-4">{{ $module->name }}</h5>

  
    <!-- Professor -->
    @if ($module->professor)
      <p class=" fw-semibold mb-3" style="vertical-align: middle ; color: #4723d9;"><i class="bi bi-person-circle me-1 "></i>{{ $module->professor->firstname }} {{ $module->professor->lastname }}</p>
    @else
      <p class="mb-3">
        <span class="badge bg-danger rounded-pill px-3 py-1">Non associé</span>
      </p>
    @endif

    <!-- Hours -->
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <div class="text-center">
        <span class="text-muted small d-block">Cours</span>
        <span class="badge bg-success rounded-pill px-3">{{ $module->cm_hours }}h</span>
      </div>
      <div class="text-center">
        <span class="text-muted small d-block">TP</span>
        <span class="badge bg-success rounded-pill px-3">{{ $module->tp_hours }}h</span>
      </div>
      <div class="text-center">
        <span class="text-muted small d-block">TD</span>
        <span class="badge bg-success rounded-pill px-3">{{ $module->td_hours }}h</span>
      </div>
    </div>

     <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
      <div class="text-center">
        <span class="text-muted small d-block">Semestre</span>
        <span class="badge bg-primary rounded-pill px-3">
          @if ( $module->semester==1)
          1ere Semsetre
          @else
          2eme Semestre
        @endif
      
      </span>
      </div>
      <div class="text-center">
        <span class="text-muted small d-block">Status</span>
        <span class="badge bg-primary rounded-pill px-3">{{ $module->status }}</span>
      </div>
    
    </div>


    <div class="buttons-container mt-4 d-flex gap-2"><button class="btn" style="border: 1px solid #4723d9; color: #4723d9;">Modifier</button><button class="btn btn-danger bg-white" style=" color:rgb(228, 96, 56); border: 1px solid rgb(228, 96, 56);">Supprimer</button></div>
  </div>
</div>
@php
  $modulesCount++;
@endphp

@endif
@endforeach
@if ($modulesCount==0)
<h5>Il n'ya pas des modules pour ce filière</h5>
  
@endif

</div>
@endforeach



      </div>
   
    
      <style>

.module-container{
  transition: all 0.3s;
}
        .module-container:hover{

          outline: 1px solid #4723d9;
          transform:translateY(5px) ;

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
        function showPopup(moduleId, moduleName) {
          document.getElementById('moduleName').innerText = moduleName;
          document.getElementById('module_id').value = moduleId;
          document.getElementById("name").value = moduleName;
          document.getElementById('popupForm').action = "{{ url('/chef/modules/modifier') }}/" + moduleId;
          document.getElementById("overlay").style.display = "flex";
        }
    
        function closePopup() {
          document.getElementById("overlay").style.display = "none";
        }
      </script>
    </x-chef_layout>
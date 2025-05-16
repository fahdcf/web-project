<x-chef_layout>
    <div class="container-fluid p-0 pt-5">
  
        <h1 style="color: #330bcf; font-weight: 500;">La liste des Modules</h1>
    
        

    
  
  
    
    
  
@foreach ($filieres as $filiere)
  

  <h4 class=" m-0" >Les modules du filière {{$filiere->name}}:</h4>
 

<div class="row p-4">
  
  @php
  $modulesCount=0;
@endphp

              @foreach ($modules as $module)
@if ($module->filiere_id==$filiere->id)
  

 <!-- affecter popup -->
<div id="affecterpopupfor{{$module->id}}" class="overlay">
  <div class="popup bg-white rounded p-4 shadow" style="max-width: 500px; width: 90%; margin: auto; position: relative;">
<form action="{{url('chef/modules_vacantes/affecter/'. $module->id)}}" method="post">
  @csrf
    <h5 class="text-primary fw-bold mb-3">Affecter le module <span id="affectermoduleName{{$module->id}}">{{ $module->name }}</span> a un professeur</h5>
    

   <!-- Select Professor -->
                            <div class="mb-4 mt-5 d-flex flex-column align-items-center">
                                <label style="color:#515151; font-weight: 700; width:100%;" for="professor" class="form-label fw-bold text-start pb-1">Professeurs</label>
                                <select class="form-select py-2 rounded" id="professor" name="prof_id" >
                                    <option value="">-- Sélectionner un professeur --</option>
                                    @foreach ($professors as $professor)
                                        <option value="{{ $professor->id }}">{{ $professor->lastname }} {{ $professor->firstname }}</option>
                                    @endforeach
                                </select>
                            </div>


    <!-- Footer -->
    <div class="text-end mt-4">
      
      <button type="button" class="btn btn-secondary btn-sm" onclick="closePopupaffecter({{$module->id}})">Annuler</button>
      <button type="submit" class="btn btn-primary btn-sm" >Affecter</button>
    </div>
    </form>
  </div>
</div>




  <!--details popup -->
<div id="popupfor{{$module->id}}" class="overlay">
  <div class="popup bg-white rounded p-4 shadow" style="max-width: 600px; width: 90%; margin: auto; position: relative;">

    <!-- Title -->
    <h5 class="text-primary fw-bold mb-3">Détails du module</h5>
    
    <!-- Module Name -->
    <p class="text-muted mb-4"><i class="bi bi-book me-2"></i><span id="moduleName{{$module->id}}">{{ $module->name }}</span></p>

    <!-- Info Table -->
    <div class="row gy-3">
      <div class="col-12">
        <strong>ID du module:</strong> {{ $module->id }}
      </div>

      @if($module->description)
      <div class="col-12">
        <strong>Description:</strong> {{ $module->description }}
      </div>
      @endif

      @if($module->responsable)
      <div class="col-12">
        <strong>Responsable:</strong> {{ $module->responsable->firstname }} {{ $module->responsable->lastname }}
      </div>
      @endif

      <div class="col-6">
        <strong>Évaluation:</strong> {{ $module->evaluation }}
      </div>

      <div class="col-6">
        <strong>Crédit:</strong> {{ $module->credit }}
      </div>

      <div class="col-6">
        <strong>Type:</strong> {{ $module->type }}
      </div>

      <div class="col-6">
        <strong>Date de création:</strong> {{ $module->created_at->format('d/m/Y') }}
      </div>
    </div>

    <!-- Footer -->
    <div class="text-end mt-4">
      <button type="button" class="btn btn-secondary btn-sm" onclick="closePopup({{$module->id}})">Fermer</button>
    </div>
  </div>
</div>


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


    <div class="buttons-container mt-4 d-flex gap-2"><button class="btn" style="border: 1px solid #4723d9; color: #4723d9;" onclick="showPopupaffecter({{$module->id}}, '{{$module->name}}')">Affecter</button><button class="btn btn-success bg-white" style=" color:#18a16f; border: 1px solid #18a16f;" onclick="showPopup({{$module->id}}, '{{$module->name}}')">Voire plus</button></div>
  </div>
</div>
@php
  $modulesCount++;
@endphp

@endif
@endforeach
@if ($modulesCount==0)
<h5 class="text-center">Il n'ya pas des modules pour ce filière</h5>
  
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
          document.getElementById('moduleName' + moduleId).innerText = moduleName;
          document.getElementById("popupfor" + moduleId).style.display = "flex";
        }
    
        function closePopup(moduleId) {
          document.getElementById("popupfor" + moduleId).style.display = "none";
        }

         function showPopupaffecter(moduleId, moduleName) {
          document.getElementById('affectermoduleName' + moduleId).innerText = moduleName;
          document.getElementById("affecterpopupfor" + moduleId).style.display = "flex";
        }
    
        function closePopupaffecter(moduleId) {
          document.getElementById("affecterpopupfor" + moduleId).style.display = "none";
        }
      </script>
    </x-chef_layout>
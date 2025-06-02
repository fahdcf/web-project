<x-chef_layout>

    
  
  <style>
    * {
    box-sizing: border-box;
  }

.row div{
  background: none;
}

  .main-section .welcome{
    border-radius: 15px;
    background-color: #4723d9;
    color: white;
    padding: 0;
    box-shadow: 0px 3px 15px 1px #3838381d;
    background-image: url('{{ asset('storage/images/adminavatar.png') }}');
    background-repeat: no-repeat;
    background-position: right center;
    background-size: 150px auto;
    padding: 15px;
    width: 100%; /* or your preferred width */
  }

.welcome, .tasks{
   border-radius: 15px;
    background-color: white;
    padding: 15px;
    box-shadow: 0px 3px 15px 1px #3838381d;
    
}

.tasks{
  padding: 7px;
   border-radius: 5px;
   font-size: 15px;
   height: auto;
   border-top-left-radius: 15px;
   border-top-right-radius: 15px;
   box-shadow: none;
}
.tasks .task-desc{
  text-wrap: wrap;

}
.tasks .task-time{
  font-size: 12px;
  color:#8a8a8a; 

}

.btn{
  background-color: #e1ecff;
color: #03346e;
font-weight: 600;
font-size: 12px;
padding: 5px;
border-radius: 3px;
width: 100%;
}


.buttons-wrapper button{
  border-radius: 5px;
  padding: 8px 10px;
  font-weight: 500;
  text-wrap: nowrap;




}
.buttons-wrapper a{
  color: #4723D9;
}
.buttons-wrapper a:hover{
  text-decoration: none;
}
.addbtn{
  background-color: white!important;
  color:#4723d9;
  border: none;
  
}



.seebtn{

  background:none;
  color:#ffffff;
  border: 1px solid white;

}
.tasks-header{
  padding: 10px;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;

}
.tasks-header button{
  border: none;
  background: none;
  color: white;
  font-size: 20px;
  padding: 0 8px;

  
}

.tasks-header button:hover{
  background-color:#5029ef;
}

.task-item{
  border-bottom:1px solid #e8e8e8d3;
  color:#252525;
}
.task-item button{
  border: none;
  background: none;

}

#task-input{
  border-radius: 15px !important;

}

#task-add{
    border: 1px solid #1777ec;
    border-radius: 7px;
    padding: 12px;
  }


  
  .numbers-card{
    border-radius:15px;
    box-shadow: 0px 3px 15px 1px #3838381d;

  }
  .numbers-card img{
    height: 80px;
    width: 80px;
    border-radius: 50%;

  }
  .numbers-card .title{
    color: #252525;

  }
  .numbers-card .num{
    color:#252525;
    font-size: 14px;
  }

  .numbers-card .seemore{
    border: none;
    background: none;
    font-size: 14px;
    color: #4723d9;

  }

  @media (max-width:900px) {
  .buttons-wrapper button{
    font-size: small;
  }
  
}

@media (max-width:1400px) {
  .numbers-card {
    gap:8px !important;
  }
 
    
    .numbers-card img{
      height: 50px;
      width: 50px;
      border-radius: 50%;
  
    }
    .numbers-card .title{
      color: #252525;
      font-size: 13px;
  
    }
    .numbers-card .num{
      color:#252525;
      font-size: 14px;
    }
  
    .numbers-card .seemore{
      border: none;
      background: none;
      font-size: 11px;
      color: #4723d9;
  
    }
      
    }

@media (max-width:800px) {
    
    .numbers-card img{
      height: 60px;
      width: 60px;
      border-radius: 50%;
  
    }
    .numbers-card .title{
      color: #252525;
      font-size: 14px;
  
    }
    .numbers-card .num{
      color:#252525;
      font-size: 14px;
    }
  
    .numbers-card .seemore{
      border: none;
      background: none;
      font-size: 12px;
      color: #4723d9;
  
    }
      
    }

    .shart-container{
      box-shadow: 0px 3px 15px 1px #3838381d;
      border-radius: 15px;

    }

    .history{
  padding: 7px;
   border-radius: 5px;
   font-size: 15px;
   height: auto;
   border-top-left-radius: 15px;
   border-top-right-radius: 15px;
   box-shadow: none;
}

    .history-header{
  padding: 10px;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;

}



.history-item{
  border-bottom:1px solid #e8e8e8d3;
  color:#252525;
}
.history-item button{
  border: none;
  background: none;

}


.history .history-desc{
  text-wrap: wrap;

}
.history .history-time{
  font-size: 12px;
  color:#8a8a8a; 

}




.logs{
  padding: 7px;
   border-radius: 5px;
   font-size: 15px;
   height: auto;
   border-top-left-radius: 15px;
   border-top-right-radius: 15px;
   box-shadow: none;
}

.logs-header{
  padding: 10px;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;

}



.logs-item{
  border-bottom:1px solid #e8e8e8d3;
  color:#252525;
}
.logs-item button{
  border: none;
  background: none;

}


.logs .logs-desc{
  text-wrap: wrap;

}
.logs .logs-time{
  font-size: 12px;
  color:#8a8a8a; 

}

/* Connections History Container */
.connections-history-container {
    background: #FFFFFF;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
}

/* Header Section */
.connections-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 24px;
    background-color: #4723D9 !important;
    color: white;
}

.connections-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #FFFFFF;
}

.view-all a {
    color: rgba(255, 255, 255, 0.9);
    font-size: 14px;
    text-decoration: none;
    transition: color 0.2s;
}

.view-all a:hover {
    color: white;
    text-decoration: underline;
}

/* Connection Items */
.connections-list {
    padding: 10px 16px;
    background-color: #ffffff !important;

}


.connection-item {
  background-color: white !important;
    padding: 16px 15px !important;
    border-bottom: 1px solid #F0F0F0;
    transition: background-color 0.2s;
    
}

.connection-item:last-child {
    border-bottom: none;
}

.connection-item:hover {
    background-color:#f9f8ff !important;
}

/* Profile Section */
.connection-profile {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
}

.profile-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 12px;
    border: 2px solid #F0F0F0;
}

.profile-info {
    display: flex;
    flex-direction: column;
}

.profile-name {
    font-weight: 600;
    color: #2D3748;
    text-decoration: none;
    font-size: 14px;
    margin-bottom: 2px;
}

.profile-name:hover {
    text-decoration: underline;
    color: #4723D9;
}

.connection-time {
    font-size: 12px;
    color: #718096;
}

/* Hours Progress Section */
.hours-progress {
    margin-top: 12px;
}

.hours-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
    font-size: 12px;
}

.current-hours {
    font-weight: 600;
    color: #2D3748;
}

.hours-range {
    color: #718096;
}

.progress-track {
    position: relative;
    height: 8px;
    background-color: #f4f5f6 !important;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: inset 3px 2px 5px 1px #25252512 
  
  }

.progress-bar {
    height: 100%;
    border-radius: 4px;
    transition: width 0.5s ease;
}

.min-marker {
    position: absolute;
    top: 0;
    width: 2px;
    height: 100%;
    transform: translateX(-50%);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .connections-header {
        padding: 12px 16px;
    }
    
    .connection-item {
        padding: 12px 4px;
    }
}




/* Module Requests Container */
.module-requests-container {
    background: #ffffff !important;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
     border-radius: 15px !important;

}

/* Header Section */
.requests-header {
      border-top-left-radius: 15px !important;
    border-top-right-radius: 15px !important;


    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background-color:#4723D9 !important;
    border-bottom: 1px solid #e9ecef;
}

.requests-header h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #ffffff;
}

.requests-count {
    font-size: 13px;
    color: #edeff0;
    font-weight: 500;
}


/* Empty State */
.empty-state {
    padding: 24px 16px;
    text-align: center;
    color: #adb5bd;
}

.empty-state svg {
    margin-bottom: 12px;
}

.empty-state p {
    margin: 0;
    font-size: 14px;
}

/* Request Cards */
.requests-list {
    padding: 8px;
}

.request-card {
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 8px;
    transition: all 0.2s ease;
}


.pen-dropdown{
  font-size: 15px;
  color: #4723d9;
  padding: 5px;
  border-radius: 10px;
  transition: all 0.3s;
  cursor: pointer;
}

.pen-dropdown:hover{
  font-size: 15px;
  background-color: #4723d9;
  color: white;
}
.request-card:hover {
    border-color: #dee2e6;
    background-color: #f8f9fa;
}

/* Request Main Content */
.request-main {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.professor-info {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
}

.avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    overflow: hidden;
    background-color: #f1f3f5;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    font-size: 13px;
    font-weight: 600;
    color: #495057;
}

.professor-details {
    flex: 1;
    min-width: 0;
}

.professor-details h4 {
    margin: 0;
    font-size: 14px;
    color: #2d3748;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.request-meta {
    display: flex;
    gap: 8px;
    margin-top: 2px;
}

.module-name {
    font-size: 12px;
    color: #495057;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 180px;
}

.request-date {
    font-size: 11px;
    color: #868e96;
}

/* Request Status */
.request-status {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    font-weight: 500;
    padding: 4px 8px;
    border-radius: 12px;
    margin-left: 8px;
}

.request-status.pending {
    background: #fff3bf;
    color: #e67700;
}

.request-status.approved {
    background: #d3f9d8;
    color: #2b8a3e;
}

.request-status.rejected {
    background: #ffd8d8;
    color: #c92a2a;
}

/* Request Description */
.request-description {
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px dashed #e9ecef;
}

.request-description p {
    margin: 0;
    font-size: 13px;
    color: #495057;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Request ID */
.request-id {
    margin-top: 8px;
    font-size: 11px;
    color: #868e96;
    text-align: right;
}

/* Responsive Design */
@media (max-width: 768px) {
    .request-meta {
        flex-direction: column;
        gap: 2px;
    }
    
    .module-name {
        max-width: 140px;
    }
}

  </style>



    <div class="container-fluid p-0 d-flex flex-column " >

   

      <div class="page-wrapper w-100 row m-0" >

      
      <section class="main-section col-12 col-md-8 col-lg-9 p-0 pr-md-4"  >

        <div class="welcome p-4 ">

          <div class="d-flex flex-column justify-content-between col-8">
          <h3 style="font-weight: 500; padding-bottom: 10px;">Welcome <strong>{{auth()->user()->firstname . " " . auth()->user()->lastname}}</strong> to the Dashboard</h3>
          <p style="font-size: 14px;">Vous avez {{ count($module_requests) }} demandes de professeurs.</p>  
          
          <div class="buttons-wrapper d-flex  gap-3"><button class="addbtn"> <a href="{{url('/chef/professeurs')}}"> Liste des professeurs</a></button> <button class="seebtn"><a href="{{url('/chef/demandes')}}" style="color: white;"> Les demandes</a></button> </div>

          </div>


       </div>

       <div class="numbers row w-100 m-0 mt-4 ">
      
      <div class="p-2 col-6 col-lg-3">
        
        <div class="numbers-card  bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
          <img  src="{{ asset('storage/images/1.png') }}" alt="">

          <div class="d-flex flex-column justify-content-start align-items-start">
            <p class="title">Etudiants</p>
            <p class="num">Total: <strong>{{$studentCount}}</strong></p>
            <button class="seemore">> Voir Plus</button>

          </div>

        </div>
        
      </div>
      
       
      <div class="p-2 col-6 col-lg-3">
        
        <div class="numbers-card bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
          <img  src="{{ asset('storage/images/2.png') }}" alt="">

          <div class="d-flex flex-column justify-content-start align-items-start">
            <p class="title">Professeurs</p>
            <p class="num">Total: <strong>27</strong></p>
            <button class="seemore">> Voir Plus</button>

          </div>

        </div>
        
      </div>
      
      
      <div class="p-2 col-6 col-lg-3">
        
        <div class="numbers-card bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
            <img  src="{{ asset('storage/images/3.png') }}" alt="">

          <div class="d-flex flex-column justify-content-start align-items-start">
            <p class="title">departements</p>
            <p class="num">Total: <strong>4</strong></p>
            <button class="seemore">> Voir Plus</button>

          </div>

        </div>
        
      </div>

       
      <div class="p-2 col-6 col-lg-3">
        
        <div class="numbers-card bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
           <img  src="{{ asset('storage/images/4.png') }}" alt="">

          <div class="d-flex flex-column justify-content-start align-items-start">
            <p class="title">Filieres</p>
            <p class="num">Total: <strong>7</strong></p>
            <button class="seemore">> Voir Plus</button>

          </div>

        </div>
        
      </div>
      

        

       </div>

       <div class="row m-0 mt-3">
            <!-- Doughnut Chart -->
            <div class="col-12 col-lg-6 mb-4 p-2">
              <div class=" shart-container p-3 bg-white d-flex flex-column justify-content-start align-items-center" style="height: 350px;">
                
                <h6 class="pt-1 pb-4 m-0 text-center" style="color: #252525">Répartition des Etudiants</h6>
                <canvas id="genderChart" style="width: 90%; max-height: 250px;"></canvas>
              </div>
            </div>
      
   
        <!-- Bar Chart -->
        <div class="col-12 col-lg-6 mb-4 p-2">
          <div class="shart-container p-3 bg-white d-flex flex-column justify-content-start align-items-center" style="height: 350px;">
            <h6 class="pt-1 pb-4  text-center" style="color: #252525">Nombre de connexions par jour</h6>
            <canvas id="loginChart" style="width: 100%; height: 100%;"></canvas>
          </div>
        </div>
      </div>
      <div class="">
        <div class="history p-0 " style="background-color:white ">

          <div style=" border:none; background-color:#4723d9; " class="history-header d-flex justify-content-between align-items-center ">
              <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin:0">History des actions:</p>

          </div>

          <div class="history-content px-3 px-md-4 pt-0 ">


    

            @foreach ($chefHistory as $History)
            <div class="history-item mt-3 d-flex justify-content-between align-items-center pb-3">
            <div class="d-flex gap-3 align-items-center">

              @switch($History['action_type'])

                @case('affecter')
                
                <i style="color: #21b524" class="bi bi-plus-circle-fill"></i>
                  @break
              
                  @case('retirer')
                
                  <i style="color: #ee5951" class="bi bi-trash3-fill"></i>
                    @break

                    @case('modifier')
                
                    <i style="color:#5e3de3" class="bi bi-pencil-square"></i>
                      @break

                @default
                <i style="color:#ff914d" class="bi bi-check-circle-fill"> </i>
                  
              @endswitch
              
              
              

              <div>

                <p class="history-desc m-0"> {{ $History['description']}}</p>
                <p class="history-time m-0"> {{$History->created_at->diffForHumans()}}</p>
                
              </div>

              </div>

              <div class="dropdown">

                <button data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="Dropdown" data-bs-display="static" style="width: 250px">
                
                 <li >
                    <p class="m-0 py-1 pl-3"> Date : <strong>{{$History->created_at}}</strong></p>                   
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  
                   <li>
                    <p class="m-0 py-1 pl-3"> Admin : <strong>{{$History->user->firstname}} {{$History->user->lastname}}</strong></p>                   
                  </li>
                  <li><hr class="dropdown-divider"></li>

                    <li>
                    <p class="m-0 py-1 pl-3"> Table : <strong>{{$History->target_table}}</strong></p>                   
                  </li>
                  
                 
              </ul>



            </div>

            </div>
            @endforeach

            <a href="{{url('/chef/actions')}}" class="text-center"><p class="pt-2 m-0">Voir tous</p></a>
            
          </div>
        </div>

      </div>

      </section>

      <section class="side-section col-12 col-md-4 col-lg-3  p-0 pt-4 p-md-0">
   
        
       <div class="connections-history-container">
    <div class="connections-header">
        <h3>Charge horaire</h3>
        <div class="view-all">
            <a href="#">View All</a>
        </div>
    </div>
    
    <div class="connections-list">
        @foreach ($professorsMin as $prof)
            @if ($prof->hours > $prof->user_details->min_hours || $prof->hours < $prof->user_details->min_hours)
            <div class="connection-item">
                <div class="connection-profile">
                    <a href="{{url('chef/professeur_profile/' .$prof->id)}}">
                        @if ($prof->user_details && $prof->user_details->profile_img != null)
                            <img class="profile-img" src="{{asset('storage/' . $prof->user_details->profile_img)}}" alt="{{$prof->firstname}} {{$prof->lastname}}">
                        @else
                            <img class="profile-img" src="{{asset('storage/images/default_profile_img.png')}}" alt="Default profile">
                        @endif
                    </a>
                    
                    <div class="profile-info">
                        <a href="{{url('profile/' .$prof->id)}}" class="profile-name">{{$prof->firstname}} {{$prof->lastname}}</a>
                        <span class="connection-time">{{$prof->created_at->diffForHumans()}}</span>
                    </div>
                </div>
                
                @php
                    $current_hours = $prof->hours ?? 0;
                    $min_hours = $prof->user_details->min_hours ?? 0;
                    $max_hours = $prof->user_details->max_hours ?? 0;
                    $progress_percentage = min(100, ($current_hours / max(1, $max_hours)) * 100);
                    $progress_color = ($current_hours < $min_hours || $current_hours > $max_hours) ? '#EA5455' : '#28C76F';
                    $min_marker_pos = ($min_hours / max(1, $max_hours)) * 100;
                @endphp
                
                <div class="hours-progress">
                    <div class="hours-info">
                        <span class="current-hours">{{ $current_hours }}h</span>
                        <span class="hours-range">{{ $min_hours }}h - {{ $max_hours }}h</span>
                    </div>
                    
                    <div class="progress-track">
                        <div class="progress-bar" style="width: {{ $progress_percentage }}%; background-color: {{ $progress_color }};"></div>
                        <div class="min-marker" style="left: {{ $min_marker_pos }}%; background-color:{{$min_marker_pos<$progress_percentage ? "rgba(79, 231, 137, 0.985)": "rgba(210, 77, 53, 0.912)"}}"></div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>



<div class="module-requests-container mt-4">
    <div class="requests-header">
        <h3>Module Requests</h3>
        <div class="requests-count">{{ count($module_requests) }} requests</div>
    </div>

    @if($module_requests->isEmpty())
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <p>No module requests found</p>
        </div>
    @else


        <div class="requests-list">

            @foreach($module_requests as $module_request)
              
            
                <div class="request-card">
                    <div class="request-main">
                        <div class="professor-info">
                           
                            <div class="professor-details">
                                <h4>{{ $module_request->prof->firstname ?? 'Unknown' }} {{ $module_request->prof->lastname ?? 'Professor' }}</h4>
                                <div class="request-meta">
                                    <span class="module-name">{{ $module_request->target->name ?? 'Not specified' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="request-status {{ $module_request->status ?? 'pending' }}">
                            @if($module_request->status == 'pending')
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                Pending
                            @elseif($module_request->status == 'rejected')
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                                Rejected
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                                Approved
                            @endif
                        </div>
                    </div>
                    
                    @if($module_request->description)
                    <div class="request-description">
                        <p>{{ $module_request->description }}</p>

                    </div>
                    @endif
                    
                    <div class="request-id d-flex justify-content-between">  
                      
                      <span class="request-date">{{ $module_request->created_at->diffForHumans() ?? 'N/A' }}</span>
              
                      <div class="dropdown">
                        <span class="pen-dropdown dropdown-toggle" id="penDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-pen"></i>
                        </span>
                        <ul class="dropdown-menu" aria-labelledby="penDropdown">
                            <li>

                              <form action="{{ url('/chef/demandes/' . $module_request['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="dropdown-item text-danger" href="#"><i class="bi bi-x-circle-fill me-2"></i>Refuser</button>
                              </form>
                            
                            </li>
                            <li><hr class="dropdown-divider"></li>


                            <li>
                              <form action="{{ url('/chef/demandes/' . $module_request['id']) }}" method="POST">
                                  @csrf
                                  @method('PATCH')
                              <button class="dropdown-item text-success"><i class="bi bi-check-circle-fill me-2"></i>Accepter</button></li>
                              </form>
                            </ul>
                    </div>
                    
                </div>                  
  
  
  </div>
  @endforeach
  <div class="text-center"><a href="{{url('chef/demandes')}}" >Voir tous</a></div>
      </div>
      @endif
    </div>

  





     <div class="tasks-container overflow-hidden shadow-sm mt-4 bg-white" style="border-radius: 15px !important" >

    <div class="tasks-header d-flex justify-content-between align-items-center px-3 py-2" style="background-color: #4723d9;">
        <p class="text-white m-0 fw-semibold small">Your tasks:</p>
        <button id="task-add-button" class="btn btn-sm btn-light rounded-circle p-0 d-flex align-items-center justify-content-center" 
                style="width:24px;height:24px;" onclick="addtask()">+</button>
    </div>

    <div class="task-content p-3 p-md-4">
        <!-- Add Task Form (hidden by default) -->
        <div id="task-add" class="mb-3" style="display: none">
            <form action="{{url('/addtask')}}" method="post" class="d-flex gap-2">
                @csrf
                <input id="task-input" name="task" type="text" 
                       class="  flex-grow-1" 
                       placeholder="Ajouter une tâche...">
                <button type="submit " class="btn btn-sm " style="width:40px">+</button>
            </form>
        </div>

        <!-- Task List -->
        @if(count($tasks) > 0)
            @foreach ($tasks as $task)
            <div class="task-item d-flex justify-content-between align-items-center py-3 px-2 mb-2 bg-light" style="border-radius:15px !important">
                <div class="d-flex gap-3 align-items-center">
                    @if ($task['isdone'])
                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                    @else
                    <i class="bi bi-clock-fill text-warning fs-5"></i>
                    @endif

                    <div>
                        <p class="task-desc m-0 @if($task['isdone']) text-decoration-line-through text-muted @endif">
                            {{ $task['description']}}
                        </p>
                        <p class="task-time m-0 small text-muted">
                            {{$task->created_at->diffForHumans()}}
                        </p>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn btn-sm btn-link text-secondary p-0" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm">
                        @if ($task->isdone)
                        <li>
                            <form action="{{url("mark-task-aspending/". $task->id)}}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item py-2">
                                    <i class="bi bi-clock me-2"></i>Marquer en attente
                                </button>
                            </form>
                        </li>
                        @else
                        <li>
                            <form action="{{url("mark-task-asdone/". $task->id)}}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item py-2">
                                    <i class="bi bi-check-circle me-2"></i>Marquer comme fait
                                </button>
                            </form>
                        </li>
                        @endif
                        <li><hr class="dropdown-divider m-0"></li>
                        <li>
                            <form action="{{url("delete-task/". $task->id)}}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="bi bi-trash me-2"></i>Supprimer
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            @endforeach

            <div class="text-center mt-2">
                <a href="#" class="text-primary text-decoration-none small">Voir tous</a>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-clipboard2-check fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">Aucune tâche pour le moment</p>
                <small class="text-muted">Cliquez sur "+" pour ajouter une tâche</small>
            </div>
        @endif
    </div>
</div>



      </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

function getShadedColors(data) {
  const max = Math.max(...data);
  const min = Math.min(...data);
  return data.map(value => {
    // Scale darkness from 20% (dark) to 70% (light)
    const lightness = 70 - ((value - min) / (max - min)) * 50;
    return `hsl(255, 100%, ${lightness}%)`; // Purple hue
  });
}

  // Doughnut Chart
  const genderCtx = document.getElementById('genderChart').getContext('2d');
  new Chart(genderCtx, {
    type: 'doughnut',
    data: {
      labels: ['Filles', 'Garçons'],
      datasets: [{
        data: [55, 45],
        backgroundColor: ['#a48de8', '#4723d9'],
        borderWidth: 0
      }]
    },
    options: {
      cutout: '60%',
      plugins: {
        legend: {
          position: 'bottom',
      labels: {
        usePointStyle: true,
        pointStyle: 'circle',
        boxWidth: 10,   // smaller size
        padding: 15,
      }
    },
        tooltip: {
          callbacks: {
            label: function (context) {
              const label = context.label || '';
              const value = context.parsed;
              const total = context.dataset.data.reduce((a, b) => a + b, 0);
              const percentage = ((value / total) * 100).toFixed(1);
              return `${label}: ${value} (${percentage}%)`;
            }
          }
        }
      }
    }
  });

    const values = @json($loginCounts);
    console.log(values);

  const loginCtx = document.getElementById('loginChart').getContext('2d');
  new Chart(loginCtx, {
    type: 'line',
    data: {
      labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
      datasets: [{
        label: 'Nombre de connexions',
        data: values,
        fill: true,
        backgroundColor: 'rgba(71,35,217, 0.1)',
        borderColor: '#4723d9',
        pointBackgroundColor: 'rgba(71,35,170, 1)',
        pointBorderColor: '#fff',
        tension: 0.4, // smooth curve
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 5
          },
          title: {
            display: true,
            text: 'Connexions'
          },
          grid: {
            display: true,
            drawBorder: false,
            color: 'rgba(0,0,0,0.06)'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Jours de la semaine'
          },
          grid: {
            display: false
          }
        }
      },
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });


      function addtask(){
        const taskaddButton=document.getElementById('task-add-button');
        const taskadd=document.getElementById('task-add');

      if(taskaddButton.innerHTML=="x"){
          taskadd.style.display="none";
          taskaddButton.innerHTML="+";

      }
      else{
        taskaddButton.innerHTML="x";
        taskadd.style.display="block";
        document.getElementById('task-input').focus();
      }

      }
        
      </script>
      
</x-chef_layout>
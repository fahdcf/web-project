<x-admin_layout>
  
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
  color: #4723d9
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
  outline: none;
  font-size: 20px;
  padding: 0 8px;

  
}

.tasks-header button:hover{
  background-color:#5029ef;
  outline: none;
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


  </style>



    <div class="container-fluid p-0 pt-5 d-flex flex-column " >

   

      <div class="page-wrapper w-100 row m-0" >

      
      <section class="main-section col-12 col-md-8 col-lg-9 p-0 pr-md-4"  >

        <div class="welcome p-4 ">

          <div class="d-flex flex-column justify-content-between col-8">
          <h3 style="font-weight: 500; padding-bottom: 10px;">Bienvenue <strong>{{auth()->user()->firstname . " " . auth()->user()->lastname}}</strong> sur le tableau de bord</h3>
          <p style="font-size: 14px;"> {{ count($users_logs) }} professeurs connectés aujourd'hui.</p>  
          
          <div class="buttons-wrapper d-flex  gap-3"><button class="addbtn"><a href="{{url('professeurs')}}">gérer les professeurs</a></button> <button class="seebtn"><a href="{{url('filieres')}}" style="color: white">gérer les Filiéres</a></button> </div>

          </div>


       </div>

       <div class="numbers row w-100 m-0 mt-4 ">
      
      <div class="p-2 col-6 col-lg-3">
        
        <div class="numbers-card  bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
          <img  src="{{ asset('storage/images/1.png') }}" alt="">

          <div class="d-flex flex-column justify-content-start align-items-start">
            <p class="title">Etudiants</p>
            <p class="num">Total: <strong>{{$studentCount}}</strong></p>
            <a class="seemore" href="{{url('etudiants')}}"> Voir Plus</a>

          </div>

        </div>
        
      </div>
      
       
      <div class="p-2 col-6 col-lg-3">
        
        <div class="numbers-card bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
          <img  src="{{ asset('storage/images/2.png') }}" alt="">

          <div class="d-flex flex-column justify-content-start align-items-start">
            <p class="title">Professeurs</p>
            <p class="num">Total: <strong>27</strong></p>
            <a class="seemore" href="{{url('professeurs')}}"> Voir Plus</a>

          </div>

        </div>
        
      </div>
      
      
      <div class="p-2 col-6 col-lg-3">
        
        <div class="numbers-card bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
            <img  src="{{ asset('storage/images/3.png') }}" alt="">

          <div class="d-flex flex-column justify-content-start align-items-start">
            <p class="title">departements</p>
            <p class="num">Total: <strong>4</strong></p>
            <a class="seemore" href="{{url('departements')}}"> Voir Plus</a>

          </div>

        </div>
        
      </div>

       
      <div class="p-2 col-6 col-lg-3">
        
        <div class="numbers-card bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
           <img  src="{{ asset('storage/images/4.png') }}" alt="">

          <div class="d-flex flex-column justify-content-start align-items-start">
            <p class="title">Filieres</p>
            <p class="num">Total: <strong>7</strong></p>
            <a class="seemore" href="{{url('filieres')}}"> Voir Plus</a>

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


    

            @foreach ($adminsHistory as $History)
            <div class="history-item mt-3 d-flex justify-content-between align-items-center pb-3">
            <div class="d-flex gap-3 align-items-center">

              @switch($History['action_type'])

                @case('create')
                
                <i style="color: #21b524" class="bi bi-plus-circle-fill"></i>
                  @break
              
                  @case('delete')
                
                  <i style="color: #ee5951" class="bi bi-trash3-fill"></i>
                    @break

                    @case('update')
                
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

            <a href="{{url('/admin/actions')}}" class="text-center"><p class="pt-2 m-0">Voir tous</p></a>
            
          </div>
        </div>

      </div>

      </section>

      <section class="side-section col-12 col-md-4 col-lg-3  p-0 pt-4 p-md-0">
   
        
        <div class="">
          <div class="logs p-0 " style="background-color:white ">
  
            <div style=" border:none; background-color:#4723d9; " class="logs-header d-flex justify-content-between align-items-center ">
                <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin:0">History des Connexions:</p>
  
            </div>
  
            <div class="logs-content p-3 p-md-4 pt-0">
  
  
      
  
              @foreach ($users_logs as $user_log)
              <div class="logs-item mt-3 d-flex align-items-center pb-3">
              <div class="d-flex gap-3 align-items-center">
                 <a href="{{url('profile/' .$user_log->user->id)}}">      
                @if ($user_log->user->user_details)
                @if ($user_log->user->user_details->profile_img!=null)
                
                
                <img style="height: 40px;width: 40px;object-fit:cover;border-radius:50%; background-color: #c7c1e1;" src="{{asset('storage/' . $user_log->user->user_details->profile_img)}}">
                @else
                <img style="height: 40px;width: 40px;object-fit:cover;border-radius:50%;" src="{{asset('storage/images/default_profile_img.png')}}">
                
                @endif
                
                
                @else
                <img style="width: 35px; border-radius:50%;" src="{{asset('storage/images/default_profile_img.png')}}">
                
                @endif
                </a> 
  
                <div>
  
                    <a href="{{url('profile/' .$user_log->user->id)}}" class="text-decoration-none">      
                  <p class="logs-desc m-0"> <strong style="color: #252525">{{$user_log->user->firstname}} {{$user_log->user->lastname}}</strong> </a> {{ $user_log['action']}}</p>
                 
                  <p class="logs-time m-0"> {{$user_log->created_at->diffForHumans()}}</p>
                  
                </div>
  
                </div>
  
                
  
              </div>
              @endforeach
  
              <a href="{{url('/logs')}}" class="text-center"><p class="pt-2 m-0">Voir Plus</p></a>
              
            </div>
          </div>
  
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
      
    </x-admin_layout>
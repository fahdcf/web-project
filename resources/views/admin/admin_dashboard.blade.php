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
  </style>



    <div class="container-fluid p-0 pt-5 d-flex " >

      <div class="page-wrapper w-100 row m-0" >

      
      <section class="main-section col-12 col-md-8 col-lg-9 p-0 pr-md-4"  >

        <div class="welcome p-4 ">

          <div class="d-flex flex-column justify-content-between col-8">
          <h3 style="font-weight: 500; padding-bottom: 10px;">Welcome <strong>{{auth()->user()->firstname . " " . auth()->user()->lastname}}</strong> to the Dashboard</h3>
          <p style="font-size: 14px;">Unlock All Premium Songs, no Ads, and more.</p>  
          
          <div class="buttons-wrapper d-flex  gap-3"><button class="addbtn">Ajeuter un utilisateur</button> <button class="seebtn">voir tous les utilisateurs</button> </div>

          </div>


       </div>

       <div class="numbers row w-100 m-0 mt-4 ">
      
      <div class="p-2 col-6 col-lg-3">
        
        <div class="numbers-card  bg-white d-flex  p-2 gap-3 gap-md-4 align-items-center">
          <img  src="{{ asset('storage/images/1.png') }}" alt="">

          <div class="d-flex flex-column justify-content-start align-items-start">
            <p class="title">Etudiants</p>
            <p class="num">Total: <strong>312</strong></p>
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

        <!-- Connexions Chart -->
        <div class="col-12 col-md-6 mb-4  p-2">
          <div class="p-3 bg-white " style="height: 350px;">

            <h5 class="text-center">Nombre de connexions par jour (semaine)</h5>
            <canvas id="loginChart" style="width: 100%; height: auto;"></canvas>
          </div>
        </div>
    
        <!-- Répartition Filles / Garçons -->
        <div class="col-12 col-md-6 mb-4  p-2">
          <div class="p-3 bg-white " style="height: 350px;">

          <h5 class="text-center">Répartition des élèves : Filles vs Garçons</h5>
          <canvas id="genderChart" style="width: 100%; height: auto;"></canvas>
        </div>
        </div>
    
      </div>

      </section>

      <section class="side-section col-12 col-md-4 col-lg-3  p-0 pt-4 p-md-0">
   
     <div class="tasks p-0 " style="background-color:white ">

                <div style=" border:none; background-color:#4723d9; " class="tasks-header d-flex justify-content-between align-items-center ">
                    <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin:0">Your tasks:</p>
                    <button id="task-add-button"  onclick="addtask()">+</button>

                </div>
                <div class="task-content p-3 p-md-4 pt-0">


                  <div id="task-add" style="display: none">
                    <form action="{{url('/addtask')}}" method="post">
                    @csrf
                        <input id="task-input" name="task" type="text" placeholder="Ajeuter...">
                    </form>
                  </div>

                  @foreach ($tasks as $task)
                  <div class="task-item mt-3 d-flex justify-content-between align-items-center pb-3">
                  <div class="d-flex gap-3 align-items-center">
                    @if ($task['isdone'])
                    
                   <i style="color: #21b524" class="bi bi-check-circle-fill"> </i>
                    
                    @else
                    <i style="color: #ff914d" class="bi bi-clock-fill"></i>
                    
                    @endif

                    <div>

                      <p class="task-desc m-0"> {{ $task['description']}}</p>
                      <p class="task-time m-0"> {{$task->created_at->diffForHumans()}}</p>
                      
                    </div>

                    </div>

                    <div>
                      <button><i class="bi bi-three-dots-vertical"></i>
                    </button>
                  </div>

                  </div>
                  @endforeach

                  <a href="#" class="text-center"><p class="pt-2 m-0">Voir tous</p></a>
                  
                </div>
              </div>

      </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  
    const ctx = document.getElementById('genderChart').getContext('2d');
    const genderChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Filles', 'Garçons'],
        datasets: [{
          data: [55, 45], // ← change these numbers to match your data
          backgroundColor: [
            '#8b76e2', // rose pour filles
            '#4723d9'  // bleu pour garçons
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)'
          ],
          borderWidth: 0
        }]
      },
      options: {
        plugins: {
          tooltip: {
            callbacks: {
              label: function(context) {
                const label = context.label || '';
                const value = context.parsed;
                const total = context.chart._metasets[0].total;
                const percentage = ((value / total) * 100).toFixed(1);
                return `${label}: ${value} (${percentage}%)`;
              }
            }
          }
        }
      }
    });
  const ctx2 = document.getElementById('loginChart').getContext('2d');
  const loginChart = new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
      datasets: [{
        label: 'Nombre de connexions',
        data: [120, 150, 90, 180, 200, 130, 80], // Replace with your real data
        backgroundColor: 'rgba(54, 162, 235, 0.7)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Connexions'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Jours de la semaine'
          }
        }
      }
    }
  });
</script>

    <script>

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
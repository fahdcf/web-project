<x-admin_layout>
  
  <style>
    * {
    box-sizing: border-box;
  }



  #task-add{
    border: 1px solid #1777ec;
  }
#task-input{
  border: none;
  height: 21px;
}

#task-input:focus {
  outline: none;
  
}

 




  .main-section div{
    border-radius: 15px;
    background-color: white;
    padding: 15px;
    box-shadow: 0px 3px 15px 1px #3838381d;
  }
  .side-section div{
    border-radius: 15px;
    background-color: white;
    padding: 15px;
    box-shadow: 0px 3px 15px 1px #3838381d;
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
   font-size: 14px;
   height: auto;

   border: 1px solid rgba(101, 101, 101, 0.3);
   box-shadow: none;
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
  </style>



    <div class="container-fluid p-0 pt-5 ">

      <div class="page-wrapper row">

      
      <section class="main-section col-8">

        <div class="welcome">

          <h4>Welcome <strong>{{auth()->user()->firstname . " " . auth()->user()->lastname}}</strong> to the Dashboard</h4>

          <div class="d-flex  justify-content-between">

              <div class="mt-5 d-flex flex-column justify-content-between">
              <button class="btn">Check pending users <i class="bi bi-arrow-right"></i>
              </button>
              <p class="text-start">{{ \Carbon\Carbon::today()->toDateString() }}</p>
            </div>
           <img style="width: 150px" src="{{ asset('storage/images/adminavatar.png') }}" alt="">


          </div>


       </div>

      </section>

      <section class="side-section col-4">
   
     <div class="tasks" style="background-color:#4723d9 ">

                <div style=" border:none; background-color:#4723d9; " class="d-flex justify-content-between align-items-center">
                    <p style="color: #f1eded; font-size: 15px; font-weight: 600;">Your daily tasks:</p>
                    <button id="task-add-button" style="background:none;marging-right:0px; border:none ;font-size:20px; margin-top:-29px;margin-right:-15px; color: #f2f1f1;" onclick="addtask()">+</button>

                </div>
                <div class="task-content">


                  <div id="task-add" style="display: none">
                    <form action="{{url('/addtask')}}" method="post">
                    @csrf
                        <input id="task-input" name="task" type="text">
                    </form>
                  </div>

                  @foreach ($tasks as $task)
                  <div class="mt-3">
                    <p >{{ $task['description']}}</p>
                    </div>
                  @endforeach
                  
                </div>
              </div>

      </section>
    </div>
</div>


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
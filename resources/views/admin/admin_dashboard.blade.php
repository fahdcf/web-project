<x-admin_layout>
  
  <style>
    * {
    box-sizing: border-box;
  }


 



  .main-section > div{
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
   font-size: 14px;
   height: auto;

   border-top-left-radius: 15px;
   border-top-right-radius: 15px;
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


.buttons-wrapper button{
  border:none;
  background-color: white;
  border-radius: 5px;
  padding: 8px 10px;
  color: #4723d9;
  font-weight: 500;
  text-wrap: nowrap;




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

#task-input{
  border-radius: 15px !important;

}

#task-add{
    border: 1px solid #1777ec;
    border-radius: 7px;
    padding: 12px;
  }

  </style>



    <div class="container-fluid p-0 pt-5 d-flex " >

      <div class="page-wrapper w-100 row m-0 " >

      
      <section class="main-section col-12 col-md-8 p-0 pr-md-4"  >

        <div class="welcome p-4 ">

          <div class="d-flex flex-column justify-content-between col-8">
          <h3 style="font-weight: 500; padding-bottom: 10px;">Welcome <strong>{{auth()->user()->firstname . " " . auth()->user()->lastname}}</strong> to the Dashboard</h3>
          <p style="font-size: 14px;">Unlock All Premium Songs, no Ads, and more.</p>  
          
          <div class="buttons-wrapper d-flex flex-column flex-lg-row  gap-3"><button>Ajeuter un utilisateur</button> <button>voir tous les utilisateurs</button> </div>

          </div>


       </div>

      </section>

      <section class="side-section col-12 col-md-4  p-0 pt-4 p-md-0">
   
     <div class="tasks p-0 " style="background-color:white ">

                <div style=" border:none; background-color:#4723d9; " class="tasks-header d-flex justify-content-between align-items-center ">
                    <p style="color: #f1eded; font-size: 15px; font-weight: 600; margin:0">Your tasks:</p>
                    <button id="task-add-button"  onclick="addtask()">+</button>

                </div>
                <div class="task-content p-3 p-md-4">


                  <div id="task-add" style="display: none">
                    <form action="{{url('/addtask')}}" method="post">
                    @csrf
                        <input id="task-input" name="task" type="text" placeholder="Ajeuter...">
                    </form>
                  </div>

                  @foreach ($tasks as $task)
                  <div class="task-item mt-3">
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
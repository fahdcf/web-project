<x-chef_layout>

    

    <div class="container-fluid p-0 pt-5">
  
     

        <h1 class="pb-5" style="color: #330bcf; font-weight: 500; ">The list of requests</h1>
    
     

    
        
            <div class="sections-container">
                <section class="buttons-section d-flex gap-2">
        
                   
                  
                  <div id="line2"  class="active-btn">
                    <button onclick="togglebtnformodule()"><i class='bx bx-lock-alt'></i> Les demandes pour les module</button>
                    <div id="line"></div>
                  </div>
        
                     <div id="line1">
                    <button onclick="togglebtnforfiliere()"><i class='bx bx-info-circle' ></i> Les demandes pour filieres</button>
                    <div id="line"></div>
                  </div>
                    
        
        
                </section>
        
        
                
              
        
   
     
            
        <section id="filiere" class="hidden mt-5">

            

  <div >
        <div class="accordion rounded" id="accordionFilters">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapspending" aria-expanded="false" aria-controls="collapsefilters">
                        pending
                    </button>
                </h2>
    
                <div id="collapspending" class="accordion-collapse collapse" data-bs-parent="#collapspending">
                    <div class="accordion-body">
    
      <div class="table-responsive mt-4 ">
        <table class="table table-borderless">
          <thead >
            <tr style="color: #535050; font-weight: 600;font-size:15px;">
                <th>Professeur</th>
                <th>filiere</th>
              <th>Type</th>
              <th>Status</th>
              <th>date</th>
              <th class="pAlso">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($filiere_requests as $filiere_request)
            @if ($filiere_request->status=="pending")
              
           
              <tr class="filiere_request-row">
                <td colspan="6" style="padding: 0; background:#ffffff;">
                  <div class="custom-row-wrapper" style="width: 100%">
                    <div class="custom-row d-flex" style="width: 100%">
                        
                        <p>{{ $filiere_request->prof->firstname}} {{ $filiere_request->prof->lastname}}</p>
                        <p>{{$filiere_request->target->name}}</p>

                      
                      <p>{{ $filiere_request->type}}</p>

                      @if ($filiere_request->status=='pending')
                      <p><span style="background-color: #eaa454; color: white;padding:5px 6px;border-radius:15px;" >pending</span></p>
                          @elseif ($filiere_request->status=='rejected')
                
                          <p><span style="background-color: #ea5e54; color: white;padding:5px 6px;border-radius:15px;" >refusee</span></p>
                  
                          @elseif ($filiere_request->status=='approved')
                    <p><span style="background-color: #13ab50; color: white;padding:5px 6px;border-radius:15px;" >approved</span></p>

                      @endif


                      
                      

                      <p>{{ $filiere_request->created_at->format('Y-m-d') }}</p>
                      <div class="pAlso d-flex align-items-center gap-2">
                        <input type="number" hidden id="pending_user_id_{{ $filiere_request['id'] }}" value="{{ $filiere_request['id'] }}">
                        <button style="background-color: #4723d9;color:white;" class="btn btn-sm" onclick="showPopup({{ $filiere_request['id'] }}, '{{ $filiere_request['name'] }}')" data-toggle="modal" data-target="#acceptModalforid{{ $filiere_request['id'] }}"><i class="bi bi-check-square"></i></button>
                        <button class="btn ml-1 btn-danger btn-sm" data-toggle="modal" data-target="#rejectModalforid{{ $filiere_request['id'] }}"><i class="bi bi-x-square"></i></button>
      
                      
                      </div>
  
                    </div>
                  </div>
                </td>            
              </tr>

  
    <!--reject Modal -->
    <div class="modal fade" id="rejectModalforid{{ $filiere_request['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Refuser</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Vous voulez refuser la demande de <strong>{{ $filiere_request->prof->firstname }} {{ $filiere_request->prof->lastname }}</strong> ?</p>
            <form action="{{ url('/chef/demandes/' . $filiere_request['id']) }}" method="POST">
              @csrf
              @method('DELETE')

              <textarea 
                name="rejection_reason" 
                id="rejection_reason" 
                style="resize:none; width: 100%; max-height: 100px;padding:7px;"
                placeholder="Enter rejection reason here..."
                value=""></textarea>

              <div class="modal-footer">
                <button type="button" class="btn ml-1 btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn ml-1 btn-danger btn-sm">Refuser</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    
    <!-- accept Modal -->
    <div class="modal fade" id="acceptModalforid{{ $filiere_request['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Accepter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Vous voulez accepter la demande de <strong>{{ $filiere_request->prof->firstname }} {{ $filiere_request->prof->lastname }}</strong> ?</p>
            <form action="{{ url('/chef/demandes/' . $filiere_request['id']) }}" method="POST">
              @csrf
              @method('PATCH')
              <div class="modal-footer">
                <button type="button" class="btn ml-1 btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn ml-1 btn-sm text-white" style="background-color:#4723d9">Accepter</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
     @endif
              @endforeach
          </tbody>
        </table>
                     </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    

          

 <div class="pt-5">
        <div class="accordion rounded" id="accordionFilters">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseapproved" aria-expanded="false" aria-controls="collapsefilters">
                        Acceptee
                    </button>
                </h2>
    
                <div id="collapseapproved" class="accordion-collapse collapse" data-bs-parent="#collapseapproved">
                    <div class="accordion-body">
    

                        
      <div class="table-responsive mt-4 ">
        <table class="table table-borderless">
          <thead >
            <tr style="color: #535050; font-weight: 600;font-size:15px;">
                <th>Professeur</th>
                <th>filiere</th>
              <th>Type</th>
              <th>Status</th>
              <th>date</th>
              <th class="pAlso">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($filiere_requests as $filiere_request)
            @if ($filiere_request->status=="approved")
              
           
              <tr class="filiere_request-row">
                <td colspan="6" style="padding: 0; background:#ffffff;">
                  <div class="custom-row-wrapper" style="width: 100%">
                    <div class="custom-row d-flex" style="width: 100%">
                        
                        <p>{{ $filiere_request->prof->firstname}} {{ $filiere_request->prof->lastname}}</p>
                        <p>{{$filiere_request->target->name}}</p>

                      
                      <p>{{ $filiere_request->type}}</p>

                      @if ($filiere_request->status=='pending')
                      <p><span style="background-color: #eaa454; color: white;padding:5px 6px;border-radius:15px;" >pending</span></p>
                          @elseif ($filiere_request->status=='rejected')
                
                          <p><span style="background-color: #ea5e54; color: white;padding:5px 6px;border-radius:15px;" >refusee</span></p>
                  
                          @elseif ($filiere_request->status=='approved')
                    <p><span style="background-color: #13ab50; color: white;padding:5px 6px;border-radius:15px;" >approved</span></p>

                      @endif


                      
                      

                      <p>{{ $filiere_request->created_at->format('Y-m-d') }}</p>
                      <div class="pAlso d-flex align-items-center justify-content-center gap-2">
                        <input type="number" hidden id="pending_user_id_{{ $filiere_request['id'] }}" value="{{ $filiere_request['id'] }}">
                        <button style="background-color: #4723d9;color:white;" class="btn btn-sm" onclick="showPopup({{ $filiere_request['id'] }}, '{{ $filiere_request['name'] }}')" ><i class="bi bi-info-square"></i></button>
                     
                      
                      </div>
  
                    </div>
                  </div>
                </td>            
              </tr>

  
  

    
    
     @endif
              @endforeach
          </tbody>
        </table>
</div>

                   
    
                    </div>
                </div>
            </div>
        </div>
    </div>
    



 <div class="pt-5 pb-3">
        <div class="accordion rounded" id="accordionFilters">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapserejected" aria-expanded="false" aria-controls="collapsefilters">
                        rejectee
                    </button>
                </h2>
    
                <div id="collapserejected" class="accordion-collapse collapse" data-bs-parent="#collapserejected">
                    <div class="accordion-body">
    

                        
      <div class="table-responsive mt-4 ">
        <table class="table table-borderless">
          <thead >
            <tr style="color: #535050; font-weight: 600;font-size:15px;">
                <th>Professeur</th>
                <th>filiere</th>
              <th>Type</th>
              <th>Status</th>
              <th>date</th>
              <th class="pAlso">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($filiere_requests as $filiere_request)
            @if ($filiere_request->status=="rejected")
              
           
              <tr class="filiere_request-row">
                <td colspan="6" style="padding: 0; background:#ffffff;">
                  <div class="custom-row-wrapper" style="width: 100%">
                    <div class="custom-row d-flex" style="width: 100%">
                        
                        <p>{{ $filiere_request->prof->firstname}} {{ $filiere_request->prof->lastname}}</p>
                        <p>{{$filiere_request->target->name}}</p>

                      
                      <p>{{ $filiere_request->type}}</p>

                      @if ($filiere_request->status=='pending')
                      <p><span style="background-color: #eaa454; color: white;padding:5px 6px;border-radius:15px;" >pending</span></p>
                          @elseif ($filiere_request->status=='rejected')
                
                          <p><span style="background-color: #ea5e54; color: white;padding:5px 6px;border-radius:15px;" >refusee</span></p>
                  
                          @elseif ($filiere_request->status=='approved')
                    <p><span style="background-color: #13ab50; color: white;padding:5px 6px;border-radius:15px;" >approved</span></p>

                      @endif


                      
                      

                      <p>{{ $filiere_request->created_at->format('Y-m-d') }}</p>
                      <div class="pAlso d-flex align-items-center justify-content-center gap-2">
                        <input type="number" hidden id="pending_user_id_{{ $filiere_request['id'] }}" value="{{ $filiere_request['id'] }}">
                        <button style="background-color: #4723d9;color:white;" class="btn btn-sm" onclick="showPopup({{ $filiere_request['id'] }}, '{{ $filiere_request['name'] }}')" ><i class="bi bi-info-square"></i></button>
                     
                      
                      </div>
  
                    </div>
                  </div>
                </td>            
              </tr>

  
  

    
    
     @endif
              @endforeach
          </tbody>
        </table>
</div>

                   
    
                    </div>
                </div>
            </div>
        </div>
    </div>
    

  </section>
  <!-- #module requests-->   
    
    <section id="module" class=" mt-5">


        <div class="table-responsive mt-4 ">
        <table class="table table-borderless">
          <thead >
            <tr style="color: #535050; font-weight: 600;font-size:15px;">
                <th>Professeur</th>
                <th>Module</th>
              <th>Type</th>
              <th>Status</th>
              <th>date</th>
              <th class="pAlso">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($module_requests as $module_request)
            @if ($module_request->status=="pending")
              
           
              <tr class="module_request-row">
                <td colspan="6" style="padding: 0; background:#ffffff;">
                  <div class="custom-row-wrapper" style="width: 100%">
                    <div class="custom-row d-flex" style="width: 100%">
                        
                        <p>{{ $module_request->prof->firstname}} {{ $module_request->prof->lastname}}</p>
                        <p>{{$module_request->target->name}}</p>

                      
                      <p>{{ $module_request->type}}</p>

                      @if ($module_request->status=='pending')
                      <p><span style="background-color: #eaa454; color: white;padding:5px 6px;border-radius:15px;" >pending</span></p>
                          @elseif ($module_request->status=='rejected')
                
                          <p><span style="background-color: #ea5e54; color: white;padding:5px 6px;border-radius:15px;" >refusee</span></p>
                  
                          @elseif ($module_request->status=='approved')
                    <p><span style="background-color: #13ab50; color: white;padding:5px 6px;border-radius:15px;" >approved</span></p>

                      @endif


                      
                      

                      <p>{{ $module_request->created_at->format('Y-m-d') }}</p>
                       <div class="pAlso d-flex align-items-center gap-2">
                        <input type="number" hidden id="pending_user_id_{{ $module_request['id'] }}" value="{{ $module_request['id'] }}">
                        <button style="background-color: #4723d9;color:white;" class="btn btn-sm" onclick="showPopup({{ $module_request['id'] }}, '{{ $module_request['name'] }}')" data-toggle="modal" data-target="#acceptModuleforid{{ $module_request['id'] }}"><i class="bi bi-check-square"></i></button>
                        <button class="btn ml-1 btn-danger btn-sm" data-toggle="modal" data-target="#rejectModuleforid{{ $module_request['id'] }}"><i class="bi bi-x-square"></i></button>
      
                      
                      </div>
  
                    </div>
                  </div>
                </td>            
              </tr>

  
  
  <!--reject Modal -->
    <div class="modal fade" id="rejectModuleforid{{ $module_request['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Refuser</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Vous voulez refuser la demande de <strong>{{ $module_request->prof->firstname }} {{ $module_request->prof->lastname }}</strong> ?</p>
            <form action="{{ url('/chef/demandes/' . $module_request['id']) }}" method="POST">
              @csrf
              @method('DELETE')

              <textarea 
                name="rejection_reason" 
                id="rejection_reason" 
                style="resize:none; width: 100%; max-height: 100px;padding:7px;"
                placeholder="Enter rejection reason here..."
                value=""></textarea>

              <div class="modal-footer">
                <button type="button" class="btn ml-1 btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn ml-1 btn-danger btn-sm">Refuser</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    
    <!-- accept Modal -->
    <div class="modal fade" id="acceptModuleforid{{ $module_request['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Accepter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Vous voulez accepter la demande de <strong>{{ $module_request->prof->firstname }} {{ $module_request->prof->lastname }}</strong> ?</p>
            <form action="{{ url('/chef/demandes/' . $module_request['id']) }}" method="POST">
              @csrf
              @method('PATCH')
              <div class="modal-footer">
                <button type="button" class="btn ml-1 btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn ml-1 btn-sm text-white" style="background-color:#4723d9">Accepter</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
     @endif
              @endforeach
          </tbody>
        </table>
</div>
      
    
    </section>
    
        
           
           
            </div>  
        </div>
        
      
          
        
        
        
        
        
        
        
        
        
        
        
        
        


      </div>
   
    
      <style>
         button:disabled{
            background-color: white;
            border: 1px solid #cccfe1a6;
            color: #cccfe1a6;
            
            
        }
        
        .sections-container{
            background-color: white;
            border-radius: 7px;
            padding: 20px;
            box-shadow: 1px 1px 10px 2px #33333314;
        
        
        }
        .hidden{
            display: none;
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
        
        
        
       
  
  thead tr {
    display: flex;
  }
  
  thead tr th{
    padding: 0.75rem;
    width: 100%;
    margin: 2px;
    text-align: center;
  
  }
  
  .custom-row {
    background-color: #ffffff;
    display: flex;
    padding: 10px;
    
  }
  
  .custom-row p{
    color: #3f3f3f;
    font-weight: 500;
  }
  .custom-row p,.pAlso {
    text-align: center;
    min-width: 200px;
    padding: 0.75rem;
    margin: 0;
    vertical-align: middle;
  text-wrap: wrap;
  word-break: break-all;
    width: 100%;
  
  }
  .pAlso{
    min-width: 100px;
    max-width: 100px;
    widows: 100px;
  }
  
  
  thead {
      display: table-header-group;
      
      vertical-align: middle;
      unicode-bidi: isolate;
      border-color: inherit;
  }
  
        .table-responsive {
          border-radius: 6px;
          width: 100%;
        }
    
        .filiere_request-row td .custom-row-wrapper {
          overflow-x: auto;
          width: 100%;
          margin: 2px;
          margin-bottom: 7px;
          outline:1px solid #4723d929;
  
          background-color: white;
          border-radius: 10px;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
          transition: all 0.2s ease-in-out;
        }
    
        .filiere_request-row td .custom-row-wrapper:hover {
          outline:1px solid #4723d9;
  
          transform: translateY(-5px);
          box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
   
         .module_request-row td .custom-row-wrapper {
          overflow-x: auto;
          width: 100%;
          margin: 2px;
          margin-bottom: 7px;
          outline:1px solid #4723d929;
  
          background-color: white;
          border-radius: 10px;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
          transition: all 0.2s ease-in-out;
        }
    
        .module_request-row td .custom-row-wrapper:hover {
          outline:1px solid #4723d9;
  
          transform: translateY(-5px);
          box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
   

        table{
          max-width: 1250px;
          margin: 0 auto;
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
            function togglebtnformodule(){
                document.getElementById('line1').classList.remove('active-btn');
                document.getElementById('line2').classList.add('active-btn');
            
                document.getElementById('filiere').classList.add('hidden');
                document.getElementById('module').classList.remove('hidden');
        
            
            }
            function togglebtnforfiliere(){
                document.getElementById('line1').classList.add('active-btn');
                document.getElementById('line2').classList.remove('active-btn');
            
                document.getElementById('filiere').classList.remove('hidden');
                document.getElementById('module').classList.add('hidden');
        
            
            
            }
            
            
                </script>   
    
    
</x-chef_layout>
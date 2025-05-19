<x-chef_layout>

<style>
    /* Main Container */
    .requests-container {
        padding: 2rem;
        min-height: 100vh;
    }
    
    /* Header */
    .page-header {
        margin-bottom: 2rem;
    }
    
    .page-title {
        color: #4723d9;
        font-weight: 600;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
    }
    
    /* Tabs Navigation */
    .requests-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        background: white;
        padding: 1rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .tab-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        background: none;
        border: none;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .tab-btn.active {
        background-color: #4723d9;
        color: white;
        box-shadow: 0 4px 8px rgba(71, 35, 217, 0.2);
    }
    
    .tab-btn i {
        font-size: 1.1rem;
    }
    
    /* Request Sections */
    .request-section {
        background: rgb(255, 255, 255);
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .section-header {
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
    }
    
    .section-header h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 500;
        color: #333;
    }
    
    .section-header .badge {
        background-color: #4723d9;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
  
  td{
    padding: 10px !important;
  }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #666;
    }
    
   
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .request-item {
            flex-wrap: wrap;
        }
        
        .request-item > div {
            flex: 0 0 50%;
            margin-bottom: 0.5rem;
        }
        
        .action-buttons {
            flex: 0 0 100%;
            justify-content: center;
            margin-top: 0.5rem;
        }
    }
</style>

<div class="requests-container">
    <div class="page-header">
        <h1 class=" display-6 fw-bold  mb-5" style="color: #4723d9">Requests Management</h1>
        
        <div class="requests-tabs">
          <button class="tab-btn active" onclick="toggleSection('module')">
              <i class="bi bi-journal-text"></i> Module demandes
          </button>

            <button class="tab-btn " onclick="toggleSection('filiere')">
                <i class="bi bi-book"></i> Filieres demandes
            </button>
        </div>
    </div>
    
    <!-- Program Requests Section -->
    <section id="filiere" class="request-section hidden">
        <!-- Pending Requests -->
        <div class="section-header" data-bs-toggle="collapse" data-bs-target="#fpendingRequests" aria-expanded="true">
            <h3>Pending Requests <span class="badge">{{ $filiere_requests->where('status', 'pending')->count() }}</span></h3>
            <i class='bx bx-chevron-down'></i>
        </div>
        
        <div id="fpendingRequests" class="section-body collapse show">
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
            @forelse ($filiere_requests->where('status', 'pending') as $filiere_request)
              
           
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

  @empty
     <tr>
                            <td colspan="6">
                                <div class="empty-state">No pending module requests found</div>
                            </td>
                        </tr>
  @endforelse
          </tbody>
        </table>
                     </div>
        </div>
        
        <!-- Approved Requests -->
        <div class="section-header collapsed" data-bs-toggle="collapse" data-bs-target="#fapprovedRequests" aria-expanded="false">
            <h3>Approved Requests <span class="badge">{{ $filiere_requests->where('status', 'approved')->count() }}</span></h3>
            <i class='bx bx-chevron-up'></i>
        </div>
        
        <div id="fapprovedRequests" class="section-body collapse">
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

            @forelse ($filiere_requests->where('status', 'approved') as $filiere_request)
              
           
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

  
  

    
    
 @empty
     <tr>
                          <td colspan="6">
                                <div class="empty-state">No approved module requests found</div>
                            </td>
                        </tr>
  @endforelse
  
          </tbody>
        </table>
</div>
        </div>
        
        <!-- Rejected Requests -->
        <div class="section-header collapsed" data-bs-toggle="collapse" data-bs-target="#frejectedRequests" aria-expanded="false">
            <h3>Rejected Requests <span class="badge">{{ $filiere_requests->where('status', 'rejected')->count() }}</span></h3>
            <i class='bx bx-chevron-up'></i>
        </div>
        
        <div id="frejectedRequests" class="section-body collapse">
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

            @forelse ($filiere_requests->where('status', 'rejected') as $filiere_request)
              
           
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

               @empty
                         <tr>
                            <td colspan="6">
                                <div class="empty-state">No rejected module requests found</div>
                            </td>
                        </tr>
  @endforelse

  
          </tbody>
        </table>
</div>
        </div>
    </section>


    
    
    <!-- Module Requests Section (hidden by default) -->
    <section id="module" class="request-section">
       <!-- Pending Requests -->
        <div class="section-header" data-bs-toggle="collapse" data-bs-target="#mpendingRequests" aria-expanded="true">
            <h3>Pending Requests <span class="badge">{{ $module_requests->where('status', 'pending')->count() }}</span></h3>
            <i class='bx bx-chevron-down'></i>
        </div>
        
        <div id="mpendingRequests" class="section-body collapse show">
        <div class="table-responsive mt-4 ">
        <table class="table table-borderless">
          <thead >
            <tr style="color: #535050; font-weight: 600;font-size:15px;">
                <th>Professeur</th>
                <th>module</th>
              <th>Type</th>
              <th>Status</th>
              <th>date</th>
              <th class="pAlso">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($module_requests->where('status', 'pending') as $module_request)
              
           
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
                        <button style="background-color: #4723d9;color:white;" class="btn btn-sm" onclick="showPopup({{ $module_request['id'] }}, '{{ $module_request['name'] }}')" data-toggle="modal" data-target="#acceptModalforid{{ $module_request['id'] }}"><i class="bi bi-check-square"></i></button>
                        <button class="btn ml-1 btn-danger btn-sm" data-toggle="modal" data-target="#rejectModalforid{{ $module_request['id'] }}"><i class="bi bi-x-square"></i></button>
      
                      
                      </div>
  
                    </div>
                  </div>
                </td>            
              </tr>

  
    <!--reject Modal -->
    <div class="modal fade" id="rejectModalforid{{ $module_request['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    <div class="modal fade" id="acceptModalforid{{ $module_request['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

  @empty
     <tr>
                            <td colspan="6">
                                <div class="empty-state">No pending module requests found</div>
                            </td>
                        </tr>
  @endforelse
          </tbody>
        </table>
                     </div>
        </div>
        
        <!-- Approved Requests -->
        <div class="section-header collapsed" data-bs-toggle="collapse" data-bs-target="#mapprovedRequests" aria-expanded="false">
            <h3>Approved Requests <span class="badge">{{ $module_requests->where('status', 'approved')->count() }}</span></h3>
            <i class='bx bx-chevron-up'></i>
        </div>
        
        <div id="mapprovedRequests" class="section-body collapse">
            <div class="table-responsive mt-4 ">
        <table class="table table-borderless">
          <thead >
            <tr style="color: #535050; font-weight: 600;font-size:15px;">
                <th>Professeur</th>
                <th>module</th>
              <th>Type</th>
              <th>Status</th>
              <th>date</th>
              <th class="pAlso">Action</th>
            </tr>
          </thead>
          <tbody>

            @forelse ($module_requests->where('status', 'approved') as $module_request)
              
           
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
                      <div class="pAlso d-flex align-items-center justify-content-center gap-2">
                        <input type="number" hidden id="pending_user_id_{{ $module_request['id'] }}" value="{{ $module_request['id'] }}">
                        <button style="background-color: #4723d9;color:white;" class="btn btn-sm" onclick="showPopup({{ $module_request['id'] }}, '{{ $module_request['name'] }}')" ><i class="bi bi-info-square"></i></button>
                     
                      
                      </div>
  
                    </div>
                  </div>
                </td>            
              </tr>

  
  

    
    
 @empty
     <tr>
                          <td colspan="6">
                                <div class="empty-state">No approved module requests found</div>
                            </td>
                        </tr>
  @endforelse
  
          </tbody>
        </table>
</div>
        </div>
        
        <!-- Rejected Requests -->
        <div class="section-header collapsed" data-bs-toggle="collapse" data-bs-target="#mrejectedRequests" aria-expanded="false">
            <h3>Rejected Requests <span class="badge">{{ $module_requests->where('status', 'rejected')->count() }}</span></h3>
            <i class='bx bx-chevron-up'></i>
        </div>
        
        <div id="mrejectedRequests" class="section-body collapse">
             <div class="table-responsive mt-4 ">
        <table class="table table-borderless">
          <thead >
            <tr style="color: #535050; font-weight: 600;font-size:15px;">
                <th>Professeur</th>
                <th>module</th>
              <th>Type</th>
              <th>Status</th>
              <th>date</th>
              <th class="pAlso">Action</th>
            </tr>
          </thead>
          <tbody>

            @forelse ($module_requests->where('status', 'rejected') as $module_request)
              
           
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
                      <div class="pAlso d-flex align-items-center justify-content-center gap-2">
                        <input type="number" hidden id="pending_user_id_{{ $module_request['id'] }}" value="{{ $module_request['id'] }}">
                        <button style="background-color: #4723d9;color:white;" class="btn btn-sm" onclick="showPopup({{ $module_request['id'] }}, '{{ $module_request['name'] }}')" ><i class="bi bi-info-square"></i></button>
                     
                      
                      </div>
  
                    </div>
                  </div>
                </td>            
              </tr>

               @empty
                         <tr>
                            <td colspan="6">
                                <div class="empty-state">No rejected module requests found</div>
                            </td>
                        </tr>
  @endforelse

  
          </tbody>
        </table>
</div>
        </div>
    </section>
</div>

<script>
    // Toggle between program and module requests
    function toggleSection(sectionId) {
        // Update tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.currentTarget.classList.add('active');
        
        // Show/hide sections
        document.getElementById('filiere').classList.toggle('hidden', sectionId !== 'filiere');
        document.getElementById('module').classList.toggle('hidden', sectionId !== 'module');
    }
    
    // Initialize Bootstrap collapse components
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners to section headers
        document.querySelectorAll('.section-header').forEach(header => {
            header.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (this.classList.contains('collapsed')) {
                    icon.classList.remove('bx-chevron-down');
                    icon.classList.add('bx-chevron-up');
                } else {
                    icon.classList.remove('bx-chevron-up');
                    icon.classList.add('bx-chevron-down');
                }
            });
        });
    });
</script>

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
</x-chef_layout>
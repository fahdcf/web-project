<x-chef_layout>
<style>
    /* Root Variables */
    :root {
        --primary: #4723d9;
        --primary-soft: #e8e5ff;
    }

    /* Main Container */
    .requests-container {
        padding: 2rem;
        min-height: 100vh;
        background: #f8f9fa;
    }

    /* Header */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        color: var(--primary);
        font-weight: 600;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
    }

    /* Tabs Navigation */
    .requests-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 2rem;
        background: white;
        padding: 0.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow-x: auto;
    }

    .tab-btn {
        position: relative;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        background: none;
        border: none;
        font-weight: 600;
        font-size: 0.95rem;
        color: #666;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .tab-btn.active {
        color: var(--primary);
        background: var(--primary-soft);
    }

    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--primary);
        border-radius: 2px 2px 0 0;
        animation: slideIn 0.3s ease;
    }

    .tab-btn i {
        font-size: 1.1rem;
    }

    /* Request Sections */
    .request-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .section-header {
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, var(--primary-soft) 0%, #f8f9fa 100%);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        transition: background 0.2s ease;
    }

    .section-header:hover {
        background: var(--primary-soft);
    }

    .section-header h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 500;
        color: #333;
    }

    .section-header .badge {
        background-color: var(--primary);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .section-header i {
        font-size: 1.2rem;
        color: var(--primary);
    }

    td {
        padding: 10px !important;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #666;
        font-size: 0.95rem;
    }

    /* Table Styles (Unchanged) */
    thead tr {
        display: flex;
    }

    thead tr th {
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

    .custom-row p,
    .pAlso {
        text-align: center;
        min-width: 200px;
        padding: 0.75rem;
        margin: 0;
        vertical-align: middle;
        text-wrap: wrap;
        word-break: break-all;
        width: 100%;
    }

    .custom-row p {
        color: #3f3f3f;
        font-weight: 500;
    }

    .pAlso {
        min-width: 100px;
        max-width: 100px;
        width: 100px;
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

    .module_request-row td .custom-row-wrapper {
        overflow-x: auto;
        width: 100%;
        margin: 2px;
        margin-bottom: 7px;
        outline: 1px solid #4723d929;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease-in-out;
    }

    .module_request-row td .custom-row-wrapper:hover {
        outline: 1px solid #4723d9;
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    table {
        max-width: 1250px;
        margin: 0 auto;
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
        height: 3px;
        width: 5px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 15px;
    }

    ::-webkit-scrollbar-thumb {
        background: #3300ff8e;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #7a5af9;
    }

    /* Modal Popup */
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
        backdrop-filter: blur(4px);
    }

    .popup {
        background-color: white;
        padding: 1.5rem;
        border-radius: 12px;
        text-align: left;
        width: 100%;
        max-width: 500px;
        margin: 1rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        animation: popIn 0.3s ease-out;
    }

    .popup-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .popup-header h5 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary);
    }

    .popup-body {
        padding: 1rem 0;
    }

    .popup-footer {
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
        text-align: right;
    }

    /* Animations */
    @keyframes slideIn {
        from { width: 0; }
        to { width: 100%; }
    }

    @keyframes popIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .requests-container {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .requests-tabs {
            gap: 0.25rem;
            padding: 0.25rem;
        }

        .tab-btn {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .tab-btn i {
            font-size: 1rem;
        }

        .section-header {
            padding: 0.75rem 1rem;
        }

        .section-header h3 {
            font-size: 0.9rem;
        }

        .section-header i {
            font-size: 1rem;
        }

        .custom-row p,
        .pAlso {
            min-width: 150px;
            font-size: 0.85rem;
        }

        .pAlso {
            min-width: 80px;
            max-width: 80px;
        }
    }

    @media (max-width: 576px) {
        .popup {
            max-width: 90%;
        }

        .custom-row p,
        .pAlso {
            min-width: 120px;
            font-size: 0.8rem;
        }

        .pAlso {
            min-width: 60px;
            max-width: 60px;
        }
    }
</style>

<div class="requests-container">
    <div class="page-header">
        <h1 class="display-6 fw-bold mb-5" style="color: #4723d9">Requests Management</h1>
        
        <div class="requests-tabs">
            <button class="tab-btn active" onclick="toggleSection('pending')">
                <i class="bi bi-hourglass-split"></i> Pending Requests
            </button>
            <button class="tab-btn" onclick="toggleSection('approved')">
                <i class="bi bi-check-circle"></i> Approved Requests
            </button>
            <button class="tab-btn" onclick="toggleSection('rejected')">
                <i class="bi bi-x-circle"></i> Rejected Requests
            </button>
        </div>
    </div>

    <!-- Module Requests Sections -->
    <section id="pending" class="request-section">
        <!-- Pending Requests -->
        <div class="section-header" data-bs-toggle="collapse" data-bs-target="#mpendingRequests" aria-expanded="true">
            <h3>Pending Requests <span class="badge">{{ $module_requests->where('status', 'pending')->count() }}</span></h3>
            <i class='bx bx-chevron-down'></i>
        </div>
        
        <div id="mpendingRequests" class="section-body collapse show">
            <div class="table-responsive mt-4">
                <table class="table table-borderless">
                    <thead>
                        <tr style="color: #535050; font-weight: 600; font-size: 15px;">
                            <th>Professeur</th>
                            <th>Module</th>
                            <th>Elements</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="pAlso">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($module_requests->where('status', 'pending') as $module_request)
                            <tr class="module_request-row">
                                <td colspan="6" style="padding: 0; background: #ffffff;">
                                    <div class="custom-row-wrapper" style="width: 100%">
                                        <div class="custom-row d-flex" style="width: 100%">
                                            <p>{{ $module_request->prof->firstname }} {{ $module_request->prof->lastname }}</p>
                                            <p>{{ $module_request->target->name }}</p>
                                            <p>
                                              @if ($module_request->toTeach_cm)
                                                
                                              <span class="badge bg-success">Cours</span>
                                              @endif
                                                 @if ($module_request->toTeach_tp)
                                                
                                              <span class="badge bg-success">Tp</span>
                                              @endif   @if ($module_request->toTeach_td)
                                                
                                              <span class="badge bg-success">Td</span>
                                              @endif
                                            
                                            </p>
                                            <p><span style="background-color: #eaa454; color: white; padding: 5px 6px; border-radius: 15px;">pending</span></p>
                                            <p>{{ $module_request->created_at->format('Y-m-d') }}</p>
                                            <div class="pAlso d-flex align-items-center gap-2">
                                                <input type="number" hidden id="pending_user_id_{{ $module_request['id'] }}" value="{{ $module_request['id'] }}">
                                                <button style="background-color: #4723d9; color: white;" class="btn btn-sm" data-toggle="modal" data-target="#acceptModalforid{{ $module_request['id'] }}"><i class="bi bi-check-square"></i></button>
                                                <button class="btn ml-1 btn-danger btn-sm" data-toggle="modal" data-target="#rejectModalforid{{ $module_request['id'] }}"><i class="bi bi-x-square"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Reject Modal -->
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
                                                <textarea name="rejection_reason" id="rejection_reason" style="resize: none; width: 100%; max-height: 100px; padding: 7px;" placeholder="Enter rejection reason here..."></textarea>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn ml-1 btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn ml-1 btn-danger btn-sm">Refuser</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Accept Modal -->
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
                                                    <button type="submit" class="btn ml-1 btn-sm text-white" style="background-color: #4723d9">Accepter</button>
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
    </section>

    <section id="approved" class="request-section hidden">
        <!-- Approved Requests -->
        <div class="section-header" data-bs-toggle="collapse" data-bs-target="#mapprovedRequests" aria-expanded="true">
            <h3>Approved Requests <span class="badge">{{ $module_requests->where('status', 'approved')->count() }}</span></h3>
            <i class='bx bx-chevron-down'></i>
        </div>
        
        <div id="mapprovedRequests" class="section-body collapse show">
            <div class="table-responsive mt-4">
                <table class="table table-borderless">
                    <thead>
                        <tr style="color: #535050; font-weight: 600; font-size: 15px;">
                            <th>Professeur</th>
                            <th>Module</th>
                            <th>Element</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="pAlso">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($module_requests->where('status', 'approved') as $module_request)
                            <tr class="module_request-row">
                                <td colspan="6" style="padding: 0; background: #ffffff;">
                                    <div class="custom-row-wrapper" style="width: 100%">
                                        <div class="custom-row d-flex" style="width: 100%">
                                            <p>{{ $module_request->prof->firstname }} {{ $module_request->prof->lastname }}</p>
                                            <p>{{ $module_request->target->name }}</p>
                                            <p>{{ $module_request->type }}</p>
                                            <p><span style="background-color: #13ab50; color: white; padding: 5px 6px; border-radius: 15px;">approved</span></p>
                                            <p>{{ $module_request->created_at->format('Y-m-d') }}</p>
                                            <div class="pAlso d-flex align-items-center justify-content-center gap-2">
                                                <input type="number" hidden id="pending_user_id_{{ $module_request['id'] }}" value="{{ $module_request['id'] }}">
                                                <button style="background-color: #4723d9; color: white;" class="btn btn-sm" onclick="showPopup({{ $module_request['id'] }}, '{{ $module_request->target->name }}')"><i class="bi bi-info-square"></i></button>
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
    </section>

    <section id="rejected" class="request-section hidden">
        <!-- Rejected Requests -->
        <div class="section-header" data-bs-toggle="collapse" data-bs-target="#mrejectedRequests" aria-expanded="true">
            <h3>Rejected Requests <span class="badge">{{ $module_requests->where('status', 'rejected')->count() }}</span></h3>
            <i class='bx bx-chevron-down'></i>
        </div>
        
        <div id="mrejectedRequests" class="section-body collapse show">
            <div class="table-responsive mt-4">
                <table class="table table-borderless">
                    <thead>
                        <tr style="color: #535050; font-weight: 600; font-size: 15px;">
                            <th>Professeur</th>
                            <th>Module</th>
                            <th>Element</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="pAlso">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($module_requests->where('status', 'rejected') as $module_request)
                            <tr class="module_request-row">
                                <td colspan="6" style="padding: 0; background: #ffffff;">
                                    <div class="custom-row-wrapper" style="width: 100%">
                                        <div class="custom-row d-flex" style="width: 100%">
                                            <p>{{ $module_request->prof->firstname }} {{ $module_request->prof->lastname }}</p>
                                            <p>{{ $module_request->target->name }}</p>
                                            <p>{{ $module_request->type }}</p>
                                            <p><span style="background-color: #ea5e54; color: white; padding: 5px 6px; border-radius: 15px;">refusee</span></p>
                                            <p>{{ $module_request->created_at->format('Y-m-d') }}</p>
                                            <div class="pAlso d-flex align-items-center justify-content-center gap-2">
                                                <input type="number" hidden id="pending_user_id_{{ $module_request['id'] }}" value="{{ $module_request['id'] }}">
                                                <button style="background-color: #4723d9; color: white;" class="btn btn-sm" onclick="showPopup({{ $module_request['id'] }}, '{{ $module_request->target->name }}')"><i class="bi bi-info-square"></i></button>
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

    <!-- Details Popup -->
    @foreach ($module_requests as $module_request)
        <div id="popupfor{{ $module_request['id'] }}" class="overlay">
            <div class="popup">
                <div class="popup-header">
                    <h5>Request Details</h5>
                    <button type="button" class="btn-close" onclick="closePopup({{ $module_request['id'] }})"></button>
                </div>
                <div class="popup-body">
                    <div class="detail-item">
                        <span class="detail-label">Professeur</span>
                        <span class="detail-value">{{ $module_request->prof->firstname }} {{ $module_request->prof->lastname }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Module</span>
                        <span class="detail-value">{{ $module_request->target->name }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Type</span>
                        <span class="detail-value">{{ $module_request->type }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status</span>
                        <span class="detail-value">
                            @if ($module_request->status == 'pending')
                                <span style="background-color: #eaa454; color: white; padding: 5px 6px; border-radius: 15px;">pending</span>
                            @elseif ($module_request->status == 'rejected')
                                <span style="background-color: #ea5e54; color: white; padding: 5px 6px; border-radius: 15px;">refusee</span>
                            @elseif ($module_request->status == 'approved')
                                <span style="background-color: #13ab50; color: white; padding: 5px 6px; border-radius: 15px;">approved</span>
                            @endif
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date</span>
                        <span class="detail-value">{{ $module_request->created_at->format('Y-m-d') }}</span>
                    </div>
                    @if ($module_request->status == 'rejected' && $module_request->rejection_reason)
                        <div class="detail-item">
                            <span class="detail-label">Rejection Reason</span>
                            <span class="detail-value">{{ $module_request->rejection_reason }}</span>
                        </div>
                    @endif
                </div>
                <div class="popup-footer">
                    <button type="button" class="btn btn-primary px-4 rounded-pill" onclick="closePopup({{ $module_request['id'] }})">
                        <i class="bi bi-x-lg me-1"></i>Close
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    // Toggle between tabs
    function toggleSection(sectionId) {
        // Update tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.currentTarget.classList.add('active');
        
        // Show/hide sections
        document.querySelectorAll('.request-section').forEach(section => {
            section.classList.add('hidden');
        });
        document.getElementById(sectionId).classList.remove('hidden');
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

    // Popup functions
    function showPopup(requestId, requestName) {
        document.getElementById('popupfor' + requestId).style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closePopup(requestId) {
        document.getElementById('popupfor' + requestId).style.display = 'none';
        document.body.style.overflow = 'auto';
    }
</script>
</x-chef_layout>
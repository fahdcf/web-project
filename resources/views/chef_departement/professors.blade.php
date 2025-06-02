<x-chef_layout>

<style>
    /* Main Container */
    .professor-container {
        padding: 2rem;
        min-height: 80vh;
    }
    
    /* Header */
       /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.038);

        margin-bottom: 2rem;
    }

    .page-title {
        color: #4723d9;
        font-weight: 600;
        font-size: 1.6rem;
        margin: 0;
    }
    
    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .filter-header {
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .filter-header h5 {
        margin: 0;
        font-weight: 500;
        color: #333;
    }
    
    .filter-header i {
        transition: transform 0.3s ease;
    }
    
    .filter-header.collapsed i {
        transform: rotate(180deg);
    }
    
    .filter-body {
        padding: 1.5rem;
    }
   
  
    
    .filter-group {
        margin-bottom: 0;
    }
    
    .filter-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #555;
    }
    
    .filter-input {
        width: 100%;
        padding: 0.6rem 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    .filter-input:focus {
        border-color: #4723d9;
        box-shadow: 0 0 0 3px rgba(71, 35, 217, 0.1);
        outline: none;
    }
    
    .apply-btn {
        background-color: #4723d9;
        color: white;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        align-self: flex-end;
        grid-column: -1;
    }
    
    .apply-btn:hover {
        background-color: #3a1cb3;
        transform: translateY(-2px);
    }
    
    /* Table Section */
    .table-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .table-responsive {
        overflow-x: auto;
        max-height: 70vh;
        scrollbar-width: thin;
        scrollbar-color: #ccc transparent;
    }
    
    .table-responsive::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background-color: #aaa;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 1100px;
    }
    
    .table thead th {
        background-color: #4723d9;
        color: white;
        padding: 1rem;
        font-weight: 500;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .table tbody tr {
        transition: all 0.2s;
    }
    
    .table tbody tr:hover {
        background-color: #f9f9ff !important;
        transform: translateX(4px);
    }
    
    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        color: #555;
        font-weight: 400;
    }
    
    /* Professor Card Elements */
    .professor-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #eee;
        transition: all 0.3s;
    }
    
    .professor-avatar:hover {
        transform: scale(1.1);
        border-color: #4723d9;
    }
    
    .professor-name {
        font-weight: 500;
        color: #333;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-active {
        background-color: #e6f7ee;
        color: #28a745;
    }
    
    .status-inactive {
        background-color: #fde8e8;
        color: #dc3545;
    }
    
    /* Hours Progress Bar */
    .hours-container {
        min-width: 150px;
    }
    
    .hours-label {
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
        color: #666;
        display: flex;
        justify-content: space-between;
    }
    
    .hours-progress {
        height: 8px;
        background-color: #f0f0f0;
        border-radius: 4px;
        overflow: hidden;
        position: relative;
    }
    
    .hours-filled {
        height: 100%;
        border-radius: 4px;
        position: absolute;
        left: 0;
        top: 0;
    }
    
    .hours-min-marker {
        position: absolute;
        top: 0;
        height: 100%;
        width: 3px;
        background-color: #ff6b6b;
    }
    
    .hours-max-marker {
        position: absolute;
        top: 0;
        height: 100%;
        width: 3px;
        background-color: #4723d9;
    }
    
    /* Action Buttons */
    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    
    .view-btn {
        background-color: #4723d9;
        color: white;
    }
    
    .view-btn:hover {
        background-color: #3a1cb3;
        transform: rotate(5deg);
    }
    
    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        padding: 1.5rem;
    }
    
    .page-btn {
        padding: 0.5rem 1rem;
        margin: 0 0.5rem;
        border-radius: 8px;
        border: 1px solid #ddd;
        background: white;
        color: #333;
        transition: all 0.3s;
    }
    
    .page-btn:hover {
        border-color: #4723d9;
        color: #4723d9;
    }
    
    .page-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .page-btn.active {
        background-color: #4723d9;
        color: white;
        border-color: #4723d9;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #666;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .filter-row {
            grid-template-columns: 1fr;
        }
        
        .apply-btn {
            grid-column: auto;
        }
    }
</style>

<div class="professor-container">
      <div class="page-header bg-white py-3 px-3 rounded">
        <h3 class="page-title"><i class="bi bi-person-video3 pr-2"></i> Professors Directory</h3>
        <!-- export button -->
 <button onclick="exportStyledExcel()" class="btn btn-outline-success " >
    <i class="bi bi-file-excel"></i> Export
</button>
    </div>
    
    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-header" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true">
            <h5>Filters</h5>
            <i class="bi bi-chevron-down"></i>
        </div>
        
        <div class="collapse" id="filterCollapse">
            <div class="filter-body ">
                    <div class="filter-row row g-2">
                        <!-- Search -->
                        <div class="col-12 col-md-4 col-lg-4 filter-group">
                            <label for="search" class="filter-label">Search</label>
                            <input type="text" id="search" name="search" class="filter-input py-2" placeholder="Name, ID or email">
                        </div>
                        
                        <!-- Status Filter -->
                        <div class="col-12 col-md-4 col-lg-2 filter-group">
                            <label for="statusFilter" class="filter-label">Status</label>
                            <select class="filter-input" id="statusFilter" name="status">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        
                        <!-- Hours Filter -->
                        <div class=" col-12 col-md-4 col-lg-2 filter-group">
                            <label for="hoursFilter" class="filter-label">Workload Status</label>
                            <select class="filter-input" id="hoursFilter" name="hours_status">
                                <option value="">All Workloads</option>
                                <option value="under">Below Minimum</option>
                                <option value="adequate">Adequate</option>
                                <option value="over">Above Maximum</option>
                            </select>
                        </div>
                        
                        <!-- Rows Per Page -->
                        <div class=" col-12 col-md-4 col-lg-2 filter-group mb-4 mb-md-0">
                            <label for="rowsPerPage" class="filter-label">Rows per page</label>
                            <select id="rowsPerPage" name="rows" class="filter-input">
                                <option value="all">Show All</option>
                                <option value="5">5</option>
                                <option value="15">15</option>
                                <option value="30">30</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        
                        <button  type="button" id="resetFilters" class="apply-btn col-12 col-md-4 col-lg-2  py-2 " style="background-color: #6c757d;">Reset</button>
                    </div>
            </div>
        </div>
    </div>

    
    <!-- Table Section -->
    <div class="table-section">
        <div class="table-responsive">
            <table class="table" id="exportTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Workload</th>
                        <th>Professor</th>
                        <th>Status</th>
                        <th>Email</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="professorsTableBody">
                    @foreach ($professors as $professor)
                    <tr class="professor-row" 
                        data-id="{{ $professor['id'] }}"
                        data-name="{{ strtolower($professor->lastname . ' ' . $professor->firstname) }}"
                        data-email="{{ strtolower($professor['email']) }}"
                        data-status="{{ $professor->user_details ? $professor->user_details->status : '' }}"
                        data-hours="{{ $professor->user_details ? $professor->user_details->actuelle_hours : 0 }}"
                        data-min-hours="{{ $professor->user_details ? $professor->user_details->min_hours : 0 }}"
                        data-max-hours="{{ $professor->user_details ? $professor->user_details->max_hours : 0 }}">
                        <td>#{{ $professor['id'] }}</td>
                        
                        <td>
                            <a href="{{url('profile/'. $professor->id)}}">
                                @if ($professor->user_details)
                                    @if ($professor->user_details->profile_img!=null)
                                        <img class="professor-avatar" src="{{asset('storage/' . $professor->user_details->profile_img)}}">
                                    @else
                                        <img class="professor-avatar" src="{{asset('storage/images/default_profile_img.png')}}">
                                    @endif
                                @else
                                    <img class="professor-avatar" src="{{asset('storage/images/default_profile_img.png')}}">
                                @endif
                            </a>
                        </td>
                        
                        <td class="hours-container">
                        

                            @php
                                $min = $professor->user_details->min_hours ?? 0;
                                $max = $professor->user_details->max_hours ?? 0;
                                $current = $professor->hours ?? 0;
                                
                                $current_percent = $max > 0 ? round(($current / $max) * 100) : 0;
                                $min_percent = $max > 0 ? round(($min / $max) * 100) : 0;
                                
                                // Determine color based on workload status
                                if ($current < $min) {
                                    $color = '#ff6b6b'; // Red for under minimum
                                } elseif ($current > $max) {
                                    $color = '#ff922b'; // Orange for over maximum
                                } else {
                                    $color = '#51cf66'; // Green for adequate
                                }
                            @endphp
                            
                            <div class="hours-label">
                                <span>{{ $current }}h</span>
                                <span>Min: {{ $min }}h / Max: {{ $max }}h</span>
                            </div>
                            
                            <div class="hours-progress">
                                <div class="hours-filled" style="width: {{ $current_percent }}%; background-color: {{ $color }};"></div>
                                <div class="hours-min-marker" style="left: {{ $min_percent }}%;"></div>
                                <div class="hours-max-marker" style="left: 100%;"></div>
                            </div>
                        </td>
                        
                        <td class="professor-name">{{ $professor->lastname }} {{ $professor->firstname }}</td>
                        
                        <td>
                            @if ($professor->user_details)
                                <span class="status-badge status-{{ $professor->user_details->status }}">
                                    {{ ucfirst($professor->user_details->status) }}
                                </span>
                            @else
                                <span class="status-badge">Unknown</span>
                            @endif
                        </td>
                        
                        <td>{{ $professor['email'] }}</td>
                        
                        <td>{{ $professor->created_at->format('Y-m-d') }}</td>
                        
                        <td class="p-0">
                            <div class="d-flex justify-content-center gap-3">

                                <a href="{{url('chef/professeur_profile/'. $professor->id)}}" class="action-btn view-btn" title="View Profile">
                                    <i class="bi bi-file-earmark-plus"></i>
                                    
                                </a>
                                
                                <a href="{{url('chef/professeur_profile/'. $professor->id)}}" class="action-btn view-btn" title="View Profile">
                            <i class="bi bi-person-square"></i>

                        </a>
                     </div>


                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination will be handled client-side -->
        <div id="paginationControls" class="pagination">
            <!-- Will be populated by JavaScript -->
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
function exportStyledExcel() {
    const table = document.getElementById("exportTable");
    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet("Professors");

    // Extract headers
    const headers = [];
    const headerRow = table.rows[0];
    for (let i = 0; i < headerRow.cells.length; i++) {
        if (i !== 1 && i !== headerRow.cells.length - 1) { // skip Photo and Actions
            headers.push(headerRow.cells[i].innerText);
        }
    }
    worksheet.addRow(headers);

    // Style header
    worksheet.getRow(1).eachCell(cell => {
        cell.font = { bold: true, color: { argb: 'FFFFFFFF' } };
        cell.fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: '4F81BD' } // Blue
        };
        cell.alignment = { horizontal: 'center' };
    });

    // Data rows
    for (let i = 1; i < table.rows.length; i++) {
        const row = table.rows[i];
        const rowData = [];
        for (let j = 0; j < row.cells.length; j++) {
            if (j !== 1 && j !== row.cells.length - 1) { // skip Photo and Actions
                rowData.push(row.cells[j].innerText);
            }
        }
        const newRow = worksheet.addRow(rowData);

        // Apply conditional color to "Status" column (assuming it's 4th after removing Photo)
        const status = newRow.getCell(4);
        if (status.value === "Active") {
            status.font = { color: { argb: 'FF00AA00' } }; // Green
        } else if (status.value === "Inactive") {
            status.font = { color: { argb: 'FFAA0000' } }; // Red
        }
        status.alignment = { horizontal: 'center' };
    }

    // Set column widths
    worksheet.columns = [
        { width: 10 }, // ID
        { width: 25 }, // Workload
        { width: 20 }, // Professor
        { width: 15 }, // Status
        { width: 30 }, // Email
        { width: 15 }  // Created
    ];

    // Export the file
    workbook.xlsx.writeBuffer().then((buffer) => {
        const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
        saveAs(blob, "Professors_Styled.xlsx");
    });
}


</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const searchInput = document.getElementById('search');
    const statusFilter = document.getElementById('statusFilter');
    const hoursFilter = document.getElementById('hoursFilter');
    const rowsPerPage = document.getElementById('rowsPerPage');
    const resetBtn = document.getElementById('resetFilters');
    const tableBody = document.getElementById('professorsTableBody');
    const paginationControls = document.getElementById('paginationControls');
    const professorRows = document.querySelectorAll('.professor-row');
    
    // Current pagination state
    let currentPage = 1;
    let rowsPerPageValue = parseInt(rowsPerPage.value) || professorRows.length;
    
    // Initialize
    updatePaginationControls();
    filterProfessors();
    
    // Event listeners for filters
    searchInput.addEventListener('input', function() {
        currentPage = 1;
        filterProfessors();
    });
    
    statusFilter.addEventListener('change', function() {
        currentPage = 1;
        filterProfessors();
    });
    
    hoursFilter.addEventListener('change', function() {
        currentPage = 1;
        filterProfessors();
    });
    
    rowsPerPage.addEventListener('change', function() {
        currentPage = 1;
        rowsPerPageValue = this.value === 'all' ? professorRows.length : parseInt(this.value);
        filterProfessors();
        updatePaginationControls();
    });
    
    resetBtn.addEventListener('click', function() {
        searchInput.value = '';
        statusFilter.value = '';
        hoursFilter.value = '';
        rowsPerPage.value = 'all';
        currentPage = 1;
        rowsPerPageValue = professorRows.length;
        filterProfessors();
        updatePaginationControls();
    });
    
    // Filter professors based on criteria
    function filterProfessors() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const hoursValue = hoursFilter.value;
        
        let visibleCount = 0;
        
        professorRows.forEach(row => {
            const name = row.dataset.name;
            const email = row.dataset.email;
            const id = row.dataset.id;
            const status = row.dataset.status;
            const currentHours = parseFloat(row.dataset.hours);
            const minHours = parseFloat(row.dataset.minHours);
            const maxHours = parseFloat(row.dataset.maxHours);
            
            // Check search term
            const matchesSearch = searchTerm === '' || 
                name.includes(searchTerm) || 
                email.includes(searchTerm) || 
                id.includes(searchTerm);
            
            // Check status
            const matchesStatus = statusValue === '' || status === statusValue;
            
            // Check hours
            let matchesHours = true;
            if (hoursValue === 'under') {
                matchesHours = currentHours < minHours;
            } else if (hoursValue === 'adequate') {
                matchesHours = currentHours >= minHours && currentHours <= maxHours;
            } else if (hoursValue === 'over') {
                matchesHours = currentHours > maxHours;
            }
            
            // Show/hide row based on filters
            if (matchesSearch && matchesStatus && matchesHours) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update pagination
        updatePaginationControls(visibleCount);
        showPage(currentPage);
    }
    
    // Update pagination controls
    function updatePaginationControls(totalRows = professorRows.length) {
        if (rowsPerPageValue === 'all' || rowsPerPageValue >= totalRows) {
            paginationControls.style.display = 'none';
            return;
        }
        
        paginationControls.style.display = 'flex';
        const pageCount = Math.ceil(totalRows / rowsPerPageValue);
        
        let paginationHTML = '';
        
        // Previous button
        if (currentPage > 1) {
            paginationHTML += `<button class="page-btn" onclick="changePage(${currentPage - 1})">Previous</button>`;
        } else {
            paginationHTML += `<button class="page-btn disabled">Previous</button>`;
        }
        
        // Page numbers
        for (let i = 1; i <= pageCount; i++) {
            if (i === currentPage) {
                paginationHTML += `<button class="page-btn active">${i}</button>`;
            } else {
                paginationHTML += `<button class="page-btn" onclick="changePage(${i})">${i}</button>`;
            }
        }
        
        // Next button
        if (currentPage < pageCount) {
            paginationHTML += `<button class="page-btn" onclick="changePage(${currentPage + 1})">Next</button>`;
        } else {
            paginationHTML += `<button class="page-btn disabled">Next</button>`;
        }
        
        paginationControls.innerHTML = paginationHTML;
    }
    
    // Show specific page of results
    function showPage(page) {
        const visibleRows = Array.from(professorRows).filter(row => row.style.display !== 'none');
        
        if (rowsPerPageValue === 'all') {
            visibleRows.forEach(row => row.style.display = '');
            return;
        }
        
        const startIdx = (page - 1) * rowsPerPageValue;
        const endIdx = startIdx + rowsPerPageValue;
        
        visibleRows.forEach((row, index) => {
            if (index >= startIdx && index < endIdx) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // Change page (exposed to global scope for button onclick)
    window.changePage = function(page) {
        currentPage = page;
        filterProfessors();
    };
    
    // Initialize workload colors
    document.querySelectorAll('.hours-filled').forEach(bar => {
        const percent = parseInt(bar.style.width);
        const minMarker = bar.parentElement.querySelector('.hours-min-marker');
        const minPercent = parseInt(minMarker.style.left);
        
        if (percent < minPercent) {
            bar.style.backgroundColor = '#ff6b6b'; // Under minimum
        } else if (percent > 95) {
            bar.style.backgroundColor = '#ff922b'; // Approaching or over max
        } else {
            bar.style.backgroundColor = '#51cf66'; // Adequate
        }
    });
});
</script>



<script>
    function showPopup(professorId, professorName) {
        document.getElementById('professorName').innerText=professorName;
        var professorIdInput = document.getElementById('professor_id');
        professorIdInput.value=professorId;
        var form = document.getElementById('popupForm');
        form.action = "{{ url('/professors') }}/" + professorId;
        
        document.getElementById("overlay").style.display = "flex";
    }

    function closePopup(){
        document.getElementById("overlay").style.display = "none";
    }
</script>

</x-chef_layout>
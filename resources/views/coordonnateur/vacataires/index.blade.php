<x-coordonnateur_layout>

<style>
    /* Main Container */
    .professor-container {
        padding: 2rem;
        min-height: 80vh;
    }
    
    /* Header */
    .header-grid {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 1rem;
        align-items: center;
        margin-bottom: 2rem;
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

    /* Buttons */
    .btn-primary {
        background-color: #4723d9;
        border-color: #4723d9;
        font-size: 0.9rem;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background-color: white;
        color: #4723d9;
        border-color: #4723d9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        font-size: 0.9rem;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-success:hover {
        background-color: white;
        color: #28a745;
        border-color: #28a745;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        font-size: 0.9rem;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-danger:hover {
        background-color: white;
        color: #dc3545;
        border-color: #dc3545;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .dropdown-menu {
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #4723d9;
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

    .delete-btn {
        background-color: #dc3545;
        color: white;
    }

    .delete-btn:hover {
        background-color: #c82333;
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

        .header-grid {
            grid-template-columns: 1fr;
        }

        .header-grid .d-flex.gap-2 {
            justify-content: center;
        }
    }
</style>

<div class="professor-container">
    <div class="header-grid">
        <div class="d-flex align-items-center gap-3">
            <i class="fas fa-user-graduate fa-2x" style="color: #330bcf;"></i>
            <h3 style="color: #330bcf; font-weight: 500;">Gestion des Vacataires</h3>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('coordonnateur.vacataires.create') }}"
                class="btn btn-primary rounded fw-semibold">
                <i class="fas fa-plus-circle"></i> Ajouter un compte vacataire
            </a>
            <div class="dropdown">
                <button class="btn btn-success rounded fw-semibold dropdown-toggle" type="button"
                    id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-export"></i> Exporter
                </button>
                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('coordonnateur.vacataires.export') }}">
                            Tous les Vacataires
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-header" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true">
            <h5>Filtres</h5>
            <i class="bi bi-chevron-down"></i>
        </div>
        
        <div class="collapse show" id="filterCollapse">
            <div class="filter-body">
                <div class="filter-row row g-2">
                    <!-- Search -->
                    <div class="col-12 col-md-4 col-lg-4 filter-group">
                        <label for="search" class="filter-label">Recherche</label>
                        <input type="text" id="search" name="search" class="filter-input py-2" placeholder="Nom, ID ou email">
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="col-12 col-md-4 col-lg-2 filter-group">
                        <label for="statusFilter" class="filter-label">Statut</label>
                        <select class="filter-input" id="statusFilter" name="status">
                            <option value="">Tous les statuts</option>
                            <option value="active">Actif</option>
                            <option value="inactive">Inactif</option>
                        </select>
                    </div>
                    
                   
                    
                 
                    <button type="button" id="resetFilters" class="apply-btn col-12 col-md-4 col-lg-2 py-2" style="background-color: #6c757d;">
                        Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-responsive">
            <table class="table" id="vacatairesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Charge de travail</th>
                        <th>Professeur</th>
                        <th>Statut</th>
                        <th>Email</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="vacatairesTableBody">
                    @foreach ($vacataires as $vacataire)
                    <tr class="professor-row" 
                        data-id="{{ $vacataire['id'] }}"
                        data-name="{{ strtolower($vacataire->lastname . ' ' . $vacataire->firstname) }}"
                        data-email="{{ strtolower($vacataire['email']) }}"
                        data-status="{{ $vacataire->user_details ? $vacataire->user_details->status : '' }}"
                        data-hours="{{ $vacataire->user_details ? $vacataire->user_details->actuelle_hours : 0 }}"
                        data-min-hours="{{ $vacataire->user_details ? $vacataire->user_details->min_hours : 0 }}"
                        data-max-hours="{{ $vacataire->user_details ? $vacataire->user_details->max_hours : 0 }}">
                        <td>#{{ $vacataire['id'] }}</td>
                        
                        <td>
                            <a href="{{ url('profile/' . $vacataire->id) }}">
                                @if ($vacataire->user_details && $vacataire->user_details->profile_img)
                                    <img class="professor-avatar" src="{{ asset('storage/' . $vacataire->user_details->profile_img) }}">
                                @else
                                    <img class="professor-avatar" src="{{ asset('storage/images/default_profile_img.png') }}">
                                @endif
                            </a>
                        </td>
                        
                        <td class="hours-container">
                            @php
                                $min = $vacataire->user_details->min_hours ?? 0;
                                $max = $vacataire->user_details->max_hours ?? 0;
                                $current = $vacataire->hours ?? 0;
                                
                                $current_percent = $max > 0 ? round(($current / $max) * 100) : 0;
                                $min_percent = $max > 0 ? round(($min / $max) * 100) : 0;
                                
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
                        
                        <td class="professor-name">{{ $vacataire->lastname }} {{ $vacataire->firstname }}</td>
                        
                        <td>
                            @if ($vacataire->user_details)
                                <span class="status-badge status-{{ $vacataire->user_details->status }}">
                                    {{ ucfirst($vacataire->user_details->status) }}
                                </span>
                            @else
                                <span class="status-badge">Inconnu</span>
                            @endif
                        </td>
                        
                        <td>{{ $vacataire['email'] }}</td>
                        
                        <td>{{ $vacataire->created_at->format('Y-m-d') }}</td>
                        
                        <td class="p-0">
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('coordonnateur.vacataire.assignemts_profile', $vacataire->id) }}" class="action-btn view-btn" title="Voir le profil">
                                    <i class="bi bi-file-earmark-plus"></i>
                                </a>
                                <a href="{{ url('profile/' . $vacataire->id) }}" class="action-btn view-btn" title="Voir le profil">
                                    <i class="bi bi-person-square"></i>
                                </a>
                                <form action="{{ route('coordonnateur.vacataires.destroy', $vacataire->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn" title="Supprimer"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce vacataire ?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div id="paginationControls" class="pagination">
            <!-- Populated by JavaScript -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const searchInput = document.getElementById('search');
    const statusFilter = document.getElementById('statusFilter');
    const hoursFilter = document.getElementById('hoursFilter');
    const rowsPerPage = document.getElementById('rowsPerPage');
    const resetBtn = document.getElementById('resetFilters');
    const tableBody = document.getElementById('vacatairesTableBody');
    const paginationControls = document.getElementById('paginationControls');
    const vacataireRows = document.querySelectorAll('.professor-row');
    
    // Current pagination state
    let currentPage = 1;
    let rowsPerPageValue = parseInt(rowsPerPage.value) || vacataireRows.length;
    
    // Initialize
    updatePaginationControls();
    filterVacataires();
    
    // Event listeners for filters
    searchInput.addEventListener('input', function() {
        currentPage = 1;
        filterVacataires();
    });
    
    statusFilter.addEventListener('change', function() {
        currentPage = 1;
        filterVacataires();
    });
    
    hoursFilter.addEventListener('change', function() {
        currentPage = 1;
        filterVacataires();
    });
    
    rowsPerPage.addEventListener('change', function() {
        currentPage = 1;
        rowsPerPageValue = this.value === 'all' ? vacataireRows.length : parseInt(this.value);
        filterVacataires();
        updatePaginationControls();
    });
    
    resetBtn.addEventListener('click', function() {
        searchInput.value = '';
        statusFilter.value = '';
        hoursFilter.value = '';
        rowsPerPage.value = 'all';
        currentPage = 1;
        rowsPerPageValue = vacataireRows.length;
        filterVacataires();
        updatePaginationControls();
    });
    
    // Filter vacataires based on criteria
    function filterVacataires() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const hoursValue = hoursFilter.value;
        
        let visibleCount = 0;
        
        vacataireRows.forEach(row => {
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
    function updatePaginationControls(totalRows = vacataireRows.length) {
        if (rowsPerPageValue === 'all' || rowsPerPageValue >= totalRows) {
            paginationControls.style.display = 'none';
            return;
        }
        
        paginationControls.style.display = 'flex';
        const pageCount = Math.ceil(totalRows / rowsPerPageValue);
        
        let paginationHTML = '';
        
        // Previous button
        if (currentPage > 1) {
            paginationHTML += `<button class="page-btn" onclick="changePage(${currentPage - 1})">Précédent</button>`;
        } else {
            paginationHTML += `<button class="page-btn disabled">Précédent</button>`;
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
            paginationHTML += `<button class="page-btn" onclick="changePage(${currentPage + 1})">Suivant</button>`;
        } else {
            paginationHTML += `<button class="page-btn disabled">Suivant</button>`;
        }
        
        paginationControls.innerHTML = paginationHTML;
    }
    
    // Show specific page of results
    function showPage(page) {
        const visibleRows = Array.from(vacataireRows).filter(row => row.style.display !== 'none');
        
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
    
    // Change page
    window.changePage = function(page) {
        currentPage = page;
        filterVacataires();
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

</x-coordonnateur_layout>
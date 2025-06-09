
<x-admin_layout>
<head>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
</head>

<style>
  /* Main Container */
  .professor-container {
    padding: 2rem;
    padding-top:5rem !important; 
    min-height: 80vh;
    font-family: 'Inter', sans-serif;
    background-color: #f7f7fb;
  }

  /* Header */
  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
  }

  .page-title {
    color: #4723d9;
    font-weight: 600;
    font-size: 1.8rem;
    margin: 0;
  }

  .btn-outline-success {
    border: 1px solid #28a745;
    color: #28a745;
    background-color: transparent;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s;
  }

  .btn-outline-success:hover {
    background-color: #28a745;
    color: white;
    transform: translateY(-2px);
  }

  .btn-primary {
    background-color: #4723d9;
    color: white;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s;
    text-decoration: none;
  }

  .btn-primary:hover {
    background-color: #3a1cb3;
    transform: translateY(-2px);
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
    font-size: 0.95rem;
    color: #333;
    transition: all 0.3s;
  }

  .filter-input:focus {
    border-color: #4723d9;
    box-shadow: 0 0 0 3px rgba(71, 35, 217, 0.1);
    outline: none;
  }

  .apply-btn {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 0.7rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s;
    align-self: flex-end;
  }

  .apply-btn:hover {
    background-color: #5a6268;
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
    font-weight: bold;
    position: sticky;
    top: 0;
    z-index: 2;
    text-align: center;
    border-bottom: none;
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
    border-bottom: 1px solid #f3f3f0;
    color: #555;
    font-weight: 400;
    text-align: center;
  }

  /* Professor Card Elements */
  .professor-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #eee;
    transition: all 0.3s;
  }

  .professor-img:hover {
    transform: scale(1.1);
    border-color: #4723d9;
  }

  .status {
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

  /* Action Buttons */
  .action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    border: none;
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

  /* Modal */
  .modal-content {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }

  .modal-header {
    border-bottom: none;
    padding: 1.5rem;
  }

  .modal-title {
    font-weight: 600;
    color: #333;
  }

  .modal-body {
    padding: 1.5rem;
    color: #555;
  }

  .modal-footer {
    border-top: none;
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
  }

  .btn-secondary {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
  }

  .btn-secondary:hover {
    background-color: #5a6268;
  }

  .btn-danger {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
  }

  .btn-danger:hover {
    background-color: #c82333;
  }

  /* Overlay */
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
    padding: 2rem;
    border-radius: 12px;
    width: 400px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }

  .popup h5 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 1.5rem;
  }

  .popup .form-group {
    margin-bottom: 1.5rem;
  }

  .popup label {
    font-size: 0.9rem;
    font-weight: 500;
    color: #555;
    margin-bottom: 0.5rem;
    display: block;
    text-align: left;
  }

  .popup input,
  .popup select {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 0.95rem;
    color: #333;
  }

  .popup input:focus,
  .popup select:focus {
    border-color: #4723d9;
    box-shadow: 0 0 0 3px rgba(71, 35, 217, 0.1);
    outline: none;
  }

  .popup .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 1.5rem;
  }

  .popup .btn {
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    font-weight: 500;
    border: none;
  }
</style>

<div class="professor-container pt-0">
  <div class="page-header pt-0">
    <h1 class="page-title">Liste des professeurs</h1>
    <div class="d-flex gap-3">
      <button onclick="exportStyledExcel()" class="btn btn-outline-success">
        <i class="bi bi-file-excel"></i> Exporter
      </button>
      <a href="{{url('professeurs/add')}}" class="btn btn-primary">Ajouter un professeur</a>
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
            <label for="searchInput" class="filter-label">Recherche</label>
            <input type="text" id="searchInput" class="filter-input py-2" placeholder="Nom, ID ou email">
          </div>
          <!-- Department Filter -->
          <div class="col-12 col-md-4 col-lg-2 filter-group">
            <label for="departementFilter" class="filter-label">Département</label>
            <select class="filter-input" id="departementFilter">
              <option value="">Tous les départements</option>
              @foreach ($Departements as $Departement)
                <option value="{{ $Departement->name }}">{{ $Departement->name }}</option>
              @endforeach
            </select>
          </div>
          <!-- Status Filter -->
          <div class="col-12 col-md-4 col-lg-2 filter-group">
            <label for="statusFilter" class="filter-label">Statut</label>
            <select class="filter-input" id="statusFilter">
              <option value="">Tous les statuts</option>
              <option value="active">Actif</option>
              <option value="inactive">Inactif</option>
            </select>
          </div>
          <!-- Rows Per Page -->
          <div class="col-12 col-md-4 col-lg-2 filter-group mb-4 mb-md-0">
            <label for="rowsPerPage" class="filter-label">Lignes par page</label>
            <select id="rowsPerPage" class="filter-input">
              <option value="all">Tout afficher</option>
              <option value="5">5</option>
              <option value="15">15</option>
              <option value="30">30</option>
              <option value="100">100</option>
            </select>
          </div>
          <button type="button" id="resetFilters" class="apply-btn col-12 col-md-4 col-lg-2 py-2">Réinitialiser</button>
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
            <th>Nom complet</th>
            <th>Statut</th>
            <th>Email</th>
            <th>Date de création</th>
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
                data-departement="{{ $professor->departement ? $professor->departement : '' }}">
              <td>{{ $professor['id'] }}</td>
              <td>
                <a href="{{url('profile/'. $professor->id)}}">
                  @if ($professor->user_details)
                    @if ($professor->user_details->profile_img!=null)
                      <img class="professor-img" src="{{asset('storage/' . $professor->user_details->profile_img)}}">
                    @else
                      <img class="professor-img" src="{{asset('storage/images/default_profile_img.png')}}">
                    @endif
                  @else
                    <img class="professor-img" src="{{asset('storage/images/default_profile_img.png')}}">
                  @endif
                </a>
              </td>
              <td class="professor-name">{{ $professor->lastname }} {{ $professor->firstname }}</td>
              <td>
                @if ($professor->user_details)
                  <span class="status status-{{ $professor->user_details->status }}">
                    {{ ucfirst($professor->user_details->status == 'active' ? 'Actif' : 'Inactif') }}
                  </span>
                @else
                  <span class="status">Aucun</span>
                @endif
              </td>
              <td>{{ $professor['email'] }}</td>
              <td>{{ $professor->created_at->format('Y-m-d') }}</td>
              <td>
                <div class="d-flex justify-content-center gap-3">
                  <a href="{{url('profile/'. $professor->id)}}" class="action-btn view-btn" title="Modifier le profil">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <button class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal_{{$professor['id']}}" title="Désactiver le professeur">
                    <i class="bi bi-trash3"></i>
                  </button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- Modals for Delete Confirmation -->
    @foreach ($professors as $professor)
      <div class="modal fade" id="deleteModal_{{$professor['id']}}" tabindex="-1" aria-labelledby="deleteModalLabel_{{$professor['id']}}" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel_{{$professor['id']}}">Confirmer la désactivation</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Voulez-vous désactiver le compte du professeur <strong>{{$professor['lastname']}}</strong> ?</p>
              <form action="{{ url('/professeurs/' . $professor['id']) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fermer</button>
                  <button type="submit" class="btn btn-danger btn-sm">Désactiver</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endforeach
    <div id="paginationControls" class="pagination"></div>
  </div>

  <!-- Overlay -->
  <div id="overlay" class="overlay">
    <div class="popup">
      <h5>Modifier le professeur <span id="professorName"></span></h5>
      <form id="popupForm" action="" method="POST">
        @csrf
        @method('PATCH')
        <input hidden type="text" id="professor_id" name="professor_id">
        <div class="form-group">
          <label for="name">Nom du département</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Informatique">
        </div>
        <div class="form-group">
          <label for="professor">Chef de département</label>
          <select class="form-control" id="professor" name="user_id">
            <option value="">-- Sélectionner un professeur --</option>
            @foreach ($professors as $professor)
              <option value="{{ $professor->id }}">{{ $professor->lastname }} {{ $professor->firstname }}</option>
            @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closePopup()">Fermer</button>
          <button type="submit" class="btn btn-success">Mettre à jour</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Debounce function to limit filter execution
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Filter and pagination logic
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const departementFilter = document.getElementById('departementFilter');
  const statusFilter = document.getElementById('statusFilter');
  const rowsPerPage = document.getElementById('rowsPerPage');
  const resetBtn = document.getElementById('resetFilters');
  const tableBody = document.getElementById('professorsTableBody');
  const paginationControls = document.getElementById('paginationControls');
  const professorRows = document.querySelectorAll('.professor-row');

  let currentPage = 1;
  let rowsPerPageValue = rowsPerPage.value === 'all' ? professorRows.length : parseInt(rowsPerPage.value);

  updatePaginationControls();
  filterProfessors();

  searchInput.addEventListener('input', debounce(function() {
    currentPage = 1;
    filterProfessors();
  }, 300));

  departementFilter.addEventListener('change', function() {
    currentPage = 1;
    filterProfessors();
  });

  statusFilter.addEventListener('change', function() {
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
    departementFilter.value = '';
    statusFilter.value = '';
    rowsPerPage.value = 'all';
    currentPage = 1;
    rowsPerPageValue = professorRows.length;
    filterProfessors();
    updatePaginationControls();
  });

  function filterProfessors() {
    const searchTerm = searchInput.value.toLowerCase();
    const departementValue = departementFilter.value;
    const statusValue = statusFilter.value;
    let visibleCount = 0;

    professorRows.forEach(row => {
      const id = row.dataset.id;
      const name = row.dataset.name;
      const email = row.dataset.email;
      const status = row.dataset.status;
      const departement = row.dataset.departement;

      const matchesSearch = !searchTerm || 
        id.includes(searchTerm) || 
        name.includes(searchTerm) || 
        email.includes(searchTerm);
      const matchesDepartement = !departementValue || departement === departementValue;
      const matchesStatus = !statusValue || status === statusValue;

      if (matchesSearch && matchesDepartement && matchesStatus) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    updatePaginationControls(visibleCount);
    showPage(currentPage);
  }

  function updatePaginationControls(totalRows = professorRows.length) {
    if (rowsPerPageValue === 'all' || rowsPerPageValue >= totalRows) {
      paginationControls.style.display = 'none';
      return;
    }

    paginationControls.style.display = 'flex';
    const pageCount = Math.ceil(totalRows / rowsPerPageValue);
    let paginationHTML = '';

    if (currentPage > 1) {
      paginationHTML += `<button class="page-btn" onclick="changePage(${currentPage - 1})">Précédent</button>`;
    } else {
      paginationHTML += `<button class="page-btn disabled">Précédent</button>`;
    }

    for (let i = 1; i <= pageCount; i++) {
      paginationHTML += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
    }

    if (currentPage < pageCount) {
      paginationHTML += `<button class="page-btn" onclick="changePage(${currentPage + 1})">Suivant</button>`;
    } else {
      paginationHTML += `<button class="page-btn disabled">Suivant</button>`;
    }

    paginationControls.innerHTML = paginationHTML;
  }

  function showPage(page) {
    const visibleRows = Array.from(professorRows).filter(row => row.style.display !== 'none');
    if (rowsPerPageValue === 'all') {
      visibleRows.forEach(row => row.style.display = '');
      return;
    }

    const startIdx = (page - 1) * rowsPerPageValue;
    const endIdx = startIdx + rowsPerPageValue;

    visibleRows.forEach((row, index) => {
      row.style.display = index >= startIdx && index < endIdx ? '' : 'none';
    });
  }

  window.changePage = function(page) {
    currentPage = page;
    filterProfessors();
  };
});

// Excel export
function exportStyledExcel() {
  const table = document.getElementById("exportTable");
  const workbook = new ExcelJS.Workbook();
  const worksheet = workbook.addWorksheet("Professeurs");

  // Headers
  const headers = ['ID', 'Nom complet', 'Statut', 'Email', 'Date de création'];
  worksheet.addRow(headers);

  // Style header
  worksheet.getRow(1).eachCell(cell => {
    cell.font = { bold: true, color: { argb: 'FFFFFFFF' } };
    cell.fill = {
      type: 'pattern',
      pattern: 'solid',
      fgColor: { argb: '4F81BD' }
    };
    cell.alignment = { horizontal: 'center' };
  });

  // Data rows
  const rows = table.querySelectorAll('tbody tr');
  rows.forEach(row => {
    if (row.style.display !== 'none') {
      const rowData = [
        row.cells[0].innerText, // ID
        row.cells[2].innerText, // Nom complet
        row.cells[3].querySelector('.status')?.innerText || 'Aucun', // Statut
        row.cells[4].innerText, // Email
        row.cells[5].innerText  // Date de création
      ];
      const newRow = worksheet.addRow(rowData);
      const statusCell = newRow.getCell(3);
      if (statusCell.value === 'Actif') {
        statusCell.font = { color: { argb: 'FF00AA00' } };
      } else if (statusCell.value === 'Inactif') {
        statusCell.font = { color: { argb: 'FFAA0000' } };
      }
      statusCell.alignment = { horizontal: 'center' };
    }
  });

  // Set column widths
  worksheet.columns = [
    { width: 10 }, // ID
    { width: 20 }, // Nom complet
    { width: 15 }, // Statut
    { width: 30 }, // Email
    { width: 15 }  // Date de création
  ];

  // Export
  workbook.xlsx.writeBuffer().then((buffer) => {
    const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
    saveAs(blob, "Professeurs_Styled.xlsx");
  });
}

// Popup functions
function showPopup(professorId, professorName) {
  document.getElementById('professorName').innerText = professorName;
  document.getElementById('professor_id').value = professorId;
  document.getElementById('popupForm').action = "{{ url('/professors') }}/" + professorId;
  document.getElementById('overlay').style.display = 'flex';
}

function closePopup() {
  document.getElementById('overlay').style.display = 'none';
}
</script>
</x-admin_layout>
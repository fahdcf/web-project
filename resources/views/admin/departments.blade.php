<x-admin_layout>
<head>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
</head>

<div class="requests-container">
  <!-- Header -->
  <div class="header-grid pt-3">
    <div class="d-flex align-items-center gap-3">
      <i class="fas fa-book-open fa-2x" style="color: #330bcf;"></i>
      <h3 style="color: #330bcf; font-weight: 500;">Gestion des Départements</h3>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <button onclick="exportStyledExcel()" class="btn btn-outline-success">
        <i class="bi bi-file-excel"></i> Export
      </button>
      <a href="{{ url('departements/add') }}" class="btn btn-primary rounded fw-semibold">
        <i class="fas fa-plus-circle"></i> Ajouter un nouveau département
      </a>
    </div>
  </div>

  <!-- Search -->
  <div class="d-flex justify-content-start mb-4">
    <div class="search-container">
      <i class="bi bi-search search-icon pl-2"></i>
      <input type="text" id="searchInput" class="form-control search-inputt pl-2" placeholder="Rechercher par chef de département...">
    </div>
  </div>

  <!-- Overlay -->
  <div id="overlay" class="overlay">
    <div class="popup">
      <h5 style="color: #202020">Modifier le département <span id="departementName"></span></h5>
      <form id="popupForm" action="" method="POST">
        @csrf
        @method('PATCH')
        <input hidden type="text" id="departement_id" name="departement_id">
        <div class="mb-4">
          <label style="color:#515151; width: 100%; font-weight: 700; text-align: start;" for="name" class="mt-4 form-label fw-bold">Nom du Département</label>
          <input style="color:#202020" type="text" class="form-control rounded" id="name" name="name" placeholder="Ex: Informatique">
        </div>
        <!-- Select Professor -->
        <div class="mb-4 d-flex flex-column">
          <label style="color:#515151; width: 100%; font-weight: 700; text-align: start;" for="professor" class="form-label fw-bold">Chef de Département</label>
          <select style="border-color:#3028893b;" class="form-select py-2 rounded" id="professor" name="user_id">
            <option value="">-- Sélectionner un professeur --</option>
            @foreach ($professors as $professor)
              <option value="{{ $professor->id }}">{{ $professor->lastname }} {{ $professor->firstname }}</option>
            @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" onclick="closePopup()">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Update</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Table -->
  <section class="table-container">
    <div class="table-responsive mt-4">
      <table class="table table-borderless" id="exportTable">
        <thead>
          <tr style="color: #535050; font-weight: 600; font-size: 15px;">
            <th>Name</th>
            <th>Chef de département</th>
            <th>Date de création</th>
            <th class="pAlso">Action</th>
          </tr>
        </thead>
        <tbody id="departementTableBody">
          @foreach ($departements as $departement)
            <tr class="departement-row" 
                data-id="{{ $departement->id }}"
                data-name="{{ strtolower($departement->name) }}"
                data-chef="{{ $departement->chef ? strtolower($departement->chef->firstname.' '.$departement->chef->lastname) : 'non associé' }}">
              <td colspan="6" style="padding: 0;">
                <div class="custom-row-wrapper" style="width: 100%;">
                  <div class="custom-row d-flex" style="width: 100%;">
                    <p>{{ $departement->name }}</p>
                    @if ($departement->chef)
                      <p>{{ $departement->chef->firstname }} {{ $departement->chef->lastname }}</p>
                    @else
                      <p><span style="background-color: #ea5455; color: white; padding: 4px 5px; border-radius: 15px;">Non associé</span></p>
                    @endif
                    <p>{{ $departement->created_at->format('Y-m-d') }}</p>
                    <div class="pAlso d-flex align-items-center gap-2">
                      <input type="number" hidden id="pending_user_id_{{ $departement->id }}" value="{{ $departement->id }}">
                      <button style="background-color: #4723d9; color: white;" class="btn btn-sm" onclick="showPopup({{ $departement->id }}, '{{ $departement->name }}')" data-bs-toggle="modal" data-bs-target="#Modalformodifying"><i class="bi bi-pencil-square"></i></button>
                      <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#Modalforid{{ $departement->id }}"><i class="bi bi-trash3"></i></button>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="Modalforid{{ $departement->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>Vous voulez supprimer le département <strong>{{ $departement->name }}</strong> définitivement?</p>
                    <form action="{{ url('/departements/' . $departement->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>

  <style>
    /* Main Container */
    .requests-container {
      padding: 2rem;
      min-height: 100vh;
      background-color: #f7f7fb;
      font-family: 'Inter', sans-serif;
    }

    /* Header */
    .header-grid {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .btn-primary,
    .btn-outline-success {
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      font-weight: 500;
      font-size: 0.95rem;
      line-height: 1.5;
      height: 38px;
      transition: all 0.3s;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      box-sizing: border-box;
    }

    .btn-primary {
      background-color: #4723d9;
      color: white;
    }

    .btn-primary:hover {
      background-color: #3a1cb3;
      transform: translateY(-2px);
    }

    .btn-outline-success {
      border: 1px solid #28a745;
      color: #28a745;
      background-color: transparent;
    }

    .btn-outline-success:hover {
      background-color: #28a745;
      color: white;
      transform: translateY(-2px);
    }

    /* Search */
    .search-container {
      padding: 0 !important;
      min-width: 250px;
      max-width: 350px;
      border: 1px solid #4723d9;
      border-radius: 8px;
      display: flex;
      align-items: center;
      background-color: white;
    }

    .search-inputt {
      font-size: 14px;
      padding-left: 35px;
      border-radius: 8px;
      border: none;
      transition: all 0.3s;
      color: #270e8c !important;
      background: none;
    }

    .search-inputt::placeholder {
      color: #4723d99b !important;
    }

    .search-inputt:focus {
      border: none !important;
      box-shadow: none !important;
      outline: none;
      background: none;
    }

    .search-icon {
      color: #4723d9;
      margin-left: 10px;
    }

    /* Table Container */
    .table-container {
      padding: 20px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .table-responsive {
      border-radius: 6px;
      width: 100%;
      overflow-x: auto;
    }

    table {
      max-width: 1250px;
      margin: 0 auto;
    }

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

    .custom-row p {
      color: #3f3f3f;
      font-weight: 500;
    }

    .custom-row p, .pAlso {
      text-align: center;
      min-width: 200px;
      padding: 0.75rem;
      margin: 0;
      vertical-align: middle;
      text-wrap: wrap;
      word-break: break-all;
      width: 100%;
    }

    .pAlso {
      min-width: 100px;
      max-width: 100px;
    }

    .departement-row td .custom-row-wrapper {
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

    .departement-row td .custom-row-wrapper:hover {
      outline: 1px solid #4723d9;
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    /* Overlay and Popup */
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
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .popup .form-control,
    .popup .form-select {
      border-color: #3028893b;
    }

    .modal-footer .btn {
      padding: 0.5rem 1rem;
      border-radius: 6px;
    }

    .btn-secondary {
      background-color: #6c757d;
      color: white;
    }

    .btn-success {
      background-color: #28a745;
      color: white;
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 2rem;
      color: #666;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
      .header-grid {
        flex-direction: column;
        align-items: flex-start;
      }

      .header-grid .d-flex:last-child {
        width: 100%;
        justify-content: flex-start;
        gap: 0.75rem;
      }

      .search-container {
        width: 100%;
        max-width: none;
      }
    }

    @media (max-width: 768px) {
      .custom-row p, .pAlso {
        min-width: 100px;
        font-size: 0.9rem;
        padding: 0.5rem;
      }

      .pAlso {
        min-width: 80px;
        max-width: 80px;
      }

      .btn-primary,
      .btn-outline-success {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
        height: 34px;
      }
    }

    @media (max-width: 576px) {
      .requests-container {
        padding: 1rem;
      }

      .custom-row p {
        min-width: 80px;
        font-size: 0.85rem;
        padding: 0.4rem;
      }

      .pAlso {
        min-width: 50px;
        max-width: 50px;
      }

      .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
      }

      .btn-primary,
      .btn-outline-success {
        padding: 0.35rem 0.7rem;
        font-size: 0.85rem;
        height: 32px;
      }

      .search-container {
        min-width: 100%;
      }

      .table-container {
        padding: 10px;
      }
    }
  </style>

  <script>
    function showPopup(departementId, departementName) {
      document.getElementById('departementName').innerText = departementName;
      document.getElementById('departement_id').value = departementId;
      document.getElementById('name').value = departementName;
      document.getElementById('popupForm').action = "{{ url('/departements') }}/" + departementId;
      document.getElementById('overlay').style.display = 'flex';
    }

    function closePopup() {
      document.getElementById('overlay').style.display = 'none';
    }

    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('searchInput');
      const departementRows = document.querySelectorAll('.departement-row');
      const departementTableBody = document.getElementById('departementTableBody');

      function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        let visibleCount = 0;

        departementRows.forEach(row => {
          const chef = row.dataset.chef;

          const matchesSearch = !searchTerm || chef.includes(searchTerm);

          if (matchesSearch) {
            row.style.display = '';
            visibleCount++;
          } else {
            row.style.display = 'none';
          }
        });

        // Show empty state if no results
        const emptyState = document.getElementById('emptyState');
        if (visibleCount === 0) {
          if (!emptyState) {
            const emptyRow = document.createElement('tr');
            emptyRow.id = 'emptyState';
            emptyRow.innerHTML = `
              <td colspan="6">
                <div class="empty-state">Aucun résultat trouvé</div>
              </td>
            `;
            departementTableBody.appendChild(emptyRow);
          }
        } else if (emptyState) {
          emptyState.remove();
        }
      }

      searchInput.addEventListener('input', performSearch);
    });

    // Excel export
    function exportStyledExcel() {
      const table = document.getElementById('exportTable');
      const workbook = new ExcelJS.Workbook();
      const worksheet = workbook.addWorksheet('Departements');

      // Headers
      const headers = ['Name', 'Chef de département', 'Date de création'];
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
            row.cells[0].querySelector('.custom-row p:nth-child(1)')?.innerText || '', // Name
            row.cells[0].querySelector('.custom-row p:nth-child(2)')?.innerText || 'Non associé', // Chef de département
            row.cells[0].querySelector('.custom-row p:nth-child(3)')?.innerText || ''  // Date de création
          ];
          const newRow = worksheet.addRow(rowData);
          newRow.eachCell(cell => {
            cell.alignment = { horizontal: 'center' };
          });
        }
      });

      // Set column widths
      worksheet.columns = [
        { width: 20 }, // Name
        { width: 25 }, // Chef de département
        { width: 15 }  // Date de création
      ];

      // Export
      workbook.xlsx.writeBuffer().then((buffer) => {
        const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        saveAs(blob, 'Departements_Styled.xlsx');
      });
    }
  </script>
</x-admin_layout>
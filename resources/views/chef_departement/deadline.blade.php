<x-chef_layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/exceljs@4.4.0/dist/exceljs.min.js" integrity="sha256-HDze4xT4Sz/1u1mAcJ7y3Tl2r1W3Da5qO25yGs3y5nQ=" crossorigin="anonymous"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js" integrity="sha512-Qlv6VSKh1gDKGoJbnyA5RMXYcvnpIqhO++MhIM2fStMcGT9i2T//tCVZllrpuZP1S/pD6j+w0uukPhXjO8jdF5w==" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<div class="requests-container pt-5">
    <!-- Header -->
   <div class="header-grid mt-3 mb-5">
    <div class="d-flex align-items-center gap-3">
        <i class="fas fa-clock fa-2x" style="color: #4723d9;"></i>
        <h2 class="fw-bold" style="color: #1a1a1a;">Gestion des Échéances</h2>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <button onclick="exportStyledExcel()" class="btn btn-outline-success">
            <i class="bi bi-file-excel"></i> Exporter Excel
        </button>
        <button class="btn btn-primary fw-medium" data-bs-toggle="collapse" data-bs-target="#create-deadline-form" aria-expanded="false" aria-controls="create-deadline-form">
            <i class="bi bi-plus-circle"></i> Nouvelle Échéance
        </button>
    </div>
</div>

    <!-- Success or Error Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Create Deadline Form -->
    <div class="card filter-card mb-5 collapse" id="create-deadline-form">
        <div class="card-body">
            <h5 class="fw-semibold mb-4" style="color: #1a1a1a;">Créer une Nouvelle Échéance</h5>
            <form action="{{ route('deadline.store') }}" method="POST" id="deadline-form">
                @csrf
                <div class="row g-4">
                    <!-- Type Selection -->
                    <div class="col-12 col-md-6">
                        <label for="type" class="form-label fw-medium">Type d'Échéance</label>
                        <select id="type" name="type" class="form-select" required>
                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>Sélectionner le type</option>
                            <option value="note" {{ old('type') == 'note' ? 'selected' : '' }}>Note</option>
                            <option value="ue_selecion" {{ old('type') == 'ue_selecion' ? 'selected' : '' }}>UE Sélection</option>
                        </select>
                        @error('type')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deadline Date -->
                    <div class="col-12 col-md-6">
                        <label for="deadline_date" class="form-label fw-medium">Date d'Échéance</label>
                        <input type="datetime-local" id="deadline_date" name="deadline_date" class="form-control" value="{{ old('deadline_date') ? \Carbon\Carbon::parse(old('deadline_date'))->format('Y-m-d\TH:i') : '' }}" min="{{ now()->format('Y-m-d\TH:i') }}" required>
                        @error('deadline_date')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Notification Date -->
                    <div class="col-12 col-md-6">
                        <label for="notification_date" class="form-label fw-medium">Date de Notification</label>
                        <input type="datetime-local" id="notification_date" name="notification_date" class="form-control" value="{{ old('notification_date') ? \Carbon\Carbon::parse(old('notification_date'))->format('Y-m-d\TH:i') : '' }}" min="{{ now()->format('Y-m-d\TH:i') }}" required>
                        @error('notification_date')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-12 col-md-6">
                        <label for="status" class="form-label fw-medium">Statut</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expiré</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary fw-medium">
                            <i class="bi bi-save"></i> Enregistrer l'Échéance
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-semibold mb-0" style="color: #1a1a1a;">Historique des Échéances</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm fw-medium" onclick="toggleSort()">
                        <i class="bi bi-sort-down"></i> <span id="sortText">Trier par Date ↓</span>
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless" id="exportTable">
                    <thead>
                        <tr style="color: #1a1a1a; font-weight: 600;">
                            <th>Type</th>
                            <th>Date d'Échéance</th>
                            <th>Date de Notification</th>
                            <th>Statut</th>
                            <th>Créé par</th>
                            <th>Créé le</th>
                        </tr>
                    </thead>
                    <tbody id="actionTableBody">
                        @forelse ($deadlines as $deadline)
                            <tr class="action-row custom-row-wrapper"
                                data-id="{{ $deadline->id }}"
                                data-date="{{ $deadline->deadline_date->format('Y-m-d H:i:s') }}">
                                <td>
                                    <div class="custom-row d-flex align-items-center">
                                        <p>{{ ucfirst($deadline->type) }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-row d-flex align-items-center">
                                        <p>{{ $deadline->deadline_date->format('Y-m-d H:i') }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-row d-flex align-items-center">
                                        <p>{{ $deadline->notification_date->format('Y-m-d H:i') }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-row d-flex align-items-center">
                                        <p>
                                            <span class="badge {{ $deadline->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($deadline->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-row d-flex align-items-center">
                                        <p>{{ $deadline->user ? $deadline->user->firstname . ' ' . $deadline->user->lastname : 'Inconnu' }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-row d-flex align-items-center">
                                        <p>{{ $deadline->created_at->format('Y-m-d H:i') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">Aucune échéance trouvée</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $deadlines->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Main Container */
        .requests-container {
            padding: 2.5rem;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        /* Header */
        .header-grid {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .btn-primary,
        .btn-outline-success,
        .btn-outline-primary {
            padding: 0.75rem 1.25rem;
            border-radius: 10px;
            font-weight: 500;
            font-size: 1rem;
            height: 44px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4723d9, #3b1cb3);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3b1cb3, #2e1590);
            transform: translateY(-2px);
        }

        .btn-outline-success {
            border: 2px solid #28a745;
            color: #28a745;
            background: transparent;
        }

        .btn-outline-success:hover {
            background: #28a745;
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            border: 2px solid #4723d9;
            color: #4723d9;
        }

        .btn-outline-primary:hover {
            background: #4723d9;
            color: white;
            transform: translateY(-2px);
        }

        /* Form Card */
        .filter-card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            background: linear-gradient(145deg, #ffffff, #f8fafc);
        }

        .form-label {
            color: #1a1a1a;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-select,
        .form-control {
            height: 44px;
            font-size: 0.95rem;
            padding: 0.75rem 1rem;
            border: 2px solid #4723d9;
            border-radius: 10px;
            color: #1a1a1a;
            background: white;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #3b1cb3;
            box-shadow: 0 0 0 3px rgba(71, 35, 217, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        /* Table */
        .table-card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .table {
            width: 100%;
            max-width: 100%;
        }

        thead tr th {
            padding: 1rem;
            text-align: center;
            width: 16.66%;
        }

        .custom-row {
            display: flex;
            padding: 0.75rem;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .custom-row p {
            color: #1a1a1a;
            font-weight: 500;
            text-align: center;
            min-width: 120px;
            padding: 0.75rem;
            margin: 0;
            flex: 1;
        }

        .custom-row .d-flex {
            flex: 1;
            justify-content: center;
        }

        .custom-row-wrapper {
            outline: 1px solid #4723d929;
            border-radius: 10px;
            background: white;
            transition: all 0.2s ease-in-out;
            margin: 0.25rem;
            margin-bottom: 0.5rem;
        }

        .custom-row-wrapper:hover {
            outline: 1px solid #4723d9;
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6b7280;
            font-size: 1.1rem;
        }

        /* Alerts and Badges */
        .alert {
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .custom-row p {
                min-width: 100px;
            }
        }

        @media (max-width: 992px) {
            .header-grid {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 768px) {
            .requests-container {
                padding: 1.5rem;
            }

            .custom-row p {
                min-width: 80px;
                font-size: 0.9rem;
                padding: 0.5rem;
            }

            .btn-primary,
            .btn-outline-success,
            .btn-outline-primary {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
                height: 38px;
            }

            .form-select,
            .form-control {
                height: 38px;
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .custom-row p {
                min-width: 60px;
                font-size: 0.85rem;
                padding: 0.4rem;
            }

            .btn-primary,
            .btn-outline-success,
            .btn-outline-primary {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
                height: 34px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Client-side form validation
            const form = document.getElementById('deadline-form');
            if (form) {
                form.addEventListener('submit', (e) => {
                    const deadlineDate = new Date(document.getElementById('deadline_date').value);
                    const notificationDate = new Date(document.getElementById('notification_date').value);
                    if (notificationDate >= deadlineDate) {
                        e.preventDefault();
                        alert('La date de notification doit être antérieure à la date d\'échéance.');
                    }
                });
            }

            // Table Sort
            let sortAscending = false;
            window.toggleSort = function() {
                const actionTableBody = document.getElementById('actionTableBody');
                const rows = Array.from(actionTableBody.querySelectorAll('.action-row'));
                rows.sort((a, b) => {
                    const dateA = new Date(a.dataset.date);
                    const dateB = new Date(b.dataset.date);
                    return sortAscending ? dateA - dateB : dateB - dateA;
                });
                actionTableBody.innerHTML = '';
                rows.forEach(row => actionTableBody.appendChild(row));
                sortAscending = !sortAscending;
                document.getElementById('sortText').textContent = sortAscending ? 'Trier par Date ↑' : 'Trier par Date ↓';
            };

            // Excel Export
            window.exportStyledExcel = function() {
                if (typeof ExcelJS === 'undefined') {
                    console.error('ExcelJS not loaded');
                    alert('Erreur: Impossible de générer le fichier Excel.');
                    return;
                }

                const table = document.getElementById('exportTable');
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('Deadlines');

                worksheet.addRow(['Type', 'Date d\'Échéance', 'Date de Notification', 'Statut', 'Créé par', 'Créé le']);
                worksheet.getRow(1).eachCell(cell => {
                    cell.font = { bold: true, color: { argb: 'FFFFFFFF' } };
                    cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '4F81BD' } };
                    cell.alignment = { horizontal: 'center' };
                });

                const rows = table.querySelectorAll('tbody tr.action-row');
                rows.forEach(row => {
                    const rowData = [
                        row.cells[0].querySelector('.custom-row p')?.innerText || '',
                        row.cells[1].querySelector('.custom-row p')?.innerText || '',
                        row.cells[2].querySelector('.custom-row p')?.innerText || '',
                        row.cells[3].querySelector('.custom-row p .badge')?.innerText || '',
                        row.cells[4].querySelector('.custom-row p')?.innerText || 'Inconnu',
                        row.cells[5].querySelector('.custom-row p')?.innerText || ''
                    ];
                    const newRow = worksheet.addRow(rowData);
                    newRow.eachCell(cell => {
                        cell.alignment = { horizontal: 'center' };
                    });
                });

                worksheet.columns = [
                    { width: 15 }, { width: 20 }, { width: 20 }, { width: 15 }, { width: 25 }, { width: 20 }
                ];

                workbook.xlsx.writeBuffer().then(buffer => {
                    const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                    saveAs(blob, 'Deadlines_Styled.xlsx');
                }).catch(err => {
                    console.error('Excel export failed:', err);
                    alert('Erreur lors de l’exportation Excel.');
                });
            };
        });
    </script>
</x-chef_layout>
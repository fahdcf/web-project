<x-coordonnateur_layout>
    <div class="container-fluid py-4">
        <!-- Retour Button -->
        <div class="mb-3">
            <a href="{{ route('coordonnateur.modules.index') }}" class="btn btn-outline-secondary rounded fw-semibold">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
        </div>

        <!-- Module Card -->
        <div class="module-card bg-white rounded-3 shadow-sm p-0">
            <!-- Card Header -->
            <div class="module-header p-4 rounded-top">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="module-name mb-0 text-white">
                            <i class="bi bi-book me-2"></i>{{ $module->name }}
                        </h3>
                        <small class="text-white-50">
                            Filière: {{ $filiere->name ?? 'Non définie' }} - Année universitaire: {{ $anneeUniversitaire ?? now()->year }}
                        </small>
                    </div>
                    <div class="module-hours-badge bg-white text-primary">
                        {{ $module->code }}
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="module-details p-4">
                <!-- Essential Information -->
                <div class="form-section mb-4">
                    <h3 class="section-title h5 mb-3 fw-bold text-primary">
                        <i class="bi bi-info-circle me-2"></i>Informations essentielles
                    </h3>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="detail-item">
                                <span class="detail-label">Type UE</span>
                                <span class="detail-value">{{ $module->type == 'complet' ? 'Complet' : 'Élément' }}</span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="detail-item">
                                <span class="detail-label">Nom complet</span>
                                <span class="detail-value">{{ $module->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-item">
                                <span class="detail-label">Spécialité</span>
                                <span class="detail-value">{{ $module->specialty ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-item">
                                <span class="detail-label">Semestre</span>
                                <span class="detail-value">
                                    {{ $module->semester == 1 ? '1er Semestre' : $module->semester . 'ème Semestre' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-item">
                                <span class="detail-label">Crédits ECTS</span>
                                <span class="detail-value">{{ $module->credits }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-item">
                                <span class="detail-label">Évaluation</span>
                                <span class="detail-value">{{ $module->evaluation }} (Coefficient)</span>
                            </div>
                        </div>
                        @if ($module->description)
                            <div class="col-12">
                                <div class="detail-item">
                                    <span class="detail-label">Description pédagogique</span>
                                    <span class="detail-value">{{ $module->description }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Parent Module (if applicable) -->
                @if ($module->parent_id)
                    <div class="form-section mb-4">
                        <h3 class="section-title h5 mb-3 fw-bold text-primary">
                            <i class="bi bi-sitemap me-2"></i>Module Parent
                        </h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">Module parent</span>
                                    <span class="detail-value">
                                        {{ $module->parentModule ? $module->parentModule->code . ' - ' . $module->parentModule->name : 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Volume Horaire -->
                <div class="form-section mb-4">
                    <h3 class="section-title h5 mb-3 fw-bold text-primary">
                        <i class="bi bi-clock me-2"></i>Volume horaire
                    </h3>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="detail-item">
                                <span class="detail-label">CM (heures)</span>
                                <span class="detail-value">{{ $module->cm_hours }}h</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-item">
                                <span class="detail-label">TD (heures)</span>
                                <span class="detail-value">{{ $module->td_hours }}h</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-item">
                                <span class="detail-label">TP (heures)</span>
                                <span class="detail-value">{{ $module->tp_hours }}h</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-item">
                                <span class="detail-label">Autre (heures)</span>
                                <span class="detail-value">{{ $module->autre_hours }}h</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info py-2 d-flex justify-content-between align-items-center small">
                                <span><i class="bi bi-calculator me-1"></i>Total heures:</span>
                                <span class="badge bg-primary rounded-pill">
                                    {{ $module->cm_hours + $module->td_hours + $module->tp_hours + $module->autre_hours }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsable and Status -->
                <div class="form-section mb-4">
                    <h3 class="section-title h5 mb-3 fw-bold text-primary">
                        <i class="bi bi-user-tie me-2"></i>Responsable du module et Status
                    </h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Responsable</span>
                                <span class="detail-value">
                                    @if ($module->responsable_id == 'vacataire')
                                        {{ $module->vacataire_nom ?? 'Vacataire non défini' }}
                                    @elseif ($module->responsable)
                                        {{ $module->responsable->firstname }} {{ $module->responsable->lastname }}
                                    @else
                                        Non associé
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <span class="detail-label">Status</span>
                                <span class="detail-value">
                                    <span class="badge {{ $module->status == 'active' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $module->status == 'active' ? 'Active' : 'Inactive' }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        @if ($module->responsable_id == 'vacataire')
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">Email du vacataire</span>
                                    <span class="detail-value">{{ $module->vacataire_email ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">Téléphone du vacataire</span>
                                    <span class="detail-value">{{ $module->vacataire_telephone ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">Spécialité du vacataire</span>
                                    <span class="detail-value">{{ $module->vacataire_specialite ?? 'N/A' }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Footer (Actions) -->
            <div class="module-actions p-3 border-top bg-light rounded-bottom d-flex justify-content-end gap-3">
                <a href="{{ route('coordonnateur.modules.edit', $module->id) }}" class="btn btn-primary px-4">
                    <i class="bi bi-pencil-fill me-2"></i>Modifier
                </a>
                <form action="{{ route('coordonnateur.modules.destroy', $module->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="remove-btn px-4" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce module ?')">
                        <i class="bi bi-trash-fill me-2"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary: #4723d9;
            --primary-soft: #e8e5ff;
        }

        .module-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #4723d91e;
            max-width: 900px;
            margin: 0 auto;
        }

        .module-header {
            padding: 16px 20px;
            background: linear-gradient(135deg, #4723d9 0%, #6047c7 100%);
            border-bottom: 1px solid #e0e0e0;
            border-radius: 12px 12px 0 0;
        }

        .module-name {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: #f0f0f0;
        }

        .module-hours-badge {
            background: #ffffff;
            color: var(--primary);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .module-details {
            padding: 20px;
            display: grid;
            gap: 20px;
        }

        .form-section {
            background: #f8f9fc;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e3e6f0;
        }

        .section-title {
            font-size: 1.1rem;
            color: var(--primary);
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .detail-label {
            font-size: 0.75rem;
            color: #95a5a6;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .detail-value {
            font-size: 0.95rem;
            font-weight: 500;
            color: #34495e;
        }

        .module-actions {
            padding: 12px 20px;
            border-top: 1px solid #f0f0f0;
            background: #f9f9f9;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: #3a1cb3;
            border-color: #3a1cb3;
        }

        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }

        .remove-btn {
            background: none;
            border: 1px solid #e74c3c;
            color: #e74c3c;
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .remove-btn:hover {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .alert-info {
            background-color: #f0f7fd;
            border-color: #d0e3f0;
            color: #3a87ad;
            font-size: 0.85rem;
            border-radius: 6px;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.25em 0.6em;
        }

        @media (max-width: 768px) {
            .module-card {
                margin: 0 10px;
            }

            .module-header,
            .module-details,
            .module-actions {
                padding: 12px;
            }

            .form-section {
                padding: 12px;
            }
        }
    </style>
</x-coordonnateur_layout>
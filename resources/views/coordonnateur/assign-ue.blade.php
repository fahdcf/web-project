<x-coordonnateur_layout>

    <div class="container-fluid p-0 pt-5">
        <x-global_alert />



        <!-- En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Assignation des UE</h3>
                <p class="text-muted mb-0">
                    Vacataire: <strong>{{ $vacataire->firstname }} {{ $vacataire->lastname }}</strong>
                </p>
            </div>
            <a href="{{ route('coordonnateur.vacataires.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>

        <!-- Carte principale -->
        <div class="card border-0 shadow-sm">
            <form method="POST" action="{{ route('assign', $vacataire->id) }}">
                @csrf

                <!-- Corps de la carte -->
                <div class="card-body">
                    <!-- Filtre de recherche -->
                    <div class="mb-3">
                        <input type="text" id="searchUE" class="form-control" placeholder="Rechercher une UE...">
                    </div>

                    <!-- Liste des UE -->
                    <div class="row row-cols-1 row-cols-md-2 g-3" id="ueList">
                        @foreach ($modules as $module)
                            <div class="col">
                                <div class="card h-100 border">
                                    <div class="card-body p-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="ues[]"
                                                value="{{ $module->id }}" id="module-{{ $module->id }}"
                                                {{ $vacataire->modules->contains($module->id) ? 'checked' : '' }}>
                                            <label class="form-check-label w-100" for="module-{{ $module->id }}">
                                                <div class="d-flex justify-content-between">
                                                    <span class="fw-bold">{{ $module->code }}</span>
                                                    <span
                                                        class="badge bg-{{ $vacataire->modules->contains($module->id) ? 'success' : 'light' }}">
                                                        {{ $vacataire->modules->contains($module->id) ? 'Assigné' : 'Non assigné' }}
                                                    </span>
                                                </div>
                                                <div class="text-muted">{{ $module->name }}</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pied de carte -->
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted" id="selectedCount">
                            {{ count($vacataire->modules) }} UE sélectionnée(s)
                        </small>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript pour l'interactivité -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filtre de recherche
            document.getElementById('searchUE').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const cards = document.querySelectorAll('#ueList .col');

                cards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    card.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });

            // Compteur de sélection
            const checkboxes = document.querySelectorAll('input[name="ues[]"]');
            const selectedCount = document.getElementById('selectedCount');

            function updateCounter() {
                const checked = document.querySelectorAll('input[name="ues[]"]:checked').length;
                selectedCount.textContent = `${checked} UE sélectionnée(s)`;
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateCounter);
            });
        });

        // Fermeture automatique après 5 secondes
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 150);
                }, 5000);
            }
        });
    </script>

    <style>
        .alert {
            border-radius: 0.5rem;
            padding: 1rem 1.25rem;
            border: none;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .alert-dismissible .btn-close {
            padding: 0.5rem;
        }

        .form-check-input:checked {
            background-color: #4723d9;
            border-color: #4723d9;
        }

        .form-check-label {
            cursor: pointer;
        }

        #ueList .card:hover {
            border-color: #4723d9;
        }
    </style>
</x-coordonnateur_layout>

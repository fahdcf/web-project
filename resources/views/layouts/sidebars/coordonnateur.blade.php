<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <!-- Logo -->
            <a href="#" class="nav_logo">
                <i class="bx bx-user-circle nav_logo-icon"></i>
                <span class="nav_logo-name">AssignPro - Coordinateur</span>
            </a>

            <!-- Navigation Links -->
            <div class="nav_list">
                <!-- Tableau de Bord -->
                <a href="{{ route('coordonnateur.dashboard') }}" class="nav_link ">
                    <i class="bx bx-grid-alt nav_icon"></i>
                    <span class="nav_name">Tableau de Bord</span>
                </a>

                <!-- Unités d'Enseignement -->
                <a href="{{ route('coordonnateur.modules.index') }}" class="nav_link">
                    <i class="bx bx-book-content nav_icon"></i>
                    <span class="nav_name">Gestion des UE</span>
                </a>

                <!-- Gestion des Vacataires -->
                <a href="{{ route('coordonnateur.vacataires.index') }}" class="nav_link">
                    <i class="bx bx-user-plus nav_icon"></i>
                    <span class="nav_name">Vacataires</span>
                </a>

                <!-- Groupes TD / TP -->
                <a href="{{ route('coordonnateur.groupes.index') }}" class="nav_link">
                    <i class="bx bx-group nav_icon"></i>
                    <span class="nav_name">Groupes TD / TP</span>
                </a>

                <!-- Emploi du Temps -->
                <a href="#" class="nav_link">
                    <i class="bx bx-calendar nav_icon"></i>
                    <span class="nav_name">Emploi du Temps</span>
                </a>

                <!-- Validations / Affectations -->
                <a href="#" class="nav_link">
                    <i class="bx bx-check-circle nav_icon"></i>
                    <span class="nav_name">Affectations Validées</span>
                </a>

              
    

                {{-- --}}


                {{-- --}}

                <!-- Modules Vacants -->
                <a href="#" class="nav_link">
                    <i class="bx bx-error nav_icon"></i>
                    <span class="nav_name">Modules Vacants</span>
                </a>

                <!-- Historique -->
                <a href="#" class="nav_link">
                    <i class="bx bx-history nav_icon"></i>
                    <span class="nav_name">Historique</span>
                </a>

                <!-- Import / Export -->
                <a href="#" class="nav_link">
                    <i class="bx bx-upload nav_icon"></i>
                    <span class="nav_name">Import / Export</span>
                </a>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="nav_bottom">
            <a href="#" class="nav_link">
                <i class="bx bx-cog nav_icon"></i>
                <span class="nav_name">Paramètres</span>
            </a>
            <a href="#" class="nav_link">
                <i class="bx bx-user nav_icon"></i>
                <span class="nav_name">Mon Profil</span>
            </a>
            <a href="#" class="nav_link" id="logout-btn">
                <i class="bx bx-log-out nav_icon"></i>
                <span class="nav_name">Déconnexion</span>
            </a>
        </div>
    </nav>
</div>
{{-- 1. 📚 Gestion des Unités d’Enseignement ✅ Ajouter une nouvelle UE 📄 Lister toutes les UE de la filière ✏️
Modifier les informations d’une UE (volume horaire, semestre, spécialité…) 👨‍🏫 Définir le responsable de chaque UE --}}
{{--

<li class="nav-item">
    <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseUtilities"
        aria-expanded="true"
        aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-address-card"></i>
        <span>Demandes</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a
                class="collapse-item"
                href="https://ensah.ma/apps/eservices/internal/members/etudiant/demanderAttForm.php">
                Nouvelle demande
            </a>
            <a
                class="collapse-item"
                href="https://ensah.ma/apps/eservices/internal/members/etudiant/mesDemandesAtt.php">
                Etat de mes demandes
            </a>
        </div>
    </div>
</li>

--}}

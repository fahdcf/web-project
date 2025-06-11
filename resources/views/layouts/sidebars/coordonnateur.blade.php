<!-- Unités d'Enseignement -->
<a href="{{ route('coordonnateur.modules.index') }}"
    class="nav_link {{ request()->is('coordonnateur/modules') ? 'active' : '' }} ">
    <i class="bx bx-book-content nav_icon"></i>
    <span class="nav_name">Gestion des UE</span>
</a>

<!-- Gestion des Vacataires -->
<a href="{{ route('coordonnateur.vacataires.index') }}"
    class="nav_link {{ request()->is('coordonnateur/vacataires') ? 'active' : '' }} ">
    <i class="bx bx-user-plus nav_icon"></i>
    <span class="nav_name">Vacataires</span>
</a>

<!-- Groupes TD / TP -->
<a href="{{ route('coordonnateur.groupes.current_semester') }}"
    class="nav_link {{ request()->is('coordonnateur/groupes/current_semester') ? 'active' : '' }} ">
    <i class="bx bx-group nav_icon"></i>
    <span class="nav_name">Groupes TD / TP</span>
</a>

<!-- Emploi du Temps -->
<a href="{{ route('emploi.index') }}" class="nav_link {{ request()->is('emplois') ? 'active' : '' }} ">
    <i class="bx bx-calendar nav_icon"></i>
    <span class="nav_name">Emploi du Temps</span>
</a>

<!-- Validations / Affectations -->
<a href="{{ route('coordonnateur.assignments') }}"
    class="nav_link {{ request()->is('assignations') ? 'active' : '' }} ">
    <i class="bx bx-check-circle nav_icon"></i>
    <span class="nav_name">Affectations Validées</span>
</a>

<!-- Historique -->
<a href="#" class="nav_link {{ request()->is('coordonnateur/lkadflkadlfaj') ? 'active' : '' }} ">
    <i class="bx bx-history nav_icon"></i>
    <span class="nav_name">Historique</span>
</a>


{{-- 
@if (auth()->user()->role->isprof)
    <!-- Divider stylé -->
    <hr class="sidebar-divider-centered"
        style="width: 80%; margin: 1rem auto; border-top: 1px solid rgb(255, 255, 255);" />
    <!-- Ou avec une classe personnalisée -->
    <style>
        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.712);
            /* ligne claire */
            margin: 1rem 0;
        }

        .sidebar-divider-centered {
            width: 80%;
            margin: 1rem auto;
            border-top: 1px solid rgba(255, 255, 255, 0.89);
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-divider-centered {
            width: 40%;
            /* smaller width when collapsed */
        }
    </style>
    <a href="{{ route('mesModules') }}" class="nav_link {{ request()->is('mesModules') ? 'active' : '' }}">
        <i class="fas fa-book"></i> <!-- Changed from fa-book-open to fa-book (simpler book icon) -->
        <span class="nav_name">Mes Modules</span>
    </a>

    <a href="{{ route('professor.myRequests') }}" class="nav_link {{ request()->is('my-requests') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i>
        <!-- Changed to clipboard with list - clearer for "demandes" -->
        <span class="nav_name">Mes Demandes</span>
    </a>

    <a href="{{ route('availableModules') }}"
        class="nav_link {{ request()->is('availableModules') ? 'active' : '' }}">
        <i class="fas fa-book-medical"></i>
        <!-- Changed to book with plus sign - indicates availability -->
        <span class="nav_name">Modules vacantes</span>
    </a>



    <a href="{{ route('emploi.myTimetable') }}" class="nav_link {{ request()->is('my-timetable') ? 'active' : '' }}">
        <i class="fas fa-table"></i> <!-- Changed to table icon - represents timetable better -->
        <span class="nav_name">Emploi du Temps</span>
    </a>

    <a href="{{ route('notes_upload_page') }}" class="nav_link {{ request()->is('upload-notes') ? 'active' : '' }}">
        <i class="fas fa-edit"></i> <!-- Changed to edit icon - more appropriate for "saisir" -->
        <span class="nav_name">Saisir les notes</span>
    </a>
@endif --}}


















{{-- </div> --}}
</div>

<!-- Bottom Section -->


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

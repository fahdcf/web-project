<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="#" class="nav_logo">
                <i class="bx bx-user-circle nav_logo-icon"></i>
                <span class="nav_logo-name">AssignPro - Vacataire</span>
            </a>

            <div class="nav_list">
                <a href="{{ route('vacataire.dashboard') }}" class="nav_link active">
                    <i class="bx bx-book-open nav_icon"></i>
                    <span class="nav_name">Mes Unités d'Enseignement</span>
                </a>

                <a href="#" class="nav_link">
                    <i class="bx bx-upload nav_icon"></i>
                    <span class="nav_name">Uploader les Notes</span>
                </a>

                {{-- Potentially other relevant links in the future --}}
                {{-- <a href="#" class="nav_link">
                    <i class="bx bx-calendar nav_icon"></i>
                    <span class="nav_name">Mon Emploi du Temps</span>
                </a> --}}
            </div>
        </div>

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
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="#" class="nav_logo">
                <i class="bx bx-user-circle nav_logo-icon"></i>
                <span class="nav_logo-name">Espace Professeur</span>
            </a>

            <div class="nav_list">
                <!-- Dashboard -->
                <a href="{{ ('coordinator.dashboard') }}" class="nav_link active">
                    <i class="bx bx-grid-alt nav_icon"></i>
                    <span class="nav_name">Tableau de Bord</span>
                </a>

                <a href="{{ ('coordinator.ues.index') }}" class="nav_link">
                    <i class="bx bx-book-open nav_icon"></i>
                    <span class="nav_name">Unités d'Enseignement</span>
                    <span class="badge bg-warning float-end">3</span>
                </a>

                <a href="#" class="nav_link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="nav_name">Tableau de bord</span>
                </a>

                <a href="#" class="nav_link">
                    <i class="fas fa-book-open"></i>
                    <span class="nav_name">Unités d'enseignement</span>
                </a>

                <a href="#" class="nav_link">
                    <i class="fas fa-upload"></i>
                    <span class="nav_name">Dépôt des notes</span>
                </a>

                <a href="#" class="nav_link">
                    <i class="fas fa-history"></i>
                    <span class="nav_name">Historique</span>
                </a>

                <a href="#" class="nav_link">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="nav_name">Emploi du temps</span>
                </a>

                <a href="#" class="nav_link">
                    <i class="fas fa-chart-bar"></i>
                    <span class="nav_name"><span class="nav_name">Statistiques</span></span>
                </a>
            </div>
        </div>

        <!-- Bottom section -->
        <div class="nav_bottom">
            <!-- Settings -->
            <a href="{{ ('coordinator.settings') }}" class="nav_link">
                <i class="bx bx-cog nav_icon"></i>
                <span class="nav_name">Paramètres</span>
            </a>

            <!-- Profile -->
            <a href="{{ ('coordinator.profile') }}" class="nav_link">
                <i class="bx bx-user nav_icon"></i>
                <span class="nav_name">Mon Profil</span>
            </a>

            <!-- Logout -->
            <a href="#" class="nav_link" id="logout-btn">
                <i class="bx bx-log-out nav_icon"></i>
                <span class="nav_name">Déconnexion</span>
            </a>
        </div>
    </nav>
</div>

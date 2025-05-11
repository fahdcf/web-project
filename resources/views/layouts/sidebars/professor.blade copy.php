<style>
    :root {
        --primary-color: #3a7bd5;
        --secondary-color: #00d2ff;
        --sidebar-width: 250px;
        --header-height: 70px;
    }

    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f8f9fa;
        padding-top: var(--header-height);
    }

    /* Sidebar Styles */
    #sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        color: white;
        transition: all 0.3s;
        z-index: 1000;
        box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
    }

    #sidebar .sidebar-header {
        padding: 20px;
        background-color: rgba(0, 0, 0, 0.1);
    }

    #sidebar ul.components {
        padding: 20px 0;
    }

    #sidebar ul li a {
        padding: 12px 20px;
        color: white;
        display: block;
        text-decoration: none;
        transition: all 0.3s;
    }

    #sidebar ul li a:hover {
        background-color: rgba(255, 255, 255, 0.1);
        padding-left: 25px;
    }

    #sidebar ul li.active > a {
        background-color: rgba(255, 255, 255, 0.2);
        font-weight: 500;
    }

    #sidebar ul li a i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    /* Header Styles */
    #header {
        height: var(--header-height);
        position: fixed;
        top: 0;
        right: 0;
        left: var(--sidebar-width);
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 900;
        transition: all 0.3s;
    }

    /* Main Content Styles */
    #content {
        margin-left: var(--sidebar-width);
        padding: 20px;
        transition: all 0.3s;
        min-height: calc(100vh - var(--header-height));
    }

    /* Profile Dropdown */
    .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.5);
    }

    /* Badge Styles */
    .badge {
        font-weight: 500;
        padding: 5px 10px;
    }

    /* Card Styles */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        transition:
            transform 0.3s,
            box-shadow 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 10px 10px 0 0 !important;
        padding: 15px 20px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        #sidebar {
            margin-left: -var(--sidebar-width);
        }

        #sidebar.active {
            margin-left: 0;
        }

        #header {
            left: 0;
        }

        #content {
            margin-left: 0;
        }

        body {
            padding-top: var(--header-height);
        }
    }
</style>

<nav id="sidebar">
    <div class="sidebar-header text-center">
        <h4>AssignPro</h4>
        <p class="mb-0">Espace Professeur</p>
    </div>

    <ul class="list-unstyled components">
        <li class="active">
            <a href="#">
                <i class="fas fa-tachometer-alt"></i>
                Tableau de bord
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-book-open"></i>
                Unités d'enseignement
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-upload"></i>
                Dépôt des notes
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-history"></i>
                Historique
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-calendar-alt"></i>
                Emploi du temps
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-chart-bar"></i>
                Statistiques
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-cog"></i>
                Paramètres
            </a>
        </li>
    </ul>
</nav>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    @vite(['resources/css/admin-dashboard.css', 'resources/css/sb-admin-2.css', 'resources/vendor/fontawesome-free/css/all.min.css', 'resources/js/app.js', 'resources/vendor/jquery/jquery.min.js', 'resources/vendor/bootstrap/js/bootstrap.bundle.min.js', 'resources/vendor/jquery-easing/jquery.easing.min.js', 'resources/js/sb-admin-2.min.js', 'resources/vendor/chart.js/Chart.min.js', 'resources/js/demo/chart-area-demo.js', 'resources/js/demo/chart-pie-demo.js'])

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">


    <style>
        @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");

        :root {
            --header-height: 3rem;
            --nav-width: 68px;
            --first-color: #4723D9;
            --first-color-light: #AFA5D9;
            --white-color: #F7F6FB;
            --body-font: 'Montserrat', sans-serif;
            --normal-font-size: 1rem;
            --z-fixed: 100
        }

        *,
        ::before,
        ::after {
            box-sizing: border-box
        }

        body {
            position: relative;
            margin: var(--header-height) 0 0 0;
            padding: 0 2rem;
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
            transition: .5s;
            background-color: #f5f5f5;
        }

        .modal-backdrop {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100% !important;
            z-index: 1040;
            /* Bootstrap uses this for modals */
            background-color: rgba(0, 0, 0, 0.5);
            /* semi-transparent black */
        }

        a {
            text-decoration: none
        }

        .header {
            width: 100%;
            height: var(--header-height);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--white-color);
            z-index: var(--z-fixed);
            transition: .5s;
        }


        .header-content {
            height: 100%;

            width: 90vw;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            z-index: var(--z-fixed);
            transition: .5s;
            border-radius: 10px;
            box-shadow: 1px 1px 10px 2px #33333311, 1px -30px 15px 20px #f5f5f5;
            padding: 10px;
            background-color: white;




        }


        .header_toggle {
            color: var(--first-color);
            font-size: 1.5rem;
            cursor: pointer
        }


        .l-navbar {
            position: fixed;
            top: 0;
            left: -30%;
            width: var(--nav-width);
            height: 100vh;
            background-color: var(--first-color);
            padding: .5rem 1rem 0 0;
            transition: .5s;
            z-index: var(--z-fixed)
        }

        .nav {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden
        }

        .nav_logo,
        .nav_link {
            display: grid;
            grid-template-columns: max-content max-content;
            align-items: center;
            column-gap: 1rem;
            padding: .5rem 0 .5rem 1.5rem
        }

        .nav_logo {
            margin-bottom: 2rem
        }

        .nav_logo-icon {
            font-size: 1.25rem;
            color: var(--white-color)
        }

        .nav_logo-name {
            color: var(--white-color);
            font-weight: 700
        }

        .nav_link {
            position: relative;
            color: var(--first-color-light);
            margin-bottom: 1.5rem;
            transition: .3s
        }

        .nav_link:hover {
            color: var(--white-color);
            text-decoration-line: none;


        }

        .nav_icon {
            font-size: 1.25rem
        }

        .show {
            left: 0
        }

        .body-pd {
            padding-left: calc(var(--nav-width) + 1rem);
        }

        .active {
            color: var(--white-color)
        }

        .active::before {
            content: '';
            position: absolute;
            left: 0;
            width: 2px;
            height: 32px;
            background-color: var(--white-color)
        }

        .height-100 {
            height: 100vh
        }

        @media screen and (min-width: 768px) {
            body {
                margin: calc(var(--header-height) + 1rem) 0 0 0;
                padding-left: calc(var(--nav-width) + 2rem)
            }

            .header {
                height: calc(var(--header-height) + 1rem);
                padding: 0 2rem 0 calc(var(--nav-width) + 2rem)
            }

            .l-navbar {
                left: 0;
                padding: 1rem 1rem 0 0
            }

            .l-navbar.show {
                width: calc(var(--nav-width) + 156px)
            }

            .l-navbar.show {
                width: calc(var(--nav-width) + 156px)
            }

            .body-pd {
                padding-left: calc(var(--nav-width) + 188px);


            }
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
            background: #f1f1f1;
            border-radius: 20px;
            padding: 5px 10px;
            transition: width 0.4s;
            overflow: hidden;
            width: 40px;
            /* collapsed */
            cursor: pointer;
        }

        .search-container.active {
            width: 200px;
            /* expanded */
        }

        .search-input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            margin-left: 10px;
            display: none;
        }

        .search-container.active .search-input {
            display: block;
        }

        #search-icon {
            font-size: 20px;
            color: #333;
        }


        #profileDropdown img {
            height: 40px;
            width: 40px;
            object-fit: cover;
            border: 1px solid #8585866b;


        }

        #profileDropdown img:hover {
            outline: 1px solid #4723D9;


        }


        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            transform: translateY(5px);
            z-index: 2000;
        }

        .notifications-container button {
            border: none;
            background: none;

        }


        .notifications-container button i {
            color: #424242 !important;

            font-size: 25px !important;

        }

        .notifications-container button i:hover {
            color: #7367f0 !important;
            transition: color 0.3s ease;
        }

        #searshBarContainer {

            height: 100%;
            width: 90vw;
            padding: 0 1rem;
            z-index: var(--z-fixed);
            transition: .5s;
            border-radius: 10px;
            box-shadow: 1px 1px 10px 2px #33333311, 1px -30px 15px 20px #f5f5f5;
            padding: 10px;
            background-color: white;


        }


        #searchBar {

            display: flex;
            height: 100%;
            width: 100%;
            z-index: var(--z-fixed);

        }


        #searchBar input {
            width: 100%;
            height: 100%;
            padding-left: 10px;
            border: none;
            background: transparent;

        }

        #searchBar input:focus {
            outline: none;
        }

        #searchBar button {
            border: none;
            width: 40px;
            background: none;


        }

        .hidden {
            display: none !important;
        }
    </style>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>



</head>

<body id="body-pd">

    <header class="header mt-3" id="header">

        <div id="searshBarContainer" class="hidden">

            <div id="searchBar">
                <button><i class='bx bx-search' id="search-icon"></i></button>
                <input type="text" name="search" id="search-input" placeholder="search..">
                <button onclick="closeSearchBar()"><i style="font-size: 27px;" class="bi bi-x"></i></button>

            </div>

        </div>


        <div id="header-content" class="header-content ">

            <div class="header_toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>





            <div class="d-flex align-items-center">

                <div class="notifications-container ml-2" id="notifications-container">
                    <button onclick="showSearchBar()"><i class='bx bx-search' id="search-icon"></i></button>
                </div>


                <div class="notifications-container ml-2" id="notifications-container">
                    <button id="searchBtn"><i class='bx bx-bell' id="search-icon"></i></button>
                </div>

                <div class="d-flex flex-column  ml-3">

                    <p style="color: #504f4f; font-weight: 600; font-size: 15px;" class="p-0 m-0">
                        {{ Auth()->user()->firstname }} {{ Auth()->user()->lastname }}</p>

                    @if (auth()->user()->user_details)
                        <p style=" {{ Auth()->user()->user_details->status === 'active' ? 'color: #10a386;' : 'color: #cd4c35;' }} font-weight: 500; font-size: 12px;"
                            class="p-0 m-0 text-end">{{ Auth()->user()->user_details->status }}</p>
                    @else
                        <p style="color: #cd4c35; font-weight: 500; font-size: 12px;" class="p-0 m-0 text-end">inactive
                        </p>
                    @endif

                </div>

                <!-- Profile picture dropdown -->
                <div class="dropdown ms-3">
                    <a href="#" class="d-flex align-items-center" id="profileDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        @if (Auth()->user()->user_details)
                            @if (Auth()->user()->user_details->profile_img != null)
                                <img style=" border-radius:50%;"
                                    src="{{ asset('storage/' . Auth()->user()->user_details->profile_img) }}">
                            @else
                                <img style=" border-radius:50%;"
                                    src="{{ asset('storage/images/default_profile_img.png') }}">
                            @endif
                        @else
                            <img style="width: 35px; border-radius:50%;"
                                src="{{ asset('storage/images/default_profile_img.png') }}">

                        @endif
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="profileDropdown"
                        data-bs-display="static">
                        <li><a class="dropdown-item" href="{{ url('/profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form action="{{ url('/login') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item" href="#">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>



        </div>

    </header>

    <!-- sidebar-->

    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="#" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span
                        class="nav_logo-name">AssignPro</span></a>
                <div class="nav_list">
                    <!-- sidebar items-->



                    <a href="{{ url('/') }}" class="nav_link {{ request()->is('/') ? 'active' : '' }}">
                        <i class='bx bx-grid-alt nav_icon'></i>
                        <span class="nav_name">Dashboard</span>
                    </a>


                    @if (optional(auth()->user()->role)->isadmin)
                        <a href="{{ url('/pending_users') }}"
                            class="nav_link {{ request()->is('pending_users') ? 'active' : '' }}">
                            <i class="bi bi-person-exclamation" style="padding-left: 2px; font-size: 18px;"></i>
                            <span class="nav_name">Pending users</span>
                        </a>

                        <a href="{{ url('/departements') }}"
                            class="nav_link {{ request()->is('departements') ? 'active' : '' }}">
                            <i class='bx bx-buildings nav_icon'></i>
                            <span class="nav_name">Departements</span>
                        </a>

                        <a href="{{ url('/filieres') }}"
                            class="nav_link {{ request()->is('filieres') ? 'active' : '' }}">
                            <i class='bx bx-book-open nav_icon'></i>
                            <span class="nav_name">Filieres</span>
                        </a>

                        <a href="{{ url('/professeurs') }}"
                            class="nav_link {{ request()->is('professeurs') ? 'active' : '' }}">
                            <i class="bi bi-person-video3" style="padding-left: 2px; font-size: 17px;"></i>
                            <span class="nav_name">Professeurs</span>
                        </a>

                        <a href="{{ url('/etudiants') }}"
                            class="nav_link {{ request()->is('etudiants') ? 'active' : '' }}">
                            <i class="bi bi-people-fill" style="padding-left: 2px; font-size: 16px;"></i>
                            <span class="nav_name">Etudiants</span>
                        </a>

                        <a href="{{ url('/admins') }}"
                            class="nav_link {{ request()->is('admins') ? 'active' : '' }}">
                            <i class="bi bi-person-gear" style="padding-left: 2px; font-size: 18px;"></i>
                            <span class="nav_name">Admins</span>
                        </a>
                    @endif


                    <a href="{{ url('/profile') }}" class="nav_link {{ request()->is('profile') ? 'active' : '' }}">
                        <i class='bx bx-id-card nav_icon'></i>
                        <span class="nav_name">Profile</span>
                    </a>

                </div>
            </div>
            <a href="{{ url('/login') }}" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span
                    class="nav_name">Deconnexion

                </span> </a>
        </nav>
    </div>
    <!--Container Main start-->


    {{ $slot }}

    <!--Container Main end-->

    <script>
        function showSearchBar() {
            document.getElementById('searshBarContainer').classList.remove('hidden');
            document.getElementById('header-content').classList.add('hidden');
        }

        function closeSearchBar() {
            document.getElementById('searshBarContainer').classList.add('hidden');
            document.getElementById('header-content').classList.remove('hidden');

        }
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function(event) {

            const showNavbar = (toggleId, navId, bodyId, headerId) => {
                const toggle = document.getElementById(toggleId),
                    nav = document.getElementById(navId),
                    bodypd = document.getElementById(bodyId),
                    headerpd = document.getElementById(headerId)

                // Validate that all variables exist
                if (toggle && nav && bodypd && headerpd) {
                    toggle.addEventListener('click', () => {
                        // show navbar
                        nav.classList.toggle('show')
                        // change icon
                        toggle.classList.toggle('bx-x')
                        // add padding to body
                        bodypd.classList.toggle('body-pd')
                        // add padding to header
                        headerpd.classList.toggle('body-pd')
                    })
                }
            }

            showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header')

            /*===== LINK ACTIVE =====*/
            const linkColor = document.querySelectorAll('.nav_link')

            function colorLink() {
                if (linkColor) {
                    linkColor.forEach(l => l.classList.remove('active'))
                    this.classList.add('active')
                }
            }
            linkColor.forEach(l => l.addEventListener('click', colorLink))

            // Your code to run since DOM is loaded and ready
        });
    </script>
</body>


</html>

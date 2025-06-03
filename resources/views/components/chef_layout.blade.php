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

    @vite(['resources/css/admin-dashboard.css','resources/css/sb-admin-2.css','resources/vendor/fontawesome-free/css/all.min.css' ,'resources/js/app.js','resources/vendor/jquery/jquery.min.js','resources/vendor/bootstrap/js/bootstrap.bundle.min.js','resources/vendor/jquery-easing/jquery.easing.min.js','resources/js/sb-admin-2.min.js','resources/vendor/chart.js/Chart.min.js','resources/js/demo/chart-area-demo.js','resources/js/demo/chart-pie-demo.js'])
  
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    

<style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");
    :root{
        --header-height: 3rem;
        --nav-width: 80px;
        --sidebar-expanded-width: 250px;
        --first-color: #4723D9;
        --first-color-light: #AFA5D9;
        --sidebar-color: #2A3042;
        --sidebar-text: #A2A4B9;
        --sidebar-active: #4723D9;
        --white-color: #F7F6FB;
        --body-font: 'Montserrat', sans-serif;
        --normal-font-size: 1rem;
        --z-fixed: 100;
    }
    *,::before,::after{box-sizing: border-box}
    body{
        position: relative;
        margin: var(--header-height) 0 0 0;
        padding: 0 2rem;
        font-family: var(--body-font);
        font-size: var(--normal-font-size);
        transition: .5s;
        background-color: #f7f7fb;
    }
    
    .modal-backdrop {
      position: fixed !important;
      top: 0;
      left: 0;
      width: 100% !important;
      height: 100% !important;
      z-index: 1040;
      background-color: rgba(0, 0, 0, 0.5);
    }
    a{text-decoration: none}
    .header{
        width: 100%;
        height: var(--header-height);
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content:center;
        background-color: var(--white-color);
        z-index: var(--z-fixed);
        transition: .5s;
    }

    .header-content{
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

    .header_toggle{
        color: var(--first-color);
        font-size: 1.5rem;
        cursor: pointer
    }

    /* Redesigned Sidebar */
    .l-navbar{
        position: fixed;
        top: 0;
        left: -30%;
        width: var(--nav-width);
        height: 100vh;
        background-color: var(--sidebar-color);
        padding: 1rem 0 0 0;
        transition: .5s;
        z-index: var(--z-fixed);
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .nav{
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden;
    }
    
    .nav_logo{
        display: flex;
        align-items: center;
        padding: 0 1rem 1.5rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .nav_logo-icon{
        font-size: 1.8rem;
        color: var(--white-color);
        margin-right: 1rem;
        min-width: 40px;
        text-align: center;
    }
    
    .nav_logo-name{
        color: var(--white-color);
        font-weight: 700;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .nav_list{
        padding: 0 0.5rem;
    }
    
    .nav_link{
        display: flex;
        align-items: center;
        color: var(--sidebar-text);
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        border-radius: 6px;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .nav_link:hover{
        background-color: rgba(255, 255, 255, 0.05);
        color: var(--white-color);
        text-decoration: none;
    }
    
    .nav_icon{
        font-size: 1.4rem;
        min-width: 40px;
        display: flex;
        justify-content: center;
    }
    
    .nav_name{
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s ease;
        font-size: 0.9rem;
    }
    
    .active{
        background-color: var(--sidebar-active);
        color: var(--white-color);
        font-weight: 600;
    }
    
    .active::before{
        display: none;
    }
    
    .show{
        left: 0;
    }
    
    .l-navbar.show{
        width: var(--sidebar-expanded-width);
    }
    
    .l-navbar.show .nav_logo-name,
    .l-navbar.show .nav_name{
        opacity: 1;
    }
    
    .body-pd{
        padding-left: calc(var(--nav-width) + 1rem);
    }
    
    .height-100{height:100vh}
    
    @media screen and (min-width: 768px){
        body{
            margin: calc(var(--header-height) + 1rem) 0 0 0;
            padding-left: calc(var(--nav-width) + 2rem);
        }
        
        .header{
            height: calc(var(--header-height) + 1rem);
            padding: 0 2rem 0 calc(var(--nav-width) + 2rem);
        }
    
        .l-navbar{
            left: 0;
            padding: 1rem 0 0 0;
        }
        
        .l-navbar.show{
            width: var(--sidebar-expanded-width);
        }
        
        .body-pd{
            padding-left: calc(var(--sidebar-expanded-width) + 2rem);
        }
    }
    
    /* Profile in sidebar */
    .sidebar-profile {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: auto;
    }
    
    .sidebar-profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 12px;
        border: 2px solid rgba(255, 255, 255, 0.2);
    }
    
    .sidebar-profile-info {
        opacity: 0;
        transition: opacity 0.3s ease;
        overflow: hidden;
    }
    
    .l-navbar.show .sidebar-profile-info {
        opacity: 1;
    }
    
    .sidebar-profile-name {
        color: var(--white-color);
        font-weight: 600;
        font-size: 0.9rem;
        white-space: nowrap;
        text-overflow: ellipsis;
        margin-bottom: 0;
    }
    
    .sidebar-profile-status {
        color: var(--sidebar-text);
        font-size: 0.75rem;
        margin-top: 2px;
    }
    
    .sidebar-logout-btn {
        background: none;
        border: none;
        color: var(--sidebar-text);
        padding: 0.5rem 1rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        width: 100%;
        transition: all 0.3s ease;
    }
    
    .sidebar-logout-btn:hover {
        background-color: rgba(255, 255, 255, 0.05);
        color: var(--white-color);
    }
    
    .sidebar-logout-icon {
        font-size: 1.4rem;
        min-width: 40px;
        display: flex;
        justify-content: center;
    }
    
    .sidebar-logout-text {
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s ease;
        font-size: 0.9rem;
    }
    
    .l-navbar.show .sidebar-logout-text {
        opacity: 1;
    }

    /* Keep all your existing search and header styles */
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
        cursor: pointer;
    }
    
    .search-container.active {
        width: 200px;
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
    
    #profileDropdown img{
        height: 40px;
        width: 40px;
        object-fit:cover;
        border: 1px solid #8585866b;
    }

    #profileDropdown img:hover{
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

    .notifications-container button{
        border: none;
        background: none;
    }

    .notifications-container button i{
        color: #424242 !important;
        font-size: 25px !important;
    }

    .notifications-container button i:hover {
        color: #7367f0 !important;
        transition: color 0.3s ease;
    }

    #searshBarContainer{
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

    #searchBar{
        display: flex;
        height: 100%;
        width: 100%;
        z-index: var(--z-fixed);
    }

    #searchBar input{
        width: 100%;
        height: 100%;
        padding-left:10px; 
        border: none;
        background: transparent;
    }

    #searchBar input:focus{
        outline: none;
    }

    #searchBar button{
        border: none;
        width: 40px;
        background: none;
    }

    .hidden {
        display: none !important;
    }
    
    .notification-menu  {
        max-width: 350px;
        width: 350px;
        box-shadow: 1px 1px 10px 2px #3333332d;
        overflow-x: hidden;
        white-space: normal;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .notification-menu li {
        word-break: break-word;
        white-space: normal;
    }

    .notification-menu a.dropdown-item {
        font-size: 14px;
        padding: 10px 15px;
        white-space: normal;
    }  
</style>
</head>

<body id="body-pd">
    @php
        $notifications = Auth::user()->notifications()->latest()->take(5)->get();
        $unreadCount = auth()->user()->unreadNotifications->count();
    @endphp
    
    <header class="header mt-3" id="header">
        <div id="searshBarContainer" class="hidden">
            <div id="searchBar">
                <button><i class='bx bx-search' id="search-icon"></i></button>
                <input type="text" name="search" id="search-input" placeholder="search..">
                <button onclick="closeSearchBar()"><i style="font-size: 27px;" class="bi bi-x"></i></button>
            </div>
        </div>

        <div id="header-content" class="header-content">
            <div class="header_toggle"> 
                <i class='bx bx-menu' id="header-toggle"></i> 
            </div>
            
            <div class="d-flex align-items-center">
                <div class="notifications-container ml-2" id="notifications-container">
                    <button onclick="showSearchBar()"><i class='bx bx-search' id="search-icon"></i></button>
                </div>

                <!-- Notification Dropdown -->
                <div class="dropdown ms-2">
                    <div class="notifications-container ml-2" id="notifications-container" data-bs-toggle="dropdown" aria-expanded="false">
                        <button id="notification" ><i class='bx bx-bell'></i>
                            @if($unreadCount > 0)
                            <span class="position-absolute  translate-middle badge rounded-pill bg-danger">
                                {{ $unreadCount }}
                            </span>
                           @endif
                        </button>
                    </div>

                    <ul class="dropdown-menu notification-menu dropdown-menu-end mt-2" aria-labelledby="notificationDropdown">
                        <li style="background-color: #4723D9;"><h6 class="dropdown-header" style="color: white;">Notifications</h6></li>
                        @if (!$notifications)
                        <li><a class="dropdown-item text-muted" href="#">No notifications</a></li>   
                        @else
                        @foreach ($notifications as $notification)
                        <li>
                            @if (is_null($notification->read_at)) 
                                <a class="dropdown-item" style="background-color:#1319c70d ; border-bottom: 1px solid #3333331d;" href="{{ route('notifications.read', $notification->id) }}"> 
                                    {{ $notification->data['message'] }} 
                                    <br><small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </a>
                                @else
                                <a class="dropdown-item" style="border-bottom: 1px solid #3333331b;" href="{{ route('notifications.read', $notification->id) }}">
                                    {{ $notification->data['message'] }}
                                    <br><small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </a>
                                @endif     
                            </li>
                        @endforeach
                        <li class="text-center pt-1"><a href="#">Voir tous les notifications</a></li>
                        @endif
                    </ul>
                </div>

                <div class="d-flex flex-column  ml-3">
                    <p style="color: #504f4f; font-weight: 600; font-size: 15px;" class="p-0 m-0">{{Auth()->user()->firstname}} {{Auth()->user()->lastname}}</p>
                    
                    @if (auth()->user()->user_details)
                    <p style=" {{Auth()->user()->user_details->status ==='active' ?  'color: #10a386;' :  'color: #cd4c35;'}} font-weight: 500; font-size: 12px;" class="p-0 m-0 text-end">{{Auth()->user()->user_details->status}}</p>
                    @else
                    <p style="color: #cd4c35; font-weight: 500; font-size: 12px;" class="p-0 m-0 text-end">inactive</p>
                    @endif
                </div>

                <!-- Profile picture dropdown -->
                <div class="dropdown ms-3">
                    <a href="#" class="d-flex align-items-center" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (Auth()->user()->user_details)
                        @if (Auth()->user()->user_details->profile_img!=null)
                        <img style=" border-radius:50%;" src="{{asset('storage/' . Auth()->user()->user_details->profile_img)}}">
                        @else
                        <img style=" border-radius:50%;" src="{{asset('storage/images/default_profile_img.png')}}">
                        @endif
                    @else
                        <img style="width: 35px; border-radius:50%;" src="{{asset('storage/images/default_profile_img.png')}}">
                    @endif                    
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="profileDropdown" data-bs-display="static">
                        <li><a class="dropdown-item" href="{{url("/profile")}}">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        
                        <li>
                            <form action="{{url('/login')}}" method="post">
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

    <!-- Redesigned Sidebar -->
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> 
                <a href="#" class="nav_logo"> 
                    <i class='bx bx-layer nav_logo-icon'></i> 
                    <span class="nav_logo-name">AssignPro</span>
                </a>
                
                <div class="nav_list"> 
                    <!-- sidebar items-->
                    <a href="{{url('/')}}" class="nav_link {{request()->is('/') ? 'active' : '' }}"> 
                        <i class='bx bx-grid-alt nav_icon'></i> 
                        <span class="nav_name">Dashboard</span> 
                    </a>

                    @if (optional(auth()->user()->role)->isadmin)
                    <a href="{{url('/departements')}}" class="nav_link {{request()->is('departements') ? 'active' : '' }}"> 
                        <i class='bx bx-buildings nav_icon'></i> 
                        <span class="nav_name">Departements</span> 
                    </a>
                    
                    <a href="{{url('/filieres')}}" class="nav_link {{request()->is('filieres') ? 'active' : '' }}"> 
                        <i class='bx bx-book-open nav_icon'></i> 
                        <span class="nav_name">Filieres</span> 
                    </a>
                    
                    <a href="{{url('/professeurs')}}" class="nav_link {{request()->is('professeurs') ? 'active' : '' }}"> 
                        <i class="bi bi-person-video3 nav_icon"></i>
                        <span class="nav_name">Professeurs</span> 
                    </a>
                    
                    <a href="{{url('/etudiants')}}" class="nav_link {{request()->is('etudiants') ? 'active' : '' }}"> 
                        <i class="bi bi-people-fill nav_icon"></i>
                        <span class="nav_name">Etudiants</span> 
                    </a>
                    
                    <a href="{{url('/admins')}}" class="nav_link {{request()->is('admins') ? 'active' : '' }}"> 
                        <i class="bi bi-person-gear nav_icon"></i>
                        <span class="nav_name">Admins</span> 
                    </a>
                    @endif
                    
                    <a href="{{url('/profile')}}" class="nav_link {{request()->is('profile') ? 'active' : '' }}"> 
                        <i class='bx bx-id-card nav_icon'></i> 
                        <span class="nav_name">Profile</span> 
                    </a>
                </div>
            </div>
            
            <!-- Sidebar Footer with Profile and Logout -->
            <div class="sidebar-profile">
                @if (Auth()->user()->user_details && Auth()->user()->user_details->profile_img)
                <img src="{{asset('storage/' . Auth()->user()->user_details->profile_img)}}" class="sidebar-profile-img">
                @else
                <img src="{{asset('storage/images/default_profile_img.png')}}" class="sidebar-profile-img">
                @endif
                
                <div class="sidebar-profile-info">
                    <p class="sidebar-profile-name">{{Auth()->user()->firstname}} {{Auth()->user()->lastname}}</p>
                    @if (auth()->user()->user_details)
                    <p class="sidebar-profile-status" style="{{Auth()->user()->user_details->status ==='active' ?  'color: #10a386;' :  'color: #cd4c35;'}}">
                        {{Auth()->user()->user_details->status}}
                    </p>
                    @else
                    <p class="sidebar-profile-status" style="color: #cd4c35;">inactive</p>
                    @endif
                </div>
                
                <button class="sidebar-logout-btn" onclick="document.querySelector('form[action=\'{{url('/login')}}\']').submit()">
                    <i class='bx bx-log-out sidebar-logout-icon'></i>
                    <span class="sidebar-logout-text">Logout</span>
                </button>
            </div>
        </nav>
    </div>
    
    <!--Container Main start-->
    {{$slot}}
    <!--Container Main end-->

    <script>
        function showSearchBar() {
            document.getElementById('searshBarContainer').classList.remove('hidden');
            document.getElementById('header-content').classList.add('hidden');
        }

        function closeSearchBar(){
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
                
                if(toggle && nav && bodypd && headerpd){
                    toggle.addEventListener('click', ()=>{
                        nav.classList.toggle('show')
                        toggle.classList.toggle('bx-x')
                        bodypd.classList.toggle('body-pd')
                        headerpd.classList.toggle('body-pd')
                    })
                }
            }
            
            showNavbar('header-toggle','nav-bar','body-pd','header')
            
            const linkColor = document.querySelectorAll('.nav_link')
            
            function colorLink(){
                if(linkColor){
                    linkColor.forEach(l=> l.classList.remove('active'))
                    this.classList.add('active')
                }
            }
            linkColor.forEach(l=> l.addEventListener('click', colorLink))
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
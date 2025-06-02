<a href="{{ route('mesModules') }}" class="nav_link {{ request()->is('professor/mesModules') ? 'active' : '' }}">
    <i class="fas fa-book-open"></i>
    <span class="nav_name">Mes Modules</span>
</a>


<a href="{{ route('notes_upload_page') }}" class="nav_link {{ request()->is('professor/upload-notes') ? 'active' : '' }}">
    <i class="fas fa-edit"></i> <!-- Changed to edit icon - more appropriate for "saisir" -->
    <span class="nav_name">Saisir les notes</span>
</a>

<a href="{{ route('emploi.myTimetable') }}" class="nav_link {{ request()->is('my-timetable') ? 'active' : '' }}">
    <i class="fas fa-table"></i> <!-- Changed to table icon - represents timetable better -->
    <span class="nav_name">Emploi du Temps</span>
</a>

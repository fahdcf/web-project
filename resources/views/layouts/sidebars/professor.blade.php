                <!-- Dashboard -->


                <a href="{{ route('mesModules') }}"
                    class="nav_link {{ request()->is('professor/mesModules') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> <!-- Changed from fa-book-open to fa-book (simpler book icon) -->
                    <span class="nav_name">Mes Modules</span>
                </a>

                <a href="{{ route('professor.myRequests') }}"
                    class="nav_link {{ request()->is('professor/requests') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <!-- Changed to clipboard with list - clearer for "demandes" -->
                    <span class="nav_name">Mes Demandes</span>
                </a>

                <a href="{{ route('availableModules') }}"
                    class="nav_link {{ request()->is('professor/availableModules') ? 'active' : '' }}">
                    <i class="fas fa-book-medical"></i> <!-- Changed to book with plus sign - indicates availability -->
                    <span class="nav_name">Modules disponibles</span>
                </a>

                <a href="{{ route('notes_upload_page') }}"
                    class="nav_link {{ request()->is('professor/upload-notes') ? 'active' : '' }}">
                    <i class="fas fa-edit"></i> <!-- Changed to edit icon - more appropriate for "saisir" -->
                    <span class="nav_name">Saisir les notes</span>
                </a>

                <a href="{{ route('emploi.myTimetable') }}"
                    class="nav_link {{ request()->is('my-timetable') ? 'active' : '' }}">
                    <i class="fas fa-table"></i> <!-- Changed to table icon - represents timetable better -->
                    <span class="nav_name">Emploi du Temps</span>
                </a>
                {{-- 

<!-- Dashboard -->
<a href="{{ route('mesModules') }}" class="nav_link {{ request()->is('professor/mesModules') ? 'active' : '' }}">
    <i class="fas fa-book-open fa-2x" style="color: #330bcf;"></i>
    <span class="nav_name">Mes Modules</span>
</a>

<a href="{{ route('professor.myRequests') }}" class="nav_link {{ request()->is('professor/requests') ? 'active' : '' }}">
    <i class="fas fa-clipboard-list fa-2x" style="color: #330bcf;"></i>
    <span class="nav_name">Mes Demandes</span>
</a>

<a href="{{ route('availableModules') }}" class="nav_link {{ request()->is('professor/availableModules') ? 'active' : '' }}">
    <i class="fas fa-book-medical fa-2x" style="color: #330bcf;"></i>
    <span class="nav_name">Modules disponibles</span>
</a>

<a href="{{ route('notes_upload_page') }}" class="nav_link {{ request()->is('professor/upload-notes') ? 'active' : '' }}">
    <i class="fas fa-edit fa-2x" style="color: #330bcf;"></i>
    <span class="nav_name">Saisir les notes</span>
</a>

<a href="{{ route('emploi.myTimetable') }}" class="nav_link {{ request()->is('my-timetable') ? 'active' : '' }}">
    <i class="fas fa-table fa-2x" style="color: #330bcf;"></i>
    <span class="nav_name">Emploi du Temps</span>
</a> --}}

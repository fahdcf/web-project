                <!-- Dashboard -->


                <a href="{{ route('mesModules') }}" class="nav_link {{ request()->is('professor/mesModules') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i>
                    <span class="nav_name">Mes Modules</span>
                </a>


                <a href="{{ route('professor.myRequests') }}" class="nav_link {{ request()->is('professor/requests') ? 'active' : '' }}">
                    <i class="fas fa-list-alt"></i> {{-- Changed from fa-history to fa-list-alt --}}
                    <span class="nav_name">Mes Demandes</span> {{-- Changed "Mes choix" to "Mes Demandes" --}}
                </a>

                <a href="{{ route('availableModules') }}" class="nav_link {{ request()->is('professor/availableModules') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark-fill"></i> <!-- Modules disponibles -->
                    <span class="nav_name">Modules disponibles</span>
                </a>

                <a href="{{ route('notes_upload_page') }}" class="nav_link {{ request()->is('professor/upload-notes') ? 'active' : '' }}">
                    <i class="fas fa-file-upload"></i> {{-- Changed from fa-upload to fa-file-upload --}}
                    <span class="nav_name">Saisir les notes</span>
                </a>

                <a href="{{ route('emploi.myTimetable') }}" class="nav_link {{ request()->is('my-timetable') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> {{-- Changed from fa-upload to fa-file-upload --}}
                    <span class="nav_name">Emploi du Temps</span>
                </a>


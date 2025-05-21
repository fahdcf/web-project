<a href="{{ route('mesModules') }}"

    class="nav_link {{ request()->is('professor/mesModules') ? 'active' : '' }}">
    <i class="fas fa-book-open"></i>
    <span class="nav_name">Mes Modules</span>
</a>


<a href="{{ route('notes_upload_page') }}"
    class="nav_link {{ request()->is('professor/upload-notes') ? 'active' : '' }}">
    <i class="fas fa-file-upload"></i>
    <span class="nav_name">Saisir les notes</span>
</a>

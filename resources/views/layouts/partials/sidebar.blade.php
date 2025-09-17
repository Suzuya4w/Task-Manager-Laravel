<div class="sidebar" id="sidebar">
    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-house-door"></i> <span class="nav-text">Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('projects*') ? 'active' : '' }}"
                href="{{ route('projects.index') }}">
                <i class="bi bi-folder"></i> <span class="nav-text">Proyek</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('tasks') ? 'active' : '' }}" href="{{ route('tasks.index') }}">
                <i class="bi bi-list-task"></i> <span class="nav-text">Semua Tugas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('notes') ? 'active' : '' }}" href="{{ route('notes.index') }}">
                <i class="bi bi-journal-text"></i> <span class="nav-text">Catatan</span>
            </a>
        </li>
    

        @if(Auth::user()->role === 'manager')
            <li class="nav-item">
                <a class="nav-link {{ request()->is('list') ? 'active' : '' }}" href="{{ route('tasks.list') }}">
                    <i class="bi bi-list-check"></i> <span class="nav-text"> Task List</span>
                </a>
            </li>
        @endif
        <li class="nav-item mt-auto">
            <button class="nav-link text-start w-100" id="closeSidebarBtn" style="background: none; border: none;">
                <i class="bi bi-chevron-left"></i> <span class="nav-text">Tutup Sidebar</span>
            </button>
        </li>
    </ul>
</div>
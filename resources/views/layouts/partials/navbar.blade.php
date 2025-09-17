<header class="topnav mb-4 d-flex align-items-center position-fixed" style="z-index: 800; width: 100%">
    <nav class="navbar navbar-expand-lg navbar-light w-100">
        <div class="container-fluid px-0">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list" id="toggleIcon"></i>
            </button>
                <span class="fw-semibold" id="currentDateTime"></span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">


<li class="nav-item dropdown" style="margin-right: 15px;">
                        <a class="nav-link position-relative" href="#" id="reminderDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell" style="font-size:1.2rem;"></i>
                            @php
                                // Hitung tugas yang belum selesai (to_do atau in_progress)
                                $tasksCount = Auth::user()->tasks()
                                    ->whereIn('status', ['to_do', 'in_progress'])
                                    ->count();
                            @endphp
                            @if($tasksCount > 0)
                                <span class="badge-on-bell badge rounded-pill bg-danger">
                                    {{ $tasksCount }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="reminderDropdown" style="width: 300px; max-height: 400px; overflow-y:auto;">
                            @php
                                // Ambil tugas yang belum selesai (max 5, urut berdasarkan created_at desc)
                                $pendingTasks = Auth::user()->tasks()
                                    ->whereIn('status', ['to_do', 'in_progress'])
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();
                            @endphp
                            
                            @if($pendingTasks->count() > 0)
                                <li class="dropdown-header text-center fw-bold">Tugas Belum Selesai</li>
                                @foreach($pendingTasks as $task)
                                    <li>
                                        <a class="dropdown-item small" href="{{ route('tasks.show', $task->id) }}">
                                            <div class="d-flex justify-content-between">
                                                <strong>{{ $task->title }}</strong>
                                                @if($task->due_date)
                                                    <span class="badge bg-primary">{{ $task->due_date }}</span>
                                                @else
                                                    <span class="badge bg-secondary">No Due Date</span>
                                                @endif
                                            </div>
                                            <small class="text-muted d-block mt-1">
                                                <i class="bi bi-flag"></i> {{ ucfirst($task->priority) }} Priority
                                            </small>
                                            @if($task->description)
                                                <small class="text-muted d-block mt-1">
                                                    {{ \Illuminate\Support\Str::limit($task->description, 50) }}
                                                </small>
                                            @endif
                                        </a>
                                    </li>
                                    @if(!$loop->last)
                                        <li><hr class="dropdown-divider m-1"></li>
                                    @endif
                                @endforeach
                                <li class="dropdown-item text-center">
                                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-primary w-100">
                                        Lihat Semua Tugas
                                    </a>
                                </li>
                            @else
                                <li class="dropdown-item text-center text-muted py-3">
                                    <i class="bi bi-check-circle" style="font-size: 2rem;"></i>
                                    <p class="mt-2 mb-0">Tidak ada tugas yang belum selesai</p>
                                </li>
                            @endif
                        </ul>
                    </li>



                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
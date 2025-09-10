@extends('layouts.app')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1 fw-bold text-dark">Selamat Datang di Dashboard</h2>
                <p class="text-muted mb-0">Kelola <strong>tugas, rutinitas, catatan, dan file</strong> Anda dari satu tempat</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 py-2 dashboard-card task-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                    TOTAL TUGAS
                                </div>
                                <div class="h2 mb-0 fw-bold text-gray-800">{{ $tasksCount }}</div>
                                <p class="mt-2 mb-0 text-muted">
                                    <span class="text-nowrap"><strong>{{ $tasksCount }} tugas</strong> tertunda</span>
                                </p>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-primary">
                                    <i class="bi bi-list-task text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent d-flex align-items-center justify-content-between border-top-0 py-3">
                        <a href="{{ route('projects.index') }}" class="text-decoration-none fw-bold text-primary stretched-link">LIHAT TUGAS</a>
                        <i class="bi bi-arrow-right-short text-primary fs-5"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 py-2 dashboard-card routine-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                    RUTINITAS HARI INI
                                </div>
                                <div class="h2 mb-0 fw-bold text-gray-800">{{ $routinesCount }}</div>
                                <p class="mt-2 mb-0 text-muted">
                                    <span class="text-nowrap"><strong>{{ $routinesCount }} rutinitas</strong> terjadwal</span>
                                </p>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-success">
                                    <i class="bi bi-calendar-check text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent d-flex align-items-center justify-content-between border-top-0 py-3">
                        <a href="{{ route('routines.index') }}" class="text-decoration-none fw-bold text-success stretched-link">LIHAT RUTINITAS</a>
                        <i class="bi bi-arrow-right-short text-success fs-5"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 py-2 dashboard-card note-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                    TOTAL CATATAN
                                </div>
                                <div class="h2 mb-0 fw-bold text-gray-800">{{ $notesCount }}</div>
                                <p class="mt-2 mb-0 text-muted">
                                    <span class="text-nowrap"><strong>{{ $notesCount }} catatan</strong> tersimpan</span>
                                </p>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-info">
                                    <i class="bi bi-sticky text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent d-flex align-items-center justify-content-between border-top-0 py-3">
                        <a href="{{ route('notes.index') }}" class="text-decoration-none fw-bold text-info stretched-link">LIHAT CATATAN</a>
                        <i class="bi bi-arrow-right-short text-info fs-5"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 py-2 dashboard-card file-card">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                    TOTAL FILE
                                </div>
                                <div class="h2 mb-0 fw-bold text-gray-800">{{ $filesCount }}</div>
                                <p class="mt-2 mb-0 text-muted">
                                    <span class="text-nowrap"><strong>{{ $filesCount }} file</strong> disimpan</span>
                                </p>
                            </div>
                            <div class="col-auto">
                                <div class="icon-circle bg-warning">
                                    <i class="bi bi-file-earmark text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent d-flex align-items-center justify-content-between border-top-0 py-3">
                        <a href="{{ route('files.index') }}" class="text-decoration-none fw-bold text-warning stretched-link">LIHAT FILE</a>
                        <i class="bi bi-arrow-right-short text-warning fs-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Recent Tasks -->
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between border-bottom">
                        <h6 class="m-0 fw-bold text-primary">
                            <i class="bi bi-list-task me-2"></i>TUGAS TERBARU
                        </h6>
                        <a href="{{ route('tasks.index') }}" class="text-decoration-none fw-bold text-primary small">LIHAT SEMUA <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($recentTasks as $task)
                                <div class="list-group-item border-0 px-0 py-3 d-flex align-items-center">
                                    <div class="bg-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-circle-fill text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold">{{ Str::limit($task->title, 30) }}</h6>
                                            <span class="badge bg-{{ $task->status == 'to_do' ? 'secondary' : 'primary' }} rounded-pill fw-normal">
                                                {{ $task->status == 'to_do' ? 'TO DO' : 'IN PROGRESS' }}
                                            </span>
                                        </div>
                                        <p class="text-muted small mb-0">
                                            <i class="bi bi-calendar me-1"></i> 
                                            <strong>Due:</strong> {{ $task->due_date ? $task->due_date->format('d M Y') : 'Tidak ada tenggat waktu' }}
                                        </p>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-2">
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Routines -->
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between border-bottom">
                        <h6 class="m-0 fw-bold text-success">
                            <i class="bi bi-calendar-check me-2"></i>RUTINITAS HARI INI
                        </h6>
                        <a href="{{ route('routines.index') }}" class="text-decoration-none fw-bold text-success small">LIHAT SEMUA <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($todayRoutines as $routine)
                                <div class="list-group-item border-0 px-0 py-3 d-flex align-items-center">
                                    <div class="bg-success rounded-circle p-2 me-3 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-arrow-repeat text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold">{{ Str::limit($routine->title, 30) }}</h6>
                                            <span class="badge bg-light text-dark rounded-pill fw-normal">{{ $routine->frequency }}</span>
                                        </div>
                                        <p class="text-muted small mb-0">
                                            @if($routine->time)
                                                <i class="bi bi-clock me-1"></i> 
                                                <strong>Waktu:</strong> {{ $routine->time->format('H:i') }}
                                            @else
                                                <i class="bi bi-info-circle me-1"></i> 
                                                <strong>Tidak ada waktu spesifik</strong>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-2">
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Notes -->
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between border-bottom">
                        <h6 class="m-0 fw-bold text-info">
                            <i class="bi bi-sticky me-2"></i>CATATAN TERBARU
                        </h6>
                        <a href="{{ route('notes.index') }}" class="text-decoration-none fw-bold text-info small">LIHAT SEMUA <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($recentNotes as $note)
                                <div class="list-group-item border-0 px-0 py-3 d-flex align-items-center">
                                    <div class="bg-info rounded-circle p-2 me-3 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journal-text text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold">{{ Str::limit($note->title, 35) }}</h6>
                                        <p class="text-muted small mb-0">
                                            <strong>Konten:</strong> {{ Str::limit(strip_tags($note->content), 60) }}
                                        </p>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-2">
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Reminders -->
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between border-bottom">
                        <h6 class="m-0 fw-bold text-warning">
                            <i class="bi bi-bell me-2"></i>PENGINGAT MENDATANG
                        </h6>
                        <a href="{{ route('reminders.index') }}" class="text-decoration-none fw-bold text-warning small">LIHAT SEMUA <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($upcomingReminders as $reminder)
                                <div class="list-group-item border-0 px-0 py-3 d-flex align-items-center 
                                    {{ $reminder->date->isToday() ? 'bg-warning bg-opacity-10' : 
                                       ($reminder->date->isPast() ? 'bg-danger bg-opacity-10' : 'bg-success bg-opacity-10') }}">
                                    <div class="rounded-circle p-2 me-3 d-flex align-items-center justify-content-center
                                        {{ $reminder->date->isToday() ? 'bg-warning' : 
                                           ($reminder->date->isPast() ? 'bg-danger' : 'bg-success') }}">
                                        <i class="bi bi-clock text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold">{{ Str::limit($reminder->title, 30) }}</h6>
                                            <span class="badge fw-bold
                                                {{ $reminder->date->isToday() ? 'bg-warning' : 
                                                   ($reminder->date->isPast() ? 'bg-danger' : 'bg-success') }} rounded-pill">
                                                {{ $reminder->date->format('d M') }} 
                                                @if($reminder->time)
                                                    {{ $reminder->time->format('H:i') }}
                                                @endif
                                            </span>
                                        </div>
                                        <p class="small mb-0 fw-bold
                                            {{ $reminder->date->isToday() ? 'text-warning' : 
                                               ($reminder->date->isPast() ? 'text-danger' : 'text-success') }}">
                                            @if($reminder->date->isToday())
                                                ⚡ <strong>HARI INI</strong>
                                            @elseif($reminder->date->isPast())
                                                ⚠️ <strong>TERLEWAT - {{ $reminder->date->diffForHumans() }}</strong>
                                            @else
                                                🗓️ <strong>{{ $reminder->date->diffForHumans() }}</strong>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-2">
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .dashboard-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-left: 4px solid transparent;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        
        .task-card:hover {
            border-left-color: #2563eb;
        }
        
        .routine-card:hover {
            border-left-color: #10b981;
        }
        
        .note-card:hover {
            border-left-color: #0ea5e9;
        }
        
        .file-card:hover {
            border-left-color: #f59e0b;
        }
        
        .icon-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50px;
            width: 50px;
            border-radius: 50%;
            font-size: 1.2rem;
        }
        
        .card-header {
            border-bottom: 2px solid #e5e7eb !important;
        }
        
        .list-group-item {
            transition: background-color 0.2s ease;
            border-radius: 8px !important;
        }
        
        .list-group-item:hover {
            background-color: #f9fafb;
        }
        
        .rounded-circle {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        h2, h6, .fw-bold {
            font-weight: 700 !important;
        }
        
        .h2 {
            font-size: 1.8rem !important;
        }
        
        .text-xs {
            font-size: 0.8rem !important;
        }
        
        .stretched-link::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1;
            pointer-events: auto;
            content: "";
            background-color: rgba(0,0,0,0);
        }
    </style>
@endsection
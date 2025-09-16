@extends('layouts.app')
@section('title')
    Detail Proyek - {{ $project->name }}
@endsection
@section('content')
    <div class="container">

        <div class="bg-white align-items-center mb-4 shadow-sm p-3 rounded d-flex justify-content-between">
            <!-- Tombol kembali di kiri -->
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                ← Kembali
            </a>

            <!-- Judul di tengah -->
            <h2 class="text-center flex-grow-1 m-0">Proyek - {{ $project->name }}</h2>

            <!-- Spacer agar h2 tetap center -->
            <div style="width:90px;"></div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-7">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $project->name }}</h5>
                        <p class="card-text">{{ $project->description }}</p>
                        <p class="card-text"><strong>Pembuat:</strong> {{ $project->user->name }}</p>
                        <p class="card-text"><strong>Tanggal Mulai:</strong>
                            {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->translatedFormat('d F Y') : '-' }}
                        </p>
                        <p class="card-text"><strong>Tanggal Berakhir:</strong>
                            @if(!$project->end_date)
                                <span class="text-muted">Tanpa Batas Waktu</span>
                            @else
                                {{ \Carbon\Carbon::parse($project->end_date)->translatedFormat('d F Y') }}
                                @if($project->end_date->isPast())
                                    <span class="badge bg-danger ms-2">Sudah Lewat</span>
                                @endif
                            @endif
                        </p>
                        
                        <p class="card-text"><strong>Status:</strong>
                            @php
                                $status = $project->status;
                                $badgeClass = match($status) {
                                    'Belum Dikerjakan' => 'secondary',
                                    'Sedang Dikerjakan' => 'warning',
                                    'Selesai' => 'success',
                                    'Terlambat' => 'danger',
                                    default => 'dark',
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }}">{{ $status }}</span>
                        </p>

                        <p class="card-text"><strong>Anggaran:</strong> Rp{{ number_format($project->budget, 0, ',', '.') }}</p>

                        <h5 class="mt-4">Kemajuan Proyek</h5>
                        @php
                            $totalTasks = $project->tasks->count();
                            $completedTasks = $project->tasks->where('status', 'completed')->count();
                            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                        @endphp
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%;"
                                aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                {{ round($progress) }}%
                            </div>
                        </div>
                        <small class="text-muted">Selesai {{ $completedTasks }} dari {{ $totalTasks }} tugas</small>
                    </div>
                </div>

                <!-- Daftar Tugas -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Tugas</h5>
                        @if($totalTasks > 0)
                            <ul class="list-group">
                                @foreach($project->tasks as $task)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $task->title }}</span>
                                        <span class="badge bg-{{ $task->status_color }}">
                                            {{ $task->status_label }}
                                        </span>

                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Belum ada tugas di proyek ini.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Anggota Tim -->
            <div class="col-md-5">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Anggota Tim</h5>
                            @if(Auth::user()->role === 'manager')
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addMemberModal"> <i class="bi bi-plus-circle"></i> Tambah </button>
                            @endif
                        </div>

                        <div class="row">
                            @foreach ($teamMembers as $user)
                                <div class="col-12">
                                    <div class="card mb-2">
                                        <div class="card-body py-2">
                                            <p class="card-title fw-bold mb-0">{{ $user->name }}</p>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if($teamMembers->isEmpty())
                                <p class="text-muted">Belum ada anggota tim.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Anggota -->
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberModalLabel">Tambah Anggota Tim</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('projects.addMember') }}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Pilih Pengguna</label>
                            <select class="form-select" name="user_id" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

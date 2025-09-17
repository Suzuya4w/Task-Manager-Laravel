@extends('layouts.app')
@section('title')
    Task List - Manager View
@endsection
@section('content')
    <div class="container">
        <h2 class="mb-4">Daftar Tugas</h2>
        
        <!-- Filter Options -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="btn-group">
                    <a href="{{ route('tasks.list') }}?filter=all" 
                       class="btn btn-outline-primary {{ request('filter', 'all') == 'all' ? 'active' : '' }}">
                        Semua Tugas
                    </a>
                    <a href="{{ route('tasks.list') }}?filter=with_files" 
                       class="btn btn-outline-primary {{ request('filter') == 'with_files' ? 'active' : '' }}">
                        Dengan File
                    </a>
                    <a href="{{ route('tasks.list') }}?filter=with_notes" 
                       class="btn btn-outline-primary {{ request('filter') == 'with_notes' ? 'active' : '' }}">
                        Dengan Catatan
                    </a>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <span class="text-muted">Menampilkan {{ $tasks->count() }} Tugas</span>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if($tasks->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul Tugas</th>
                                    <th>Proyek</th>
                                    <th>Ditugaskan ke</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th>File</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>
                                            <strong>{{ $task->title }}</strong>
                                            @if($task->description)
                                                <br><small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $task->project->name }}</td>
                                        <td>{{ $task->user->name }}</td>
                                        <td>
                                            @if($task->due_date)
                                                {{ $task->due_date->format('M d, Y') }}
                                                @if($task->due_date->isPast() && $task->status != 'completed')
                                                    <br><span class="badge bg-danger">Terlambat</span>
                                                @endif
                                            @else
                                                <span class="text-muted">Tidak ada tanggal berakhir</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ 
                                                $task->priority == 'Rendah' ? 'bg-success' : 
                                                ($task->priority == 'Sedang' ? 'bg-warning' : 'bg-danger') 
                                            }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ 
                                                $task->status == 'Selesai' ? 'bg-success' : 
                                                ($task->status == 'Sedang Dikerjakan' ? 'bg-warning' : 'bg-primary') 
                                            }}">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($task->file_path)
                                                <a href="{{ asset('storage/' . $task->file_path) }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Download attached file">
                                                    <i class="bi bi-download"></i> File
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($task->notes)
                                                <button class="btn btn-sm btn-outline-info" 
                                                        data-bs-toggle="popover" 
                                                        data-bs-title="Catatan untuk {{ $task->title }}"
                                                        data-bs-content="{{ $task->notes }}"
                                                        data-bs-html="true">
                                                    <i class="bi bi-chat-text"></i> View
                                                </button>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('tasks.show', $task->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="View task details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($tasks->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $tasks->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <h4 class="text-muted mt-3">No tasks found</h4>
                        <p class="text-muted">
                            @if(request('filter') == 'with_files')
                                Tidak ada tugas dengan lampiran file..
                            @elseif(request('filter') == 'with_notes')
                                Tidak ada tugas dengan lampiran catatan.
                            @else
                                Tidak ada tugas yang tersedia.
                            @endif
                        </p>
                        <a href="{{ route('projects.index') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle"></i> Buat Proyek Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Enable popovers for notes
        document.addEventListener('DOMContentLoaded', function() {
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl, {
                    trigger: 'click',
                    placement: 'left'
                });
            });
        });
    </script>
@endsection
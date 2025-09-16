@extends('layouts.app')
@section('title')
    Task List - Manager View
@endsection
@section('content')
    <div class="container">
        <h2 class="mb-4">Task List - Manager Overview</h2>
        
        <!-- Filter Options -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="btn-group">
                    <a href="{{ route('tasks.list') }}?filter=all" 
                       class="btn btn-outline-primary {{ request('filter', 'all') == 'all' ? 'active' : '' }}">
                        All Tasks
                    </a>
                    <a href="{{ route('tasks.list') }}?filter=with_files" 
                       class="btn btn-outline-primary {{ request('filter') == 'with_files' ? 'active' : '' }}">
                        With Files
                    </a>
                    <a href="{{ route('tasks.list') }}?filter=with_notes" 
                       class="btn btn-outline-primary {{ request('filter') == 'with_notes' ? 'active' : '' }}">
                        With Notes
                    </a>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <span class="text-muted">Showing {{ $tasks->count() }} tasks</span>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if($tasks->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Task Title</th>
                                    <th>Project</th>
                                    <th>Assigned To</th>
                                    <th>Due Date</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>File</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
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
                                                    <br><span class="badge bg-danger">Overdue</span>
                                                @endif
                                            @else
                                                <span class="text-muted">No due date</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ 
                                                $task->priority == 'low' ? 'bg-success' : 
                                                ($task->priority == 'medium' ? 'bg-warning' : 'bg-danger') 
                                            }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ 
                                                $task->status == 'completed' ? 'bg-success' : 
                                                ($task->status == 'in_progress' ? 'bg-warning' : 'bg-primary') 
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
                                                        data-bs-title="Notes for {{ $task->title }}"
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
                                No tasks with file attachments.
                            @elseif(request('filter') == 'with_notes')
                                No tasks with notes.
                            @else
                                No tasks available.
                            @endif
                        </p>
                        <a href="{{ route('projects.index') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle"></i> Create New Project
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
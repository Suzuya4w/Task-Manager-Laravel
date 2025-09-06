@extends('layouts.app')
@section('title')
    All Tasks
@endsection
@section('content')
    <style>
        .kanban-column {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            height: 100%;
        }

        .kanban-list {
            min-height: 500px;
            background-color: #e9ecef;
            border-radius: 5px;
            padding: 10px;
        }

        .kanban-item {
            cursor: move;
        }

        .kanban-item.invisible {
            opacity: 0.4;
        }
        
        .project-badge {
            font-size: 0.75rem;
            background-color: #6c757d;
            color: white;
        }
        
        .task-card {
            border-left: 4px solid;
        }
        
        .priority-low {
            border-left-color: #28a745;
        }
        
        .priority-medium {
            border-left-color: #ffc107;
        }
        
        .priority-high {
            border-left-color: #dc3545;
        }
    </style>
    <div class="container">
        <div class="bg-white align-items-center mb-4 shadow-sm p-3 rounded">
            <h2 class="text-center">All My Tasks</h2>
            <p class="text-center text-muted mb-0">Tasks from all your projects</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="kanban-column">
                    <div class="d-flex justify-content-between bg-primary text-white shadow-sm align-items-center px-3 py-2 rounded-top">
                        <h4 class="text-white fw-bolder m-0">To Do</h4>
                        <span class="badge bg-light text-dark">{{ count($tasks['to_do']) }}</span>
                    </div>
                    
                    <div class="kanban-list" id="to_do">
                        @foreach ($tasks['to_do'] as $task)
                            <div class="card mb-3 kanban-item task-card priority-{{ $task->priority }}" data-id="{{ $task->id }}" draggable="true">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge {{ $task->priority == 'low' ? 'bg-success' : ($task->priority == 'medium' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                        <small class="text-muted">
                                            @if($task->due_date)
                                                Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                            @else
                                                No due date
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <h6 class="card-title mb-2">{{ $task->title }}</h6>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge project-badge">
                                            <i class="bi bi-folder me-1"></i>{{ $task->project->name }}
                                        </span>
                                        <small class="text-muted">
                                            Assigned to: {{ $task->user->name }}
                                        </small>
                                    </div>
                                    
                                    @if($task->description)
                                        <p class="card-text small text-muted mb-2">{{ Str::limit($task->description, 100) }}</p>
                                    @endif
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <a href="{{ route('projects.tasks.index', $task->project) }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-folder"></i> Project
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if(count($tasks['to_do']) === 0)
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-inbox display-4"></i>
                                <p class="mt-2">No tasks to do</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="kanban-column">
                    <div class="d-flex justify-content-between shadow-sm align-items-center bg-warning px-3 py-2 rounded-top">
                        <h4 class="text-white fw-bolder m-0">In Progress</h4>
                        <span class="badge bg-light text-dark">{{ count($tasks['in_progress']) }}</span>
                    </div>
                    
                    <div class="kanban-list" id="in_progress">
                        @foreach ($tasks['in_progress'] as $task)
                            <div class="card mb-3 kanban-item task-card priority-{{ $task->priority }}" data-id="{{ $task->id }}" draggable="true">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge {{ $task->priority == 'low' ? 'bg-success' : ($task->priority == 'medium' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                        <small class="text-muted">
                                            @if($task->due_date)
                                                Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                            @else
                                                No due date
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <h6 class="card-title mb-2">{{ $task->title }}</h6>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge project-badge">
                                            <i class="bi bi-folder me-1"></i>{{ $task->project->name }}
                                        </span>
                                        <small class="text-muted">
                                            Assigned to: {{ $task->user->name }}
                                        </small>
                                    </div>
                                    
                                    @if($task->description)
                                        <p class="card-text small text-muted mb-2">{{ Str::limit($task->description, 100) }}</p>
                                    @endif
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <a href="{{ route('projects.tasks.index', $task->project) }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-folder"></i> Project
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if(count($tasks['in_progress']) === 0)
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-hourglass-split display-4"></i>
                                <p class="mt-2">No tasks in progress</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="kanban-column">
                    <div class="d-flex justify-content-between shadow-sm align-items-center bg-success px-3 py-2 rounded-top">
                        <h4 class="text-white fw-bolder m-0">Completed</h4>
                        <span class="badge bg-light text-dark">{{ count($tasks['completed']) }}</span>
                    </div>
                    <div class="kanban-list" id="completed">
                        @foreach ($tasks['completed'] as $task)
                            <div class="card mb-3 kanban-item task-card priority-{{ $task->priority }}" data-id="{{ $task->id }}" draggable="true">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge {{ $task->priority == 'low' ? 'bg-success' : ($task->priority == 'medium' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                        <small class="text-muted">
                                            @if($task->due_date)
                                                Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                            @else
                                                No due date
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <h6 class="card-title mb-2">{{ $task->title }}</h6>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge project-badge">
                                            <i class="bi bi-folder me-1"></i>{{ $task->project->name }}
                                        </span>
                                        <small class="text-muted">
                                            Assigned to: {{ $task->user->name }}
                                        </small>
                                    </div>
                                    
                                    @if($task->description)
                                        <p class="card-text small text-muted mb-2">{{ Str::limit($task->description, 100) }}</p>
                                    @endif
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <a href="{{ route('projects.tasks.index', $task->project) }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-folder"></i> Project
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if(count($tasks['completed']) === 0)
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-check-circle display-4"></i>
                                <p class="mt-2">No completed tasks</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const kanbanItems = document.querySelectorAll('.kanban-item');
            const kanbanLists = document.querySelectorAll('.kanban-list');

            kanbanItems.forEach(item => {
                item.addEventListener('dragstart', handleDragStart);
                item.addEventListener('dragend', handleDragEnd);
            });

            kanbanLists.forEach(list => {
                list.addEventListener('dragover', handleDragOver);
                list.addEventListener('drop', handleDrop);
            });

            function handleDragStart(e) {
                e.dataTransfer.setData('text/plain', e.target.dataset.id);
                setTimeout(() => {
                    e.target.classList.add('invisible');
                }, 0);
            }

            function handleDragEnd(e) {
                e.target.classList.remove('invisible');
            }

            function handleDragOver(e) {
                e.preventDefault();
            }

            function handleDrop(e) {
                e.preventDefault();
                const id = e.dataTransfer.getData('text');
                const draggableElement = document.querySelector(`.kanban-item[data-id='${id}']`);
                const dropzone = e.target.closest('.kanban-list');
                
                if (draggableElement && dropzone) {
                    dropzone.appendChild(draggableElement);
                    const status = dropzone.id;
                    updateTaskStatus(id, status);
                }
            }

            function updateTaskStatus(id, status) {
                fetch(`/tasks/${id}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status
                    })
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to update task status');
                    }
                    return response.json();
                }).then(data => {
                    console.log('Task status updated:', data);
                    // Optional: Show a success message
                    showToast('Task status updated successfully');
                }).catch(error => {
                    console.error('Error:', error);
                    showToast('Error updating task status', 'error');
                });
            }

            function showToast(message, type = 'success') {
                // Simple toast notification
                const toast = document.createElement('div');
                toast.className = `position-fixed bottom-0 end-0 p-3 ${type === 'success' ? 'text-bg-success' : 'text-bg-danger'}`;
                toast.innerHTML = `
                    <div class="toast show" role="alert">
                        <div class="toast-body">
                            ${message}
                        </div>
                    </div>
                `;
                document.body.appendChild(toast);
                
                // Remove toast after 3 seconds
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }
        });
    </script>
@endsection
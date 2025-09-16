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
        .checklist-item {
    transition: all 0.3s ease;
}

.checklist-item:hover {
    background-color: #f8f9fa;
    border-radius: 5px;
}

.remove-checklist-item {
    transition: all 0.2s ease;
}

.remove-checklist-item:hover {
    background-color: #dc3545;
    color: white;
}
    </style>
    <div class="container">

        <div class="bg-white align-items-center mb-4 shadow-sm p-3 rounded d-flex justify-content-between">
            <!-- Tombol kembali di kiri -->
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                ← Kembali
            </a>

            <!-- Judul di tengah -->
            <h2 class="text-center flex-grow-1 m-0">Tugas - {{ $project->name }}</h2>

            <!-- Tombol tambah task untuk manager -->
            @if(Auth::user()->role === 'manager')
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                    <i class="bi bi-plus-circle"></i> Tambah Tugas
                </button>
            </div>
            @else
            <!-- Spacer agar h2 tetap center -->
            <div style="width:90px;"></div>
            @endif
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
                        <h4 class="text-white fw-bolder m-0">Yang Belum Dikerjakan</h4>
                        <span class="badge bg-light text-dark">{{ count($tasks['to_do']) }}</span>
                    </div>
                    
                    <div class="kanban-list" id="to_do">
                        @foreach ($tasks['to_do'] as $task)
                            <div class="card mb-3 kanban-item task-card border-start border-4 border-{{ $task->priority }}" data-id="{{ $task->id }}" draggable="true">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-{{ $task->priority_color }}">
                                            {{ $task->priority_label }}
                                        </span>
                                        <small class="text-muted">
                                            @if($task->due_date)
                                                Tanggal: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                            @else
                                                Tidak ada batas waktu
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <h6 class="card-title mb-2">{{ $task->title }}</h6>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge project-badge">
                                            <i class="bi bi-folder me-1"></i>{{ $task->project->name }}
                                        </span>
                                        <small class="text-muted">
                                            Ditugaskan ke: {{ $task->user->name }}
                                        </small>
                                    </div>
                                    
                                    @if($task->description)
                                        <p class="card-text small text-muted mb-2">{{ Str::limit($task->description, 100) }}</p>
                                    @endif
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i> Lihat Tugas
                                        </a>
 
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if(count($tasks['to_do']) === 0)
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-inbox display-4"></i>
                                <p class="mt-2">Tidak ada tugas yang belum dikerjakan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="kanban-column">
                    <div class="d-flex justify-content-between shadow-sm align-items-center bg-warning px-3 py-2 rounded-top">
                        <h4 class="text-white fw-bolder m-0">Sedang Dikerjakan</h4>
                        <span class="badge bg-light text-dark">{{ count($tasks['in_progress']) }}</span>
                    </div>
                    
                    <div class="kanban-list" id="in_progress">
                        @foreach ($tasks['in_progress'] as $task)
                            <div class="card mb-3 kanban-item task-card border-start border-4 border-{{ $task->priority }}" data-id="{{ $task->id }}" draggable="true">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-{{ $task->priority_color }}">
                                            {{ $task->priority_label }}
                                        </span>
                                        <small class="text-muted">
                                            @if($task->due_date)
                                                Tanggal: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                            @else
                                                Tidak ada batas waktu
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <h6 class="card-title mb-2">{{ $task->title }}</h6>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge project-badge">
                                            <i class="bi bi-folder me-1"></i>{{ $task->project->name }}
                                        </span>
                                        <small class="text-muted">
                                            Ditugaskan ke: {{ $task->user->name }}
                                        </small>
                                    </div>
                                    
                                    @if($task->description)
                                        <p class="card-text small text-muted mb-2">{{ Str::limit($task->description, 100) }}</p>
                                    @endif
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-eye"></i> Lihat Tugas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if(count($tasks['in_progress']) === 0)
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-hourglass-split display-4"></i>
                                <p class="mt-2">Tidak ada tugas yang sedang berlangsung</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="kanban-column">
                    <div class="d-flex justify-content-between shadow-sm align-items-center bg-success px-3 py-2 rounded-top">
                        <h4 class="text-white fw-bolder m-0">Selesai</h4>
                        <span class="badge bg-light text-dark">{{ count($tasks['completed']) }}</span>
                    </div>
                    <div class="kanban-list" id="completed">
                        @foreach ($tasks['completed'] as $task)
                            <div class="card mb-3 kanban-item task-card border-start border-4 border-{{ $task->priority }}" data-id="{{ $task->id }}" draggable="true">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-{{ $task->priority_color }}">
                                            {{ $task->priority_label }}
                                        </span>
                                        <small class="text-muted">
                                            @if($task->due_date)
                                                Tanggal: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                            @else
                                                Tidak ada batas waktu
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <h6 class="card-title mb-2">{{ $task->title }}</h6>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge project-badge">
                                            <i class="bi bi-folder me-1"></i>{{ $task->project->name }}
                                        </span>
                                        <small class="text-muted">
                                            Ditugaskan ke: {{ $task->user->name }}
                                        </small>
                                    </div>
                                    
                                    @if($task->description)
                                        <p class="card-text small text-muted mb-2">{{ Str::limit($task->description, 100) }}</p>
                                    @endif
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-eye"></i> Lihat Tugas
                                        </a>
 
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if(count($tasks['completed']) === 0)
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-check-circle display-4"></i>
                                <p class="mt-2">Belum ada tugas yang selesai</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

<!-- Create Task Modal - Hanya untuk manager -->
@if(Auth::user()->role === 'manager')
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('projects.tasks.store', $project) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">Buat Tugas Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Tugas *</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Ditugaskan Kepada *</label>
                                <select name="user_id" id="user_id" class="form-select" required>
                                    <option value="">Pilih Pengguna</option>
                                    @foreach ($users as $user)  
                                        <option value="{{$user->id}}">{{$user->name}} ({{$user->role}})</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Tugas</label>
                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Deskripsi detail tugas..."></textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="due_date" class="form-label">Tanggal Jatuh Tempo</label>
                                <input type="date" name="due_date" id="due_date" class="form-control" min="{{ date('Y-m-d') }}">
                                @error('due_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="priority" class="form-label">Prioritas *</label>
                                <select name="priority" id="priority" class="form-select" required>
                                    <option value="low">Rendah</option>
                                    <option value="medium" selected>Sedang</option>
                                    <option value="high">Tinggi</option>
                                </select>
                                @error('priority')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Checklist Items Section -->
                    <div class="mb-3">
                        <label class="form-label">Checklist Items (Point-point tugas)</label>
                        <div id="checklist-items-container">
                            <div class="checklist-item input-group mb-2">
                                <input type="text" name="checklist_items[]" class="form-control" placeholder="Deskripsi item checklist" required>
                                <button type="button" class="btn btn-outline-danger remove-checklist-item">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-checklist-item">
                            <i class="bi bi-plus-circle"></i> Tambah Item
                        </button>
                    </div>

                    <!-- File Upload Info -->
                    <div class="alert alert-info">
                        <small>
                            <i class="bi bi-info-circle"></i> User dapat mengupload file dan catatan setelah tugas dibuat.
                            File bisa berupa screenshot, dokumen, atau file pendukung lainnya.
                        </small>
                    </div>

                    <input type="hidden" name="status" value="to_do">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Buat Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add checklist item
        document.getElementById('add-checklist-item').addEventListener('click', function() {
            const container = document.getElementById('checklist-items-container');
            const newItem = document.createElement('div');
            newItem.className = 'checklist-item input-group mb-2';
            newItem.innerHTML = `
                <input type="text" name="checklist_items[]" class="form-control" placeholder="Deskripsi item checklist" required>
                <button type="button" class="btn btn-outline-danger remove-checklist-item">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            container.appendChild(newItem);
            
            // Add event listener to remove button
            newItem.querySelector('.remove-checklist-item').addEventListener('click', function() {
                if (document.querySelectorAll('.checklist-item').length > 1) {
                    newItem.remove();
                }
            });
        });

        // Remove checklist item
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-checklist-item')) {
                const items = document.querySelectorAll('.checklist-item');
                if (items.length > 1) {
                    e.target.closest('.checklist-item').remove();
                }
            }
        });

        // Set minimum date for due date
        const dueDateInput = document.getElementById('due_date');
        if (!dueDateInput.value) {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            dueDateInput.value = tomorrow.toISOString().split('T')[0];
        }
    });
</script>
@endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const kanbanItems = document.querySelectorAll('.kanban-item');
            const kanbanLists = document.querySelectorAll('.kanban-list');
            const createTaskModal = document.getElementById('createTaskModal');
            
            @if(Auth::user()->role === 'manager')
            if (createTaskModal) {
                const taskStatusInput = document.getElementById('task_status');
                
                createTaskModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget; 
                    var status = button.getAttribute('data-status'); 
                    if (status) {
                        taskStatusInput.value = status;
                    } else {
                        taskStatusInput.value = 'to_do'; // Default value
                    }
                });
            }
            @endif

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
                    showToast('Status tugas berhasil diperbarui');
                }).catch(error => {
                    console.error('Error:', error);
                    showToast('Error memperbarui status tugas', 'error');
                });
            }

            function showToast(message, type = 'success') {
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
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }
        });
    </script>
@endsection
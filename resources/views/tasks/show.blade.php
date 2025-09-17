@extends('layouts.app')
@section('title')
    {{ $task->title }} - Detail Tugas
@endsection
@section('content')
    <div class="container">
        <!-- Header dengan tombol kembali di kiri, judul di tengah, dan tombol edit di kanan -->
        <div class="bg-white align-items-center mb-4 shadow-sm p-3 rounded d-flex justify-content-between">
            <!-- Tombol kembali di kiri -->
            <a href="{{ route('projects.tasks.index', $task->project->id) }}" class="btn btn-secondary">
                ← Kembali
            </a>

            <!-- Judul di tengah -->
            <h2 class="text-center flex-grow-1 m-0">Detail Tugas - {{ $task->title }}</h2>

            @if(Auth::user()->role === 'manager')
            <!-- Tombol edit di kanan -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal">
                <i class="bi bi-pencil-square"></i> Edit
            </button>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">{{ $task->title }}</h5>
                                <p class="card-text">{{ $task->description }}</p>
                                <p class="card-text"><strong>Tanggal Jatuh Tempo:</strong> 
                                    @if($task->due_date)
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </p>
                                <p class="card-text"><strong>Prioritas:</strong> <span
                                        class="badge {{ $task->priority == 'low' ? 'bg-success' : ($task->priority == 'medium' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $task->priority == 'low' ? 'Rendah' : ($task->priority == 'medium' ? 'Sedang' : 'Tinggi') }}
                                    </span>
                                </p>
                                <p class="card-text"><strong>Status:</strong>
                                    @if ($task->status == 'completed')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($task->status == 'to_do')
                                        <span class="badge bg-primary">Belum Dikerjakan</span>
                                    @elseif($task->status == 'in_progress')
                                        <span class="badge bg-warning">Sedang Dikerjakan</span>
                                    @endif
                                </p>

                                <p class="card-text"><strong>Ditugaskan Kepada:</strong> {{ $task->user->name }}</p>
                            </div>

                            <div class="col-md-6 border-start">
                                <h5>Informasi Proyek</h5>
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-2"><strong>Proyek:</strong> {{ $task->project->name }}</p>
                                    <p class="mb-2"><strong>Deskripsi Proyek:</strong> 
                                        {{ $task->project->description ?? 'Tidak ada deskripsi' }}
                                    </p>
                                    <p class="mb-0"><strong>Status Proyek:</strong> 
                                        <span class="badge bg-{{ $task->project->status == 'completed' ? 'success' : ($task->project->status == 'in_progress' ? 'warning' : 'secondary') }}">
                                            {{ str_replace('_', ' ', $task->project->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Checklist Section dengan Upload File per Item -->
                        <div class="col-md-12 mt-4">
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <h5>Checklist Items</h5>
                                @if(Auth::user()->role === 'manager')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addChecklistModal"> 
                                    <i class="bi bi-plus-circle"></i> Tambah Item
                                </button>
                                @endif
                            </div>

                            <div class="mt-3">
                                @foreach ($task->checklistItems as $item)
                                    <div class="card mb-3 checklist-item-card" id="checklist-item-{{ $item->id }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="checklist-item-checkbox-{{ $item->id }}"
                                                        {{ $item->completed ? 'checked' : '' }}
                                                        onchange="toggleChecklistItem({{ $item->id }})">
                                                    <label class="form-check-label {{ $item->completed ? 'text-decoration-line-through' : '' }} fw-bold">
                                                        {{ $item->name }}
                                                    </label>
                                                </div>
                                                <div class="btn-group">
                                                    

                                                    @if(Auth::user()->role === 'manager')
                                                    <!-- Tombol delete -->
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                        onclick="deleteChecklistItem({{ $item->id }})"
                                                        title="Hapus Item">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Tampilkan file dan catatan jika ada -->
                                            <div class="mt-2">
                                                @if($item->file_path)
                                                <div class="mb-2">
                                                    <small class="text-muted">File:</small>
                                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-link p-0 text-primary">
                                                        <i class="bi bi-download"></i> Download File
                                                    </a>
                                                    <form action="{{ route('checklist-items.delete-file', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-link p-0 text-danger" onclick="return confirm('Hapus file ini?')">
                                                            <i class="bi bi-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                                @endif
                                                
                                                @if($item->notes)
                                                <div>
                                                    <small class="text-muted">Catatan:</small>
                                                    <p class="mb-0 small">{{ $item->notes }}</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Upload File untuk Checklist Item -->
                                    <div class="modal fade" id="uploadFileModal-{{ $item->id }}" tabindex="-1" aria-labelledby="uploadFileModalLabel-{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('checklist-items.upload', $item->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="uploadFileModalLabel-{{ $item->id }}">Upload File untuk "{{ $item->name }}"</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="file-{{ $item->id }}" class="form-label">Pilih File</label>
                                                            <input type="file" class="form-control" id="file-{{ $item->id }}" name="file" required>
                                                            <div class="form-text">Maksimal 2MB</div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Catatan untuk Checklist Item -->
                                    <div class="modal fade" id="notesModal-{{ $item->id }}" tabindex="-1" aria-labelledby="notesModalLabel-{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('checklist-items.add-notes', $item->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="notesModalLabel-{{ $item->id }}">Catatan untuk "{{ $item->name }}"</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="notes-{{ $item->id }}" class="form-label">Catatan</label>
                                                            <textarea class="form-control" id="notes-{{ $item->id }}" name="notes" rows="3" placeholder="Tambahkan catatan untuk item ini...">{{ old('notes', $item->notes) }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Catatan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- File Upload Section untuk Task secara keseluruhan -->
                        <div class="col-md-12 mt-4">
                            <div class="border-top pt-3">
                                <h5>File Lampiran Tugas</h5>
                                
                                @if($task->file_path)
                                <div class="mb-3">
                                    <p class="mb-1">File Saat Ini:</p>
                                    <a href="{{ asset('storage/' . $task->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-download"></i> Download File
                                    </a>
                                    <form action="{{ route('tasks.delete-file', $task->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus file ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                                @endif
                                
                                <form action="{{ route('tasks.upload', $task->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Upload File Baru</label>
                                        <input type="file" class="form-control" id="file" name="file">
                                        <div class="form-text">Maksimal ukuran file: 2MB</div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-upload"></i> Upload File
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Notes Section untuk Task secara keseluruhan -->
                        <div class="col-md-12 mt-4">
                            <div class="border-top pt-3">
                                <h5>Catatan Tugas</h5>
                                
                                @if($task->notes)
                                <div class="mb-3 p-3 bg-light rounded">
                                    <p>{{ $task->notes }}</p>
                                </div>
                                @endif
                                
                                <form action="{{ route('tasks.add-notes', $task->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Tambah atau Perbarui Catatan</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Tambahkan catatan tugas di sini...">{{ old('notes', $task->notes) }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Simpan Catatan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Checklist Modal -->
        <div class="modal fade" id="addChecklistModal" tabindex="-1" aria-labelledby="addChecklistModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('checklist-items.store', $task->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addChecklistModalLabel">Tambah Checklist Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="checklist-name" class="form-label">Nama Item</label>
                                <input type="text" name="name" id="checklist-name" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Tambah Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Task Modal -->
        <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTaskModalLabel">Edit Tugas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Judul Tugas *</label>
                                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $task->title) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if(Auth::user()->role === 'manager')
                                    <div class="mb-3">
                                        <label for="user_id" class="form-label">Ditugaskan Kepada *</label>
                                        <select name="user_id" id="user_id" class="form-select" required>
                                            <option value="">Pilih Pengguna</option>
                                            @foreach ($users ?? [] as $user)
                                                <option value="{{ $user->id }}" {{ old('user_id', $task->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->role }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @else
                                    <input type="hidden" name="user_id" value="{{ $task->user_id }}">
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Tugas</label>
                                <textarea name="description" id="description" class="form-control" rows="3" placeholder="Deskripsi detail tugas...">{{ old('description', $task->description) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="due_date" class="form-label">Tanggal Jatuh Tempo</label>
                                        <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', $task->due_date) }}" min="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="priority" class="form-label">Prioritas *</label>
                                        <select name="priority" id="priority" class="form-select" required>
                                            <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Rendah</option>
                                            <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Sedang</option>
                                            <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>Tinggi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="to_do" {{ old('status', $task->status) == 'to_do' ? 'selected' : '' }}>Belum Dikerjakan</option>
                                    <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                                    <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Perbarui Tugas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Checklist functionality
        function toggleChecklistItem(itemId) {
            const url = '{{ route('checklist-items.update-status', ':id') }}'.replace(':id', itemId);
            const checkbox = document.getElementById(`checklist-item-checkbox-${itemId}`);
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    completed: checkbox.checked
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const label = checkbox.closest('.form-check').querySelector('.form-check-label');
                    label.classList.toggle('text-decoration-line-through', checkbox.checked);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function deleteChecklistItem(itemId) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                const url = '{{ route('checklist-items.destroy', ':id') }}'.replace(':id', itemId);
                
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`checklist-item-${itemId}`).remove();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
@endsection
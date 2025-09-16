@extends('layouts.app')

@section('title', 'Catatan')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center bg-white shadow-sm p-3 rounded mb-4">
        <h2>Catatan</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNoteModal">
            Tambah Catatan
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($notes as $note)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $note->title }}</h5>
                        <p class="card-text">{{ Str::limit($note->content, 150) }}</p>
                        <p class="card-text"><strong>Tanggal:</strong> {{ $note->date }}</p>
                        <p class="card-text"><strong>Waktu:</strong> {{ $note->time }}</p>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editNoteModal" 
                                data-mode="edit" 
                                data-id="{{ $note->id }}" 
                                data-title="{{ $note->title }}" 
                                data-content="{{ $note->content }}" 
                                data-date="{{ $note->date }}" 
                                data-time="{{ $note->time }}">
                                Ubah
                            </button>
                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        @empty
            <p>Tidak ada catatan ditemukan.</p>
        @endforelse
    </div>
</div>

<div class="modal fade" id="createNoteModal" tabindex="-1" aria-labelledby="createNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createNoteModalLabel">Tambah Catatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('notes.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Isi</label>
                        <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="date" name="date" id="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Waktu</label>
                        <input type="time" name="time" id="time" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Catatan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNoteModalLabel">Ubah Catatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="editNoteForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Judul</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_content" class="form-label">Isi</label>
                        <textarea name="content" id="edit_content" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_date" class="form-label">Tanggal</label>
                        <input type="date" name="date" id="edit_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="edit_time" class="form-label">Waktu</label>
                        <input type="time" name="time" id="edit_time" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui Catatan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editNoteModal = document.getElementById('editNoteModal');
        
        editNoteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const title = button.getAttribute('data-title') || '';
            const content = button.getAttribute('data-content') || '';
            const date = button.getAttribute('data-date') || '';
            const time = button.getAttribute('data-time') || '';

            const form = editNoteModal.querySelector('#editNoteForm');
            const titleInput = editNoteModal.querySelector('#edit_title');
            const contentInput = editNoteModal.querySelector('#edit_content');
            const dateInput = editNoteModal.querySelector('#edit_date');
            const timeInput = editNoteModal.querySelector('#edit_time');

            // Set aksi formulir
            form.action = `/notes/${id}`;

            // Isi formulir dengan data
            titleInput.value = title;
            contentInput.value = content;
            dateInput.value = date;
            timeInput.value = time;
        });
    });
</script>
@endsection
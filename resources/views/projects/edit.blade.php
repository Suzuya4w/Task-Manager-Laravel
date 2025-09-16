@extends('layouts.app')
@section('title')
    Edit Proyek - {{ $project->name }}
@endsection
@section('content')
    <div class="container">
        <h2 class="mb-4 shadow-sm p-3 rounded bg-white">Edit Proyek</h2>
        <div class="card border-0 shadow-sm m-auto" style="max-width: 600px;">
            <div class="card-body">
                <form action="{{ route('projects.update', $project->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Proyek</label>
                        <input type="text" name="name" id="name" class="form-control" 
                               value="{{ $project->name }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control">{{ $project->description }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control"
                               value="{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : '' }}">

                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Pilih jika proyek memiliki tanggal mulai</small>
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Berakhir</label>
                        <input type="date" name="end_date" id="end_date" class="form-control"
                               value="{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') : '' }}">
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Kosongkan jika proyek tidak memiliki batas waktu</small>
                    </div>

                    <div class="mb-3">
                        <label for="budget" class="form-label">Anggaran</label>
                        <input type="number" name="budget" id="budget" class="form-control" step="0.01"
                               value="{{ $project->budget }}">
                        @error('budget')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui Proyek</button>
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('title')
    Create Project
@endsection
@section('content')
    <div class="container mb-3">
        <h2 class="mb-4 shadow-sm p-3 rounded bg-white">Buat Proyek</h2>
        <div class="card border-0 shadow-sm m-auto" style="max-width: 600px;">
            <div class="card-body">
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Proyek</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Keterangan</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control">
                        <small class="text-muted">Pilih jika proyek memiliki tanggal mulai / Biarkan keduanya kosong jika proyek tidak memiliki batas waktu.</small>
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Berakhir</label>
                        <input type="date" name="end_date" id="end_date" class="form-control">
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="budget" class="form-label">Budget</label>
                        <input type="number" name="budget" id="budget" class="form-control" step="0.01">
                        @error('budget')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Buat Proyek</button>
                </form>
            </div>
        </div>
    </div>
@endsection

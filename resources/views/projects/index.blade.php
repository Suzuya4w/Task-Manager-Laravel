@extends('layouts.app')
@section('title')
    Projects 
@endsection
@section('content')
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center bg-white mb-4 shadow-sm p-3 rounded">
            <h2>PROYEK</h2>
            @if(Auth::user()->role === 'manager')
            <a href="{{ route('projects.create') }}" class="btn btn-primary">Tambah Proyek</a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            @foreach($projects as $project)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->name }}</h5>
                            <p class="card-text">{{ $project->description }}</p>
                            <p class="card-text">
                                <strong>Status:</strong> {{ $project->status }}
<br>
                                <strong>Pembuat:</strong> {{ $project->user->name }}<br>
                                <strong>Batas Waktu:</strong> 
                                @if(!$project->end_date)
                                    <span class="text-muted">Tanpa Batas Waktu</span>
                                @elseif($project->end_date->isFuture())
                                    {{ $project->end_date->diffForHumans() }}
                                @else
                                    <span class="text-danger">Batas waktu telah berlalu</span>
                                @endif

                            </p>
                            <a href="{{ route('projects.tasks.index', $project->id) }}" class="btn btn-primary"> <i class="bi bi-list"></i> Lihat Tugas</a>
                            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-info"> <i class="bi bi-eye"></i> Detail</a>
                            
                            @if($project->user_id == Auth::id())
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning"> <i class="bi bi-pencil-square"></i> Edit</a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')"> <i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
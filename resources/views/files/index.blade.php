@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center bg-white shadow-sm p-3 rounded mb-4">
        <h2>Uploaded Files</h2>
        <a href="{{ route('files.create') }}" class="btn btn-primary">Upload File</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($files as $file)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <!-- Image preview section -->
                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px; overflow: hidden;">
                        @if($file->is_image)
                            <img src="{{ Storage::url($file->path) }}" 
                                 alt="{{ $file->name }}" 
                                 class="img-fluid" 
                                 style="max-height: 100%; object-fit: contain;">
                        @else
                            <!-- Show icon for non-image files -->
                            <div class="text-center text-muted">
                                @switch($file->extension)
                                    @case('pdf')
                                        <i class="bi bi-file-earmark-pdf" style="font-size: 4rem;"></i>
                                        @break
                                    @case('doc')
                                    @case('docx')
                                        <i class="bi bi-file-earmark-word" style="font-size: 4rem;"></i>
                                        @break
                                    @case('xls')
                                    @case('xlsx')
                                        <i class="bi bi-file-earmark-excel" style="font-size: 4rem;"></i>
                                        @break
                                    @case('zip')
                                    @case('rar')
                                        <i class="bi bi-file-earmark-zip" style="font-size: 4rem;"></i>
                                        @break
                                    @case('mp3')
                                    @case('wav')
                                        <i class="bi bi-file-earmark-music" style="font-size: 4rem;"></i>
                                        @break
                                    @case('mp4')
                                    @case('mov')
                                    @case('avi')
                                        <i class="bi bi-file-earmark-play" style="font-size: 4rem;"></i>
                                        @break
                                    @default
                                        <i class="bi bi-file-earmark" style="font-size: 4rem;"></i>
                                @endswitch
                                <p class="mt-2">{{ strtoupper($file->extension) }} File</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $file->name }}</h5>
                        <p class="card-text">
                            <strong>Type:</strong> {{ $file->type }}<br>
                            <strong>Size:</strong> {{ $file->formatted_size }}
                        </p>
                    </div>
                    
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between">
                            <a href="{{ Storage::url($file->path) }}" target="_blank" class="btn btn-primary btn-sm" download> 
                                <i class="bi bi-download"></i> 
                            </a>
                            <a href="{{ route('files.edit', $file->id) }}" class="btn btn-warning btn-sm"> 
                                <i class="bi bi-pencil-square"></i> 
                            </a>
                            <form action="{{ route('files.destroy', $file->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"> 
                                    <i class="bi bi-trash"></i> 
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
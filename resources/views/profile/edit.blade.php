@extends('layouts.app')

@section('title', 'Profile')

@section('content')

    {{-- Tombol kembali --}}
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">← Kembali</a>

<div class="container">
    <h2 class="mb-4">Kelola Profil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    {{-- Update Profile --}}
    <div class="card mb-4">
        <div class="card-header">Perbarui Profil</div>
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" 
                  onsubmit="return confirm('Apakah Anda yakin ingin memperbarui profil?');">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <button class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    {{-- Update Password --}}
    <div class="card">
        <div class="card-header">Ubah Kata Sandi</div>
        <div class="card-body">
            <form action="{{ route('profile.updatePassword') }}" method="POST" 
                  onsubmit="return confirm('Apakah Anda yakin ingin mengubah kata sandi?');">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Sandi Saat Ini</label>
                    <input type="password" name="current_password" class="form-control">
                    @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label>Sandi Baru</label>
                    <input type="password" name="password" class="form-control">
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="mb-3">
                    <label>Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <button class="btn btn-warning">Ubah Kata Sandi</button>
            </form>
        </div>
    </div>
</div>
@endsection

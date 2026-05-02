@extends('layouts.ceo')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center">
                    <a href="{{ route('ceo.users.index') }}" class="btn btn-light rounded-pill me-3">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-user-edit text-primary me-2"></i> Edit User
                    </h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('ceo.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password <span class="text-muted">(Kosongkan jika tidak diubah)</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        <small class="text-muted">Minimal 6 karakter</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="marketing" {{ $user->role == 'marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="ceo" {{ $user->role == 'ceo' ? 'selected' : '' }}>CEO</option>
                            <option value="client" {{ $user->role == 'client' ? 'selected' : '' }}>Client</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('ceo.users.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
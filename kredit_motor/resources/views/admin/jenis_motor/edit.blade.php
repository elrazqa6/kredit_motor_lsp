@extends('layouts.admin')

@section('title', 'Edit Jenis Motor')
@section('page-title', 'Edit Jenis Motor')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.jenis-motor.index') }}" class="btn btn-light rounded-pill me-3">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-edit text-primary me-2"></i> Edit Jenis Motor
                        </h5>
                        <p class="text-muted mb-0 small">Ubah data jenis motor</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.jenis-motor.update', $jenisMotor->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Jenis <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_jenis" 
                               class="form-control @error('nama_jenis') is-invalid @enderror"
                               value="{{ old('nama_jenis', $jenisMotor->nama_jenis) }}" required>
                        @error('nama_jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" 
                                  class="form-control @error('keterangan') is-invalid @enderror" 
                                  rows="4">{{ old('keterangan', $jenisMotor->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" 
                                   id="isActive" role="switch" {{ $jenisMotor->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="isActive">
                                <i class="fas fa-check-circle text-success me-1"></i> Aktif
                            </label>
                            <small class="text-muted d-block mt-1">Nonaktifkan jika jenis motor ini tidak lagi digunakan</small>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.jenis-motor.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i> Perbarui Jenis Motor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
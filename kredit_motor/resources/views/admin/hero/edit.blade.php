@extends('layouts.admin')

@section('title', 'Edit Banner Hero')
@section('page-title', 'Edit Banner Hero')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.hero.index') }}" class="btn btn-light rounded-pill me-3">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-edit text-primary me-2"></i> Edit Banner Hero
                        </h5>
                        <p class="text-muted mb-0 small">Ubah data banner hero</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.hero.update', $hero->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    @if($hero->gambar)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar Saat Ini</label>
                            <div>
                                <img src="{{ asset('storage/'.$hero->gambar) }}" alt="Hero Banner" style="height: 120px; width: auto; border-radius: 8px;" class="border p-1">
                            </div>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gambar Baru</label>
                        <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG, WebP (Max 2MB)</small>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Banner</label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                            value="{{ old('judul', $hero->judul) }}">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sub Judul</label>
                        <textarea name="sub_judul" class="form-control @error('sub_judul') is-invalid @enderror" 
                            rows="2">{{ old('sub_judul', $hero->sub_judul) }}</textarea>
                        @error('sub_judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Teks Tombol</label>
                                <input type="text" name="tombol_teks" class="form-control @error('tombol_teks') is-invalid @enderror"
                                    value="{{ old('tombol_teks', $hero->tombol_teks ?? 'Lihat Selengkapnya') }}">
                                @error('tombol_teks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Link Tombol</label>
                                <input type="text" name="tombol_link" class="form-control @error('tombol_link') is-invalid @enderror"
                                    value="{{ old('tombol_link', $hero->tombol_link ?? '#') }}">
                                @error('tombol_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror"
                            value="{{ old('urutan', $hero->urutan ?? 0) }}">
                        <small class="text-muted">Urutan 1 akan tampil pertama, 2 kedua, dst.</small>
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.hero.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i> Update Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
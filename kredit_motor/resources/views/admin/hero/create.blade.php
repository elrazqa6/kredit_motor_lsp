@extends('layouts.admin')

@section('title', 'Tambah Banner Hero')
@section('page-title', 'Tambah Banner Hero')

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
                            <i class="fas fa-plus-circle text-primary me-2"></i> Tambah Banner Hero
                        </h5>
                        <p class="text-muted mb-0 small">Banner akan tampil di halaman utama client</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.hero.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gambar Banner <span class="text-danger">*</span></label>
                        <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG, WebP (Max 2MB). Rekomendasi ukuran: 1920x800px</small>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Banner</label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                            value="{{ old('judul') }}" placeholder="Contoh: Promo Spesial Lebaran">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sub Judul</label>
                        <textarea name="sub_judul" class="form-control @error('sub_judul') is-invalid @enderror" 
                            rows="2" placeholder="Deskripsi singkat banner">{{ old('sub_judul') }}</textarea>
                        @error('sub_judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Teks Tombol</label>
                                <input type="text" name="tombol_teks" class="form-control @error('tombol_teks') is-invalid @enderror"
                                    value="{{ old('tombol_teks', 'Lihat Selengkapnya') }}" placeholder="Contoh: Beli Sekarang">
                                @error('tombol_teks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Link Tombol</label>
                                <input type="text" name="tombol_link" class="form-control @error('tombol_link') is-invalid @enderror"
                                    value="{{ old('tombol_link', '#') }}" placeholder="Contoh: /motor">
                                @error('tombol_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror"
                            value="{{ old('urutan', 0) }}" placeholder="Semakin kecil angka, semakin awal tampil">
                        <small class="text-muted">Urutan 1 akan tampil pertama, 2 kedua, dst.</small>
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.hero.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i> Simpan Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
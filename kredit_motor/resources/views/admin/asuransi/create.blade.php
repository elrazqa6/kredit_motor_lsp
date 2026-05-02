@extends('layouts.admin')

@section('title', 'Tambah Asuransi')
@section('page-title', 'Tambah Asuransi Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.asuransi.index') }}" class="btn btn-light rounded-pill me-3">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-shield-alt text-primary me-2"></i> Form Tambah Asuransi
                        </h5>
                        <p class="text-muted mb-0 small">Isi data asuransi dengan lengkap</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.asuransi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Nama Asuransi <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_asuransi" 
                                class="form-control @error('nama_asuransi') is-invalid @enderror"
                                value="{{ old('nama_asuransi') }}" 
                                placeholder="Contoh: Allianz, Sinarmas, dll" required>
                            @error('nama_asuransi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Nama Perusahaan
                            </label>
                            <input type="text" name="nama_perusahaan" 
                                class="form-control @error('nama_perusahaan') is-invalid @enderror"
                                value="{{ old('nama_perusahaan') }}" 
                                placeholder="Contoh: PT. Allianz Indonesia">
                            @error('nama_perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Biaya Asuransi (Rp) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="biaya" 
                                    class="form-control @error('biaya') is-invalid @enderror"
                                    value="{{ old('biaya') }}" 
                                    placeholder="0" required>
                            </div>
                            <small class="text-muted">Biaya asuransi per tahun</small>
                            @error('biaya')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Margin Asuransi (%)
                            </label>
                            <div class="input-group">
                                <input type="number" name="margin_asuransi" 
                                    class="form-control @error('margin_asuransi') is-invalid @enderror"
                                    value="{{ old('margin_asuransi', 0) }}" 
                                    step="0.01" placeholder="0">
                                <span class="input-group-text">%</span>
                            </div>
                            <small class="text-muted">Persentase keuntungan dari biaya asuransi</small>
                            @error('margin_asuransi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                No. Rekening
                            </label>
                            <input type="text" name="no_rekening" 
                                class="form-control @error('no_rekening') is-invalid @enderror"
                                value="{{ old('no_rekening') }}" 
                                placeholder="Contoh: 1234567890 a.n PT Asuransi">
                            @error('no_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Logo Asuransi
                            </label>
                            <input type="file" name="url_logo" 
                                class="form-control @error('url_logo') is-invalid @enderror"
                                accept="image/*">
                            <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>
                            @error('url_logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.asuransi.index') }}" class="btn btn-light rounded-pill px-4">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i> Simpan Asuransi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.marketing')

@section('title', 'Edit Angsuran')
@section('page-title', 'Edit Data Angsuran')

@push('styles')
<style>
    .form-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        margin-bottom: 24px;
    }
    .form-label {
        font-weight: 600;
        font-size: 13px;
        margin-bottom: 8px;
        color: #1e293b;
    }
    .form-control, .form-select {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 10px 16px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 10px 24px;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    .info-box {
        background: linear-gradient(135deg, #667eea10 0%, #764ba210 100%);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
    }
    .info-label {
        font-size: 11px;
        color: #64748b;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('marketing.angsuran.update', $angsuran->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Informasi Kredit -->
            <div class="form-card">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-credit-card text-primary me-2"></i> Informasi Kredit
                </h5>
                <div class="info-box">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-label">Pelanggan</div>
                            <div class="info-value">{{ $angsuran->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Motor</div>
                            <div class="info-value">{{ $angsuran->kredit->pengajuanKredit->motor->nama_motor ?? '-' }}</div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="info-label">Angsuran Ke</div>
                            <div class="info-value">{{ $angsuran->angsuran_ke }}</div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="info-label">Cicilan per Bulan</div>
                            <div class="info-value">Rp {{ number_format($angsuran->kredit->pengajuanKredit->cicilan_perbulan, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="info-label">Sisa Kredit</div>
                            <div class="info-value">Rp {{ number_format($angsuran->kredit->sisa_kredit, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Edit Detail Angsuran -->
            <div class="form-card">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-edit text-primary me-2"></i> Edit Detail Angsuran
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Bayar <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="tgl_bayar" class="form-control @error('tgl_bayar') is-invalid @enderror" 
                               value="{{ old('tgl_bayar', \Carbon\Carbon::parse($angsuran->tgl_bayar)->format('Y-m-d\TH:i')) }}" required>
                        @error('tgl_bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Total Bayar <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="total_bayar" class="form-control @error('total_bayar') is-invalid @enderror" 
                                   value="{{ old('total_bayar', $angsuran->total_bayar) }}" required>
                        </div>
                        @error('total_bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Lunas" {{ $angsuran->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="Belum Bayar" {{ $angsuran->status == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                            <option value="Telat" {{ $angsuran->status == 'Telat' ? 'selected' : '' }}>Telat</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan keterangan...">{{ old('keterangan', $angsuran->keterangan) }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Tombol Submit -->
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary px-5 py-2">
                    <i class="fas fa-save me-2"></i> Update Angsuran
                </button>
                <a href="{{ route('marketing.angsuran.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left me-2"></i> Batal
                </a>
            </div>
        </form>
    </div>
    
    <div class="col-lg-4">
        <!-- Info Card -->
        <div class="form-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-info-circle text-primary me-2"></i> Informasi
            </h5>
            <ul class="list-unstyled mb-0">
                <li class="mb-2">
                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                    Ubah tanggal bayar sesuai bukti transfer
                </li>
                <li class="mb-2">
                    <i class="fas fa-money-bill-wave text-warning me-2"></i>
                    Total bayar harus sesuai dengan bukti
                </li>
                <li>
                    <i class="fas fa-save text-success me-2"></i>
                    Perubahan akan update sisa kredit otomatis
                </li>
            </ul>
        </div>
        
        <!-- Riwayat Angsuran -->
        <div class="form-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-history text-primary me-2"></i> Riwayat Angsuran
            </h5>
            <div class="small text-muted mb-2">Dibuat: {{ \Carbon\Carbon::parse($angsuran->created_at)->format('d/m/Y H:i') }}</div>
            <div class="small text-muted">Terakhir update: {{ \Carbon\Carbon::parse($angsuran->updated_at)->format('d/m/Y H:i') }}</div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.marketing')

@section('title', 'Input Pengajuan Offline')
@section('page-title', 'Input Pengajuan Offline')
@section('page-subtitle', 'Form input pengajuan kredit untuk pelanggan yang datang langsung')

@push('styles')
<style>
    .form-section {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        margin-bottom: 24px;
    }
    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e2e8f0;
    }
    .section-title i {
        color: #6366f1;
        margin-right: 8px;
    }
    .info-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
    }
    .info-icon {
        width: 40px;
        height: 40px;
        background: #eef2ff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')

<form action="{{ route('marketing.pengajuan-offline.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Data Pelanggan -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-user"></i> Data Pelanggan
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pelanggan" class="form-control @error('nama_pelanggan') is-invalid @enderror" 
                            value="{{ old('nama_pelanggan') }}" required>
                        @error('nama_pelanggan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email') }}" required>
                        <small class="text-muted">Akan digunakan untuk login</small>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" 
                            value="{{ old('no_telp') }}" required>
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                            rows="2" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kota</label>
                        <input type="text" name="kota" class="form-control" value="{{ old('kota') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kode Pos</label>
                        <input type="text" name="kodepos" class="form-control" value="{{ old('kodepos') }}">
                    </div>
                </div>
            </div>
            
            <!-- Data Kredit -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-credit-card"></i> Data Kredit
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Pilih Motor <span class="text-danger">*</span></label>
                        <select name="id_motor" id="motorSelect" class="form-select @error('id_motor') is-invalid @enderror" required onchange="hitungCicilan()">
                            <option value="">-- Pilih Motor --</option>
                            @foreach($motors as $motor)
                            <option value="{{ $motor->id }}" data-harga="{{ $motor->harga_jual }}" {{ old('id_motor') == $motor->id ? 'selected' : '' }}>
                                {{ $motor->merk }} - {{ $motor->nama_motor }} (Rp {{ number_format($motor->harga_jual, 0, ',', '.') }})
                            </option>
                            @endforeach
                        </select>
                        @error('id_motor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Cicilan <span class="text-danger">*</span></label>
                        <select name="id_jenis_cicilan" id="cicilanSelect" class="form-select @error('id_jenis_cicilan') is-invalid @enderror" required onchange="hitungCicilan()">
                            <option value="">-- Pilih Tenor --</option>
                            @foreach($jenisCicilans as $cicilan)
                            <option value="{{ $cicilan->id }}" data-bulan="{{ $cicilan->lama_cicilan }}" data-margin="{{ $cicilan->margin_kredit }}" {{ old('id_jenis_cicilan') == $cicilan->id ? 'selected' : '' }}>
                                {{ $cicilan->lama_cicilan }} bulan (Bunga {{ $cicilan->margin_kredit }}%)
                            </option>
                            @endforeach
                        </select>
                        @error('id_jenis_cicilan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Asuransi</label>
                        <select name="id_asuransi" id="asuransiSelect" class="form-select" onchange="hitungCicilan()">
                            <option value="">-- Tanpa Asuransi --</option>
                            @foreach($asuransiList as $asuransi)
                            <option value="{{ $asuransi->id }}" data-biaya="{{ $asuransi->biaya }}" {{ old('id_asuransi') == $asuransi->id ? 'selected' : '' }}>
                                {{ $asuransi->nama_asuransi }} (Rp {{ number_format($asuransi->biaya, 0, ',', '.') }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Metode Bayar <span class="text-danger">*</span></label>
                        <select name="id_metode_bayar" class="form-select @error('id_metode_bayar') is-invalid @enderror" required>
                            <option value="">-- Pilih Metode --</option>
                            @foreach($metodeBayar as $method)
                            <option value="{{ $method->id }}" {{ old('id_metode_bayar') == $method->id ? 'selected' : '' }}>
                                {{ $method->metode_pembayaran }} - {{ $method->tempat_bayar }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_metode_bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Uang Muka (DP) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="uang_muka" id="dpInput" class="form-control @error('uang_muka') is-invalid @enderror" 
                                value="{{ old('uang_muka') }}" oninput="hitungCicilan()" required>
                        </div>
                        <small class="text-muted">Minimal 20% dari harga motor</small>
                        @error('uang_muka')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Dokumen (Opsional) -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-file-upload"></i> Dokumen Pendukung
                </div>
                <div class="alert alert-info border-0 rounded-3">
                    <i class="fas fa-info-circle me-2"></i>
                    Dokumen tidak wajib untuk pengajuan offline. Marketing bisa upload belakangan.
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Foto KTP</label>
                        <input type="file" name="url_ktp" class="form-control" accept="image/*,.pdf">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kartu Keluarga</label>
                        <input type="file" name="url_kk" class="form-control" accept="image/*,.pdf">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NPWP</label>
                        <input type="file" name="url_npwp" class="form-control" accept="image/*,.pdf">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Slip Gaji</label>
                        <input type="file" name="url_slip_gaji" class="form-control" accept="image/*,.pdf">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Foto Diri</label>
                        <input type="file" name="url_foto" class="form-control" accept="image/*,.pdf">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="form-section sticky-top" style="top: 20px;">
                <div class="section-title">
                    <i class="fas fa-calculator"></i> Ringkasan Kredit
                </div>
                
                <div id="ringkasanKredit">
                    <div class="info-card">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Harga Motor</span>
                            <span class="fw-bold" id="ringkasanHarga">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">DP</span>
                            <span class="fw-bold" id="ringkasanDP">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Pokok Kredit</span>
                            <span class="fw-bold" id="ringkasanPokok">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Bunga</span>
                            <span class="fw-bold" id="ringkasanBunga">Rp 0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">Cicilan / Bulan</span>
                            <span class="fw-bold text-primary fs-5" id="ringkasanCicilan">Rp 0</span>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning border-0 rounded-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>Pelanggan akan mendapat akun dengan password default: <strong>password123</strong></small>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">
                    <i class="fas fa-save me-2"></i> Simpan Pengajuan
                </button>
            </div>
        </div>
    </div>
</form>

<script>
function hitungCicilan() {
    const motorSelect = document.getElementById('motorSelect');
    const cicilanSelect = document.getElementById('cicilanSelect');
    const asuransiSelect = document.getElementById('asuransiSelect');
    const dpInput = document.getElementById('dpInput');
    
    const harga = parseFloat(motorSelect.options[motorSelect.selectedIndex]?.dataset?.harga || 0);
    const bulan = parseInt(cicilanSelect.options[cicilanSelect.selectedIndex]?.dataset?.bulan || 0);
    const margin = parseFloat(cicilanSelect.options[cicilanSelect.selectedIndex]?.dataset?.margin || 0);
    const biayaAsuransi = parseFloat(asuransiSelect.options[asuransiSelect.selectedIndex]?.dataset?.biaya || 0);
    let uangMuka = parseFloat(dpInput.value) || 0;
    
    if (harga > 0 && uangMuka < harga * 0.2) {
        uangMuka = harga * 0.2;
        dpInput.value = uangMuka;
    }
    
    if (harga === 0 || bulan === 0) {
        document.getElementById('ringkasanHarga').innerHTML = 'Rp 0';
        document.getElementById('ringkasanDP').innerHTML = 'Rp 0';
        document.getElementById('ringkasanPokok').innerHTML = 'Rp 0';
        document.getElementById('ringkasanBunga').innerHTML = 'Rp 0';
        document.getElementById('ringkasanCicilan').innerHTML = 'Rp 0';
        return;
    }
    
    const pokokKredit = harga - uangMuka + biayaAsuransi;
    const bungaTotal = pokokKredit * (margin / 100) * (bulan / 12);
    const totalKredit = pokokKredit + bungaTotal;
    const cicilan = totalKredit / bulan;
    
    document.getElementById('ringkasanHarga').innerHTML = 'Rp ' + harga.toLocaleString('id-ID');
    document.getElementById('ringkasanDP').innerHTML = 'Rp ' + uangMuka.toLocaleString('id-ID');
    document.getElementById('ringkasanPokok').innerHTML = 'Rp ' + pokokKredit.toLocaleString('id-ID');
    document.getElementById('ringkasanBunga').innerHTML = 'Rp ' + bungaTotal.toLocaleString('id-ID');
    document.getElementById('ringkasanCicilan').innerHTML = 'Rp ' + Math.round(cicilan).toLocaleString('id-ID');
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('motorSelect')?.addEventListener('change', hitungCicilan);
    document.getElementById('cicilanSelect')?.addEventListener('change', hitungCicilan);
    document.getElementById('asuransiSelect')?.addEventListener('change', hitungCicilan);
    document.getElementById('dpInput')?.addEventListener('input', hitungCicilan);
    hitungCicilan();
});
</script>
@endsection
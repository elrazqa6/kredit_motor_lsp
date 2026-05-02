@extends('layouts.marketing')

@section('title', 'Tambah Angsuran')
@section('page-title', 'Tambah Data Angsuran')

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
        margin-top: 16px;
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
    .highlight {
        background: #fef3c7;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('marketing.angsuran.store') }}" method="POST">
            @csrf
            
            <!-- Pilih Kredit -->
            <div class="form-card">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-credit-card text-primary me-2"></i> Pilih Kredit
                </h5>
                <div class="mb-3">
                    <label class="form-label">Kredit Aktif <span class="text-danger">*</span></label>
                    <select name="id_kredit" id="kreditSelect" class="form-select @error('id_kredit') is-invalid @enderror" required onchange="updateKreditInfo()">
                        <option value="">-- Pilih Kredit --</option>
                        @foreach($kreditAktif as $item)
                            <option value="{{ $item->id }}"
                                data-pelanggan="{{ $item->pengajuanKredit->pelanggan->nama_pelanggan }}"
                                data-motor="{{ $item->pengajuanKredit->motor->nama_motor }}"
                                data-tenor="{{ $item->pengajuanKredit->tenor }}"
                                data-cicilan="{{ $item->pengajuanKredit->cicilan_perbulan }}"
                                data-sisa="{{ $item->sisa_kredit }}"
                                data-angsuran_terakhir="{{ $item->angsuran->max('angsuran_ke') ?? 0 }}"
                                {{ old('id_kredit') == $item->id ? 'selected' : '' }}>
                                {{ $item->pengajuanKredit->pelanggan->nama_pelanggan }} - {{ $item->pengajuanKredit->motor->nama_motor }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kredit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Informasi Kredit -->
                <div id="kreditInfo" style="display: none;" class="info-box">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-label">Pelanggan</div>
                            <div class="info-value" id="infoPelanggan">-</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Motor</div>
                            <div class="info-value" id="infoMotor">-</div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="info-label">Tenor</div>
                            <div class="info-value" id="infoTenor">- bulan</div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="info-label">Cicilan per Bulan</div>
                            <div class="info-value" id="infoCicilan">Rp 0</div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="info-label">Sisa Kredit</div>
                            <div class="info-value" id="infoSisa">Rp 0</div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="info-label">Angsuran Terakhir</div>
                            <div class="info-value" id="infoAngsuranTerakhir">Belum ada angsuran</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Detail Angsuran -->
            <div class="form-card">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-receipt text-primary me-2"></i> Detail Angsuran
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Angsuran Ke <span class="text-danger">*</span></label>
                        <input type="number" name="angsuran_ke" id="angsuranKe" class="form-control @error('angsuran_ke') is-invalid @enderror" 
                               value="{{ old('angsuran_ke') }}" required readonly>
                        @error('angsuran_ke')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Bayar <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="tgl_bayar" class="form-control @error('tgl_bayar') is-invalid @enderror" 
                               value="{{ old('tgl_bayar', date('Y-m-d\TH:i')) }}" required>
                        @error('tgl_bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Total Bayar <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="total_bayar" id="totalBayar" class="form-control @error('total_bayar') is-invalid @enderror" 
                                   value="{{ old('total_bayar') }}" required onchange="hitungStatus()">
                        </div>
                        @error('total_bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" id="statusSelect" class="form-select">
                            <option value="Lunas">Lunas</option>
                            <option value="Belum Bayar">Belum Bayar</option>
                            <option value="Telat">Telat</option>
                        </select>
                        <small class="text-muted" id="statusHint"></small>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan keterangan jika diperlukan...">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Tombol Submit -->
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary px-5 py-2">
                    <i class="fas fa-save me-2"></i> Simpan Angsuran
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
                    <i class="fas fa-check-circle text-success me-2"></i>
                    Angsuran ke- akan dihitung otomatis
                </li>
                <li class="mb-2">
                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                    Total bayar minimal = cicilan per bulan
                </li>
                <li class="mb-2">
                    <i class="fas fa-chart-line text-warning me-2"></i>
                    Sisa kredit akan berkurang otomatis
                </li>
                <li>
                    <i class="fas fa-bell text-danger me-2"></i>
                    Status "Telat" jika melebihi jatuh tempo
                </li>
            </ul>
        </div>
        
        <!-- Ringkasan -->
        <div class="form-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-chart-simple text-primary me-2"></i> Ringkasan
            </h5>
            <div class="mb-2">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Total Dibayar:</span>
                    <span class="fw-bold" id="totalDibayar">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between mt-1">
                    <span class="text-muted">Sisa Setelah Bayar:</span>
                    <span class="fw-bold text-success" id="sisaSetelahBayar">Rp 0</span>
                </div>
            </div>
            <div class="progress mt-2" style="height: 6px;">
                <div class="progress-bar bg-success" id="progressBar" style="width: 0%"></div>
            </div>
        </div>
    </div>
</div>

<script>
function updateKreditInfo() {
    const select = document.getElementById('kreditSelect');
    const selectedOption = select.options[select.selectedIndex];
    const infoDiv = document.getElementById('kreditInfo');
    
    if (select.value) {
        const pelanggan = selectedOption.dataset.pelanggan;
        const motor = selectedOption.dataset.motor;
        const tenor = selectedOption.dataset.tenor;
        const cicilan = parseFloat(selectedOption.dataset.cicilan) || 0;
        const sisa = parseFloat(selectedOption.dataset.sisa) || 0;
        const angsuranTerakhir = parseInt(selectedOption.dataset.angsuran_terakhir) || 0;
        const angsuranKe = angsuranTerakhir + 1;
        
        document.getElementById('infoPelanggan').innerText = pelanggan;
        document.getElementById('infoMotor').innerText = motor;
        document.getElementById('infoTenor').innerHTML = tenor + ' bulan';
        document.getElementById('infoCicilan').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(cicilan);
        document.getElementById('infoSisa').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(sisa);
        document.getElementById('infoAngsuranTerakhir').innerHTML = angsuranTerakhir > 0 ? 'Angsuran ke-' + angsuranTerakhir : 'Belum ada angsuran';
        
        document.getElementById('angsuranKe').value = angsuranKe;
        
        // Set default total bayar = cicilan
        if (!document.getElementById('totalBayar').value) {
            document.getElementById('totalBayar').value = cicilan;
        }
        
        infoDiv.style.display = 'block';
        hitungStatus();
    } else {
        infoDiv.style.display = 'none';
        document.getElementById('angsuranKe').value = '';
    }
}

function hitungStatus() {
    const select = document.getElementById('kreditSelect');
    const selectedOption = select.options[select.selectedIndex];
    const cicilan = parseFloat(selectedOption.dataset.cicilan) || 0;
    const totalBayar = parseFloat(document.getElementById('totalBayar').value) || 0;
    const sisa = parseFloat(selectedOption.dataset.sisa) || 0;
    const statusSelect = document.getElementById('statusSelect');
    const statusHint = document.getElementById('statusHint');
    const totalDibayar = document.getElementById('totalDibayar');
    const sisaSetelahBayar = document.getElementById('sisaSetelahBayar');
    const progressBar = document.getElementById('progressBar');
    
    // Update ringkasan
    const sisaBaru = sisa - totalBayar;
    totalDibayar.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalBayar);
    sisaSetelahBayar.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.max(0, sisaBaru));
    
    const progress = sisa > 0 ? ((totalBayar / sisa) * 100) : 0;
    progressBar.style.width = Math.min(progress, 100) + '%';
    
    // Auto set status
    if (totalBayar >= cicilan) {
        statusSelect.value = 'Lunas';
        statusHint.innerHTML = '<span class="highlight">✓ Angsuran ini akan dianggap lunas</span>';
    } else if (totalBayar > 0) {
        statusSelect.value = 'Belum Bayar';
        statusHint.innerHTML = '<span class="highlight">⚠️ Total bayar kurang dari cicilan</span>';
    }
}

// Event listeners
document.getElementById('kreditSelect').addEventListener('change', updateKreditInfo);
document.getElementById('totalBayar').addEventListener('input', hitungStatus);

// Initial call if there's old value
if (document.getElementById('kreditSelect').value) {
    updateKreditInfo();
}
</script>
@endsection
@extends('layouts.client')

@section('title', 'Ajukan Kredit')
@section('page-title', 'Ajukan Kredit')

@section('content')
<div class="container px-0">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-paper-plane text-primary me-2"></i> Ajukan Kredit Motor
            </h4>
            <p class="text-muted mb-0">Isi form berikut untuk mengajukan kredit motor impian Anda</p>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="{{ route('client.pengajuan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Step Indicator -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body py-3">
            <div class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                <div class="step-item active">
                    <div class="step-circle">1</div>
                    <span class="step-label">Pilih Motor</span>
                </div>
                <div class="step-line"></div>
                <div class="step-item">
                    <div class="step-circle">2</div>
                    <span class="step-label">Detail Kredit</span>
                </div>
                <div class="step-line"></div>
                <div class="step-item">
                    <div class="step-circle">3</div>
                    <span class="step-label">Metode Bayar</span>
                </div>
                <div class="step-line"></div>
                <div class="step-item">
                    <div class="step-circle">4</div>
                    <span class="step-label">Upload Dokumen</span>
                </div>
                <div class="step-line"></div>
                <div class="step-item">
                    <div class="step-circle">5</div>
                    <span class="step-label">Review</span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('client.pengajuan.store') }}" method="POST" enctype="multipart/form-data" id="pengajuanForm">
        @csrf
        
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- SECTION 1: Pilih Motor -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 p-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-motorcycle text-primary me-2"></i> 1. Pilih Motor
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Motor yang Diinginkan <span class="text-danger">*</span></label>
                            <select name="id_motor" id="motorSelect" class="form-select @error('id_motor') is-invalid @enderror" required onchange="updateMotorInfo(this)">
                                <option value="">-- Pilih Motor --</option>
                                @foreach($motors ?? [] as $m)
                                    <option value="{{ $m->id }}"
                                        data-harga="{{ $m->harga_jual }}"
                                        data-nama="{{ $m->nama_motor }}"
                                        data-stok="{{ $m->stok }}"
                                        {{ old('id_motor') == $m->id ? 'selected' : '' }}>
                                        {{ $m->merk }} - {{ $m->nama_motor }} (Rp {{ number_format($m->harga_jual, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_motor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Motor Preview -->
                        <div id="motorPreview" class="mt-3 p-3 bg-light rounded-3" style="display: none;">
                            <div class="d-flex gap-3 align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-motorcycle fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <div class="small text-muted">Motor dipilih</div>
                                    <div class="fw-bold fs-5" id="previewNama">-</div>
                                    <div class="text-primary fw-semibold" id="previewHarga">Rp 0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Detail Kredit -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 p-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-calculator text-primary me-2"></i> 2. Detail Kredit
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis Cicilan <span class="text-danger">*</span></label>
                                <select name="id_jenis_cicilan" id="jenisCicilanSelect" class="form-select @error('id_jenis_cicilan') is-invalid @enderror" required onchange="hitungRingkasan()">
                                    <option value="">-- Pilih Tenor --</option>
                                    @foreach($jenisCicilans as $cicilan)
                                        <option value="{{ $cicilan->id }}"
                                            data-bulan="{{ $cicilan->lama_cicilan }}"
                                            data-margin="{{ $cicilan->margin_kredit }}"
                                            {{ old('id_jenis_cicilan') == $cicilan->id ? 'selected' : '' }}>
                                            {{ $cicilan->lama_cicilan }} Bulan ({{ number_format($cicilan->lama_cicilan / 12, 1) }} tahun) - Bunga {{ $cicilan->margin_kredit }}%
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_jenis_cicilan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Asuransi (Opsional)</label>
                                <select name="id_asuransi" id="asuransiSelect" class="form-select" onchange="hitungRingkasan()">
                                    <option value="">-- Tanpa Asuransi --</option>
                                    @foreach($asuransiList as $asuransi)
                                        <option value="{{ $asuransi->id }}"
                                            data-biaya="{{ $asuransi->biaya }}"
                                            {{ old('id_asuransi') == $asuransi->id ? 'selected' : '' }}>
                                            {{ $asuransi->nama_asuransi }} - Rp {{ number_format($asuransi->biaya, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Uang Muka (DP) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="uang_muka" id="dpInput" 
                                        class="form-control @error('uang_muka') is-invalid @enderror"
                                        value="{{ old('uang_muka', 0) }}" 
                                        min="0" 
                                        oninput="hitungRingkasan()" 
                                        required>
                                </div>
                                <div class="form-text" id="dpWarning" style="color: #dc2626; display: none;">
                                    <i class="fas fa-exclamation-triangle me-1"></i> DP minimal 20% dari harga motor
                                </div>
                                @error('uang_muka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Ringkasan Kredit -->
                        <div class="mt-4 p-3 bg-primary bg-opacity-10 rounded-3">
                            <div class="row text-center">
                                <div class="col-6 col-md-3 mb-2 mb-md-0">
                                    <div class="small text-muted">Harga Motor</div>
                                    <div class="fw-bold" id="summaryHarga">Rp 0</div>
                                </div>
                                <div class="col-6 col-md-3 mb-2 mb-md-0">
                                    <div class="small text-muted">DP</div>
                                    <div class="fw-bold" id="summaryDP">Rp 0</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small text-muted">Cicilan / Bulan</div>
                                    <div class="fw-bold text-success fs-5" id="summaryCicilan">Rp 0</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="small text-muted">Tenor</div>
                                    <div class="fw-bold" id="summaryTenor">- bulan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

         

                <!-- SECTION 4: Dokumen -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 p-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-file-upload text-primary me-2"></i> 3. Dokumen Pendukung
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info border-0 rounded-3 mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Upload dokumen dalam format JPG, PNG, atau PDF (max 2MB per file)
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Foto KTP <span class="text-danger">*</span></label>
                                <input type="file" name="url_ktp" class="form-control @error('url_ktp') is-invalid @enderror" accept="image/*,.pdf" required>
                                <small class="text-muted">Foto KTP yang jelas</small>
                                @error('url_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kartu Keluarga (KK)</label>
                                <input type="file" name="url_kk" class="form-control" accept="image/*,.pdf">
                                <small class="text-muted">Upload KK jika ada</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">NPWP (Opsional)</label>
                                <input type="file" name="url_npwp" class="form-control" accept="image/*,.pdf">
                                <small class="text-muted">NPWP jika memiliki</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Slip Gaji / Bukti Penghasilan</label>
                                <input type="file" name="url_slip_gaji" class="form-control" accept="image/*,.pdf">
                                <small class="text-muted">Slip gaji 3 bulan terakhir</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Foto Diri</label>
                                <input type="file" name="url_foto" class="form-control" accept="image/*,.pdf">
                                <small class="text-muted">Foto terbaru dengan latar polos</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Keterangan Tambahan</label>
                                <textarea name="keterangan_status_pengajuan" class="form-control" rows="3" placeholder="Informasi tambahan yang ingin disampaikan...">{{ old('keterangan_status_pengajuan') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Ringkasan -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                    <div class="card-header bg-white border-0 p-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-clipboard-list text-primary me-2"></i> Ringkasan Pengajuan
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3 pb-2 border-bottom">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Motor</span>
                                <span class="fw-semibold text-end" id="sumMotor">-</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tenor</span>
                                <span class="fw-semibold" id="sumTenor">-</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">DP</span>
                                <span class="fw-semibold" id="sumDP">-</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Metode Bayar</span>
                                <span class="fw-semibold" id="sumMetode">-</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Cicilan / Bulan</span>
                                <span class="fw-bold text-primary fs-5" id="sumCicilan">-</span>
                            </div>
                        </div>
                        <div class="alert alert-light border-0 rounded-3 mb-3">
                            <div class="small text-muted mb-1">Total Pembayaran</div>
                            <div class="fw-bold" id="sumTotal">Rp 0</div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 fw-semibold">
                                <i class="fas fa-paper-plane me-2"></i> Ajukan Kredit
                            </button>
                            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary rounded-pill py-2">
                                <i class="fas fa-times me-2"></i> Batal
                            </a>
                        </div>
                        <div class="mt-3 pt-2 text-center">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i> Data Anda aman & terenkripsi
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card border-0 shadow-sm rounded-4 mt-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i> Informasi
                        </h6>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Proses cepat 1x24 jam</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Bunga kompetitif</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Tenor fleksibel</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Pembayaran mudah</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Tanpa biaya administrasi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }
    .step-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #64748b;
    }
    .step-item.active .step-circle {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .step-label {
        font-size: 12px;
        color: #64748b;
    }
    .step-item.active .step-label {
        color: #667eea;
        font-weight: 600;
    }
    .step-line {
        width: 40px;
        height: 2px;
        background: #e2e8f0;
    }
    @media (max-width: 576px) {
        .step-line {
            width: 20px;
        }
        .step-label {
            font-size: 10px;
        }
        .step-circle {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }
    }
    .sticky-top {
        position: sticky;
        top: 20px;
        z-index: 1;
    }
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .rounded-4 {
        border-radius: 1rem !important;
    }
    
    /* Method Card Styles */
    .method-card {
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.2s;
        background: #fff;
    }
    .method-card:hover {
        border-color: #667eea;
        background: #f8fafc;
    }
    .method-card:has(.form-check-input:checked) {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea10 0%, #764ba210 100%);
    }
    .method-radio .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
</style>

<script>
function formatRp(n) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(n));
}

function updateMotorInfo(sel) {
    const opt = sel.options[sel.selectedIndex];
    const harga = parseFloat(opt.dataset.harga) || 0;
    const nama = opt.dataset.nama || '-';

    const preview = document.getElementById('motorPreview');
    if (harga > 0) {
        preview.style.display = 'block';
        document.getElementById('previewNama').textContent = nama;
        document.getElementById('previewHarga').textContent = formatRp(harga);
        document.getElementById('sumMotor').textContent = nama;
    } else {
        preview.style.display = 'none';
        document.getElementById('sumMotor').textContent = '-';
    }
    hitungRingkasan();
}

function selectMetode(id) {
    // Cari radio button yang sesuai
    const radio = document.getElementById('method' + id);
    if (radio) {
        radio.checked = true;
    }
    
    // Cari nama metode
    const card = document.querySelector(`.method-card[data-method-id="${id}"]`);
    const namaMetode = card ? card.querySelector('.fw-bold')?.textContent : '-';
    
    // Update ringkasan
    document.getElementById('sumMetode').textContent = namaMetode;
    
    // Tampilkan info
    const metodeInfo = document.getElementById('metodeInfo');
    const metodeInfoText = document.getElementById('metodeInfoText');
    if (metodeInfo && metodeInfoText) {
        metodeInfo.style.display = 'block';
        metodeInfoText.innerHTML = `<i class="fas fa-check-circle me-1"></i> Metode pembayaran: <strong>${namaMetode}</strong>`;
    }
}

function hitungRingkasan() {
    const motorSel = document.getElementById('motorSelect');
    const cicilanSel = document.getElementById('jenisCicilanSelect');
    const asuransiSel = document.getElementById('asuransiSelect');
    const dpInput = document.getElementById('dpInput');

    const opt = motorSel.options[motorSel.selectedIndex];
    const cOpt = cicilanSel.options[cicilanSel.selectedIndex];
    const aOpt = asuransiSel.options[asuransiSel.selectedIndex];

    const harga = parseFloat(opt?.dataset?.harga) || 0;
    let uangMuka = parseFloat(dpInput.value) || 0;
    const bulan = parseInt(cOpt?.dataset?.bulan) || 0;
    const margin = parseFloat(cOpt?.dataset?.margin) || 0;
    const biayaAsuransi = parseFloat(aOpt?.dataset?.biaya) || 0;

    // Validasi DP minimal 20%
    const dpMinimal = harga * 0.2;
    const dpWarning = document.getElementById('dpWarning');
    if (uangMuka < dpMinimal && harga > 0) {
        dpWarning.style.display = 'block';
        uangMuka = dpMinimal;
        dpInput.value = uangMuka;
    } else {
        dpWarning.style.display = 'none';
    }

    if (!harga || !bulan) {
        document.getElementById('summaryHarga').innerText = formatRp(harga);
        document.getElementById('summaryDP').innerText = formatRp(uangMuka);
        document.getElementById('summaryCicilan').innerText = formatRp(0);
        document.getElementById('summaryTenor').innerText = bulan + ' bulan';
        document.getElementById('sumTenor').innerText = bulan + ' bulan';
        document.getElementById('sumDP').innerText = formatRp(uangMuka);
        document.getElementById('sumCicilan').innerText = formatRp(0);
        document.getElementById('sumTotal').innerText = formatRp(0);
        
        // Reset hidden inputs
        document.getElementById('hargaKreditInput').value = 0;
        document.getElementById('cicilanPerbulanInput').value = 0;
        document.getElementById('dpPersenInput').value = 0;
        document.getElementById('hargaCashInput').value = 0;
        document.getElementById('biayaAsuransiPerbulanInput').value = 0;
        document.getElementById('tenorInput').value = 0;
        return;
    }

    // Hitung kredit
    // Hitung kredit
    const pokokKredit = harga - uangMuka;
    const bungaTotal = pokokKredit * (margin / 100) * (bulan / 12);
    const totalAngsuran = pokokKredit + bungaTotal;
    const asuransiPerBulan = biayaAsuransi / bulan;
    const cicilan = (totalAngsuran / bulan) + asuransiPerBulan;
    const totalBayar = uangMuka + totalAngsuran + biayaAsuransi;
    const dpPersen = (uangMuka / harga) * 100;

    // Update tampilan
    document.getElementById('summaryHarga').innerText = formatRp(harga);
    document.getElementById('summaryDP').innerText = formatRp(uangMuka);
    document.getElementById('summaryCicilan').innerText = formatRp(cicilan);
    document.getElementById('summaryTenor').innerText = bulan + ' bulan';
    document.getElementById('sumTenor').innerText = bulan + ' bulan';
    document.getElementById('sumDP').innerText = formatRp(uangMuka);
    document.getElementById('sumCicilan').innerText = formatRp(cicilan);
    document.getElementById('sumTotal').innerText = formatRp(totalBayar);

    // Update hidden inputs
    document.getElementById('hargaKreditInput').value = totalAngsuran;
    document.getElementById('cicilanPerbulanInput').value = cicilan;
    document.getElementById('dpPersenInput').value = dpPersen;
    document.getElementById('hargaCashInput').value = harga;
    document.getElementById('biayaAsuransiPerbulanInput').value = asuransiPerBulan;
    document.getElementById('tenorInput').value = bulan;

}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const motorSelect = document.getElementById('motorSelect');
    const cicilanSelect = document.getElementById('jenisCicilanSelect');
    const asuransiSelect = document.getElementById('asuransiSelect');
    const dpInput = document.getElementById('dpInput');

    if (motorSelect) {
        motorSelect.addEventListener('change', hitungRingkasan);
        if (motorSelect.value) updateMotorInfo(motorSelect);
    }
    if (cicilanSelect) cicilanSelect.addEventListener('change', hitungRingkasan);
    if (asuransiSelect) asuransiSelect.addEventListener('change', hitungRingkasan);
    if (dpInput) dpInput.addEventListener('input', hitungRingkasan);
    
    hitungRingkasan();
    
    // Cek metode bayar yang sudah dipilih (old value)
    const selectedMethod = document.querySelector('input[name="id_metode_bayar"]:checked');
    if (selectedMethod) {
        selectMetode(selectedMethod.value);
    }
});
</script>

@if(session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonColor: '#dc2626'
    });
</script>
@endif
@endsection
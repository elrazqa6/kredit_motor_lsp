@extends('layouts.marketing')

@section('title', 'Tambah Kredit')
@section('page-title', 'Tambah Data Kredit')

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
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('marketing.kredit.store') }}" method="POST">
            @csrf
            
            <!-- Pilih Pengajuan Kredit -->
            <div class="form-card">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-file-invoice text-primary me-2"></i> Pilih Pengajuan Kredit
                </h5>
                <div class="mb-3">
                    <label class="form-label">Pengajuan Kredit yang Disetujui <span class="text-danger">*</span></label>
                    <select name="id_pengajuan_kredit" id="pengajuanSelect" class="form-select @error('id_pengajuan_kredit') is-invalid @enderror" required onchange="updateKreditInfo()">
                        <option value="">-- Pilih Pengajuan --</option>
                        @foreach($pengajuanDisetujui as $item)
                            <option value="{{ $item->id }}"
                                data-pelanggan="{{ $item->pelanggan->nama_pelanggan }}"
                                data-motor="{{ $item->motor->nama_motor }}"
                                data-tenor="{{ $item->tenor }}"
                                data-cicilan="{{ $item->cicilan_perbulan }}"
                                data-total="{{ $item->harga_kredit }}"
                                {{ old('id_pengajuan_kredit') == $item->id ? 'selected' : '' }}>
                                {{ $item->pelanggan->nama_pelanggan }} - {{ $item->motor->nama_motor }} (Rp {{ number_format($item->harga_kredit, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_pengajuan_kredit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Informasi Pengajuan -->
                <div id="pengajuanInfo" style="display: none;" class="info-box">
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
                            <div class="info-label">Total Kredit</div>
                            <div class="info-value" id="infoTotal">Rp 0</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Detail Kredit -->
            <div class="form-card">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-credit-card text-primary me-2"></i> Detail Kredit
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Metode Bayar <span class="text-danger">*</span></label>
                        <select name="id_metode_bayar" class="form-select @error('id_metode_bayar') is-invalid @enderror" required>
                            <option value="">-- Pilih Metode Bayar --</option>
                            @foreach($metodeBayar as $metode)
                                <option value="{{ $metode->id }}" {{ old('id_metode_bayar') == $metode->id ? 'selected' : '' }}>
                                    {{ $metode->nama_metode }} - {{ $metode->nama_bank ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_metode_bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Mulai Kredit <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_mulai_kredit" id="tglMulai" class="form-control @error('tgl_mulai_kredit') is-invalid @enderror" 
                               value="{{ old('tgl_mulai_kredit', date('Y-m-d')) }}" required onchange="hitungTglSelesai()">
                        @error('tgl_mulai_kredit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Selesai Kredit</label>
                        <input type="date" name="tgl_selesai_kredit" id="tglSelesai" class="form-control bg-light" readonly>
                        <small class="text-muted">Dihitung otomatis berdasarkan tenor</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sisa Kredit <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="sisa_kredit" id="sisaKredit" class="form-control @error('sisa_kredit') is-invalid @enderror" 
                                   value="{{ old('sisa_kredit', 0) }}" required readonly>
                        </div>
                        @error('sisa_kredit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Status Kredit</label>
                        <select name="status_kredit" class="form-select">
                            <option value="aktif">Aktif</option>
                            <option value="lunas">Lunas</option>
                            <option value="bermasalah">Bermasalah</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan Status Kredit</label>
                        <textarea name="keterangan_status_kredit" class="form-control" rows="3" placeholder="Tambahkan keterangan jika diperlukan...">{{ old('keterangan_status_kredit') }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Tombol Submit -->
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary px-5 py-2">
                    <i class="fas fa-save me-2"></i> Simpan Kredit
                </button>
                <a href="{{ route('marketing.kredit.index') }}" class="btn btn-outline-secondary px-4">
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
                    Kredit dibuat berdasarkan pengajuan yang sudah disetujui
                </li>
                <li class="mb-2">
                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                    Tanggal selesai dihitung otomatis dari tenor
                </li>
                <li class="mb-2">
                    <i class="fas fa-money-bill-wave text-warning me-2"></i>
                    Sisa kredit awal = total kredit
                </li>
                <li>
                    <i class="fas fa-chart-line text-info me-2"></i>
                    Status akan berubah otomatis saat angsuran lunas
                </li>
            </ul>
        </div>
        
        <!-- Metode Bayar Info -->
        <div class="form-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-credit-card text-primary me-2"></i> Metode Pembayaran
            </h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Metode</th>
                            <th>Bank</th>
                            <th>No Rekening</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($metodeBayar as $metode)
                        <tr>
                            <td>{{ $metode->nama_metode }}</td>
                            <td>{{ $metode->nama_bank ?? '-' }}</td>
                            <td>{{ $metode->no_rekening ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function updateKreditInfo() {
    const select = document.getElementById('pengajuanSelect');
    const selectedOption = select.options[select.selectedIndex];
    const infoDiv = document.getElementById('pengajuanInfo');
    
    if (select.value) {
        const pelanggan = selectedOption.dataset.pelanggan;
        const motor = selectedOption.dataset.motor;
        const tenor = selectedOption.dataset.tenor;
        const cicilan = parseFloat(selectedOption.dataset.cicilan) || 0;
        const total = parseFloat(selectedOption.dataset.total) || 0;
        
        document.getElementById('infoPelanggan').innerText = pelanggan;
        document.getElementById('infoMotor').innerText = motor;
        document.getElementById('infoTenor').innerHTML = tenor + ' bulan';
        document.getElementById('infoCicilan').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(cicilan);
        document.getElementById('infoTotal').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('sisaKredit').value = total;
        
        infoDiv.style.display = 'block';
        hitungTglSelesai();
    } else {
        infoDiv.style.display = 'none';
        document.getElementById('sisaKredit').value = 0;
    }
}

function hitungTglSelesai() {
    const tglMulai = document.getElementById('tglMulai').value;
    const select = document.getElementById('pengajuanSelect');
    const selectedOption = select.options[select.selectedIndex];
    const tenor = parseInt(selectedOption.dataset.tenor) || 0;
    
    if (tglMulai && tenor > 0) {
        const startDate = new Date(tglMulai);
        const endDate = new Date(startDate);
        endDate.setMonth(endDate.getMonth() + tenor);
        
        const year = endDate.getFullYear();
        const month = String(endDate.getMonth() + 1).padStart(2, '0');
        const day = String(endDate.getDate()).padStart(2, '0');
        
        document.getElementById('tglSelesai').value = `${year}-${month}-${day}`;
    }
}

// Event listeners
document.getElementById('pengajuanSelect').addEventListener('change', updateKreditInfo);
document.getElementById('tglMulai').addEventListener('change', hitungTglSelesai);

// Initial call if there's old value
if (document.getElementById('pengajuanSelect').value) {
    updateKreditInfo();
}
</script>
@endsection
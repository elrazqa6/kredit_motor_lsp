@extends('layouts.client')

@section('title', 'Form Pengajuan Kredit')

@section('content')
<div class="container px-0">
    <!-- Header Section -->
    <div class="mb-4">
        <h3 class="fw-bold mb-1">
            <i class="fas fa-paper-plane text-primary me-2"></i> Form Pengajuan Kredit
        </h3>
        <p class="text-muted">Isi data berikut untuk mengajukan kredit motor</p>
    </div>

    <div class="row g-4">
        <!-- Form Pengajuan -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('client.pengajuan.store') }}" method="POST" id="pengajuanForm">
                        @csrf
                        
                        <!-- Pilih Motor -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-motorcycle text-primary me-1"></i> Pilih Motor
                            </label>
                            <select name="motor_id" id="motor_id" class="form-select rounded-3" required>
                                <option value="">-- Pilih Motor --</option>
                                @foreach($motors as $m)
                                    <option value="{{ $m->id }}" 
                                            data-harga="{{ $m->harga_jual }}"
                                            data-nama="{{ $m->nama_motor }}"
                                            {{ (request('motor_id') == $m->id || old('motor_id') == $m->id) ? 'selected' : '' }}>
                                        {{ $m->merk }} - {{ $m->nama_motor }} (Rp {{ number_format($m->harga_jual, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('motor_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Informasi Motor -->
                        <div class="bg-light rounded-3 p-3 mb-4" id="motorInfo" style="display: none;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Motor Pilihan</small>
                                    <div class="fw-bold fs-5" id="selectedMotorName">-</div>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted">Harga OTR</small>
                                    <div class="fw-bold text-primary fs-5" id="selectedMotorPrice">Rp 0</div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Pengajuan -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-percent text-primary me-1"></i> DP (%)
                                </label>
                                <div class="d-flex gap-2">
                                    <input type="range" name="dp_persen" id="dp_persen" 
                                           class="form-range flex-grow-1" 
                                           min="10" max="30" step="5" 
                                           value="{{ old('dp_persen', request('dp', 20)) }}">
                                    <input type="number" name="dp_persen_input" id="dp_persen_input" 
                                           class="form-control rounded-pill" style="width: 70px;" 
                                           min="10" max="30" step="5" 
                                           value="{{ old('dp_persen', request('dp', 20)) }}">
                                </div>
                                @error('dp_persen')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt text-primary me-1"></i> Tenor (Bulan)
                                </label>
                                <select name="tenor" id="tenor" class="form-select rounded-3" required>
                                    <option value="12" {{ old('tenor', request('tenor', 24)) == 12 ? 'selected' : '' }}>12 bulan (1 tahun)</option>
                                    <option value="24" {{ old('tenor', request('tenor', 24)) == 24 ? 'selected' : '' }}>24 bulan (2 tahun) - Populer</option>
                                    <option value="36" {{ old('tenor', request('tenor', 24)) == 36 ? 'selected' : '' }}>36 bulan (3 tahun)</option>
                                </select>
                                @error('tenor')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Detail Pembayaran -->
                        <div class="bg-gradient-primary text-white rounded-3 p-4 mb-4">
                            <h6 class="fw-bold mb-3">Detail Pembayaran</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-white-50">Harga Motor</small>
                                    <div class="fw-bold" id="displayHarga">Rp 0</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-white-50">DP Nominal</small>
                                    <div class="fw-bold" id="displayDP">Rp 0</div>
                                </div>
                                <div class="col-6 mt-2">
                                    <small class="text-white-50">Pokok Pinjaman</small>
                                    <div class="fw-bold" id="displayPokok">Rp 0</div>
                                </div>
                                <div class="col-6 mt-2">
                                    <small class="text-white-50">Total Bunga (8%/thn)</small>
                                    <div class="fw-bold" id="displayBunga">Rp 0</div>
                                </div>
                                <div class="col-12 mt-3 pt-2 border-top border-white-30">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Cicilan per Bulan</span>
                                        <span class="fs-3 fw-bold" id="displayCicilan">Rp 0</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 flex-grow-1">
                                <i class="fas fa-paper-plane me-2"></i> Ajukan Kredit
                            </button>
                            <a href="{{ route('client.pengajuan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-arrow-left me-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Informasi Sidebar -->
        <div class="col-lg-4">
            <!-- Persyaratan -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i> Persyaratan
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-id-card text-primary me-2"></i> KTP (asli & fotokopi)</li>
                        <li class="mb-2"><i class="fas fa-file-alt text-primary me-2"></i> Kartu Keluarga</li>
                        <li class="mb-2"><i class="fas fa-wallet text-primary me-2"></i> Slip Gaji/Surat Keterangan Kerja</li>
                        <li class="mb-2"><i class="fas fa-home text-primary me-2"></i> Rekening Listrik/PDAM</li>
                        <li><i class="fas fa-phone text-primary me-2"></i> NPWP (opsional)</li>
                    </ul>
                </div>
            </div>

            <!-- Info Bunga -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-chart-line text-success me-2"></i> Info Bunga
                    </h6>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Bunga per tahun</span>
                            <strong>8% flat</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Bunga per bulan</span>
                            <strong>0.67%</strong>
                        </div>
                        <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                            <span>marketing</span>
                            <strong>Gratis</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Asuransi</span>
                            <strong>Inklusif</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontak -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-headset text-success me-2"></i> Butuh Bantuan?
                    </h6>
                    <p class="small text-muted mb-2">Hubungi customer service kami:</p>
                    <div class="d-flex flex-column gap-2">
                        <a href="tel:081234567890" class="text-decoration-none">
                            <i class="fab fa-whatsapp text-success me-2"></i> +62 812 3456 7890
                        </a>
                        <a href="mailto:cs@kreditmotor.id" class="text-decoration-none">
                            <i class="fas fa-envelope text-primary me-2"></i> cs@kreditmotor.id
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .form-range {
        height: 6px;
    }
    .form-range::-webkit-slider-thumb {
        background: #667eea;
    }
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const motorSelect = document.getElementById('motor_id');
    const dpRange = document.getElementById('dp_persen');
    const dpInput = document.getElementById('dp_persen_input');
    const tenorSelect = document.getElementById('tenor');
    
    let selectedHarga = 0;
    
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(angka));
    }
    
    function hitungSimulasi() {
        if (selectedHarga <= 0) return;
        
        let dpPersen = parseInt(dpRange.value);
        let tenorBulan = parseInt(tenorSelect.value);
        let dpValue = (selectedHarga * dpPersen) / 100;
        let pokok = selectedHarga - dpValue;
        let bungaPerTahun = 8;
        let totalBunga = (pokok * bungaPerTahun / 100) * (tenorBulan / 12);
        let totalPinjaman = pokok + totalBunga;
        let cicilanPerBulan = totalPinjaman / tenorBulan;
        
        document.getElementById('displayHarga').innerText = formatRupiah(selectedHarga);
        document.getElementById('displayDP').innerText = formatRupiah(dpValue);
        document.getElementById('displayPokok').innerText = formatRupiah(pokok);
        document.getElementById('displayBunga').innerText = formatRupiah(totalBunga);
        document.getElementById('displayCicilan').innerText = formatRupiah(cicilanPerBulan);
    }
    
    function updateMotorInfo() {
        const selectedOption = motorSelect.options[motorSelect.selectedIndex];
        if (motorSelect.value && selectedOption) {
            selectedHarga = parseInt(selectedOption.dataset.harga);
            const motorName = selectedOption.dataset.nama;
            
            document.getElementById('selectedMotorName').innerText = motorName;
            document.getElementById('selectedMotorPrice').innerText = formatRupiah(selectedHarga);
            document.getElementById('motorInfo').style.display = 'block';
            
            hitungSimulasi();
        } else {
            document.getElementById('motorInfo').style.display = 'none';
            selectedHarga = 0;
        }
    }
    
    // Event listeners
    motorSelect.addEventListener('change', updateMotorInfo);
    dpRange.addEventListener('input', function() {
        dpInput.value = this.value;
        hitungSimulasi();
    });
    dpInput.addEventListener('input', function() {
        let val = parseInt(this.value);
        if (val < 10) val = 10;
        if (val > 30) val = 30;
        dpRange.value = val;
        hitungSimulasi();
    });
    tenorSelect.addEventListener('change', hitungSimulasi);
    
    // Initial load jika ada motor_id dari parameter
    if (motorSelect.value) {
        updateMotorInfo();
    }
});
</script>
@endsection
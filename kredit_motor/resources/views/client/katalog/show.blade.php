@extends('layouts.client')

@section('title', $motor->nama_motor . ' - Detail Motor Kredit')

@section('content')
<div class="container px-0">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('client.motor.index') }}" class="text-decoration-none">Katalog Motor</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $motor->nama_motor }}</li>
        </ol>
    </nav>

    <!-- Main Motor Detail -->
    <div class="row g-4">
        <!-- Left Column: Gallery -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 90px; z-index: 1;">
                <!-- Main Image -->
                <div class="position-relative bg-gradient-dark" style="height: 400px;">
                    @php
                        $fotoPath = null;
                        if($motor->foto1 && file_exists(public_path('storage/'.$motor->foto1))) {
                            $fotoPath = asset('storage/'.$motor->foto1);
                        } elseif($motor->foto2 && file_exists(public_path('storage/'.$motor->foto2))) {
                            $fotoPath = asset('storage/'.$motor->foto2);
                        } elseif($motor->foto3 && file_exists(public_path('storage/'.$motor->foto3))) {
                            $fotoPath = asset('storage/'.$motor->foto3);
                        }
                    @endphp
                    
                    @if($fotoPath)
                        <img src="{{ $fotoPath }}" 
                             id="mainImage"
                             class="w-100 h-100" 
                             alt="{{ $motor->nama_motor }}"
                             style="object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-motorcycle fa-6x text-white opacity-50"></i>
                        </div>
                    @endif
                    
                    <!-- Badge -->
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-primary rounded-pill px-3 py-2 shadow">
                            <i class="fas fa-check-circle me-1"></i> Tersedia
                        </span>
                    </div>
                </div>
                
                <!-- Thumbnail Gallery -->
                @if($motor->foto1 || $motor->foto2 || $motor->foto3)
                <div class="p-3 bg-white border-top">
                    <div class="row g-2">
                        @if($motor->foto1 && file_exists(public_path('storage/'.$motor->foto1)))
                        <div class="col-3">
                            <img src="{{ asset('storage/'.$motor->foto1) }}" 
                                 class="w-100 rounded-3 cursor-pointer thumbnail-img active-thumb" 
                                 style="height: 80px; object-fit: cover; cursor: pointer;"
                                 data-image="{{ asset('storage/'.$motor->foto1) }}"
                                 alt="Thumbnail 1">
                        </div>
                        @endif
                        @if($motor->foto2 && file_exists(public_path('storage/'.$motor->foto2)))
                        <div class="col-3">
                            <img src="{{ asset('storage/'.$motor->foto2) }}" 
                                 class="w-100 rounded-3 cursor-pointer thumbnail-img" 
                                 style="height: 80px; object-fit: cover; cursor: pointer;"
                                 data-image="{{ asset('storage/'.$motor->foto2) }}"
                                 alt="Thumbnail 2">
                        </div>
                        @endif
                        @if($motor->foto3 && file_exists(public_path('storage/'.$motor->foto3)))
                        <div class="col-3">
                            <img src="{{ asset('storage/'.$motor->foto3) }}" 
                                 class="w-100 rounded-3 cursor-pointer thumbnail-img" 
                                 style="height: 80px; object-fit: cover; cursor: pointer;"
                                 data-image="{{ asset('storage/'.$motor->foto3) }}"
                                 alt="Thumbnail 3">
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Right Column: Details -->
        <div class="col-lg-6">
            <!-- Motor Title & Rating -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-2 mb-2">
                                <i class="fas fa-trademark me-1"></i> {{ $motor->merk }}
                            </span>
                            <h1 class="fw-bold mb-2">{{ $motor->nama_motor }}</h1>
                            <p class="text-muted mb-0">
                                <i class="fas fa-layer-group me-1"></i> 
                                {{ $motor->jenisMotor->nama_jenis ?? 'Motor Sport' }}
                            </p>
                        </div>
                        <div class="text-end">
                            <div class="text-warning mb-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <small class="text-muted">4.5 (120 ulasan)</small>
                        </div>
                    </div>
                    
                    <!-- Price Section -->
                    <div class="bg-gradient-soft rounded-3 p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">Harga OTR Jakarta</small>
                                <div class="h1 text-primary fw-bold mb-0">
                                    Rp {{ number_format($motor->harga_jual, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">Estimasi Cicilan</small>
                                <div class="h4 text-success fw-bold mb-0">
                                    Rp {{ number_format($motor->harga_jual * 0.035, 0, ',', '.') }}
                                </div>
                                <small>/bulan (tenor 24 bulan)</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Action Buttons -->
                    <div class="d-flex gap-3 mb-4">
                        <button type="button" 
                                class="btn btn-primary rounded-pill px-5 py-3 flex-grow-1 fw-semibold quick-simulasi"
                                data-harga="{{ $motor->harga_jual }}"
                                data-nama="{{ $motor->nama_motor }}"
                                data-id="{{ $motor->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#simulasiCepatModal">
                            <i class="fas fa-chart-line me-2"></i> Simulasi Kredit
                        </button>
                        <a href="#" class="btn btn-outline-primary rounded-pill px-4 py-3">
                            <i class="fas fa-heart"></i>
                        </a>
                    </div>
                    
                    <!-- Tombol Ajukan Kredit Langsung -->
                    <a href="{{ route('client.pengajuan.create', ['motor_id' => $motor->id]) }}" 
                       class="btn btn-success rounded-pill py-3 w-100 mb-4 fw-semibold">
                        <i class="fas fa-paper-plane me-2"></i> Ajukan Kredit Sekarang
                    </a>
                    
                    <!-- Key Features -->
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-soft-primary rounded-circle p-2 me-2">
                                    <i class="fas fa-percent text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">DP Mulai</small>
                                    <strong>10% dari harga motor</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-soft-primary rounded-circle p-2 me-2">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Tenor</small>
                                    <strong>12 - 36 bulan</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-soft-primary rounded-circle p-2 me-2">
                                    <i class="fas fa-bolt text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Proses</small>
                                    <strong>Cepat & Mudah</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-soft-primary rounded-circle p-2 me-2">
                                    <i class="fas fa-file-invoice text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Persyaratan</small>
                                    <strong>Sederhana</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab Section: Deskripsi & Spesifikasi -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs border-0 p-3 pb-0" id="motorTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill me-2" id="deskripsi-tab" data-bs-toggle="tab" data-bs-target="#deskripsi" type="button" role="tab">
                                <i class="fas fa-align-left me-2"></i>Deskripsi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill me-2" id="spesifikasi-tab" data-bs-toggle="tab" data-bs-target="#spesifikasi" type="button" role="tab">
                                <i class="fas fa-cog me-2"></i>Spesifikasi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill" id="kredit-tab" data-bs-toggle="tab" data-bs-target="#kredit" type="button" role="tab">
                                <i class="fas fa-calculator me-2"></i>Info Kredit
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content p-4">
                        <!-- Deskripsi Tab -->
                        <div class="tab-pane fade show active" id="deskripsi" role="tabpanel">
                            <h5 class="fw-bold mb-3">Tentang {{ $motor->nama_motor }}</h5>
                            <p class="text-muted mb-4">
                                {{ $motor->deskripsi ?? 'Motor ini merupakan pilihan terbaik untuk kebutuhan mobilitas Anda sehari-hari. Dengan desain modern, performa handal, dan fitur canggih, motor ini siap menemani perjalanan Anda. Nikmati kenyamanan berkendara dengan teknologi terbaru dan efisiensi bahan bakar yang optimal.' }}
                            </p>
                            
                            <h6 class="fw-semibold mb-3">Keunggulan:</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span>Irit bahan bakar</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span>Desain modern & stylish</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span>Performa mesin tangguh</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span>Fitur keselamatan lengkap</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span>Garansi resmi 3 tahun</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span>Service center terdekat</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Spesifikasi Tab -->
                        <div class="tab-pane fade" id="spesifikasi" role="tabpanel">
                            <h5 class="fw-bold mb-3">Spesifikasi Teknis</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tr>
                                        <td style="width: 200px;"><strong>Merk</strong></td>
                                        <td>: {{ $motor->merk }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tipe Motor</strong></td>
                                        <td>: {{ $motor->jenisMotor->nama_jenis ?? 'Motor Sport' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tahun</strong></td>
                                        <td>: {{ $motor->tahun ?? '2024' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kapasitas Mesin</strong></td>
                                        <td>: {{ $motor->cc ?? '150' }} cc</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Warna</strong></td>
                                        <td>: Hitam, Putih, Merah, Biru</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sistem Bahan Bakar</strong></td>
                                        <td>: Injeksi (PGM-FI)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Transmisi</strong></td>
                                        <td>: Otomatis (CVT)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Rem Depan</strong></td>
                                        <td>: Cakram Hidrolik</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Rem Belakang</strong></td>
                                        <td>: Cakram / Tromol</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Info Kredit Tab -->
                        <div class="tab-pane fade" id="kredit" role="tabpanel">
                            <h5 class="fw-bold mb-3">Simulasi Kredit</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>DP</th>
                                            <th>12 Bulan</th>
                                            <th>24 Bulan</th>
                                            <th>36 Bulan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $harga = $motor->harga_jual;
                                            $dpValues = [10, 15, 20, 25, 30];
                                        @endphp
                                        @foreach($dpValues as $dp)
                                        <tr>
                                            <td><strong>{{ $dp }}%</strong><br><small>(Rp {{ number_format($harga * $dp / 100, 0, ',', '.') }})</small></td>
                                            <td>Rp {{ number_format(($harga * (1 - $dp/100) * 1.08) / 12, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format(($harga * (1 - $dp/100) * 1.16) / 24, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format(($harga * (1 - $dp/100) * 1.24) / 36, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">*Simulasi dengan bunga flat 8% per tahun. Syarat dan ketentuan berlaku.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Rekomendasi Motor Lainnya -->
    @if(isset($rekomendasi) && $rekomendasi->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">
                    <i class="fas fa-thumbs-up me-2 text-primary"></i> Rekomendasi Motor Lainnya
                </h4>
                <a href="{{ route('client.motor.index') }}" class="text-decoration-none">Lihat Semua <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="row g-4">
                @foreach($rekomendasi as $rekom)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift">
                        @php
                            $rekFoto = null;
                            if($rekom->foto1 && file_exists(public_path('storage/'.$rekom->foto1))) {
                                $rekFoto = asset('storage/'.$rekom->foto1);
                            }
                        @endphp
                        @if($rekFoto)
                            <img src="{{ $rekFoto }}" class="card-img-top rounded-top-4" style="height: 180px; object-fit: cover;" alt="{{ $rekom->nama_motor }}">
                        @else
                            <div class="bg-gradient-soft rounded-top-4" style="height: 180px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-motorcycle fa-3x text-primary opacity-50"></i>
                            </div>
                        @endif
                        <div class="card-body p-3">
                            <h6 class="fw-bold mb-1">{{ $rekom->nama_motor }}</h6>
                            <small class="text-muted">{{ $rekom->merk }}</small>
                            <div class="text-primary fw-bold mt-2">
                                Rp {{ number_format($rekom->harga_jual, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3">
                            <a href="{{ route('client.motor.show', $rekom->id) }}" class="btn btn-sm btn-outline-primary rounded-pill w-100">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal Simulasi Cepat Premium -->
<div class="modal fade" id="simulasiCepatModal" tabindex="-1" aria-labelledby="simulasiCepatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-xl">
            <div class="modal-header border-0 bg-gradient-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="simulasiCepatModalLabel">
                    <i class="fas fa-chart-line me-2"></i> Simulasi Kredit
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="bg-gradient-soft rounded-3 p-4 text-center">
                            <i class="fas fa-motorcycle fa-3x text-primary mb-3"></i>
                            <div class="small text-muted mb-1">Motor Pilihan</div>
                            <div class="fw-bold fs-5" id="modalMotorName">-</div>
                            <hr>
                            <div class="text-start">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Harga Motor:</span>
                                    <strong id="modalHargaMotor">Rp 0</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-percent me-1 text-primary"></i> DP (Down Payment)
                            </label>
                            <input type="range" class="form-range" id="dpRange" min="10" max="30" step="5" value="20">
                            <div class="d-flex justify-content-between mt-2">
                                <span class="badge bg-light">10%</span>
                                <span class="fw-bold text-primary" id="dpPersenValue">20%</span>
                                <span class="badge bg-light">30%</span>
                            </div>
                            <div class="mt-2 text-center" id="dpRupiahDisplay">Rp 0</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt me-1 text-primary"></i> Tenor
                            </label>
                            <select class="form-select rounded-3" id="tenorSelect">
                                <option value="12">12 bulan (1 tahun)</option>
                                <option value="24" selected>24 bulan (2 tahun) - Populer</option>
                                <option value="36">36 bulan (3 tahun)</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-success rounded-3 p-4 mt-3">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-white-50">Pokok Pinjaman</small>
                            <div class="fw-bold text-white" id="pokokPinjaman">Rp 0</div>
                        </div>
                        <div class="col-6">
                            <small class="text-white-50">Total Bunga (8%/thn)</small>
                            <div class="fw-bold text-white" id="bungaTotal">Rp 0</div>
                        </div>
                        <div class="col-12 mt-3 pt-2 border-top border-white-30">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-white fw-semibold">Cicilan per Bulan:</span>
                                <span class="text-white fs-3 fw-bold" id="cicilanHasil">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <small class="text-muted d-block text-center mt-3">
                    <i class="fas fa-info-circle me-1"></i> Simulasi estimasi dengan bunga flat 8% per tahun
                </small>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary rounded-pill px-5" id="ajukanKreditBtn">
                    <i class="fas fa-paper-plane me-2"></i> Ajukan Kredit
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .bg-gradient-soft {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }
    .bg-soft-primary {
        background-color: rgba(102, 126, 234, 0.1);
    }
    .rounded-4 {
        border-radius: 1rem !important;
    }
    .rounded-top-4 {
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
    }
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .active-thumb {
        border: 2px solid #667eea;
        box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.3);
    }
    .thumbnail-img {
        transition: all 0.2s ease;
    }
    .thumbnail-img:hover {
        transform: scale(1.05);
    }
    .sticky-top {
        position: sticky;
        top: 90px;
    }
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        transition: all 0.3s ease;
    }
    .nav-tabs .nav-link:hover {
        background: #f8f9fa;
        color: #667eea;
    }
    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
    }
    .btn-success:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
    }
    .shadow-xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .text-primary {
        color: #667eea !important;
    }
    .table-bordered {
        border-color: #dee2e6;
    }
    .table-bordered th, .table-bordered td {
        border-color: #dee2e6;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery Thumbnail
    const thumbnails = document.querySelectorAll('.thumbnail-img');
    const mainImage = document.getElementById('mainImage');
    
    if (thumbnails.length > 0 && mainImage) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const newImageSrc = this.dataset.image;
                mainImage.src = newImageSrc;
                
                thumbnails.forEach(t => t.classList.remove('active-thumb'));
                this.classList.add('active-thumb');
            });
        });
    }
    
    // Simulasi Kredit Logic
    let selectedHarga = {{ $motor->harga_jual }};
    let selectedMotorName = '{{ $motor->nama_motor }}';
    let selectedMotorId = {{ $motor->id }};
    
    const modalMotorName = document.getElementById('modalMotorName');
    const modalHargaMotor = document.getElementById('modalHargaMotor');
    const dpRange = document.getElementById('dpRange');
    const dpPersenValue = document.getElementById('dpPersenValue');
    const dpRupiahDisplay = document.getElementById('dpRupiahDisplay');
    const tenorSelect = document.getElementById('tenorSelect');
    const pokokPinjamanSpan = document.getElementById('pokokPinjaman');
    const bungaTotalSpan = document.getElementById('bungaTotal');
    const cicilanHasilSpan = document.getElementById('cicilanHasil');
    const ajukanKreditBtn = document.getElementById('ajukanKreditBtn');
    
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
        
        dpPersenValue.innerText = dpPersen + '%';
        dpRupiahDisplay.innerText = formatRupiah(dpValue);
        pokokPinjamanSpan.innerText = formatRupiah(pokok);
        bungaTotalSpan.innerText = formatRupiah(totalBunga);
        cicilanHasilSpan.innerText = formatRupiah(cicilanPerBulan);
    }
    
    // Event listener untuk tombol quick simulasi
    document.querySelectorAll('.quick-simulasi').forEach(btn => {
        btn.addEventListener('click', function() {
            selectedHarga = parseInt(this.dataset.harga);
            selectedMotorName = this.dataset.nama;
            selectedMotorId = parseInt(this.dataset.id);
            
            modalMotorName.innerText = selectedMotorName;
            modalHargaMotor.innerText = formatRupiah(selectedHarga);
            
            dpRange.value = 20;
            tenorSelect.value = 24;
            hitungSimulasi();
        });
    });
    
    // Event listener untuk range dan select
    if (dpRange) dpRange.addEventListener('input', hitungSimulasi);
    if (tenorSelect) tenorSelect.addEventListener('change', hitungSimulasi);
    
    // Tombol Ajukan Kredit di modal - REDIRECT KE HALAMAN PENGAJUAN
    if (ajukanKreditBtn) {
        ajukanKreditBtn.addEventListener('click', function() {
            // Redirect ke halaman pengajuan dengan membawa data motor
            window.location.href = '{{ route("client.pengajuan.create") }}?motor_id=' + selectedMotorId + 
                                   '&dp=' + dpRange.value + 
                                   '&tenor=' + tenorSelect.value;
        });
    }
});
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
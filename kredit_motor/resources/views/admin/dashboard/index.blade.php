@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="row">
    <!-- Welcome Section -->
    <div class="col-12 mb-4">
        <div class="bg-white rounded-4 p-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h4 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->name }}!</h4>
                    <p class="text-muted mb-0">Kelola data motor dan pantau katalog motor Anda.</p>
                </div>
                <div class="mt-2 mt-sm-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                        <i class="fas fa-calendar-alt me-1"></i> {{ date('d F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards (Data Motor & Pelanggan) -->
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="bg-white rounded-4 p-3 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase">Total Motor</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ number_format($totalMotor ?? 0) }}</h3>
                </div>
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="fas fa-motorcycle text-primary fs-4"></i>
                </div>
            </div>
            <div class="mt-2">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i> Jenis motor {{ number_format($totalJenisMotor ?? 0) }}
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <div class="bg-white rounded-4 p-3 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase">Jenis Cicilan</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ number_format($totalJenisCicilan ?? 0) }}</h3>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="fas fa-percent text-success fs-4"></i>
                </div>
            </div>
            <div class="mt-2">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i> Tenor & bunga
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <div class="bg-white rounded-4 p-3 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase">Asuransi</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ number_format($totalAsuransi ?? 0) }}</h3>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="fas fa-shield-alt text-warning fs-4"></i>
                </div>
            </div>
            <div class="mt-2">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i> Pilihan asuransi
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <div class="bg-white rounded-4 p-3 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase">Metode Bayar</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ number_format($totalMetodeBayar ?? 0) }}</h3>
                </div>
                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                    <i class="fas fa-credit-card text-info fs-4"></i>
                </div>
            </div>
            <div class="mt-2">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i> Metode pembayaran
                </small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Daftar Motor Terbaru -->
    <div class="col-lg-7 mb-4">
        <div class="bg-white rounded-4 shadow-sm">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-motorcycle me-2 text-primary"></i> Motor Terbaru
                </h5>
                <a href="{{ route('admin.motor.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                    <i class="fas fa-plus me-1"></i> Tambah Motor
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Motor</th>
                            <th>Merk</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($motorTerbaru ?? [] as $motor)
                        <tr>
                            <td>{{ $motor->nama_motor ?? '-' }}</td>
                            <td>{{ $motor->merk ?? '-' }}</td>
                            <td>{{ $motor->jenisMotor->nama_jenis ?? '-' }}</td>
                            <td>Rp {{ number_format($motor->harga_jual ?? 0, 0, ',', '.') }}</td>
                            <td><span class="badge {{ $motor->stok > 0 ? 'bg-success' : 'bg-danger' }}">{{ $motor->stok ?? 0 }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-2"></i>
                                <p>Belum ada data motor</p>
                            </div>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Statistik Tambahan -->
    <div class="col-lg-5 mb-4">
        <div class="bg-white rounded-4 p-4 shadow-sm h-100">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-chart-pie me-2 text-primary"></i> Ringkasan Data
            </h5>
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Total Pengguna (Users)</span>
                    <span class="fw-bold">{{ number_format($totalUsers ?? 0) }}</span>
                </div>
                <div class="progress mb-3" style="height: 6px;">
                    <div class="progress-bar bg-primary" style="width: 100%;"></div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Data Motor</span>
                    <span class="fw-bold">{{ number_format($totalMotor ?? 0) }}</span>
                </div>
                <div class="progress mb-3" style="height: 6px;">
                    <div class="progress-bar bg-success" style="width: {{ min(100, ($totalMotor ?? 0) * 5) }}%;"></div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Jenis Cicilan</span>
                    <span class="fw-bold">{{ number_format($totalJenisCicilan ?? 0) }}</span>
                </div>
                <div class="progress mb-3" style="height: 6px;">
                    <div class="progress-bar bg-warning" style="width: {{ min(100, ($totalJenisCicilan ?? 0) * 10) }}%;"></div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Asuransi</span>
                    <span class="fw-bold">{{ number_format($totalAsuransi ?? 0) }}</span>
                </div>
                <div class="progress mb-3" style="height: 6px;">
                    <div class="progress-bar bg-info" style="width: {{ min(100, ($totalAsuransi ?? 0) * 20) }}%;"></div>
                </div>
            </div>
            
            <div class="alert alert-info border-0 rounded-3">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Info:</strong> Admin bertanggung jawab untuk mengelola data motor, jenis motor, jenis cicilan, asuransi, dan metode pembayaran.
            </div>
            
            <div class="d-grid gap-2 mt-3">
                <a href="{{ route('admin.motor.index') }}" class="btn btn-outline-primary rounded-pill">
                    <i class="fas fa-motorcycle me-2"></i> Kelola Data Motor
                </a>
                <a href="{{ route('admin.jenis-cicilan.index') }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="fas fa-percent me-2"></i> Kelola Jenis Cicilan
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Menu Cepat -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="bg-white rounded-4 p-4 shadow-sm">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-folder-open me-2 text-primary"></i> Menu Cepat
            </h5>
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <a href="{{ route('admin.motor.index') }}" class="text-decoration-none">
                        <div class="text-center p-3 border rounded-3 hover-shadow">
                            <i class="fas fa-motorcycle fa-2x text-primary mb-2"></i>
                            <div class="fw-semibold small">Data Motor</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('admin.jenis-motor.index') }}" class="text-decoration-none">
                        <div class="text-center p-3 border rounded-3 hover-shadow">
                            <i class="fas fa-tags fa-2x text-success mb-2"></i>
                            <div class="fw-semibold small">Jenis Motor</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('admin.jenis-cicilan.index') }}" class="text-decoration-none">
                        <div class="text-center p-3 border rounded-3 hover-shadow">
                            <i class="fas fa-percent fa-2x text-warning mb-2"></i>
                            <div class="fw-semibold small">Jenis Cicilan</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('admin.asuransi.index') }}" class="text-decoration-none">
                        <div class="text-center p-3 border rounded-3 hover-shadow">
                            <i class="fas fa-shield-alt fa-2x text-info mb-2"></i>
                            <div class="fw-semibold small">Asuransi</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: all 0.2s ease;
    }
    .hover-shadow:hover {
        background-color: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
</style>
@endsection
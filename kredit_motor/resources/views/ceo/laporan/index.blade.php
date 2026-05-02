@extends('layouts.ceo')

@section('title', 'Laporan')
@section('page-title', 'Laporan & Analitik')
@section('page-subtitle', 'Lihat dan export data laporan')

@push('styles')
<style>
    .menu-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e8ecf4;
        padding: 30px;
        text-align: center;
        transition: all 0.2s ease;
        text-decoration: none;
        display: block;
        height: 100%;
    }
    .menu-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        border-color: #6366f1;
    }
    .menu-icon {
        width: 70px;
        height: 70px;
        background: #eef2ff;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .menu-icon i {
        font-size: 32px;
        color: #6366f1;
    }
    .menu-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }
    .menu-desc {
        font-size: 13px;
        color: #64748b;
    }
</style>
@endpush

@section('content')
<div class="row g-4">
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('ceo.laporan.kredit') }}" class="menu-card">
            <div class="menu-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="menu-title">Laporan Kredit</div>
            <div class="menu-desc">Data kredit aktif, lunas, dan macet</div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('ceo.laporan.motor') }}" class="menu-card">
            <div class="menu-icon">
                <i class="fas fa-motorcycle"></i>
            </div>
            <div class="menu-title">Data Motor</div>
            <div class="menu-desc">Inventaris motor, stok, dan harga</div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('ceo.laporan.analitik') }}" class="menu-card">
            <div class="menu-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="menu-title">Analitik</div>
            <div class="menu-desc">Grafik pendapatan, status, tren</div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="menu-card" data-bs-toggle="modal" data-bs-target="#exportModal" style="cursor: pointer;">
            <div class="menu-icon">
                <i class="fas fa-download"></i>
            </div>
            <div class="menu-title">Export Data</div>
            <div class="menu-desc">Export ke CSV/Excel</div>
        </div>
    </div>
</div>

<!-- Modal Export -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exportModalLabel">Export Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ceo.laporan.export') }}" method="GET">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tipe Data</label>
                        <select name="type" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="kredit">Data Kredit</option>
                            <option value="motor">Data Motor</option>
                            <option value="angsuran">Data Angsuran</option>
                            <option value="pelanggan">Data Pelanggan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Format</label>
                        <select name="format" class="form-select">
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-download me-2"></i> Export
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.ceo')

@section('title', 'Data Motor')
@section('page-title', 'Data Motor')
@section('page-subtitle', 'Inventaris motor, stok, dan harga')

@section('content')
<!-- Statistik -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="summary-card">
            <div class="summary-value text-primary">{{ number_format($statistik['total_motor']) }}</div>
            <div class="summary-label">Total Motor</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="summary-card">
            <div class="summary-value text-success">{{ number_format($statistik['total_stok']) }}</div>
            <div class="summary-label">Total Stok</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="summary-card">
            <div class="summary-value text-warning">{{ number_format($statistik['motor_kosong']) }}</div>
            <div class="summary-label">Motor Habis</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="summary-card">
            <div class="summary-value text-info">{{ $statistik['motor_terlaris']->nama_motor ?? '-' }}</div>
            <div class="summary-label">Motor Terlaris</div>
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Daftar Motor</h5>
        <a href="{{ route('ceo.motor.export') }}" class="btn btn-sm btn-outline-primary rounded-pill">
            <i class="fas fa-download me-1"></i> Export CSV
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th><a href="?sort_by=nama_motor&sort_order={{ request('sort_order') == 'asc' ? 'desc' : 'asc' }}">Nama Motor</a></th>
                        <th>Merk</th>
                        <th>Jenis</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($motor as $item)
                    <tr>
                        <td>{{ $item->nama_motor }}</div>
                        <td>{{ $item->merk }}</div>
                        <td>{{ $item->jenisMotor->nama_jenis ?? '-' }}</div>
                        <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</div>
                        <td>
                            @if($item->stok <= 0)
                                <span class="badge bg-danger">Habis</span>
                            @elseif($item->stok <= 3)
                                <span class="badge bg-warning">Stok {{ $item->stok }}</span>
                            @else
                                <span class="badge bg-success">Stok {{ $item->stok }}</span>
                            @endif
                         </div>
                     </div>
                    @empty
                    <tr class="text-center py-4">
                        <td colspan="5">Belum ada data motor</div>
                    </td>
                    @endforelse
                </tbody>
             </div>
        </div>
    </div>
    <div class="card-footer bg-white border-0 p-4">
        {{ $motor->appends(request()->query())->links() }}
    </div>
</div>

<style>
    .summary-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e8ecf4;
        padding: 20px;
        text-align: center;
    }
    .summary-value {
        font-size: 28px;
        font-weight: 800;
    }
</style>
@endsection
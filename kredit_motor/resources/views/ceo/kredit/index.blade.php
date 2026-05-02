@extends('layouts.ceo')

@section('title', 'Laporan Kredit')
@section('page-title', 'Laporan Kredit')
@section('page-subtitle', 'Data kredit aktif, lunas, dan macet')

@push('styles')
<style>
    .filter-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e8ecf4;
        padding: 20px;
        margin-bottom: 24px;
    }
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
        color: #0f172a;
    }
    .summary-label {
        font-size: 12px;
        color: #64748b;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')
<!-- Filter -->
<div class="filter-card">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-semibold small">Dari Tanggal</label>
            <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold small">Sampai Tanggal</label>
            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100 rounded-pill">
                <i class="fas fa-filter me-2"></i> Filter
            </button>
        </div>
    </form>
</div>

<!-- Ringkasan -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="summary-card">
            <div class="summary-value">{{ number_format($ringkasan['total_kredit']) }}</div>
            <div class="summary-label">Total Kredit</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="summary-card">
            <div class="summary-value">{{ number_format($ringkasan['aktif']) }}</div>
            <div class="summary-label">Aktif</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="summary-card">
            <div class="summary-value">{{ number_format($ringkasan['lunas']) }}</div>
            <div class="summary-label">Lunas</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="summary-card">
            <div class="summary-value">{{ number_format($ringkasan['macet']) }}</div>
            <div class="summary-label">Macet</div>
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Data Kredit</h5>
        <a href="{{ route('ceo.kredit.export', request()->query()) }}" class="btn btn-sm btn-outline-primary rounded-pill">
            <i class="fas fa-download me-1"></i> Export CSV
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Motor</th>
                        <th>Tgl Mulai</th>
                        <th>Sisa Kredit</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kredit as $item)
                    <tr>
                        <td>#{{ $item->id }}</div>
                        <td>{{ $item->pengajuanKredit->pelanggan->nama_pelanggan ?? '-' }}</div>
                        <td>{{ $item->pengajuanKredit->motor->nama_motor ?? '-' }}</div>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_mulai_kredit)->format('d/m/Y') }}</div>
                        <td>Rp {{ number_format($item->sisa_kredit, 0, ',', '.') }}</div>
                        <td>
                            @if($item->status_kredit == 'Dicicil')
                                <span class="badge bg-primary">Aktif</span>
                            @elseif($item->status_kredit == 'Lunas')
                                <span class="badge bg-success">Lunas</span>
                            @else
                                <span class="badge bg-danger">Macet</span>
                            @endif
                         </div>
                     </div>
                    @empty
                    <tr class="text-center py-4">
                        <td colspan="6">Belum ada data kredit</div>
                    </tr>
                    @endforelse
                </tbody>
             </div>
        </div>
    </div>
    <div class="card-footer bg-white border-0 p-4">
        {{ $kredit->appends(request()->query())->links() }}
    </div>
</div>
@endsection
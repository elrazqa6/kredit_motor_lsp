@extends('layouts.client')

@section('title', 'Pengiriman Saya')
@section('page-title', 'Riwayat Pengiriman')

@section('content')
<div class="container px-0">
    
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-truck text-primary me-2"></i> Pengiriman Saya
            </h4>
            <p class="text-muted mb-0">Lacak status pengiriman motor Anda</p>
        </div>
    </div>
    
    <!-- Daftar Pengiriman -->
    <div class="row g-4">
        @forelse($pengiriman as $item)
        @php
            $motor = $item->kredit->pengajuanKredit->motor->nama_motor ?? '-';
            $statusClass = '';
            $statusIcon = '';
            if ($item->status == 'Diproses') {
                $statusClass = 'warning';
                $statusIcon = 'fa-clock';
                $statusText = 'Sedang Diproses';
            } elseif ($item->status == 'Dikirim') {
                $statusClass = 'primary';
                $statusIcon = 'fa-truck';
                $statusText = 'Dalam Perjalanan';
            } elseif ($item->status == 'Selesai') {
                $statusClass = 'success';
                $statusIcon = 'fa-check-circle';
                $statusText = 'Telah Diterima';
            } else {
                $statusClass = 'danger';
                $statusIcon = 'fa-times-circle';
                $statusText = 'Dibatalkan';
            }
        @endphp
        
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} px-3 py-2">
                                <i class="fas {{ $statusIcon }} me-1"></i> {{ $statusText }}
                            </span>
                        </div>
                        <small class="text-muted">{{ $item->no_resi }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="fw-bold fs-5">{{ $motor }}</div>
                        <div class="text-muted small">Kurir: {{ $item->kurir ?? 'Belum ditentukan' }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Progress</small>
                            @if($item->status == 'Diproses')
                                <small class="text-warning">Persiapan</small>
                            @elseif($item->status == 'Dikirim')
                                <small class="text-primary">Diperjalanan</small>
                            @elseif($item->status == 'Selesai')
                                <small class="text-success">Selesai</small>
                            @endif
                        </div>
                        <div class="progress" style="height: 8px;">
                            @php
                                $progress = 0;
                                if ($item->status == 'Diproses') $progress = 25;
                                elseif ($item->status == 'Dikirim') $progress = 75;
                                elseif ($item->status == 'Selesai') $progress = 100;
                            @endphp
                            <div class="progress-bar bg-{{ $statusClass }}" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="info-label">Tanggal Kirim</div>
                            <div class="info-value small">{{ $item->tgl_pengiriman ? \Carbon\Carbon::parse($item->tgl_pengiriman)->format('d/m/Y') : '-' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="info-label">Estimasi Sampai</div>
                            <div class="info-value small">{{ $item->tgl_estimasi_sampai ? \Carbon\Carbon::parse($item->tgl_estimasi_sampai)->format('d/m/Y') : '-' }}</div>
                        </div>
                    </div>
                    
                    <a href="{{ route('client.pengiriman.show', $item->id) }}" class="btn btn-outline-primary rounded-pill w-100">
                        <i class="fas fa-map-marker-alt me-2"></i> Lacak Pengiriman
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                <div class="card-body">
                    <i class="fas fa-truck fa-4x text-muted mb-3"></i>
                    <h5 class="fw-bold mb-2">Belum Ada Pengiriman</h5>
                    <p class="text-muted">Pengiriman akan muncul setelah DP lunas dan admin membuat pengiriman.</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    
    @if($pengiriman->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $pengiriman->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

<style>
    .info-label {
        font-size: 10px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    .info-value {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }
    .progress {
        background: #e2e8f0;
        border-radius: 10px;
    }
</style>
@endsection
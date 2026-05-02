@extends('layouts.ceo')

@section('title', 'Analitik')
@section('page-title', 'Analitik & Grafik')
@section('page-subtitle', 'Visualisasi data bisnis')

@push('styles')
<style>
    .analitik-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e8ecf4;
        padding: 20px;
        height: 100%;
    }
</style>
@endpush

@section('content')
<!-- Filter -->
<div class="filter-card mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-semibold small">Tahun</label>
            <select name="tahun" class="form-select">
                @for($i = date('Y'); $i >= date('Y')-3; $i--)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary rounded-pill px-4">Tampilkan</button>
        </div>
    </form>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="analitik-card">
            <h6 class="fw-bold mb-3">Pendapatan Angsuran per Bulan</h6>
            <canvas id="revenueChart" height="280"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="analitik-card">
            <h6 class="fw-bold mb-3">Status Pengajuan</h6>
            <canvas id="pengajuanChart" height="200"></canvas>
            <div class="mt-3">
                @foreach($statusPengajuan as $key => $value)
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ $key }}</span>
                    <span class="fw-bold">{{ number_format($value) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="analitik-card">
            <h6 class="fw-bold mb-3">Status Kredit</h6>
            <canvas id="kreditChart" height="200"></canvas>
            <div class="mt-3">
                @foreach($statusKredit as $key => $value)
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ $key }}</span>
                    <span class="fw-bold">{{ number_format($value) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="analitik-card">
            <h6 class="fw-bold mb-3">Top 10 Motor Terlaris</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Nama Motor</th>
                            <th>Merk</th>
                            <th class="text-end">Pengajuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($motorTerlaris as $index => $motor)
                        <tr>
                            <td>{{ $index + 1 }}</div>
                            <td>{{ $motor->nama_motor }}</div>
                            <td>{{ $motor->merk }}</div>
                            <td class="text-end fw-bold text-primary">{{ $motor->pengajuan_kredit_count ?? 0 }}</div>
                         </div>
                        @endforeach
                    </tbody>
                 </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="analitik-card">
            <h6 class="fw-bold mb-3">Pertumbuhan Pelanggan per Bulan</h6>
            <canvas id="pelangganChart" height="200"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('revenueChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($bulanLabels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($pendapatanData) !!},
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.07)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return 'Rp ' + ctx.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000).toFixed(0) + 'jt';
                        }
                    }
                }
            }
        }
    });
    
    new Chart(document.getElementById('pengajuanChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Disetujui', 'Ditolak'],
            datasets: [{
                data: [{{ $statusPengajuan['Menunggu'] }}, {{ $statusPengajuan['Disetujui'] }}, {{ $statusPengajuan['Ditolak'] }}],
                backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: { cutout: '60%' }
    });
    
    new Chart(document.getElementById('kreditChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Lunas', 'Macet'],
            datasets: [{
                data: [{{ $statusKredit['Aktif'] }}, {{ $statusKredit['Lunas'] }}, {{ $statusKredit['Macet'] }}],
                backgroundColor: ['#3b82f6', '#10b981', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: { cutout: '60%' }
    });
    
    new Chart(document.getElementById('pelangganChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulanLabels) !!},
            datasets: [{
                label: 'Pelanggan Baru',
                data: {!! json_encode($pelangganData) !!},
                backgroundColor: '#6366f1',
                borderRadius: 8
            }]
        },
        options: { responsive: true, maintainAspectRatio: true }
    });
});
</script>
@endsection
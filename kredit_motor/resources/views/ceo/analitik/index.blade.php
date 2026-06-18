@extends('layouts.ceo')

@section('title', 'Analitik')
@section('page-title', 'Analitik & Grafik')
@section('page-subtitle', 'Visualisasi data bisnis')
@push('styles')
<style>
    .analitik-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #e8ecf4;
        padding: 24px;
        height: 100%;
        box-shadow: 0 4px 20px rgba(0,0,0,.04);
        transition: .2s;
    }

    .analitik-card:hover {
        transform: translateY(-2px);
    }

    .filter-card {
        background: white;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid #e8ecf4;
        box-shadow: 0 4px 20px rgba(0,0,0,.04);
    }

    .stat-card {
        background: white;
        border-radius: 18px;
        padding: 20px;
        border: 1px solid #e8ecf4;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,.04);
    }

    .stat-card h3 {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .table th {
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<!-- Filter -->
<div class="filter-card mb-4">
    <form method="GET">
        <div class="row g-3 align-items-end">

            <div class="col-lg-3">
                <label class="form-label fw-semibold">Periode Cepat</label>
                <select name="filter" class="form-select">
                    <option value="">Semua Data</option>
                    <option value="hari_ini" {{ request('filter') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="minggu_ini" {{ request('filter') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="bulan_ini" {{ request('filter') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="tahun_ini" {{ request('filter') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                    <option value="custom" {{ request('filter') == 'custom' ? 'selected' : '' }}>Custom Tanggal</option>
                </select>
            </div>

            <div class="col-lg-3">
                <label class="form-label fw-semibold">Tanggal Mulai</label>
                <input type="date"
                    name="tanggal_mulai"
                    class="form-control"
                    value="{{ request('tanggal_mulai') }}">
            </div>

            <div class="col-lg-3">
                <label class="form-label fw-semibold">Tanggal Selesai</label>
                <input type="date"
                    name="tanggal_selesai"
                    class="form-control"
                    value="{{ request('tanggal_selesai') }}">
            </div>

            <div class="col-lg-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-2"></i>Tampilkan
                </button>
            </div>

        </div>
    </form>
</div>

</form>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="analitik-card">
            <h6 class="fw-bold mb-3">Tren Pengajuan & Persetujuan Kredit</h6>
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
        datasets: [
            {
                label: 'Pengajuan Kredit',
                data: {!! json_encode($pengajuanData) !!},
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.1)',
                borderWidth: 3,
                tension: 0.4
            },
            {
                label: 'Disetujui',
                data: {!! json_encode($disetujuiData) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16,185,129,0.1)',
                borderWidth: 3,
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        interaction: {
            mode: 'index',
            intersect: false
        },
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
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
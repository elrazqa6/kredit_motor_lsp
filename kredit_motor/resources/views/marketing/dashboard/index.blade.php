@extends('layouts.marketing')

@section('title', 'Dashboard Marketing')
@section('page-title', 'Dashboard Marketing')

@push('styles')
<style>
    .stat-card {
        background: #fff;
        border-radius: 20px;
        border: none;
        padding: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1;
    }
    .stat-label {
        font-size: 13px;
        color: #64748b;
        margin-top: 5px;
    }
    .chart-card {
        background: #fff;
        border-radius: 20px;
        border: none;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        height: 100%;
    }
    .badge-warning { background: #fef3c7; color: #d97706; }
    .badge-success { background: #d1fae5; color: #059669; }
    .badge-danger { background: #fee2e2; color: #dc2626; }
    .badge-info { background: #dbeafe; color: #2563eb; }
    .avatar-sm {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    
    <!-- Welcome Section -->
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->name }}! 👋</h4>
        <p class="text-muted">Berikut ringkasan aktivitas marketing hari ini.</p>
    </div>

    <!-- Stat Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ number_format($totalPengajuan) }}</div>
                        <div class="stat-label">Total Pengajuan</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10">
                        <i class="fas fa-file-invoice fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="mt-3 d-flex gap-2">
                    <small class="text-success"><i class="fas fa-check-circle"></i> {{ number_format($pengajuanDisetujui) }} Disetujui</small>
                    <small class="text-danger"><i class="fas fa-times-circle"></i> {{ number_format($pengajuanDitolak) }} Ditolak</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value text-warning">{{ number_format($pengajuanMenunggu) }}</div>
                        <div class="stat-label">Perlu Ditindaklanjuti</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">Menunggu verifikasi marketing</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ number_format($kreditAktif) }}</div>
                        <div class="stat-label">Kredit Aktif</div>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10">
                        <i class="fas fa-credit-card fa-2x text-success"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-success">Lunas: {{ number_format($kreditLunas) }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value fs-4">Rp {{ number_format($totalAngsuranMasuk / 1000000, 1) }} jt</div>
                        <div class="stat-label">Angsuran Masuk</div>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10">
                        <i class="fas fa-money-bill-wave fa-2x text-info"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">Total pembayaran angsuran</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold mb-0">📊 Pendapatan Angsuran</h6>
                        <small class="text-muted">Tahun {{ date('Y') }}</small>
                    </div>
                </div>
                <canvas id="angsuranChart" height="280"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="chart-card">
                <h6 class="fw-bold mb-3">📋 Status Pengajuan</h6>
                <canvas id="statusChart" height="200"></canvas>
                <div class="mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="fas fa-circle text-warning me-2"></i> Menunggu</span>
                        <span class="fw-bold">{{ number_format($pengajuanMenunggu) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="fas fa-circle text-success me-2"></i> Disetujui</span>
                        <span class="fw-bold">{{ number_format($pengajuanDisetujui) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><i class="fas fa-circle text-danger me-2"></i> Ditolak</span>
                        <span class="fw-bold">{{ number_format($pengajuanDitolak) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Pengajuan Terbaru & Angsuran Terlambat -->
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-file-invoice me-2 text-primary"></i> Pengajuan Terbaru
                        </h6>
                        <a href="{{ route('marketing.pengajuan.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            Lihat Semua →
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Pelanggan</th>
                                    <th>Motor</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuanTerbaru as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-sm bg-primary bg-opacity-10 text-primary">
                                                {{ strtoupper(substr($item->pelanggan->nama_pelanggan ?? 'U', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold small">{{ $item->pelanggan->nama_pelanggan ?? '-' }}</div>
                                                <small class="text-muted">{{ $item->pelanggan->no_telp ?? '-' }}</small>
                                            </div>
                                        </div>
                                     </div>
                                    <td>{{ $item->motor->nama_motor ?? '-' }} </div>
                                    <td>{{ \Carbon\Carbon::parse($item->tgl_pengajuan_kredit)->format('d/m/Y') }} </div>
                                    <td>
                                        @if($item->status_pengajuan == 'Menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($item->status_pengajuan == 'Disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                     </div>
                                    <td>
                                        <a href="{{ route('marketing.pengajuan.show', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                     </div>
                                 </div>
                                @empty
                                 <tr class="text-center py-4">
                                    <td colspan="5">Belum ada pengajuan</div>
                                 </div>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-exclamation-triangle me-2 text-danger"></i> Angsuran Terlambat
                        </h6>
                        <a href="{{ route('marketing.angsuran.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            Lihat Semua →
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Pelanggan</th>
                                    <th>Motor</th>
                                    <th>Angsuran Ke</th>
                                    <th>Jatuh Tempo</th>
                                 </tr>
                            </thead>
                            <tbody>
                                @forelse($angsuranTerlambat as $item)
                                 <tr>
                                     <td>
                                        <div class="fw-semibold small">{{ $item->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '-' }}</div>
                                        <small class="text-muted">{{ $item->kredit->pengajuanKredit->pelanggan->no_telp ?? '-' }}</small>
                                     </div>
                                     <td>{{ $item->kredit->pengajuanKredit->motor->nama_motor ?? '-' }}</div>
                                     <td>{{ $item->angsuran_ke }}</div>
                                     <td>
                                        <span class="text-danger fw-semibold">
                                            {{ \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d/m/Y') }}
                                        </span>
                                        <br>
                                        <small class="text-danger">
                                            Terlambat {{ \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->diffInDays(now()) }} hari
                                        </small>
                                     </div>
                                 </div>
                                @empty
                                 <tr class="text-center py-4">
                                    <td colspan="4">Tidak ada angsuran terlambat</div>
                                 </div>
                                @endforelse
                            </tbody>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Angsuran
    const ctx1 = document.getElementById('angsuranChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: {!! json_encode($bulanLabels) !!},
            datasets: [{
                label: 'Pendapatan Angsuran (Rp)',
                data: {!! json_encode($angsuranData) !!},
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.05)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000).toFixed(0) + ' jt';
                        }
                    }
                }
            }
        }
    });
    
    // Chart Status
    const ctx2 = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Disetujui', 'Ditolak'],
            datasets: [{
                data: [
                    {{ $pengajuanMenunggu }},
                    {{ $pengajuanDisetujui }},
                    {{ $pengajuanDitolak }}
                ],
                backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});
</script>
@endsection
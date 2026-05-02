@extends('layouts.ceo')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')
@section('page-subtitle', 'Ringkasan performa bisnis kredit motor')

@push('styles')
<style>
    /* ─── Stat Cards ─── */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 18px 20px;
        border: 1px solid #e8ecf4;
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: box-shadow 0.2s ease;
    }

    .stat-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    }

    .sc-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sc-icon i {
        font-size: 17px;
    }

    .sc-value {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        margin-top: 10px;
    }

    .sc-value.medium {
        font-size: 20px;
    }

    .sc-label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sc-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 6px;
    }

    .sc-badge.up {
        background: #f0fdf4;
        color: #16a34a;
    }

    .sc-badge.neutral {
        background: #fef3c7;
        color: #d97706;
    }

    .sc-sub {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .sc-sub-item {
        font-size: 11px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .sc-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    /* ─── Chart Card ─── */
    .chart-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e8ecf4;
        height: 100%;
    }

    .chart-card-title {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .chart-card-sub {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 2px;
    }

    /* ─── Motor List ─── */
    .moto-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .moto-item:last-child {
        border-bottom: none;
    }

    .moto-rank {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        flex-shrink: 0;
    }

    .moto-rank.rank-1 { background: #fef9ee; color: #d97706; }
    .moto-rank.rank-2 { background: #f8fafc; color: #64748b; }
    .moto-rank.rank-3 { background: #fff7ed; color: #c2410c; }

    .moto-name {
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
    }

    .moto-brand {
        font-size: 11px;
        color: #94a3b8;
    }

    .moto-bar-wrap {
        width: 60px;
        height: 5px;
        background: #f1f5f9;
        border-radius: 3px;
        margin-top: 4px;
    }

    .moto-bar {
        height: 5px;
        border-radius: 3px;
    }

    .moto-count {
        font-size: 13px;
        font-weight: 700;
        color: #6366f1;
        white-space: nowrap;
    }

    /* ─── Table Card ─── */
    .table-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e8ecf4;
        overflow: hidden;
    }

    .table-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-card-header h6 {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .view-all-link {
        font-size: 12px;
        font-weight: 600;
        color: #6366f1;
        text-decoration: none;
    }

    .view-all-link:hover {
        color: #4f46e5;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead th {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 20px;
        background: #f8fafc;
        text-align: left;
        border: none;
    }

    .data-table tbody td {
        padding: 12px 20px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr:hover td {
        background: #fafbff;
    }

    .td-name {
        font-weight: 600;
        color: #0f172a;
    }

    .td-id {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 1px;
    }

    .status-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 6px;
    }

    .status-badge.menunggu  { background: #fef9c3; color: #a16207; }
    .status-badge.disetujui { background: #f0fdf4; color: #16a34a; }
    .status-badge.ditolak   { background: #fef2f2; color: #dc2626; }
</style>
@endpush

@section('content')

    {{-- Baris 1: Stat Cards Utama --}}
    <div class="row g-3 mb-3">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="sc-icon" style="background:#eef2ff;">
                        <i class="fas fa-users" style="color:#6366f1;"></i>
                    </div>
                    <span class="sc-badge up">+12%</span>
                </div>
                <div class="sc-value">{{ number_format($totalUser) }}</div>
                <div class="sc-label">Total User</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="sc-icon" style="background:#f0fdf4;">
                        <i class="fas fa-user-check" style="color:#22c55e;"></i>
                    </div>
                    <span class="sc-badge up">+8%</span>
                </div>
                <div class="sc-value">{{ number_format($totalPelanggan) }}</div>
                <div class="sc-label">Total Pelanggan</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="sc-icon" style="background:#fffbeb;">
                        <i class="fas fa-motorcycle" style="color:#f59e0b;"></i>
                    </div>
                    <span class="sc-badge neutral">+3%</span>
                </div>
                <div class="sc-value">{{ number_format($totalMotor) }}</div>
                <div class="sc-label">Total Unit Motor</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="sc-icon" style="background:#ecfeff;">
                        <i class="fas fa-money-bill-wave" style="color:#06b6d4;"></i>
                    </div>
                    <span class="sc-badge up">+21%</span>
                </div>
                <div class="sc-value medium">
                    Rp {{ number_format($totalPendapatan / 1000000, 1) }} jt
                </div>
                <div class="sc-label">Total Pendapatan</div>
            </div>
        </div>
    </div>

    {{-- Baris 2: Stat Cards Sekunder --}}
    <div class="row g-3 mb-3">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="sc-label" style="margin-top:2px;">Total Pengajuan</div>
                    <div class="sc-icon" style="background:#f5f3ff; width:36px; height:36px;">
                        <i class="fas fa-file-invoice" style="color:#7c3aed; font-size:14px;"></i>
                    </div>
                </div>
                <div class="sc-value">{{ number_format($totalPengajuan) }}</div>
                <div class="sc-sub">
                    <span class="sc-sub-item">
                        <span class="sc-dot" style="background:#22c55e;"></span>
                        <span style="color:#16a34a;">{{ number_format($pengajuanDisetujui) }} disetujui</span>
                    </span>
                    <span class="sc-sub-item">
                        <span class="sc-dot" style="background:#ef4444;"></span>
                        <span style="color:#dc2626;">{{ number_format($pengajuanDitolak) }} ditolak</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="sc-label" style="margin-top:2px;">Kredit Aktif</div>
                    <div class="sc-icon" style="background:#eff6ff; width:36px; height:36px;">
                        <i class="fas fa-credit-card" style="color:#2563eb; font-size:14px;"></i>
                    </div>
                </div>
                <div class="sc-value">{{ number_format($kreditAktif) }}</div>
                <div class="sc-sub">
                    <span class="sc-sub-item">
                        <span class="sc-dot" style="background:#22c55e;"></span>
                        <span style="color:#16a34a;">{{ number_format($kreditLunas) }} lunas</span>
                    </span>
                    <span class="sc-sub-item">
                        <span class="sc-dot" style="background:#ef4444;"></span>
                        <span style="color:#dc2626;">{{ number_format($kreditMacet) }} macet</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="sc-label" style="margin-top:2px;">Menunggu Review</div>
                    <div class="sc-icon" style="background:#fffbeb; width:36px; height:36px;">
                        <i class="fas fa-clock" style="color:#d97706; font-size:14px;"></i>
                    </div>
                </div>
                <div class="sc-value" style="color:#d97706;">{{ number_format($pengajuanMenunggu) }}</div>
                <div class="sc-sub">
                    <span class="sc-sub-item" style="color:#94a3b8;">Perlu tindakan segera</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="sc-label" style="margin-top:2px;">Rata-rata Angsuran</div>
                    <div class="sc-icon" style="background:#f0fdf4; width:36px; height:36px;">
                        <i class="fas fa-chart-line" style="color:#16a34a; font-size:14px;"></i>
                    </div>
                </div>
                <div class="sc-value medium">
                    Rp {{ ($totalPendapatan > 0 && $kreditAktif > 0) ? number_format($totalPendapatan / $kreditAktif, 0, ',', '.') : '0' }}
                </div>
                <div class="sc-sub">
                    <span class="sc-sub-item" style="color:#94a3b8;">Per kontrak aktif</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart + Motor Terlaris --}}
    <div class="row g-3 mb-3">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="chart-card-title">Pendapatan Angsuran</p>
                        <p class="chart-card-sub">Tren bulanan tahun {{ date('Y') }}</p>
                    </div>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm"
                            style="font-size:11px;font-weight:600;padding:5px 10px;background:#6366f1;color:white;border:none;border-radius:6px;">
                            Bulanan
                        </button>
                        <button class="btn btn-sm"
                            style="font-size:11px;font-weight:600;padding:5px 10px;background:#f1f5f9;color:#64748b;border:none;border-radius:6px;">
                            Kuartal
                        </button>
                    </div>
                </div>
                <canvas id="revenueChart" height="220"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="chart-card">
                <p class="chart-card-title mb-1">Motor Terlaris</p>
                <p class="chart-card-sub mb-3">Berdasarkan jumlah pengajuan</p>

                @php
                    $barColors = [
                        ['bar' => 'linear-gradient(90deg,#6366f1,#8b5cf6)', 'count' => '#6366f1'],
                        ['bar' => 'linear-gradient(90deg,#8b5cf6,#a78bfa)', 'count' => '#8b5cf6'],
                        ['bar' => 'linear-gradient(90deg,#f59e0b,#fbbf24)', 'count' => '#d97706'],
                        ['bar' => 'linear-gradient(90deg,#06b6d4,#22d3ee)',  'count' => '#0891b2'],
                        ['bar' => 'linear-gradient(90deg,#10b981,#34d399)',  'count' => '#059669'],
                    ];
                    $maxCount = $motorTerlaris->first()->pengajuan_kredit_count ?? 1;
                @endphp

                <div>
                    @foreach($motorTerlaris as $index => $motor)
                        @php
                            $rankClass = match($index) { 0 => 'rank-1', 1 => 'rank-2', 2 => 'rank-3', default => '' };
                            $pct = $maxCount > 0 ? round(($motor->pengajuan_kredit_count / $maxCount) * 100) : 0;
                            $color = $barColors[$index] ?? end($barColors);
                        @endphp
                        <div class="moto-item">
                            <div class="moto-rank {{ $rankClass }}">{{ $index + 1 }}</div>
                            <div style="flex:1;">
                                <div class="moto-name">{{ $motor->nama_motor ?? '-' }}</div>
                                <div class="moto-brand">{{ $motor->merk ?? '-' }}</div>
                                <div class="moto-bar-wrap">
                                    <div class="moto-bar"
                                        style="width:{{ $pct }}%; background: {{ $color['bar'] }};"></div>
                                </div>
                            </div>
                            <div class="moto-count" style="color:{{ $color['count'] }};">
                                {{ $motor->pengajuan_kredit_count ?? 0 }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Pengajuan Terbaru --}}
    <div class="table-card">
        <div class="table-card-header">
            <h6>Pengajuan Kredit Terbaru</h6>
            <a href="#" class="view-all-link">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Motor</th>
                        <th>Uang Muka</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuanTerbaru as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_pengajuan_kredit)->format('d M Y') }}</td>
                            <td>
                                <div class="td-name">{{ $item->pelanggan->nama_pelanggan ?? '-' }}</div>
                                <div class="td-id">ID #{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td>{{ $item->motor->nama_motor ?? '-' }}</td>
                            <td>Rp {{ number_format($item->uang_muka ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $statusClass = match($item->status_pengajuan) {
                                        'Disetujui' => 'disetujui',
                                        'Ditolak'   => 'ditolak',
                                        default     => 'menunggu',
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $item->status_pengajuan }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4" style="color:#94a3b8; font-size:13px;">
                                Belum ada data pengajuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('revenueChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($bulanLabels) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode($pendapatanData) !!},
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.07)',
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (ctx) {
                            return 'Rp ' + ctx.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 }, color: '#94a3b8' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { size: 11 },
                        color: '#94a3b8',
                        callback: function (value) {
                            return 'Rp ' + (value / 1000000).toFixed(0) + ' jt';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
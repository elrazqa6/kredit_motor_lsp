@extends('layouts.marketing')

@section('title', 'Detail Kredit')
@section('page-title', 'Detail Data Kredit')

@push('styles')
<style>
    .info-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        margin-bottom: 20px;
    }
    .info-label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }
    .status-badge {
        display: inline-flex;
        padding: 5px 12px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
    }
    .badge-success { background: #d1fae5; color: #059669; }
    .badge-warning { background: #fef3c7; color: #d97706; }
    .badge-danger { background: #fee2e2; color: #dc2626; }
    .badge-info { background: #dbeafe; color: #2563eb; }
    .progress {
        height: 8px;
        border-radius: 10px;
    }
    .timeline-item {
        position: relative;
        padding-left: 25px;
        margin-bottom: 20px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #667eea;
    }
    .timeline-item::after {
        content: '';
        position: absolute;
        left: 5px;
        top: 17px;
        width: 2px;
        height: calc(100% - 12px);
        background: #e2e8f0;
    }
    .timeline-item:last-child::after {
        display: none;
    }
    .bg-soft-primary {
        background: rgba(102, 126, 234, 0.1);
    }
    .table-angsuran th {
        font-size: 11px;
        font-weight: 600;
        background: #f8fafc;
    }
    .table-angsuran td {
        font-size: 12px;
        padding: 10px 12px;
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-lg-8">
        <!-- Informasi Kredit -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-credit-card text-primary me-2"></i> Informasi Kredit
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-label">ID Kredit</div>
                    <div class="info-value">#{{ $kredit->id }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Status Kredit</div>
                    <div class="info-value">
                        <span class="status-badge {{ $kredit->status_kredit == 'aktif' ? 'badge-success' : ($kredit->status_kredit == 'lunas' ? 'badge-info' : 'badge-danger') }}">
                            {{ ucfirst($kredit->status_kredit) }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Tanggal Mulai</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($kredit->tgl_mulai_kredit)->format('d F Y') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Tanggal Selesai</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($kredit->tgl_selesai_kredit)->format('d F Y') }}</div>
                </div>
                <div class="col-md-12">
                    <div class="info-label">Metode Pembayaran</div>
                    <div class="info-value">{{ $kredit->metodeBayar->nama_metode ?? '-' }} - {{ $kredit->metodeBayar->nama_bank ?? '' }}</div>
                </div>
                @if($kredit->keterangan_status_kredit)
                <div class="col-12">
                    <div class="info-label">Keterangan</div>
                    <div class="info-value">{{ $kredit->keterangan_status_kredit }}</div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Informasi Pengajuan -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-file-invoice text-primary me-2"></i> Informasi Pengajuan
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-label">No. Pengajuan</div>
                    <div class="info-value">#{{ $kredit->pengajuanKredit->id }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Status Pengajuan</div>
                    <div class="info-value">{{ $kredit->pengajuanKredit->status_pengajuan }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Tanggal Pengajuan</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($kredit->pengajuanKredit->tgl_pengajuan_kredit)->format('d F Y') }}</div>
                </div>
            </div>
        </div>
        
        <!-- Informasi Pelanggan & Motor -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-user-circle text-primary me-2"></i> Informasi Pelanggan & Motor
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-label">Nama Pelanggan</div>
                    <div class="info-value">{{ $kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">{{ $kredit->pengajuanKredit->pelanggan->no_telp ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Motor</div>
                    <div class="info-value">{{ $kredit->pengajuanKredit->motor->nama_motor ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Merk</div>
                    <div class="info-value">{{ $kredit->pengajuanKredit->motor->merk ?? '-' }}</div>
                </div>
                <div class="col-md-12">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ $kredit->pengajuanKredit->pelanggan->alamat ?? '-' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Detail Keuangan -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-chart-line text-primary me-2"></i> Detail Keuangan
            </h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="info-label">Harga Cash</div>
                    <div class="info-value">Rp {{ number_format($kredit->pengajuanKredit->harga_cash, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">DP</div>
                    <div class="info-value">{{ number_format($kredit->pengajuanKredit->dp, 2) }}%</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Uang Muka</div>
                    <div class="info-value">Rp {{ number_format($kredit->pengajuanKredit->uang_muka, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Tenor</div>
                    <div class="info-value">{{ $kredit->pengajuanKredit->tenor }} bulan</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Cicilan per Bulan</div>
                    <div class="info-value text-success fw-bold">Rp {{ number_format($kredit->pengajuanKredit->cicilan_perbulan, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Total Kredit</div>
                    <div class="info-value">Rp {{ number_format($kredit->pengajuanKredit->harga_kredit, 0, ',', '.') }}</div>
                </div>
            </div>
            
            @php
                $totalKredit = $kredit->pengajuanKredit->harga_kredit;
                $sisaKredit = $kredit->sisa_kredit;
                $progress = $totalKredit > 0 ? (($totalKredit - $sisaKredit) / $totalKredit) * 100 : 0;
            @endphp
            <div class="mt-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="small">Progress Pembayaran</span>
                    <span class="small fw-bold">{{ number_format($progress, 1) }}%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span class="small text-muted">Sisa Kredit: Rp {{ number_format($sisaKredit, 0, ',', '.') }}</span>
                    <span class="small text-muted">Total Dibayar: Rp {{ number_format($totalKredit - $sisaKredit, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Riwayat Angsuran -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-history text-primary me-2"></i> Riwayat Angsuran
            </h5>
            <div class="table-responsive">
                <table class="table table-bordered table-angsuran">
                    <thead>
                        <tr>
                            <th>Angsuran Ke</th>
                            <th>Jumlah</th>
                            <th>Jatuh Tempo</th>
                            <th>Tgl Bayar</th>
                            <th>Status</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kredit->angsuran as $angsuran)
                        <tr>
                            <td>{{ $angsuran->angsuran_ke }}</td>
                            <td>Rp {{ number_format($angsuran->jumlah_angsuran, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($angsuran->tanggal_jatuh_tempo)->format('d/m/Y') }}</td>
                            <td>{{ $angsuran->tanggal_bayar ? \Carbon\Carbon::parse($angsuran->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($angsuran->status == 'Lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @elseif($angsuran->status == 'Telat')
                                    <span class="badge bg-danger">Telat</span>
                                @else
                                    <span class="badge bg-warning">Belum Bayar</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($angsuran->denda, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-receipt fa-2x text-muted mb-2"></i>
                                    <p class="mb-0">Belum ada data angsuran</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Timeline -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-timeline text-primary me-2"></i> Timeline Kredit
            </h5>
            <div class="timeline-item">
                <div class="fw-semibold">Pengajuan Disetujui</div>
                <small class="text-muted">{{ \Carbon\Carbon::parse($kredit->pengajuanKredit->updated_at)->format('d F Y H:i') }}</small>
            </div>
            <div class="timeline-item">
                <div class="fw-semibold">Kredit Dimulai</div>
                <small class="text-muted">{{ \Carbon\Carbon::parse($kredit->tgl_mulai_kredit)->format('d F Y') }}</small>
            </div>
            <div class="timeline-item">
                <div class="fw-semibold">Kredit Berakhir</div>
                <small class="text-muted">{{ \Carbon\Carbon::parse($kredit->tgl_selesai_kredit)->format('d F Y') }}</small>
            </div>
            <div class="timeline-item">
                <div class="fw-semibold">Status Saat Ini</div>
                <small class="text-muted">{{ ucfirst($kredit->status_kredit) }}</small>
            </div>
        </div>
        
        <!-- Aksi -->
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-cog text-primary me-2"></i> Aksi
            </h5>
            <div class="d-grid gap-2">
                <a href="{{ route('marketing.angsuran.create', ['kredit_id' => $kredit->id]) }}" class="btn btn-success">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Angsuran
                </a>
                <a href="{{ route('marketing.kredit.edit', $kredit->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i> Edit Kredit
                </a>
                <a href="{{ route('marketing.kredit.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
        
        <!-- Informasi Tambahan -->
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-clock text-primary me-2"></i> Informasi Sistem
            </h5>
            <div class="info-label">Dibuat pada</div>
            <div class="info-value mb-2">{{ \Carbon\Carbon::parse($kredit->created_at)->format('d F Y H:i:s') }}</div>
            <div class="info-label">Terakhir diupdate</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($kredit->updated_at)->format('d F Y H:i:s') }}</div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonColor: '#667eea'
    });
</script>
@endif
@endsection
@extends('layouts.marketing')

@section('title', 'Detail Angsuran')
@section('page-title', 'Detail Data Angsuran')

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
    .badge-status {
        display: inline-flex;
        padding: 5px 12px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
    }
    .badge-lunas { background: #d1fae5; color: #059669; }
    .badge-belum { background: #fef3c7; color: #d97706; }
    .badge-telat { background: #fee2e2; color: #dc2626; }
    .bg-soft-primary {
        background: rgba(102, 126, 234, 0.1);
    }
    .progress {
        height: 8px;
        border-radius: 10px;
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-lg-8">
        <!-- Detail Angsuran -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-receipt text-primary me-2"></i> Detail Angsuran
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-label">ID Angsuran</div>
                    <div class="info-value">#{{ $angsuran->id }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="badge-status {{ $angsuran->status == 'Lunas' ? 'badge-lunas' : ($angsuran->status == 'Telat' ? 'badge-telat' : 'badge-belum') }}">
                            {{ $angsuran->status ?? 'Belum Bayar' }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Angsuran Ke</div>
                    <div class="info-value">{{ $angsuran->angsuran_ke }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Tanggal Bayar</div>
                    <div class="info-value">{{ $angsuran->tgl_bayar ? \Carbon\Carbon::parse($angsuran->tgl_bayar)->format('d F Y H:i') : '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Total Bayar</div>
                    <div class="info-value text-success fw-bold fs-4">Rp {{ number_format($angsuran->total_bayar, 0, ',', '.') }}</div>
                </div>
                @if($angsuran->keterangan)
                <div class="col-12">
                    <div class="info-label">Keterangan</div>
                    <div class="info-value">{{ $angsuran->keterangan }}</div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Informasi Kredit -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-credit-card text-primary me-2"></i> Informasi Kredit
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-label">No. Kredit</div>
                    <div class="info-value">#{{ $angsuran->kredit->id }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Status Kredit</div>
                    <div class="info-value">{{ ucfirst($angsuran->kredit->status_kredit) }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Tenor</div>
                    <div class="info-value">{{ $angsuran->kredit->pengajuanKredit->tenor }} bulan</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Cicilan per Bulan</div>
                    <div class="info-value">Rp {{ number_format($angsuran->kredit->pengajuanKredit->cicilan_perbulan, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Total Kredit</div>
                    <div class="info-value">Rp {{ number_format($angsuran->kredit->pengajuanKredit->harga_kredit, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Sisa Kredit</div>
                    <div class="info-value">Rp {{ number_format($angsuran->kredit->sisa_kredit, 0, ',', '.') }}</div>
                </div>
            </div>
            
            @php
                $totalKredit = $angsuran->kredit->pengajuanKredit->harga_kredit;
                $sisaKredit = $angsuran->kredit->sisa_kredit;
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
            </div>
        </div>
        
        <!-- Informasi Pelanggan -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-user-circle text-primary me-2"></i> Informasi Pelanggan
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-label">Nama Pelanggan</div>
                    <div class="info-value">{{ $angsuran->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">{{ $angsuran->kredit->pengajuanKredit->pelanggan->no_telp ?? '-' }}</div>
                </div>
                <div class="col-12">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ $angsuran->kredit->pengajuanKredit->pelanggan->alamat ?? '-' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Informasi Motor -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-motorcycle text-primary me-2"></i> Informasi Motor
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-label">Motor</div>
                    <div class="info-value">{{ $angsuran->kredit->pengajuanKredit->motor->nama_motor ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Merk</div>
                    <div class="info-value">{{ $angsuran->kredit->pengajuanKredit->motor->merk ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Tipe</div>
                    <div class="info-value">{{ $angsuran->kredit->pengajuanKredit->motor->jenisMotor->nama_jenis ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Tahun</div>
                    <div class="info-value">{{ $angsuran->kredit->pengajuanKredit->motor->tahun ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Timeline -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-timeline text-primary me-2"></i> Timeline
            </h5>
            <div class="timeline-item mb-3">
                <div class="fw-semibold">Kredit Dimulai</div>
                <small class="text-muted">{{ \Carbon\Carbon::parse($angsuran->kredit->tgl_mulai_kredit)->format('d F Y') }}</small>
            </div>
            <div class="timeline-item mb-3">
                <div class="fw-semibold">Angsuran Dibayar</div>
                <small class="text-muted">{{ $angsuran->tgl_bayar ? \Carbon\Carbon::parse($angsuran->tgl_bayar)->format('d F Y H:i') : '-' }}</small>
            </div>
            <div class="timeline-item mb-3">
                <div class="fw-semibold">Kredit Berakhir</div>
                <small class="text-muted">{{ \Carbon\Carbon::parse($angsuran->kredit->tgl_selesai_kredit)->format('d F Y') }}</small>
            </div>
        </div>
        
        <!-- Aksi -->
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-cog text-primary me-2"></i> Aksi
            </h5>
            <div class="d-grid gap-2">
                <a href="{{ route('marketing.angsuran.edit', $angsuran->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i> Edit Angsuran
                </a>
                <a href="{{ route('marketing.kredit.show', $angsuran->id_kredit) }}" class="btn btn-info">
                    <i class="fas fa-credit-card me-2"></i> Lihat Detail Kredit
                </a>
                <a href="{{ route('marketing.angsuran.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
        
        <!-- Informasi Sistem -->
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-clock text-primary me-2"></i> Informasi Sistem
            </h5>
            <div class="info-label">Dibuat pada</div>
            <div class="info-value mb-2">{{ \Carbon\Carbon::parse($angsuran->created_at)->format('d F Y H:i:s') }}</div>
            <div class="info-label">Terakhir diupdate</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($angsuran->updated_at)->format('d F Y H:i:s') }}</div>
        </div>
    </div>
</div>

<style>
.timeline-item {
    position: relative;
    padding-left: 20px;
    border-left: 2px solid #e2e8f0;
}
.timeline-item:last-child {
    border-left-color: transparent;
}
</style>

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
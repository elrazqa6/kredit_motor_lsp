@extends('layouts.client')

@section('title', 'Detail Pengajuan Kredit')
@section('page-title', 'Detail Pengajuan Kredit')

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
        font-size: 11px;
        color: #64748b;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
    .badge-menunggu { background: #fef3c7; color: #d97706; }
    .badge-disetujui { background: #d1fae5; color: #059669; }
    .badge-ditolak { background: #fee2e2; color: #dc2626; }
    .file-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 12px;
        text-align: center;
        transition: all 0.2s;
    }
    .file-card:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 24px;
    }
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    .timeline-icon {
        position: absolute;
        left: -30px;
        top: 0;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .timeline-content {
        padding-left: 16px;
    }
    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: -14px;
        top: 32px;
        width: 2px;
        height: calc(100% - 8px);
        background: #e2e8f0;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .bg-gradient-danger {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    .rounded-4 {
        border-radius: 1rem !important;
    }
    .method-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 12px;
        transition: all 0.2s;
    }
    .method-card:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-lg-8">
        <!-- Informasi Pengajuan -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-info-circle text-primary me-2"></i> Informasi Pengajuan
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-label">ID Pengajuan</div>
                    <div class="info-value fw-bold text-primary">#{{ $pengajuan->id }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Tanggal Pengajuan</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan_kredit)->translatedFormat('d F Y H:i') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Status Pengajuan</div>
                    <div class="info-value">
                        @php
                            $badgeClass = '';
                            $icon = '';
                            if ($pengajuan->status_pengajuan == 'Menunggu') {
                                $badgeClass = 'badge-menunggu';
                                $icon = 'clock';
                                $statusText = 'Menunggu Konfirmasi';
                            } elseif ($pengajuan->status_pengajuan == 'Disetujui') {
                                $badgeClass = 'badge-disetujui';
                                $icon = 'check-circle';
                                $statusText = 'Disetujui';
                            } else {
                                $badgeClass = 'badge-ditolak';
                                $icon = 'times-circle';
                                $statusText = 'Ditolak';
                            }
                        @endphp
                        <span class="status-badge {{ $badgeClass }}">
                            <i class="fas fa-{{ $icon }} me-1"></i> {{ $statusText }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Terakhir Diupdate</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($pengajuan->updated_at)->translatedFormat('d F Y H:i') }}</div>
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
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">{{ $pengajuan->pelanggan->nama_pelanggan ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">{{ $pengajuan->pelanggan->no_telp ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $pengajuan->pelanggan->email ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Pekerjaan</div>
                    <div class="info-value">{{ $pengajuan->pelanggan->pekerjaan ?? '-' }}</div>
                </div>
                <div class="col-md-12">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ $pengajuan->pelanggan->alamat ?? '-' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Informasi Motor & Kredit -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-motorcycle text-primary me-2"></i> Informasi Motor & Kredit
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-label">Motor</div>
                    <div class="info-value fw-bold">{{ $pengajuan->motor->nama_motor ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Merk</div>
                    <div class="info-value">{{ $pengajuan->motor->merk ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Tipe Motor</div>
                    <div class="info-value">{{ $pengajuan->motor->jenisMotor->nama_jenis ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Tahun</div>
                    <div class="info-value">{{ $pengajuan->motor->tahun ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Harga Cash</div>
                    <div class="info-value text-primary fw-bold">Rp {{ number_format($pengajuan->harga_cash, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">DP (Uang Muka)</div>
                    <div class="info-value">{{ number_format($pengajuan->dp, 2) }}%</div>
                    <small class="text-muted">Rp {{ number_format($pengajuan->uang_muka, 0, ',', '.') }}</small>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Tenor</div>
                    <div class="info-value">{{ $pengajuan->tenor }} bulan</div>
                    <small class="text-muted">{{ number_format($pengajuan->tenor / 12, 1) }} tahun</small>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Cicilan per Bulan</div>
                    <div class="info-value text-success fw-bold fs-5">Rp {{ number_format($pengajuan->cicilan_perbulan, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Jenis Cicilan</div>
                    <div class="info-value">{{ $pengajuan->jenisCicilan->lama_cicilan ?? '-' }} bulan</div>
                    <small class="text-muted">Margin {{ $pengajuan->jenisCicilan->margin_kredit ?? '-' }}%</small>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Asuransi</div>
                    <div class="info-value">{{ $pengajuan->asuransi->nama_asuransi ?? 'Tanpa Asuransi' }}</div>
                    @if($pengajuan->biaya_asuransi_perbulan > 0)
                        <small class="text-muted">Rp {{ number_format($pengajuan->biaya_asuransi_perbulan, 0, ',', '.') }}/bulan</small>
                    @endif
                </div>
                <div class="col-md-12">
                    <div class="info-label">Total Harga Kredit</div>
                    <div class="info-value text-primary fw-bold fs-5">Rp {{ number_format($pengajuan->harga_kredit, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
@if($pengajuan->status_dp == 'Lunas')
<a href="{{ route('client.pengajuan.print-dp', $pengajuan->id) }}"
   class="btn btn-success">
    <i class="fas fa-print me-2"></i>
    Cetak Kwitansi DP
</a>
@endif
        <!-- Ringkasan Pembayaran -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-chart-pie text-primary me-2"></i> Ringkasan Pembayaran
            </h5>
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="text-center p-3 bg-light rounded-3">
                        <div class="info-label">Harga Motor</div>
                        <div class="info-value text-dark">Rp {{ number_format($pengajuan->harga_cash, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="text-center p-3 bg-light rounded-3">
                        <div class="info-label">DP ({{ number_format($pengajuan->dp, 2) }}%)</div>
                        <div class="info-value text-danger">- Rp {{ number_format($pengajuan->uang_muka, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="text-center p-3 bg-light rounded-3">
                        <div class="info-label">Pokok Kredit</div>
                        <div class="info-value text-warning">Rp {{ number_format($pengajuan->harga_cash - $pengajuan->uang_muka, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="text-center p-3 bg-primary bg-opacity-10 rounded-3">
                        <div class="info-label">Cicilan/Bulan</div>
                        <div class="info-value text-success fw-bold">Rp {{ number_format($pengajuan->cicilan_perbulan, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Keterangan -->
        @if($pengajuan->keterangan_status_pengajuan)
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-sticky-note text-primary me-2"></i> Keterangan Status
            </h5>
            <p class="mb-0">{{ $pengajuan->keterangan_status_pengajuan }}</p>
        </div>
        @endif
    </div>
    
    <div class="col-lg-4">
        <!-- Dokumen Pendukung -->
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-file-upload text-primary me-2"></i> Dokumen Pendukung
            </h5>
            <div class="row g-3">
                @if($pengajuan->url_ktp)
                <div class="col-12">
                    <div class="file-card">
                        <i class="fas fa-id-card fa-2x text-primary mb-2"></i>
                        <div class="fw-semibold">KTP</div>
                        <a href="{{ asset('storage/'.$pengajuan->url_ktp) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2 rounded-pill">
                            <i class="fas fa-eye me-1"></i> Lihat Dokumen
                        </a>
                    </div>
                </div>
                @endif
                @if($pengajuan->url_kk)
                <div class="col-12">
                    <div class="file-card">
                        <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                        <div class="fw-semibold">Kartu Keluarga</div>
                        <a href="{{ asset('storage/'.$pengajuan->url_kk) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2 rounded-pill">
                            <i class="fas fa-eye me-1"></i> Lihat Dokumen
                        </a>
                    </div>
                </div>
                @endif
                @if($pengajuan->url_npwp)
                <div class="col-12">
                    <div class="file-card">
                        <i class="fas fa-file-invoice fa-2x text-primary mb-2"></i>
                        <div class="fw-semibold">NPWP</div>
                        <a href="{{ asset('storage/'.$pengajuan->url_npwp) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2 rounded-pill">
                            <i class="fas fa-eye me-1"></i> Lihat Dokumen
                        </a>
                    </div>
                </div>
                @endif
                @if($pengajuan->url_slip_gaji)
                <div class="col-12">
                    <div class="file-card">
                        <i class="fas fa-money-bill fa-2x text-primary mb-2"></i>
                        <div class="fw-semibold">Slip Gaji</div>
                        <a href="{{ asset('storage/'.$pengajuan->url_slip_gaji) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2 rounded-pill">
                            <i class="fas fa-eye me-1"></i> Lihat Dokumen
                        </a>
                    </div>
                </div>
                @endif
                @if($pengajuan->url_foto)
                <div class="col-12">
                    <div class="file-card">
                        <i class="fas fa-camera fa-2x text-primary mb-2"></i>
                        <div class="fw-semibold">Foto Diri</div>
                        <a href="{{ asset('storage/'.$pengajuan->url_foto) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2 rounded-pill">
                            <i class="fas fa-eye me-1"></i> Lihat Dokumen
                        </a>
                    </div>
                </div>
                @endif
                @if(!$pengajuan->url_ktp && !$pengajuan->url_kk && !$pengajuan->url_npwp && !$pengajuan->url_slip_gaji && !$pengajuan->url_foto)
                <div class="col-12">
                    <div class="text-center py-4">
                        <i class="fas fa-file fa-3x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Belum ada dokumen yang diupload</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Timeline Pengajuan -->
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-timeline text-primary me-2"></i> Timeline Pengajuan
            </h5>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-icon bg-gradient-primary text-white d-flex align-items-center justify-content-center">
                        <i class="fas fa-file-invoice fa-sm"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="fw-bold">Pengajuan Dibuat</div>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($pengajuan->created_at)->translatedFormat('d F Y H:i') }}</small>
                    </div>
                </div>
                
                @if($pengajuan->status_pengajuan != 'Menunggu')
                <div class="timeline-item">
                    <div class="timeline-icon bg-gradient-warning text-white d-flex align-items-center justify-content-center">
                        <i class="fas fa-spinner fa-sm"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="fw-bold">Pengajuan Diproses</div>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($pengajuan->updated_at)->translatedFormat('d F Y H:i') }}</small>
                    </div>
                </div>
                @endif
                
                @if($pengajuan->status_pengajuan == 'Disetujui')
                <div class="timeline-item">
                    <div class="timeline-icon bg-gradient-success text-white d-flex align-items-center justify-content-center">
                        <i class="fas fa-check-circle fa-sm"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="fw-bold">Pengajuan Disetujui</div>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($pengajuan->updated_at)->translatedFormat('d F Y H:i') }}</small>
                    </div>
                </div>
                @endif
                
                @if($pengajuan->status_pengajuan == 'Ditolak')
                <div class="timeline-item">
                    <div class="timeline-icon bg-gradient-danger text-white d-flex align-items-center justify-content-center">
                        <i class="fas fa-times-circle fa-sm"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="fw-bold">Pengajuan Ditolak</div>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($pengajuan->updated_at)->translatedFormat('d F Y H:i') }}</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Info Kredit (Jika Sudah Disetujui) -->
        @if($pengajuan->status_pengajuan == 'Disetujui' && $pengajuan->kredit)
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-chart-line text-primary me-2"></i> Info Kredit Aktif
            </h5>
            <div class="row g-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Status Kredit</span>
                        <span class="badge bg-success">Dicicil</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Sisa Kredit</span>
                        <span class="fw-bold">Rp {{ number_format($pengajuan->kredit->sisa_kredit, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Mulai Kredit</span>
                        <span>{{ \Carbon\Carbon::parse($pengajuan->kredit->tgl_mulai_kredit)->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Selesai Kredit</span>
                        <span>{{ \Carbon\Carbon::parse($pengajuan->kredit->tgl_selesai_kredit)->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 mt-3">
                <a href="{{ route('client.angsuran.index', $pengajuan->kredit->id) }}" class="btn btn-primary-gradient rounded-pill">
                    <i class="fas fa-credit-card me-2"></i> Lihat Tagihan & Bayar
                </a>
            </div>
        </div>
        @endif
        
        <!-- Aksi (Hanya untuk Client) -->
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-cog text-primary me-2"></i> Aksi
            </h5>
            <div class="d-grid gap-2">
                @if($pengajuan->status_pengajuan == 'Menunggu')
                <button type="button" class="btn btn-warning rounded-pill py-2" onclick="confirmCancel()">
                    <i class="fas fa-times-circle me-2"></i> Batalkan Pengajuan
                </button>
                @endif
                <a href="{{ route('client.pengajuan.index') }}" class="btn btn-outline-secondary rounded-pill py-2">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmCancel() {
    Swal.fire({
        title: 'Batalkan Pengajuan?',
        text: 'Apakah Anda yakin ingin membatalkan pengajuan ini? Data tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Batalkan!',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("client.pengajuan.update", $pengajuan->id) }}';
            form.innerHTML = `
                @csrf
                @method('PUT')
                <input type="hidden" name="status_pengajuan" value="Ditolak">
                <input type="hidden" name="keterangan" value="Dibatalkan oleh pelanggan">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

@if(session('success'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonColor: '#667eea',
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: 'Gagal!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonColor: '#dc2626'
    });
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        title: 'Error!',
        html: '{!! implode('<br>', $errors->all()) !!}',
        icon: 'error',
        confirmButtonColor: '#dc2626'
    });
</script>
@endif

@endsection
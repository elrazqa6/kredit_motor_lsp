@extends('layouts.marketing')

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
    .badge-warning { background: #fef3c7; color: #d97706; }
    .badge-info { background: #dbeafe; color: #2563eb; }
    .badge-success { background: #d1fae5; color: #059669; }
    .badge-danger { background: #fee2e2; color: #dc2626; }
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
</style>
@endpush

@section('content')

@php
    $kredit = $pengajuan->kredit;
    $pengiriman = $kredit ? \App\Models\Pengiriman::where('id_kredit', $kredit->id)->first() : null;
@endphp

<div class="row">
    <div class="col-lg-8">
        <!-- Informasi Pengajuan -->
        <div class="info-card">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-info-circle text-primary me-2"></i> Informasi Pengajuan
            </h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-label">Tanggal Pengajuan</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan_kredit)->format('d F Y H:i') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Status Pengajuan</div>
                    <div class="info-value">
                        @php
                            $statusMap = [
                                'Menunggu' => ['class' => 'badge-warning', 'text' => 'Menunggu Konfirmasi'],
                                'Disetujui' => ['class' => 'badge-success', 'text' => 'Disetujui'],
                                'Ditolak' => ['class' => 'badge-danger', 'text' => 'Ditolak'],
                            ];
                            $status = $statusMap[$pengajuan->status_pengajuan] ?? ['class' => 'badge-secondary', 'text' => $pengajuan->status_pengajuan];
                        @endphp
                        <span class="status-badge {{ $status['class'] }}">
                            {{ $status['text'] }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">ID Pengajuan</div>
                    <div class="info-value">#{{ $pengajuan->id }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Terakhir Diupdate</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($pengajuan->updated_at)->format('d F Y H:i') }}</div>
                </div>
                
                {{-- STATUS DP --}}
                <div class="col-md-6">
                    <div class="info-label">Status DP (Uang Muka)</div>
                    <div class="info-value">
                        @php
                            $dpStatus = $pengajuan->status_dp ?? 'Belum Bayar';
                            if ($dpStatus == 'Lunas') {
                                $dpBadgeClass = 'badge-success';
                                $dpText = 'DP Lunas ✅';
                            } elseif ($dpStatus == 'Menunggu') {
                                $dpBadgeClass = 'badge-warning';
                                $dpText = 'Menunggu Verifikasi';
                            } elseif ($dpStatus == 'Ditolak') {
                                $dpBadgeClass = 'badge-danger';
                                $dpText = 'DP Ditolak ❌';
                            } else {
                                $dpBadgeClass = 'badge-secondary';
                                $dpText = 'Belum Bayar';
                            }
                        @endphp
                        <span class="status-badge {{ $dpBadgeClass }}">
                            {{ $dpText }}
                        </span>
                        @if($dpStatus == 'Menunggu' && $pengajuan->bukti_dp)
                            <br>
                            <small class="text-muted">
                                <a href="{{ asset('storage/'.$pengajuan->bukti_dp) }}" target="_blank" class="text-primary">
                                    <i class="fas fa-image me-1"></i> Lihat Bukti
                                </a>
                            </small>
                        @endif
                        @if($pengajuan->tgl_bayar_dp)
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Dibayar: {{ \Carbon\Carbon::parse($pengajuan->tgl_bayar_dp)->format('d/m/Y H:i') }}
                            </small>
                        @endif
                    </div>
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
                    <div class="info-value">{{ $pengajuan->pelanggan->nama_pelanggan ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">{{ $pengajuan->pelanggan->no_telp ?? '-' }}</div>
                </div>
                <div class="col-md-12">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ $pengajuan->pelanggan->alamat1 ?? '-' }}</div>
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
                    <div class="info-value">{{ $pengajuan->motor->nama_motor ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Merk</div>
                    <div class="info-value">{{ $pengajuan->motor->merk ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Harga Cash</div>
                    <div class="info-value">Rp {{ number_format($pengajuan->harga_cash, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">DP</div>
                    <div class="info-value">{{ number_format($pengajuan->dp, 2) }}% (Rp {{ number_format($pengajuan->uang_muka, 0, ',', '.') }})</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Tenor</div>
                    <div class="info-value">{{ $pengajuan->tenor }} bulan</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Cicilan per Bulan</div>
                    <div class="info-value text-success fw-bold">Rp {{ number_format($pengajuan->cicilan_perbulan, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Jenis Cicilan</div>
                    <div class="info-value">{{ $pengajuan->jenisCicilan->lama_cicilan ?? '-' }} bulan (Margin {{ $pengajuan->jenisCicilan->margin_kredit ?? '-' }}%)</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Asuransi</div>
                    <div class="info-value">{{ $pengajuan->asuransi->nama_asuransi ?? 'Tanpa Asuransi' }}</div>
                </div>
                <div class="col-md-12">
                    <div class="info-label">Total Harga Kredit</div>
                    <div class="info-value text-primary fw-bold">Rp {{ number_format($pengajuan->harga_kredit, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        
        <!-- Keterangan -->
        @if($pengajuan->keterangan_status_pengajuan)
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-sticky-note text-primary me-2"></i> Keterangan
            </h5>
            <p class="mb-0">{{ $pengajuan->keterangan_status_pengajuan }}</p>
        </div>
        @endif
    </div>
    
    <div class="col-lg-4">
        <!-- Dokumen -->
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
                        <a href="{{ asset('storage/'.$pengajuan->url_ktp) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-eye"></i> Lihat Dokumen
                        </a>
                    </div>
                </div>
                @endif
                @if($pengajuan->url_kk)
                <div class="col-12">
                    <div class="file-card">
                        <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                        <div class="fw-semibold">Kartu Keluarga</div>
                        <a href="{{ asset('storage/'.$pengajuan->url_kk) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-eye"></i> Lihat Dokumen
                        </a>
                    </div>
                </div>
                @endif
                @if($pengajuan->url_npwp)
                <div class="col-12">
                    <div class="file-card">
                        <i class="fas fa-file-invoice fa-2x text-primary mb-2"></i>
                        <div class="fw-semibold">NPWP</div>
                        <a href="{{ asset('storage/'.$pengajuan->url_npwp) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-eye"></i> Lihat Dokumen
                        </a>
                    </div>
                </div>
                @endif
                @if($pengajuan->url_slip_gaji)
                <div class="col-12">
                    <div class="file-card">
                        <i class="fas fa-money-bill fa-2x text-primary mb-2"></i>
                        <div class="fw-semibold">Slip Gaji</div>
                        <a href="{{ asset('storage/'.$pengajuan->url_slip_gaji) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-eye"></i> Lihat Dokumen
                        </a>
                    </div>
                </div>
                @endif
                @if($pengajuan->url_foto)
                <div class="col-12">
                    <div class="file-card">
                        <i class="fas fa-camera fa-2x text-primary mb-2"></i>
                        <div class="fw-semibold">Foto</div>
                        <a href="{{ asset('storage/'.$pengajuan->url_foto) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-eye"></i> Lihat Dokumen
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Aksi -->
        <div class="info-card">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-cog text-primary me-2"></i> Aksi
            </h5>
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editStatusModal">
                    <i class="fas fa-edit me-2"></i> Ubah Status
                </button>
                
                @if($pengajuan->status_pengajuan == 'Disetujui')
                    @if($pengajuan->status_dp == 'Lunas')
                        @if(!$pengiriman)
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#buatPengirimanModal">
                                <i class="fas fa-truck me-2"></i> Buat Pengiriman
                            </button>
                        @else
                            <div class="alert alert-info border-0 rounded-3 mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Pengiriman sudah dibuat.<br>
                                No Resi: <strong>{{ $pengiriman->no_resi }}</strong><br>
                                Status: <strong>{{ $pengiriman->status }}</strong>
                            </div>
                            <a href="{{ route('marketing.pengiriman.show', $pengiriman->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i> Detail Pengiriman
                            </a>
                        @endif
                    @else
                        <div class="alert alert-warning border-0 rounded-3 mb-0">
                            <i class="fas fa-clock me-2"></i>
                            Menunggu pembayaran DP dari pelanggan.
                        </div>
                    @endif
                @endif
                
                <a href="{{ route('marketing.pengajuan.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Buat Pengiriman -->
<div class="modal fade" id="buatPengirimanModal" tabindex="-1" aria-labelledby="buatPengirimanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="buatPengirimanModalLabel">
                    <i class="fas fa-truck me-2"></i> Buat Pengiriman
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('marketing.pengiriman.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_kredit" value="{{ $kredit->id ?? '' }}">
                <input type="hidden"
       name="alamat_pengiriman"
       value="{{ $pengajuan->pelanggan->alamat1 ?? '-' }}">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kurir</label>
                        <select name="kurir" class="form-select" required>
                            <option value="">-- Pilih Kurir --</option>
                            <option value="JNE">JNE</option>
                            <option value="J&T">J&T Express</option>
                            <option value="SiCepat">SiCepat</option>
                            <option value="Ninja Express">Ninja Express</option>
                            <option value="Lion Parcel">Lion Parcel</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Estimasi Sampai</label>
                        <input type="date" name="tgl_estimasi_sampai" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan khusus..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Buat Pengiriman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Status -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editStatusModalLabel">
                    <i class="fas fa-edit me-2"></i> Ubah Status Pengajuan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('marketing.pengajuan.update', $pengajuan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Pengajuan</label>
                        <select name="status_pengajuan" class="form-select" required>
                            <option value="Menunggu" {{ $pengajuan->status_pengajuan == 'Menunggu' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="Disetujui" {{ $pengajuan->status_pengajuan == 'Disetujui' ? 'selected' : '' }}>Disetujui / Diterima</option>
                            <option value="Ditolak" {{ $pengajuan->status_pengajuan == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <small class="text-muted">Pilih status pengajuan</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan (Opsional)</label>
                        <textarea name="keterangan_status_pengajuan" class="form-control" rows="3" placeholder="Tambahkan catatan...">{{ $pengajuan->keterangan_status_pengajuan }}</textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
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
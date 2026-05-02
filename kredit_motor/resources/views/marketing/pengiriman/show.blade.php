@extends('layouts.marketing')

@section('title', 'Detail Pengiriman')
@section('page-title', 'Detail Pengiriman')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-truck me-2 text-primary"></i> Detail Pengiriman
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-label">No Resi</div>
                        <div class="info-value fw-bold">{{ $pengiriman->no_resi }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            @if($pengiriman->status == 'Diproses')
                                <span class="badge bg-warning">Diproses</span>
                            @elseif($pengiriman->status == 'Dikirim')
                                <span class="badge bg-primary">Dikirim</span>
                            @elseif($pengiriman->status == 'Selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Batal</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Pelanggan</div>
                        <div class="info-value">{{ $pengiriman->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">No. Telepon</div>
                        <div class="info-value">{{ $pengiriman->kredit->pengajuanKredit->pelanggan->no_telp ?? '-' }}</div>
                    </div>
                    <div class="col-12">
                        <div class="info-label">Alamat Pengiriman</div>
                        <div class="info-value">{{ $pengiriman->alamat_pengiriman }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Kurir</div>
                        <div class="info-value">{{ $pengiriman->kurir ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Tanggal Kirim</div>
                        <div class="info-value">{{ $pengiriman->tgl_pengiriman ? \Carbon\Carbon::parse($pengiriman->tgl_pengiriman)->format('d/m/Y') : '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Estimasi Sampai</div>
                        <div class="info-value">{{ $pengiriman->tgl_estimasi_sampai ? \Carbon\Carbon::parse($pengiriman->tgl_estimasi_sampai)->format('d/m/Y') : '-' }}</div>
                    </div>
                    @if($pengiriman->tgl_sampai)
                    <div class="col-12">
                        <div class="info-label">Tanggal Sampai</div>
                        <div class="info-value text-success fw-bold">{{ \Carbon\Carbon::parse($pengiriman->tgl_sampai)->format('d/m/Y') }}</div>
                    </div>
                    @endif
                    @if($pengiriman->keterangan)
                    <div class="col-12">
                        <div class="info-label">Keterangan</div>
                        <div class="info-value">{{ $pengiriman->keterangan }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-cog me-2 text-primary"></i> Update Status
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('marketing.pengiriman.updateStatus', $pengiriman->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ubah Status</label>
                        <select name="status" class="form-select">
                            <option value="Diproses" {{ $pengiriman->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Dikirim" {{ $pengiriman->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="Selesai" {{ $pengiriman->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Batal" {{ $pengiriman->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">
                        <i class="fas fa-save me-2"></i> Update Status
                    </button>
                </form>
                
                <hr>
                
                <div class="timeline mt-3">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="text-center {{ $pengiriman->status == 'Diproses' ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-clipboard-list fa-2x"></i>
                            <p class="small mb-0">Diproses</p>
                        </div>
                        <div class="text-center {{ $pengiriman->status == 'Dikirim' ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-truck fa-2x"></i>
                            <p class="small mb-0">Dikirim</p>
                        </div>
                        <div class="text-center {{ $pengiriman->status == 'Selesai' ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-check-circle fa-2x"></i>
                            <p class="small mb-0">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .info-label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }
</style>
@endsection
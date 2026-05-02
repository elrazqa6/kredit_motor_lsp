@extends('layouts.marketing')

@section('title', 'Pengajuan Offline')
@section('page-title', 'Pengajuan Offline')

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-file-invoice me-2 text-primary"></i> Daftar Pengajuan Offline
            </h5>
            <a href="{{ route('marketing.pengajuan-offline.create') }}" class="btn btn-primary rounded-pill">
                <i class="fas fa-plus me-2"></i> Input Baru
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Motor</th>
                        <th>Cicilan/Bulan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuan as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_pengajuan_kredit)->format('d/m/Y H:i') }}</div>
                        <td>
                            <div class="fw-semibold">{{ $item->pelanggan->nama_pelanggan ?? '-' }}</div>
                            <small class="text-muted">{{ $item->pelanggan->no_telp ?? '-' }}</small>
                         </div>
                        <td>{{ $item->motor->nama_motor ?? '-' }}</div>
                        <td>Rp {{ number_format($item->cicilan_perbulan, 0, ',', '.') }}</div>
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
                        <td colspan="6">Belum ada pengajuan offline</div>
                     </div>
                    @endforelse
                </tbody>
             </div>
        </div>
    </div>
    <div class="card-footer bg-white border-0 p-4">
        {{ $pengajuan->links() }}
    </div>
</div>
@endsection
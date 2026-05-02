@extends('layouts.marketing')

@section('title', 'Pengiriman Motor')
@section('page-title', 'Manajemen Pengiriman')

@push('styles')
<style>
    .status-badge {
        display: inline-flex;
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 600;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 p-4">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-truck me-2 text-primary"></i> Daftar Pengiriman
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">No Resi</th>
                        <th width="20%">Pelanggan</th>
                        <th width="20%">Motor</th>
                        <th width="10%">Kurir</th>
                        <th width="10%">Tgl Kirim</th>
                        <th width="10%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengiriman as $index => $item)
                    <tr>
                        <td>{{ $index + $pengiriman->firstItem() }} </td>
                        <td><strong>{{ $item->no_resi }}</strong> </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fas fa-user text-primary fa-sm"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $item->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '-' }}</div>
                                    <small class="text-muted">{{ $item->kredit->pengajuanKredit->pelanggan->no_telp ?? '-' }}</small>
                                </div>
                            </div>
                         </td>
                        <td>
                            <div class="fw-semibold small">{{ $item->kredit->pengajuanKredit->motor->nama_motor ?? '-' }}</div>
                            <small class="text-muted">{{ $item->kredit->pengajuanKredit->motor->merk ?? '-' }}</small>
                         </td>
                        <td>{{ $item->kurir ?? '-' }} </td>
                        <td>{{ $item->tgl_pengiriman ? \Carbon\Carbon::parse($item->tgl_pengiriman)->format('d/m/Y') : '-' }} </td>
                        <td>
                            @if($item->status == 'Diproses')
                                <span class="badge bg-warning">Diproses</span>
                            @elseif($item->status == 'Dikirim')
                                <span class="badge bg-primary">Dikirim</span>
                            @elseif($item->status == 'Selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Batal</span>
                            @endif
                         </td>
                        <td>
                            <a href="{{ route('marketing.pengiriman.show', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>                        
                            <a href="{{ route('marketing.pengiriman.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="fas fa-eye"></i>
                            </a>
                         </td>
                     </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Belum ada data pengiriman</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $pengiriman->links() }}
</div>
@endsection
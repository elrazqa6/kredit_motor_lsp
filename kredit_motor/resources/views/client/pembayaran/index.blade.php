@extends('layouts.client')

@section('title', 'Pembayaran Angsuran')
@section('page-title', 'Tagihan Kredit')

@section('content')
<div class="container">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('client.kredit.index') }}" class="btn btn-light rounded-pill me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-1">Tagihan Angsuran</h4>
            <p class="text-muted mb-0">{{ $kredit->pengajuanKredit->motor->nama_motor ?? '-' }}</p>
        </div>
    </div>
    
    <!-- Summary -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="bg-light rounded-4 p-3 text-center">
                <small class="text-muted">Total Tagihan</small>
                <h5 class="fw-bold mb-0">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</h5>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="bg-light rounded-4 p-3 text-center">
                <small class="text-muted">Sudah Dibayar</small>
                <h5 class="fw-bold mb-0 text-success">Rp {{ number_format($totalBayar, 0, ',', '.') }}</h5>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="bg-light rounded-4 p-3 text-center">
                <small class="text-muted">Sisa Tagihan</small>
                <h5 class="fw-bold mb-0 text-primary">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</h5>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="bg-light rounded-4 p-3 text-center">
                <small class="text-muted">Angsuran</small>
                <h5 class="fw-bold mb-0">{{ $sudahBayar }} / {{ $totalAngsuran }}</h5>
            </div>
        </div>
    </div>
    
    <!-- Daftar Tagihan -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 p-4">
            <h5 class="fw-bold mb-0">Daftar Angsuran</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Angsuran Ke-</th>
                            <th>Jatuh Tempo</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayaran as $item)
                        <tr>
                            <td class="fw-bold">{{ $item->angsuran_ke }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($item->nominal_bayar, 0, ',', '.') }}</td>
                            <td>
                                @if($item->status_bayar == 'Lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @elseif($item->jatuh_tempo < now())
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-warning">Belum Bayar</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status_bayar != 'Lunas')
                                    <a href="{{ route('client.pembayaran.create', ['id_kredit' => $kredit->id, 'id_pembayaran' => $item->id]) }}" 
                                       class="btn btn-sm btn-primary rounded-pill">
                                        <i class="fas fa-credit-card me-1"></i> Bayar
                                    </a>
                                @elseif($item->bukti_bayar)
                                    <a href="{{ asset('storage/'.$item->bukti_bayar) }}" target="_blank" 
                                       class="btn btn-sm btn-outline-secondary rounded-pill">
                                        <i class="fas fa-receipt me-1"></i> Bukti
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
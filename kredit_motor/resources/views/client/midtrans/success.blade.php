@extends('layouts.client')

@section('title', 'Pembayaran Berhasil')
@section('page-title', 'Pembayaran Berhasil')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                <div class="card-body">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-4 mb-4">
                        <i class="fas fa-check-circle fa-4x text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-2">Pembayaran Berhasil!</h3>
                    <p class="text-muted mb-4">Terima kasih, pembayaran Anda telah kami terima.</p>
                    <p class="small text-muted mb-4">Order ID: {{ $orderId ?? '-' }}</p>
                    
                    <div class="alert alert-info border-0 rounded-3" id="printStatus">
                        <i class="fas fa-spinner fa-spin me-2"></i>
                        Mempersiapkan kwitansi...
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('client.angsuran.index') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-list me-2"></i> Lihat Riwayat Angsuran
                        </a>
                        <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-home me-2"></i> Ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const orderId = '{{ $orderId }}';

    if (orderId.startsWith('DP-')) {
        const parts = orderId.split('-');
        const pengajuanId = parts[1];

        setTimeout(function() {
            window.location.href = '/client/pengajuan/' + pengajuanId;
        }, 2000);
    }

    if (orderId.startsWith('AGS-')) {
        const parts = orderId.split('-');
        const angsuranId = parts[1];

        setTimeout(function() {
            window.location.href = '/client/angsuran/' + angsuranId + '/print';
        }, 2000);
    }
});
</script>
@endsection
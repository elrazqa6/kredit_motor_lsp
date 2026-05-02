@extends('layouts.client')

@section('title', 'Pembayaran')
@section('page-title', 'Pembayaran via Midtrans')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-credit-card text-primary me-2"></i>
                        @if($type == 'dp')
                            Pembayaran Uang Muka (DP)
                        @else
                            Pembayaran Angsuran Ke-{{ $angsuran_ke ?? '' }}
                        @endif
                    </h5>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-2">
                            <i class="fas fa-money-bill-wave fa-3x text-primary"></i>
                        </div>
                        <h3 class="fw-bold text-primary">Rp {{ number_format($amount, 0, ',', '.') }}</h3>
                        <p class="text-muted">Total yang harus dibayar</p>
                    </div>
                    
                    <div id="payment-loading">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p>Mengarahkan ke halaman pembayaran...</p>
                        <p class="text-muted small">
                            <i class="fas fa-lock me-1"></i> Pembayaran aman & terenkripsi oleh Midtrans
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const snapToken = '{{ $snapToken }}';
    
    if (snapToken) {
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('Success:', result);
                window.location.href = '{{ route("midtrans.success") }}?order_id=' + result.order_id;
            },
            onPending: function(result) {
                console.log('Pending:', result);
                window.location.href = '{{ route("midtrans.pending") }}';
            },
            onError: function(result) {
                console.log('Error:', result);
                window.location.href = '{{ route("midtrans.error") }}';
            },
            onClose: function() {
                console.log('Customer closed the popup');
                alert('Pembayaran dibatalkan');
                window.location.href = document.referrer;
            }
        });
    } else {
        alert('Gagal memuat halaman pembayaran');
        window.location.href = '{{ url()->previous() }}';
    }
});
</script>
@endsection
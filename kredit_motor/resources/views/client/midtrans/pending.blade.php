@extends('layouts.client')

@section('title', 'Pembayaran Pending')
@section('page-title', 'Pembayaran Pending')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                <div class="card-body">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4 mb-4">
                        <i class="fas fa-clock fa-4x text-warning"></i>
                    </div>
                    <h3 class="fw-bold mb-2">Pembayaran Pending</h3>
                    <p class="text-muted mb-4">Pembayaran Anda sedang diproses. Kami akan mengonfirmasi segera.</p>
                    <a href="{{ route('client.dashboard') }}" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-home me-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.marketing')

@section('title', 'Pengajuan Berhasil')
@section('page-title', 'Pengajuan Berhasil')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="card-body">
                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-4 mb-4">
                    <i class="fas fa-check-circle fa-4x text-success"></i>
                </div>
                <h3 class="fw-bold mb-2">Pengajuan Berhasil!</h3>
                <p class="text-muted mb-4">Pengajuan offline telah disimpan.</p>
                
                <div class="alert alert-info border-0 rounded-3 text-start">
                    <strong><i class="fas fa-info-circle me-2"></i> Informasi Akun Pelanggan:</strong><br>
                    Email: <strong>{{ $pengajuan->pelanggan->email }}</strong><br>
                    Password: <strong>password123</strong>
                </div>
                
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('marketing.pengajuan.show', $pengajuan->id) }}" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-eye me-2"></i> Lihat Detail
                    </a>
                    <a href="{{ route('marketing.pengajuan-offline.create') }}" class="btn btn-outline-primary rounded-pill px-4">
                        <i class="fas fa-plus me-2"></i> Input Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
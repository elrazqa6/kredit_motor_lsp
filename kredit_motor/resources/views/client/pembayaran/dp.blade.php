@extends('layouts.client')

@section('title', 'Bayar Uang Muka (DP)')
@section('page-title', 'Bayar Uang Muka')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('client.pengajuan.show', $pengajuan->id) }}" class="btn btn-light rounded-pill me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="fw-bold mb-1">Bayar Uang Muka (DP)</h4>
                    <p class="text-muted mb-0">{{ $pengajuan->motor->nama_motor ?? '-' }}</p>
                </div>
            </div>

            @if($pengajuan->status_dp == 'Lunas')
                <div class="alert alert-success border-0 rounded-4">
                    <i class="fas fa-check-circle me-2"></i>
                    DP sudah lunas. Terima kasih! Motor akan segera diproses.
                </div>
            @elseif($pengajuan->status_dp == 'Menunggu')
                <div class="alert alert-warning border-0 rounded-4">
                    <i class="fas fa-clock me-2"></i>
                    Bukti DP sudah diupload, menunggu verifikasi admin.
                </div>
            @elseif($pengajuan->status_dp == 'Ditolak')
                <div class="alert alert-danger border-0 rounded-4">
                    <i class="fas fa-times-circle me-2"></i>
                    Bukti DP ditolak. Alasan: {{ $pengajuan->keterangan_dp }}<br>
                    Silakan upload ulang bukti yang valid.
                </div>
            @endif

            @if($pengajuan->status_dp != 'Lunas' && $pengajuan->status_dp != 'Menunggu')
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                            <i class="fas fa-money-bill-wave fa-3x text-primary"></i>
                        </div>
                        <h2 class="fw-bold text-primary">
                            Rp {{ number_format($pengajuan->uang_muka, 0, ',', '.') }}
                        </h2>
                        <p class="text-muted">Nominal Uang Muka (DP) yang harus dibayar</p>
                    </div>

                    <div class="alert alert-info border-0 rounded-3 mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Silakan transfer ke rekening berikut:
                        <hr class="my-2">
                        <strong>Bank BCA</strong><br>
                        No. Rekening: 1234567890<br>
                        Atas Nama: PT Kredit Motor Indonesia
                    </div>

                    <form action="{{ route('client.pembayaran.dp.proses', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload Bukti Transfer</label>
                            <input type="file" name="bukti_bayar" class="form-control" accept="image/*,.pdf" required>
                            <small class="text-muted">Format: JPG, PNG, PDF (Max 2MB)</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Keterangan (Opsional)</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Transfer BCA a.n. John Doe"></textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill py-3 fw-bold">
                                <i class="fas fa-upload me-2"></i> Kirim Bukti Pembayaran
                            </button>
                            <a href="{{ route('client.pengajuan.show', $pengajuan->id) }}" class="btn btn-outline-secondary rounded-pill py-2">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@extends('layouts.client')

@section('title', 'Bayar Angsuran')
@section('page-title', 'Bayar Angsuran')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-credit-card text-primary me-2"></i> Form Pembayaran Angsuran
                    </h5>
                    <p class="text-muted small mb-0">Lakukan pembayaran angsuran kredit Anda</p>
                </div>
                <div class="card-body p-4">
                    @if($angsuranTertunda->count() > 0)
                        <div class="alert alert-info border-0 rounded-3 mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            Anda memiliki {{ $angsuranTertunda->count() }} angsuran yang perlu dibayar.
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Angsuran Ke</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Total Bayar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($angsuranTertunda as $item)
                                    <tr>
                                        <td>{{ $item->angsuran_ke }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') }}</td>
                                        <td class="text-success fw-bold">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm rounded-pill bayar-btn"
                                                    data-id="{{ $item->id }}"
                                                    data-angsuran="{{ $item->angsuran_ke }}"
                                                    data-total="{{ $item->total_bayar }}">
                                                <i class="fas fa-credit-card me-1"></i> Bayar
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="bg-soft-success rounded-circle d-inline-flex p-4 mb-3" style="width: 100px; height: 100px;">
                                <i class="fas fa-check-circle fa-4x text-success mx-auto"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Tidak Ada Tagihan</h4>
                            <p class="text-muted">Semua angsuran Anda sudah lunas. Terima kasih!</p>
                            <a href="{{ route('client.angsuran.index') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Pembayaran -->
<div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold" id="bayarModalLabel">
                    <i class="fas fa-credit-card text-primary me-2"></i> Konfirmasi Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="bayarForm" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Metode Pembayaran</label>
                        <select name="metode_bayar" class="form-select rounded-pill" required>
                            <option value="">Pilih Metode</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Kartu Kredit">Kartu Kredit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor Referensi</label>
                        <input type="text" name="ref_no" class="form-control rounded-pill" placeholder="Nomor referensi pembayaran">
                    </div>
                    <div class="alert alert-warning border-0 rounded-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Pastikan Anda melakukan pembayaran sesuai dengan total tagihan.
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-check-circle me-2"></i> Konfirmasi Bayar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-soft-success {
        background: rgba(16, 185, 129, 0.1);
    }
    .rounded-4 {
        border-radius: 1rem !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bayarBtns = document.querySelectorAll('.bayar-btn');
    const bayarForm = document.getElementById('bayarForm');
    
    bayarBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const angsuranKe = this.dataset.angsuran;
            const total = this.dataset.total;
            
            document.getElementById('bayarForm').action = '{{ route("client.angsuran.pay", "") }}/' + id;
            
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                html: `Apakah Anda yakin akan membayar angsuran ke-<strong>${angsuranKe}</strong> sebesar <strong>Rp ${new Intl.NumberFormat('id-ID').format(total)}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Bayar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    new bootstrap.Modal(document.getElementById('bayarModal')).show();
                }
            });
        });
    });
});
</script>
@endsection
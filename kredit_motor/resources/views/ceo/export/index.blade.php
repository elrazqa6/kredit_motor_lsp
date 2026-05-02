@extends('layouts.ceo')

@section('title', 'Export Data')
@section('page-title', 'Export Data')
@section('page-subtitle', 'Export data ke CSV / Excel')

@push('styles')
<style>
    .export-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e8ecf4;
        padding: 24px;
        transition: all 0.2s ease;
        cursor: pointer;
        height: 100%;
    }
    .export-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        border-color: #6366f1;
    }
    .export-icon {
        width: 60px;
        height: 60px;
        background: #eef2ff;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    .export-icon i {
        font-size: 28px;
        color: #6366f1;
    }
    .export-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }
    .export-desc {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 16px;
    }
    .export-badge {
        background: #f1f5f9;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        color: #64748b;
    }
    .filter-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e8ecf4;
        padding: 20px;
        margin-bottom: 24px;
    }
    .modal-export-icon {
        width: 50px;
        height: 50px;
        background: #eef2ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')

<!-- Filter Card -->
<div class="filter-card">
    <form id="exportForm" method="GET" action="{{ route('ceo.export.process') }}">
        <input type="hidden" name="type" id="exportType">
        <input type="hidden" name="format" id="exportFormat">
        
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Dari Tanggal</label>
                <input type="date" name="start_date" id="startDate" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Sampai Tanggal</label>
                <input type="date" name="end_date" id="endDate" class="form-control">
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-secondary w-100 rounded-pill" onclick="resetFilter()">
                    <i class="fas fa-undo-alt me-2"></i> Reset Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Export Cards -->
<div class="row g-4">
    <div class="col-md-6 col-lg-4">
        <div class="export-card" onclick="showExportModal('kredit')">
            <div class="export-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="export-title">Data Kredit</div>
            <div class="export-desc">Export data kredit aktif, lunas, dan macet</div>
            <div class="d-flex gap-2">
                <span class="export-badge"><i class="fas fa-chart-line me-1"></i> Ringkasan</span>
                <span class="export-badge"><i class="fas fa-calendar me-1"></i> Bisa filter tanggal</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="export-card" onclick="showExportModal('motor')">
            <div class="export-icon">
                <i class="fas fa-motorcycle"></i>
            </div>
            <div class="export-title">Data Motor</div>
            <div class="export-desc">Export data inventaris motor, stok, dan harga</div>
            <div class="d-flex gap-2">
                <span class="export-badge"><i class="fas fa-boxes me-1"></i> Stok</span>
                <span class="export-badge"><i class="fas fa-tags me-1"></i> Harga</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="export-card" onclick="showExportModal('angsuran')">
            <div class="export-icon">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="export-title">Data Angsuran</div>
            <div class="export-desc">Export data angsuran, status, dan riwayat bayar</div>
            <div class="d-flex gap-2">
                <span class="export-badge"><i class="fas fa-money-bill-wave me-1"></i> Pembayaran</span>
                <span class="export-badge"><i class="fas fa-calendar me-1"></i> Bisa filter tanggal</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="export-card" onclick="showExportModal('pelanggan')">
            <div class="export-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="export-title">Data Pelanggan</div>
            <div class="export-desc">Export data pelanggan dan kontak</div>
            <div class="d-flex gap-2">
                <span class="export-badge"><i class="fas fa-address-card me-1"></i> Profil</span>
                <span class="export-badge"><i class="fas fa-phone me-1"></i> Kontak</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="export-card" onclick="showExportModal('pengajuan')">
            <div class="export-icon">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="export-title">Data Pengajuan</div>
            <div class="export-desc">Export data pengajuan kredit pelanggan</div>
            <div class="d-flex gap-2">
                <span class="export-badge"><i class="fas fa-chart-line me-1"></i> Statistik</span>
                <span class="export-badge"><i class="fas fa-calendar me-1"></i> Bisa filter tanggal</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-4">
        <div class="export-card" onclick="showExportAll()">
            <div class="export-icon" style="background: #f0fdf4;">
                <i class="fas fa-database" style="color: #22c55e;"></i>
            </div>
            <div class="export-title">Export Semua</div>
            <div class="export-desc">Export semua data dalam satu archive</div>
            <div class="d-flex gap-2">
                <span class="export-badge"><i class="fas fa-file-archive me-1"></i> ZIP Archive</span>
                <span class="export-badge"><i class="fas fa-chart-simple me-1"></i> Complete</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Export -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="modal-export-icon" id="modalIcon">
                        <i class="fas fa-file-csv" style="color: #6366f1; font-size: 24px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold" id="exportModalLabel">Export Data</h5>
                        <p class="text-muted small mb-0" id="modalDesc">Pilih format export</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Pilih Format</label>
                        <div class="d-flex gap-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="format" id="formatCSV" value="csv" checked>
                                <label class="form-check-label" for="formatCSV">
                                    <i class="fas fa-file-csv text-success me-1"></i> CSV
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="format" id="formatExcel" value="excel" disabled>
                                <label class="form-check-label text-muted" for="formatExcel">
                                    <i class="fas fa-file-excel text-success me-1"></i> Excel (Premium)
                                </label>
                            </div>
                        </div>
                        <small class="text-muted">CSV dapat dibuka dengan Excel, Google Sheets, atau aplikasi spreadsheet lainnya.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="confirmExportBtn">
                    <i class="fas fa-download me-2"></i> Export Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="mb-0">Sedang memproses export...</p>
            </div>
        </div>
    </div>
</div>

<script>
    let currentType = '';
    
    function showExportModal(type) {
        currentType = type;
        const titles = {
            'kredit': 'Export Data Kredit',
            'motor': 'Export Data Motor',
            'angsuran': 'Export Data Angsuran',
            'pelanggan': 'Export Data Pelanggan',
            'pengajuan': 'Export Data Pengajuan'
        };
        
        const descs = {
            'kredit': 'Data kredit aktif, lunas, dan macet',
            'motor': 'Data inventaris motor, stok, dan harga',
            'angsuran': 'Data angsuran, status, dan riwayat bayar',
            'pelanggan': 'Data pelanggan dan kontak',
            'pengajuan': 'Data pengajuan kredit pelanggan'
        };
        
        const icons = {
            'kredit': 'credit-card',
            'motor': 'motorcycle',
            'angsuran': 'receipt',
            'pelanggan': 'users',
            'pengajuan': 'file-invoice'
        };
        
        document.getElementById('exportModalLabel').innerText = titles[type];
        document.getElementById('modalDesc').innerHTML = descs[type];
        document.getElementById('modalIcon').innerHTML = `<i class="fas fa-${icons[type]}" style="color: #6366f1; font-size: 24px;"></i>`;
        
        new bootstrap.Modal(document.getElementById('exportModal')).show();
    }
    
    function showExportAll() {
        Swal.fire({
            title: 'Export Semua Data',
            html: `
                <div class="text-start">
                    <p>Anda akan mengexport semua data:</p>
                    <ul>
                        <li>Data Kredit</li>
                        <li>Data Motor</li>
                        <li>Data Angsuran</li>
                        <li>Data Pelanggan</li>
                        <li>Data Pengajuan</li>
                    </ul>
                    <p class="text-warning"><i class="fas fa-info-circle me-2"></i>Proses ini mungkin memakan waktu beberapa menit.</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            confirmButtonText: 'Ya, Export Semua',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("ceo.export.all") }}';
            }
        });
    }
    
    document.getElementById('confirmExportBtn').addEventListener('click', function() {
        const format = document.querySelector('input[name="format"]:checked').value;
        
        document.getElementById('exportType').value = currentType;
        document.getElementById('exportFormat').value = format;
        
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();
        
        const form = document.getElementById('exportForm');
        form.action = '{{ route("ceo.export.process") }}';
        form.submit();
    });
    
    function resetFilter() {
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
    }
    
    // SweetAlert for flash messages
    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonColor: '#6366f1'
        });
    @endif
    
    @if(session('error'))
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonColor: '#dc2626'
        });
    @endif
</script>
@endsection
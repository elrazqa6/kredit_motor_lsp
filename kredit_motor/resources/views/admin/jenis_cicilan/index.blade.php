@extends('layouts.admin')

@section('title', 'Jenis Cicilan')
@section('page-title', 'Manajemen Jenis Cicilan')

@push('styles')
<style>
    .table-container {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .btn-action {
        padding: 4px 8px;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .search-box {
        position: relative;
    }
    .search-box input {
        padding-left: 40px;
        border-radius: 40px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
    }
    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
    .modal-content {
        border-radius: 20px;
        border: none;
    }
    .modal-header {
        border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px 20px 0 0;
    }
    .btn-close-white {
        filter: brightness(0) invert(1);
    }
    .form-control, .form-select {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 10px 16px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 10px 24px;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }
    .table th {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        padding: 15px 12px;
    }
    .table td {
        padding: 15px 12px;
        font-size: 13px;
        vertical-align: middle;
    }
    .badge-info {
        background: #dbeafe;
        color: #2563eb;
        padding: 5px 12px;
        border-radius: 99px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-12">
        <!-- Header with Actions -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 fw-bold">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i> Jenis Cicilan
                </h4>
                <p class="text-muted mb-0">Kelola tenor dan margin kredit</p>
            </div>
            <div class="mt-2 mt-sm-0">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCicilanModal">
                    <i class="fas fa-plus me-2"></i> Tambah Jenis Cicilan
                </button>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6 col-lg-4">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari lama cicilan...">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <select id="perPageSelect" class="form-select">
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                    </div>
                    <div class="col-md-12 col-lg-5 text-end">
                        <span class="text-muted small" id="totalCount">
                            Total: {{ $jenisCicilan->total() }} data
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="ps-4">No</th>
                            <th width="30%">Lama Cicilan</th>
                            <th width="30%">Margin Kredit</th>
                            <th width="25%">Tanggal Dibuat</th>
                            <th width="10%" class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($jenisCicilan as $index => $item)
                        <tr data-id="{{ $item->id }}" data-name="{{ $item->lama_cicilan }}">
                            <td class="ps-4">{{ $index + $jenisCicilan->firstItem() }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-soft-primary rounded-circle p-2" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-clock text-primary"></i>
                                    </div>
                                    <div>
                                        <span class="fw-semibold">{{ $item->lama_cicilan }} bulan</span>
                                        <div class="small text-muted">{{ number_format($item->lama_cicilan / 12, 1) }} tahun</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-info">
                                    {{ $item->margin_kredit }}%
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}
                                </small>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-primary btn-action edit-btn"
                                            data-id="{{ $item->id }}"
                                            data-lama="{{ $item->lama_cicilan }}"
                                            data-margin="{{ $item->margin_kredit }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-action delete-btn"
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->lama_cicilan }} bulan">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
                                    <h5 class="fw-semibold">Belum Ada Data</h5>
                                    <p class="text-muted">Silakan tambah jenis cicilan baru</p>
                                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addCicilanModal">
                                        <i class="fas fa-plus me-2"></i> Tambah Jenis Cicilan
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted small">
                Menampilkan {{ $jenisCicilan->firstItem() ?? 0 }} - {{ $jenisCicilan->lastItem() ?? 0 }} dari {{ $jenisCicilan->total() }} data
            </div>
            <div>
                {{ $jenisCicilan->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Jenis Cicilan -->
<div class="modal fade" id="addCicilanModal" tabindex="-1" aria-labelledby="addCicilanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addCicilanModalLabel">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Jenis Cicilan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.jenis-cicilan.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-clock me-1 text-primary"></i> Lama Cicilan (Bulan)
                        </label>
                        <div class="row g-2">
                            <div class="col-8">
                                <input type="number" name="lama_cicilan" class="form-control" placeholder="Contoh: 12, 24, 36" required min="1" max="120">
                            </div>
                            <div class="col-4">
                                <select id="lamaCicilanPreset" class="form-select">
                                    <option value="">Pilih Preset</option>
                                    <option value="12">12 bulan (1 tahun)</option>
                                    <option value="24">24 bulan (2 tahun)</option>
                                    <option value="36">36 bulan (3 tahun)</option>
                                    <option value="48">48 bulan (4 tahun)</option>
                                </select>
                            </div>
                        </div>
                        <small class="text-muted">Lama cicilan dalam bulan (min 1, max 120)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-chart-line me-1 text-primary"></i> Margin Kredit (%)
                        </label>
                        <div class="input-group">
                            <input type="number" name="margin_kredit" class="form-control" placeholder="Contoh: 8.5" required step="0.01" min="0" max="100">
                            <span class="input-group-text bg-light">%</span>
                        </div>
                        <small class="text-muted">Persentase margin/bunga per tahun</small>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Jenis Cicilan -->
<div class="modal fade" id="editCicilanModal" tabindex="-1" aria-labelledby="editCicilanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editCicilanModalLabel">
                    <i class="fas fa-edit me-2"></i> Edit Jenis Cicilan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-clock me-1 text-primary"></i> Lama Cicilan (Bulan)
                        </label>
                        <input type="number" name="lama_cicilan" id="editLamaCicilan" class="form-control" required min="1" max="120">
                        <small class="text-muted">Lama cicilan dalam bulan</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-chart-line me-1 text-primary"></i> Margin Kredit (%)
                        </label>
                        <div class="input-group">
                            <input type="number" name="margin_kredit" id="editMarginKredit" class="form-control" required step="0.01" min="0" max="100">
                            <span class="input-group-text bg-light">%</span>
                        </div>
                        <small class="text-muted">Persentase margin/bunga per tahun</small>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary {
        background: rgba(102, 126, 234, 0.1);
    }
    .badge-info {
        background: #dbeafe;
        color: #2563eb;
        padding: 5px 12px;
        border-radius: 99px;
        font-weight: 600;
        font-size: 13px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preset untuk lama cicilan
    const lamaPreset = document.getElementById('lamaCicilanPreset');
    const lamaInput = document.querySelector('input[name="lama_cicilan"]');
    
    if (lamaPreset) {
        lamaPreset.addEventListener('change', function() {
            if (this.value) {
                lamaInput.value = this.value;
            }
        });
    }
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(value)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            document.getElementById('totalCount').innerText = `Menampilkan ${visibleCount} dari ${rows.length} data`;
        });
    }
    
    // Per Page functionality
    const perPageSelect = document.getElementById('perPageSelect');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            window.location.href = '{{ route("admin.jenis-cicilan.index") }}?per_page=' + this.value;
        });
    }
    
    // Edit button click
    const editBtns = document.querySelectorAll('.edit-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const lama = this.dataset.lama;
            const margin = this.dataset.margin;
            
            document.getElementById('editLamaCicilan').value = lama;
            document.getElementById('editMarginKredit').value = margin;
            document.getElementById('editForm').action = '{{ route("admin.jenis-cicilan.index") }}/' + id;
            
            new bootstrap.Modal(document.getElementById('editCicilanModal')).show();
        });
    });
    
    // Delete button click
    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            
            Swal.fire({
                title: 'Hapus Jenis Cicilan?',
                html: `Apakah Anda yakin ingin menghapus <strong>${name}</strong>?<br><small class="text-muted">Data pengajuan yang menggunakan cicilan ini tidak akan terhapus.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("admin.jenis-cicilan.index") }}/' + id;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
    
    // Success message
    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonColor: '#667eea',
            timer: 3000,
            showConfirmButton: true
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
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
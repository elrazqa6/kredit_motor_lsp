@extends('layouts.admin')

@section('title', 'Data Asuransi')
@section('page-title', 'Manajemen Asuransi')

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
    .logo-preview {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        object-fit: cover;
        background: #f1f5f9;
        padding: 5px;
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
    .status-badge {
        display: inline-flex;
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-active {
        background: #d1fae5;
        color: #059669;
    }
    .badge-inactive {
        background: #fee2e2;
        color: #dc2626;
    }
    .image-upload-preview {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px dashed #e2e8f0;
        padding: 5px;
        cursor: pointer;
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
                    <i class="fas fa-shield-alt me-2 text-primary"></i> Data Asuransi
                </h4>
                <p class="text-muted mb-0">Kelola data asuransi motor</p>
            </div>
            <div class="mt-2 mt-sm-0">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAsuransiModal">
                    <i class="fas fa-plus me-2"></i> Tambah Asuransi
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
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari asuransi...">
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
                            Total: {{ $asuransi->total() }} data
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="ps-4">No</th>
                            <th width="10%">Logo</th>
                            <th width="20%">Nama Asuransi</th>
                            <th width="15%">Perusahaan</th>
                            <th width="10%">Biaya</th>
                            <th width="10%">Margin</th>
                            <th width="15%">No. Rekening</th>
                            <th width="10%">Status</th>
                            <th width="10%" class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($asuransi as $index => $item)
                        <tr data-id="{{ $item->id }}" data-name="{{ $item->nama_asuransi }}">
                            <td class="ps-4">{{ $index + $asuransi->firstItem() }}</td>
                            <td>
                                @if($item->url_logo)
                                    <img src="{{ asset('storage/'.$item->url_logo) }}" 
                                         class="logo-preview" 
                                         alt="{{ $item->nama_asuransi }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-building text-muted fa-lg"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $item->nama_asuransi }}</div>
                                <small class="text-muted">ID: #{{ $item->id }}</small>
                            </td>
                            <td>{{ $item->nama_perusahaan }}</td>
                            <td>
                                <span class="fw-semibold text-primary">
                                    Rp {{ number_format($item->biaya, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                    {{ $item->margin_asuransi }}%
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $item->no_rekening ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="status-badge {{ $item->status == 'aktif' ? 'badge-active' : 'badge-inactive' }}">
                                    {{ ucfirst($item->status ?? 'Aktif') }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-primary btn-action edit-btn"
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama_asuransi }}"
                                            data-perusahaan="{{ $item->nama_perusahaan }}"
                                            data-biaya="{{ $item->biaya }}"
                                            data-margin="{{ $item->margin_asuransi }}"
                                            data-rekening="{{ $item->no_rekening }}"
                                            data-logo="{{ $item->url_logo }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-action delete-btn"
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->nama_asuransi }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-shield-alt fa-4x text-muted mb-3"></i>
                                    <h5 class="fw-semibold">Belum Ada Data</h5>
                                    <p class="text-muted">Silakan tambah data asuransi baru</p>
                                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addAsuransiModal">
                                        <i class="fas fa-plus me-2"></i> Tambah Asuransi
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
                Menampilkan {{ $asuransi->firstItem() ?? 0 }} - {{ $asuransi->lastItem() ?? 0 }} dari {{ $asuransi->total() }} data
            </div>
            <div>
                {{ $asuransi->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Asuransi -->
<div class="modal fade" id="addAsuransiModal" tabindex="-1" aria-labelledby="addAsuransiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addAsuransiModalLabel">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Asuransi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.asuransi.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-building me-1 text-primary"></i> Nama Asuransi
                            </label>
                            <input type="text" name="nama_asuransi" class="form-control" placeholder="Contoh: Asuransi XYZ" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-industry me-1 text-primary"></i> Nama Perusahaan
                            </label>
                            <input type="text" name="nama_perusahaan" class="form-control" placeholder="Nama perusahaan asuransi" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-money-bill-wave me-1 text-primary"></i> Biaya (Rp)
                            </label>
                            <input type="number" name="biaya" class="form-control" placeholder="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-chart-line me-1 text-primary"></i> Margin Asuransi (%)
                            </label>
                            <input type="number" name="margin_asuransi" class="form-control" placeholder="0" step="0.01" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-credit-card me-1 text-primary"></i> No. Rekening
                            </label>
                            <input type="text" name="no_rekening" class="form-control" placeholder="Nomor rekening perusahaan">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-image me-1 text-primary"></i> Logo Asuransi
                            </label>
                            <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewImage(this, 'addLogoPreview')">
                            <small class="text-muted">Format: JPG, PNG, SVG (Max 2MB)</small>
                            <div class="mt-2">
                                <img id="addLogoPreview" class="image-upload-preview" style="display: none;">
                            </div>
                        </div>
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

<!-- Modal Edit Asuransi -->
<div class="modal fade" id="editAsuransiModal" tabindex="-1" aria-labelledby="editAsuransiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editAsuransiModalLabel">
                    <i class="fas fa-edit me-2"></i> Edit Asuransi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="editForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-building me-1 text-primary"></i> Nama Asuransi
                            </label>
                            <input type="text" name="nama_asuransi" id="editNamaAsuransi" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-industry me-1 text-primary"></i> Nama Perusahaan
                            </label>
                            <input type="text" name="nama_perusahaan" id="editNamaPerusahaan" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-money-bill-wave me-1 text-primary"></i> Biaya (Rp)
                            </label>
                            <input type="number" name="biaya" id="editBiaya" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-chart-line me-1 text-primary"></i> Margin Asuransi (%)
                            </label>
                            <input type="number" name="margin_asuransi" id="editMargin" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-credit-card me-1 text-primary"></i> No. Rekening
                            </label>
                            <input type="text" name="no_rekening" id="editNoRekening" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-image me-1 text-primary"></i> Logo Asuransi
                            </label>
                            <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewImage(this, 'editLogoPreview')">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah logo</small>
                            <div class="mt-2">
                                <img id="editLogoPreview" class="image-upload-preview" style="display: none;">
                                <div id="currentLogo" class="mt-2"></div>
                            </div>
                        </div>
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
    .image-upload-preview {
        width: 100px;
        height: 100px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        padding: 5px;
    }
    .logo-preview {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        object-fit: cover;
        background: #f1f5f9;
        padding: 5px;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }
    .table th {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }
    .table td {
        font-size: 13px;
    }
</style>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function() {
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
            window.location.href = '{{ route("admin.asuransi.index") }}?per_page=' + this.value;
        });
    }
    
    // Edit button click
    const editBtns = document.querySelectorAll('.edit-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const perusahaan = this.dataset.perusahaan;
            const biaya = this.dataset.biaya;
            const margin = this.dataset.margin;
            const rekening = this.dataset.rekening;
            const logo = this.dataset.logo;
            
            document.getElementById('editNamaAsuransi').value = nama;
            document.getElementById('editNamaPerusahaan').value = perusahaan;
            document.getElementById('editBiaya').value = biaya;
            document.getElementById('editMargin').value = margin;
            document.getElementById('editNoRekening').value = rekening;
            
            if (logo) {
                document.getElementById('currentLogo').innerHTML = `
                    <div class="mt-2">
                        <small class="text-muted">Logo saat ini:</small>
                        <img src="{{ asset('storage') }}/${logo}" class="image-upload-preview mt-1">
                    </div>
                `;
            } else {
                document.getElementById('currentLogo').innerHTML = '';
            }
            
            document.getElementById('editForm').action = '{{ route("admin.asuransi.index") }}/' + id;
            new bootstrap.Modal(document.getElementById('editAsuransiModal')).show();
        });
    });
    
    // Delete button click
    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            
            Swal.fire({
                title: 'Hapus Asuransi?',
                html: `Apakah Anda yakin ingin menghapus <strong>${name}</strong>?<br><small class="text-muted">Data terkait akan terpengaruh.</small>`,
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
                    form.action = '{{ route("admin.asuransi.index") }}/' + id;
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
            timer: 3000
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
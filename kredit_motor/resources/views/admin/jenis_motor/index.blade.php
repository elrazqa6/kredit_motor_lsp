@extends('layouts.admin')

@section('title', 'Jenis Motor')
@section('page-title', 'Manajemen Jenis Motor')

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
    .status-badge {
        display: inline-flex;
        padding: 4px 10px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-active {
        background: #d1fae5;
        color: #059669;
    }
    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
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
    .filter-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 16px;
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-12">
        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 fw-bold">
                    <i class="fas fa-tags me-2 text-primary"></i> Data Jenis Motor
                </h4>
                <p class="text-muted mb-0">Kelola jenis-jenis motor yang tersedia</p>
            </div>
            <div class="mt-2 mt-sm-0">
                <a href="{{ route('admin.jenis-motor.create') }}" class="btn btn-primary rounded-pill">
                    <i class="fas fa-plus me-2"></i> Tambah Jenis Motor
                </a>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="filter-card mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-lg-3">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari jenis motor...">
                    </div>
                </div>
                <div class="col-md-3 col-lg-2">
                    <select id="statusFilter" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-2 col-lg-2">
                    <select id="perPageSelect" class="form-select">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
                <div class="col-md-12 col-lg-5 text-end">
                    <button id="resetFilter" class="btn btn-outline-secondary rounded-pill">
                        <i class="fas fa-redo-alt me-1"></i> Reset Filter
                    </button>
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
                            <th width="30%">Nama Jenis</th>
                            <th width="40%">Keterangan</th>
                            <th width="10%">Status</th>
                            <th width="15%" class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($jenisMotor as $index => $item)
                        <tr data-status="{{ $item->is_active ? 'active' : 'inactive' }}"
                            data-search="{{ strtolower($item->nama_jenis) }} {{ strtolower($item->keterangan ?? '') }}">
                            <td class="ps-4">{{ $index + $jenisMotor->firstItem() }}</td>
                            <td class="fw-semibold">{{ $item->nama_jenis }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td>
                                <span class="status-badge {{ $item->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-info btn-action toggle-status-btn"
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->nama_jenis }}"
                                            data-status="{{ $item->is_active ? 'active' : 'inactive' }}"
                                            title="Ubah Status">
                                        <i class="fas {{ $item->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-action delete-btn"
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->nama_jenis }}"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                                    <h5 class="fw-semibold">Belum Ada Data</h5>
                                    <p class="text-muted">Silakan tambah jenis motor baru</p>
                                    <a href="{{ route('admin.jenis-motor.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus me-2"></i> Tambah Jenis Motor
                                    </a>
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
                Menampilkan {{ $jenisMotor->firstItem() ?? 0 }} - {{ $jenisMotor->lastItem() ?? 0 }} dari {{ $jenisMotor->total() }} data
            </div>
            <div>
                {{ $jenisMotor->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==========================================
    // SEARCH & FILTER
    // ==========================================
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const resetBtn = document.getElementById('resetFilter');
    const perPageSelect = document.getElementById('perPageSelect');
    
    function filterTable() {
        const searchTerm = searchInput?.value.toLowerCase() || '';
        const statusValue = statusFilter?.value || '';
        const rows = document.querySelectorAll('#tableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            let show = true;
            const text = row.dataset.search || '';
            const status = row.dataset.status || '';
            
            if (searchTerm && !text.includes(searchTerm)) show = false;
            if (statusValue && status !== statusValue) show = false;
            
            if (show) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        let noResult = document.getElementById('noResultMsg');
        if (visibleCount === 0 && rows.length > 0) {
            if (!noResult) {
                noResult = document.createElement('tr');
                noResult.id = 'noResultMsg';
                noResult.innerHTML = `
                    <td colspan="5" class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h6 class="fw-semibold">Tidak ada data ditemukan</h6>
                        <p class="text-muted small">Coba dengan kata kunci yang berbeda</p>
                    </td>
                `;
                document.getElementById('tableBody').appendChild(noResult);
            }
        } else if (noResult) {
            noResult.remove();
        }
    }
    
    if (searchInput) searchInput.addEventListener('keyup', filterTable);
    if (statusFilter) statusFilter.addEventListener('change', filterTable);
    
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (statusFilter) statusFilter.value = '';
            filterTable();
        });
    }
    
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', this.value);
            window.location.href = url.toString();
        });
    }
    
    // ==========================================
    // TOGGLE STATUS
    // ==========================================
    const toggleBtns = document.querySelectorAll('.toggle-status-btn');
    
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const currentStatus = this.dataset.status;
            const newStatus = currentStatus === 'active' ? 'nonaktif' : 'aktif';
            
            Swal.fire({
                title: 'Ubah Status?',
                html: `Apakah Anda yakin ingin mengubah status <strong>${name}</strong> menjadi <strong>${newStatus}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6366f1',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Ubah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/jenis-motor/${id}/toggle`;
                }
            });
        });
    });
    
    // ==========================================
    // DELETE
    // ==========================================
    const deleteBtns = document.querySelectorAll('.delete-btn');
    
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            
            Swal.fire({
                title: 'Hapus Jenis Motor?',
                html: `Apakah Anda yakin ingin menghapus <strong>${name}</strong>?<br><small class="text-muted">Data yang dihapus tidak dapat dikembalikan.</small>`,
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
                    form.action = `{{ route("admin.jenis-motor.index") }}/${id}`;
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
    
    // ==========================================
    // NOTIFICATIONS
    // ==========================================
    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonColor: '#6366f1',
            timer: 3000,
            timerProgressBar: true
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
@endsection
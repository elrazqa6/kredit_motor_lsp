@extends('layouts.marketing')

@section('title', 'Data Angsuran')
@section('page-title', 'Manajemen Angsuran')

@push('styles')
<style>
    .status-badge {
        display: inline-flex;
        padding: 5px 12px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .badge-success { background: #d1fae5; color: #059669; }
    .badge-warning { background: #fef3c7; color: #d97706; }
    .badge-danger { background: #fee2e2; color: #dc2626; }
    .badge-info { background: #dbeafe; color: #2563eb; }
    
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
    .bg-soft-primary {
        background: rgba(102, 126, 234, 0.1);
    }
    .badge-status {
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .badge-lunas { background: #d1fae5; color: #059669; }
    .badge-belum { background: #fef3c7; color: #d97706; }
    .badge-telat { background: #fee2e2; color: #dc2626; }
    
    /* Highlight untuk yang telat */
    .tr-telat {
        background-color: #fef2f2 !important;
    }
    .tr-telat:hover {
        background-color: #fee2e2 !important;
    }
    .tr-hampir {
        background-color: #fffbeb !important;
    }
    .tr-hampir:hover {
        background-color: #fef3c7 !important;
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
                    <i class="fas fa-receipt me-2 text-primary"></i> Data Angsuran
                </h4>
                <p class="text-muted mb-0">Kelola data angsuran kredit pelanggan</p>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4 col-lg-3">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari pelanggan atau motor...">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <select id="statusFilter" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Lunas">Lunas</option>
                            <option value="Belum Bayar">Belum Bayar</option>
                            <option value="Telat">Telat</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <input type="month" id="monthFilter" class="form-control" placeholder="Filter Bulan">
                    </div>
                    <div class="col-md-2 col-lg-2">
                        <select id="perPageSelect" class="form-select">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 per page</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                        </select>
                    </div>
                    <div class="col-md-12 col-lg-3 text-end">
                        <button id="resetFilter" class="btn btn-outline-secondary rounded-pill w-100 w-lg-auto">
                            <i class="fas fa-redo-alt me-1"></i> Reset Filter
                        </button>
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
                            <th width="14%">Pelanggan</th>
                            <th width="14%">Motor</th>
                            <th width="7%">Angsuran Ke</th>
                            <th width="12%">Jatuh Tempo</th>
                            <th width="10%">Tgl Bayar</th>
                            <th width="10%">Total Bayar</th>
                            <th width="8%">Status</th>
                            <th width="10%">Keterangan</th>
                            <th width="10%" class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($angsuran as $index => $item)
                        @php
                            // Hitung status
                            $isLunas = !is_null($item->tgl_bayar);
                            $status = '';
                            $statusClass = '';
                            $rowClass = '';
                            
                            if ($isLunas) {
                                $status = 'Lunas';
                                $statusClass = 'badge-lunas';
                            } else {
                                $jatuhTempo = \Carbon\Carbon::parse($item->tgl_jatuh_tempo);
                                $now = \Carbon\Carbon::now();
                                
                                if ($jatuhTempo < $now) {
                                    $status = 'Telat';
                                    $statusClass = 'badge-telat';
                                    $rowClass = 'tr-telat';
                                } elseif ($jatuhTempo->diffInDays($now) <= 7) {
                                    $status = 'Hampir JT';
                                    $statusClass = 'badge-warning';
                                    $rowClass = 'tr-hampir';
                                } else {
                                    $status = 'Belum Bayar';
                                    $statusClass = 'badge-belum';
                                }
                            }
                        @endphp
                        <tr data-status="{{ $status }}" 
                            data-bulan="{{ $item->tgl_jatuh_tempo ? \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('Y-m') : '' }}"
                            class="{{ $rowClass }}">
                            <td class="ps-4">{{ $index + $angsuran->firstItem() }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-soft-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $item->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '-' }}</div>
                                        <small class="text-muted">{{ $item->kredit->pengajuanKredit->pelanggan->no_telp ?? '-' }}</small>
                                    </div>
                                </div>
                             </div>
                            <td>
                                <div class="fw-semibold">{{ $item->kredit->pengajuanKredit->motor->nama_motor ?? '-' }}</div>
                                <small class="text-muted">{{ $item->kredit->pengajuanKredit->motor->merk ?? '-' }}</small>
                             </div>
                            <td>
                                <div class="fw-bold text-primary">{{ $item->angsuran_ke }}</div>
                                <small class="text-muted">/ {{ $item->kredit->pengajuanKredit->tenor }}</small>
                             </div>
                            <td>
                                <div>
                                    <span class="fw-semibold {{ $status == 'Telat' ? 'text-danger' : ($status == 'Hampir JT' ? 'text-warning' : '') }}">
                                        {{ $item->tgl_jatuh_tempo ? \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d/m/Y') : '-' }}
                                    </span>
                                    @if(!$isLunas && $item->tgl_jatuh_tempo)
                                        @php
                                            $sisaHari = \Carbon\Carbon::today()->diffInDays($item->tgl_jatuh_tempo, false);
                                        @endphp
                                        @if($sisaHari < 0)
                                            <br><small class="text-danger">Terlambat {{ abs($sisaHari) }} hari</small>
                                        @elseif($sisaHari <= 7)
                                            <br><small class="text-warning">{{ $sisaHari }} hari lagi</small>
                                        @endif
                                    @endif
                                </div>
                             </div>
                            <td>
                                <div>{{ $item->tgl_bayar ? \Carbon\Carbon::parse($item->tgl_bayar)->format('d/m/Y') : '-' }}</div>
                                <small class="text-muted">{{ $item->tgl_bayar ? \Carbon\Carbon::parse($item->tgl_bayar)->format('H:i') : '' }}</small>
                             </div>
                            <td>
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                </span>
                             </div>
                            <td>
                                <span class="badge-status {{ $statusClass }}">
                                    {{ $status }}
                                </span>
                             </div>
                            <td>
                                <small class="text-muted">{{ Str::limit($item->keterangan ?? '-', 30) }}</small>
                             </div>
                            <td class="text-center pe-4">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('marketing.angsuran.show', $item->id) }}" 
                                       class="btn btn-sm btn-outline-primary btn-action"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-action delete-btn"
                                            data-id="{{ $item->id }}"
                                            data-name="Angsuran ke-{{ $item->angsuran_ke }}"
                                            data-pelanggan="{{ $item->kredit->pengajuanKredit->pelanggan->nama_pelanggan ?? '' }}"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                             </div>
                         </div>
                        @empty
                         <tr>
                            <td colspan="10" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
                                    <h5 class="fw-semibold">Belum Ada Data Angsuran</h5>
                                    <p class="text-muted">Belum ada data angsuran</p>
                                </div>
                             </div>
                         </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted small">
                Menampilkan {{ $angsuran->firstItem() ?? 0 }} - {{ $angsuran->lastItem() ?? 0 }} dari {{ $angsuran->total() }} data
            </div>
            <div>
                {{ $angsuran->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const monthFilter = document.getElementById('monthFilter');
    const resetBtn = document.getElementById('resetFilter');
    const perPageSelect = document.getElementById('perPageSelect');
    
    function filterTable() {
        const searchTerm = searchInput?.value.toLowerCase() || '';
        const statusValue = statusFilter?.value || '';
        const monthValue = monthFilter?.value || '';
        const rows = document.querySelectorAll('#tableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            let show = true;
            const text = row.textContent.toLowerCase();
            const status = row.dataset.status;
            const bulan = row.dataset.bulan;
            
            if (searchTerm && !text.includes(searchTerm)) show = false;
            if (statusValue && status !== statusValue) show = false;
            if (monthValue && bulan !== monthValue) show = false;
            
            if (show) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    if (searchInput) searchInput.addEventListener('keyup', filterTable);
    if (statusFilter) statusFilter.addEventListener('change', filterTable);
    if (monthFilter) monthFilter.addEventListener('change', filterTable);
    
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (statusFilter) statusFilter.value = '';
            if (monthFilter) monthFilter.value = '';
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
    
    // Delete button
    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const pelanggan = this.dataset.pelanggan;
            
            Swal.fire({
                title: 'Hapus Angsuran?',
                html: `Apakah Anda yakin ingin menghapus <strong>${name}</strong> atas nama <strong>${pelanggan}</strong>?<br><small class="text-muted">Data yang dihapus tidak dapat dikembalikan.</small>`,
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
                    form.action = '{{ route("marketing.angsuran.index") }}/' + id;
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
    
    // Success/Error messages
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
@endsection
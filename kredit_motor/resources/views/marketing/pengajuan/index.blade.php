@extends('layouts.marketing')

@section('title', 'Data Pengajuan Kredit')
@section('page-title', 'Manajemen Pengajuan Kredit')

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
    .badge-menunggu { background: #fef3c7; color: #d97706; }
    .badge-disetujui { background: #d1fae5; color: #059669; }
    .badge-ditolak { background: #fee2e2; color: #dc2626; }
    
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
    .avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
        color: #667eea;
        flex-shrink: 0;
    }
    .filter-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 16px;
    }
    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 16px;
        text-align: center;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
    .bg-soft-primary { background: rgba(102, 126, 234, 0.1); }
    .rounded-circle-custom {
        width: 45px;
        height: 45px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
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
                     Data Pengajuan Kredit
                </h4>
                <p class="text-muted mb-0">Kelola dan verifikasi pengajuan kredit dari pelanggan</p>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="bg-soft-warning rounded-circle-custom mb-2">
                        <i class="fas fa-clock fa-xl text-warning"></i>
                    </div>
                    <h5 class="fw-bold mb-0 text-warning" id="statMenunggu">0</h5>
                    <small class="text-muted">Menunggu Konfirmasi</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="bg-soft-success rounded-circle-custom mb-2">
                        <i class="fas fa-check-circle fa-xl text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-0 text-success" id="statDisetujui">0</h5>
                    <small class="text-muted">Disetujui</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="bg-soft-danger rounded-circle-custom mb-2">
                        <i class="fas fa-times-circle fa-xl text-danger"></i>
                    </div>
                    <h5 class="fw-bold mb-0 text-danger" id="statDitolak">0</h5>
                    <small class="text-muted">Ditolak</small>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="bg-soft-primary rounded-circle-custom mb-2">
                        <i class="fas fa-chart-line fa-xl text-primary"></i>
                    </div>
                    <h5 class="fw-bold mb-0 text-primary" id="statTotal">0</h5>
                    <small class="text-muted">Total Pengajuan</small>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="filter-card mb-4">
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
                        <option value="Menunggu">Menunggu Konfirmasi</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3 col-lg-2">
                    <input type="date" id="dateFilter" class="form-control" placeholder="Filter Tanggal">
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

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="ps-4">No</th>
                            <th width="12%">Tgl Pengajuan</th>
                            <th width="18%">Pelanggan</th>
                            <th width="18%">Motor</th>
                            <th width="10%">Cicilan/Bulan</th>
                            <th width="12%">Status</th>
                            <th width="10%">Status DP</th>
                            <th width="10%" class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
             <tbody id="tableBody">
    @forelse($pengajuan as $index => $item)
    <tr data-status="{{ $item->status_pengajuan }}" 
        data-tanggal="{{ \Carbon\Carbon::parse($item->tgl_pengajuan_kredit)->format('Y-m-d') }}"
        data-search="{{ strtolower($item->pelanggan->nama_pelanggan ?? '') }} {{ strtolower($item->motor->nama_motor ?? '') }}">
        <td class="ps-4">{{ $index + $pengajuan->firstItem() }}</td>
        <td>
            <div class="fw-semibold">{{ \Carbon\Carbon::parse($item->tgl_pengajuan_kredit)->format('d/m/Y') }}</div>
            <small class="text-muted">{{ \Carbon\Carbon::parse($item->tgl_pengajuan_kredit)->format('H:i') }}</small>
        </td>
        <td>
            <div class="d-flex align-items-center gap-2">
                <div class="avatar d-flex align-items-center justify-content-center">
                    {{ strtoupper(substr($item->pelanggan->nama_pelanggan ?? 'U', 0, 2)) }}
                </div>
                <div>
                    <div class="fw-semibold">{{ $item->pelanggan->nama_pelanggan ?? '-' }}</div>
                    <small class="text-muted">{{ $item->pelanggan->no_telp ?? '-' }}</small>
                </div>
            </div>
        </td>
        <td>
            <div class="fw-semibold">{{ $item->motor->nama_motor ?? '-' }}</div>
            <small class="text-muted">{{ $item->motor->merk ?? '-' }}</small>
        </td>
        <td>
            <span class="fw-bold text-success">
                Rp {{ number_format($item->cicilan_perbulan, 0, ',', '.') }}
            </span>
            <br>
            <small class="text-muted">Tenor: {{ $item->tenor }} bulan</small>
        </td>
        
        {{-- STATUS PENGAJUAN --}}
        <td>
            @php
                $badgeClass = '';
                $icon = '';
                $statusText = '';
                if ($item->status_pengajuan == 'Menunggu') {
                    $badgeClass = 'badge-menunggu';
                    $icon = 'clock';
                    $statusText = 'Menunggu Konfirmasi';
                } elseif ($item->status_pengajuan == 'Disetujui') {
                    $badgeClass = 'badge-disetujui';
                    $icon = 'check-circle';
                    $statusText = 'Disetujui';
                } else {
                    $badgeClass = 'badge-ditolak';
                    $icon = 'times-circle';
                    $statusText = 'Ditolak';
                }
            @endphp
            <span class="status-badge {{ $badgeClass }}">
                <i class="fas fa-{{ $icon }} me-1"></i>
                {{ $statusText }}
            </span>
        </td>
       {{-- ═══ STATUS DP (DENGAN TOMBOL EDIT UNTUK SEMUA STATUS) ═══ --}}
<td class="text-center">
    <div class="d-flex flex-column align-items-center gap-1">
        @php
            $dpStatus = $item->status_dp ?? 'Belum Bayar';
            if ($dpStatus == 'Lunas') {
                $dpBadgeClass = 'badge-disetujui';
                $dpIcon = 'check-circle';
                $dpText = 'Lunas ';
            } elseif ($dpStatus == 'Menunggu') {
                $dpBadgeClass = 'badge-menunggu';
                $dpIcon = 'clock';
                $dpText = 'Menunggu Verifikasi';
            } elseif ($dpStatus == 'Ditolak') {
                $dpBadgeClass = 'badge-ditolak';
                $dpIcon = 'times-circle';
                $dpText = 'DP Ditolak ❌';
            } else {
                $dpBadgeClass = 'badge-secondary';
                $dpIcon = 'clock';
                $dpText = 'Belum Bayar';
            }
        @endphp
        
        <span class="status-badge {{ $dpBadgeClass }}">
            <i class="fas fa-{{ $dpIcon }} me-1"></i>
            {{ $dpText }}
        </span>
        
        @if($item->bukti_dp)
            <small class="text-muted">
                <a href="{{ asset('storage/'.$item->bukti_dp) }}" target="_blank" class="text-primary">
                    <i class="fas fa-image me-1"></i> Lihat Bukti
                </a>
            </small>
        @endif
        
        {{-- TOMBOL EDIT STATUS DP (MUNCUL UNTUK SEMUA STATUS) --}}
        <button type="button" 
                class="btn btn-sm btn-outline-info mt-1 edit-status-dp-btn"
                data-id="{{ $item->id }}"
                data-status="{{ $dpStatus }}"
                data-pelanggan="{{ $item->pelanggan->nama_pelanggan ?? '-' }}"
                data-nominal="{{ number_format($item->uang_muka, 0, ',', '.') }}"
                data-bukti="{{ $item->bukti_dp ? asset('storage/'.$item->bukti_dp) : '' }}"
                data-keterangan="{{ $item->keterangan_dp ?? '' }}"
                data-bs-toggle="modal"
                data-bs-target="#editStatusDpModal"
                title="Ubah Status DP">
            <i class="fas fa-edit me-1"></i> Edit DP
        </button>
    </div>
</div>
        
        {{-- AKSI --}}
        <td class="text-center pe-4">
            <div class="d-flex gap-1 justify-content-center">
                <a href="{{ route('marketing.pengajuan.show', $item->id) }}" 
                   class="btn btn-sm btn-outline-primary btn-action"
                   title="Detail">
                    <i class="fas fa-eye"></i>
                </a>
                <button type="button" 
                        class="btn btn-sm btn-outline-warning btn-action edit-status-btn"
                        data-id="{{ $item->id }}"
                        data-status="{{ $item->status_pengajuan }}"
                        data-pelanggan="{{ $item->pelanggan->nama_pelanggan ?? '-' }}"
                        data-motor="{{ $item->motor->nama_motor ?? '-' }}"
                        data-bs-toggle="modal"
                        data-bs-target="#editStatusModal"
                        title="Ubah Status">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" 
                        class="btn btn-sm btn-outline-danger btn-action delete-btn"
                        data-id="{{ $item->id }}"
                        data-name="{{ $item->pelanggan->nama_pelanggan ?? 'Pengajuan' }}"
                        title="Hapus">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
    @empty
    <tr>
        {{-- UBAH COLSPAN MENJADI 8 --}}
        <td colspan="8" class="text-center py-5">
            <div class="empty-state">
                <i class="fas fa-file-invoice fa-4x text-muted mb-3"></i>
                <h5 class="fw-semibold">Belum Ada Pengajuan</h5>
                <p class="text-muted">Belum ada data pengajuan kredit</p>
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
                Menampilkan {{ $pengajuan->firstItem() ?? 0 }} - {{ $pengajuan->lastItem() ?? 0 }} dari {{ $pengajuan->total() }} data
            </div>
            <div>
                {{ $pengajuan->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Status -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editStatusModalLabel">
                    <i class="fas fa-edit me-2"></i> Ubah Status Pengajuan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="editStatusForm">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <div class="alert alert-info border-0 rounded-3 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-user-circle fa-lg"></i>
                                <div>
                                    <span class="fw-semibold" id="modalPelanggan">-</span>
                                    <br>
                                    <small class="text-muted" id="modalMotor">-</small>
                                </div>
                            </div>
                        </div>
                        <label class="form-label fw-semibold">
                            <i class="fas fa-tag me-1 text-primary"></i> Status Pengajuan
                        </label>
                        <select name="status_pengajuan" id="statusSelect" class="form-select" required>
                            <option value="Menunggu">Menunggu Konfirmasi</option>
                            <option value="Disetujui">Disetujui / Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                        <small class="text-muted text-danger" id="statusWarning" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-1"></i> Mengubah ke Disetujui akan membuat jadwal angsuran otomatis!
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-sticky-note me-1 text-primary"></i> Catatan (Opsional)
                        </label>
                        <textarea name="keterangan_status_pengajuan" id="keteranganText" class="form-control" rows="3" placeholder="Tambahkan catatan untuk pelanggan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>

                
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Status DP -->
<div class="modal fade" id="editStatusDpModal" tabindex="-1" aria-labelledby="editStatusDpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editStatusDpModalLabel">
                    <i class="fas fa-money-bill-wave me-2"></i> Ubah Status DP (Uang Muka)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="editStatusDpForm">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <div class="alert alert-info border-0 rounded-3 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-user-circle fa-lg"></i>
                                <div>
                                    <span class="fw-semibold" id="modalDpPelanggan">-</span>
                                    <br>
                                    <small class="text-muted" id="modalDpNominal">Nominal DP: Rp 0</small>
                                </div>
                            </div>
                        </div>
                        <label class="form-label fw-semibold">
                            <i class="fas fa-tag me-1 text-primary"></i> Status DP
                        </label>
                        <select name="status_dp" id="statusDpSelect" class="form-select" required>
                            <option value="Belum Bayar">Belum Bayar</option>
                            <option value="Menunggu">Menunggu Verifikasi</option>
                            <option value="Lunas">Lunas ✅</option>
                            <option value="Ditolak">Ditolak ❌</option>
                        </select>
                        <small class="text-muted text-info mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i> 
                            Ubah status DP sesuai dengan bukti pembayaran yang diterima.
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-sticky-note me-1 text-primary"></i> Catatan (Opsional)
                        </label>
                        <textarea name="keterangan_dp" id="keteranganDpText" class="form-control" rows="3" placeholder="Tambahkan catatan untuk pelanggan..."></textarea>
                    </div>
                    
                    {{-- Preview Bukti DP --}}
                    <div id="previewBuktiDp" style="display: none;" class="mt-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-image me-1 text-primary"></i> Bukti Pembayaran
                        </label>
                        <div class="text-center">
                            <img id="buktiDpImage" src="" alt="Bukti DP" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <br>
                            <a href="#" id="buktiDpLink" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="fas fa-external-link-alt me-1"></i> Buka Bukti
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==========================================
    // UPDATE STATISTIK
    // ==========================================
    function updateStats() {
        const rows = document.querySelectorAll('#tableBody tr');
        let menunggu = 0, disetujui = 0, ditolak = 0, total = 0;
        
        rows.forEach(row => {
            if (row.style.display !== 'none' && row.dataset.status) {
                const status = row.dataset.status;
                if (status === 'Menunggu') menunggu++;
                else if (status === 'Disetujui') disetujui++;
                else if (status === 'Ditolak') ditolak++;
                total++;
            }
        });
        
        const statMenunggu = document.getElementById('statMenunggu');
        const statDisetujui = document.getElementById('statDisetujui');
        const statDitolak = document.getElementById('statDitolak');
        const statTotal = document.getElementById('statTotal');
        
        if (statMenunggu) statMenunggu.innerText = menunggu;
        if (statDisetujui) statDisetujui.innerText = disetujui;
        if (statDitolak) statDitolak.innerText = ditolak;
        if (statTotal) statTotal.innerText = total;
    }
    
    // ==========================================
    // FILTER TABLE
    // ==========================================
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const resetBtn = document.getElementById('resetFilter');
    
    function filterTable() {
        const searchTerm = searchInput?.value.toLowerCase() || '';
        const statusValue = statusFilter?.value || '';
        const dateValue = dateFilter?.value || '';
        const rows = document.querySelectorAll('#tableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            if (!row.dataset.status) return;
            
            let show = true;
            const text = row.dataset.search || '';
            const status = row.dataset.status || '';
            const tanggal = row.dataset.tanggal || '';
            
            if (searchTerm && !text.includes(searchTerm)) show = false;
            if (statusValue && status !== statusValue) show = false;
            if (dateValue && tanggal !== dateValue) show = false;
            
            if (show) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        updateStats();
        
        let noResult = document.getElementById('noResultMsg');
        if (visibleCount === 0 && document.querySelectorAll('#tableBody tr[data-status]').length > 0) {
            if (!noResult) {
                noResult = document.createElement('tr');
                noResult.id = 'noResultMsg';
                noResult.innerHTML = `
                    <td colspan="8" class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h6 class="fw-semibold">Tidak ada data ditemukan</h6>
                        <p class="text-muted small">Coba dengan kata kunci atau filter yang berbeda</p>
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
    if (dateFilter) dateFilter.addEventListener('change', filterTable);
    
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (statusFilter) statusFilter.value = '';
            if (dateFilter) dateFilter.value = '';
            filterTable();
        });
    }
    
    // ==========================================
    // EDIT STATUS PENGAJUAN BUTTON
    // ==========================================
    const editBtns = document.querySelectorAll('.edit-status-btn');
    const statusWarning = document.getElementById('statusWarning');
    
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const status = this.dataset.status;
            const pelanggan = this.dataset.pelanggan;
            const motor = this.dataset.motor;
            
            const modalPelanggan = document.getElementById('modalPelanggan');
            const modalMotor = document.getElementById('modalMotor');
            
            if (modalPelanggan) {
                modalPelanggan.innerHTML = '<i class="fas fa-user me-1"></i> ' + pelanggan;
            }
            if (modalMotor) {
                modalMotor.innerHTML = '<i class="fas fa-motorcycle me-1"></i> ' + motor;
            }
            
            let selectValue = 'Menunggu';
            if (status === 'Disetujui') {
                selectValue = 'Disetujui';
            } else if (status === 'Ditolak') {
                selectValue = 'Ditolak';
            }
            
            const statusSelect = document.getElementById('statusSelect');
            if (statusSelect) {
                statusSelect.value = selectValue;
            }
            
            if (statusWarning) {
                if (selectValue === 'Disetujui') {
                    statusWarning.style.display = 'block';
                } else {
                    statusWarning.style.display = 'none';
                }
            }
            
            const editForm = document.getElementById('editStatusForm');
            if (editForm) {
                editForm.action = '{{ route("marketing.pengajuan.index") }}/' + id;
            }
        });
    });
    
    // Show/hide warning when select changes
    const statusSelectPengajuan = document.getElementById('statusSelect');
    if (statusSelectPengajuan && statusWarning) {
        statusSelectPengajuan.addEventListener('change', function() {
            if (this.value === 'Disetujui') {
                statusWarning.style.display = 'block';
            } else {
                statusWarning.style.display = 'none';
            }
        });
    }
    
    // ==========================================
    // DELETE BUTTON
    // ==========================================
    const deleteBtns = document.querySelectorAll('.delete-btn');
    
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            
            Swal.fire({
                title: 'Hapus Pengajuan?',
                html: `Apakah Anda yakin ingin menghapus pengajuan dari <strong>${name}</strong>?<br><small class="text-muted">Data yang dihapus tidak dapat dikembalikan.</small>`,
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
                    form.action = '{{ route("marketing.pengajuan.index") }}/' + id;
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
    // PER PAGE SELECTOR
    // ==========================================
    const perPageSelect = document.getElementById('perPageSelect');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', this.value);
            window.location.href = url.toString();
        });
    }
    
    // ==========================================
    // EDIT STATUS DP BUTTON (YANG DIPERBAIKI)
    // ==========================================
    const editStatusDpBtns = document.querySelectorAll('.edit-status-dp-btn');
    
    editStatusDpBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const status = this.dataset.status;
            const pelanggan = this.dataset.pelanggan;
            const nominal = this.dataset.nominal;
            const bukti = this.dataset.bukti;
            const keterangan = this.dataset.keterangan;
            
            // Set data ke modal
            const modalDpPelanggan = document.getElementById('modalDpPelanggan');
            const modalDpNominal = document.getElementById('modalDpNominal');
            const statusDpSelect = document.getElementById('statusDpSelect');
            const keteranganDpText = document.getElementById('keteranganDpText');
            const previewDiv = document.getElementById('previewBuktiDp');
            const buktiDpImage = document.getElementById('buktiDpImage');
            const buktiDpLink = document.getElementById('buktiDpLink');
            
            if (modalDpPelanggan) {
                modalDpPelanggan.innerHTML = '<i class="fas fa-user me-1"></i> ' + pelanggan;
            }
            if (modalDpNominal) {
                modalDpNominal.innerHTML = 'Nominal DP: Rp ' + nominal;
            }
            
            // Set value select sesuai status
            let selectValue = 'Belum Bayar';
            if (status === 'Lunas') selectValue = 'Lunas';
            else if (status === 'Menunggu') selectValue = 'Menunggu';
            else if (status === 'Ditolak') selectValue = 'Ditolak';
            if (statusDpSelect) statusDpSelect.value = selectValue;
            
            // Set keterangan
            if (keteranganDpText) {
                keteranganDpText.value = keterangan || '';
            }
            
            // Preview bukti jika ada
            if (previewDiv && bukti) {
                previewDiv.style.display = 'block';
                if (buktiDpImage) buktiDpImage.src = bukti;
                if (buktiDpLink) buktiDpLink.href = bukti;
            } else if (previewDiv) {
                previewDiv.style.display = 'none';
            }
            
            // Set action form (URL MANUAL)
            const editDpForm = document.getElementById('editStatusDpForm');
            if (editDpForm) {
                editDpForm.action = `/marketing/pengajuan/${id}/update-status-dp`;
            }
        });
    });
    
    // ==========================================
    // INITIAL STATS
    // ==========================================
    updateStats();
    
    // ==========================================
    // NOTIFICATIONS
    // ==========================================
    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonColor: '#667eea',
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
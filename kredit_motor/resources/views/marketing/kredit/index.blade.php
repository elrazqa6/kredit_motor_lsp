@extends('layouts.marketing')

@section('title', 'Data Kredit')
@section('page-title', 'Manajemen Kredit')

@section('content')
<div class="row">
    <div class="col-12">

        {{-- ═══ HEADER ══════════════════════════════════════════════════════════ --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 fw-bold">
                    <i class="fas fa-credit-card me-2 text-primary"></i> Data Kredit
                </h4>
                <p class="text-muted mb-0 small">Kelola data kredit yang sudah disetujui</p>
            </div>
            <a href="{{ route('marketing.kredit.create') }}" class="k-btn-primary mt-2 mt-sm-0">
                <i class="fas fa-plus me-2"></i> Tambah Kredit
            </a>
        </div>

        {{-- ═══ FILTER BAR ═══════════════════════════════════════════════════════ --}}
        <div class="k-filter-card mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-lg-3">
                    <div class="k-search-wrap">
                        <i class="fas fa-search k-search-icon"></i>
                        <input type="text" id="searchInput" class="k-search-input"
                               placeholder="Cari pelanggan atau motor...">
                    </div>
                </div>
                <div class="col-md-3 col-lg-2">
                    <select id="statusFilter" class="k-select">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="lunas">Lunas</option>
                        <option value="bermasalah">Bermasalah</option>
                    </select>
                </div>
                <div class="col-md-3 col-lg-2">
                    <select id="perPageSelect" class="k-select">
                        <option value="10">10 / halaman</option>
                        <option value="25">25 / halaman</option>
                        <option value="50">50 / halaman</option>
                    </select>
                </div>
                <div class="col text-md-end">
                    <span class="text-muted small" id="totalCount">
                        Total: {{ $kredit->total() }} data
                    </span>
                </div>
            </div>
        </div>

        {{-- ═══ TABLE ══════════════════════════════════════════════════════════════ --}}
        <div class="k-table-wrap">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" width="4%">No</th>
                            <th width="16%">Pelanggan</th>
                            <th width="14%">Motor</th>
                            <th width="9%">Tenor</th>
                            <th width="16%">Progress Cicilan</th>
                            <th width="12%">Sisa Kredit</th>
                            <th width="10%">Status</th>
                            <th width="11%" class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($kredit as $index => $item)
                        @php
                            // Progress lunas berdasarkan angsuran yang sudah dibayar
                            $totalAngsuran  = $item->angsuran->count();
                            $sudahBayar     = $item->angsuran->whereNotNull('tgl_bayar')->count();
                            $progress       = $totalAngsuran > 0 ? round(($sudahBayar / $totalAngsuran) * 100) : 0;

                            $statusMap = [
                                'aktif'       => ['label' => 'Aktif',       'color' => 'success'],
                                'lunas'       => ['label' => 'Lunas',       'color' => 'info'],
                                'bermasalah'  => ['label' => 'Bermasalah',  'color' => 'danger'],
                            ];
                            $st = $statusMap[$item->status_kredit] ?? ['label' => ucfirst($item->status_kredit), 'color' => 'warning'];

                            $progressColor = $progress >= 75 ? 'success' : ($progress >= 40 ? 'primary' : 'warning');
                        @endphp
                        <tr data-status="{{ $item->status_kredit }}"
                            data-search="{{ strtolower(($item->pengajuanKredit->pelanggan->nama_pelanggan ?? '').' '.($item->pengajuanKredit->motor->nama_motor ?? '')) }}">
                            <td class="ps-4 text-muted small">{{ $index + $kredit->firstItem() }}</td>

                            {{-- Pelanggan --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="k-avatar">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="font-size:13.5px;">
                                            {{ $item->pengajuanKredit->pelanggan->nama_pelanggan ?? '-' }}
                                        </div>
                                        <div class="text-muted" style="font-size:12px;">
                                            {{ $item->pengajuanKredit->pelanggan->no_telp ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Motor --}}
                            <td>
                                <div class="fw-semibold" style="font-size:13.5px;">
                                    {{ $item->pengajuanKredit->motor->nama_motor ?? '-' }}
                                </div>
                                <div class="text-muted" style="font-size:12px;">
                                    {{ $item->pengajuanKredit->motor->merk ?? '-' }}
                                </div>
                            </td>

                            {{-- Tenor --}}
                            <td>
                                <div class="fw-semibold" style="font-size:13.5px;">
                                    {{ $item->pengajuanKredit->tenor }} bln
                                </div>
                                <div class="text-muted" style="font-size:12px;">
                                    {{ number_format($item->pengajuanKredit->tenor / 12, 1) }} thn
                                </div>
                            </td>

                            {{-- Progress --}}
                            <td>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="small fw-semibold text-{{ $progressColor }}">
                                        {{ $sudahBayar }}/{{ $totalAngsuran }}
                                    </span>
                                    <span class="text-muted small">angsuran</span>
                                </div>
                                <div class="k-progress">
                                    <div class="k-progress-bar bg-{{ $progressColor }}"
                                         style="width:{{ $progress }}%"></div>
                                </div>
                                <div class="text-muted mt-1" style="font-size:11px;">
                                    {{ $progress }}% lunas
                                </div>
                            </td>

                            {{-- Sisa Kredit --}}
                            <td>
                                <span class="fw-bold text-danger" style="font-size:13.5px;">
                                    Rp {{ number_format($item->sisa_kredit, 0, ',', '.') }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td>
                                <span class="k-badge k-badge-{{ $st['color'] }}">
                                    {{ $st['label'] }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center pe-4">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('marketing.kredit.show', $item->id) }}"
                                       class="k-icon-btn k-icon-btn-primary" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button"
                                            class="k-icon-btn k-icon-btn-warning edit-btn"
                                            data-id="{{ $item->id }}"
                                            data-status="{{ $item->status_kredit }}"
                                            data-keterangan="{{ $item->keterangan_status_kredit }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editStatusModal"
                                            title="Edit Status">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button"
                                            class="k-icon-btn k-icon-btn-danger delete-btn"
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->pengajuanKredit->pelanggan->nama_pelanggan ?? 'Kredit' }}"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="k-avatar mx-auto mb-3"
                                     style="width:70px;height:70px;font-size:1.8rem;background:rgba(102,126,234,.08);">
                                    <i class="fas fa-credit-card text-primary"></i>
                                </div>
                                <h5 class="fw-semibold mb-1">Belum Ada Data Kredit</h5>
                                <p class="text-muted small mb-3">Silakan tambah data kredit baru</p>
                                <a href="{{ route('marketing.kredit.create') }}" class="k-btn-primary">
                                    <i class="fas fa-plus me-2"></i> Tambah Kredit
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ═══ PAGINATION ════════════════════════════════════════════════════════ --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 gap-2">
            <div class="text-muted small">
                Menampilkan {{ $kredit->firstItem() ?? 0 }}–{{ $kredit->lastItem() ?? 0 }}
                dari {{ $kredit->total() }} data
            </div>
            {{ $kredit->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

{{-- ═══ MODAL EDIT STATUS ═══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content k-modal">
            <div class="k-modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-edit me-2"></i> Ubah Status Kredit
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="editStatusForm">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="k-label">
                            <i class="fas fa-tag me-1 text-primary"></i> Status Kredit
                        </label>
                        <select name="status_kredit" id="statusSelect" class="k-form-control" required>
                            <option value="aktif">Aktif</option>
                            <option value="lunas">Lunas</option>
                            <option value="bermasalah">Bermasalah</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="k-label">
                            <i class="fas fa-sticky-note me-1 text-primary"></i> Keterangan
                        </label>
                        <textarea name="keterangan_status_kredit" id="keteranganText"
                                  class="k-form-control" rows="3"
                                  placeholder="Tambahkan keterangan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="k-btn-ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="k-btn-primary">
                        <i class="fas fa-save me-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ═══ STYLES ════════════════════════════════════════════════════════════════════ --}}
<style>
/* ── Table wrap ──────────────────────────────────────────────────────────────── */
.k-table-wrap {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #eaecf0;
    overflow: hidden;
}
.table thead tr { background: #f8fafc; }
.table th {
    font-size: 11.5px; font-weight: 700; color: #64748b;
    padding: 14px 12px; letter-spacing: .4px; text-transform: uppercase;
    border-bottom: 1px solid #f1f3f5; white-space: nowrap;
}
.table td { padding: 14px 12px; font-size: 13px; vertical-align: middle; border-color: #f8fafc; }
.table tbody tr { transition: background .15s; }
.table-hover tbody tr:hover { background: #fafbff; }

/* ── Filter card ─────────────────────────────────────────────────────────────── */
.k-filter-card {
    background: #f8fafc; border: 1px solid #e8edf2;
    border-radius: 1rem; padding: 1rem 1.25rem;
}
.k-search-wrap { position: relative; }
.k-search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
                 color: #aaa; font-size: 13px; pointer-events: none; }
.k-search-input { width: 100%; padding: 9px 14px 9px 38px; border: 1px solid #dde3ea;
                  border-radius: 999px; background: #fff; font-size: 13.5px; outline: none;
                  transition: border-color .2s; }
.k-search-input:focus { border-color: #667eea; }
.k-select { width: 100%; padding: 9px 14px; border: 1px solid #dde3ea;
            border-radius: 999px; background: #fff; font-size: 13.5px;
            outline: none; cursor: pointer; transition: border-color .2s; }
.k-select:focus { border-color: #667eea; }

/* ── Avatar ──────────────────────────────────────────────────────────────────── */
.k-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(102,126,234,.1);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 14px;
}

/* ── Progress ────────────────────────────────────────────────────────────────── */
.k-progress { height: 6px; background: #f1f3f5; border-radius: 99px; overflow: hidden; }
.k-progress-bar { height: 100%; border-radius: 99px; transition: width .4s ease; }

/* ── Badges ──────────────────────────────────────────────────────────────────── */
.k-badge {
    display: inline-block; padding: 4px 12px; border-radius: 999px;
    font-size: 11.5px; font-weight: 700; letter-spacing: .3px;
}
.k-badge-success { background: #d1fae5; color: #059669; }
.k-badge-info    { background: #dbeafe; color: #2563eb; }
.k-badge-danger  { background: #fee2e2; color: #dc2626; }
.k-badge-warning { background: #fef3c7; color: #d97706; }

/* ── Icon buttons ────────────────────────────────────────────────────────────── */
.k-icon-btn {
    width: 32px; height: 32px; border-radius: 8px; border: none;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer; transition: all .2s; text-decoration: none;
}
.k-icon-btn:hover { transform: translateY(-2px); }
.k-icon-btn-primary { background: rgba(102,126,234,.1); color: #667eea; }
.k-icon-btn-primary:hover { background: #667eea; color: #fff; }
.k-icon-btn-warning { background: rgba(245,158,11,.1); color: #d97706; }
.k-icon-btn-warning:hover { background: #f59e0b; color: #fff; }
.k-icon-btn-danger  { background: rgba(239,68,68,.1); color: #dc2626; }
.k-icon-btn-danger:hover  { background: #ef4444; color: #fff; }

/* ── Primary button ──────────────────────────────────────────────────────────── */
.k-btn-primary {
    display: inline-flex; align-items: center; padding: 9px 20px;
    border-radius: 999px; font-size: 13.5px; font-weight: 700;
    background: linear-gradient(135deg,#667eea,#764ba2);
    color: #fff; border: none; cursor: pointer; text-decoration: none;
    transition: all .22s;
}
.k-btn-primary:hover { opacity:.88; color:#fff; transform:translateY(-1px);
                       box-shadow:0 6px 18px rgba(102,126,234,.35); }
.k-btn-ghost {
    display: inline-flex; align-items: center; padding: 9px 20px;
    border-radius: 999px; font-size: 13.5px; font-weight: 600;
    background: #f1f3f5; color: #555; border: none; cursor: pointer;
    transition: all .2s;
}
.k-btn-ghost:hover { background: #e2e6ea; }

/* ── Modal ───────────────────────────────────────────────────────────────────── */
.k-modal { border-radius: 1.25rem; border: none; overflow: hidden; }
.k-modal-header {
    padding: 1.1rem 1.5rem;
    background: linear-gradient(135deg,#667eea,#764ba2);
    color: #fff;
}
.k-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block; }
.k-form-control {
    width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0;
    border-radius: .75rem; font-size: 13.5px; outline: none;
    transition: border-color .2s; background: #fff;
}
.k-form-control:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,.1); }

/* ── Pagination ──────────────────────────────────────────────────────────────── */
.pagination {
    --bs-pagination-color: #667eea;
    --bs-pagination-active-bg: #667eea;
    --bs-pagination-active-border-color: #667eea;
    margin-bottom: 0;
}
</style>

{{-- ═══ SCRIPTS ═══════════════════════════════════════════════════════════════════ --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Filter client-side ─────────────────────────────────────────────── */
    const searchInput  = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const totalCount   = document.getElementById('totalCount');

    function filterTable() {
        const q      = (searchInput?.value || '').toLowerCase();
        const status = statusFilter?.value || '';
        const rows   = document.querySelectorAll('#tableBody tr[data-status]');
        let visible  = 0;

        rows.forEach(row => {
            const okSearch = !q      || (row.dataset.search || '').includes(q);
            const okStatus = !status || row.dataset.status === status;
            row.style.display = (okSearch && okStatus) ? '' : 'none';
            if (okSearch && okStatus) visible++;
        });

        if (totalCount) totalCount.innerText = `Menampilkan ${visible} data`;
    }

    searchInput?.addEventListener('keyup', filterTable);
    statusFilter?.addEventListener('change', filterTable);

    /* ── Edit modal ─────────────────────────────────────────────────────── */
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = document.getElementById('editStatusForm');
            form.action = '{{ url("marketing/kredit") }}/' + this.dataset.id;
            document.getElementById('statusSelect').value    = this.dataset.status;
            document.getElementById('keteranganText').value  = this.dataset.keterangan || '';
        });
    });

    /* ── Delete ─────────────────────────────────────────────────────────── */
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id   = this.dataset.id;
            const name = this.dataset.name;
            Swal.fire({
                title: 'Hapus Kredit?',
                html: `Yakin hapus kredit atas nama <strong>${name}</strong>?<br>
                       <small class="text-muted">Data tidak dapat dikembalikan.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ url("marketing/kredit") }}/' + id;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    /* ── Flash messages ─────────────────────────────────────────────────── */
    @if(session('success'))
        Swal.fire({ title:'Berhasil!', text:'{{ session('success') }}',
            icon:'success', confirmButtonColor:'#667eea', timer:3000, timerProgressBar:true });
    @endif
    @if(session('error'))
        Swal.fire({ title:'Gagal!', text:'{{ session('error') }}',
            icon:'error', confirmButtonColor:'#dc2626' });
    @endif
});
</script>
@endsection
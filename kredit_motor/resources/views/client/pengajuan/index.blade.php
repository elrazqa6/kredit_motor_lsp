@extends('layouts.client')

@section('title', 'Pengajuan Kredit Saya')
@section('page-title', 'Pengajuan Kredit Saya')

@section('content')
<div class="container px-0">

    {{-- ═══ HEADER ═══════════════════════════════════════════════════════════ --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-file-invoice text-primary me-2"></i> Pengajuan Kredit Saya
            </h4>
            <p class="text-muted mb-0">Pantau status pengajuan kredit motor Anda</p>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="{{ route('client.pengajuan.create') }}"
               class="btn-ajukan">
                <i class="fas fa-plus me-2"></i> Ajukan Kredit Baru
            </a>
        </div>
    </div>

    {{-- ═══ STATISTIK ═════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">
        @php
            $stats = [
                ['key' => 'menunggu',  'label' => 'Menunggu',  'icon' => 'fa-clock',       'color' => 'warning'],
                ['key' => 'diterima',  'label' => 'Disetujui', 'icon' => 'fa-check-circle','color' => 'success'],
                ['key' => 'ditolak',   'label' => 'Ditolak',   'icon' => 'fa-times-circle','color' => 'danger'],
                ['key' => 'total',     'label' => 'Total',     'icon' => 'fa-layer-group', 'color' => 'primary'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="col-6 col-md-3">
            <div class="stat-card stat-{{ $s['color'] }}">
                <div class="stat-icon-wrap">
                    <i class="fas {{ $s['icon'] }}"></i>
                </div>
                <div class="stat-num">{{ $statistik[$s['key']] ?? 0 }}</div>
                <div class="stat-label">{{ $s['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ═══ FILTER ════════════════════════════════════════════════════════════ --}}
    <div class="filter-card mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="search-wrap">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput"
                           class="search-input"
                           placeholder="Cari motor atau ID pengajuan...">
                </div>
            </div>
            <div class="col-md-3">
                <select id="statusFilter" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="Menunggu">Menunggu</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" id="dateFilter" class="filter-select">
            </div>
            <div class="col-md-2">
                <button id="resetFilter" class="btn-reset w-100">
                    <i class="fas fa-redo-alt me-1"></i> Reset
                </button>
            </div>
        </div>
    </div>

    {{-- ═══ DAFTAR PENGAJUAN ══════════════════════════════════════════════════ --}}
    <div id="pengajuanList">
        @forelse($pengajuan as $item)
        @php
            $st = $item->status_pengajuan;   // Menunggu | Disetujui | Ditolak
            $colorMap = ['Menunggu' => 'warning', 'Disetujui' => 'success', 'Ditolak' => 'danger'];
            $iconMap  = ['Menunggu' => 'fa-clock', 'Disetujui' => 'fa-check-circle', 'Ditolak' => 'fa-times-circle'];
            $c = $colorMap[$st] ?? 'secondary';
            $ic = $iconMap[$st] ?? 'fa-info-circle';
            
            // STATUS DP
            $dpStatus = $item->status_dp ?? 'Belum Bayar';
            $dpColorMap = [
                'Belum Bayar' => 'secondary',
                'Menunggu' => 'warning',
                'Lunas' => 'success',
                'Ditolak' => 'danger'
            ];
            $dpIconMap = [
                'Belum Bayar' => 'fa-clock',
                'Menunggu' => 'fa-hourglass-half',
                'Lunas' => 'fa-check-circle',
                'Ditolak' => 'fa-times-circle'
            ];
            $dpTextMap = [
                'Belum Bayar' => 'Belum Bayar DP',
                'Menunggu' => 'Menunggu Verifikasi DP',
                'Lunas' => 'DP Lunas ✅',
                'Ditolak' => 'DP Ditolak ❌'
            ];
            $dpColor = $dpColorMap[$dpStatus] ?? 'secondary';
            $dpIcon = $dpIconMap[$dpStatus] ?? 'fa-clock';
            $dpText = $dpTextMap[$dpStatus] ?? $dpStatus;
        @endphp

        <div class="pengajuan-item pengajuan-card mb-3"
             data-status="{{ $st }}"
             data-tanggal="{{ \Carbon\Carbon::parse($item->tgl_pengajuan_kredit)->format('Y-m-d') }}"
             data-search="{{ strtolower($item->motor->nama_motor ?? '') }} {{ $item->id }}">

            {{-- Strip warna kiri --}}
            <div class="pcard-strip bg-{{ $c }}"></div>

            <div class="pcard-body">
                <div class="row align-items-center gy-3">

                    {{-- Icon status --}}
                    <div class="col-auto">
                        <div class="pcard-icon bg-{{ $c }}-soft">
                            <i class="fas {{ $ic }} text-{{ $c }}"></i>
                        </div>
                    </div>

                    {{-- Info motor --}}
                    <div class="col-md-3">
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            <span class="chip chip-primary">#{{ $item->id }}</span>
                            <span class="chip chip-gray">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($item->tgl_pengajuan_kredit)->format('d/m/Y') }}
                            </span>
                        </div>
                        <div class="fw-bold" style="font-size:1rem;color:#1a1a2e;">
                            {{ $item->motor->nama_motor ?? '-' }}
                        </div>
                        <div class="text-muted" style="font-size:13px;">
                            <i class="fas fa-trademark me-1"></i>{{ $item->motor->merk ?? '-' }}
                        </div>
                    </div>

                    {{-- Detail kredit --}}
                    <div class="col-md-2">
                        <div class="mb-2">
                            <div class="detail-label">Cicilan / Bulan</div>
                            <div class="detail-val text-success">
                                Rp {{ number_format($item->cicilan_perbulan, 0, ',', '.') }}
                            </div>
                        </div>
                        <div>
                            <div class="detail-label">Tenor</div>
                            <div class="detail-val-sm">
                                {{ $item->jenisCicilan->lama_cicilan ?? '-' }} bulan
                            </div>
                        </div>
                    </div>

                    {{-- DP & Status --}}
                    <div class="col-md-2">
                        <div class="mb-2">
                            <div class="detail-label">Uang Muka (DP)</div>
                            <div class="detail-val-sm text-primary">
                                Rp {{ number_format($item->uang_muka ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                        {{-- Badge status pengajuan --}}
                        <span class="status-badge status-{{ $c }}">
                            <i class="fas {{ $ic }} me-1"></i>{{ $st }}
                        </span>
                    </div>

                    {{-- ═══ STATUS DP (BARU) ═══ --}}
                    <div class="col-md-2">
                        <div class="detail-label mb-1">Status DP</div>
                        <span class="status-badge status-{{ $dpColor }}">
                            <i class="fas {{ $dpIcon }} me-1"></i>{{ $dpText }}
                        </span>
                        @if($dpStatus == 'Menunggu' && $item->bukti_dp)
                            <br>
                            <small class="text-muted">
                                <a href="{{ asset('storage/'.$item->bukti_dp) }}" target="_blank" class="text-primary">
                                    <i class="fas fa-image me-1"></i> Lihat Bukti
                                </a>
                            </small>
                        @endif
                        @if($dpStatus == 'Ditolak' && $item->keterangan_dp)
                            <br>
                            <small class="text-danger">
                                <i class="fas fa-info-circle me-1"></i> {{ $item->keterangan_dp }}
                            </small>
                        @endif
                    </div>

                    {{-- Aksi --}}
                    <div class="col-md-2 text-md-end d-flex flex-md-column gap-2 justify-content-end">

                        {{-- Tombol Detail --}}
                        <a href="{{ route('client.pengajuan.show', $item->id) }}"
                           class="pcard-btn pcard-btn-primary">
                            <i class="fas fa-eye me-1"></i> Detail
                        </a>
@if($st === 'Disetujui' && $dpStatus !== 'Lunas')
    <a href="{{ route('midtrans.pay.dp', $item->id) }}" 
       class="pcard-btn pcard-btn-pay">
        <i class="fas fa-credit-card me-1"></i> Bayar DP
    </a>
@endif
   {{-- ═══ TOMBOL LACAK PENGIRIMAN (TAMBAHKAN INI) ═══ --}}
    @if($st === 'Disetujui' && $dpStatus == 'Lunas')
        @php
            $kredit = $item->kredit;
            $pengiriman = $kredit ? \App\Models\Pengiriman::where('id_kredit', $kredit->id)->first() : null;
        @endphp
        @if($pengiriman)
            <a href="{{ route('client.pengiriman.show', $pengiriman->id) }}"
               class="pcard-btn pcard-btn-tracking">
                <i class="fas fa-truck me-1"></i> Lacak Pengiriman
            </a>
        @else
            <button class="pcard-btn pcard-btn-disabled" disabled style="opacity: 0.5;">
                <i class="fas fa-truck me-1"></i> Menunggu Pengiriman
            </button>
        @endif
    @endif
    {{-- ============================================= --}}

                        {{-- Tombol Cancel untuk yang masih menunggu --}}
                        @if($st === 'Menunggu')
                            <button type="button"
                                    class="pcard-btn pcard-btn-danger cancel-btn"
                                    data-id="{{ $item->id }}"
                                    data-motor="{{ $item->motor->nama_motor ?? '' }}">
                                <i class="fas fa-times me-1"></i> Batalkan
                            </button>
                        @endif
                    </div>

                </div>

                {{-- Keterangan --}}
                @if($item->keterangan_status_pengajuan)
                <div class="pcard-note mt-3">
                    <i class="fas fa-sticky-note me-1"></i>
                    {{ \Illuminate\Support\Str::limit($item->keterangan_status_pengajuan, 120) }}
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state-card text-center py-5">
            <div class="empty-icon mx-auto mb-4">
                <i class="fas fa-file-invoice fa-3x" style="color:#667eea;"></i>
            </div>
            <h4 class="fw-bold mb-2">Belum Ada Pengajuan</h4>
            <p class="text-muted mb-4">Anda belum mengajukan kredit motor apapun</p>
            <a href="{{ route('client.pengajuan.create') }}" class="btn-ajukan">
                <i class="fas fa-plus me-2"></i> Ajukan Kredit Sekarang
            </a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($pengajuan->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $pengajuan->links('pagination::bootstrap-4') }}
    </div>
    @endif

</div>

{{-- ═══ STYLES ═════════════════════════════════════════════════════════════════ --}}
<style>
/* ── Util ─────────────────────────────────────────────────────────────────── */
.rounded-4 { border-radius: 1rem !important; }

/* ── Stat cards ─────────────────────────────────────────────────────────────── */
.stat-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #eaecf0;
    padding: 1.1rem .75rem;
    text-align: center;
    transition: transform .25s, box-shadow .25s;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 24px -8px rgba(0,0,0,.08); }

.stat-icon-wrap {
    width: 48px; height: 48px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; margin: 0 auto .6rem;
}
.stat-num   { font-size: 1.6rem; font-weight: 800; line-height: 1; }
.stat-label { font-size: 12px; color: #888; margin-top: 4px; }

.stat-warning .stat-icon-wrap { background: rgba(245,158,11,.12); color: #f59e0b; }
.stat-warning .stat-num        { color: #f59e0b; }
.stat-success .stat-icon-wrap  { background: rgba(16,185,129,.12); color: #10b981; }
.stat-success .stat-num        { color: #10b981; }
.stat-danger .stat-icon-wrap   { background: rgba(239,68,68,.12);  color: #ef4444; }
.stat-danger .stat-num         { color: #ef4444; }
.stat-primary .stat-icon-wrap  { background: rgba(102,126,234,.12);color: #667eea; }
.stat-primary .stat-num        { color: #667eea; }

/* ── Filter card ─────────────────────────────────────────────────────────────── */
.filter-card {
    background: #f8fafc;
    border: 1px solid #e8edf2;
    border-radius: 1rem;
    padding: 1rem 1.25rem;
}
.search-wrap   { position: relative; }
.search-icon   { position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
                 color: #aaa; font-size: 13px; pointer-events: none; }
.search-input  { width: 100%; padding: 9px 14px 9px 38px;
                 border: 1px solid #dde3ea; border-radius: 999px;
                 background: #fff; font-size: 14px; outline: none;
                 transition: border-color .2s; }
.search-input:focus { border-color: #667eea; }
.filter-select { width: 100%; padding: 9px 14px; border: 1px solid #dde3ea;
                 border-radius: 999px; background: #fff; font-size: 14px;
                 outline: none; cursor: pointer; transition: border-color .2s; }
.filter-select:focus { border-color: #667eea; }
.btn-reset { padding: 9px 0; border: 1px solid #dde3ea; border-radius: 999px;
             background: #fff; font-size: 13.5px; color: #555; cursor: pointer;
             transition: all .2s; }
.btn-reset:hover { background: #f1f3f5; border-color: #aaa; }

/* ── Pengajuan card ──────────────────────────────────────────────────────────── */
.pengajuan-card {
    background: #fff;
    border: 1px solid #eaecf0;
    border-radius: 1rem;
    overflow: hidden;
    display: flex;
    transition: transform .28s cubic-bezier(.22,.68,0,1.2), box-shadow .28s ease;
}
.pengajuan-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 36px -12px rgba(0,0,0,.1);
}
.pcard-strip {
    width: 5px;
    flex-shrink: 0;
    border-radius: 0;
}
.pcard-body { flex: 1; padding: 1.25rem 1.5rem; }

.pcard-btn-tracking {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff;
}
.pcard-btn-tracking:hover {
    opacity: .88;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(245,158,11,.4);
}

.pcard-btn-disabled {
    background: #e2e8f0;
    color: #64748b;
    cursor: not-allowed;
}

/* ── Card icon ──────────────────────────────────────────────────────────────── */
.pcard-icon {
    width: 52px; height: 52px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
}
.bg-warning-soft  { background: rgba(245,158,11,.12); }
.bg-success-soft  { background: rgba(16,185,129,.12); }
.bg-danger-soft   { background: rgba(239,68,68,.12); }
.bg-secondary-soft{ background: rgba(100,116,139,.12); }

/* ── Chips ──────────────────────────────────────────────────────────────────── */
.chip {
    display: inline-block; font-size: 11.5px; font-weight: 600;
    padding: 3px 10px; border-radius: 999px;
}
.chip-primary { background: rgba(102,126,234,.1); color: #5059d4; }
.chip-gray    { background: #f1f3f5; color: #666; }

/* ── Detail text ────────────────────────────────────────────────────────────── */
.detail-label  { font-size: 12px; color: #aaa; margin-bottom: 2px; }
.detail-val    { font-size: 1.1rem; font-weight: 700; }
.detail-val-sm { font-size: .95rem; font-weight: 600; color: #333; }

/* ── Status badge ───────────────────────────────────────────────────────────── */
.status-badge {
    display: inline-block; font-size: 12px; font-weight: 600;
    padding: 5px 12px; border-radius: 999px;
}
.status-warning { background: rgba(245,158,11,.12); color: #b7791f;
                  border: 1px solid rgba(245,158,11,.3); }
.status-success { background: rgba(16,185,129,.12);  color: #276749;
                  border: 1px solid rgba(16,185,129,.3); }
.status-danger  { background: rgba(239,68,68,.12);   color: #9b2c2c;
                  border: 1px solid rgba(239,68,68,.3); }
.status-secondary { background: rgba(100,116,139,.12); color: #4a5568;
                    border: 1px solid rgba(100,116,139,.3); }

/* ── Card buttons ───────────────────────────────────────────────────────────── */
.pcard-btn {
    display: inline-block; text-align: center;
    padding: 8px 18px; border-radius: 999px; font-size: 13px; font-weight: 600;
    cursor: pointer; border: none; text-decoration: none;
    transition: all .2s; white-space: nowrap;
}
.pcard-btn-primary {
    background: linear-gradient(135deg,#667eea,#764ba2);
    color: #fff;
}
.pcard-btn-primary:hover { opacity: .88; color: #fff; transform: translateY(-1px); }

.pcard-btn-pay {
    background: linear-gradient(135deg,#f59e0b,#d97706);
    color: #fff;
}
.pcard-btn-pay:hover { opacity: .88; color: #fff; transform: translateY(-1px);
                       box-shadow: 0 4px 12px rgba(245,158,11,.4); }

.pcard-btn-danger {
    background: rgba(239,68,68,.1);
    color: #dc2626;
    border: 1px solid rgba(239,68,68,.25) !important;
}
.pcard-btn-danger:hover { background: #dc2626; color: #fff; }

/* ── Note ───────────────────────────────────────────────────────────────────── */
.pcard-note {
    background: #f8fafc;
    border-left: 3px solid #dde3ea;
    border-radius: 0 .5rem .5rem 0;
    padding: 8px 12px;
    font-size: 13px;
    color: #666;
}

/* ── Ajukan button ──────────────────────────────────────────────────────────── */
.btn-ajukan {
    display: inline-block;
    padding: 10px 24px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    background: linear-gradient(135deg,#667eea,#764ba2);
    color: #fff;
    text-decoration: none;
    transition: all .2s;
    border: none;
    cursor: pointer;
}
.btn-ajukan:hover { opacity: .88; color: #fff; transform: translateY(-2px);
                    box-shadow: 0 8px 20px rgba(102,126,234,.35); }

/* ── Empty state ────────────────────────────────────────────────────────────── */
.empty-state-card {
    background: #fff;
    border: 1px solid #eaecf0;
    border-radius: 1rem;
}
.empty-icon {
    width: 80px; height: 80px;
    background: rgba(102,126,234,.1);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}

/* ── Pagination ─────────────────────────────────────────────────────────────── */
.pagination {
    --bs-pagination-color: #667eea;
    --bs-pagination-active-bg: #667eea;
    --bs-pagination-active-border-color: #667eea;
    --bs-pagination-hover-color: #764ba2;
}
</style>

{{-- ═══ SCRIPTS ════════════════════════════════════════════════════════════════ --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Filter ─────────────────────────────────────────────────────── */
    const searchInput  = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter   = document.getElementById('dateFilter');
    const resetBtn     = document.getElementById('resetFilter');
    const items        = document.querySelectorAll('.pengajuan-item');
    const list         = document.getElementById('pengajuanList');

    function filterItems() {
        const q      = (searchInput?.value || '').toLowerCase();
        const status = statusFilter?.value || '';
        const date   = dateFilter?.value   || '';
        let visible  = 0;

        items.forEach(item => {
            let show = true;
            if (q      && !(item.dataset.search || '').includes(q)) show = false;
            if (status && item.dataset.status   !== status)         show = false;
            if (date   && item.dataset.tanggal  !== date)           show = false;
            item.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        let noRes = document.getElementById('noResultMsg');
        if (visible === 0 && items.length > 0) {
            if (!noRes) {
                noRes = document.createElement('div');
                noRes.id = 'noResultMsg';
                noRes.className = 'empty-state-card text-center py-5';
                noRes.innerHTML = `
                    <div class="empty-icon mx-auto mb-3">
                        <i class="fas fa-search fa-2x" style="color:#667eea;"></i>
                    </div>
                    <h5 class="fw-bold">Tidak ada hasil</h5>
                    <p class="text-muted">Coba kata kunci atau filter yang berbeda</p>
                    <button id="resetFromMsg" class="btn-ajukan" style="font-size:13px;padding:8px 20px;">
                        Reset Filter
                    </button>`;
                list.appendChild(noRes);
                document.getElementById('resetFromMsg')?.addEventListener('click', () => resetBtn?.click());
            }
        } else if (noRes) {
            noRes.remove();
        }
    }

    searchInput?.addEventListener('keyup', filterItems);
    statusFilter?.addEventListener('change', filterItems);
    dateFilter?.addEventListener('change', filterItems);
    resetBtn?.addEventListener('click', () => {
        if (searchInput)  searchInput.value  = '';
        if (statusFilter) statusFilter.value = '';
        if (dateFilter)   dateFilter.value   = '';
        filterItems();
    });
    filterItems();

    /* ── Cancel ─────────────────────────────────────────────────────── */
    document.querySelectorAll('.cancel-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id    = this.dataset.id;
            const motor = this.dataset.motor;
            Swal.fire({
                title: 'Batalkan Pengajuan?',
                html: `Yakin membatalkan pengajuan untuk <strong>${motor}</strong>?<br>
                       <small class="text-muted">Pengajuan yang dibatalkan tidak dapat dikembalikan.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak',
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/client/pengajuan/${id}/cancel`;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
});
</script>

{{-- Flash messages --}}
@if(session('success'))
<script>
    Swal.fire({ title:'Berhasil!', text:'{{ session('success') }}',
        icon:'success', confirmButtonColor:'#667eea', timer:3000, timerProgressBar:true });
</script>
@endif
@if(session('error'))
<script>
    Swal.fire({ title:'Gagal!', text:'{{ session('error') }}',
        icon:'error', confirmButtonColor:'#dc2626' });
</script>
@endif
@endsection
@extends('layouts.client')

@section('title', 'Riwayat Angsuran Saya')

@section('content')
<div class="container px-0">

    {{-- ═══ BANNER NOTIFIKASI ══════════════════════════════════════════════════ --}}
    @if(isset($notifikasi) && $notifikasi->count() > 0)
    <div class="notif-banner rounded-4 mb-4 p-4" id="notifBanner">
        <div class="notif-glow"></div>
        <div class="d-flex align-items-start gap-3">
            <div class="notif-bell"><i class="fas fa-bell"></i></div>
            <div class="flex-grow-1">
                <div class="fw-bold mb-1" style="color:#b91c1c;">
                    ⚠️ {{ $notifikasi->count() }} angsuran akan / sudah jatuh tempo
                </div>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @foreach($notifikasi as $n)
                    @php
                        $s = $n->sisa_hari;
                        $chipLabel = $s < 0 ? 'Lewat '.abs($s).' hari' : ($s === 0 ? 'Hari ini!' : $s.' hari lagi');
                        $chipColor = $s < 0 ? 'danger' : ($s <= 3 ? 'warning' : 'info');
                    @endphp
                    <span class="notif-chip notif-chip-{{ $chipColor }}">
                        <i class="fas fa-motorcycle me-1"></i>
                        {{ $n->kredit->pengajuanKredit->motor->nama_motor ?? 'Motor' }}
                        · #{{ $n->angsuran_ke }} · <strong>{{ $chipLabel }}</strong>
                    </span>
                    @endforeach
                </div>
            </div>
            <button class="btn-close btn-close-sm mt-1"
                    onclick="document.getElementById('notifBanner').remove()"></button>
        </div>
    </div>
    @endif

    {{-- ═══ HEADER ════════════════════════════════════════════════════════════ --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-credit-card text-primary me-2"></i> Riwayat Angsuran Saya
            </h4>
            <p class="text-muted mb-0">Lihat & bayar angsuran kredit motor Anda</p>
        </div>
    </div>

    {{-- ═══ STATISTIK ═════════════════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">
        @php
            $statItems = [
                ['label'=>'Lunas',       'val'=>$statistik['lunas']??0,              'icon'=>'fa-check-circle',        'color'=>'success'],
                ['label'=>'Belum Bayar', 'val'=>$statistik['belum_bayar']??0,        'icon'=>'fa-clock',               'color'=>'secondary'],
                ['label'=>'Hampir JT',   'val'=>$statistik['hampir_jatuh_tempo']??0, 'icon'=>'fa-exclamation-triangle','color'=>'warning'],
                ['label'=>'Jatuh Tempo', 'val'=>$statistik['jatuh_tempo']??0,        'icon'=>'fa-fire',                'color'=>'danger'],
            ];
        @endphp
        @foreach($statItems as $s)
        <div class="col-6 col-md-3">
            <div class="stat-card stat-{{ $s['color'] }}">
                <div class="stat-icon-wrap"><i class="fas {{ $s['icon'] }}"></i></div>
                <div class="stat-num">{{ $s['val'] }}</div>
                <div class="stat-label">{{ $s['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ═══ TAB FILTER (server-side) ══════════════════════════════════════════ --}}
    <div class="tab-wrap mb-4">
        @php
            $tabs = [
                'semua'       => ['label' => 'Semua ('  .($statistik['lunas']+$statistik['belum_bayar']).')', 'icon' => 'fa-list'],
                'belum_bayar' => ['label' => 'Belum Bayar ('.$statistik['belum_bayar'].')',                   'icon' => 'fa-clock'],
                'lunas'       => ['label' => 'Lunas ('  .$statistik['lunas'].')',                             'icon' => 'fa-check-circle'],
            ];
        @endphp
        @foreach($tabs as $key => $t)
        <a href="{{ route('client.angsuran.index', ['tab' => $key]) }}"
           class="tab-btn {{ $tab === $key ? 'tab-active' : '' }}">
            <i class="fas {{ $t['icon'] }} me-1"></i>{{ $t['label'] }}
        </a>
        @endforeach
    </div>

    {{-- ═══ FILTER CLIENT-SIDE (search saja, status sudah ditangani tab) ═════ --}}
    <div class="filter-card mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="search-wrap">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" class="search-input"
                           placeholder="Cari nama motor...">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center gap-2">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" id="nearDueOnly" role="switch">
                    <label class="form-check-label small fw-semibold" for="nearDueOnly"
                           style="color:#f59e0b;">
                        <i class="fas fa-exclamation-circle me-1"></i>Hampir Jatuh Tempo saja
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <button id="resetFilter" class="btn-reset w-100">
                    <i class="fas fa-redo-alt me-1"></i> Reset
                </button>
            </div>
        </div>
    </div>

    {{-- ═══ DAFTAR ANGSURAN ════════════════════════════════════════════════════ --}}
    <div id="angsuranList">
        @forelse($angsuran as $item)
        @php
            $isLunas  = !is_null($item->tgl_bayar);
            $sisaHari = null;
            if (!$isLunas && $item->tgl_jatuh_tempo) {
                $sisaHari = (int) \Carbon\Carbon::today()->diffInDays($item->tgl_jatuh_tempo, false);
            }

            if ($isLunas) {
                $statusLabel = 'Lunas'; $color = 'success'; $icon = 'fa-check-circle';
            } elseif ($sisaHari === null) {
                $statusLabel = 'Belum Bayar'; $color = 'secondary'; $icon = 'fa-clock';
            } elseif ($sisaHari < 0) {
                $statusLabel = 'Jatuh Tempo'; $color = 'danger'; $icon = 'fa-fire';
            } elseif ($sisaHari <= 7) {
                $statusLabel = 'Hampir Jatuh Tempo'; $color = 'warning'; $icon = 'fa-exclamation-triangle';
            } else {
                $statusLabel = 'Belum Bayar'; $color = 'secondary'; $icon = 'fa-clock';
            }

            $isNearDue = !$isLunas && $sisaHari !== null && $sisaHari <= 7;

            $sisaLabel = null;
            if (!$isLunas && $sisaHari !== null) {
                $sisaLabel = $sisaHari < 0
                    ? 'Telat '.abs($sisaHari).' hari'
                    : ($sisaHari === 0 ? 'Hari ini!' : $sisaHari.' hari lagi');
            }
        @endphp

        <div class="angsuran-item angsuran-card mb-3"
             data-near-due="{{ $isNearDue ? '1' : '0' }}"
             data-search="{{ strtolower($item->kredit->pengajuanKredit->motor->nama_motor ?? '') }}">

            <div class="acard-strip bg-{{ $color }}"></div>

            <div class="acard-body">
                <div class="row align-items-center gy-3">

                    {{-- Icon --}}
                    <div class="col-auto">
                        <div class="acard-icon bg-{{ $color }}-soft">
                            <i class="fas {{ $icon }} text-{{ $color }}"></i>
                        </div>
                    </div>

                    {{-- Info Motor --}}
                    <div class="col-md-3">
                        <div class="mb-2">
                            <span class="chip chip-primary">
                                <i class="fas fa-hashtag me-1"></i>Angsuran #{{ $item->angsuran_ke }}
                            </span>
                        </div>
                        <div class="fw-bold" style="font-size:1rem;color:#1a1a2e;">
                            {{ $item->kredit->pengajuanKredit->motor->nama_motor ?? '-' }}
                        </div>
                        <div class="text-muted" style="font-size:13px;">
                            <i class="fas fa-trademark me-1"></i>
                            {{ $item->kredit->pengajuanKredit->motor->merk ?? '-' }}
                        </div>
                    </div>

                    {{-- Detail Bayar --}}
                    <div class="col-md-2">
                        <div class="detail-label">Total Bayar</div>
                        <div class="detail-val text-success">
                            Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                        </div>
                        <div class="detail-label mt-2">Tgl Bayar</div>
                        <div class="detail-val-sm">
                            {{ $item->tgl_bayar
                                ? \Carbon\Carbon::parse($item->tgl_bayar)->format('d/m/Y')
                                : '-' }}
                        </div>
                    </div>

                    {{-- Jatuh Tempo --}}
                    <div class="col-md-2">
                        <div class="detail-label">Jatuh Tempo</div>
                        <div class="detail-val-sm">
                            {{ $item->tgl_jatuh_tempo
                                ? \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d/m/Y')
                                : '-' }}
                        </div>
                        @if($sisaLabel)
                        <div class="mt-2">
                            <span class="sisa-badge sisa-{{ $color }}">
                                <i class="fas fa-hourglass-half me-1"></i>{{ $sisaLabel }}
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Status --}}
                    <div class="col-md-1 d-none d-md-block">
                        <span class="status-badge status-{{ $color }}">{{ $statusLabel }}</span>
                    </div>

                    {{-- Aksi --}}
         <div class="col-md-2 text-md-end d-flex flex-md-column gap-2 justify-content-end">
    <a href="{{ route('client.angsuran.show', $item->id) }}"
       class="acard-btn acard-btn-outline">
        <i class="fas fa-eye me-1"></i> Detail
    </a>
    
    @if(!$isLunas)
        <a href="{{ route('client.angsuran.form-bayar', $item->id) }}"
           class="acard-btn acard-btn-pay {{ $isNearDue ? 'btn-pulse' : '' }}">
            <i class="fas fa-money-bill-wave me-1"></i> Bayar
        </a>
    @else
        {{-- TOMBOL CETAK KWITANSI UNTUK YANG SUDAH LUNAS --}}
        <a href="{{ route('client.angsuran.print', $item->id) }}" 
           target="_blank"
           class="acard-btn acard-btn-print">
            <i class="fas fa-print me-1"></i> Cetak Kwitansi
        </a>
    @endif
</div>

                </div>

                @if($item->keterangan)
                <div class="acard-note mt-3">
                    <i class="fas fa-sticky-note me-1"></i>
                    {{ \Illuminate\Support\Str::limit($item->keterangan, 120) }}
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state-card text-center py-5">
            <div class="empty-icon mx-auto mb-4">
                <i class="fas fa-receipt fa-3x" style="color:#667eea;"></i>
            </div>
            <h4 class="fw-bold mb-2">
                @if($tab === 'lunas') Belum Ada Angsuran Lunas
                @elseif($tab === 'belum_bayar') Tidak Ada Angsuran Belum Bayar
                @else Belum Ada Angsuran
                @endif
            </h4>
            <p class="text-muted">Tidak ada data untuk ditampilkan</p>
        </div>
        @endforelse
    </div>

    @if($angsuran->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $angsuran->links('pagination::bootstrap-4') }}
    </div>
    @endif

</div>

{{-- ═══ TOAST ══════════════════════════════════════════════════════════════════ --}}
@if(isset($notifikasi) && $notifikasi->count() > 0)
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:1100;">
    @foreach($notifikasi->take(3) as $n)
    @php
        $s = $n->sisa_hari;
        $tl = $s < 0 ? 'Lewat '.abs($s).' hari' : ($s === 0 ? 'Hari ini!' : $s.' hari lagi');
        $tc = $s < 0 ? 'danger' : ($s <= 3 ? 'warning' : 'info');
    @endphp
    <div class="toast align-items-center text-bg-{{ $tc }} border-0 mb-2"
         role="alert" id="toast-{{ $n->id }}">
        <div class="d-flex">
            <div class="toast-body">
                <strong><i class="fas fa-bell me-1"></i> Jatuh Tempo!</strong><br>
                <span class="small">
                    {{ $n->kredit->pengajuanKredit->motor->nama_motor ?? 'Motor' }}
                    — #{{ $n->angsuran_ke }}: <strong>{{ $tl }}</strong>
                </span>
                <div class="mt-2">
                    <a href="{{ route('client.angsuran.form-bayar', $n->id) }}"
                       class="btn btn-sm btn-light rounded-pill px-3">Bayar</a>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endforeach
</div>
@endif

<style>
/* ── Stat cards ─────────────────────────────────────────────────────────── */
.stat-card { background:#fff;border-radius:1rem;border:1px solid #eaecf0;
             padding:1.1rem .75rem;text-align:center;
             transition:transform .25s,box-shadow .25s; }
.stat-card:hover { transform:translateY(-3px);box-shadow:0 12px 24px -8px rgba(0,0,0,.08); }
.stat-icon-wrap { width:48px;height:48px;border-radius:50%;
                  display:flex;align-items:center;justify-content:center;
                  font-size:1.25rem;margin:0 auto .6rem; }
.stat-num   { font-size:1.6rem;font-weight:800;line-height:1; }
.stat-label { font-size:12px;color:#888;margin-top:4px; }
.stat-success  .stat-icon-wrap { background:rgba(16,185,129,.12);color:#10b981; }
.stat-success  .stat-num       { color:#10b981; }
.stat-secondary .stat-icon-wrap{ background:rgba(100,116,139,.12);color:#64748b; }
.stat-secondary .stat-num      { color:#64748b; }
.stat-warning  .stat-icon-wrap { background:rgba(245,158,11,.12);color:#f59e0b; }
.stat-warning  .stat-num       { color:#f59e0b; }
.stat-danger   .stat-icon-wrap { background:rgba(239,68,68,.12);color:#ef4444; }
.stat-danger   .stat-num       { color:#ef4444; }

/* ── Tabs ───────────────────────────────────────────────────────────────── */
.tab-wrap { display:flex;gap:8px;flex-wrap:wrap; }
.tab-btn {
    display:inline-block;padding:9px 20px;border-radius:999px;
    font-size:13.5px;font-weight:600;text-decoration:none;
    border:1.5px solid #dde3ea;color:#555;background:#fff;
    transition:all .2s;
}
.tab-btn:hover { border-color:#667eea;color:#667eea; }
.tab-active {
    background:linear-gradient(135deg,#667eea,#764ba2) !important;
    border-color:transparent !important;color:#fff !important;
    box-shadow:0 4px 14px rgba(102,126,234,.3);
}

/* ── Filter card ────────────────────────────────────────────────────────── */
.filter-card { background:#f8fafc;border:1px solid #e8edf2;border-radius:1rem;padding:1rem 1.25rem; }
.search-wrap { position:relative; }
.search-icon { position:absolute;left:14px;top:50%;transform:translateY(-50%);
               color:#aaa;font-size:13px;pointer-events:none; }
.search-input{ width:100%;padding:9px 14px 9px 38px;border:1px solid #dde3ea;
               border-radius:999px;background:#fff;font-size:14px;
               outline:none;transition:border-color .2s; }
.search-input:focus { border-color:#667eea; }
.btn-reset   { padding:9px 0;border:1px solid #dde3ea;border-radius:999px;
               background:#fff;font-size:13.5px;color:#555;cursor:pointer;transition:all .2s; }
.btn-reset:hover { background:#f1f3f5;border-color:#aaa; }

/* ── Angsuran card ──────────────────────────────────────────────────────── */
.angsuran-card { background:#fff;border:1px solid #eaecf0;border-radius:1rem;
                 overflow:hidden;display:flex;
                 transition:transform .28s cubic-bezier(.22,.68,0,1.2),box-shadow .28s ease; }
.angsuran-card:hover { transform:translateY(-4px);box-shadow:0 20px 36px -12px rgba(0,0,0,.1); }
.acard-strip { width:5px;flex-shrink:0; }
.acard-body  { flex:1;padding:1.25rem 1.5rem; }
.acard-btn-print {
    background: linear-gradient(135deg, #64748b, #475569);
    color: #fff;
}
.acard-btn-print:hover {
    opacity: .88;
    color: #fff;
    transform: translateY(-1px);
}
.acard-icon { width:52px;height:52px;border-radius:50%;
              display:flex;align-items:center;justify-content:center;font-size:1.3rem; }
.bg-success-soft  { background:rgba(16,185,129,.12); }
.bg-warning-soft  { background:rgba(245,158,11,.12); }
.bg-danger-soft   { background:rgba(239,68,68,.12); }
.bg-secondary-soft{ background:rgba(100,116,139,.12); }

.chip { display:inline-block;font-size:11.5px;font-weight:600;padding:3px 10px;border-radius:999px; }
.chip-primary { background:rgba(102,126,234,.1);color:#5059d4; }

.detail-label  { font-size:12px;color:#aaa;margin-bottom:2px; }
.detail-val    { font-size:1.1rem;font-weight:700; }
.detail-val-sm { font-size:.9rem;font-weight:600;color:#333; }

.sisa-badge { display:inline-block;font-size:11.5px;font-weight:700;
              padding:4px 10px;border-radius:999px; }
.sisa-warning  { background:rgba(245,158,11,.12);color:#b7791f;border:1px solid rgba(245,158,11,.3); }
.sisa-danger   { background:rgba(239,68,68,.12);color:#9b2c2c;border:1px solid rgba(239,68,68,.3); }
.sisa-secondary{ background:rgba(100,116,139,.1);color:#4a5568;border:1px solid #dde3ea; }

.status-badge { display:block;font-size:11px;font-weight:600;
                padding:4px 8px;border-radius:999px;text-align:center;white-space:normal; }
.status-success  { background:rgba(16,185,129,.1);color:#276749;border:1px solid rgba(16,185,129,.3); }
.status-warning  { background:rgba(245,158,11,.1);color:#b7791f;border:1px solid rgba(245,158,11,.3); }
.status-danger   { background:rgba(239,68,68,.1);color:#9b2c2c;border:1px solid rgba(239,68,68,.3); }
.status-secondary{ background:#f1f3f5;color:#4a5568;border:1px solid #dde3ea; }

.acard-btn { display:inline-block;text-align:center;padding:8px 16px;
             border-radius:999px;font-size:13px;font-weight:600;
             cursor:pointer;border:none;text-decoration:none;
             transition:all .2s;white-space:nowrap; }
.acard-btn-outline { border:1.5px solid #667eea !important;color:#667eea;background:transparent; }
.acard-btn-outline:hover { background:linear-gradient(135deg,#667eea,#764ba2);
                           border-color:transparent !important;color:#fff; }
.acard-btn-pay { background:linear-gradient(135deg,#10b981,#059669);color:#fff; }
.acard-btn-pay:hover { opacity:.88;color:#fff;transform:translateY(-1px); }

@keyframes pulse-green {
    0%   { box-shadow:0 0 0 0 rgba(245,158,11,.6); }
    70%  { box-shadow:0 0 0 8px rgba(245,158,11,0); }
    100% { box-shadow:0 0 0 0 rgba(245,158,11,0); }
}
.btn-pulse { animation:pulse-green 1.8s infinite; }

.acard-note { background:#f8fafc;border-left:3px solid #dde3ea;
              border-radius:0 .5rem .5rem 0;padding:8px 12px;font-size:13px;color:#666; }

/* ── Notif banner ───────────────────────────────────────────────────────── */
.notif-banner { background:linear-gradient(135deg,#fff5f5,#fff9ed);
                border:1px solid #fca5a5;position:relative;overflow:hidden; }
.notif-glow   { position:absolute;inset:0;pointer-events:none;border-radius:inherit;
                background:radial-gradient(ellipse at 80% 50%,rgba(239,68,68,.06),transparent 70%); }
.notif-bell   { width:44px;height:44px;background:rgba(239,68,68,.1);border-radius:50%;
                display:flex;align-items:center;justify-content:center;color:#dc2626;
                flex-shrink:0;animation:bell-shake 2s ease-in-out infinite; }
@keyframes bell-shake {
    0%,100%{transform:rotate(0)}10%,30%{transform:rotate(-12deg)}20%,40%{transform:rotate(12deg)}50%{transform:rotate(0)}
}
.notif-chip { display:inline-block;font-size:12px;font-weight:600;padding:4px 12px;border-radius:999px; }
.notif-chip-danger  { background:rgba(239,68,68,.1);color:#9b2c2c;border:1px solid rgba(239,68,68,.3); }
.notif-chip-warning { background:rgba(245,158,11,.1);color:#b7791f;border:1px solid rgba(245,158,11,.3); }
.notif-chip-info    { background:rgba(59,130,246,.1);color:#1e40af;border:1px solid rgba(59,130,246,.3); }

/* ── Empty state ────────────────────────────────────────────────────────── */
.empty-state-card { background:#fff;border:1px solid #eaecf0;border-radius:1rem; }
.empty-icon { width:80px;height:80px;background:rgba(102,126,234,.1);
              border-radius:50%;display:flex;align-items:center;justify-content:center; }

.pagination {
    --bs-pagination-color:#667eea;
    --bs-pagination-active-bg:#667eea;
    --bs-pagination-active-border-color:#667eea;
}
.rounded-4 { border-radius:1rem !important; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const nearDueOnly = document.getElementById('nearDueOnly');
    const resetBtn    = document.getElementById('resetFilter');
    const items       = document.querySelectorAll('.angsuran-item');
    const list        = document.getElementById('angsuranList');

    function filterItems() {
        const q      = (searchInput?.value || '').toLowerCase();
        const ndOnly = nearDueOnly?.checked || false;
        let visible  = 0;

        items.forEach(item => {
            const okSearch  = !q      || (item.dataset.search || '').includes(q);
            const okNearDue = !ndOnly || item.dataset.nearDue === '1';
            const show = okSearch && okNearDue;
            item.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        let noRes = document.getElementById('noResultMsg');
        if (visible === 0 && items.length > 0) {
            if (!noRes) {
                noRes = document.createElement('div');
                noRes.id = 'noResultMsg';
                noRes.className = 'empty-state-card text-center py-4 mb-3';
                noRes.innerHTML = `
                    <div class="empty-icon mx-auto mb-3">
                        <i class="fas fa-search fa-2x" style="color:#667eea;"></i>
                    </div>
                    <h5 class="fw-bold">Tidak ada hasil</h5>
                    <p class="text-muted small">Coba kata kunci yang berbeda</p>
                    <button id="resetFromMsg" class="acard-btn acard-btn-pay" style="border:none;">
                        Reset Filter
                    </button>`;
                list.prepend(noRes);
                document.getElementById('resetFromMsg')?.addEventListener('click', () => resetBtn?.click());
            }
        } else if (noRes) {
            noRes.remove();
        }
    }

    searchInput?.addEventListener('keyup', filterItems);
    nearDueOnly?.addEventListener('change', filterItems);
    resetBtn?.addEventListener('click', () => {
        if (searchInput)  searchInput.value   = '';
        if (nearDueOnly)  nearDueOnly.checked = false;
        filterItems();
    });

    // Toast notifikasi
    document.querySelectorAll('.toast').forEach((el, i) => {
        const t = new bootstrap.Toast(el, { delay: 5000 + i * 1200 });
        setTimeout(() => t.show(), 800 + i * 600);
    });
});
</script>

@if(session('success'))
<script>
    Swal.fire({ title:'Berhasil!', text:'{{ session('success') }}',
        icon:'success', confirmButtonColor:'#667eea', timer:3000, timerProgressBar:true });
</script>
@endif
@if(session('info'))
<script>
    Swal.fire({ title:'Info', text:'{{ session('info') }}',
        icon:'info', confirmButtonColor:'#667eea' });
</script>
@endif
@endsection
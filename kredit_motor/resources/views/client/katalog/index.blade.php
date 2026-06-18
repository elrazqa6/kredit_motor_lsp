@extends('layouts.client')

@section('title', 'Katalog Motor - Temukan Motor Impian Anda')

@section('content')
<div class="container px-0">

    {{-- ═══ FILTER & SEARCH ═══════════════════════════════════════════════════ --}}
    <div class="filter-section mb-5">
        <div class="card border-0 rounded-4" style="background:#f8fafc;border:1px solid #e8edf2 !important;">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="fas fa-search me-1"></i> Cari Motor
                        </label>
                        <div class="input-wrapper position-relative">
                            <i class="fas fa-search position-absolute top-50 translate-middle-y ms-3 text-muted" style="left:0;font-size:13px;"></i>
                            <input type="text" id="searchMotor"
                                   class="form-control rounded-pill ps-5"
                                   style="background:#fff;border:1px solid #dde3ea;"
                                   placeholder="Cari nama motor atau merk...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="fas fa-filter me-1"></i> Filter Merk
                        </label>
                        <select id="filterMerk" class="form-select rounded-pill"
                                style="background:#fff;border:1px solid #dde3ea;">
                            <option value="">Semua Merk</option>
                            @php $merks = $motors->pluck('merk')->unique()->sort(); @endphp
                            @foreach($merks as $merk)
                                <option value="{{ $merk }}">{{ $merk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="fas fa-sort-amount-down me-1"></i> Urutkan
                        </label>
                        <select id="sortBy" class="form-select rounded-pill"
                                style="background:#fff;border:1px solid #dde3ea;">
                            <option value="default">Default</option>
                            <option value="price_asc">Harga Terendah</option>
                            <option value="price_desc">Harga Tertinggi</option>
                            <option value="name_asc">Nama A-Z</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="resetFilter" class="btn btn-outline-secondary rounded-pill w-100">
                            <i class="fas fa-redo-alt me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ GRID MOTOR ════════════════════════════════════════════════════════ --}}
    <div class="row g-4" id="motorGrid">
        @forelse($motors as $motor)
        @php
            $idx = $loop->index;
            $badgeClass = match(true) {
                $idx % 5 === 0 => ['label' => 'Hot Deal',    'icon' => 'fa-fire',       'bg' => 'badge-hot'],
                $idx % 4 === 0 => ['label' => 'Best Seller', 'icon' => 'fa-crown',      'bg' => 'badge-best'],
                $idx % 3 === 0 => ['label' => 'Populer',     'icon' => 'fa-thumbs-up',  'bg' => 'badge-pop'],
                default        => ['label' => 'New',         'icon' => 'fa-bolt',       'bg' => 'badge-new'],
            };
        @endphp

        <div class="col-md-6 col-lg-4 motor-item"
             data-merk="{{ $motor->merk }}"
             data-nama="{{ strtolower($motor->nama_motor) }}"
             data-harga="{{ $motor->harga_jual }}"
             data-nama-asli="{{ $motor->nama_motor }}">

            <div class="motor-card h-100">

                {{-- ── Gambar ─────────────────────────────────────────────── --}}
                <div class="motor-img-wrap position-relative overflow-hidden">
                    @if($motor->foto1 && file_exists(public_path('storage/'.$motor->foto1)))
                        <img src="{{ asset('storage/'.$motor->foto1) }}"
                             class="motor-img w-100 h-100"
                             alt="{{ $motor->nama_motor }}"
                             loading="lazy">
                    @else
                        <div class="motor-img-placeholder d-flex align-items-center justify-content-center w-100 h-100">
                            <i class="fas fa-motorcycle fa-4x text-white" style="opacity:.4"></i>
                        </div>
                    @endif

                    {{-- Badge --}}
                    <span class="motor-badge {{ $badgeClass['bg'] }}">
                        <i class="fas {{ $badgeClass['icon'] }} me-1"></i>{{ $badgeClass['label'] }}
                    </span>

                    
                </div>

                {{-- ── Body ───────────────────────────────────────────────── --}}
                <div class="motor-body p-4">
                    {{-- Merk & Rating --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="merk-chip">
                            <i class="fas fa-trademark me-1"></i>{{ $motor->merk }}
                        </span>
                        <div class="rating-stars">
                            @for($i = 0; $i < 4; $i++)
                            <i class="fas fa-star"></i>
                            @endfor
                            <i class="fas fa-star-half-alt"></i>
                            <span class="ms-1" style="font-size:12px;color:#aaa;">(4.5)</span>
                        </div>
                    </div>

                    {{-- Nama & Jenis --}}
                    <h5 class="motor-name mb-1">{{ $motor->nama_motor }}</h5>
                    <p class="motor-jenis mb-4">
                        <i class="fas fa-layer-group me-1"></i>
                        {{ $motor->jenisMotor->nama_jenis ?? 'Motor Sport' }}
                    </p>

                    {{-- Harga --}}
                    <div class="harga-row mb-3">
                        <span class="harga-label">Harga OTR</span>
                        <span class="harga-value">
                            Rp {{ number_format($motor->harga_jual, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="price-bar mb-4">
                        <div class="price-bar-fill"></div>
                    </div>

                    {{-- Estimasi Cicilan --}}
                    <div class="cicilan-box mb-4">
                        <div class="d-flex justify-content-between align-items-end">
                            <div>
                                <small class="text-muted"><i class="fas fa-calculator me-1"></i>Est. Cicilan</small>
                                <div class="cicilan-value">
                                    Rp {{ number_format($motor->harga_jual * 0.035, 0, ',', '.') }}
                                    <span class="cicilan-per">/bulan</span>
                                </div>
                                <small class="text-muted">tenor 24 bulan</small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">DP Mulai</small>
                                <div class="dp-value">
                                    Rp {{ number_format($motor->harga_jual * 0.1, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('client.motor.show', $motor->id) }}"
                           class="btn-detail flex-grow-1 text-center">
                            <i class="fas fa-info-circle me-1"></i> Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5 my-5">
                <div class="empty-icon mx-auto mb-4">
                    <i class="fas fa-motorcycle fa-3x" style="color:#667eea;"></i>
                </div>
                <h3 class="fw-bold mb-2">Belum Ada Motor</h3>
                <p class="text-muted mb-4">Data motor belum tersedia. Silakan cek kembali nanti.</p>
                <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-5">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(method_exists($motors, 'links') && $motors->hasPages())
    <div class="d-flex justify-content-center mt-5 pt-4">
        {{ $motors->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

{{-- ═══ MODAL SIMULASI ═══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="simulasiCepatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">

            <div class="modal-header border-0 rounded-top-4 px-4 py-3"
                 style="background:linear-gradient(135deg,#667eea,#764ba2);">
                <h5 class="modal-title text-white fw-bold">
                    <i class="fas fa-chart-line me-2"></i> Simulasi Kredit Cepat
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="rounded-4 p-4 text-center" style="background:#f5f7ff;">
                            <div class="sim-motor-icon mx-auto mb-3">
                                <i class="fas fa-motorcycle fa-2x" style="color:#667eea;"></i>
                            </div>
                            <p class="text-muted small mb-1">Motor Pilihan</p>
                            <div class="fw-bold fs-5" id="modalMotorName">-</div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">Harga Motor</span>
                                <strong id="modalHargaMotor">Rp 0</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">
                                <i class="fas fa-percent me-1 text-primary"></i> DP (Down Payment)
                            </label>
                            <input type="range" class="form-range" id="dpRange"
                                   min="10" max="30" step="5" value="20">
                            <div class="d-flex justify-content-between mt-1">
                                <span class="text-muted small">10%</span>
                                <span class="fw-bold text-primary" id="dpPersenValue">20%</span>
                                <span class="text-muted small">30%</span>
                            </div>
                            <div class="text-center mt-1 small fw-semibold" id="dpRupiahDisplay">Rp 0</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">
                                <i class="fas fa-calendar-alt me-1 text-primary"></i> Tenor
                            </label>
                            <select class="form-select rounded-3" id="tenorSelect">
                                <option value="12">12 bulan (1 tahun)</option>
                                <option value="24" selected>24 bulan (2 tahun)</option>
                                <option value="36">36 bulan (3 tahun)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="rounded-4 p-4 mt-2 text-white"
                     style="background:linear-gradient(135deg,#4facfe,#00f2fe);">
                    <div class="row mb-3">
                        <div class="col-6">
                            <small style="opacity:.8;">Pokok Pinjaman</small>
                            <div class="fw-bold" id="pokokPinjaman">Rp 0</div>
                        </div>
                        <div class="col-6">
                            <small style="opacity:.8;">Total Bunga (8%/thn)</small>
                            <div class="fw-bold" id="bungaTotal">Rp 0</div>
                        </div>
                    </div>
                    <div class="border-top border-white border-opacity-25 pt-3 d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Cicilan per Bulan:</span>
                        <span class="fs-3 fw-bold" id="cicilanHasil">Rp 0</span>
                    </div>
                </div>

                <p class="text-muted text-center small mt-3 mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    Estimasi bunga flat 8% per tahun. Angka dapat berbeda saat pengajuan resmi.
                </p>
            </div>

            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Tutup</button>
                @auth
                    @if(auth()->user()->role == 'client')
                    <a href="{{ route('client.pengajuan.create') }}"
                       class="btn rounded-pill px-5 fw-semibold text-white"
                       style="background:linear-gradient(135deg,#667eea,#764ba2);" id="ajukanViaModal">
                        <i class="fas fa-paper-plane me-2"></i> Ajukan Kredit
                    </a>
                    @endif
                @else
                <a href="{{ route('login') }}"
                   class="btn rounded-pill px-5 fw-semibold text-white"
                   style="background:linear-gradient(135deg,#667eea,#764ba2);">
                    <i class="fas fa-sign-in-alt me-2"></i> Login untuk Ajukan
                </a>
                @endguest
            </div>
        </div>
    </div>
</div>

{{-- ═══ STYLES ═════════════════════════════════════════════════════════════════ --}}
<style>
/* ── Card ─────────────────────────────────────────────────────────────────── */
.motor-card {
    background: #fff;
    border-radius: 1.25rem;
    border: 1px solid #eaecf0;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform .32s cubic-bezier(.22,.68,0,1.2), box-shadow .32s ease;
}
.motor-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 24px 48px -12px rgba(102,126,234,.18);
}

/* ── Image wrapper ────────────────────────────────────────────────────────── */
.motor-img-wrap { height: 240px; background: #f0f2f8; }
.motor-img { object-fit: cover; transition: transform .5s ease; }
.motor-card:hover .motor-img { transform: scale(1.06); }
.motor-img-placeholder { background: linear-gradient(135deg,#667eea,#764ba2); }

/* ── Badge ───────────────────────────────────────────────────────────────── */
.motor-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .3px;
}
.badge-hot  { background:#fff0f0; color:#d63031; border:1px solid #ffb3b3; }
.badge-best { background:#fffbeb; color:#b7791f; border:1px solid #fbd38d; }
.badge-pop  { background:#f0fff4; color:#276749; border:1px solid #9ae6b4; }
.badge-new  { background:#ebf4ff; color:#2b6cb0; border:1px solid #90cdf4; }

/* ── Hover bar (BUKAN full overlay) ──────────────────────────────────────── */
.motor-hover-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    gap: 8px;
    padding: 12px;
    background: linear-gradient(to top, rgba(0,0,0,.55) 0%, transparent 100%);
    transform: translateY(100%);
    transition: transform .3s ease;
}
.motor-card:hover .motor-hover-bar { transform: translateY(0); }

.mhb-btn {
    flex: 1;
    padding: 8px 0;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    border: none;
    transition: opacity .2s;
    text-decoration: none;
    display: inline-block;
}
.mhb-btn:hover { opacity: .88; }
.mhb-outline { background: rgba(255,255,255,.92); color: #333; }
.mhb-yellow  { background: #f6c90e; color: #1a1a1a; }

/* ── Body ────────────────────────────────────────────────────────────────── */
.motor-body { flex: 1; display: flex; flex-direction: column; }

.merk-chip {
    background: #eef0fd;
    color: #4a5ae8;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 999px;
}

.rating-stars { color: #f6ad55; font-size: 13px; }

.motor-name { font-size: 1.05rem; font-weight: 700; color: #1a1a2e; }
.motor-jenis { font-size: 13px; color: #aaa; }

.harga-row { display: flex; justify-content: space-between; align-items: baseline; }
.harga-label { font-size: 12px; color: #aaa; }
.harga-value { font-size: 1.35rem; font-weight: 800; color: #667eea; }

.price-bar { height: 3px; background: #e8ecff; border-radius: 99px; overflow: hidden; }
.price-bar-fill { height: 100%; width: 100%; background: linear-gradient(90deg,#667eea,#764ba2); }

.cicilan-box {
    background: linear-gradient(135deg,#f8f9ff,#eef0fd);
    border-radius: .75rem;
    padding: 14px;
}
.cicilan-value { font-size: 1.1rem; font-weight: 700; color: #10b981; }
.cicilan-per   { font-size: 12px; font-weight: 400; color: #888; }
.dp-value      { font-size: .95rem; font-weight: 700; color: #667eea; }

/* ── Action buttons ──────────────────────────────────────────────────────── */
.btn-detail {
    display: inline-block;
    padding: 9px 0;
    border-radius: 999px;
    border: 1.5px solid #667eea;
    color: #667eea;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    transition: all .22s;
}
.btn-detail:hover {
    background: linear-gradient(135deg,#667eea,#764ba2);
    border-color: transparent;
    color: #fff;
}
.btn-simulasi {
    width: 44px;
    height: 44px;
    flex-shrink: 0;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg,#667eea,#764ba2);
    color: #fff;
    font-size: 15px;
    cursor: pointer;
    transition: transform .2s, box-shadow .2s;
}
.btn-simulasi:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 14px rgba(102,126,234,.45);
}

/* ── Empty state ─────────────────────────────────────────────────────────── */
.empty-icon {
    width: 90px; height: 90px;
    background: #eef0fd;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}

/* ── Simulasi modal inner icon ───────────────────────────────────────────── */
.sim-motor-icon {
    width: 60px; height: 60px;
    background: #eef0fd;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}

/* ── Filter card ──────────────────────────────────────────────────────────── */
.filter-section { animation: slideDown .4s ease; }
@keyframes slideDown {
    from { opacity:0; transform:translateY(-16px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ── Pagination colour ────────────────────────────────────────────────────── */
.pagination {
    --bs-pagination-color: #667eea;
    --bs-pagination-active-bg: #667eea;
    --bs-pagination-active-border-color: #667eea;
}
</style>

{{-- ═══ SCRIPTS ════════════════════════════════════════════════════════════════ --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Filter & Sort ─────────────────────────────────────────────────── */
    const searchInput = document.getElementById('searchMotor');
    const filterMerk  = document.getElementById('filterMerk');
    const sortBy      = document.getElementById('sortBy');
    const resetBtn    = document.getElementById('resetFilter');
    const motorItems  = document.querySelectorAll('.motor-item');
    const motorGrid   = document.getElementById('motorGrid');

    function filterAndSort() {
        const q     = (searchInput?.value || '').toLowerCase();
        const merk  = filterMerk?.value || '';
        const sort  = sortBy?.value || 'default';
        const shown = [];

        motorItems.forEach(item => {
            const ok = (!merk || item.dataset.merk === merk) &&
                       (!q    || item.dataset.nama.includes(q));
            item.style.display = ok ? '' : 'none';
            if (ok) shown.push(item);
        });

        if (sort !== 'default' && shown.length) {
            shown.sort((a, b) => {
                if (sort === 'price_asc')  return +a.dataset.harga - +b.dataset.harga;
                if (sort === 'price_desc') return +b.dataset.harga - +a.dataset.harga;
                if (sort === 'name_asc')   return a.dataset.namaAsli.localeCompare(b.dataset.namaAsli);
                return 0;
            });
            shown.forEach(item => motorGrid.appendChild(item));
        }
    }

    searchInput?.addEventListener('keyup', filterAndSort);
    filterMerk?.addEventListener('change', filterAndSort);
    sortBy?.addEventListener('change', filterAndSort);
    resetBtn?.addEventListener('click', () => {
        if (searchInput) searchInput.value = '';
        if (filterMerk)  filterMerk.value  = '';
        if (sortBy)      sortBy.value      = 'default';
        filterAndSort();
    });

    /* ── Simulasi Kredit ────────────────────────────────────────────────── */
    let selHarga = 0;

    const fmt = v => 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(v));

    function hitungSimulasi() {
        if (!selHarga) return;
        const dp    = parseInt(document.getElementById('dpRange').value);
        const tenor = parseInt(document.getElementById('tenorSelect').value);
        const dpVal = selHarga * dp / 100;
        const pokok = selHarga - dpVal;
        const bunga = pokok * 0.08 * (tenor / 12);
        const cicilan = (pokok + bunga) / tenor;

        document.getElementById('dpPersenValue').textContent  = dp + '%';
        document.getElementById('dpRupiahDisplay').textContent = fmt(dpVal);
        document.getElementById('pokokPinjaman').textContent  = fmt(pokok);
        document.getElementById('bungaTotal').textContent     = fmt(bunga);
        document.getElementById('cicilanHasil').textContent   = fmt(cicilan);
    }

    document.querySelectorAll('.quick-simulasi').forEach(btn => {
        btn.addEventListener('click', function () {
            selHarga = parseInt(this.dataset.harga);
            document.getElementById('modalMotorName').textContent  = this.dataset.nama;
            document.getElementById('modalHargaMotor').textContent = fmt(selHarga);
            document.getElementById('dpRange').value   = 20;
            document.getElementById('tenorSelect').value = 24;
            hitungSimulasi();
        });
    });

    document.getElementById('dpRange')?.addEventListener('input', hitungSimulasi);
    document.getElementById('tenorSelect')?.addEventListener('change', hitungSimulasi);
});
</script>
@endsection
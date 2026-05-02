@extends('layouts.client')

@section('title', 'Detail Angsuran #' . $angsuran->angsuran_ke)

@section('content')
@php
    $isLunas  = !is_null($angsuran->tgl_bayar);
    $sisaHari = $sisaHari ?? null; // dari controller

    if ($isLunas) {
        $statusLabel = 'Lunas';
        $color       = 'success';
        $icon        = 'fa-check-circle';
        $statusMsg   = 'Angsuran ini telah lunas. Terima kasih atas pembayaran Anda!';
    } elseif ($angsuran->tgl_jatuh_tempo && \Carbon\Carbon::parse($angsuran->tgl_jatuh_tempo)->lt(now())) {
        $statusLabel = 'Jatuh Tempo';
        $color       = 'danger';
        $icon        = 'fa-fire';
        $statusMsg   = 'Angsuran ini sudah melewati jatuh tempo. Segera lakukan pembayaran.';
    } elseif ($sisaHari !== null && $sisaHari <= 7) {
        $statusLabel = 'Hampir Jatuh Tempo';
        $color       = 'warning';
        $icon        = 'fa-exclamation-triangle';
        $statusMsg   = 'Angsuran ini mendekati jatuh tempo. Segera lakukan pembayaran.';
    } else {
        $statusLabel = 'Belum Bayar';
        $color       = 'secondary';
        $icon        = 'fa-clock';
        $statusMsg   = 'Angsuran ini belum dibayar.';
    }

    $sisaLabel = null;
    if (!$isLunas && $sisaHari !== null) {
        $sisaLabel = $sisaHari < 0
            ? 'Terlambat ' . abs($sisaHari) . ' hari'
            : ($sisaHari === 0 ? 'Jatuh tempo hari ini!' : $sisaHari . ' hari lagi menuju jatuh tempo');
    }

    $motor   = $angsuran->kredit->pengajuanKredit->motor   ?? null;
    $kredit  = $angsuran->kredit                            ?? null;
    $pengajuan = $angsuran->kredit->pengajuanKredit         ?? null;

    $statusKredit  = $kredit->status_kredit ?? '-';
    $kreditBadge   = match($statusKredit) {
        'Dicicil' => ['label' => 'Aktif',       'color' => 'primary'],
        'Lunas'   => ['label' => 'Lunas',        'color' => 'success'],
        default   => ['label' => 'Bermasalah',   'color' => 'danger'],
    };
@endphp

<div class="container px-0" style="max-width:960px;">

    {{-- ═══ BREADCRUMB & BACK ═══════════════════════════════════════════════ --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="fas fa-receipt text-primary me-2"></i>
                Detail Angsuran <span class="text-primary">#{{ $angsuran->angsuran_ke }}</span>
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size:13px;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('client.dashboard') }}" class="text-decoration-none">Beranda</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('client.angsuran.index') }}" class="text-decoration-none">Angsuran Saya</a>
                    </li>
                    <li class="breadcrumb-item active">Detail #{{ $angsuran->angsuran_ke }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('client.angsuran.index') }}" class="tab-btn mt-2 mt-sm-0">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- ═══ STATUS BANNER ════════════════════════════════════════════════════ --}}
    <div class="status-banner status-banner-{{ $color }} rounded-4 mb-4 p-4">
        <div class="d-flex align-items-center gap-3">
            <div class="banner-icon bg-{{ $color }}-soft">
                <i class="fas {{ $icon }} text-{{ $color }}"></i>
            </div>
            <div>
                <div class="fw-bold fs-6 mb-1">{{ $statusMsg }}</div>
                @if($sisaLabel)
                <span class="sisa-badge sisa-{{ $color }}">
                    <i class="fas fa-hourglass-half me-1"></i>{{ $sisaLabel }}
                </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══ KONTEN UTAMA ══════════════════════════════════════════════════════ --}}
    <div class="row g-4">

        {{-- ── KIRI ─────────────────────────────────────────────────────────── --}}
        <div class="col-lg-8">

            {{-- Detail Angsuran --}}
            <div class="detail-card mb-4">
                <div class="detail-card-header">
                    <i class="fas fa-info-circle text-primary me-2"></i> Detail Angsuran
                </div>
                <div class="detail-card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="info-box">
                                <div class="info-label">Angsuran Ke</div>
                                <div class="info-value" style="color:#667eea;">#{{ $angsuran->angsuran_ke }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <div class="info-label">Status</div>
                                <div class="info-value">
                                    <span class="status-chip status-{{ $color }}">
                                        <i class="fas {{ $icon }} me-1"></i>{{ $statusLabel }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <div class="info-label">Jatuh Tempo</div>
                                <div class="info-value">
                                    {{ $angsuran->tgl_jatuh_tempo
                                        ? \Carbon\Carbon::parse($angsuran->tgl_jatuh_tempo)->translatedFormat('d F Y')
                                        : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <div class="info-label">Tanggal Bayar</div>
                                <div class="info-value">
                                    {{ $angsuran->tgl_bayar
                                        ? \Carbon\Carbon::parse($angsuran->tgl_bayar)->translatedFormat('d F Y')
                                        : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-box" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
                                <div class="info-label">Total Bayar</div>
                                <div class="fw-bold text-success" style="font-size:1.5rem;">
                                    Rp {{ number_format($angsuran->total_bayar, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        @if($angsuran->keterangan)
                        <div class="col-12">
                            <div class="info-box">
                                <div class="info-label">Keterangan</div>
                                <div class="info-value">{{ $angsuran->keterangan }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Informasi Kredit --}}
            <div class="detail-card mb-4">
                <div class="detail-card-header">
                    <i class="fas fa-credit-card text-primary me-2"></i> Informasi Kredit
                </div>
                <div class="detail-card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="info-box">
                                <div class="info-label">ID Kredit</div>
                                <div class="info-value">#{{ $kredit->id ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <div class="info-label">Status Kredit</div>
                                <div class="info-value">
                                    <span class="status-chip status-{{ $kreditBadge['color'] }}">
                                        {{ $kreditBadge['label'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <div class="info-label">Total Kredit</div>
                                <div class="info-value">
                                    Rp {{ number_format($pengajuan->harga_kredit ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <div class="info-label">Sisa Kredit</div>
                                <div class="info-value text-warning">
                                    Rp {{ number_format($kredit->sisa_kredit ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <div class="info-label">Tgl Mulai Kredit</div>
                                <div class="info-value">
                                    {{ $kredit->tgl_mulai_kredit
                                        ? \Carbon\Carbon::parse($kredit->tgl_mulai_kredit)->translatedFormat('d F Y')
                                        : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <div class="info-label">Tgl Selesai Kredit</div>
                                <div class="info-value">
                                    {{ $kredit->tgl_selesai_kredit
                                        ? \Carbon\Carbon::parse($kredit->tgl_selesai_kredit)->translatedFormat('d F Y')
                                        : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Sistem --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <i class="fas fa-clock text-primary me-2"></i> Informasi Sistem
                </div>
                <div class="detail-card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="info-box">
                                <div class="info-label">Dibuat pada</div>
                                <div class="info-value">
                                    {{ \Carbon\Carbon::parse($angsuran->created_at)->translatedFormat('d F Y H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <div class="info-label">Terakhir diupdate</div>
                                <div class="info-value">
                                    {{ \Carbon\Carbon::parse($angsuran->updated_at)->translatedFormat('d F Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── KANAN ────────────────────────────────────────────────────────── --}}
        <div class="col-lg-4">

            {{-- Informasi Motor --}}
            <div class="detail-card mb-4">
                <div class="detail-card-header">
                    <i class="fas fa-motorcycle text-primary me-2"></i> Informasi Motor
                </div>
                <div class="detail-card-body">
                    {{-- Motor image / placeholder --}}
                    <div class="motor-thumb mb-3">
                        @if($motor && $motor->foto1 && file_exists(public_path('storage/'.$motor->foto1)))
                            <img src="{{ asset('storage/'.$motor->foto1) }}"
                                 class="w-100 h-100 rounded-3"
                                 style="object-fit:cover;" alt="{{ $motor->nama_motor }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100"
                                 style="background:linear-gradient(135deg,#eef0fd,#d9dcf8);border-radius:.75rem;">
                                <i class="fas fa-motorcycle fa-3x" style="color:#667eea;opacity:.5;"></i>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <div class="info-box">
                            <div class="info-label">Nama Motor</div>
                            <div class="info-value">{{ $motor->nama_motor ?? '-' }}</div>
                        </div>
                        <div class="info-box">
                            <div class="info-label">Merk</div>
                            <div class="info-value">{{ $motor->merk ?? '-' }}</div>
                        </div>
                        <div class="info-box">
                            <div class="info-label">Tipe</div>
                            <div class="info-value">{{ $motor->jenisMotor->nama_jenis ?? '-' }}</div>
                        </div>
                        <div class="info-box">
                            <div class="info-label">Tenor</div>
                            <div class="info-value">{{ $pengajuan->tenor ?? '-' }} bulan</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aksi --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <i class="fas fa-bolt text-primary me-2"></i> Aksi
                </div>
                <div class="detail-card-body">
                    @if(!$isLunas)
                    <a href="{{ route('client.angsuran.form-bayar', $angsuran->id) }}"
                       class="action-btn action-btn-pay mb-2">
                        <i class="fas fa-money-bill-wave me-2"></i> Bayar Sekarang
                    </a>
                    @else
                    <div class="text-center py-2 mb-3">
                        <div class="banner-icon bg-success-soft mx-auto mb-2">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                        <div class="fw-bold text-success small">Pembayaran Berhasil</div>
                        <div class="text-muted" style="font-size:12px;">Angsuran telah lunas</div>
                    </div>
                    @if($angsuran->bukti_bayar ?? false)
                    <a href="{{ asset('storage/'.$angsuran->bukti_bayar) }}" target="_blank"
                       class="action-btn action-btn-outline mb-2">
                        <i class="fas fa-receipt me-2"></i> Lihat Bukti Bayar
                    </a>
                    @endif
                    @endif
                    <a href="{{ route('client.angsuran.index') }}"
                       class="action-btn action-btn-outline">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* ── Card ─────────────────────────────────────────────────────────────────── */
.detail-card {
    background: #fff;
    border: 1px solid #eaecf0;
    border-radius: 1rem;
    overflow: hidden;
}
.detail-card-header {
    padding: 1rem 1.25rem .75rem;
    font-weight: 700;
    font-size: .95rem;
    color: #1a1a2e;
    border-bottom: 1px solid #f1f3f5;
    background: #fafbff;
}
.detail-card-body { padding: 1.25rem; }

/* ── Info box ─────────────────────────────────────────────────────────────── */
.info-box {
    background: #f8fafc;
    border-radius: .75rem;
    padding: 10px 14px;
}
.info-label {
    font-size: 11px;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 4px;
}
.info-value { font-size: 14px; font-weight: 600; color: #1e293b; }

/* ── Status banner ────────────────────────────────────────────────────────── */
.status-banner { border-width: 1px; border-style: solid; }
.status-banner-success  { background: #f0fdf4; border-color: #86efac; }
.status-banner-warning  { background: #fffbeb; border-color: #fcd34d; }
.status-banner-danger   { background: #fff1f2; border-color: #fca5a5; }
.status-banner-secondary{ background: #f8fafc; border-color: #cbd5e1; }

.banner-icon {
    width: 48px; height: 48px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
}
.bg-success-soft  { background: rgba(16,185,129,.12); }
.bg-warning-soft  { background: rgba(245,158,11,.12); }
.bg-danger-soft   { background: rgba(239,68,68,.12); }
.bg-secondary-soft{ background: rgba(100,116,139,.12); }

/* ── Sisa badge ───────────────────────────────────────────────────────────── */
.sisa-badge {
    display: inline-block; font-size: 12px; font-weight: 700;
    padding: 4px 12px; border-radius: 999px; margin-top: 6px;
}
.sisa-success  { background:rgba(16,185,129,.1); color:#276749; border:1px solid rgba(16,185,129,.3); }
.sisa-warning  { background:rgba(245,158,11,.1); color:#b7791f; border:1px solid rgba(245,158,11,.3); }
.sisa-danger   { background:rgba(239,68,68,.1);  color:#9b2c2c; border:1px solid rgba(239,68,68,.3); }
.sisa-secondary{ background:#f1f3f5; color:#4a5568; border:1px solid #dde3ea; }

/* ── Status chip ──────────────────────────────────────────────────────────── */
.status-chip {
    display: inline-block; font-size: 12px; font-weight: 600;
    padding: 4px 12px; border-radius: 999px;
}
.status-success  { background:rgba(16,185,129,.1); color:#276749; border:1px solid rgba(16,185,129,.3); }
.status-warning  { background:rgba(245,158,11,.1); color:#b7791f; border:1px solid rgba(245,158,11,.3); }
.status-danger   { background:rgba(239,68,68,.1);  color:#9b2c2c; border:1px solid rgba(239,68,68,.3); }
.status-secondary{ background:#f1f3f5; color:#4a5568; border:1px solid #dde3ea; }
.status-primary  { background:rgba(102,126,234,.1);color:#4338ca; border:1px solid rgba(102,126,234,.3); }

/* ── Motor thumb ──────────────────────────────────────────────────────────── */
.motor-thumb {
    height: 150px;
    border-radius: .75rem;
    overflow: hidden;
    background: #f1f3f5;
}

/* ── Action buttons ───────────────────────────────────────────────────────── */
.action-btn {
    display: flex; align-items: center; justify-content: center;
    width: 100%; padding: 11px 0; border-radius: 999px;
    font-size: 14px; font-weight: 700; text-decoration: none;
    cursor: pointer; border: none; transition: all .22s;
}
.action-btn-pay {
    background: linear-gradient(135deg,#10b981,#059669);
    color: #fff;
}
.action-btn-pay:hover { opacity:.88; color:#fff; transform:translateY(-1px);
                        box-shadow:0 6px 18px rgba(16,185,129,.35); }
.action-btn-outline {
    background: transparent;
    border: 1.5px solid #dde3ea !important;
    color: #555;
}
.action-btn-outline:hover { background:#f8fafc; color:#333; }

/* ── Tab back button ──────────────────────────────────────────────────────── */
.tab-btn {
    display: inline-block; padding: 9px 20px; border-radius: 999px;
    font-size: 13.5px; font-weight: 600; text-decoration: none;
    border: 1.5px solid #dde3ea; color: #555; background: #fff;
    transition: all .2s;
}
.tab-btn:hover { border-color:#667eea; color:#667eea; }

.rounded-4 { border-radius: 1rem !important; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
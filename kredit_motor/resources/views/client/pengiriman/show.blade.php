@extends('layouts.client')

@section('title', 'Lacak Pengiriman')
@section('page-title', 'Tracking Pengiriman')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- ── Header ── --}}
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('client.pengajuan.index') }}" class="btn btn-light rounded-pill me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="fw-bold mb-1">
                        <i class="fas fa-truck text-primary me-2"></i> Lacak Pengiriman
                    </h4>
                    <p class="text-muted mb-0">No Resi: <strong>{{ $pengiriman->no_resi }}</strong></p>
                </div>
            </div>

            {{-- ── Kartu Info Motor ── --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-motorcycle fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fw-bold fs-5">
                                {{ $pengiriman->kredit->pengajuanKredit->motor->nama_motor ?? '-' }}
                            </div>
                            <div class="text-muted small">
                                {{ $pengiriman->kredit->pengajuanKredit->motor->merk ?? '-' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            @php
                                $statusBadge = match($pengiriman->status) {
                                    'Diproses' => ['class' => 'warning',  'icon' => 'fa-clock',        'label' => 'Diproses'],
                                    'Dikirim'  => ['class' => 'primary',  'icon' => 'fa-truck',        'label' => 'Dikirim'],
                                    default    => ['class' => 'success',  'icon' => 'fa-check-circle', 'label' => 'Selesai'],
                                };
                            @endphp
                            <span class="badge bg-{{ $statusBadge['class'] }} fs-6 px-3 py-2">
                                <i class="fas {{ $statusBadge['icon'] }} me-1"></i> {{ $statusBadge['label'] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Timeline Status Pengiriman ── --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-map-marked-alt text-primary me-2"></i> Status Pengiriman
                    </h5>
                </div>
                <div class="card-body p-4">
                    @php
                        $st = $pengiriman->status;
                    @endphp
                    <div class="timeline">

                        {{-- Step 1: Diproses --}}
                        <div class="timeline-item {{ in_array($st, ['Diproses','Dikirim','Selesai']) ? 'active' : '' }}">
                            <div class="timeline-icon"><i class="fas fa-clipboard-list"></i></div>
                            <div class="timeline-content">
                                <div class="fw-bold">Pengiriman Diproses</div>
                                <div class="small text-muted">Admin sedang memproses pengiriman motor Anda</div>
                                @if($pengiriman->created_at)
                                    <div class="small text-success mt-1">
                                        <i class="fas fa-check-circle me-1"></i>
                                        {{ \Carbon\Carbon::parse($pengiriman->created_at)->translatedFormat('d F Y H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Step 2: Dikirim --}}
                        <div class="timeline-item {{ in_array($st, ['Dikirim','Selesai']) ? 'active' : '' }}">
                            <div class="timeline-icon"><i class="fas fa-truck"></i></div>
                            <div class="timeline-content">
                                <div class="fw-bold">Motor Dikirim</div>
                                <div class="small text-muted">Motor sedang dalam perjalanan menuju alamat Anda</div>
                                @if($pengiriman->tgl_pengiriman)
                                    <div class="small text-success mt-1">
                                        <i class="fas fa-check-circle me-1"></i>
                                        {{ \Carbon\Carbon::parse($pengiriman->tgl_pengiriman)->translatedFormat('d F Y H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Step 3: Selesai --}}
                        <div class="timeline-item {{ $st === 'Selesai' ? 'active' : '' }}">
                            <div class="timeline-icon"><i class="fas fa-check-circle"></i></div>
                            <div class="timeline-content">
                                <div class="fw-bold">Motor Sampai Tujuan</div>
                                <div class="small text-muted">Motor telah sampai dan diterima oleh pelanggan</div>
                                @if($pengiriman->tgl_sampai)
                                    <div class="small text-success mt-1">
                                        <i class="fas fa-check-circle me-1"></i>
                                        {{ \Carbon\Carbon::parse($pengiriman->tgl_sampai)->translatedFormat('d F Y H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ── Detail Perjalanan (Tracking Lokasi) ── --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-map-pin text-primary me-2"></i> Detail Perjalanan
                    </h5>
                </div>
                <div class="card-body p-4">
                    @php
                        $trackingData = match($pengiriman->status) {
                            'Diproses' => [
                                ['status' => 'success', 'lokasi' => 'Gudang Kredit Motor - Jakarta',  'keterangan' => 'Motor dalam persiapan pengiriman',          'waktu' => $pengiriman->created_at ?? now(), 'icon' => 'fa-box'],
                                ['status' => 'pending', 'lokasi' => 'Sortir Pusat - Cakung',          'keterangan' => 'Menunggu proses sortir',                    'waktu' => null,                             'icon' => 'fa-clock'],
                                ['status' => 'pending', 'lokasi' => 'Transit - Bekasi',               'keterangan' => 'Dalam perjalanan menuju kota tujuan',       'waktu' => null,                             'icon' => 'fa-clock'],
                                ['status' => 'pending', 'lokasi' => 'Kantor Cabang - Bogor',          'keterangan' => 'Sampai di cabang tujuan',                   'waktu' => null,                             'icon' => 'fa-clock'],
                                ['status' => 'pending', 'lokasi' => 'Alamat Pelanggan',               'keterangan' => 'Motor akan segera diantar',                 'waktu' => null,                             'icon' => 'fa-clock'],
                            ],
                            'Dikirim' => [
                                ['status' => 'success',  'lokasi' => 'Gudang Kredit Motor - Jakarta', 'keterangan' => 'Motor dalam persiapan pengiriman',          'waktu' => $pengiriman->created_at ?? now()->subDays(2), 'icon' => 'fa-box'],
                                ['status' => 'success',  'lokasi' => 'Sortir Pusat - Cakung',         'keterangan' => 'Motor sudah disortir dan siap dikirim',     'waktu' => now()->subDays(1),                            'icon' => 'fa-check-circle'],
                                ['status' => 'current',  'lokasi' => 'Transit - Bekasi',              'keterangan' => 'Motor sedang dalam perjalanan',             'waktu' => now(),                                        'icon' => 'fa-truck'],
                                ['status' => 'pending',  'lokasi' => 'Kantor Cabang - Bogor',         'keterangan' => 'Estimasi sampai hari ini atau besok',       'waktu' => null,                                         'icon' => 'fa-clock'],
                                ['status' => 'pending',  'lokasi' => 'Alamat Pelanggan',              'keterangan' => 'Motor akan segera diantar',                 'waktu' => null,                                         'icon' => 'fa-clock'],
                            ],
                            default => [
                                ['status' => 'success', 'lokasi' => 'Gudang Kredit Motor - Jakarta',  'keterangan' => 'Motor dalam persiapan pengiriman',          'waktu' => $pengiriman->created_at ?? now()->subDays(3),  'icon' => 'fa-box'],
                                ['status' => 'success', 'lokasi' => 'Sortir Pusat - Cakung',          'keterangan' => 'Motor sudah disortir',                      'waktu' => now()->subDays(2),                            'icon' => 'fa-check-circle'],
                                ['status' => 'success', 'lokasi' => 'Transit - Bekasi',               'keterangan' => 'Motor melewati transit Bekasi',             'waktu' => now()->subDays(1)->addHours(6),               'icon' => 'fa-check-circle'],
                                ['status' => 'success', 'lokasi' => 'Kantor Cabang - Bogor',          'keterangan' => 'Motor sampai di cabang tujuan',             'waktu' => now()->subHours(12),                          'icon' => 'fa-check-circle'],
                                ['status' => 'success', 'lokasi' => 'Alamat Pelanggan',               'keterangan' => 'Motor telah sampai dan diterima',           'waktu' => $pengiriman->tgl_sampai ?? now(),             'icon' => 'fa-check-circle'],
                            ],
                        };
                    @endphp

                    <div class="tracking-list">
                        @foreach($trackingData as $track)
                            <div class="tracking-item">
                                <div class="tracking-icon {{ $track['status'] }}">
                                    <i class="fas {{ $track['icon'] }}"></i>
                                </div>
                                <div class="tracking-content">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                                        <div>
                                            <div class="fw-bold">{{ $track['lokasi'] }}</div>
                                            <div class="small text-muted">{{ $track['keterangan'] }}</div>
                                        </div>
                                        @if($track['waktu'])
                                            <div class="tracking-time">
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($track['waktu'])->translatedFormat('d M Y, H:i') }}
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── Detail Pengiriman ── --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i> Detail Pengiriman
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-label">Kurir</div>
                            <div class="info-value">{{ $pengiriman->kurir ?? 'Belum ditentukan' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">No Resi</div>
                            <div class="info-value fw-bold">{{ $pengiriman->no_resi }}</div>
                        </div>
                        <div class="col-12">
                            <div class="info-label">Alamat Pengiriman</div>
                            <div class="info-value">{{ $pengiriman->alamat_pengiriman }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Tanggal Kirim</div>
                            <div class="info-value">
                                {{ $pengiriman->tgl_pengiriman
                                    ? \Carbon\Carbon::parse($pengiriman->tgl_pengiriman)->translatedFormat('d F Y')
                                    : '-' }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Estimasi Sampai</div>
                            <div class="info-value">
                                {{ $pengiriman->tgl_estimasi_sampai
                                    ? \Carbon\Carbon::parse($pengiriman->tgl_estimasi_sampai)->translatedFormat('d F Y')
                                    : '-' }}
                            </div>
                        </div>
                    </div>

                    {{-- Estimasi Waktu Tiba --}}
                    @if($pengiriman->status !== 'Selesai' && $pengiriman->tgl_estimasi_sampai)
                        @php
                            $estDate = \Carbon\Carbon::parse($pengiriman->tgl_estimasi_sampai);
                            $isNear  = $estDate->diffInDays(now()) <= 2;
                        @endphp
                        <div class="alert {{ $isNear ? 'alert-warning' : 'alert-info' }} border-0 rounded-3 mt-3">
                            <i class="fas fa-hourglass-half me-2"></i>
                            @if($estDate->isToday())
                                Estimasi sampai <strong>HARI INI</strong>
                            @elseif($estDate->isTomorrow())
                                Estimasi sampai <strong>BESOK</strong>
                            @else
                                Estimasi sampai <strong>{{ $estDate->translatedFormat('d F Y') }}</strong>
                            @endif
                            <br>
                            <small>Silakan pantau terus perjalanan motor Anda.</small>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ── Butuh Bantuan? ── --}}
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-headset text-primary me-2"></i> Butuh Bantuan?
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="mb-2 mb-md-0">
                                <div class="fw-semibold">Hubungi Call Center Kami</div>
                                <p class="text-muted small mb-0">
                                    Jika ada kendala atau pertanyaan mengenai pengiriman motor Anda,
                                    silakan hubungi tim customer service kami.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="tel:+6281234567890" class="btn btn-success rounded-pill px-4 me-2 mb-2 mb-md-0">
                                <i class="fas fa-phone-alt me-2"></i> Telepon
                            </a>
                            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-primary rounded-pill px-4">
                                <i class="fab fa-whatsapp me-2"></i> WhatsApp
                            </a>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-phone-alt text-primary"></i>
                                </div>
                                <div>
                                    <div class="small text-muted">Telepon</div>
                                    <div class="fw-semibold">(021) 1234-5678</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                    <i class="fab fa-whatsapp text-success"></i>
                                </div>
                                <div>
                                    <div class="small text-muted">WhatsApp</div>
                                    <div class="fw-semibold">+62 812-3456-7890</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-info bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-envelope text-info"></i>
                                </div>
                                <div>
                                    <div class="small text-muted">Email</div>
                                    <div class="fw-semibold">cs@kreditmotor.com</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 pt-2 border-top">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="small text-muted">
                                <i class="fas fa-clock me-1"></i> Jam Operasional:
                                Senin - Jumat (09:00 - 17:00) | Sabtu (09:00 - 14:00)
                            </div>
                            <div class="small text-success">
                                <i class="fas fa-check-circle me-1"></i> Siap membantu Anda
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Bukti Penerimaan (jika Selesai) ── --}}
            @if($pengiriman->status === 'Selesai' && $pengiriman->bukti_penerimaan)
                <div class="card border-0 shadow-sm rounded-4 mt-4">
                    <div class="card-header bg-white border-0 p-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-camera text-primary me-2"></i> Bukti Penerimaan
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $pengiriman->bukti_penerimaan) }}"
                                 alt="Bukti Penerimaan"
                                 class="img-fluid rounded-3"
                                 style="max-height: 300px;">
                            @if($pengiriman->nama_penerima)
                                <p class="mt-2 text-muted small">
                                    Diterima oleh: <strong>{{ $pengiriman->nama_penerima }}</strong>
                                </p>
                            @endif
                            @if($pengiriman->catatan_penerimaan)
                                <p class="text-muted small">Catatan: {{ $pengiriman->catatan_penerimaan }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@push('styles')
<style>
    /* ── Timeline ── */
    .timeline {
        position: relative;
        padding: 0 0 0 30px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 32px;
    }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: -10px;
        top: 40px;
        width: 2px;
        height: calc(100% - 20px);
        background: #e2e8f0;
    }
    .timeline-icon {
        position: absolute;
        left: -30px; top: 0;
        width: 40px; height: 40px;
        border-radius: 50%;
        background: #e2e8f0;
        display: flex; align-items: center; justify-content: center;
        color: #94a3b8;
        transition: all 0.3s;
    }
    .timeline-item.active .timeline-icon {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    .timeline-content { padding-left: 20px; }

    /* ── Tracking List ── */
    .tracking-list { position: relative; }
    .tracking-item {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        position: relative;
    }
    .tracking-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 18px; top: 40px;
        width: 2px;
        height: calc(100% - 16px);
        background: #e2e8f0;
    }
    .tracking-icon {
        width: 36px; height: 36px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        z-index: 1;
        background: #f1f5f9;
        color: #94a3b8;
    }
    .tracking-icon.success { background: #d1fae5; color: #059669; }
    .tracking-icon.current {
        background: #fef3c7;
        color: #d97706;
        animation: pulse 1.5s infinite;
    }
    .tracking-icon.pending { background: #f1f5f9; color: #94a3b8; }

    @keyframes pulse {
        0%   { box-shadow: 0 0 0 0   rgba(217, 119, 6, 0.4); }
        70%  { box-shadow: 0 0 0 8px rgba(217, 119, 6, 0);   }
        100% { box-shadow: 0 0 0 0   rgba(217, 119, 6, 0);   }
    }
    .tracking-content { flex: 1; padding-bottom: 8px; }
    .tracking-time    { white-space: nowrap; margin-left: 12px; }

    /* ── Info Labels ── */
    .info-label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .info-value { font-size: 14px; font-weight: 600; color: #1e293b; }

    /* ── Responsive ── */
    @media (max-width: 576px) {
        .tracking-time  { white-space: normal; margin-left: 0; margin-top: 4px; }
        .tracking-item  { flex-wrap: wrap; }
    }
</style>
@endpush

@endsection
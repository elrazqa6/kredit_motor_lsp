<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CEO Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: #f0f2f8;
            margin: 0;
            padding: 0;
        }

        .app-wrap {
            display: flex;
            min-height: 100vh;
        }

        /* ─── Sidebar ─── */
        .sidebar {
            width: 240px;
            background: linear-gradient(160deg, #0f172a 0%, #1e293b 100%);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
        }

        .sb-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .sb-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sb-logo-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sb-logo-icon i {
            color: white;
            font-size: 15px;
        }

        .sb-logo-text {
            color: #fff;
            font-weight: 800;
            font-size: 15px;
            line-height: 1.1;
        }

        .sb-logo-sub {
            color: #64748b;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .sb-nav {
            padding: 16px 12px;
            flex: 1;
            overflow-y: auto;
        }

        .sb-section-label {
            font-size: 10px;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 600;
            padding: 8px 8px 6px;
            display: block;
        }

        .sb-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 8px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 2px;
            transition: all 0.15s ease;
            border-left: 2px solid transparent;
        }

        .sb-link:hover {
            background: rgba(255,255,255,0.06);
            color: #e2e8f0;
        }

        .sb-link.active {
            background: linear-gradient(90deg, rgba(99,102,241,0.25), rgba(139,92,246,0.1));
            color: #a5b4fc;
            border-left: 2px solid #818cf8;
        }

        .sb-link i {
            width: 16px;
            text-align: center;
            font-size: 13px;
            opacity: 0.8;
        }

        .sb-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.07);
            margin: 8px 0;
        }

        .sb-bottom {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .sb-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 10px;
            background: rgba(255,255,255,0.05);
        }

        .sb-avatar {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
        }

        .sb-user-name {
            color: #e2e8f0;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sb-user-role {
            color: #64748b;
            font-size: 11px;
        }

        .sb-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 8px;
            color: #f87171;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            margin-top: 6px;
            transition: all 0.15s;
        }

        .sb-logout:hover {
            background: rgba(248,113,113,0.1);
            color: #fca5a5;
        }

        /* ─── Main Content ─── */
        .main-content {
            flex: 1;
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ─── Topbar ─── */
        .topbar {
            background: white;
            border-bottom: 1px solid #e8ecf4;
            padding: 0 28px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 17px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .topbar-sub {
            font-size: 12px;
            color: #94a3b8;
            margin: 0;
        }

        .topbar-badge {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .topbar-badge .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #22c55e;
        }

        /* ─── Page Content ─── */
        .page-content {
            padding: 24px 28px;
            flex: 1;
        }

        @stack('extra-styles')
    </style>
    @stack('styles')
</head>


    <!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="logo">
            <a href="" class="d-flex align-items-center gap-2 text-decoration-none">
                <img src="{{ asset('img/core-img/logo.png') }}" alt="Kredit Motor Logo" style="height: 40px; width: auto;">
                <div>
                    
                </div>
            </a>
        </div>
    </div>

    <div class="sb-nav">
        <span class="sb-section-label">Menu Utama</span>
        <a href="{{ route('ceo.dashboard') }}" class="sb-link {{ request()->routeIs('ceo.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="{{ route('ceo.users.index') }}" class="sb-link {{ request()->routeIs('ceo.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Manajemen User
        </a>

        <hr class="sb-divider">
        <span class="sb-section-label">Laporan & Analitik</span>
        
        <a href="{{ route('ceo.kredit.index') }}" class="sb-link {{ request()->routeIs('ceo.kredit.*') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i> Laporan Kredit
        </a>
        <a href="{{ route('ceo.motor.index') }}" class="sb-link {{ request()->routeIs('ceo.motor.*') ? 'active' : '' }}">
            <i class="fas fa-motorcycle"></i> Data Motor
        </a>
        <a href="{{ route('ceo.analitik.index') }}" class="sb-link {{ request()->routeIs('ceo.analitik.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Analitik
        </a>
        <a href="{{ route('ceo.export.index') }}" class="sb-link {{ request()->routeIs('ceo.export.*') ? 'active' : '' }}">
            <i class="fas fa-download"></i> Export Data
        </a>

        <hr class="sb-divider">
        <a href="{{ route('logout') }}" class="sb-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
</aside>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="topbar">
            <div>
                <p class="topbar-title">@yield('page-title')</p>
                <p class="topbar-sub">@yield('page-subtitle', 'CEO Panel — KreditMotor')</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="topbar-badge">
                    <span class="status-dot"></span> Live Data
                </div>
                <div class="topbar-badge">
                    <i class="fas fa-calendar-alt" style="font-size:11px;"></i>
                    {{ now()->translatedFormat('d F Y') }}
                </div>
            </div>
        </div>

        <div class="page-content">
            @yield('content')
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
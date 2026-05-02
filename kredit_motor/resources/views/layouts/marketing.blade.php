<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Marketing Panel') - Kredit Motor</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    @stack('styles')
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            overflow-x: hidden;
        }
        
        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: #94a3b8;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0,0,0,0.08);
        }
        
        .sidebar-brand {
            padding: 24px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 24px;
        }
        
        .sidebar-brand h4 {
            font-size: 20px;
            font-weight: 700;
            color: white;
            margin-bottom: 4px;
        }
        
        .sidebar-brand p {
            font-size: 11px;
            color: #64748b;
            letter-spacing: 0.5px;
        }
        
        .sidebar-nav {
            padding: 0 16px;
        }
        
        .nav-section {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #475569;
            padding: 16px 12px 8px 12px;
        }
        
        .nav-item {
            margin-bottom: 4px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 12px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .nav-link i {
            width: 20px;
            font-size: 16px;
            text-align: center;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.07);
            color: white;
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 12px rgba(102,126,234,0.3);
        }
        
        .nav-link.active i {
            color: white;
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px 24px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px;
            background: rgba(255,255,255,0.05);
            border-radius: 14px;
        }
        
        .user-avatar {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            color: white;
        }
        
        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: white;
            margin-bottom: 2px;
        }
        
        .user-role {
            font-size: 10px;
            color: #94a3b8;
        }
        
        .logout-btn {
            background: rgba(239,68,68,0.15);
            color: #f87171;
            margin-top: 8px;
        }
        
        .logout-btn:hover {
            background: #ef4444;
            color: white;
        }
        
        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        /* ========== TOPBAR ========== */
        .topbar {
            background: white;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 99;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        
        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .notification-btn {
            background: #f8fafc;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        
        .notification-btn:hover {
            background: #f1f5f9;
        }
        
        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 99px;
        }
        
        .date-badge {
            font-size: 13px;
            color: #64748b;
            background: #f8fafc;
            padding: 8px 16px;
            border-radius: 40px;
        }
        
        /* ========== PAGE CONTENT ========== */
        .page-content {
            padding: 24px 32px;
        }
        
        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            .sidebar {
                left: -280px;
            }
            .sidebar.open {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .topbar {
                padding: 12px 20px;
            }
            .page-content {
                padding: 20px;
            }
        }
        
        /* ========== UTILITIES ========== */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .rounded-4 {
            border-radius: 1rem !important;
        }
        
        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
         <div class="logo">
                <a href="{{ route('marketing.dashboard') }}" class="navbar-brand d-flex align-items-center gap-2">
                                <img src="{{ asset('img/core-img/logo.png') }}" alt="Kredit Motor Logo">
                            </a>
                        </div>
    </div>
    
    <nav class="sidebar-nav">
        <div class="nav-section">Menu Utama</div>
        
        <div class="nav-item">
            <a href="{{ route('marketing.dashboard') }}" class="nav-link {{ request()->routeIs('marketing.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </div>
        
        <div class="nav-section">Transaksi</div>
        
        <div class="nav-item">
            <a href="{{ route('marketing.pengajuan.index') }}" class="nav-link {{ request()->routeIs('marketing.pengajuan*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i>
                <span>Pengajuan Kredit</span>
                @php
                    $pendingCount = \App\Models\PengajuanKredit::where('status_pengajuan', 'Menunggu')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $pendingCount }}</span>
                @endif
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('marketing.kredit.index') }}" class="nav-link {{ request()->routeIs('marketing.kredit*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i>
                <span>Data Kredit</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('marketing.angsuran.index') }}" class="nav-link {{ request()->routeIs('marketing.angsuran*') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i>
                <span>Angsuran</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('marketing.pengiriman.index') }}" class="nav-link {{ request()->routeIs('marketing.pengiriman*') ? 'active' : '' }}">
                <i class="fas fa-truck"></i>
                <span>Pengiriman</span>
            </a>
        </div>

        <div class="nav-item">
    <a href="{{ route('marketing.pengajuan-offline.create') }}" class="nav-link">
        <i class="fas fa-user-plus"></i>
        <span>Input Pengajuan</span>
    </a>
</div>
    </nav>
    
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'M', 0, 2)) }}
            </div>
            <div style="flex: 1">
                <div class="user-name">{{ auth()->user()->name ?? 'Marketing' }}</div>
                <div class="user-role">Marketing</div>
            </div>
        </div>
        <a href="{{ route('logout') }}" class="nav-link logout-btn mt-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
</aside>

<!-- MAIN CONTENT -->
<div class="main-content">
    <!-- TOPBAR -->
    <header class="topbar">
        <button class="btn btn-light rounded-3 d-lg-none" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h4 class="page-title">@yield('page-title', 'Dashboard')</h4>
        <div class="topbar-actions">
            <div class="date-badge d-none d-md-block">
                <i class="fas fa-calendar-alt me-2"></i>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
            <div class="notification-btn">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>
        </div>
    </header>
    
    <!-- FLASH MESSAGES -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-4 mt-3 border-0 rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-4 mt-3 border-0 rounded-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <!-- PAGE CONTENT -->
    <main class="page-content">
        @yield('content')
    </main>
    
    <!-- FOOTER -->
    <footer class="px-4 py-3 border-top bg-white" style="font-size: 12px; color: #64748b;">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <span>&copy; {{ date('Y') }} Kredit Motor. All rights reserved.</span>
            <span>Marketing Panel v1.0</span>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar toggle untuk mobile
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Tutup sidebar saat klik di luar (mobile)
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992 && sidebar && toggleBtn) {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
    
    // Auto close alert after 3 seconds
    document.querySelectorAll('.alert').forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 3000);
    });
</script>

@stack('scripts')
</body>
</html>
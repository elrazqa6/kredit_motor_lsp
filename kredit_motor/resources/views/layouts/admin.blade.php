<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Kredit Motor Admin</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Custom CSS --}}
    <link href="{{ asset('css/app-custom.css') }}" rel="stylesheet">
    
    {{-- Additional Styles --}}
    @stack('styles')
    
    <style>
        /* Custom Variables & Overrides */
        :root {
            --primary: #1a56db;
            --primary-dark: #1341b8;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--gray-50);
            margin: 0;
            padding: 0;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #0f172a 0%, #0f172a 100%);
            color: #94a3b8;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                left: -260px;
            }
            .sidebar.open {
                left: 0;
            }
        }
        
        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .brand-icon {
            width: 32px;
            height: 32px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .brand-name {
            font-weight: 800;
            font-size: 16px;
            color: white;
            line-height: 1.2;
        }
        
        .brand-sub {
            font-size: 10px;
            color: #64748b;
            letter-spacing: 0.5px;
        }
        
        .sidebar-nav {
            flex: 1;
            padding: 20px 12px;
        }
        
        .sidebar-section {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            padding: 12px 12px 6px 12px;
            margin-top: 8px;
        }
        
        .sidebar-section:first-child {
            margin-top: 0;
        }
        
        .nav-item {
            margin-bottom: 4px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            position: relative;
        }
        
        .nav-link svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.07);
            color: white;
        }
        
        .nav-link.active {
            background: var(--primary);
            color: white;
        }
        
        .nav-link.active svg {
            stroke: white;
        }
        
        .badge-count {
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 99px;
            margin-left: auto;
        }
        
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            color: white;
            flex-shrink: 0;
        }
        
        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .user-role {
            font-size: 10px;
            color: #64748b;
            text-transform: capitalize;
        }
        
        /* Main Wrapper */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        @media (max-width: 992px) {
            .main-wrapper {
                margin-left: 0;
            }
        }
        
        /* Topbar */
        .topbar {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        
        .btn-icon {
            background: transparent;
            border: none;
            padding: 8px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            color: var(--gray-600);
        }
        
        .btn-icon:hover {
            background: var(--gray-100);
        }
        
        .page-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-900);
            flex: 1;
        }
        
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .notif-dot {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
        }
        
        .btn-icon {
            position: relative;
        }
        
        /* Page Content */
        .page-content {
            flex: 1;
            padding: 20px 24px;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--gray-100);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--gray-400);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--gray-500);
        }
        
        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13px;
        }
        
        .alert-success {
            background: #ecfdf5;
            color: #059669;
        }
        
        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
        }
        
        /* Utility Classes */
        .d-none { display: none !important; }
        .d-flex { display: flex !important; }
        .align-items-center { align-items: center !important; }
        .justify-content-between { justify-content: space-between !important; }
        .px-4 { padding-left: 1.5rem !important; padding-right: 1.5rem !important; }
        .pt-3 { padding-top: 1rem !important; }
        .py-3 { padding-top: 1rem !important; padding-bottom: 1rem !important; }
        .mb-3 { margin-bottom: 1rem !important; }
        .me-2 { margin-right: 0.5rem !important; }
        .text-center { text-align: center !important; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        
        <!-- Sidebar Brand -->
        <div class="sidebar-brand">
            <div class="logo">
                <a href="{{ url('/') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                    <img src="{{ asset('img/core-img/logo.png') }}" alt="Kredit Motor Logo" style="height: 32px; width: auto;">
                    <div>
                        <div class="brand-name">Kredit Motor</div>
                        <div class="brand-sub">Admin Panel</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <div class="sidebar-section">Menu Utama</div>
            
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Dashboard
                </a>
            </div>

            <div class="sidebar-section">Master Data</div>

            <div class="nav-item">
                <a href="{{ route('admin.hero.index') }}" class="nav-link {{ request()->routeIs('admin.hero*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 8h4l4 4v4h-8V8z"/>
                    </svg>
                    Hero
                </a>
            </div>

             <div class="nav-item">
                <a href="{{ route('admin.motor.index') }}" class="nav-link {{ request()->routeIs('admin.motor*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 8h4l4 4v4h-8V8z"/>
                    </svg>
                    Data Motor
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.jenis-motor.index') }}" class="nav-link {{ request()->routeIs('admin.jenis-motor*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                    </svg>
                    Jenis Motor
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.jenis-cicilan.index') }}" class="nav-link {{ request()->routeIs('admin.jenis-cicilan*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Jenis Cicilan
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.asuransi.index') }}" class="nav-link {{ request()->routeIs('admin.asuransi*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Asuransi
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.metode-bayar.index') }}" class="nav-link {{ request()->routeIs('admin.metode-bayar*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Metode Bayar
                </a>
</div>

        </nav>

        <!-- User Footer -->
        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}</div>
                <div style="flex: 1; min-width: 0">
                    <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role ?? 'admin') }}</div>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout" style="color: #64748b;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <button class="btn-icon d-lg-none me-2" id="sidebarToggle">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="page-title">@yield('page-title', 'Dashboard')</span>
            <div class="topbar-actions">
                <button class="btn-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                <button class="btn-icon" style="position: relative;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="notif-dot"></span>
                </button>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-4 pt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="margin-right: 6px; vertical-align: -2px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" style="font-size: 10px;"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" style="font-size: 10px;"></button>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="page-content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="px-4 py-3" style="border-top: 1px solid var(--gray-200); font-size: 12px; color: var(--gray-500);">
            &copy; {{ date('Y') }} Kredit Motor. All rights reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('open');
            });
        }
        
        // Close sidebar on outside click (mobile)
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
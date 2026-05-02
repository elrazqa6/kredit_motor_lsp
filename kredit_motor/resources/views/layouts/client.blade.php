<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kredit Motor - Solusi Pembiayaan Motor')</title>

    <!-- CSS WAJIB -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/classy-nav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Font Awesome (untuk icon tambahan) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Custom styling tambahan untuk menjaga konsistensi */
        .content-wrapper {
            min-height: 60vh;
            padding: 30px 0;
        }
        .navbar-brand img {
            max-height: 45px;
        }
        .dropdown-menu-custom {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            min-width: 200px;
            padding: 0.5rem 0;
            margin: 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .classynav ul li:hover .dropdown {
            opacity: 1;
            visibility: visible;
        }
        .toast-container {
            z-index: 1050;
        }
        footer {
            background: #0a2b3a;
            color: #cddfe7;
        }
        footer a {
            color: #f39c12;
            text-decoration: none;
        }
        footer a:hover {
            color: #e67e22;
        }
    </style>
    
    @stack('styles')
</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- Top Header Area -->
        <div class="top-header-area">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12 d-flex justify-content-between">
                        <!-- Logo Area -->
                        <div class="logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('img/core-img/logo.png') }}" alt="Kredit Motor Logo">
                            </a>
                        </div>

                        <!-- Top Contact Info -->
                        <div class="top-contact-info d-flex align-items-center">
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Alamat Kantor">
                                <img src="{{ asset('img/core-img/placeholder.png') }}" alt=""> 
                                <span>Jl. Raya Kebon Jeruk No. 88, Jakarta</span>
                            </a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Email Resmi">
                                <img src="{{ asset('img/core-img/message.png') }}" alt=""> 
                                <span>cs@kreditmotor.id</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navbar Area -->
        <div class="credit-main-menu" id="sticker">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="creditNav">

                        <!-- Navbar Toggler (Mobile) -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">
                            <!-- Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href="{{ url('/') }}">Home</a></li>

                                    <li>
                                        <a href="{{ route('client.motor.index') }}">Katalog Motor</a>
                                    </li>

                                    @auth
                                        @if(auth()->user()->role == 'client')
                                            <li>
                                                <a href="{{ route('client.pengajuan.index') }}">Pengajuan Saya</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('client.angsuran.index') }}">Angsuran Saya</a>
                                            </li>
                                        @endif

                                        <li class="dropdown-nav">
                                            <a href="#">{{ Auth::user()->name }} <i class="fas fa-chevron-down"></i></a>
                                            <ul class="dropdown">
                                                <li><a href="{{ route('client.profil') }}"><i class="fas fa-user-circle"></i> Profile</a></li>
                                                <li>
                                                    <a href="{{ route('logout') }}"
                                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        <i class="fas fa-sign-out-alt"></i> Logout
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endauth

                                    @guest
                                        <li>
                                            <a href="{{ route('login') }}"><i class="fas fa-key"></i> Login</a>
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                            <!-- Nav End -->
                        </div>

                        <!-- Contact Phone -->
                        <div class="contact">
                            <a href="#"><img src="{{ asset('img/core-img/call2.png') }}" alt=""> +62 812 3456 7890</a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

<!-- ===== ISI HALAMAN ===== -->
<div class="container mt-5">
    @yield('content')
</div>

<!-- ===== LOGOUT FORM ===== -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

<!-- ===== JS WAJIB ===== -->
<script src="{{ asset('js/jquery/jquery-2.2.4.min.js') }}"></script>
<script src="{{ asset('js/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/plugins.js') }}"></script>
<script src="{{ asset('js/active.js') }}"></script>

</body>
</html>
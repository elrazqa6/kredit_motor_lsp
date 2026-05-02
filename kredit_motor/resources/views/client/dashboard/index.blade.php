<!DOCTYPE html>
<html lang="en">

    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kredit Motor</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/classy-nav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

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
                            <a href="{{ url('/') }}"><img src="{{ asset('img/core-img/logo.png') }}" alt=""></a>
                        </div>

                        <!-- Top Contact Info -->
                        <div class="top-contact-info d-flex align-items-center">
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="25 th Street Avenue, Los Angeles, CA"><img src="{{ asset('img/core-img/placeholder.png') }}" alt=""> <span>Bojonggede, Bogor</span></a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="office@yourfirm.com"><img src="{{ asset('img/core-img/message.png') }}" alt=""> <span>kredit@gmail.com</span></a>
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

                        <!-- Navbar Toggler -->
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
                                        {{-- Menu khusus untuk role client --}}
                                        @if(auth()->user()->role == 'client')
                                            <li>
                                                <a href="{{ route('client.pengajuan.index') }}">Pengajuan Saya</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('client.angsuran.index') }}">Angsuran Saya</a>
                                            </li>
                                        @endif

                                        {{-- Dropdown nama user --}}
                                        <li>
                                            <a href="#">{{ Auth::user()->name }}</a>
                                            <ul class="dropdown">
                                                @if(auth()->user()->role == 'client')
                                                    <li><a href="{{ route('client.profil') }}">Profile</a></li>
                                                @else
                                                    <li><a href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                                                @endif
                                                <li>
                                                    <a href="{{ route('logout') }}"
                                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        Logout
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endauth

                                    @guest
                                        {{-- Tampilkan tombol Login jika belum login --}}
                                        <li>
                                            <a href="{{ route('login') }}">Login</a>
                                        </li>
                                    @endguest
                                </ul>
                            </div>
                            <!-- Nav End -->
                        </div>

                        <!-- Contact -->
                        <div class="contact">
                            <a href="#"><img src="{{ asset('img/core-img/call2.png') }}" alt=""> +62 5176802810</a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->
    <!-- ##### Hero Area Start ##### -->
    <div class="hero-area">
        <div class="hero-slideshow owl-carousel">
            @php
                $heroSlides = App\Models\Hero::where('is_active', true)
                    ->orderBy('urutan', 'asc')
                    ->get();
            @endphp
            
            @forelse($heroSlides as $slide)
            <!-- Single Slide -->
            <div class="single-slide bg-img">
                <div class="slide-bg-img bg-img bg-overlay" style="background-image: url('{{ asset('storage/'.$slide->gambar) }}');"></div>
                <div class="container h-100">
                    <div class="row h-100 align-items-center justify-content-center">
                        <div class="col-12 col-lg-9">
                            <div class="welcome-text text-center">
                                @if($slide->judul)
                                    <h6 data-animation="fadeInUp" data-delay="100ms">{{ $slide->judul }}</h6>
                                @endif
                                <h2 data-animation="fadeInUp" data-delay="300ms">get your <span>loan</span> now</h2>
                                @if($slide->sub_judul)
                                    <p data-animation="fadeInUp" data-delay="500ms">{{ $slide->sub_judul }}</p>
                                @endif
                                <a href="{{ $slide->tombol_link ?? route('client.motor.index') }}" 
                                   class="btn credit-btn mt-50" 
                                   data-animation="fadeInUp" data-delay="700ms">
                                    {{ $slide->tombol_teks ?? 'Lihat Katalog' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slide-du-indicator"></div>
            </div>
            @empty
            <!-- Default Slide jika tidak ada data hero -->
            <div class="single-slide bg-img">
                <div class="slide-bg-img bg-img bg-overlay" style="background-image: url('{{ asset('img/bg-img/1.jpg') }}');"></div>
                <div class="container h-100">
                    <div class="row h-100 align-items-center justify-content-center">
                        <div class="col-12 col-lg-9">
                            <div class="welcome-text text-center">
                                <h6 data-animation="fadeInUp" data-delay="100ms">Kredit Motor</h6>
                                <h2 data-animation="fadeInUp" data-delay="300ms">Wujudkan <span>Motor Impian</span> Sekarang</h2>
                                <p data-animation="fadeInUp" data-delay="500ms">Proses cepat, bunga rendah, dan tenor fleksibel.</p>
                                @auth
                                    <a href="{{ route('client.pengajuan.create') }}" class="btn credit-btn mt-50">Ajukan Kredit</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn credit-btn mt-50">Login & Ajukan</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slide-du-indicator"></div>
            </div>
            @endforelse
        </div>
    </div>
    <!-- ##### Hero Area End ##### -->

    <!-- ##### Features Area Start ###### -->
    <section class="features-area section-padding-100-0">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-features-area mb-100 wow fadeInUp" data-wow-delay="100ms">
                        <div class="section-heading">
                            <div class="line"></div>
                            <p>Take look at our</p>
                            <h2>Our Loans</h2>
                        </div>
                        <h6>In vitae nisi aliquam, scelerisque leo a, volutpat sem. Viva mus rutrum dui fermentum eros hendrerit.</h6>
                        <a href="#" class="btn credit-btn mt-50">Discover</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-features-area mb-100 wow fadeInUp" data-wow-delay="300ms">
                        <img src="{{ asset('img/bg-img/2.jpg') }}" alt="">
                        <h5>We take care of you</h5>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-features-area mb-100 wow fadeInUp" data-wow-delay="500ms">
                        <img src="{{ asset('img/bg-img/3.jpg') }}" alt="">
                        <h5>No documents needed</h5>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-features-area mb-100 wow fadeInUp" data-wow-delay="700ms">
                        <img src="{{ asset('img/bg-img/4.jpg') }}" alt="">
                        <h5>Fast &amp; easy loans</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Features Area End ###### -->

    <!-- ##### Call To Action Start ###### -->
    <section class="cta-area d-flex flex-wrap">
        <div class="cta-thumbnail bg-img jarallax" style="background-image: url('{{ asset('img/bg-img/5.jpg') }}');"></div>
        <div class="cta-content">
            <div class="section-heading white">
                <div class="line"></div>
                <p>Bold desing and beyound</p>
                <h2>Helping small businesses like yours</h2>
            </div>
            <h6>Morbi ut dapibus dui. Sed ut iaculis elit, quis varius mauris. Integer ut ultricies orci, lobortis egestas sem. Duis non volutpat arcu, eu mollis tellus.</h6>
            <div class="d-flex flex-wrap mt-50">
                <div class="single-skils-area mb-70 mr-5">
                    <div id="circle" class="circle" data-value="0.90">
                        <div class="skills-text"><span>90%</span></div>
                    </div>
                    <p>Energy</p>
                </div>
                <div class="single-skils-area mb-70 mr-5">
                    <div id="circle2" class="circle" data-value="0.75">
                        <div class="skills-text"><span>75%</span></div>
                    </div>
                    <p>Power</p>
                </div>
                <div class="single-skils-area mb-70">
                    <div id="circle3" class="circle" data-value="0.97">
                        <div class="skills-text"><span>97%</span></div>
                    </div>
                    <p>Resource</p>
                </div>
            </div>
            <a href="#" class="btn credit-btn box-shadow btn-2">Read More</a>
        </div>
    </section>
    <!-- ##### Call To Action End ###### -->

    <!-- ##### Call To Action 2 Start ###### -->
    <section class="cta-2-area wow fadeInUp" data-wow-delay="100ms">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cta-content d-flex flex-wrap align-items-center justify-content-between">
                        <div class="cta-text">
                            <h4>Are you in need for a loan? Get in touch with us.</h4>
                        </div>
                        <div class="cta-btn">
                            @guest
                                <a href="{{ route('login') }}" class="btn credit-btn box-shadow">Login & Ajukan Kredit</a>
                            @endguest
                            @auth
                                <a href="{{ route('client.pengajuan.create') }}" class="btn credit-btn box-shadow">Ajukan Kredit Sekarang</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Call To Action 2 End ###### -->

    <!-- ##### Services Area Start ###### -->
    <section class="services-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center mb-100 wow fadeInUp" data-wow-delay="100ms">
                        <div class="line"></div>
                        <p>Take look at our</p>
                        <h2>Our services</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-service-area d-flex mb-100 wow fadeInUp" data-wow-delay="200ms">
                        <div class="icon"><i class="icon-profits"></i></div>
                        <div class="text">
                            <h5>All the loans</h5>
                            <p>Morbi ut dapibus dui. Sed ut iaculis elit, quis varius mauris. Integer ut ultricies orci, lobortis egestas sem.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-service-area d-flex mb-100 wow fadeInUp" data-wow-delay="300ms">
                        <div class="icon"><i class="icon-money-1"></i></div>
                        <div class="text">
                            <h5>Easy and fast answer</h5>
                            <p>Morbi ut dapibus dui. Sed ut iaculis elit, quis varius mauris. Integer ut ultricies orci, lobortis egestas sem.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-service-area d-flex mb-100 wow fadeInUp" data-wow-delay="400ms">
                        <div class="icon"><i class="icon-coin"></i></div>
                        <div class="text">
                            <h5>No additional papers</h5>
                            <p>Morbi ut dapibus dui. Sed ut iaculis elit, quis varius mauris. Integer ut ultricies orci, lobortis egestas sem.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-service-area d-flex mb-100 wow fadeInUp" data-wow-delay="500ms">
                        <div class="icon"><i class="icon-smartphone-1"></i></div>
                        <div class="text">
                            <h5>Secure financial services</h5>
                            <p>Morbi ut dapibus dui. Sed ut iaculis elit, quis varius mauris. Integer ut ultricies orci, lobortis egestas sem.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-service-area d-flex mb-100 wow fadeInUp" data-wow-delay="600ms">
                        <div class="icon"><i class="icon-diamond"></i></div>
                        <div class="text">
                            <h5>Good investments</h5>
                            <p>Morbi ut dapibus dui. Sed ut iaculis elit, quis varius mauris. Integer ut ultricies orci, lobortis egestas sem.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-service-area d-flex mb-100 wow fadeInUp" data-wow-delay="700ms">
                        <div class="icon"><i class="icon-piggy-bank"></i></div>
                        <div class="text">
                            <h5>Accumulation goals</h5>
                            <p>Morbi ut dapibus dui. Sed ut iaculis elit, quis varius mauris. Integer ut ultricies orci, lobortis egestas sem.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Services Area End ###### -->

    <!-- ##### Miscellaneous Area Start ###### -->
    <section class="miscellaneous-area bg-gray section-padding-100-0">
        <div class="container">
            <div class="row align-items-end justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="add-area mb-100 wow fadeInUp" data-wow-delay="100ms">
                        <a href="#"><img src="{{ asset('img/bg-img/add.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="contact--area mb-100 wow fadeInUp" data-wow-delay="300ms">
                        <div class="section-heading mb-50">
                            <div class="line"></div>
                            <h2>Get in touch</h2>
                        </div>
                        <div class="contact-content">
                            <div class="single-contact-content d-flex align-items-center">
                                <div class="icon"><img src="{{ asset('img/core-img/location.png') }}" alt=""></div>
                                <div class="text"><p>3007 Sarah Drive <br> Franklin, LA 70538</p></div>
                            </div>
                            <div class="single-contact-content d-flex align-items-center">
                                <div class="icon"><img src="{{ asset('img/core-img/call.png') }}" alt=""></div>
                                <div class="text">
                                    <p>337-413-9538</p>
                                    <span>mon-fri , 08.am - 17.pm</span>
                                </div>
                            </div>
                            <div class="single-contact-content d-flex align-items-center">
                                <div class="icon"><img src="{{ asset('img/core-img/message2.png') }}" alt=""></div>
                                <div class="text">
                                    <p>contact@yourbusiness.com</p>
                                    <span>we reply in 24 hrs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="news--area mb-100 wow fadeInUp" data-wow-delay="500ms">
                        <div class="section-heading mb-50">
                            <div class="line"></div>
                            <h2>The news</h2>
                        </div>
                        <div class="single-news-area d-flex align-items-center">
                            <div class="news-thumbnail"><img src="{{ asset('img/bg-img/10.jpg') }}" alt=""></div>
                            <div class="news-content">
                                <span>July 18, 2018</span>
                                <a href="#">How to get the best loan online</a>
                                <div class="news-meta">
                                    <a href="#" class="post-author"><img src="{{ asset('img/core-img/pencil.png') }}" alt=""> Jane Smith</a>
                                    <a href="#" class="post-date"><img src="{{ asset('img/core-img/calendar.png') }}" alt=""> April 26</a>
                                </div>
                            </div>
                        </div>
                        <div class="single-news-area d-flex align-items-center">
                            <div class="news-thumbnail"><img src="{{ asset('img/bg-img/11.jpg') }}" alt=""></div>
                            <div class="news-content">
                                <span>July 18, 2018</span>
                                <a href="#">A new way to finance your dream home</a>
                                <div class="news-meta">
                                    <a href="#" class="post-author"><img src="{{ asset('img/core-img/pencil.png') }}" alt=""> Jane Smith</a>
                                    <a href="#" class="post-date"><img src="{{ asset('img/core-img/calendar.png') }}" alt=""> April 26</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Miscellaneous Area End ###### -->

    <!-- ##### Newsletter Area Start ###### -->
    <section class="newsletter-area section-padding-100 bg-img jarallax" style="background-image: url('{{ asset('img/bg-img/6.jpg') }}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-lg-8">
                    <div class="nl-content text-center">
                        <h2>Subscribe to our newsletter</h2>
                        <form action="#" method="post">
                            <input type="email" name="nl-email" id="nlemail" placeholder="Your e-mail">
                            <button type="submit">Subscribe</button>
                        </form>
                        <p>Curabitur elit turpis, maximus quis ullamcorper sed, maximus eu neque.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Newsletter Area End ###### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-footer-widget mb-100">
                        <h5 class="widget-title">About Us</h5>
                        <nav>
                            <ul>
                                <li><a href="{{ url('/') }}">Homepage</a></li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Services &amp; Offers</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-footer-widget mb-100">
                        <h5 class="widget-title">Solutions</h5>
                        <nav>
                            <ul>
                                <li><a href="#">Our Loans</a></li>
                                <li><a href="#">Financial Solutions</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-footer-widget mb-100">
                        <h5 class="widget-title">Our Loans</h5>
                        <nav>
                            <ul>
                                <li><a href="{{ route('client.motor.index') }}">Katalog Motor</a></li>
                                @auth
                                    @if(auth()->user()->role == 'client')
                                        <li><a href="{{ route('client.pengajuan.index') }}">Pengajuan Saya</a></li>
                                        <li><a href="{{ route('client.angsuran.index') }}">Angsuran Saya</a></li>
                                    @endif
                                @endauth
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-footer-widget mb-100">
                        <h5 class="widget-title">Latest News</h5>
                        <div class="single-latest-news-area d-flex align-items-center">
                            <div class="news-thumbnail"><img src="{{ asset('img/bg-img/6.jpg') }}" alt=""></div>
                            <div class="news-content">
                                <a href="#">How to get the best loan?</a>
                                <div class="news-meta">
                                    <a href="#" class="post-date"><img src="{{ asset('img/core-img/calendar.png') }}" alt=""> April 26</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copywrite Area -->
        <div class="copywrite-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="copywrite-content d-flex flex-wrap justify-content-between align-items-center">
                            <a href="{{ url('/') }}" class="footer-logo"><img src="{{ asset('img/core-img/logo.png') }}" alt=""></a>
                            <p class="copywrite-text">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Kredit Motor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- JS -->
    <script src="{{ asset('js/jquery/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('js/active.js') }}"></script>

    @auth
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @endauth
</body>

</html>
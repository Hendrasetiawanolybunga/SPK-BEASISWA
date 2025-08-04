<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <title>@yield('title', 'Beasiswa Bangsa')</title>

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/templatemo-onix-digital.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animated.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">
</head>

<body>

    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo ***** -->
                        <a href="/" class="logo">
                            <img src="assets/images/logo.png">
                        </a>
                        <!-- ***** Menu ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="/#top">Home</a></li>
                            <li class="scroll-to-section"><a href="/#beasiswa">Beasiswa</a></li>
                            <li class="scroll-to-section"><a href="/#about">Tentang</a></li>
                            <li class="scroll-to-section"><a href="/#metode">Metode</a></li>
                            {{-- <li class="scroll-to-section"><a href="#artikel">Artikel</a></li> --}}
                            <li class="scroll-to-section">
                                <div class="main-red-button-hover"><a href="/login">Login Admin</a></div>
                            </li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="main-banner" id="top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6 align-self-center">
                                <div class="owl-carousel owl-banner">
                                    <div class="item header-text">
                                        <h6>Selamat Datang</h6>
                                        <h2>Dapatkan <em>beasiswa impianmu</em> dengan <span>mudah & cepat</span>!</h2>
                                        <p>Selamat datang di Beasiswa Bangsa — platform pintar yang membantu kamu
                                            menemukan beasiswa terbaik
                                            sesuai dengan prestasi, kondisi, dan potensi dirimu. Mari wujudkan masa
                                            depan cerah melalui
                                            pendidikan yang layak!</p>
                                        <div class="down-buttons">
                                            <div class="main-blue-button-hover">
                                                <a href="#beasiswa">Coba Sekarang</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item header-text">
                                        <h6>Daftar Beasiswa Umum</h6>
                                        <h2>Temukan <em>beasiswa terbaik</em> untuk <span>masa depanmu</span></h2>
                                        <p>Beberapa beasiswa yang tersedia: Beasiswa KIP Kuliah, Beasiswa LPDP, Beasiswa
                                            Unggulan, Beasiswa
                                            Bank Indonesia, Beasiswa Baznas, Beasiswa Djarum Plus, dan banyak lagi.
                                            Dapatkan rekomendasi sesuai
                                            profil kamu hanya di sini!</p>
                                        <div class="down-buttons">
                                            <div class="main-blue-button-hover">
                                                <a href="#beasiswa">Beasiswa</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="beasiswa" class="our-services section">
            <div class="services-right-dec">
                <img src="assets/images/services-right-dec.png" alt="">
            </div>
            <div class="container">
                <div class="services-left-dec">
                    <img src="assets/images/services-left-dec.png" alt="">
                </div>
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="section-heading">
                            <h2>Kami <em>Memberikan</em> Dukungan Terbaik Dalam Memilih <span>Program Beasiswa</span>
                            </h2>
                            <span>Beasiswa</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="owl-carousel owl-services">
                            <div class="item">
                                <h4>Temukan Rekomendasi Beasiswa Terbaik Untukmu</h4>
                                <div class="icon"><img src="assets/images/service-icon-01.png" alt=""></div>
                                <p>Kami bantu kamu memilih beasiswa yang paling sesuai dengan profil dan impianmu.</p>
                            </div>
                            <div class="item">
                                <h4>Meluncur Menuju Masa Depan dengan Beasiswa Tepat</h4>
                                <div class="icon"><img src="assets/images/service-icon-02.png" alt=""></div>
                                <p>Temukan rekomendasi beasiswa yang mempercepat langkahmu meraih cita-cita.</p>
                            </div>
                            <div class="item">
                                <h4>Tingkatkan Potensimu Lewat Beasiswa Tepat</h4>
                                <div class="icon"><img src="assets/images/service-icon-03.png" alt=""></div>
                                <p>Dapatkan rekomendasi beasiswa yang membuka peluang sukses di masa depan.</p>
                            </div>
                            <div class="item">
                                <h4>Jelajahi Dukungan & Komunitas Beasiswa</h4>
                                <div class="icon"><img src="assets/images/service-icon-04.png" alt="">
                                </div>
                                <p>Temukan bimbingan dan rekomendasi beasiswa dari kami untuk perjalananmu.</p>
                            </div>
                            <div class="item">
                                <h4>Karena Setiap Mimpi Butuh Awal yang Tepat</h4>
                                <div class="icon"><img src="assets/images/service-icon-01.png" alt="">
                                </div>
                                <p>Beasiswa adalah langkah awal menuju masa depan yang kamu impikan.</p>
                            </div>
                            <div class="item">
                                <h4>Percepat Langkahmu Raih Beasiswa Impian</h4>
                                <div class="icon"><img src="assets/images/service-icon-02.png" alt="">
                                </div>
                                <p>Raih peluang pendidikan terbaik dengan rekomendasi yang tepat sasaran.</p>
                            </div>
                            <div class="item">
                                <h4>Beasiswa untuk Prestasi dan Kemajuan</h4>
                                <div class="icon"><img src="assets/images/service-icon-03.png" alt="">
                                </div>
                                <p>Pilih beasiswa yang mendukung peningkatan akademik dan pengembangan diri.</p>
                            </div>
                            <div class="item">
                                <h4>Bersama Raih Peluang Lewat Beasiswa</h4>
                                <div class="icon"><img src="assets/images/service-icon-04.png" alt="">
                                </div>
                                <p>Dapatkan rekomendasi beasiswa dengan semangat kolaborasi dan kebersamaan.</p>
                            </div>
                            <div class="item">
                                <h4>Accessibility for mobile viewing</h4>
                                <div class="icon"><img src="assets/images/service-icon-01.png" alt="">
                                </div>
                                <p>Get to know more about the topic in details</p>
                            </div>
                            <div class="item">
                                <h4>Luncurkan Mimpimu Bersama Beasiswa</h4>
                                <div class="icon"><img src="assets/images/service-icon-02.png" alt="">
                                </div>
                                <p>Pilih jalur beasiswa yang sesuai dengan potensimu hari ini.</p>
                            </div>
                            <div class="item">
                                <h4>Naik Level Bersama Rekomendasi Beasiswa</h4>
                                <div class="icon"><img src="assets/images/service-icon-03.png" alt="">
                                </div>
                                <p>Capai impian pendidikan dan karier dengan pilihan beasiswa terbaik.</p>
                            </div>
                            <div class="item">
                                <h4>Kami Temani Langkahmu Menuju Beasiswa</h4>
                                <div class="icon"><img src="assets/images/service-icon-04.png" alt="">
                                </div>
                                <p>Jangan sendiri—kami bantu pilihkan beasiswa yang sesuai untukmu.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="about" class="about-us section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 align-self-center">
                        <div class="left-image">
                            <img src="assets/images/about-left-image.png" alt="Two Girls working together">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="section-heading">
                            <h2>Temukan Beasiswa Terbaik dengan <em>Sistem Rekomendasi</em> &amp; <span>Keputusan
                                    Cerdas</span></h2>
                            <p>Website ini dirancang untuk membantu calon pendaftar dalam menemukan beasiswa yang paling
                                sesuai,
                                menggunakan pendekatan ilmiah berbasis sistem pendukung keputusan (SPK) dengan metode
                                Bayes, MAIRCA, dan
                                MOORA.</p>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="fact-item">
                                        <div class="count-area-content">
                                            <div class="icon">
                                                <img src="assets/images/service-icon-01.png" alt="">
                                            </div>
                                            <div class="count-digit">3</div>
                                            <div class="count-title">Metode SPK</div>
                                            <p>Bayes, MAIRCA, dan MOORA digunakan untuk menghasilkan rekomendasi yang
                                                objektif dan tepat
                                                sasaran.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="fact-item">
                                        <div class="count-area-content">
                                            <div class="icon">
                                                <img src="assets/images/service-icon-02.png" alt="">
                                            </div>
                                            <div class="count-digit">100%</div>
                                            <div class="count-title">Berbasis Data</div>
                                            <p>Sistem menganalisis berbagai kriteria seperti prestasi, ekonomi,
                                                domisili, dan lainnya.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="fact-item">
                                        <div class="count-area-content">
                                            <div class="icon">
                                                <img src="assets/images/service-icon-03.png" alt="">
                                            </div>
                                            <div class="count-digit">Goals</div>
                                            <div class="count-title">Membantu Pendaftar</div>
                                            <p>Memberikan rekomendasi beasiswa yang sesuai dengan profil dan kebutuhan
                                                masing-masing calon
                                                penerima.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="metode" class="our-portfolio section">
            <div class="portfolio-left-dec">
                <img src="assets/images/portfolio-left-dec.png" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="section-heading">
                            <h2>Metode <em>Sistem Pendukung Keputusan</em> <span>Yang Digunakan</span></h2>
                            <span>Metode</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="owl-carousel owl-portfolio">
                            <div class="item">
                                <div class="thumb">
                                    <img src="assets/images/portfolio-01.png" alt="">
                                    <div class="hover-effect">
                                        <div class="inner-content">
                                            <a href="#">
                                                <h4>Metode Bayes</h4>
                                            </a>
                                            <span>Probabilitas & Kecocokan Data</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="thumb">
                                    <img src="assets/images/portfolio-02.png" alt="">
                                    <div class="hover-effect">
                                        <div class="inner-content">
                                            <a href="#">
                                                <h4>Metode MAIRCA</h4>
                                            </a>
                                            <span>Model Rekomendasi Multi-Kriteria</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="thumb">
                                    <img src="assets/images/portfolio-03.png" alt="">
                                    <div class="hover-effect">
                                        <div class="inner-content">
                                            <a href="#">
                                                <h4>Metode MOORA</h4>
                                            </a>
                                            <span>Optimisasi Rasio dan Perankingan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div id="artikel" class="our-videos section">
            <div class="videos-left-dec">
                <img src="assets/images/videos-left-dec.png" alt="">
            </div>
            <div class="videos-right-dec">
                <img src="assets/images/videos-right-dec.png" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="naccs">
                            <div class="grid">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <ul class="nacc">
                                            <li class="active">
                                                <div>
                                                    <div class="thumb">
                                                        <iframe width="100%" height="auto"
                                                            src="https://www.youtube.com/embed/54lMCH8Wp3U?si=t50AJ_c3wNyJAtkm"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                        <div class="overlay-effect">
                                                            <a href="#">
                                                                <h4>Panduan Beasiswa</h4>
                                                            </a>
                                                            <span>Cara Memulai & Tips Pendaftaran</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <div class="thumb">
                                                        <iframe width="100%" height="auto"
                                                            src="https://www.youtube.com/embed/UIp6_0kct_U"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                        <div class="overlay-effect">
                                                            <a href="#">
                                                                <h4>Kriteria Beasiswa</h4>
                                                            </a>
                                                            <span>Faktor Penilaian & Persyaratan</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <div class="thumb">
                                                        <iframe width="100%" height="auto"
                                                            src="https://www.youtube.com/embed/B5SL9yrMPn8"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                        <div class="overlay-effect">
                                                            <a href="#">
                                                                <h4>Strategi Lolos Seleksi</h4>
                                                            </a>
                                                            <span>Tips Membuat CV, Essay & Interview</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <div class="thumb">
                                                        <iframe width="100%" height="auto"
                                                            src="https://www.youtube.com/embed/KlUcUSKSdP4?si=Tp1TFUkbIg5WKQly"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                        <div class="overlay-effect">
                                                            <a href="#">
                                                                <h4>Jenis-Jenis Beasiswa</h4>
                                                            </a>
                                                            <span>Akademik, Non-Akademik, dan Luar Negeri</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="menu">
                                            <div class="active">
                                                <div class="thumb">
                                                    <img src="assets/images/video-thumb-01.png" alt="">
                                                    <div class="inner-content">
                                                        <h4>Panduan Beasiswa</h4>
                                                        <span>Cara Memulai & Tips Pendaftaran</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="thumb">
                                                    <img src="assets/images/video-thumb-02.png" alt="">
                                                    <div class="inner-content">
                                                        <h4>Kriteria Beasiswa</h4>
                                                        <span>Faktor Penilaian & Persyaratan</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="thumb">
                                                    <img src="assets/images/video-thumb-03.png" alt="Marketing">
                                                    <div class="inner-content">
                                                        <h4>Strategi Lolos Seleksi</h4>
                                                        <span>Tips Membuat CV, Essay & Interview</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="thumb">
                                                    <img src="assets/images/video-thumb-04.png" alt="SEO Work">
                                                    <div class="inner-content">
                                                        <h4>Jenis-Jenis Beasiswa</h4>
                                                        <span>Akademik, Non-Akademik, dan Luar Negeri</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </main>

    <div class="footer-dec">
        <img src="assets/images/footer-dec.png" alt="">
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="about footer-item">
                        <div class="logo">
                            <a href="#"><img src="assets/images/logo.png" alt="Onix Digital TemplateMo"></a>
                        </div>
                        <a href="#">tcp.com</a>
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-whatsapp"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="services footer-item">
                        <h4>Services</h4>
                        <ul>
                            <li><a href="#">TCP Development</a></li>
                        </ul>
                    </div>
                </div>
                {{-- <div class="col-lg-3">
                    <div class="community footer-item">
                        <h4>Community</h4>
                        <ul>
                            <li><a href="#">Website Checkup</a></li>
                            <li><a href="#">Page Speed Test</a></li>
                        </ul>
                    </div>
                </div> --}}
                {{-- <div class="col-lg-3">
                    <div class="subscribe-newsletters footer-item">
                        <h4>Subscribe</h4>
                        <p>Dapatkan Informasi Pembukaan Beasiswa Terbaru Melalui Email Anda</p>
                        <form action="#" method="get">
                            <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*"
                                placeholder="Your Email" required="">
                            <button type="submit" id="form-submit" class="main-button "><i
                                    class="fa fa-paper-plane-o"></i></button>
                        </form>
                    </div>
                </div> --}}
                <div class="col-lg-12">
                    <div class="copyright">
                        <p>© 2025 TCP, Ltd. All Rights Reserved.
                            <br>
                            Designed by <a rel="nofollow" href="https://templatemo.com"
                                title="free CSS templates">Team TCP</a><br>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/animation.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        $(document).on("click", ".naccs .menu div", function() {
            var numberIndex = $(this).index();
            if (!$(this).is("active")) {
                $(".naccs .menu div").removeClass("active");
                $(".naccs ul li").removeClass("active");
                $(this).addClass("active");
                $(".naccs ul").find("li:eq(" + numberIndex + ")").addClass("active");
                var listItemHeight = $(".naccs ul").find("li:eq(" + numberIndex + ")").innerHeight();
                $(".naccs ul").height(listItemHeight + "px");
            }
        });
    </script>

</body>

</html>

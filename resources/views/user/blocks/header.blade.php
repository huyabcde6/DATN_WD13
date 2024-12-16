<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from htmldemo.net/destry/destry/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 08 Oct 2024 15:50:01 GMT -->

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>POLY STORE</title>
    <!-- Favicons -->
    <link rel="shortcut icon" href="http://datn_wd13.test/ngdung/assets/images/logo/logo1.png" />

    <!-- Vendor CSS (Icon Font) -->

    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/vendor/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/vendor/pe-icon-7-stroke.min.css') }}" />


    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/aos.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/nice-select.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/jquery-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/lightgallery.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">


    <!-- Main Style CSS -->

    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/loading.css') }}" />
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>

<body>
    {{-- <div class="loader" style="display: none;"></div> --}}
    <div class="header section">
        <!-- Header Bottom Start -->
        <div class="header-bottom">
            <div class="header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- Header Logo Start -->
                        <div class="col-xl-2 col-6">
                            <div class="header-logo">
                                <a href="{{route('home.index')}}"><img src="{{ asset('ngdung/assets/images/logo/logo1.png') }}"
                                        alt="Site Logo" width="250xp" height="135px" /></a>
                            </div>
                        </div>
                        <!-- Header Logo End -->

                        <!-- Header Menu Start -->
                        <div class="col-xl-8 d-none d-xl-block">
                            <div class="main-menu position-relative">
                                <ul>
                                    <li class="has-children">
                                        <a href="{{route('home.index')}}"><span>Trang Chủ</span></a>
                                    </li>
                                    <li class="has-children position-static">
                                        <a href="{{route('shop.index')}}"><span>Cửa hàng</span></a>

                                    </li>
                                    <li class="has-children">
                                        <a href="{{ route('user.vouchers') }}"><span>Voucher</span></a>
                                    </li>
                                    <li class="has-children">
                                        <a href="{{ route('news.index') }}"><span>Tin Tức</span></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact') }}"> <span>Liên Hệ</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Header Menu End -->

                        <!-- Header Action Start -->
                        <div class="col-xl-2 col-6">
                            <div class="header-actions">
                                <!-- Search Header Action Button Start -->
                                <a href="javascript:void(0)" class="header-action-btn header-action-btn-search"><i
                                        class="pe-7s-search"></i></a>
                                <!-- Search Header Action Button End -->

                                <!-- User Account Header Action Button Start -->


                                <a href="{{ Auth::check() ? route ('orders.index') : route ('login') }}" class="header-action-btn d-none d-md-block">
                                    <i class="pe-7s-user"></i>
                                </a>


                                <!-- User Account Header Action Button End -->

                                <!-- Wishlist Header Action Button Start -->

                                <!-- Wishlist Header Action Button End -->

                                <!-- Shopping Cart Header Action Button Start -->
                                <a href="{{ route('cart.index') }}" class="header-action-btn header-action-btn-cart">
                                    <i class="pe-7s-shopbag"></i>
                                    <span class="header-action-num">{{ session('cart') ? count(session('cart')) : '0' }}
                                    </span>
                                </a>

                                <!-- Shopping Cart Header Action Button End -->

                                <!-- Mobile Menu Hambarger Action Button Start -->
                                <a href="javascript:void(0)"
                                    class="header-action-btn header-action-btn-menu d-xl-none d-lg-block">
                                    <i class="fa fa-bars"></i>
                                </a>
                                <!-- Mobile Menu Hambarger Action Button End -->
                            </div>
                        </div>
                        <!-- Header Action End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Bottom End -->

        <!-- Mobile Menu Start -->
        <div class="mobile-menu-wrapper">
            <div class="offcanvas-overlay"></div>

            <!-- Mobile Menu Inner Start -->
            <div class="mobile-menu-inner">
                <!-- Button Close Start -->
                <div class="offcanvas-btn-close">
                    <i class="pe-7s-close"></i>
                </div>
                <!-- Button Close End -->

                <!-- Mobile Menu Start -->
                <div class="mobile-navigation">
                    <nav>
                        <ul class="mobile-menu">
                            <li class="has-children">
                                <a href="#">Home </a>
                            </li>
                            <li class="has-children">
                                <a href="#">Sản Phẩm <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="dropdown">
                                    <li><a href="shop-grid.html">Shop Grid</a></li>
                                </ul>
                            </li>
                            <li class="has-children">
                                <a href="#">Dịch Vụ </a>
                            </li>
                            <li class="has-children">
                                <a href="#">Tin Tức</a>
                            </li>
                            <li><a href="contact.html">Liên Hệ</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Mobile Menu End -->
                <!-- Contact Links/Social Links Start -->
                <div class="mt-auto">
                    <!-- Contact Links Start -->
                    <ul class="contact-links">
                        <li>
                            <i class="fa fa-phone"></i><a href="#"> +012 3456 789 123</a>
                        </li>
                        <li>
                            <i class="fa fa-envelope-o"></i><a href="#"> info@example.com</a>
                        </li>
                        <li>
                            <i class="fa fa-clock-o"></i>
                            <span>Monday - Sunday 9.00 - 18.00</span>
                        </li>
                    </ul>
                    <!-- Contact Links End -->

                    <!-- Social Widget Start -->
                    <div class="widget-social">
                        <a title="Facebook" href="#"><i class="fa fa-facebook-f"></i></a>
                        <a title="Twitter" href="#"><i class="fa fa-twitter"></i></a>
                        <a title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                        <a title="Youtube" href="#"><i class="fa fa-youtube"></i></a>
                        <a title="Vimeo" href="#"><i class="fa fa-vimeo"></i></a>
                    </div>
                    <!-- Social Widget Ende -->
                </div>
                <!-- Contact Links/Social Links End -->
            </div>
            <!-- Mobile Menu Inner End -->
        </div>
        <!-- Mobile Menu End -->

        <!-- Offcanvas Search Start -->
        <div class="offcanvas-search">
            <div class="offcanvas-search-inner">
                <!-- Button Close Start -->
                <div class="offcanvas-btn-close">
                    <i class="pe-7s-close"></i>
                </div>
                <!-- Button Close End -->

                <!-- Offcanvas Search Form Start -->
                <form class="offcanvas-search-form" action="#">
                    <input type="text" placeholder="Search Here..." class="offcanvas-search-input" />
                </form>
                <!-- Offcanvas Search Form End -->
            </div>
        </div>
        <!-- Offcanvas Search End -->

        <!-- Cart Offcanvas Start -->
        <div class="cart-offcanvas-wrapper">
            <div class="offcanvas-overlay"></div>

            <!-- Cart Offcanvas Inner Start -->
            {{-- <div class="cart-offcanvas-inner">
                <!-- Button Close Start -->
                <div class="offcanvas-btn-close">
                    <i class="pe-7s-close"></i>
                </div>
                <!-- Button Close End -->

                <!-- Offcanvas Cart Content Start -->

                <!-- Offcanvas Cart Content End -->
            </div> --}}
            <!-- Cart Offcanvas Inner End -->
        </div>
        <!-- Cart Offcanvas End -->
    </div>

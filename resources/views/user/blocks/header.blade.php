<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from htmldemo.net/destry/destry/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 08 Oct 2024 15:50:01 GMT -->

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Destry - Fashion eCommerce HTML Template</title>
    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('ngdung/assets/images/favicon.ico')}}" />

    <!-- Vendor CSS (Icon Font) -->

    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/vendor/fontawesome.min.css')}}" />
    <link
        rel="stylesheet"
        href="{{ asset('ngdung/assets/css/vendor/pe-icon-7-stroke.min.css')}}" />

    <!-- Plugins CSS (All Plugins Files) -->

    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/swiper-bundle.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/animate.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/aos.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/nice-select.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/jquery-ui.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/lightgallery.min.css')}}" />

    <!-- Main Style CSS -->

    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/style.css')}}" />
</head>

<body>
    <div class="header section">

        <!-- Header Bottom Start -->
        <div class="header-bottom">
            <div class="header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- Header Logo Start -->
                        <div class="col-xl-2 col-6">
                            <div class="header-logo">
                                <a href="index.html"><img src="{{ asset('ngdung/assets/images/logo/logo1.png')}}" alt="Site Logo"
                                        width="250xp" height="135px" /></a>
                            </div>
                        </div>
                        <!-- Header Logo End -->

                        <!-- Header Menu Start -->
                        <div class="col-xl-8 d-none d-xl-block">
                            <div class="main-menu position-relative">
                                <ul>
                                    <li class="has-children">
                                        <a href="#"><span>Trang Chủ</span></a>
                                    </li>
                                    <li class="has-children position-static">
                                        <a href="#"><span>Sản Phẩm</span> <i class="fa fa-angle-down"></i></a>
                                        <ul class="mega-menu row-cols">
                                            <li class="col">
                                                <h4 class="mega-menu-title">Shop Layout</h4>
                                                <ul class="mb-n2">
                                                    <li><a href="shop-grid.html">Shop Grid</a></li>
                                                    <li>
                                                        <a href="shop-left-sidebar.html">Left Sidebar</a>
                                                    </li>
                                                    <li>
                                                        <a href="shop-right-sidebar.html">Right Sidebar</a>
                                                    </li>
                                                    <li>
                                                        <a href="shop-list-fullwidth.html">List Fullwidth</a>
                                                    </li>
                                                    <li>
                                                        <a href="shop-list-left-sidebar.html">List Left Sidebar</a>
                                                    </li>
                                                    <li>
                                                        <a href="shop-list-right-sidebar.html">List Right Sidebar</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="col">
                                                <h4 class="mega-menu-title">Product Layout</h4>
                                                <ul class="mb-n2">
                                                    <li>
                                                        <a href="single-product.html">Single Product</a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product-sale.html">Single Product Sale</a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product-group.html">Single Product Group</a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product-normal.html">Single Product Normal</a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product-affiliate.html">Single Product Affiliate</a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product-slider.html">Single Product Slider</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="has-children">
                                        <a href="#"><span>Dịch Vụ</span> <i class="fa fa-angle-down"></i></a>
                                        <ul class="sub-menu">
                                            <li><a href="about.html">About</a></li>
                                            <li><a href="contact.html">Contact</a></li>
                                            <li><a href="faq.html">Faq</a></li>
                                            <li><a href="404-error.html">404 Error</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-children">
                                        <a href="#"><span>Tin Tức</span> <i class="fa fa-angle-down"></i></a>
                                        <ul class="sub-menu">
                                            <li><a href="blog.html">Blog</a></li>
                                            <li>
                                                <a href="blog-left-sidebar.html">Blog Left Sidebar</a>
                                            </li>
                                            <li>
                                                <a href="blog-right-sidebar.html">Blog Right Sidebar</a>
                                            </li>
                                            <li><a href="blog-details.html">Blog Details</a></li>
                                            <li>
                                                <a href="blog-details-sidebar.html">Blog Details Sidebar</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="contact.html"> <span>Liên Hệ</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Header Menu End -->

                        <!-- Header Action Start -->
                        <div class="col-xl-2 col-6">
                            <div class="header-actions">
                                <!-- Search Header Action Button Start -->
                                <a
                                    href="javascript:void(0)"
                                    class="header-action-btn header-action-btn-search"><i class="pe-7s-search"></i></a>
                                <!-- Search Header Action Button End -->

                                <!-- User Account Header Action Button Start -->
                                <a
                                    href="login-register.html"
                                    class="header-action-btn d-none d-md-block"><i class="pe-7s-user"></i></a>
                                <!-- User Account Header Action Button End -->

                                <!-- Wishlist Header Action Button Start -->
                                <a
                                    href="wishlist.html"
                                    class="header-action-btn header-action-btn-wishlist d-none d-md-block">
                                    <i class="pe-7s-like"></i>
                                </a>
                                <!-- Wishlist Header Action Button End -->

                                <!-- Shopping Cart Header Action Button Start -->
                                <a
                                    href="javascript:void(0)"
                                    class="header-action-btn header-action-btn-cart">
                                    <i class="pe-7s-shopbag"></i>
                                    <span class="header-action-num">3</span>
                                </a>
                                <!-- Shopping Cart Header Action Button End -->

                                <!-- Mobile Menu Hambarger Action Button Start -->
                                <a
                                    href="javascript:void(0)"
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
                    <input
                        type="text"
                        placeholder="Search Here..."
                        class="offcanvas-search-input" />
                </form>
                <!-- Offcanvas Search Form End -->
            </div>
        </div>
        <!-- Offcanvas Search End -->

        <!-- Cart Offcanvas Start -->
        <div class="cart-offcanvas-wrapper">
            <div class="offcanvas-overlay"></div>

            <!-- Cart Offcanvas Inner Start -->
            <div class="cart-offcanvas-inner">
                <!-- Button Close Start -->
                <div class="offcanvas-btn-close">
                    <i class="pe-7s-close"></i>
                </div>
                <!-- Button Close End -->

                <!-- Offcanvas Cart Content Start -->
                <div class="offcanvas-cart-content">
                    <!-- Offcanvas Cart Title Start -->
                    <h2 class="offcanvas-cart-title mb-10">Giỏ Hàng</h2>
                    <!-- Offcanvas Cart Title End -->

                    <!-- Cart Product/Price Start -->
                    <div class="cart-product-wrapper mb-6">
                        <!-- Single Cart Product Start -->
                        <div class="single-cart-product">
                            <div class="cart-product-thumb">
                                <a href="single-product.html"><img
                                        src="{{ asset('ngdung/assets/images/products/small-product/1.jpg')}}"
                                        alt="Cart Product" /></a>
                            </div>
                            <div class="cart-product-content">
                                <h3 class="title">
                                    <a href="single-product.html">Brother Hoddies in Grey</a>
                                </h3>
                                <span class="price">
                                    <span class="new">$38.50</span>
                                    <span class="old">$40.00</span>
                                </span>
                            </div>
                        </div>
                        <!-- Single Cart Product End -->

                        <!-- Product Remove Start -->
                        <div class="cart-product-remove">
                            <a href="#"><i class="fa fa-trash"></i></a>
                        </div>
                        <!-- Product Remove End -->
                    </div>
                    <!-- Cart Product/Price End -->

                    <!-- Cart Product/Price Start -->
                    <div class="cart-product-wrapper mb-6">
                        <!-- Single Cart Product Start -->
                        <div class="single-cart-product">
                            <div class="cart-product-thumb">
                                <a href="single-product.html"><img
                                        src="{{ asset('ngdung/assets/images/products/small-product/2.jpg')}}"
                                        alt="Cart Product" /></a>
                            </div>
                            <div class="cart-product-content">
                                <h3 class="title">
                                    <a href="single-product.html">Basic Jogging Shorts</a>
                                </h3>
                                <span class="price">
                                    <span class="new">$14.50</span>
                                    <span class="old">$18.00</span>
                                </span>
                            </div>
                        </div>
                        <!-- Single Cart Product End -->

                        <!-- Product Remove Start -->
                        <div class="cart-product-remove">
                            <a href="#"><i class="fa fa-trash"></i></a>
                        </div>
                        <!-- Product Remove End -->
                    </div>
                    <!-- Cart Product/Price End -->

                    <!-- Cart Product/Price Start -->
                    <div class="cart-product-wrapper mb-6">
                        <!-- Single Cart Product Start -->
                        <div class="single-cart-product">
                            <div class="cart-product-thumb">
                                <a href="single-product.html"><img
                                        src="{{ asset('ngdung/assets/images/products/small-product/3.jpg')}}"
                                        alt="Cart Product" /></a>
                            </div>
                            <div class="cart-product-content">
                                <h3 class="title">
                                    <a href="single-product.html">Enjoy The Rest T-Shirt</a>
                                </h3>
                                <span class="price">
                                    <span class="new">$20.00</span>
                                    <span class="old">$21.00</span>
                                </span>
                            </div>
                        </div>
                        <!-- Single Cart Product End -->

                        <!-- Product Remove Start -->
                        <div class="cart-product-remove">
                            <a href="#"><i class="fa fa-trash"></i></a>
                        </div>
                        <!-- Product Remove End -->
                    </div>
                    <!-- Cart Product/Price End -->

                    <!-- Cart Product Total Start -->
                    <div class="cart-product-total">
                        <span class="value">Tổng phụ</span>
                        <span class="price">220$</span>
                    </div>
                    <!-- Cart Product Total End -->

                    <!-- Cart Product Button Start -->
                    <div class="cart-product-btn mt-4">
                        <a
                            href="cart.html"
                            class="btn btn-dark btn-hover-primary rounded-0 w-100">Xem giỏ hàng</a>
                        <a
                            href="checkout.html"
                            class="btn btn-dark btn-hover-primary rounded-0 w-100 mt-4">Thanh toán</a>
                    </div>
                    <!-- Cart Product Button End -->
                </div>
                <!-- Offcanvas Cart Content End -->
            </div>
            <!-- Cart Offcanvas Inner End -->
        </div>
        <!-- Cart Offcanvas End -->
    </div>
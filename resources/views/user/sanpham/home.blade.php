@extends('layouts.home')

@section('content')
<!-- Hero/Intro Slider Start -->
<div class="section">
    <div class="hero-slider">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Single Hero Slider Item Start -->
                <div class="hero-slide-item-two swiper-slide">
                    <!-- Hero Slider Background Image Start-->
                    <div class="hero-slide-bg">
                        <img src="{{ asset('ngdung/assets/images/slider/slide-2.jpg')}}" alt="" />
                    </div>
                    <!-- Hero Slider Background Image End-->

                    <!-- Hero Slider Container Start -->
                    <div class="container">
                        <div class="row">
                            <div
                                class="hero-slide-content col-lg-8 col-xl-6 col-12 text-lg-center text-left">
                                <h2 class="title">
                                    Thời trang mới <br />
                                    Bộ sưu tập
                                </h2>
                                <p>Giảm tới 70% sản phẩm đã chọn</p>
                                <a
                                    href="shop-grid.html"
                                    class="btn btn-lg btn-primary btn-hover-dark">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                    <!-- Hero Slider Container End -->
                </div>
                <!-- Single Hero Slider Item End -->

                <!-- Single Hero Slider Item Start -->
                <div class="hero-slide-item-two swiper-slide">
                    <!-- Hero Slider Background Image Start -->
                    <div class="hero-slide-bg">
                        <img src="{{ asset('ngdung/assets/images/slider/slide-2-2.jpg')}}" alt="" />
                    </div>
                    <!-- Hero Slider Background Image End -->

                    <!-- Hero Slider Container Start -->
                    <div class="container">
                        <div class="row">
                            <div
                                class="hero-slide-content col-lg-8 col-xl-6 col-12 text-lg-center text-left">
                                <h2 class="title">
                                    Xu hướng thời trang <br />
                                    Bộ sưu tập
                                </h2>
                                <p>Giảm tới 30% sản phẩm đã chọn</p>
                                <a
                                    href="shop-grid.html"
                                    class="btn btn-lg btn-primary btn-hover-dark">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                    <!-- Hero Slider Container End -->
                </div>
                <!-- Single Hero Slider Item End -->
            </div>

            <!-- Swiper Pagination Start -->
            <div class="swiper-pagination d-md-none"></div>
            <!-- Swiper Pagination End -->

            <!-- Swiper Navigation Start -->
            <div
                class="home-slider-prev swiper-button-prev main-slider-nav d-md-flex d-none">
                <i class="pe-7s-angle-left"></i>
            </div>
            <div
                class="home-slider-next swiper-button-next main-slider-nav d-md-flex d-none">
                <i class="pe-7s-angle-right"></i>
            </div>
            <!-- Swiper Navigation End -->
        </div>
    </div>
</div>
<!-- Hero/Intro Slider End -->
<!-- Feature Section Start -->
<div class="section section-margin">
    <div class="container">
        <div class="feature-wrap">
            <div
                class="row row-cols-lg-4 row-cols-xl-auto row-cols-sm-2 row-cols-1 justify-content-between mb-n5">
                <!-- Feature Start -->
                <div class="col mb-5" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature">
                        <div class="icon text-primary align-self-center">
                            <img
                                src="{{ asset('ngdung/assets/images/icons/feature-icon-2.png')}}"
                                alt="Feature Icon" />
                        </div>
                        <div class="content">
                            <h5 class="title">Free shipping</h5>
                            <p>Miễn phí vận chuyển</p>
                        </div>
                    </div>
                </div>
                <!-- Feature End -->

                <!-- Feature Start -->
                <div class="col mb-5" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature">
                        <div class="icon text-primary align-self-center">
                            <img
                                src="{{ asset('ngdung/assets/images/icons/feature-icon-3.png')}}"
                                alt="Feature Icon" />
                        </div>
                        <div class="content">
                            <h5 class="title">Hỗ trợ 24/7</h5>
                            <p>Hỗ trợ 24 giờ một ngày</p>
                        </div>
                    </div>
                </div>
                <!-- Feature End -->
                <!-- Feature Start -->
                <div class="col mb-5" data-aos="fade-up" data-aos-delay="700">
                    <div class="feature">
                        <div class="icon text-primary align-self-center">
                            <img
                                src="{{ asset('ngdung/assets/images/icons/feature-icon-4.png')}}"
                                alt="Feature Icon" />
                        </div>
                        <div class="content">
                            <h5 class="title">Hoàn tiền</h5>
                            <p>Bảo hành đổi trả dưới 5 ngày</p>
                        </div>
                    </div>
                </div>
                <!-- Feature End -->

                <!-- Feature Start -->
                <div class="col mb-5" data-aos="fade-up" data-aos-delay="900">
                    <div class="feature">
                        <div class="icon text-primary align-self-center">
                            <img
                                src="{{ asset('ngdung/assets/images/icons/feature-icon-1.png')}}"
                                alt="Feature Icon" />
                        </div>
                        <div class="content">
                            <h5 class="title">Giảm giá đơn hàng</h5>
                            <p>Mỗi đơn hàng trên $150</p>
                        </div>
                    </div>
                </div>
                <!-- Feature End -->
            </div>
        </div>
    </div>
</div>
<!-- Feature Section End -->

<!-- Banner Section Start -->
<div class="section">
    <div class="container">
        <!-- Banners Start -->
        <div class="row mb-n6 overflow-hidden">
            <!-- Banner Start -->
            <div class="col-md-6 col-12 mb-6">
                <div class="banner" data-aos="fade-right" data-aos-delay="300">
                    <div class="banner-image">
                        <a href="shop-grid.html"><img
                                src="{{ asset('ngdung/assets/images/banner/banner-4.jpg')}}"
                                alt="Banner Image" /></a>
                    </div>
                    <div class="info">
                        <div class="small-banner-content">
                            <h4 class="sub-title">Giảm giá tớ <span>50%</span></h4>
                            <h3 class="title">Váy công sở</h3>
                            <a
                                href="shop-grid.html"
                                class="btn btn-primary btn-hover-dark btn-sm">Mua Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Banner End -->

            <!-- Banner Start -->
            <div class="col-md-6 col-12 mb-6">
                <div class="banner" data-aos="fade-left" data-aos-delay="500">
                    <div class="banner-image">
                        <a href="shop-grid.html"><img
                                src="{{ asset('ngdung/assets/images/banner/banner-5.jpg')}}"
                                alt="Banner Image" /></a>
                    </div>
                    <div class="info">
                        <div class="small-banner-content">
                            <h4 class="sub-title">Giảm giá tớ <span>40%</span></h4>
                            <h3 class="title">Tất cả sản phẩm</h3>
                            <a
                                href="shop-grid.html"
                                class="btn btn-primary btn-hover-dark btn-sm">Mua Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Banner End -->
        </div>
        <!-- Banners End -->
    </div>
</div>
<!-- Banner Section End -->

<!-- Product Section Start -->
<div class="section section-padding mt-0">
    <div class="container">
        <!-- Section Title & Tab Start -->
        <div class="row">
            <!-- Tab Start -->
            <div class="col-12">
                <ul
                    class="product-tab-nav nav justify-content-center mb-10 title-border-bottom mt-n3">
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="300">
                        <a
                            class="nav-link active mt-3"
                            data-bs-toggle="tab"
                            href="#tab-product-all">Sản Phẩm Mới</a>
                    </li>
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="400">
                        <a
                            class="nav-link mt-3"
                            data-bs-toggle="tab"
                            href="#tab-product-clothings">Sản Phẩm Bán Chạy</a>
                    </li>
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="500">
                        <a
                            class="nav-link mt-3"
                            data-bs-toggle="tab"
                            href="#tab-product-all">Sản phẩm sale</a>
                    </li>
                </ul>
            </div>
            <!-- Tab End -->
        </div>
        <!-- Section Title & Tab End -->

        <!-- Products Tab Start -->
        <div class="row">
            <div class="col">
                <div class="tab-content position-relative">
                    <div class="tab-pane fade show active" id="tab-product-all">
                        <div class="product-carousel">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <!-- Product Start -->
                                    <div class="swiper-slide product-wrapper">
                                        <!-- Single Product Start -->
                                        <div
                                            class="product product-border-left mb-10"
                                            data-aos="fade-up"
                                            data-aos-delay="300">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/1.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/5.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Studio Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Brother Hoddies in Grey</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                                    </span>
                                                    <span class="rating-num">(4)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$38.50</span>
                                                    <span class="old">$42.85</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->

                                        <!-- Single Product Start -->
                                        <div
                                            class="product product-border-left"
                                            data-aos="fade-up"
                                            data-aos-delay="400">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/2.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/3.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Studio Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Basic Jogging Shorts</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                                    </span>
                                                    <span class="rating-num">(4)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$14.50</span>
                                                    <span class="old">$18.00</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->
                                    </div>
                                    <!-- Product End -->

                                    <!-- Product Start -->
                                    <div class="swiper-slide product-wrapper">
                                        <!-- Single Product Start -->
                                        <div
                                            class="product product-border-left mb-10"
                                            data-aos="fade-up"
                                            data-aos-delay="400">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/4.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/10.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <span class="badges">
                                                    <span class="sale">New</span>
                                                </span>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Studio Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Simple Woven Fabrics</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 67%"></span>
                                                    </span>
                                                    <span class="rating-num">(2)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$45.50</span>
                                                    <span class="old">$48.85</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->

                                        <!-- Single Product Start -->
                                        <div
                                            class="product product-border-left"
                                            data-aos="fade-up"
                                            data-aos-delay="500">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/5.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/6.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <span class="badges">
                                                    <span class="sale">Sold</span>
                                                </span>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Studio Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Make Thing Happen T-Shirt</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 80%"></span>
                                                    </span>
                                                    <span class="rating-num">(2)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$16.00</span>
                                                    <span class="old">$18.00</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->
                                    </div>
                                    <!-- Product End -->

                                    <!-- Product Start -->
                                    <div class="swiper-slide product-wrapper">
                                        <!-- Single Product Start -->
                                        <div
                                            class="product product-border-left mb-10"
                                            data-aos="fade-up"
                                            data-aos-delay="500">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/7.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/9.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Lather Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Basic Lather Sneaker</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                                    </span>
                                                    <span class="rating-num">(12)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$65.00</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->

                                        <!-- Single Product Start -->
                                        <div
                                            class="product product-border-left"
                                            data-aos="fade-up"
                                            data-aos-delay="600">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/10.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/4.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Fabric Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Simple Woven Fashion</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 70%"></span>
                                                    </span>
                                                    <span class="rating-num">(09)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$27.00</span>
                                                    <span class="old">$29.50</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->
                                    </div>
                                    <!-- Product End -->

                                    <!-- Product Start -->
                                    <div class="swiper-slide product-wrapper">
                                        <!-- Single Product Start -->
                                        <div
                                            class="product product-border-left mb-10"
                                            data-aos="fade-up"
                                            data-aos-delay="600">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/11.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/10.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Design Source</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Handmade Shoulder Bag</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                                    </span>
                                                    <span class="rating-num">(06)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$96.50</span>
                                                    <span class="old">$100.00</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->

                                        <!-- Single Product Start -->
                                        <div
                                            class="product product-border-left"
                                            data-aos="fade-up"
                                            data-aos-delay="700">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/3.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/5.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Studio Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Enjoy The Rest T-Shirt</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                                    </span>
                                                    <span class="rating-num">(4)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$22.00</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->
                                    </div>
                                    <!-- Product End -->

                                    <!-- Product Start -->
                                    <div class="swiper-slide product-wrapper">
                                        <!-- Single Product Start -->
                                        <div
                                            class="product product-border-left mb-10"
                                            data-aos="fade-up"
                                            data-aos-delay="700">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/7.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/9.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Lather Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Basic Lather Sneaker</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                                    </span>
                                                    <span class="rating-num">(12)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$65.00</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->

                                        <!-- Single Product Start -->
                                        <div
                                            class="product product-border-left"
                                            data-aos="fade-up"
                                            data-aos-delay="800">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/10.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/4.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Fabric Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Simple Woven Fashion</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 70%"></span>
                                                    </span>
                                                    <span class="rating-num">(09)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$27.00</span>
                                                    <span class="old">$29.50</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->
                                    </div>
                                    <!-- Product End -->
                                </div>

                                <!-- Swiper Pagination Start -->
                                <div class="swiper-pagination d-md-none"></div>
                                <!-- Swiper Pagination End -->

                                <!-- Next Previous Button Start -->
                                <div
                                    class="swiper-product-button-next swiper-button-next swiper-button-white d-md-flex d-none">
                                    <i class="pe-7s-angle-right"></i>
                                </div>
                                <div
                                    class="swiper-product-button-prev swiper-button-prev swiper-button-white d-md-flex d-none">
                                    <i class="pe-7s-angle-left"></i>
                                </div>
                                <!-- Next Previous Button End -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-product-clothings">
                        <div class="product-carousel">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <!-- Product Start -->
                                    <div class="swiper-slide product-wrapper">
                                        <!-- Single Product Start -->
                                        <div class="product product-border-left mb-10">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/2.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/3.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Studio Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Basic Jogging Shorts</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                                    </span>
                                                    <span class="rating-num">(4)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$14.50</span>
                                                    <span class="old">$18.00</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->

                                        <!-- Single Product Start -->
                                        <div class="product product-border-left">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/1.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/5.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Studio Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Brother Hoddies in Grey</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                                    </span>
                                                    <span class="rating-num">(4)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$38.50</span>
                                                    <span class="old">$42.85</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->
                                    </div>
                                    <!-- Product End -->

                                    <!-- Product Start -->
                                    <div class="swiper-slide product-wrapper">
                                        <!-- Single Product Start -->
                                        <div class="product product-border-left mb-10">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/11.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/10.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Design Source</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Handmade Shoulder Bag</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                                    </span>
                                                    <span class="rating-num">(06)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$96.50</span>
                                                    <span class="old">$100.00</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->

                                        <!-- Single Product Start -->
                                        <div class="product product-border-left">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/3.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/5.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Studio Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Enjoy The Rest T-Shirt</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                                    </span>
                                                    <span class="rating-num">(4)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$22.00</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->
                                    </div>
                                    <!-- Product End -->

                                    <!-- Product Start -->
                                    <div class="swiper-slide product-wrapper">
                                        <!-- Single Product Start -->
                                        <div class="product product-border-left mb-10">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/4.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/10.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <span class="badges">
                                                    <span class="sale">New</span>
                                                </span>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Studio Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Simple Woven Fabrics</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 67%"></span>
                                                    </span>
                                                    <span class="rating-num">(2)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$45.50</span>
                                                    <span class="old">$48.85</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->

                                        <!-- Single Product Start -->
                                        <div class="product product-border-left">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/5.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/6.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <span class="badges">
                                                    <span class="sale">Sold</span>
                                                </span>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Studio Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Make Thing Happen T-Shirt</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 80%"></span>
                                                    </span>
                                                    <span class="rating-num">(2)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$16.00</span>
                                                    <span class="old">$18.00</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->
                                    </div>
                                    <!-- Product End -->

                                    <!-- Product Start -->
                                    <div class="swiper-slide product-wrapper">
                                        <!-- Single Product Start -->
                                        <div class="product product-border-left mb-10">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/7.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/9.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Lather Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Basic Lather Sneaker</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                                    </span>
                                                    <span class="rating-num">(12)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$65.00</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->

                                        <!-- Single Product Start -->
                                        <div class="product product-border-left">
                                            <div class="thumb">
                                                <a href="single-product.html" class="image">
                                                    <img
                                                        class="first-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/10.jpg')}}"
                                                        alt="Product" />
                                                    <img
                                                        class="second-image"
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/4.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a
                                                        href="#"
                                                        class="action quickview"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h4 class="sub-title">
                                                    <a href="single-product.html">Fabric Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product.html">Simple Woven Fashion</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 70%"></span>
                                                    </span>
                                                    <span class="rating-num">(09)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$27.00</span>
                                                    <span class="old">$29.50</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product End -->
                                    </div>
                                    <!-- Product End -->
                                </div>

                                <!-- Swiper Pagination Start -->
                                <div class="swiper-pagination d-md-none"></div>
                                <!-- Swiper Pagination End -->

                                <!-- Next Previous Button Start -->
                                <div
                                    class="swiper-product-button-next swiper-button-next swiper-button-white d-md-flex d-none">
                                    <i class="pe-7s-angle-right"></i>
                                </div>
                                <div
                                    class="swiper-product-button-prev swiper-button-prev swiper-button-white d-md-flex d-none">
                                    <i class="pe-7s-angle-left"></i>
                                </div>
                                <!-- Next Previous Button End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Products Tab End -->
    </div>
</div>
<!-- Product Section End -->

<!-- Banner Fullwidth Start -->
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12" data-aos="fade-up" data-aos-delay="300">
                <div class="banner">
                    <div class="banner-image">
                        <a href="shop-grid.html"><img src="{{ asset('ngdung/assets/images/banner/big-banner.jpg')}}" alt="Banner" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner Fullwidth End -->

<!-- Banner Section Start -->
<div class="section">
    <div class="container">
        <!-- Banners Start -->
        <div class="row mb-n6">
            <!-- Banner Start -->
            <div class="col-lg-4 col-md-6 col-12 mb-6">
                <div class="banner" data-aos="fade-up" data-aos-delay="300">
                    <div class="banner-image">
                        <a href="shop-grid.html"><img src="{{ asset('ngdung/assets/images/banner/banner-1.jpg')}}" alt="" /></a>
                    </div>
                    <div class="info">
                        <div class="small-banner-content">
                            <h4 class="sub-title">Mũ che nắng</h4>
                            <h3 class="title">Nhận ưu đãi <br />cho mùa hè</h3>
                            <a href="shop-grid.html" class="btn btn-dark btn-sm">Mua ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Banner End -->

            <!-- Banner Start -->
            <div class="col-lg-4 col-md-6 col-12 mb-6">
                <div class="banner" data-aos="fade-up" data-aos-delay="500">
                    <div class="banner-image">
                        <a href="shop-grid.html"><img src="{{ asset('ngdung/assets/images/banner/banner-2.jpg')}}" alt="" /></a>
                    </div>
                    <div class="info">
                        <div class="small-banner-content">
                            <h4 class="sub-title">Túi xách nữ</h4>
                            <h3 class="title">Mua một <br />Tặng một </h3>
                            <a href="shop-grid.html" class="btn btn-dark btn-sm">Mua ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Banner End -->

            <!-- Banner Start -->
            <div class="col-lg-4 col-md-6 col-12 mb-6">
                <div class="banner" data-aos="fade-up" data-aos-delay="700">
                    <div class="banner-image">
                        <a href="shop-grid.html"><img src="{{ asset('ngdung/assets/images/banner/banner-3.jpg')}}" alt="" /></a>
                    </div>
                    <div class="info">
                        <div class="small-banner-content">
                            <h4 class="sub-title">Giày & Dép</h4>
                            <h3 class="title">Giảm 20% <br />Giày & Dép</h3>
                            <a href="shop-grid.html" class="btn btn-dark btn-sm">Mua ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Banner End -->
        </div>
        <!-- Banners End -->
    </div>
</div>
<!-- Banner Section End -->

<!-- Product Deal Section Start -->
<div class="section section-padding mt-0 overflow-hidden">
    <div class="container">
        <!-- Section Title & Tab Start -->
        <div class="row">
            <!-- Tab Start -->
            <div class="col-12">
                <div class="section-title-produt-tab-wrapper">
                    <div
                        class="section-title m-0"
                        data-aos="fade-right"
                        data-aos-delay="300">
                        <h1 class="title">Ưu đãi hàng ngày</h1>
                    </div>
                </div>
            </div>
            <!-- Tab End -->
        </div>
        <!-- Section Title & Tab End -->

        <!-- Products Tab Start -->
        <div class="row">
            <div class="col">
                <div class="tab-content position-relative">
                    <div class="tab-pane fade show active" id="product-deal-all">
                        <div class="product-deal-carousel">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <!-- Product Start -->
                                    <div
                                        class="swiper-slide product-wrapper"
                                        data-aos="fade-right"
                                        data-aos-delay="600">
                                        <!-- Single Product Deal Start -->
                                        <div
                                            class="product single-deal-product product-border-left">
                                            <div class="thumb">
                                                <a href="single-product-sale.html" class="image">
                                                    <img
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/1.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                                <span class="badges">
                                                    <span class="sale">-30%</span>
                                                </span>
                                            </div>
                                            <div class="content">
                                                <p class="inner-desc">Nhanh lên! Ưu đãi kết thúc sau:</p>
                                                <div class="countdown-area">
                                                    <div
                                                        class="countdown-wrapper d-flex"
                                                        data-countdown="2023/12/24"></div>
                                                </div>
                                                <h4 class="sub-title">
                                                    <a href="single-product-sale.html">Thiết Kế Studio</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product-sale.html">Enjoy The Rest T-Shirt</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 100%"></span>
                                                    </span>
                                                    <span class="rating-num">(4)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$38.00</span>
                                                    <span class="old">$42.05</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product Deal End -->
                                    </div>
                                    <!-- Product End -->

                                    <!-- Product Start -->
                                    <div
                                        class="swiper-slide product-wrapper"
                                        data-aos="fade-left"
                                        data-aos-delay="600">
                                        <!-- Single Product Deal Start -->
                                        <div
                                            class="product single-deal-product product-border-left">
                                            <div class="thumb">
                                                <a href="single-product-sale.html" class="image">
                                                    <img
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/8.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                            </div>
                                            <div class="content">
                                                <p class="inner-desc">Hurry Up! Offer Ends In:</p>
                                                <div class="countdown-area">
                                                    <div
                                                        class="countdown-wrapper d-flex"
                                                        data-countdown="2023/12/24"></div>
                                                </div>
                                                <h4 class="sub-title">
                                                    <a href="single-product-sale.html">Studio Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product-sale.html">Classic Trucker Hat</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 65%"></span>
                                                    </span>
                                                    <span class="rating-num">(3)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$07.00</span>
                                                    <span class="old">$08.40</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product Deal End -->
                                    </div>
                                    <!-- Product End -->

                                    <!-- Product Start -->
                                    <div class="swiper-slide product-wrapper">
                                        <!-- Single Product Deal Start -->
                                        <div
                                            class="product single-deal-product product-border-left">
                                            <div class="thumb">
                                                <a href="single-product-sale.html" class="image">
                                                    <img
                                                        src="{{ asset('ngdung/assets/images/products/medium-size/9.jpg')}}"
                                                        alt="Product" />
                                                </a>
                                            </div>
                                            <div class="content">
                                                <p class="inner-desc">Hurry Up! Offer Ends In:</p>
                                                <div class="countdown-area">
                                                    <div
                                                        class="countdown-wrapper d-flex"
                                                        data-countdown="2023/12/24"></div>
                                                </div>
                                                <h4 class="sub-title">
                                                    <a href="single-product-sale.html">Studio Design</a>
                                                </h4>
                                                <h5 class="title">
                                                    <a href="single-product-sale.html">Basic Lather Sneaker</a>
                                                </h5>
                                                <span class="ratings">
                                                    <span class="rating-wrap">
                                                        <span class="star" style="width: 80%"></span>
                                                    </span>
                                                    <span class="rating-num">(2)</span>
                                                </span>
                                                <span class="price">
                                                    <span class="new">$88.00</span>
                                                    <span class="old">$92.50</span>
                                                </span>
                                                <button
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary">
                                                    Add To Cart
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Single Product Deal End -->
                                    </div>
                                    <!-- Product End -->
                                </div>

                                <!-- Swiper Pagination Start -->
                                <div class="swiper-pagination d-md-none"></div>
                                <!-- Swiper Pagination End -->

                                <!-- Next Previous Button Start -->
                                <div
                                    class="swiper-product-deal-next swiper-button-next swiper-button-white d-md-flex d-none">
                                    <i class="pe-7s-angle-right"></i>
                                </div>
                                <div
                                    class="swiper-product-deal-prev swiper-button-prev swiper-button-white d-md-flex d-none">
                                    <i class="pe-7s-angle-left"></i>
                                </div>
                                <!-- Next Previous Button End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Products Tab End -->
    </div>
</div>
<!-- Product Deal Section End -->
<!-- Blog Section Start -->
<div class="section section-padding">
    <div class="container">
        <div class="row">
            <div class="section-title" data-aos="fade-up" data-aos-delay="300">
                <h2 class="title pb-3">Blog mới nhất</h2>
                <div class="title-border-bottom"></div>
            </div>
        </div>
        <div class="row mb-n6">
            <div
                class="col-lg-4 col-md-6 col-12 mb-6"
                data-aos="fade-up"
                data-aos-delay="300">
                <!-- Blog Single Post Start -->
                <div class="blog-single-post-wrapper">
                    <div class="blog-thumb">
                        <a class="blog-overlay" href="blog-details.html">
                            <img
                                class="fit-image"
                                src="{{ asset('ngdung/assets/images/blog/blog-post/1.jpg')}}"
                                alt="Blog Post" />
                        </a>
                    </div>
                    <div class="blog-content">
                        <div class="post-meta">
                            <span>By : <a href="#">Admin</a></span>
                            <span>14 Jul 2023</span>
                        </div>
                        <h3 class="title">
                            <a href="blog-details.html">Some Winter Collections</a>
                        </h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do
                            eiusmod tempo
                        </p>
                        <a
                            href="blog-details.html"
                            class="btn btn-dark btn-hover-primary text-uppercase">Đọc thêm</a>
                    </div>
                </div>
                <!-- Blog Single Post End -->
            </div>

            <div
                class="col-lg-4 col-md-6 col-12 mb-6"
                data-aos="fade-up"
                data-aos-delay="500">
                <!-- Blog Single Post Start -->
                <div class="blog-single-post-wrapper">
                    <div class="blog-thumb">
                        <a class="blog-overlay" href="blog-details.html">
                            <img
                                class="fit-image"
                                src="{{ asset('ngdung/assets/images/blog/blog-post/2.jpg')}}"
                                alt="Blog Post" />
                        </a>
                    </div>
                    <div class="blog-content">
                        <div class="post-meta">
                            <span>By : <a href="#">Admin</a></span>
                            <span>14 Jul 2023</span>
                        </div>
                        <h3 class="title">
                            <a href="blog-details.html">My Perty Fashion</a>
                        </h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do
                            eiusmod tempo
                        </p>
                        <a
                            href="blog-details.html"
                            class="btn btn-dark btn-hover-primary text-uppercase">Đọc thêm</a>
                    </div>
                </div>
                <!-- Blog Single Post End -->
            </div>

            <div
                class="col-lg-4 col-md-6 col-12 mb-6"
                data-aos="fade-up"
                data-aos-delay="700">
                <!-- Blog Single Post Start -->
                <div class="blog-single-post-wrapper">
                    <div class="blog-thumb">
                        <a class="blog-overlay" href="blog-details.html">
                            <img
                                class="fit-image"
                                src="{{ asset('ngdung/assets/images/blog/blog-post/3.jpg')}}"
                                alt="Blog Post" />
                        </a>
                    </div>
                    <div class="blog-content">
                        <div class="post-meta">
                            <span>By : <a href="#">Admin</a></span>
                            <span>14 Jul 2023</span>
                        </div>
                        <h3 class="title">
                            <a href="blog-details.html">Perfect Fashion House</a>
                        </h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do
                            eiusmod tempo
                        </p>
                        <a
                            href="blog-details.html"
                            class="btn btn-dark btn-hover-primary text-uppercase">Đọc thêm</a>
                    </div>
                </div>
                <!-- Blog Single Post End -->
            </div>
        </div>
    </div>
</div>
<!-- Blog Section End -->

@endsection
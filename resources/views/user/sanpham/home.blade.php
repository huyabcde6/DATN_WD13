@extends('layouts.home')

@section('content')
<!-- Hero/Intro Slider Start -->
<div class="section">
    <div class="hero-slider">
        <div class="swiper-container">

            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                <div class="hero-slide-item-two swiper-slide">
                    <div class="hero-slide-bg">
                        <!-- Sử dụng đường dẫn từ cơ sở dữ liệu để hiển thị ảnh -->
                        <img src="{{ url('storage/'. $banner->image_path) }}" alt="{{ $banner->title }}" />
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="hero-slide-content col-lg-8 col-xl-6 col-12 text-lg-center text-left">
                                <h2 class="title">
                                    {!! nl2br($banner->title) !!}
                                </h2>
                                <p>
                                    {{ $banner->description }}
                                </p>
                                <a href="{{ route('shop.index',['category' => $banner->category_id]) }}" class="btn btn-lg btn-primary btn-hover-dark">
                                    Mua ngay
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>

            <!-- Swiper Pagination Start -->
            <div class="swiper-pagination d-md-none"></div>
            <!-- Swiper Pagination End -->

            <!-- Swiper Navigation Start -->
            <div class="home-slider-prev swiper-button-prev main-slider-nav d-md-flex d-none">
                <i class="pe-7s-angle-left"></i>
            </div>
            <div class="home-slider-next swiper-button-next main-slider-nav d-md-flex d-none">
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
            <div class="row row-cols-lg-4 row-cols-xl-auto row-cols-sm-2 row-cols-1 justify-content-between mb-n5">
                <!-- Feature Start -->
                <div class="col mb-5" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature">
                        <div class="icon text-primary align-self-center">
                            <img src="{{ asset('ngdung/assets/images/icons/feature-icon-2.png')}}" alt="Feature Icon" />
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
                            <img src="{{ asset('ngdung/assets/images/icons/feature-icon-3.png')}}" alt="Feature Icon" />
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
                            <img src="{{ asset('ngdung/assets/images/icons/feature-icon-4.png')}}" alt="Feature Icon" />
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
                            <img src="{{ asset('ngdung/assets/images/icons/feature-icon-1.png')}}" alt="Feature Icon" />
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
                        <a href="shop-grid.html"><img src="{{ asset('ngdung/assets/images/banner/banner-4.jpg')}}"
                                alt="Banner Image" /></a>
                    </div>
                    <div class="info">
                        <div class="small-banner-content">
                            <h4 class="sub-title">Giảm giá tớ <span>50%</span></h4>
                            <h3 class="title">Váy công sở</h3>
                            <a href="shop-grid.html" class="btn btn-primary btn-hover-dark btn-sm">Mua Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Banner End -->

            <!-- Banner Start -->
            <div class="col-md-6 col-12 mb-6">
                <div class="banner" data-aos="fade-left" data-aos-delay="500">
                    <div class="banner-image">
                        <a href="shop-grid.html"><img src="{{ asset('ngdung/assets/images/banner/banner-5.jpg')}}"
                                alt="Banner Image" /></a>
                    </div>
                    <div class="info">
                        <div class="small-banner-content">
                            <h4 class="sub-title">Giảm giá tớ <span>40%</span></h4>
                            <h3 class="title">Tất cả sản phẩm</h3>
                            <a href="shop-grid.html" class="btn btn-primary btn-hover-dark btn-sm">Mua Ngay</a>
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
            <div class="col-12">
                <ul class="product-tab-nav nav justify-content-center mb-10 title-border-bottom mt-n3">
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="300">
                        <a class="nav-link active mt-3" data-bs-toggle="tab" href="#tab-product-new">Sản Phẩm Mới</a>
                    </li>
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="400">
                        <a class="nav-link mt-3" data-bs-toggle="tab" href="#tab-product-best-seller">Sản Phẩm Bán Chạy</a>
                    </li>
                    <li class="nav-item" data-aos="fade-up" data-aos-delay="500">
                        <a class="nav-link mt-3" data-bs-toggle="tab" href="#tab-product-sale">Sản Phẩm Sale</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Section Title & Tab End -->

        <!-- Products Tab Start -->
        <div class="row">
            <div class="col">
                <div class="tab-content position-relative">
                    <!-- Sản Phẩm Mới -->
                    <div class="tab-pane fade show active" id="tab-product-new">
                        <div class="product-carousel">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach($newProducts as $product)
                                    <div class="swiper-slide product-wrapper">
                                        <div class="product product-border-left mb-10" data-aos="fade-up" data-aos-delay="300">
                                            <div class="thumb">
                                                <a href="{{ route('product.show', $product->slug) }}" class="image">
                                                    <img class="image" src="{{ url('storage/' . $product->avata) }}" alt="{{ $product->name }}" />
                                                </a>
                                                <span class="badges">
                                                    <span class="new">New</span>
                                                </span>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a href="#" class="action quickview" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h5 class="title">
                                                    <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                                </h5>
                                                <span class="price">
                                                    <span class="new">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                                                    @if($product->discount_price)
                                                    <span class="old">{{ number_format($product->discount_price, 0, ',', '.') }} đ</span>
                                                    @endif
                                                </span>
                                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-outline-dark btn-hover-primary"><i class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
                            </div>
                        </div>
                    </div>

                    <!-- Sản Phẩm Bán Chạy -->
                    <div class="tab-pane fade" id="tab-product-best-seller">
                        <div class="product-carousel">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach($bestSellingProducts as $product)
                                    <div class="swiper-slide product-wrapper">
                                        <div class="product product-border-left mb-10" data-aos="fade-up" data-aos-delay="300">
                                            <div class="thumb">
                                                <a href="{{ route('product.show', $product->slug) }}" class="image">
                                                    <img class="image" src="{{ url('storage/' . $product->avata) }}" alt="{{ $product->name }}" />
                                                </a>
                                                <span class="badges">
                                                    <span class="sale">Hot</span>
                                                </span>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a href="#" class="action quickview" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h5 class="title">
                                                    <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                                </h5>
                                                <span class="price">
                                                    <span class="new">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                                                    @if($product->discount_price)
                                                    <span class="old">{{ number_format($product->discount_price, 0, ',', '.') }} đ</span>
                                                    @endif
                                                </span>
                                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-outline-dark btn-hover-primary"><i class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
                            </div>
                        </div>
                    </div>

                    <!-- Sản Phẩm Sale -->
                    <div class="tab-pane fade" id="tab-product-sale">
                        <div class="product-carousel">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach($saleProducts as $product)
                                    <div class="swiper-slide product-wrapper">
                                        <div class="product product-border-left mb-10" data-aos="fade-up" data-aos-delay="300">
                                            <div class="thumb">
                                                <a href="{{ route('product.show', $product->slug) }}" class="image">
                                                    <img class="image" src="{{ url('storage/' . $product->avata) }}" alt="{{ $product->name }}" />
                                                </a>
                                                <span class="badges">
                                                    <span class="sale">Sale</span>
                                                </span>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a href="#" class="action quickview" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h5 class="title">
                                                    <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                                </h5>
                                                <span class="price">
                                                    <span class="new">{{ number_format($product->price, 0, ',', '.') }} VND</span>
                                                    @if($product->discount_price)
                                                    <span class="old">{{ number_format($product->discount_price, 0, ',', '.') }} VND</span>
                                                    @endif
                                                </span>
                                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-outline-dark btn-hover-primary"><i class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Swiper Pagination Start -->

                                    @endforeach

                                </div>
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
                        <a href="shop-grid.html"><img src="{{ asset('ngdung/assets/images/banner/big-banner.jpg')}}"
                                alt="Banner" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Blog Section Start -->
<div class="section section-padding">
    <div class="container">
        <div class="row">
            <div class="section-title" data-aos="fade-up" data-aos-delay="300">
                <h2 class="title pb-3">Tin tức mới nhất</h2>
                <div class="title-border-bottom"></div>
            </div>
        </div>
        <div class="row mb-n6">

            @foreach($news as $new)
            <div
                class="col-lg-4 col-md-6 col-12 mb-6"
                data-aos="fade-up"
                data-aos-delay="300">

                <!-- Blog Single Post Start -->
                <div class="blog-single-post-wrapper">
                    <div class="blog-thumb">
                        <a class="blog-overlay" href="blog-details.html">
                            <img class="fit-image" src="{{ url('storage/'. $new->avata) }}"
                                alt="Blog Post" />
                        </a>
                    </div>
                    <div class="blog-content">
                        <div class="post-meta">
                            <span>{{ $new->created_at }}</span>
                        </div>
                        <h3 class="title">
                            <a href="blog-details.html">{{ $new->title }}</a>
                        </h3>
                        <p>
                            {{ $new->description }}
                        </p>
                        <a href="blog-details.html" class="btn btn-dark btn-hover-primary text-uppercase">Đọc thêm</a>
                    </div>
                </div>
                <!-- Blog Single Post End -->
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Blog Section End -->

@endsection
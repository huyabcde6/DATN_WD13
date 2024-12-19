@extends('layouts.home')
@section('css')
<style>
.coupon-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    display: flex;
    max-width: 400px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.coupon-left {
    background-color: #FFC107;
    /* Màu vàng */
    width: 10px;
}

.coupon-content {
    padding: 15px;
    flex-grow: 1;
}

.coupon-title {
    font-weight: bold;
    font-size: 1.2rem;
    margin-bottom: 5px;
}

.coupon-desc {
    font-size: 0.9rem;
    color: #555;
}

.coupon-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.copy-btn {
    background-color: #000;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 5px 10px;
    cursor: pointer;
}

.copy-btn:hover {
    background-color: #333;
}
</style>
@endsection
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
                        <img src="{{ url('storage/'.$banner->image_path) }}" alt="{{ $banner->title }}" />
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
                                <a href="{{ route('shop.index',['category' => $banner->category_id]) }}"
                                    class="btn btn-lg btn-primary btn-hover-dark">
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
        <h2>Ưu đãi dành cho bạn</h2>
        <div class="row mb-n6 overflow-hidden">
            <!-- Banner Start -->

            @forelse($coupons as $voucher)
            <div class="mx-3 mt-3 coupon-card">
                <div class="coupon-left"></div>
                <div class="coupon-content">
                    <div class="coupon-title">{{ $voucher->code }}</div>
                    <div class="coupon-desc">
                        giảm {{ number_format($voucher->discount_value, 0, ',', '.') }}% (tối đa
                        {{ number_format($voucher->max_discount_amount, 0, ',', '.') }} đ) <br>
                        Mã: <strong class="voucher-code">{{ $voucher->code }}</strong> <br>
                        HSD: {{ \Carbon\Carbon::parse($voucher->end_date)->format('d-m-Y') }}
                    </div>
                    <div class="coupon-footer mt-2">
                        <div class="fw-bold voucher-code">{{ $voucher->code }}</div>
                        <button class="copy-btn">Sao chép mã</button>
                    </div>
                </div>
            </div>
            <!-- Banner End -->
            @empty
            <p>Không có voucher nào khả dụng.</p>
            @endforelse
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
                        <a class="nav-link mt-3" data-bs-toggle="tab" href="#tab-product-best-seller">Sản Phẩm Bán
                            Chạy</a>
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
                                        <div class="product product-border-left mb-10" data-aos="fade-up"
                                            data-aos-delay="300">
                                            <div class="thumb">
                                                <a href="{{ route('product.show', $product->slug) }}" class="image">
                                                    <img class="image" src="{{ url('storage/' . $product->avata) }}"
                                                        alt="{{ $product->name }}" />
                                                </a>
                                                <span class="badges">
                                                    <span class="new">New</span>
                                                </span>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a href="#" class="action quickview" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i
                                                            class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h5 class="title">
                                                    <a
                                                        href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                                </h5>
                                                <span class="price">
                                                    <span class="new">{{ number_format($product->price, 0, ',', '.') }}
                                                        đ</span>
                                                    @if($product->discount_price)
                                                    <span
                                                        class="old">{{ number_format($product->discount_price, 0, ',', '.') }}
                                                        đ</span>
                                                    @endif
                                                </span>
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary"><i
                                                        class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết</a>
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
                                        <div class="product product-border-left mb-10" data-aos="fade-up"
                                            data-aos-delay="300">
                                            <div class="thumb">
                                                <a href="{{ route('product.show', $product->slug) }}" class="image">
                                                    <img class="image" src="{{ url('storage/' . $product->avata) }}"
                                                        alt="{{ $product->name }}" />
                                                </a>
                                                <span class="badges">
                                                    <span class="sale">Hot</span>
                                                </span>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a href="#" class="action quickview" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i
                                                            class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h5 class="title">
                                                    <a
                                                        href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                                </h5>
                                                <span class="price">
                                                    <span class="new">{{ number_format($product->price, 0, ',', '.') }}
                                                        đ</span>
                                                    @if($product->discount_price)
                                                    <span
                                                        class="old">{{ number_format($product->discount_price, 0, ',', '.') }}
                                                        đ</span>
                                                    @endif
                                                </span>
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary"><i
                                                        class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết</a>
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
                                        <div class="product product-border-left mb-10" data-aos="fade-up"
                                            data-aos-delay="300">
                                            <div class="thumb">
                                                <a href="{{ route('product.show', $product->slug) }}" class="image">
                                                    <img class="image" src="{{ url('storage/' . $product->avata) }}"
                                                        alt="{{ $product->name }}" />
                                                </a>
                                                <span class="badges">
                                                    <span class="sale">Sale</span>
                                                </span>
                                                <div class="actions">
                                                    <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                                    <a href="#" class="action quickview" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter"><i
                                                            class="pe-7s-search"></i></a>
                                                    <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <h5 class="title">
                                                    <a
                                                        href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                                </h5>
                                                <span class="price">
                                                    <span class="new">{{ number_format($product->price, 0, ',', '.') }}
                                                        VND</span>
                                                    @if($product->discount_price)
                                                    <span
                                                        class="old">{{ number_format($product->discount_price, 0, ',', '.') }}
                                                        VND</span>
                                                    @endif
                                                </span>
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                    class="btn btn-sm btn-outline-dark btn-hover-primary"><i
                                                        class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết</a>
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
                        <a href="shop-grid.html"><img src="{{ asset('ngdung/assets/images/banner/banchay_a01333a0db53411883d51490d22b7eab.webp')}}"
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
            <div class="col-lg-4 col-md-6 col-12 mb-6" data-aos="fade-up" data-aos-delay="300">

                <!-- Blog Single Post Start -->
                <div class="blog-single-post-wrapper">
                    <div class="blog-thumb">
                        <a class="blog-overlay" href="{{ route('tintucdetail', ['id' => $new->id]) }}">
                            <img class="fit-image" src="{{ url('storage/'. $new->avata) }}" alt="Blog Post" />
                        </a>
                    </div>
                    <div class="blog-content">
                        <div class="post-meta">
                            <span>{{ $new->created_at }}</span>
                        </div>
                        <h3 class="title">
                            <a href="{{ route('tintucdetail', ['id' => $new->id]) }}">{{ $new->title }}</a>
                        </h3>
                        <p>
                            {{ $new->description }}
                        </p>
                        <a href="{{ route('tintucdetail', ['id' => $new->id]) }}"
                            class="btn btn-dark btn-hover-primary text-uppercase">Đọc thêm</a>
                    </div>
                </div>
                <!-- Blog Single Post End -->
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.copy-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            // Tìm mã voucher gần nút sao chép nhất
            var voucherCode = button.closest('.coupon-card').querySelector('.voucher-code').textContent; 

            var tempInput = document.createElement('input'); // Tạo một input ẩn tạm thời
            tempInput.value = voucherCode;
            document.body.appendChild(tempInput);

            tempInput.select(); // Chọn nội dung của input
            document.execCommand('copy'); // Thực hiện sao chép

            document.body.removeChild(tempInput); // Xóa input tạm thời

            Swal.fire({
                title: 'Sao chép thành công!',
                text: 'Mã khuyến mãi: ' + voucherCode,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Đóng'
            }); // Thông báo cho người dùng
        });
    });
</script>

@endsection
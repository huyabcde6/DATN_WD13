@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb">
        <a href="http://datn_wd13.test/"><i class="fa fa-home"></i> Trang Chủ</a>
        <span class="breadcrumb-separator"> > </span>
        <span><a href="http://datn_wd13.test/shop">Cửa hàng</a></span>
    </div>
    <!-- Breadcrumb Area End -->

</div>
<!-- Breadcrumb Section End -->

<!-- Shop Section Start -->
<div class="section section-margin">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9 col-12 col-custom">

                <!--shop toolbar start-->
                <div class="shop_toolbar_wrapper flex-column flex-md-row mb-10">

                    <!-- Shop Top Bar Left start -->
                    <div class="shop-top-bar-left mb-md-0 mb-2">
                        <div class="shop-top-show">
                            <span>Hiển thị 1–12 trong 39 kết quả</span>
                        </div>
                    </div>
                    <!-- Shop Top Bar Left end -->

                    <!-- Shopt Top Bar Right Start -->
                    <div class="shop-top-bar-right">
                        <div class="shop-short-by mr-4">
                            <select class="nice-select" aria-label=".form-select-sm example">
                                <option selected>Hiển thị 24</option>
                                <option value="1">Hiển thị 24</option>
                                <option value="2">Hiển thị 12</option>
                                <option value="3">Hiển thị 15</option>
                                <option value="3">Hiển thị 30</option>
                            </select>
                        </div>

                        <div class="shop-short-by mr-4">
                            <select class="nice-select" aria-label=".form-select-sm example">
                                <option selected>Sắp xếp mặc định</option>
                                <option value="1">Sản phẩm hot</option>
                                <option value="2">Sắp xếp theo hạng</option>
                                <option value="3">Sản phẩm mới nhất</option>
                                <option value="3">Sắp xếp theo giá</option>
                            </select>
                        </div>

                        <div class="shop_toolbar_btn">
                            <button data-role="grid_3" type="button" class="active btn-grid-4" title="Grid"><i
                                    class="fa fa-th"></i></button>
                            <button data-role="grid_list" type="button" class="btn-list" title="List"><i
                                    class="fa fa-th-list"></i></button>
                        </div>
                    </div>
                    <!-- Shopt Top Bar Right End -->

                </div>
                <!--shop toolbar end-->

                <!-- Shop Wrapper Start -->
                <div class="row shop_wrapper grid_3">

                    <!-- Single Product Start -->
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-4 col-sm-6 product" data-aos="fade-up" data-aos-delay="200">
                        <div class="product-inner">
                            <div class="thumb">
                                <a href="{{ route('product.show', $product->slug) }}" class="image">
                                    <img class="image" src="{{ url('storage/'. $product->avata) }}" alt="Product"
                                        width="auto" height="auto" />
                                </a>
                                <!-- <div class="actions">
                                    <a href="wishlist.html" title="Wishlist" class="action wishlist"><i
                                            class="pe-7s-like"></i></a>
                                    <a href="#" title="Quickview" class="action quickview" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                    <a href="compare.html" title="Compare" class="action compare"><i
                                            class="pe-7s-shuffle"></i></a>
                                </div> -->
                            </div>
                            <div class="content">
                                <h4 class="sub-title">{{ $product->categories->name }}
                                </h4>
                                <h5 class="title"><a
                                        href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h5>
                                <p>{{ $product->short_description }}</p>
                                <span class="price">
                                    @if ($product->discount_price)
                                    <span class="new">{{ number_format($product->discount_price, 0, '', '.') }}
                                        ₫</span>&nbsp;&nbsp;
                                    <span class="old">{{ number_format($product->price, 0, '', '.') }} ₫</span>
                                    @else
                                    <span class="new">{{ number_format($product->price, 0, '', '.') }} ₫</span>
                                    @endif
                                </span>

                                <div class="shop-list-btn">
                                    <!-- <a title="Wishlist" href="#"
                                        class="btn btn-sm btn-outline-dark btn-hover-primary wishlist"><i
                                            class="fa fa-heart"></i></a> -->
                                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-outline-dark btn-hover-primary"
                                        title="Add To Cart"><i class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết</a>
                                    <!-- <a title="Compare" href="#"
                                        class="btn btn-sm btn-outline-dark btn-hover-primary compare"><i
                                            class="fa fa-random"></i></a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Product End -->
                    @endforeach
                </div>
                <!-- Shop Wrapper End -->

                <!--shop toolbar start-->
                <div class="shop_toolbar_wrapper mt-10">

                    <!-- Shop Top Bar Left start -->
                    <div class="shop-top-bar-left">
                        <div class="shop-short-by mr-4">
                            <select class="nice-select rounded-0" aria-label=".form-select-sm example">
                                <option selected>Hiển thị 12 mỗi trang</option>
                                <option value="1">Hiển thị 12 mỗi trang</option>
                                <option value="2">Hiển thị 24 mỗi trang</option>
                                <option value="3">Hiển thị 15 mỗi trang</option>
                                <option value="3">Hiển thị 30 mỗi trang</option>
                            </select>
                        </div>
                    </div>
                    <!-- Shop Top Bar Left end -->

                    <!-- Shopt Top Bar Right Start -->
                    <div class="shop-top-bar-right">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link active" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Shopt Top Bar Right End -->

                </div>
                <!--shop toolbar end-->

            </div>
            <div class="col-lg-3 col-12 col-custom">
                <!-- Sidebar Widget Start -->
                <aside class="sidebar_widget mt-10 mt-lg-0">
                    <div class="widget_inner" data-aos="fade-up" data-aos-delay="200">
                        <div class="widget-list mb-10">
                            <h3 class="widget-title mb-4">Tìm kiếm</h3>

                            <form action="{{ route('shop.index') }}" method="GET">
                                <div class="search-box">
                                    <input type="text" name="keyword" class="form-control"
                                        placeholder="Nhập từ khóa cần tìm" required>
                                    <button class="btn btn-dark btn-hover-primary"  style="margin-top:0px" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>

                        </div>
                        <div class="widget-list mb-10">
                            <h3 class="widget-title mb-4">Danh mục</h3>
                            <nav>
                                <ul class="category-menu mb-n3">
                                    @foreach ($categories as $category)
                                    <li class="menu-item-has-children pb-4">
                                        <a href="#" data-category-id="{{ $category->id }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </nav>
                        </div>

                        <div class="widget-list mb-10">
                            <h3 class="widget-title mb-5">Bộ lọc giá</h3>
                            <form action="{{ route('shop.index') }}" method="GET">
                                <div id="slider-range"></div>
                                <input type="hidden" name="min_price" id="min_price" value="{{ $priceRange['min'] }}">
                                <input type="hidden" name="max_price" id="max_price" value="{{ $priceRange['max'] }}">
                                <button class="slider-range-submit" type="submit">Lọc</button>

                            </form>
                        </div>
                        <div class="widget-list mb-10">
                            <h3 class="widget-title">Màu sắc</h3>
                            <div class="sidebar-body">
                                <ul class="checkbox-container categories-list">
                                    @foreach ($colors as $color)
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                class="custom-control-input"
                                                id="color_{{ $color->color_id }}"
                                                value="{{ $color->color_id }}"
                                                {{ in_array($color->color_id, (array) request('colors', [])) ? 'checked' : '' }}

                                                onchange="updateFilters()">
                                            <label class="custom-control-label" for="color_{{ $color->color_id }}">
                                                {{ $color->value }} ({{ $color->productDetails->count() }})
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="widget-list">
                            <h3 class="widget-title mb-4">Sản phẩm gần đây</h3>
                            <div class="sidebar-body product-list-wrapper mb-n6">
                                @foreach ($recentProducts as $product)
                                <div class="single-product-list product-hover mb-6">
                                    <div class="thumb">
                                        <a href="{{ route('product.show', $product->slug) }}" class="image">
                                            <img class="image" src="{{ url('storage/'. $product->avata) }}"
                                                alt="{{ $product->name }}">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="title"><a
                                                href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                        </h5>
                                        <span class="price">
                                            <span class="new">{{ number_format($product->price, 0, '', '.') }} ₫</span>
                                            @if ($product->discount_price)
                                            <span class="old">{{ number_format($product->discount_price , 0, '', '.') }}
                                                ₫</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </aside>
                <!-- Sidebar Widget End -->
            </div>
        </div>
    </div>
</div>
<!-- Shop Section End -->
<!-- Scroll Top Start -->
<a href="#" class="scroll-top" id="scroll-top">
    <i class="arrow-top fa fa-long-arrow-up"></i>
    <i class="arrow-bottom fa fa-long-arrow-up"></i>
</a>
<!-- Scroll Top End -->
@endsection
@section('js')
<!-- Include jQuery from CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // When a category is clicked
        $('.category-menu a').on('click', function(e) {
            e.preventDefault();

            // Get the selected category ID from the data attribute
            var categoryId = $(this).data('category-id');

            // Make an AJAX request to filter products by category
            $.ajax({
                url: '/filter-products', // This is the route that will handle the filtering
                method: 'GET',
                data: {
                    category_id: categoryId // Sending category ID as a query parameter
                },
                success: function(response) {
                    // Update the products list with the filtered data
                    $('#products-list').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);
                }
            });
        });
    });
</script>
@endsection
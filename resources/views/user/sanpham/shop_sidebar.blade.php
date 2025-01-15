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
                            <span id="result-count">Hiển thị 1–12 trong 39 kết quả</span>
                        </div>
                    </div>
                    <!-- Shop Top Bar Left end -->

                    <!-- Shop Top Bar Right Start -->
                    <div class="shop-top-bar-right">
                        <div class="d-flex">
                            <div class="shop-short-by mr-4">
                                <select class="form-select" id="select-limit">
                                    <option value="12" {{ request('limit') == 12 ? 'selected' : '' }}>Hiển thị 12</option>
                                    <option value="24" {{ request('limit') == 24 ? 'selected' : '' }}>Hiển thị 24</option>
                                    <option value="36" {{ request('limit') == 36 ? 'selected' : '' }}>Hiển thị 36</option>
                                </select>
                            </div>

                            <div class="shop-short-by mr-4">
                                <select class="form-select" id="select-sort">
                                    <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Sắp xếp mặc định</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                                </select>
                            </div>

                            <div class="shop_toolbar_btn">
                                <button data-role="grid_3" type="button" class="active btn-grid-4" title="Grid"><i class="fa fa-th"></i></button>
                                <button data-role="grid_list" type="button" class="btn-list" title="List"><i class="fa fa-th-list"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- Shop Top Bar Right End -->
                </div>

                                <!--shop toolbar end-->

                <!-- Shop Wrapper Start -->
                <div class="row shop_wrapper grid_3" id="productList" >
                    <!-- Single Product Start -->
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-4 col-sm-6 product" data-aos="fade-up" data-aos-delay="200">
                        <div class="product-inner">
                            <div class="thumb">
                                <a href="{{ route('product.show', $product->slug) }}" class="image">
                                    <img class="image" src="{{ url('storage/'. $product->avata) }}" alt="Product"
                                        width="auto" height="auto" />
                                </a>

                            </div>
                            <div class="content">
                                <h4 class="sub-title">{{ $product->categories->name }}
                                </h4>
                                <h5 class="title"><a
                                        href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce posuere metus vitae
                                    arcu imperdiet, id aliquet ante scelerisque. Sed sit amet sem vitae urna fringilla
                                    tempus.</p>
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
                                    <a title="Wishlist" href="#"
                                        class="btn btn-sm btn-outline-dark btn-hover-primary wishlist"><i
                                            class="fa fa-heart"></i></a>
                                    <a href="{{ route('product.show', $product->slug) }}"
                                        class="btn btn-sm btn-outline-dark btn-hover-primary" title="Add To Cart"><i
                                            class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết</a>
                                    <a title="Compare" href="#"
                                        class="btn btn-sm btn-outline-dark btn-hover-primary compare"><i
                                            class="fa fa-random"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Product End -->
                    @endforeach
                </div>
                <!-- Shop Wrapper End -->

                <!--shop toolbar start-->
                <div class="shop_toolbar_wrapper d-flex mt-10">

                    <!-- Shop Top Bar Left start -->
                    <div class="shop-top-bar-left">

                    </div>
                    <!-- Shop Top Bar Left end -->

                    <!-- Shopt Top Bar Right Start -->
                    <div class="shop-top-bar-right justify-content-end">
                        <div class="pagination-wrapper">
                            {{ $products->appends(request()->input())->links() }}
                        </div>
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
                            <div class="search-box">
                                <input type="text" name="keyword" class="form-control" id="searchKeyword" placeholder="Nhập từ khóa cần tìm">
                            </div>
                        </div>

                        <div class="widget-list mb-10">
                            <h3 class="widget-title mb-4">Danh mục</h3>
                            <nav>
                                <ul class="category-menu mb-n3">
                                    @foreach ($categories as $category)
                                    <li class="menu-item-has-children pb-4">
                                        <a href="javascript:void(0);" class="filter-category" data-category="{{ $category->id }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </nav>
                        </div>

                        <div id="paginationWrapper" class="pagination-wrapper"></div>



                        <div class="widget-list mb-10">
                            <h3 class="widget-title">Khoảng giá</h3>
                            <div class="sidebar-body">
                                <ul class="checkbox-container price-range-list">
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter-price" id="price-below-100" value="0-100000">
                                            <label class="custom-control-label" for="price-below-100">Dưới 100.000 ₫</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter-price" id="price-100-250" value="100000-250000">
                                            <label class="custom-control-label" for="price-100-250">100.000 ₫ - 250.000 ₫</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter-price" id="price-250-500" value="250000-500000">
                                            <label class="custom-control-label" for="price-250-500">250.000 ₫ - 500.000 ₫</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter-price" id="price-above-500" value="500000-1000000">
                                            <label class="custom-control-label" for="price-above-500">Trên 500.000 ₫</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="widget-list mb-10">
                            <h3 class="widget-title">Màu sắc</h3>
                            <div class="sidebar-body">
                                <ul class="checkbox-container categories-list">
                                    @foreach ($attributes->where('name', 'Màu sắc')->first()->values as $color)
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter-color" id="color-{{ $color->id }}" value="{{ $color->value }}">
                                            <label class="custom-control-label" for="color-{{ $color->id }}">
                                                {{ $color->value }}
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>


                        <!-- <div class="widget-list">
                            <h3 class="widget-title mb-4">Sản phẩm gần đây</h3>
                            <div class="sidebar-body product-list-wrapper mb-n6">

                                <div class="single-product-list product-hover mb-6">
                                    <div class="thumb">
                                        <a href="" class="image">
                                            <img class="image" src="" alt="">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="title"><a href=""></a>
                                        </h5>
                                        <span class="price">
                                            <span class="new"></span>

                                            <span class="old">
                                                ₫</span>

                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div> -->

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Khởi tạo thanh trượt với giá trị min, max
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 1000000, // Giá trị tối đa của sản phẩm
            step: 1000, // Bước nhảy mỗi lần
            values: [{
                {
                    request('min_price', 0)
                }
            }, {
                {
                    request('max_price', 1000000)
                }
            }],
            slide: function(event, ui) {
                // Cập nhật giá trị của min_price và max_price
                $("#min_price").val(ui.values[0]);
                $("#max_price").val(ui.values[1]);

                // Cập nhật hiển thị giá hiện tại
                $("#amount").text("Giá: " + ui.values[0] + " - " + ui.values[1]);
            }
        });

        // Cập nhật giá trị mặc định của input min_price và max_price khi trang tải
        $("#min_price").val($("#slider-range").slider("values", 0));
        $("#max_price").val($("#slider-range").slider("values", 1));

        // Cập nhật hiển thị giá khi trang tải
        $("#amount").text("Giá: " + $("#min_price").val() + " - " + $("#max_price").val());
    });
</script>
<script>
$(document).ready(function () {
    // Hàm load sản phẩm qua AJAX
    function loadProducts(filters = {}) {
        $.ajax({
            url: "{{ route('ajax.products.filter') }}",
            method: "GET",
            data: filters,
            success: function (response) {
                let productsHtml = '';
                response.products.data.forEach(function (product) {
                    // Kiểm tra dữ liệu trước khi render
                    if (!product.name || !product.avata) {
                        console.warn("Sản phẩm thiếu dữ liệu: ", product);
                        return;
                    }

                    productsHtml += `
                            <div class="col-lg-4 col-md-4 col-sm-6 product" data-aos="fade-up" data-aos-delay="200">
                                <div class="product-inner">
                                    <div class="thumb">
                                        <a href="/san-pham/${product.slug}" class="image">
                                            <img class="image" src="/storage/${product.avata}" alt="${product.name}" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h4 class="sub-title">${product.categories?.name || 'Không có danh mục'}</h4>
                                        <h5 class="title"><a href="/san-pham/${product.slug}">${product.name}</a></h5>
                                        <p>${product.short_description || 'Mô tả sản phẩm đang cập nhật...'}</p>
                                        <span class="price">
                                            ${product.discount_price 
                                                ? `<span class="new">${new Intl.NumberFormat('vi-VN').format(product.discount_price)} ₫</span>
                                                <span class="old">${new Intl.NumberFormat('vi-VN').format(product.price)} ₫</span>`
                                                : `<span class="new">${new Intl.NumberFormat('vi-VN').format(product.price)} ₫</span>`
                                            }
                                        </span>
                                        <div class="shop-list-btn">
                                            <a title="Wishlist" href="#" class="btn btn-sm btn-outline-dark btn-hover-primary wishlist">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                            <a href="/san-pham/${product.slug}" class="btn btn-sm btn-outline-dark btn-hover-primary" title="Xem chi tiết">
                                                <i class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết
                                            </a>
                                            <a title="Compare" href="#" class="btn btn-sm btn-outline-dark btn-hover-primary compare">
                                                <i class="fa fa-random"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                    });


                    $('#productList').html(productsHtml);
                    $('#paginationWrapper').html(response.products.links || '');
            },
            error: function (xhr, status, error) {
                console.error("Lỗi khi tải sản phẩm:", xhr.responseText);
            },
        });
    }

    // Lấy danh sách màu sắc được chọn
    function getSelectedColors() {
        const selectedColors = [];
        $('.filter-color:checked').each(function () {
            selectedColors.push($(this).val());
        });
        return selectedColors;
    }
    function getSelectedPrices() {
        const selectedPrices = [];
        $('.filter-price:checked').each(function () {
            selectedPrices.push($(this).val());
        });
        return selectedPrices;
    }
    $('#select-limit').on('change', function () {
        loadProducts(getFilters());
    });

    // Lắng nghe sự kiện thay đổi trên sắp xếp
    $('#select-sort').on('change', function () {
        loadProducts(getFilters());
    });
    function getFilters() {
        const filters = {
            limit: $('#select-limit').val(),
            sort: $('#select-sort').val(),
            colors: getSelectedColors(),
            prices: getSelectedPrices(),
            keyword: $('#searchKeyword').val(),
            category: $('.filter-category.active').data('category') || null,
        };
        return filters;
    }
    // Tìm kiếm khi người dùng gõ vào ô tìm kiếm
    $('#searchKeyword').on('keyup', function () {
        loadProducts(getFilters());
    });
    $('.filter-category').on('click', function () {
        $('.filter-category').removeClass('active');
        $(this).addClass('active');
        loadProducts(getFilters());
    });
    // Bắt sự kiện khi checkbox được thay đổi
    $('.filter-color, .filter-price').on('change', function () {
        const filters = {
            colors: getSelectedColors(),
            prices: getSelectedPrices(),
            keyword: $('#searchKeyword').val(),
            category: $('.filter-category.active').data('category') || null, // Lấy danh sách màu được chọn
        };
        loadProducts(filters); // Gửi AJAX với bộ lọc màu
    });
});

</script>
@endsection
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
            <form action="{{ route('shop.index') }}" class="d-flex" method="GET">
                <div class="shop-short-by mr-4">
                    <select class="form-select" name="limit" onchange="this.form.submit()">
                        <option value="12" {{ request('limit') == 12 ? 'selected' : '' }}>Hiển thị 12
                        </option>
                        <option value="24" {{ request('limit') == 24 ? 'selected' : '' }}>Hiển thị 24
                        </option>
                        <option value="36" {{ request('limit') == 36 ? 'selected' : '' }}>Hiển thị 36
                        </option>
                    </select>
                </div>

                <div class="shop-short-by mr-4">
                    <select class="form-select" name="sort" onchange="this.form.submit()">
                        <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Sắp xếp mặc định
                        </option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                            Giá giảm dần</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá
                            tăng dần</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất
                        </option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất
                        </option>
                    </select>
                </div>

                <div class="shop_toolbar_btn">
                    <button data-role="grid_3" type="button" class="active btn-grid-4" title="Grid"><i
                            class="fa fa-th"></i></button>
                    <button data-role="grid_list" type="button" class="btn-list" title="List"><i
                            class="fa fa-th-list"></i></button>
                </div>
            </form>
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
                        <img class="image" src="{{ url('storage/'. $product->avata) }}" alt="Product" width="auto"
                            height="auto" />
                    </a>
                    <div class="actions">
                        <a href="wishlist.html" title="Wishlist" class="action wishlist"><i class="pe-7s-like"></i></a>
                        <a href="#" title="Quickview" class="action quickview" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                        <a href="compare.html" title="Compare" class="action compare"><i class="pe-7s-shuffle"></i></a>
                    </div>
                </div>
                <div class="content">
                    <h4 class="sub-title">{{ $product->categories->name }}
                    </h4>
                    <h5 class="title"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                    </h5>
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
                        <a title="Wishlist" href="#" class="btn btn-sm btn-outline-dark btn-hover-primary wishlist"><i
                                class="fa fa-heart"></i></a>
                        <a href="{{ route('product.show', $product->slug) }}"
                            class="btn btn-sm btn-outline-dark btn-hover-primary" title="Add To Cart"><i
                                class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết</a>
                        <a title="Compare" href="#" class="btn btn-sm btn-outline-dark btn-hover-primary compare"><i
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
@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Shop Grid Sidebar</h1>
                <ul>
                    <li>
                        <a href="index.html">Home </a>
                    </li>
                    <li class="active"> shop</li>
                </ul>
            </div>
        </div>
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
                            <span>Showing 1–12 of 39 results</span>
                        </div>
                    </div>
                    <!-- Shop Top Bar Left end -->

                    <!-- Shopt Top Bar Right Start -->
                    <div class="shop-top-bar-right">
                        <div class="shop-short-by mr-4">
                            <select class="nice-select" aria-label=".form-select-sm example">
                                <option selected>Show 24</option>
                                <option value="1">Show 24</option>
                                <option value="2">Show 12</option>
                                <option value="3">Show 15</option>
                                <option value="3">Show 30</option>
                            </select>
                        </div>

                        <div class="shop-short-by mr-4">
                            <select class="nice-select" aria-label=".form-select-sm example">
                                <option selected>Short by Default</option>
                                <option value="1">Short by Popularity</option>
                                <option value="2">Short by Rated</option>
                                <option value="3">Short by Latest</option>
                                <option value="3">Short by Price</option>
                                <option value="3">Short by Price</option>
                            </select>
                        </div>

                        <div class="shop_toolbar_btn">
                            <button data-role="grid_3" type="button" class="active btn-grid-4" title="Grid"><i class="fa fa-th"></i></button>
                            <button data-role="grid_list" type="button" class="btn-list" title="List"><i class="fa fa-th-list"></i></button>
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
                                <a href="single-product.html" class="image">
                                    <img class="first-image" src="{{ asset('ngdung/assets/images/products/medium-size/2.jpg')}}" alt="Product" />
                                    <img class="second-image" src="{{ asset('ngdung/assets/images/products/medium-size/3.jpg')}}" alt="Product" />
                                </a>
                                <div class="actions">
                                    <a href="wishlist.html" title="Wishlist" class="action wishlist"><i class="pe-7s-like"></i></a>
                                    <a href="#" title="Quickview" class="action quickview" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                    <a href="compare.html" title="Compare" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                </div>
                            </div>
                            <div class="content">
                                <h4 class="sub-title"><a href="single-product.html">{{ $product->categories->name }}</a></h4>
                                <h5 class="title"><a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a></h5>
                                <span class="ratings">
                                    <span class="rating-wrap">
                                        <span class="star" style="width: 100%"></span>
                                    </span>
                                    <span class="rating-num">(4)</span>
                                </span>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce posuere metus vitae arcu imperdiet, id aliquet ante scelerisque. Sed sit amet sem vitae urna fringilla tempus.</p>
                                <span class="price">
                                    @if ($product->productDetails->isNotEmpty())
                                        <span class="old">{{ $product->productDetails->first()->price }}</span>
                                    @else
                                        <span class="old">Price not available</span>
                                    @endif
                                </span>
                                <div class="shop-list-btn">
                                    <a title="Wishlist" href="#" class="btn btn-sm btn-outline-dark btn-hover-primary wishlist"><i class="fa fa-heart"></i></a>
                                    <button class="btn btn-sm btn-outline-dark btn-hover-primary" title="Add To Cart">Add To Cart</button>
                                    <a title="Compare" href="#" class="btn btn-sm btn-outline-dark btn-hover-primary compare"><i class="fa fa-random"></i></a>
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
                                <option selected>Show 12 Per Page</option>
                                <option value="1">Show 12 Per Page</option>
                                <option value="2">Show 24 Per Page</option>
                                <option value="3">Show 15 Per Page</option>
                                <option value="3">Show 30 Per Page</option>
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
                            <h3 class="widget-title mb-4">Search</h3>
                            <div class="search-box">
                                <input type="text" class="form-control" placeholder="Search Our Store" aria-label="Search Our Store">
                                <button class="btn btn-dark btn-hover-primary" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="widget-list mb-10">
                            <h3 class="widget-title mb-4">Menu Categories</h3>
                            <!-- Widget Menu Start -->
                            <nav>
                                <ul class="category-menu mb-n3">
                                    <li class="menu-item-has-children pb-4">
                                        <a href="#">Women <i class="fa fa-angle-down"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="#">Natural Cosmetic</a></li>
                                            <li><a href="#">Woven Fashion Tops</a></li>
                                            <li><a href="#">Knitted Fabrics</a></li>
                                            <li><a href="#">Smart Watch</a></li>
                                            <li><a href="#">Handmade Bag</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children pb-4">
                                        <a href="#">Men <i class="fa fa-angle-down"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="#">Sunglasses</a></li>
                                            <li><a href="#">Belt and Wallet</a></li>
                                            <li><a href="#">Lather Shoe</a></li>
                                            <li><a href="#">Corporate Pant and Shirt</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children pb-4">
                                        <a href="#">Kids <i class="fa fa-angle-down"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="#">Kids Fashion</a></li>
                                            <li><a href="#">Kids Toy</a></li>
                                            <li><a href="#">Playground</a></li>
                                            <li><a href="#">Video Games</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children pb-4">
                                        <a href="#">Fashion <i class="fa fa-angle-down"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="#">World Famous Fashion</a></li>
                                            <li><a href="#">Champion Beauty</a></li>
                                            <li><a href="#">Fashion of Nation</a></li>
                                            <li><a href="#">Classic Looks</a></li>
                                            <li><a href="#">Eye Fashion</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children pb-4">
                                        <a href="#">Others <i class="fa fa-angle-down"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="#">Winter Collection</a></li>
                                            <li><a href="#">Sun Protection</a></li>
                                            <li><a href="#">Water Resistant</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                            <!-- Widget Menu End -->
                        </div>
                        <div class="widget-list mb-10">
                            <h3 class="widget-title mb-5">Price Filter</h3>
                            <!-- Widget Menu Start -->
                            <form action="#">
                                <div id="slider-range"></div>
                                <button class="slider-range-submit" type="submit">Filter</button>
                                <input class="slider-range-amount" type="text" name="text" id="amount" />
                            </form>
                            <!-- Widget Menu End -->
                        </div>
                        <div class="widget-list mb-10">
                            <h3 class="widget-title">Categories</h3>
                            <div class="sidebar-body">
                                <ul class="sidebar-list">
                                    <li><a href="#">All Product</a></li>
                                    <li><a href="#">Best Seller (5)</a></li>
                                    <li><a href="#">Featured (4)</a></li>
                                    <li><a href="#">New Products (6)</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="widget-list mb-10">
                            <h3 class="widget-title">Color</h3>
                            <div class="sidebar-body">
                                <ul class="checkbox-container categories-list">
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck12">
                                            <label class="custom-control-label" for="customCheck12">black (20)</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck13">
                                            <label class="custom-control-label" for="customCheck13">red (6)</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck14">
                                            <label class="custom-control-label" for="customCheck14">blue (8)</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck11">
                                            <label class="custom-control-label" for="customCheck11">green (5)</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck15">
                                            <label class="custom-control-label" for="customCheck15">pink (4)</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="widget-list mb-10">
                            <h3 class="widget-title mb-4">Tags</h3>
                            <div class="sidebar-body">
                                <ul class="tags mb-n2">
                                    <li><a href="#">Men</a></li>
                                    <li><a href="#">Women</a></li>
                                    <li><a href="#">Fashion</a></li>
                                    <li><a href="#">Watch</a></li>
                                    <li><a href="#">Handmade</a></li>
                                    <li><a href="#">Lather</a></li>
                                    <li><a href="#">Fabrics</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="widget-list">
                            <h3 class="widget-title mb-4">Recent Products</h3>
                            <div class="sidebar-body product-list-wrapper mb-n6">
                                <!-- Single Product List Start -->
                                <div class="single-product-list product-hover mb-6">
                                    <div class="thumb">
                                        <a href="single-product.html" class="image">
                                            <img class="first-image" src="assets/images/products/small-product/1.jpg" alt="Product" />
                                            <img class="second-image" src="assets/images/products/small-product/5.jpg" alt="Product" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="title"><a href="single-product.html">Brother Hoddies in Grey</a></h5>
                                        <span class="price">
                                            <span class="new">$38.00</span>
                                            <span class="old">$42.50</span>
                                        </span>
                                        <span class="ratings">
                                            <span class="rating-wrap">
                                                <span class="star" style="width: 100%"></span>
                                            </span>
                                            <span class="rating-num">(4)</span>
                                        </span>
                                    </div>
                                </div>
                                <!-- Single Product List End -->

                                <!-- Single Product List Start -->
                                <div class="single-product-list product-hover mb-6">
                                    <div class="thumb">
                                        <a href="single-product.html" class="image">
                                            <img class="first-image" src="assets/images/products/small-product/2.jpg" alt="Product" />
                                            <img class="second-image" src="assets/images/products/small-product/3.jpg" alt="Product" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="title"><a href="single-product.html">Basic Jogging Shorts</a></h5>
                                        <span class="price">
                                            <span class="new">$21.00</span>
                                            <span class="old">$22.50</span>
                                        </span>
                                        <span class="ratings">
                                            <span class="rating-wrap">
                                                <span class="star" style="width: 60%"></span>
                                            </span>
                                            <span class="rating-num">(4)</span>
                                        </span>
                                    </div>
                                </div>
                                <!-- Single Product List End -->

                                <!-- Single Product List Start -->
                                <div class="single-product-list product-hover mb-6">
                                    <div class="thumb">
                                        <a href="single-product.html" class="image">
                                            <img class="first-image" src="assets/images/products/small-product/4.jpg" alt="Product" />
                                            <img class="second-image" src="assets/images/products/small-product/10.jpg" alt="Product" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="title"><a href="single-product.html">Simple Woven Fabrics</a></h5>
                                        <span class="price">
                                            <span class="new">$86.00</span>
                                            <span class="old">$90.00</span>
                                        </span>
                                        <span class="ratings">
                                            <span class="rating-wrap">
                                                <span class="star" style="width: 80%"></span>
                                            </span>
                                            <span class="rating-num">(1)</span>
                                        </span>
                                    </div>
                                </div>
                                <!-- Single Product List End -->
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

<!-- Modal Start  -->
<div class="modalquickview modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button class="btn close" data-bs-dismiss="modal">×</button>
            <div class="row">
                <div class="col-md-6 col-12">

                    <!-- Product Details Image Start -->
                    <div class="modal-product-carousel">

                        <!-- Single Product Image Start -->
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <a class="swiper-slide" href="#">
                                    <img class="w-100" src="assets/images/products/large-size/1.jpg" alt="Product">
                                </a>
                                <a class="swiper-slide" href="#">
                                    <img class="w-100" src="assets/images/products/large-size/2.jpg" alt="Product">
                                </a>
                                <a class="swiper-slide" href="#">
                                    <img class="w-100" src="assets/images/products/large-size/3.jpg" alt="Product">
                                </a>
                                <a class="swiper-slide" href="#">
                                    <img class="w-100" src="assets/images/products/large-size/4.jpg" alt="Product">
                                </a>
                                <a class="swiper-slide" href="#">
                                    <img class="w-100" src="assets/images/products/large-size/5.jpg" alt="Product">
                                </a>
                                <a class="swiper-slide" href="#">
                                    <img class="w-100" src="assets/images/products/large-size/6.jpg" alt="Product">
                                </a>
                            </div>

                            <!-- Swiper Pagination Start -->
                            <!-- <div class="swiper-pagination d-md-none"></div> -->
                            <!-- Swiper Pagination End -->

                            <!-- Next Previous Button Start -->
                            <div class="swiper-product-button-next swiper-button-next"><i class="pe-7s-angle-right"></i></div>
                            <div class="swiper-product-button-prev swiper-button-prev"><i class="pe-7s-angle-left"></i></div>
                            <!-- Next Previous Button End -->
                        </div>
                        <!-- Single Product Image End -->

                    </div>
                    <!-- Product Details Image End -->

                </div>
                <div class="col-md-6 col-12 overflow-hidden position-relative">

                    <!-- Product Summery Start -->
                    <div class="product-summery">

                        <!-- Product Head Start -->
                        <div class="product-head mb-3">
                            <h2 class="product-title">Sample product</h2>
                        </div>
                        <!-- Product Head End -->

                        <!-- Price Box Start -->
                        <div class="price-box mb-2">
                            <span class="regular-price">$80.00</span>
                            <span class="old-price"><del>$90.00</del></span>
                        </div>
                        <!-- Price Box End -->

                        <!-- Rating Start -->
                        <span class="ratings justify-content-start">
                            <span class="rating-wrap">
                                <span class="star" style="width: 100%"></span>
                            </span>
                            <span class="rating-num">(4)</span>
                        </span>
                        <!-- Rating End -->

                        <!-- SKU Start -->
                        <div class="sku mb-3">
                            <span>SKU: 12345</span>
                        </div>
                        <!-- SKU End -->

                        <!-- Description Start -->
                        <p class="desc-content mb-5">I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.</p>
                        <!-- Description End -->

                        <!-- Product Meta Start -->
                        <div class="product-meta mb-3">
                            <!-- Product Size Start -->
                            <div class="product-size">
                                <span>Size :</span>
                                <a href="#"><strong>S</strong></a>
                                <a href="#"><strong>M</strong></a>
                                <a href="#"><strong>L</strong></a>
                                <a href="#"><strong>XL</strong></a>
                            </div>
                            <!-- Product Size End -->
                        </div>
                        <!-- Product Meta End -->

                        <!-- Product Color Variation Start -->
                        <div class="product-color-variation mb-3">
                            <button type="button" class="btn bg-danger"></button>
                            <button type="button" class="btn bg-primary"></button>
                            <button type="button" class="btn bg-dark"></button>
                            <button type="button" class="btn bg-success"></button>
                        </div>
                        <!-- Product Color Variation End -->

                        <!-- Product Meta Start -->
                        <div class="product-meta mb-5">
                            <!-- Product Metarial Start -->
                            <div class="product-metarial">
                                <span>Metarial :</span>
                                <a href="#"><strong>Metal</strong></a>
                                <a href="#"><strong>Resin</strong></a>
                                <a href="#"><strong>Lather</strong></a>
                                <a href="#"><strong>Polymer</strong></a>
                            </div>
                            <!-- Product Metarial End -->
                        </div>
                        <!-- Product Meta End -->

                        <!-- Quantity Start -->
                        <div class="quantity mb-5">
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" value="0" type="text">
                                <div class="dec qtybutton"></div>
                                <div class="inc qtybutton"></div>
                            </div>
                        </div>
                        <!-- Quantity End -->

                        <!-- Cart & Wishlist Button Start -->
                        <div class="cart-wishlist-btn pb-4 mb-n3">
                            <div class="add-to_cart mb-3">
                                <a class="btn btn-outline-dark btn-hover-primary" href="cart.html">Add to cart</a>
                            </div>
                            <div class="add-to-wishlist mb-3">
                                <a class="btn btn-outline-dark btn-hover-primary" href="wishlist.html">Add to Wishlist</a>
                            </div>
                        </div>
                        <!-- Cart & Wishlist Button End -->

                        <!-- Social Shear Start -->
                        <div class="social-share">
                            <span>Share :</span>
                            <a href="#"><i class="fa fa-facebook-square facebook-color"></i></a>
                            <a href="#"><i class="fa fa-twitter-square twitter-color"></i></a>
                            <a href="#"><i class="fa fa-linkedin-square linkedin-color"></i></a>
                            <a href="#"><i class="fa fa-pinterest-square pinterest-color"></i></a>
                        </div>
                        <!-- Social Shear End -->

                        <!-- Product Delivery Policy Start -->
                        <ul class="product-delivery-policy border-top pt-4 mt-4 border-bottom pb-4">
                            <li> <i class="fa fa-check-square"></i> <span>Security Policy (Edit With Customer Reassurance Module)</span></li>
                            <li><i class="fa fa-truck"></i><span>Delivery Policy (Edit With Customer Reassurance Module)</span></li>
                            <li><i class="fa fa-refresh"></i><span>Return Policy (Edit With Customer Reassurance Module)</span></li>
                        </ul>
                        <!-- Product Delivery Policy End -->

                    </div>
                    <!-- Product Summery End -->

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal End  -->
@endsection
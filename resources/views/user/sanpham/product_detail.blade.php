@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Single Product Style 2</h1>
                <ul>
                    <li>
                        <a href="index.html">Home </a>
                    </li>
                    <li class="active">Single Product Style 2</li>
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

        <div class="row">
            <div class="col-lg-6 offset-lg-0 col-md-8 offset-md-2 col-custom">

                <!-- Product Details Image Start -->
                <div class="product-details-img d-flex overflow-hidden flex-row">

                    <!-- Single Product Image Start -->
                    <div class="single-product-vertical-tab vertical-style-tab swiper-container gallery-top order-1 ms-0 me-2">
                        <div class="swiper-wrapper popup-gallery">
                            <a class="swiper-slide h-auto" href="assets/images/products/large-size/1.jpg">
                                <img class="w-100" src="assets/images/products/large-size/1.jpg" alt="Product">
                            </a>
                            <a class="swiper-slide h-auto" href="assets/images/products/large-size/2.jpg">
                                <img class="w-100" src="assets/images/products/large-size/2.jpg" alt="Product">
                            </a>
                            <a class="swiper-slide h-auto" href="assets/images/products/large-size/3.jpg">
                                <img class="w-100" src="assets/images/products/large-size/3.jpg" alt="Product">
                            </a>
                            <a class="swiper-slide h-auto" href="assets/images/products/large-size/4.jpg">
                                <img class="w-100" src="assets/images/products/large-size/4.jpg" alt="Product">
                            </a>
                            <a class="swiper-slide h-auto" href="assets/images/products/large-size/5.jpg">
                                <img class="w-100" src="assets/images/products/large-size/5.jpg" alt="Product">
                            </a>
                            <a class="swiper-slide h-auto" href="assets/images/products/large-size/6.jpg">
                                <img class="w-100" src="assets/images/products/large-size/6.jpg" alt="Product">
                            </a>
                        </div>

                        <!-- Swiper Pagination Start -->
                        <!-- <div class="swiper-pagination d-none"></div> -->
                        <!-- Swiper Pagination End -->

                        <!-- Next Previous Button Start -->
                        <!-- <div class="swiper-product-tab-next swiper-button-next"><i class="pe-7s-angle-right"></i></div>
                        <div class="swiper-product-tab-prev swiper-button-prev"><i class="pe-7s-angle-left"></i></div> -->
                        <!-- Next Previous Button End -->

                    </div>
                    <!-- Single Product Image End -->

                    <!-- Single Product Thumb Start -->
                    <div class="product-thumb-vertical vertical-style-thumb overflow-hidden swiper-container gallery-thumbs order-2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="assets/images/products/small-product/1.jpg" alt="Product">
                            </div>
                            <div class="swiper-slide">
                                <img src="assets/images/products/small-product/2.jpg" alt="Product">
                            </div>
                            <div class="swiper-slide">
                                <img src="assets/images/products/small-product/3.jpg" alt="Product">
                            </div>
                            <div class="swiper-slide">
                                <img src="assets/images/products/small-product/4.jpg" alt="Product">
                            </div>
                            <div class="swiper-slide">
                                <img src="assets/images/products/small-product/5.jpg" alt="Product">
                            </div>
                            <div class="swiper-slide">
                                <img src="assets/images/products/small-product/6.jpg" alt="Product">
                            </div>
                        </div>

                        <!-- Swiper Pagination Start -->
                        <!-- <div class="swiper-pagination d-none"></div> -->
                        <!-- Swiper Pagination End -->

                        <!-- Next Previous Button Start -->
                        <div class="swiper-button-vertical-next  swiper-button-next"><i class="pe-7s-angle-right"></i></div>
                        <div class="swiper-button-vertical-prev swiper-button-prev"><i class="pe-7s-angle-left"></i></div>
                        <!-- Next Previous Button End -->

                    </div>
                    <!-- Single Product Thumb End -->

                </div>
                <!-- Product Details Image End -->

            </div>
            <div class="col-lg-6 col-custom">

                <!-- Product Summery Start -->
                <div class="product-summery position-relative">

                    <!-- Product Head Start -->
                    <div class="product-head mb-3">
                        <h2 class="product-title">{{ $product->name }}</h2>
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

                    <div class="product-meta mb-3">
                        <!-- Product Size Start -->
                        <div class="product-size">
                            <span>Size:</span>
                            @foreach ($sizes as $size)
                                <a href="#" class="size-option" data-value="{{ $size->size_id }}">
                                    <strong>{{ $size->value }}</strong>
                                </a>
                            @endforeach
                        </div>
                        <!-- Product Size End -->

                        <!-- Product Color Start -->
                        <div class="product-color">
                            @foreach ($colors as $color)
                                <a href="#" class="color-option" data-value="{{ $color->color_id }}" 
                                style="background-color: {{ $color->value }}; 
                                        display: inline-block; 
                                        width: 25px; 
                                        height: 25px; 
                                        margin-right: 5px; 
                                        margin-top: 10px; 
                                        border-radius: 50%; 
                                        border: 2px solid #000;">
                                    <strong style="display: none;">{{ $color->value }}</strong>
                                </a>
                            @endforeach

                        </div>
                        <!-- Product Color End -->
                    </div>

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
                    <div class="cart-wishlist-btn mb-4">
                        <div class="add-to_cart">
                            <a class="btn btn-outline-dark btn-hover-primary" href="cart.html">Add to cart</a>
                        </div>
                        <div class="add-to-wishlist">
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

        <div class="row section-margin">
            <!-- Single Product Tab Start -->
            <div class="col-lg-12 col-custom single-product-tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-uppercase" id="home-tab" data-bs-toggle="tab" href="#connect-1" role="tab" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" id="profile-tab" data-bs-toggle="tab" href="#connect-2" role="tab" aria-selected="false">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" id="contact-tab" data-bs-toggle="tab" href="#connect-3" role="tab" aria-selected="false">Shipping Policy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" id="review-tab" data-bs-toggle="tab" href="#connect-4" role="tab" aria-selected="false">Size Chart</a>
                    </li>
                </ul>
                <div class="tab-content mb-text" id="myTabContent">
                    <div class="tab-pane fade show active" id="connect-1" role="tabpanel" aria-labelledby="home-tab">
                        <div class="desc-content border p-3">
                            <p class="mb-3">{{ $product->description }}</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="connect-2" role="tabpanel" aria-labelledby="profile-tab">
                        <!-- Start Single Content -->
                        <div class="product_tab_content  border p-3">
                            <!-- Start Single Review -->
                            <div class="single-review d-flex mb-4">

                                <!-- Review Thumb Start -->
                                <div class="review_thumb">
                                    <img alt="review images" src="assets/images/review/1.jpg">
                                </div>
                                <!-- Review Thumb End -->

                                <!-- Review Details Start -->
                                <div class="review_details">
                                    <div class="review_info mb-2">

                                        <!-- Rating Start -->
                                        <span class="ratings justify-content-start mb-3">
                                            <span class="rating-wrap">
                                                <span class="star" style="width: 100%"></span>
                                            </span>
                                            <span class="rating-num">(1)</span>
                                        </span>
                                        <!-- Rating End -->

                                        <!-- Review Title & Date Start -->
                                        <div class="review-title-date d-flex">
                                            <h5 class="title">Admin - </h5><span> January 19, 2023</span>
                                        </div>
                                        <!-- Review Title & Date End -->

                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin in viverra ex, vitae vestibulum arcu. Duis sollicitudin metus sed lorem commodo, eu dapibus libero interdum. Morbi convallis viverra erat, et aliquet orci congue vel. Integer in odio enim. Pellentesque in dignissim leo. Vivamus varius ex sit amet quam tincidunt iaculis.</p>
                                </div>
                                <!-- Review Details End -->

                            </div>
                            <!-- End Single Review -->

                            <!-- Rating Wrap Start -->
                            <div class="rating_wrap">
                                <h5 class="rating-title mb-2">Add a review </h5>
                                <p class="mb-2">Your email address will not be published. Required fields are marked *</p>
                                <h6 class="rating-sub-title mb-2">Your Rating</h6>

                                <!-- Rating Start -->
                                <span class="ratings justify-content-start mb-3">
                                    <span class="rating-wrap">
                                        <span class="star" style="width: 100%"></span>
                                    </span>
                                    <span class="rating-num">(2)</span>
                                </span>
                                <!-- Rating End -->

                            </div>
                            <!-- Rating Wrap End -->

                            <!-- Comments ans Replay Start -->
                            <div class="comments-area comments-reply-area">
                                <div class="row">
                                    <div class="col-lg-12 col-custom">

                                        <!-- Comment form Start -->
                                        <form action="#" class="comment-form-area">
                                            <div class="row comment-input">

                                                <!-- Input Name Start -->
                                                <div class="col-md-6 col-custom comment-form-author mb-3">
                                                    <label>Name <span class="required">*</span></label>
                                                    <input type="text" required="required" name="Name">
                                                </div>
                                                <!-- Input Name End -->

                                                <!-- Input Email Start -->
                                                <div class="col-md-6 col-custom comment-form-emai mb-3">
                                                    <label>Email <span class="required">*</span></label>
                                                    <input type="text" required="required" name="email">
                                                </div>
                                                <!-- Input Email End -->

                                            </div>
                                            <!-- Comment Texarea Start -->
                                            <div class="comment-form-comment mb-3">
                                                <label>Comment</label>
                                                <textarea class="comment-notes" required="required"></textarea>
                                            </div>
                                            <!-- Comment Texarea End -->

                                            <!-- Comment Submit Button Start -->
                                            <div class="comment-form-submit">
                                                <button class="btn btn-dark btn-hover-primary">Submit</button>
                                            </div>
                                            <!-- Comment Submit Button End -->

                                        </form>
                                        <!-- Comment form End -->

                                    </div>
                                </div>
                            </div>
                            <!-- Comments ans Replay End -->

                        </div>
                        <!-- End Single Content -->
                    </div>
                    <div class="tab-pane fade" id="connect-3" role="tabpanel" aria-labelledby="contact-tab">
                        <!-- Shipping Policy Start -->
                        <div class="shipping-policy mb-n2">
                            <h4 class="title-3 mb-4">Shipping policy for our store</h4>
                            <p class="desc-content mb-2">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate</p>
                            <ul class="policy-list mb-2">
                                <li>1-2 business days (Typically by end of day)</li>
                                <li><a href="#">30 days money back guaranty</a></li>
                                <li>24/7 live support</li>
                                <li>odio dignissim qui blandit praesent</li>
                                <li>luptatum zzril delenit augue duis dolore</li>
                                <li>te feugait nulla facilisi.</li>
                            </ul>
                            <p class="desc-content mb-2">Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum</p>
                            <p class="desc-content mb-2">claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per</p>
                            <p class="desc-content mb-2">seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
                        </div>
                        <!-- Shipping Policy End -->
                    </div>
                    <div class="tab-pane fade" id="connect-4" role="tabpanel" aria-labelledby="review-tab">
                        <div class="size-tab table-responsive-lg">
                            <h4 class="title-3 mb-4">Size Chart</h4>
                            <table class="table border mb-0">
                                <tbody>
                                    <tr>
                                        <td class="cun-name"><span>UK</span></td>
                                        <td>18</td>
                                        <td>20</td>
                                        <td>22</td>
                                        <td>24</td>
                                        <td>26</td>
                                    </tr>
                                    <tr>
                                        <td class="cun-name"><span>European</span></td>
                                        <td>46</td>
                                        <td>48</td>
                                        <td>50</td>
                                        <td>52</td>
                                        <td>54</td>
                                    </tr>
                                    <tr>
                                        <td class="cun-name"><span>usa</span></td>
                                        <td>14</td>
                                        <td>16</td>
                                        <td>18</td>
                                        <td>20</td>
                                        <td>22</td>
                                    </tr>
                                    <tr>
                                        <td class="cun-name"><span>Australia</span></td>
                                        <td>28</td>
                                        <td>10</td>
                                        <td>12</td>
                                        <td>14</td>
                                        <td>16</td>
                                    </tr>
                                    <tr>
                                        <td class="cun-name"><span>Canada</span></td>
                                        <td>24</td>
                                        <td>18</td>
                                        <td>14</td>
                                        <td>42</td>
                                        <td>36</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single Product Tab End -->
        </div>

        <!-- Products Start -->
        <div class="row">

            <div class="col-12">
                <!-- Section Title Start -->
                <div class="section-title aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                    <h2 class="title pb-3">You Might Also Like</h2>
                    <span></span>
                    <div class="title-border-bottom"></div>
                </div>
                <!-- Section Title End -->
            </div>
            <div class="col">
                <div class="product-carousel">

                    <div class="swiper-container">
                        <div class="swiper-wrapper">

                            <!-- Product Start -->
                            <div class="swiper-slide product-wrapper">

                                <!-- Single Product Start -->
                                <div class="product product-border-left" data-aos="fade-up" data-aos-delay="300">
                                    <div class="thumb">
                                        <a href="single-product.html" class="image">
                                            <img class="first-image" src="assets/images/products/medium-size/1.jpg" alt="Product" />
                                            <img class="second-image" src="assets/images/products/medium-size/5.jpg" alt="Product" />
                                        </a>
                                        <div class="actions">
                                            <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                            <a href="#" class="action quickview" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                            <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4 class="sub-title"><a href="single-product.html">Studio Design</a></h4>
                                        <h5 class="title"><a href="single-product.html">Brother Hoddies in Grey</a></h5>
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
                                        <button class="btn btn-sm btn-outline-dark btn-hover-primary">Add To Cart</button>
                                    </div>
                                </div>
                                <!-- Single Product End -->

                            </div>
                            <!-- Product End -->

                            <!-- Product Start -->
                            <div class="swiper-slide product-wrapper">

                                <!-- Single Product Start -->
                                <div class="product product-border-left" data-aos="fade-up" data-aos-delay="400">
                                    <div class="thumb">
                                        <a href="single-product.html" class="image">
                                            <img class="first-image" src="assets/images/products/medium-size/4.jpg" alt="Product" />
                                            <img class="second-image" src="assets/images/products/medium-size/10.jpg" alt="Product" />
                                        </a>
                                        <span class="badges">
                                            <span class="sale">New</span>
                                        </span>
                                        <div class="actions">
                                            <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                            <a href="#" class="action quickview" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                            <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4 class="sub-title"><a href="single-product.html">Studio Design</a></h4>
                                        <h5 class="title"><a href="single-product.html">Simple Woven Fabrics</a></h5>
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
                                        <button class="btn btn-sm btn-outline-dark btn-hover-primary">Add To Cart</button>
                                    </div>
                                </div>
                                <!-- Single Product End -->

                            </div>
                            <!-- Product End -->

                            <!-- Product Start -->
                            <div class="swiper-slide product-wrapper">

                                <!-- Single Product Start -->
                                <div class="product product-border-left" data-aos="fade-up" data-aos-delay="500">
                                    <div class="thumb">
                                        <a href="single-product.html" class="image">
                                            <img class="first-image" src="assets/images/products/medium-size/7.jpg" alt="Product" />
                                            <img class="second-image" src="assets/images/products/medium-size/9.jpg" alt="Product" />
                                        </a>
                                        <div class="actions">
                                            <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                            <a href="#" class="action quickview" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                            <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4 class="sub-title"><a href="single-product.html">Lather Design</a></h4>
                                        <h5 class="title"><a href="single-product.html">Basic Lather Sneaker</a></h5>
                                        <span class="ratings">
                                            <span class="rating-wrap">
                                                <span class="star" style="width: 100%"></span>
                                            </span>
                                            <span class="rating-num">(12)</span>
                                        </span>
                                        <span class="price">
                                            <span class="new">$65.00</span>
                                        </span>
                                        <button class="btn btn-sm btn-outline-dark btn-hover-primary">Add To Cart</button>
                                    </div>
                                </div>
                                <!-- Single Product End -->

                            </div>
                            <!-- Product End -->

                            <!-- Product Start -->
                            <div class="swiper-slide product-wrapper">

                                <!-- Single Product Start -->
                                <div class="product product-border-left" data-aos="fade-up" data-aos-delay="600">
                                    <div class="thumb">
                                        <a href="single-product.html" class="image">
                                            <img class="first-image" src="assets/images/products/medium-size/11.jpg" alt="Product" />
                                            <img class="second-image" src="assets/images/products/medium-size/10.jpg" alt="Product" />
                                        </a>
                                        <div class="actions">
                                            <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                            <a href="#" class="action quickview" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                            <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4 class="sub-title"><a href="single-product.html">Design Source</a></h4>
                                        <h5 class="title"><a href="single-product.html">Handmade Shoulder Bag</a></h5>
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
                                        <button class="btn btn-sm btn-outline-dark btn-hover-primary">Add To Cart</button>
                                    </div>
                                </div>
                                <!-- Single Product End -->

                            </div>
                            <!-- Product End -->

                            <!-- Product Start -->
                            <div class="swiper-slide product-wrapper">

                                <!-- Single Product Start -->
                                <div class="product product-border-left" data-aos="fade-up" data-aos-delay="700">
                                    <div class="thumb">
                                        <a href="single-product.html" class="image">
                                            <img class="first-image" src="assets/images/products/medium-size/7.jpg" alt="Product" />
                                            <img class="second-image" src="assets/images/products/medium-size/9.jpg" alt="Product" />
                                        </a>
                                        <div class="actions">
                                            <a href="#" class="action wishlist"><i class="pe-7s-like"></i></a>
                                            <a href="#" class="action quickview" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                                            <a href="#" class="action compare"><i class="pe-7s-shuffle"></i></a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4 class="sub-title"><a href="single-product.html">Lather Design</a></h4>
                                        <h5 class="title"><a href="single-product.html">Basic Lather Sneaker</a></h5>
                                        <span class="ratings">
                                            <span class="rating-wrap">
                                                <span class="star" style="width: 100%"></span>
                                            </span>
                                            <span class="rating-num">(12)</span>
                                        </span>
                                        <span class="price">
                                            <span class="new">$65.00</span>
                                        </span>
                                        <button class="btn btn-sm btn-outline-dark btn-hover-primary">Add To Cart</button>
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
                        <div class="swiper-product-button-next swiper-button-next swiper-button-white d-md-flex d-none"><i class="pe-7s-angle-right"></i></div>
                        <div class="swiper-product-button-prev swiper-button-prev swiper-button-white d-md-flex d-none"><i class="pe-7s-angle-left"></i></div>
                        <!-- Next Previous Button End -->

                    </div>

                </div>
            </div>

        </div>
        <!-- Products End -->

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
                            <h2 class="product-title">{{ $product->name }}</h2>
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
                                @foreach ($product->productDetails as $detail)đsdsad
                                <option value="{{ $detail->sizes_id }}">{{ $detail->size->value }}</option>
                                @endforeach
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

@section('js')
<script>
    document.querySelectorAll('.size-option').forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
            const sizeId = item.dataset.value; // Lấy giá trị size_id từ data-value
            console.log("Selected Size ID:", sizeId);
            // Thực hiện hành động bạn muốn (cập nhật giá trị, gửi AJAX, v.v.)
        });
    });

    document.querySelectorAll('.color-option').forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
            const colorId = item.dataset.value; // Lấy giá trị color_id từ data-value
            console.log("Selected Color ID:", colorId);
            // Thực hiện hành động bạn muốn (cập nhật giá trị, gửi AJAX, v.v.)
        });
    });
</script>
@endsection


@extends('layouts.home')
@section('css')
<style>
.unavailable {
    opacity: 0.5;
    /* Làm mờ màu không khả dụng */
    pointer-events: none;
    /* Ngăn chặn nhấp chuột vào các tùy chọn không khả dụng */
    text-decoration: line-through;

    /* Gạch chéo */
    .size-option.active {
        border: 2px solid #000;
        /* Đường viền đậm cho tùy chọn kích thước đã chọn */
    }

    .color-option.active {
        border: 2px solid #000;
        /* Đường viền đậm cho tùy chọn màu sắc đã chọn */
    }
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb">
        <a href="http://datn_wd13.test/"><i class="fa fa-home"></i> Trang Chủ</a>
        <span class="breadcrumb-separator"> > </span>
        <span><a href="http://datn_wd13.test/shop">Cửa hàng</a></span>
        <span class="breadcrumb-separator"> > </span>
        <span><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></span>
    </div>
    <!-- Breadcrumb Area End -->
</div>
<!-- Breadcrumb Section End -->

<!-- Shop Section Start -->
<div class="section section-margin">
    <div class="container ">

        <div class="row">
            <div class="col-lg-6 offset-lg-0 col-md-8 offset-md-2 col-custom">

                <!-- Product Details Image Start -->
                <div class="product-details-img d-flex overflow-hidden flex-row">

                    <!-- Single Product Image Start -->
                    <div
                        class="single-product-vertical-tab vertical-style-tab swiper-container gallery-top order-1 ms-0 me-2">
                        <div class="swiper-wrapper popup-gallery">
                            <!-- Ảnh chính: Ban đầu hiển thị ảnh đại diện -->
                            <a id="main-image-link" class="swiper-slide h-auto"
                                href="{{ url('storage/' . $product->avata) }}">
                                <img id="main-image" src="{{ url('storage/' . $product->avata) }}" alt="Product">
                            </a>

                            <!-- Danh sách hình ảnh phụ từ productImages -->
                            @foreach($product->productImages as $key => $image)
                            @if($key > 0)
                            <a class="swiper-slide h-auto" href="{{ url('storage/' . $image->image_path) }}">
                                <img class="w-100 h-100" src="{{ url('storage/' . $image->image_path) }}" alt="Product">
                            </a>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <!-- Single Product Image End -->

                    <!-- Single Product Thumb Start -->
                    <div
                        class="product-thumb-vertical vertical-style-thumb overflow-hidden swiper-container gallery-thumbs order-2">
                        <div class="swiper-wrapper">
                            @foreach($product->productImages as $image)
                            <div class="swiper-slide">
                                <img src="{{ url('storage/' . $image->image_path) }}" alt="Product"
                                    style="max-height: auto;">

                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-vertical-next  swiper-button-next"><i class="pe-7s-angle-right"></i>
                        </div>
                        <div class="swiper-button-vertical-prev swiper-button-prev"><i class="pe-7s-angle-left"></i>
                        </div>
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
                        <!-- Kiểm tra xem sản phẩm có giá khuyến mãi (discount_price) không -->
                        @if($product->discount_price && $product->price)
                        <span class="regular-price" id="current-price">
                            {{ number_format($product->discount_price, 0, '', '.') }} đ
                        </span>
                        <span class="old-price">
                            <del>{{ number_format($product->price, 0, '', '.') }} ₫</del>
                        </span>
                        @elseif($product->price)
                        <!-- Trường hợp không có giá khuyến mãi, chỉ hiển thị giá gốc -->
                        <span class="regular-price" id="current-price">
                            {{ number_format($product->price, 0, '', '.') }} đ
                        </span>

                        @endif
                    </div>
                    <!-- Price Box End -->


                    <!-- SKU Start -->
                    <div class="sku mb-3">
                        <span id="current-sku">SKU: {{ $product->productDetails->first()->product_code }}</span>
                    </div>

                    <!-- SKU End -->

                    <!-- Stock Quantity Start -->
                    <div class="stock-quantity mb-3">
                        <span id="current-stock">
                            Số lượng: <span id="stock-value">{{ $product->productDetails->sum('quantity') }}</span>
                        </span>
                    </div>

                    <!-- Stock Quantity End -->

                    <!-- Short Description Start -->
                    <p class="short-desc mb-3">{{ $product->short_description }}</p>
                    <!-- Short Description End -->

                    <div class="product-meta mb-3">
                        <!-- Product Size Start -->
                        <div class="product-size">
                            <span class="mt-3">Size: <span id="selected-size">Chưa chọn</span> </span></br>
                            @foreach ($sizes as $size)
                            <a href="#" class="size-option  " data-value="{{ $size->size_id }}">
                                <strong
                                    class=" btn btn border border-dark mt-3 mb-3 px-2 py-2">{{ $size->value }}</strong>
                            </a>
                            @endforeach
                        </div>
                        <!-- Product Size End -->

                        <!-- Product Color Start -->
                        <div class="product-color">
                            <span>Color: <span id="selected-color-text">Chưa chọn</span></span></br>
                            @foreach ($colors as $color)
                            <a href="#" class="color-option mb-3" data-value="{{ $color->color_id }}"
                                data-color-name="{{ $color->value }}"
                                style="background-color: {{ $color->value }}; display: inline-block; width: 30px; height: 30px; margin-right: 5px; margin-top: 10px; border-radius: 50%; border: 2px solid #000;">
                            </a>
                            @endforeach
                        </div>
                        <!-- Product Color End -->
                    </div>
                    <!-- Quantity Start -->
                    <div class="quantity mb-5">
                        <div class="cart-plus-minus">
                            <input class="cart-plus-minus-box" id="product-quantity" name="quantity" value="1" min="1"
                                max="{{ $product->productDetails->first()->quantity }}" required>
                            <div class="dec qtybutton"><i class="fa fa-minus"></i></div>
                            <div class="inc qtybutton"><i class="fa fa-plus"></i></div>
                        </div>
                    </div>
                    <!-- Quantity End -->

                    <!-- Cart & Wishlist Button Start -->
                    <div class="cart-wishlist-btn mb-4">
                        <div class="add-to_cart">
                            <form id="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="products_id" value="{{ $product->id }}">
                                <input type="hidden" name="size" value="" id="selected-size">
                                <input type="hidden" name="color" value="" id="selected-color">
                                <input type="hidden" name="quantity" id="product-quantity-hidden" value="1">
                                <button type="button" class="btn btn-outline-dark btn-hover-primary"
                                    id="add-to-cart-button">Thêm vào giỏ</button>
                            </form>
                        </div>
                        <div class="add-to-wishlist">
                            <form method="POST" action="{{ route('muangay') }}" id="muangay-form">
                                @csrf
                                <input type="hidden" name="products_id" value="{{ $product->id }}">
                                <input type="hidden" name="size" value="" id="muangay-size">
                                <input type="hidden" name="color" value="" id="mungay-color">
                                <input type="hidden" name="quantity" id="muangay-quantity" value="">
                                <button type="submit" class="btn btn-outline-dark btn-hover-primary" id="add-to-buy">Mua
                                    Ngay</button>
                            </form>
                        </div>
                    </div>
                    <!-- Cart & Wishlist Button End -->

                    <!-- Social Share Start -->
                    <div class="social-share">
                        <span>Share :</span>
                        <a href="#"><i class="fa fa-facebook-square facebook-color"></i></a>
                        <a href="#"><i class="fa fa-twitter-square twitter-color"></i></a>
                        <a href="#"><i class="fa fa-linkedin-square linkedin-color"></i></a>
                        <a href="#"><i class="fa fa-pinterest-square pinterest-color"></i></a>
                    </div>
                    <!-- Social Share End -->

                    <!-- Product Delivery Policy Start -->
                    <ul class="product-delivery-policy border-top pt-4 mt-4 border-bottom pb-4">
                        <li><i class="fa fa-check-square"></i><span>Chính sách bảo mật</span></li>
                        <li><i class="fa fa-truck"></i><span>Chính sách giao hàng</span></li>
                        <li><i class="fa fa-refresh"></i><span>Chính sách hoàn trả</span></li>
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
                        <a class="nav-link active text-uppercase" id="home-tab" data-bs-toggle="tab" href="#connect-1"
                            role="tab" aria-selected="true">Mô tả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" id="profile-tab" data-bs-toggle="tab" href="#connect-2"
                            role="tab" aria-selected="false">Chính sách giao hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" id="review-tab" data-bs-toggle="tab" href="#connect-3"
                            role="tab" aria-selected="false">Bảng size</a>
                    </li>
                </ul>
                <div class="tab-content mb-text" id="myTabContent">
                    <div class="tab-pane fade show active" id="connect-1" role="tabpanel" aria-labelledby="home-tab">
                        <div class="desc-content border p-3">
                            <p class="mb-3">{!! $product->description !!}</p>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="connect-2" role="tabpanel" aria-labelledby="profile-tab">
                        <!-- Shipping Policy Start -->
                        <div class="shipping-policy mb-n2">
                            <h4 class="title-3 mb-4">Chính sách vận chuyển của chúng tôi</h4>
                            <p class="desc-content mb-2">Tại POLLY STORE,
                                chúng tôi cam kết mang đến trải nghiệm mua sắm thuận tiện và nhanh chóng cho quý khách
                                hàng.
                                Chính sách vận chuyển của chúng tôi được thiết kế để đảm bảo sự hài lòng và tin tưởng.
                            </p>
                            <p class="desc-content mb-2">Các điều khoản vận chuyển:</p>
                            <ul class="policy-list mb-2">
                                <li>Thời gian giao hàng: 1-2 ngày làm việc (Thông thường là trước cuối ngày)</li>
                                <li><a href="#">Đảm bảo hoàn tiền: 30 ngày kể từ ngày mua</a></li>
                                <li>Hỗ trợ khách hàng: 24/7 qua điện thoại và email</li>
                                <li>Miễn phí vận chuyển cho đơn hàng trên 1.000.000đ</li>
                                <li>Theo dõi đơn hàng trực tuyến</li>
                                <li>Đóng gói cẩn thận, chuyên nghiệp</li>
                            </ul>
                            <p class="desc-content mb-2">Chúng tôi luôn nỗ lực để mang đến dịch vụ tốt nhất,
                                đảm bảo sản phẩm đến tay khách hàng an toàn và nhanh chóng.</p>
                            <p class="desc-content mb-2">Để biết thêm chi tiết, vui lòng liên hệ bộ phận chăm sóc khách
                                hàng của chúng tôi.</p>
                        </div>
                        <!-- Shipping Policy End -->
                    </div>

                    <div class="tab-pane fade" id="connect-3" role="tabpanel" aria-labelledby="review-tab">
                        <div class="size-tab table-responsive-lg">
                            <h4 class="title-3 mb-4">Bản size</h4>
                            <table class="table border mb-0">
                                <tbody>
                                    <tr>
                                        <td class="cun-name"><span>VN</span></td>
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
            </div><br><br><br>
            <!-- Single Product Tab End -->

            <!-- Start Comment Section (Moved) -->
            <div class="col-lg-12 col-custom single-product-comment">
                @auth
                <br><br><br>
                <div class="review-form mb-4">
                    <!-- Review Form Card -->
                    <h4>BÌNH LUẬN</h4>
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white py-2">
                            <h6 class="mb-0" style="color: white">Đánh giá sản phẩm</h6>
                        </div>

                        <div class="card-body bg-light">
                            <form method="POST" action="{{ route('product.comment', $product->slug) }}" class="px-2">
                                @csrf
                                <div class="mb-3">
                                    <label for="description" class="form-label small text-muted">Nội dung đánh
                                        giá</label>
                                    <textarea name="description" class="form-control form-control-sm border-dark"
                                        rows="3" required placeholder="Nhập đánh giá của bạn về sản phẩm..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-dark btn-sm">
                                    Gửi đánh giá
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Comments List -->
                <div class="reviews-list">
                    <h6 class="text-muted mb-3">Các đánh giá khác</h6>
                    @if ($comments->isNotEmpty())
                    @foreach ($comments as $comment)
                    <div class="card mb-2 shadow-sm border-0">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small fw-bold text-dark">{{ $comment->user->name }}</span>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            <hr class="my-2">
                            <p class="card-text small mb-0">{{ $comment->description }}</p>
                        </div>
                    </div>
                    @endforeach
                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-4">
                        {{ $comments->links() }}
                    </div>
                    @else
                    <div class="alert alert-dark py-2 small">
                        Chưa có đánh giá nào.
                    </div>
                    @endif
                </div>
            </div>

            <!-- End Comment Section -->
        </div>


        <!-- Products Start -->
        <div class="row">

            <div class="col-12">
                <!-- Section Title Start -->
                <div class="section-title aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                    <h2 class="title pb-3">Có thể bạn sẽ thích</h2>
                    <span></span>
                    <div class="title-border-bottom"></div>
                </div>
                <!-- Section Title End -->
            </div>
            <div class="col">
                <div class="product-carousel">

                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($products as $item)
                            <!-- Product Start -->
                            <div class="swiper-slide product-wrapper">

                                <!-- Single Product Start -->
                                <div class="product product-border-left" data-aos="fade-up" data-aos-delay="300">
                                    <div class="thumb">
                                        <a href="{{ route('product.show', $item->slug) }}" class="image">
                                            <img class="image w-100 h-100" src="{{ url('storage/' . $item->avata) }}"
                                                alt="Product" />
                                        </a>
                                        
                                    </div>
                                    <div class="content">
                                        <h4 class="sub-title">{{ $item->categories->name }}</h4>
                                        <h5 class="title"><a
                                                href="{{ route('product.show', $item->slug) }}">{{ $item->name }}</a>
                                        </h5>

                                        <span class="price">
                                            @if ($item->discount_price)
                                            <span class="new">{{ number_format($item->discount_price, 0, '', '.') }}
                                                ₫</span>&nbsp;&nbsp;
                                            <span class="old">{{ number_format($item->price, 0, '', '.') }} ₫</span>
                                            @else
                                            <span class="new">{{ number_format($item->price, 0, '', '.') }} ₫</span>
                                            @endif
                                        </span>
                                        <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-outline-dark btn-hover-primary"
                                        title="Add To Cart"><i class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết</a>
                                    </div>
                                </div>
                                <!-- Single Product End -->

                            </div>
                            <!-- Product End -->
                            @endforeach

                        </div>

                        <!-- Swiper Pagination Start -->
                        <div class="swiper-pagination d-md-none"></div>
                        <!-- Swiper Pagination End -->

                        <!-- Next Previous Button Start -->
                        <div class="swiper-product-button-next swiper-button-next swiper-button-white d-md-flex d-none">
                            <i class="pe-7s-angle-right"></i>
                        </div>
                        <div class="swiper-product-button-prev swiper-button-prev swiper-button-white d-md-flex d-none">
                            <i class="pe-7s-angle-left"></i>
                        </div>
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
<!-- Modal End  -->
@endsection

@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    var selectedSize = null;
    var selectedColor = null;
    var variantDetails = @json($productDetails); // Dữ liệu về các biến thể sản phẩm

    // Hiển thị tổng số lượng ban đầu
    const totalStock = variantDetails.reduce((sum, variant) => sum + variant.quantity, 0);
    $('#current-stock').text(`Số lượng: ${totalStock}`);

    // Khi người dùng chọn kích thước
    $('.size-option').on('click', function(event) {
        event.preventDefault();
        selectedSize = $(this).data('value');

        // Hiển thị size đã chọn
        $('#selected-size').text($(this).text());

        $('.size-option').removeClass('active');
        $(this).addClass('active');
        updateAvailability(); // Cập nhật khả dụng của màu và size
        updateVariantDetails(); // Cập nhật thông tin biến thể
    });

    // Khi người dùng chọn màu sắc
    $('.color-option').on('click', function(event) {
        event.preventDefault();
        if ($(this).hasClass('unavailable')) {
            return; // Không cho phép chọn màu không khả dụng
        }
        selectedColor = $(this).data('value');
        $('#selected-color').val(selectedColor);
        const colorName = $(this).data('color-name'); // Lấy tên màu từ data attribute
        $('#selected-color-text').text(colorName); // Cập nhật tên màu đã chọn
        $('.color-option').removeClass('active');
        $(this).addClass('active');
        updateAvailability(); // Cập nhật khả dụng của màu và size
        updateVariantDetails(); // Cập nhật thông tin biến thể
    });

    // Hàm kiểm tra khả dụng của một biến thể
    function isVariantAvailable(sizeId, colorId) {
        return variantDetails.some(v => v.size_id == sizeId && v.color_id == colorId && v.quantity > 0);
    }

    // Cập nhật khả dụng của các tùy chọn
    function updateAvailability() {
        // Cập nhật khả dụng của màu
        $('.color-option').each(function() {
            const colorId = $(this).data('value');
            const isAvailable = variantDetails.some(v => v.color_id == colorId && (!selectedSize || v
                .size_id == selectedSize) && v.quantity > 0);
            toggleAvailability($(this), isAvailable);
        });

        // Cập nhật khả dụng của size
        $('.size-option').each(function() {
            const sizeId = $(this).data('value');
            const isAvailable = variantDetails.some(v => v.size_id == sizeId && (!selectedColor || v
                .color_id == selectedColor) && v.quantity > 0);
            toggleAvailability($(this), isAvailable);
        });
    }

    // Hàm thay đổi trạng thái khả dụng
    function toggleAvailability(element, isAvailable) {
        if (isAvailable) {
            element.removeClass('unavailable').css({
                opacity: 1,
                textDecoration: 'none'
            });
        } else {
            element.addClass('unavailable').css({
                opacity: 0.5,
                textDecoration: 'line-through'
            });
        }
    }

    // Cập nhật thông tin chi tiết biến thể (giá, SKU, số lượng tồn kho)
    function updateVariantDetails() {
        if (selectedColor && selectedSize) {
            // Nếu đã chọn cả màu và size
            const variant = variantDetails.find(v => v.color_id == selectedColor && v.size_id == selectedSize);
            if (variant) {
                $('#current-price').text(new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(variant.discount_price));
                $('#current-sku').text(`SKU: ${variant.product_code}`);
                $('#current-stock').text(`Số lượng: ${variant.quantity}`);
                $('#product-quantity').attr('max', variant.quantity);

                if (variant.image) {
                    $('#main-image').attr('src', `/storage/${variant.image}`);
                    $('#main-image-link').attr('href', `/storage/${variant.image}`);
                }
            } else {
                // Nếu không tìm thấy biến thể
                $('#current-stock').text('Không khả dụng');
            }
        } else {
            // Nếu chưa chọn đủ biến thể, hiển thị tổng số lượng
            const totalStock = variantDetails.reduce((sum, variant) => sum + variant.quantity, 0);
            $('#current-stock').text(`Số lượng: ${totalStock}`);
        }
    }

    // Điều chỉnh số lượng sản phẩm
    $('.inc.qtybutton').on('click', function() {
        var currentQuantity = parseInt($('#product-quantity').val());
        var maxQuantity = parseInt($('#product-quantity').attr('max'));

        // Kiểm tra nếu số lượng hiện tại đã đạt số lượng tối đa
        if (currentQuantity < maxQuantity) {
            $('#product-quantity').val(currentQuantity + 1);
        } else {
            Swal.fire({
                title: 'Lỗi',
                text: 'Số lượng sản phẩm không thể vượt quá số lượng tồn kho.',
                icon: 'error'
            });
        }
    });

    $('.dec.qtybutton').on('click', function() {
        var currentQuantity = parseInt($('#product-quantity').val());
        if (currentQuantity > 1) {
            $('#product-quantity').val(currentQuantity - 1);
        }
    });


    $('#product-quantity').on('input', function() {
        let quantity = parseInt(this.value) || 1;
        const maxQuantity = parseInt($(this).attr('max'));
        this.value = Math.min(Math.max(quantity, 1), maxQuantity);
    });
    // Thêm sản phẩm vào giỏ hàng
    $('#add-to-cart-button').on('click', function(event) {
        event.preventDefault();
        if (!selectedSize || !selectedColor) {
            Swal.fire({
                title: 'Thông báo',
                text: 'Vui lòng chọn cả kích thước và màu sắc trước khi thêm vào giỏ hàng.',
                icon: 'warning'
            });
            return;
        }

        // Lấy số lượng tối đa của biến thể đã chọn
        const maxQuantityForSelectedVariant = variantDetails.find(v => v.size_id == selectedSize && v.color_id == selectedColor)?.quantity || 0;
        const selectedQuantity = parseInt($('#product-quantity').val());

        // Kiểm tra số lượng chọn có vượt quá số lượng tồn kho của biến thể không
        if (selectedQuantity > maxQuantityForSelectedVariant) {
            Swal.fire({
                title: 'Lỗi',
                text: `Số lượng bạn chọn vượt quá số lượng tồn kho của biến thể này. Số lượng tối đa là ${maxQuantityForSelectedVariant}.`,
                icon: 'error'
            });
            return;
        }

        $(this).prop('disabled', true).text('Đang thêm...');

        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                products_id: $('input[name="products_id"]').val(),
                quantity: selectedQuantity,
                size: selectedSize,
                color: selectedColor,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('.total-amount').text(response.total_price + ' $');
                    updateCartCount();
                    Swal.fire({
                        title: 'Thành công',
                        text: response.message,
                        icon: 'success'
                    });
                }
            },
            error: function(xhr) {
                var errorMessage = xhr.responseJSON.message ||
                    'Có lỗi xảy ra, vui lòng thử lại.';
                Swal.fire({
                    title: 'Lỗi',
                    text: errorMessage,
                    icon: 'error'
                });
            },
            complete: function() {
                $('#add-to-cart-button').prop('disabled', false).text('Thêm vào giỏ hàng');
            }
        });
    });


    // Hàm để cập nhật số lượng sản phẩm trong giỏ hàng
    function updateCartCount() {
        $.ajax({
            url: '{{ route("cart.count") }}',
            method: 'GET',
            success: function(data) {
                $('.header-action-num').text(data.count);
            },
            error: function(xhr) {
                console.error('Có lỗi xảy ra khi cập nhật số lượng giỏ hàng.', xhr);
            }
        });
    }
});
</script>
<script>
$(document).ready(function() {
    var selectedSize = null;
    var selectedColor = null;
    var variantDetails = @json($productDetails); // Dữ liệu biến thể sản phẩm

    // Hiển thị tổng số lượng ban đầu
    const totalStock = variantDetails.reduce((sum, variant) => sum + variant.quantity, 0);
    $('#current-stock').text(`Số lượng: ${totalStock}`);

    // Khi người dùng chọn kích thước
    $('.size-option').on('click', function(event) {
        event.preventDefault();
        selectedSize = $(this).data('value');
        $('#selected-size').val(selectedSize);
        $('#muangay-size').val(selectedSize); // Cập nhật hidden input của form "Mua ngay"

        $('#selected-size-text').text($(this).text());
        $('.size-option').removeClass('active');
        $(this).addClass('active');
        updateAvailability();
        updateVariantDetails();
    });

    // Khi người dùng chọn màu sắc
    $('.color-option').on('click', function(event) {
        event.preventDefault();
        if ($(this).hasClass('unavailable')) {
            return;
        }
        selectedColor = $(this).data('value');
        $('#selected-color').val(selectedColor);
        $('#mungay-color').val(selectedColor); // Cập nhật hidden input của form "Mua ngay"

        const colorName = $(this).data('color-name');
        $('#selected-color-text').text(colorName);
        $('.color-option').removeClass('active');
        $(this).addClass('active');
        updateAvailability();
        updateVariantDetails();
    });

    // Kiểm tra khả dụng của biến thể
    function isVariantAvailable(sizeId, colorId) {
        return variantDetails.some(v => v.size_id == sizeId && v.color_id == colorId && v.quantity > 0);
    }

    // Cập nhật khả dụng của các tùy chọn
    function updateAvailability() {
        $('.color-option').each(function() {
            const colorId = $(this).data('value');
            const isAvailable = variantDetails.some(v => v.color_id == colorId && (!selectedSize || v
                .size_id == selectedSize) && v.quantity > 0);
            toggleAvailability($(this), isAvailable);
        });

        $('.size-option').each(function() {
            const sizeId = $(this).data('value');
            const isAvailable = variantDetails.some(v => v.size_id == sizeId && (!selectedColor || v
                .color_id == selectedColor) && v.quantity > 0);
            toggleAvailability($(this), isAvailable);
        });
    }

    // Thay đổi trạng thái khả dụng
    function toggleAvailability(element, isAvailable) {
        if (isAvailable) {
            element.removeClass('unavailable').css({
                opacity: 1,
                textDecoration: 'none'
            });
        } else {
            element.addClass('unavailable').css({
                opacity: 0.5,
                textDecoration: 'line-through'
            });
        }
    }

    // Cập nhật thông tin biến thể
    function updateVariantDetails() {
        if (selectedColor && selectedSize) {
            const variant = variantDetails.find(v => v.color_id == selectedColor && v.size_id == selectedSize);
            if (variant) {
                $('#current-price').text(new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(variant.discount_price));
                $('#current-sku').text(`SKU: ${variant.product_code}`);
                $('#current-stock').text(`Số lượng: ${variant.quantity}`);
                $('#product-quantity').attr('max', variant.quantity);
                $('#muangay-quantity').val(1); // Gán giá trị mặc định cho số lượng trong form "Mua ngay"

                if (variant.image) {
                    $('#main-image').attr('src', `/storage/${variant.image}`);
                    $('#main-image-link').attr('href', `/storage/${variant.image}`);
                }
            } else {
                $('#current-stock').text('Không khả dụng');
            }
        } else {
            const totalStock = variantDetails.reduce((sum, variant) => sum + variant.quantity, 0);
            $('#current-stock').text(`Số lượng: ${totalStock}`);
        }
    }

    // Xử lý nút "Mua ngay"
    $('#add-to-buy').on('click', function(event) {
        event.preventDefault();
        if (!selectedSize || !selectedColor) {
            Swal.fire({
                title: 'Thông báo',
                text: 'Vui lòng chọn cả kích thước và màu sắc trước khi mua.',
                icon: 'warning'
            });
            return;
        }

        // Gửi form "Mua ngay"
        $(this).prop('disabled', true).text('Đang xử lý...');
        $('#muangay-quantity').val($('#product-quantity').val()); // Gán số lượng vào hidden input

        $('#muangay-form').submit();
    });
});
</script>

@endsection
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
    /* Kiểm tra nếu có một phần tử che khuất */
    .attribute-option {
        pointer-events: all;
    }

    /* Thêm một chút hiệu ứng để làm nổi bật khi người dùng chọn thuộc tính */
    .attribute-option.selected {
        border: 2px solid #FF0000;
        /* Viền đỏ khi đã chọn */
        background-color: #FFD700;
        /* Màu vàng cho lựa chọn */
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
                    <div class="single-product-vertical-tab vertical-style-tab swiper-container gallery-top order-1 ms-0 me-2">
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
                    <div class="product-thumb-vertical vertical-style-thumb overflow-hidden swiper-container gallery-thumbs order-2">
                        <div class="swiper-wrapper">
                            @foreach($product->productImages as $image)
                            <div class="swiper-slide mb-3">
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
                <!-- Product Summary Start -->
                <div class="product-summery position-relative">
                    <!-- Product Head Start -->
                    <div class="product-head mb-3">
                        <h2 class="product-title">{{ $product->name }}</h2>
                    </div>
                    <!-- Product Head End -->

                    <!-- Price Box Start -->
                    <div class="price-box mb-2">
                        @if($product->discount_price && $product->price)
                        <span class="regular-price" id="current-price">
                            {{ number_format($product->discount_price, 0, '', '.') }} đ
                        </span>
                        <span class="old-price">
                            <del>{{ number_format($product->price, 0, '', '.') }} ₫</del>
                        </span>
                        @elseif($product->price)
                        <span class="regular-price" id="current-price">
                            {{ number_format($product->price, 0, '', '.') }} đ
                        </span>
                        @endif
                    </div>
                    <!-- Price Box End -->

                    <!-- SKU Start -->
                    <div class="sku mb-3">
                        <span id="current-sku">SKU: </span>
                    </div>
                    <!-- SKU End -->

                    <!-- Stock Quantity Start -->
                    <div class="stock-quantity mb-3">
                        <span id="current-stock">
                            Số lượng: 
                            <span id="stock-value" 
                                class="{{ $variants->sum('stock_quantity') == 0 ? 'text-danger' : '' }}">
                                {{ $variants->sum('stock_quantity') == 0 ? 'Hết hàng' : $variants->sum('stock_quantity') }}
                            </span>
                        </span>
                    </div>
                    <!-- Stock Quantity End -->

                    <!-- Short Description Start -->
                    <p class="short-desc mb-3">{{ $product->short_description }}</p>
                    <!-- Short Description End -->

                    <!-- Product Attributes Start -->
                    <div class="product-meta mb-3">
                        @php $shownValues = []; @endphp
                        @foreach ($attributes as $attribute)
                        @php
                        // Kiểm tra xem thuộc tính này có bất kỳ giá trị nào liên quan đến biến thể hay không
                        $hasValidValues = $attribute->values->some(function ($value) use ($product) {
                        return $product->variants->some(function ($variant) use ($value) {
                        return $variant->attributes->some(function ($variantAttribute) use ($value) {
                        return $variantAttribute->attribute_value_id === $value->id;
                        });
                        });
                        });
                        @endphp

                        @if ($hasValidValues)
                        <div class="product-attribute">
                            <span class="mt-3">{{ $attribute->name }}:
                                <span id="selected-{{ $attribute->slug }}">Chưa chọn</span>
                            </span><br>

                            @foreach ($attribute->values as $value)
                            @if (!in_array($value->id, $shownValues))
                            @php
                            // Chỉ hiển thị nếu giá trị tồn tại trong biến thể
                            $isAvailable = $product->variants->some(function ($variant) use ($value) {
                            return $variant->attributes->some(function ($variantAttribute) use ($value) {
                            return $variantAttribute->attribute_value_id === $value->id;
                            });
                            });
                            @endphp

                            @if ($isAvailable)
                            <a class="attribute-option mb-3" data-attribute-id="{{ $attribute->id }}"
                                data-value-id="{{ $value->id }}" data-value-name="{{ $value->value }}"
                                data-attribute-slug="{{ $attribute->slug }}" @if ($attribute->slug === 'mau-sac')
                                style="background-color: {{ $value->color_code }}; display: inline-block; width: 30px;
                                height: 30px; margin-right: 5px; margin-top: 10px; border-radius: 50%; border: 2px solid
                                #000;"
                                @endif>
                                <strong
                                    class="@if($attribute->slug !== 'mau-sac') btn btn border border-dark mt-3 mb-3 px-2 py-2 @endif">
                                    {{ $attribute->slug === 'mau-sac' ? '' : $value->value }}
                                </strong>
                            </a>
                            @php $shownValues[] = $value->id; @endphp
                            @endif
                            @endif
                            @endforeach
                        </div>
                        @endif
                        @endforeach
                    </div>

                    <!-- Product Attributes End -->

                    <!-- Quantity Start -->
                    
                    <!-- Quantity End -->

                    <!-- Cart & Wishlist Button Start -->
                    <div class="cart-wishlist-btn mb-4">
                        <div class="quantity mb-5">
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" id="product-quantity" name="quantity" value="1" min="1" required>
                                <div class="dec qtybutton"><i class="fa fa-minus"></i></div>
                                <div class="inc qtybutton"><i class="fa fa-plus"></i></div>
                            </div>
                        </div>
                        <div class="add-to_cart">
                            <form id="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="button" class="btn btn-outline-dark btn-hover-primary"
                                    id="add-to-cart-button">Thêm vào giỏ</button>
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
                        <li><i class="fa fa-check-square"></i> <span> Chính sách bảo mật</span></li>
                        <li><i class="fa fa-truck"></i> <span> Chính sách giao hàng</span></li>
                        <li><i class="fa fa-refresh"></i> <span> Chính sách hoàn trả</span></li>
                    </ul>
                    <!-- Product Delivery Policy End -->
                </div>
                <!-- Product Summary End -->
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
                <!-- @auth
                <br><br><br>
                <div class="review-form mb-4">
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
                @endauth -->

                <!-- Comments List -->

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
                                        <a href="{{ route('product.show', $product->slug) }}"
                                            class="btn btn-sm btn-outline-dark btn-hover-primary" title="Add To Cart"><i
                                                class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết</a>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Khai báo biến lưu trữ
        let selectedOptions = {};
        const productVariants = @json($variants);
        const quantityInput = document.getElementById('product-quantity');
        const increaseButton = document.querySelector('.inc.qtybutton');
        const decreaseButton = document.querySelector('.dec.qtybutton');
        const stockValueElement = document.getElementById('stock-value'); // Số lượng tồn kho của biến thể

        const mainImageLink = document.getElementById('main-image-link'); // Lấy liên kết hình ảnh chính
        const mainImage = document.getElementById('main-image');

        // Xử lý tăng số lượng
        increaseButton.addEventListener('click', function () {
            let currentValue = parseInt(quantityInput.value) || 1;
            const maxStock = parseInt(stockValueElement.textContent) || 0; // Số lượng tối đa

            if (currentValue < maxStock) {
                quantityInput.value = currentValue + 1;
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Số lượng tối đa',
                    text: `Bạn chỉ có thể mua tối đa ${maxStock} sản phẩm!`,
                });
            }
        });

        // Xử lý giảm số lượng
        decreaseButton.addEventListener('click', function () {
            let currentValue = parseInt(quantityInput.value) || 1;

            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        // Xử lý khi người dùng nhập trực tiếp vào ô số lượng
        quantityInput.addEventListener('input', function () {
            let currentValue = parseInt(quantityInput.value) || 1;
            const maxStock = parseInt(stockValueElement.textContent) || 0; // Số lượng tối đa

            if (currentValue > maxStock) {
                quantityInput.value = maxStock;
                Swal.fire({
                    icon: 'info',
                    title: 'Số lượng tối đa',
                    text: `Bạn chỉ có thể mua tối đa ${maxStock} sản phẩm!`,
                });
            } else if (currentValue < 1) {
                quantityInput.value = 1;
            }
        });
        // Lắng nghe sự kiện chọn thuộc tính
        const attributeOptions = document.querySelectorAll('.attribute-option');

        attributeOptions.forEach(function (option) {
            option.addEventListener('click', function (event) {
                event.preventDefault();

                // Lấy thông tin thuộc tính từ option
                const attributeId = option.getAttribute('data-attribute-id');
                const valueId = option.getAttribute('data-value-id');
                const valueName = option.getAttribute('data-value-name');
                const attributeSlug = option.getAttribute('data-attribute-slug');

                // Cập nhật lựa chọn thuộc tính
                selectedOptions[attributeId] = {
                    valueId: valueId,
                    valueName: valueName,
                };

                // Hiển thị thuộc tính đã chọn
                const selectedElement = document.getElementById('selected-' + attributeSlug);
                if (selectedElement) {
                    selectedElement.textContent = valueName;
                }

                // Cập nhật thông tin sản phẩm
                updateProductInfo(selectedOptions);
            });
        });

        // Hàm tìm biến thể phù hợp và cập nhật thông tin
        function updateProductInfo(selectedOptions) {
            const matchingVariant = productVariants.find(variant => {
                return variant.attributes.every(attribute => {
                    const selected = Object.values(selectedOptions).find(option => option.valueId == attribute.attribute_value_id);
                    return selected;
                });
            });

            // Tính tổng số lượng tồn kho của tất cả các biến thể
            const totalStockQuantity = productVariants.reduce((total, variant) => total + variant.stock_quantity, 0);

            // Lấy SKU của sản phẩm đầu tiên
            const defaultSKU = productVariants.length > 0 ? productVariants[0].product_code : "Chưa xác định";

            const baseUrl = window.location.origin;
            // Hiển thị thông tin biến thể nếu tìm thấy
            if (matchingVariant) {
                if (matchingVariant.image) {
                mainImage.src = baseUrl + '/' + 'storage/' + matchingVariant.image ; // Cập nhật đường dẫn hình ảnh chính của biến thể
                mainImageLink.href = baseUrl + '/' + 'storage/'  + matchingVariant.image ; // Cập nhật liên kết để mở ảnh lớn
            }
                document.getElementById('current-sku').textContent = "SKU: " + matchingVariant.product_code;
                document.getElementById('current-price').textContent = new Intl.NumberFormat().format(matchingVariant.price) + " đ";
                // Kiểm tra nếu số lượng là 0, hiển thị "Hết hàng" màu đỏ, ngược lại hiển thị số lượng
                const stockDisplay = matchingVariant.stock_quantity === 0 ? 'Hết hàng' : matchingVariant.stock_quantity;
                const stockElement = document.getElementById('stock-value');
                stockElement.textContent = stockDisplay;

                // Nếu số lượng là 0, thêm lớp CSS để làm chữ đỏ
                if (matchingVariant.stock_quantity === 0) {
                    stockElement.style.color = 'red';
                } else {
                    stockElement.style.color = ''; // Khôi phục lại màu chữ mặc định
                }
            } else {
                // Hiển thị SKU mặc định và tổng số lượng tồn kho
                document.getElementById('current-sku').textContent = "SKU: " + defaultSKU;
                const stockDisplay = totalStockQuantity === 0 ? 'Hết hàng' : totalStockQuantity;
                const stockElement = document.getElementById('stock-value');
                stockElement.textContent = stockDisplay;

                // Nếu tổng số lượng là 0, thêm lớp CSS để làm chữ đỏ
                if (totalStockQuantity === 0) {
                    stockElement.style.color = 'red';
                } else {
                    stockElement.style.color = ''; // Khôi phục lại màu chữ mặc định
                }
            }
        }
        // Xử lý sự kiện thêm vào giỏ hàng
        document.getElementById('add-to-cart-button').addEventListener('click', function (event) {
            event.preventDefault();

            const matchingVariant = productVariants.find(variant => {
                return variant.attributes.every(attribute => {
                    const selected = Object.values(selectedOptions).find(option => option.valueId == attribute.attribute_value_id);
                    return selected;
                });
            });

            if (!matchingVariant) {
                Swal.fire({
                    icon: 'error',
                    title: 'Không tìm thấy biến thể',
                    text: 'Vui lòng chọn đúng các thuộc tính sản phẩm để tiếp tục!',
                });
                return;
            }

            const quantity = parseInt(document.getElementById('product-quantity').value) || 1;

            const productInfo = {
                product_id: document.querySelector('input[name="product_id"]').value,
                variant_id: matchingVariant.variant_id,
                quantity: quantity,
            };

            // Gửi dữ liệu sang backend
            addToCart(productInfo);
        });

        // Hàm gửi dữ liệu đến backend
        function addToCart(productInfo) {
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(productInfo),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: 'Sản phẩm đã được thêm vào giỏ hàng!',
                            timer: 1000,
                            showConfirmButton: false
                        });
                        updateCartCount();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Không thể thêm sản phẩm vào giỏ hàng. Vui lòng thử lại!',
                            timer: 1000,
                            showConfirmButton: false
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Có lỗi xảy ra khi thêm vào giỏ hàng. Vui lòng thử lại!',
                    });
                    console.error('Chi tiết lỗi:', error);
                });
                
        }
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


@endsection
@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb">
        <a href="http://datn_wd13.test/"><i class="fa fa-home"></i> Trang Chủ</a>
        <span class="breadcrumb-separator"> > </span>
        <span><a href="http://datn_wd13.test/cart">Giỏ hàng</a></span>
    </div>


    <!-- Breadcrumb Area End -->

</div>
<!-- Breadcrumb Section End -->

<!-- Shopping Cart Section Start -->
<div class="section section-margin">
    <div class="container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class="row">
            <div class="col-12">

                <!-- Kiểm tra giỏ hàng trống -->
                @if (empty($cartItems) || count($cartItems) === 0)
                <div class=" text-center">
                    <img src="{{ asset('ngdung/assets/images/cart/empty-cart1.png')}}" alt="Giỏ hàng trống"
                        style="max-width: 400px; margin-bottom: 20px;">
                    <p>Giỏ hàng của bạn đang trống. <a href="{{ route('home.index') }}">Tiếp tục mua sắm</a>.</p>
                </div>
                @else

                <!-- Cart Table Start -->
                <!-- Cart Table Start -->
                <div class="cart-table table-responsive">
                    <table class="table table-bordered">

                        <!-- Table Head Start -->
                        <thead>
                            <tr>
                                <th class="pro-checkbox">
                                    <input type="checkbox" id="select-all" style="display: block;" />
                                </th>
                                <th class="pro-thumbnail">Hình ảnh</th>
                                <th class="pro-title">Sản phẩm</th>
                                <th class="pro-price">Giá</th>
                                <th class="pro-quantity">Số lượng</th>
                                <th class="pro-subtotal">Tổng</th>
                                <th class="pro-remove">Xóa</th>
                            </tr>
                        </thead>
                        <!-- Table Head End -->

                        <!-- Table Body Start -->
                        <tbody id="cartItems">
                            @foreach ($cartItems as $item)
                            <tr>
                                <td class="pro-checkbox">
                                    <input type="checkbox" class="select-item" data-id="{{ $item['product_detail_id'] }}" style="display: block;" />
                                </td>
                                <td class="pro-thumbnail">
                                    <a href="#"><img class="img-fluid" src="{{ url('storage/'. $item['image']) }}" height="auto"
                                            width="70" alt="Product" /></a>
                                </td>
                                <td class="pro-title">
                                    <a href="{{ route('product.show', $item['slug']) }}">
                                        {{ $item['name'] }}<br>
                                        @foreach ($item['attributes'] as $attribute)

                                        {{ $attribute['value'] }}{{ !$loop->last ? ' / ' : '' }}
                                        @endforeach
                                    </a>
                                </td>
                                <td class="pro-quantity">
                                    <div class="quantity">
                                        <div class="cart-plus-minus" style="margin-left: 35px;">
                                            <input class="cart-plus-minus-box" value="{{ $item['quantity'] }}"
                                                type="text" data-id="{{ $item['variant_id'] ?? $item['product_id'] }}"
                                                data-available-quantity="{{ $item['stock_quantity'] }}"
                                                data-product-id="{{ $item['product_id'] }}">
                                            <!-- Lưu product_id ở đây -->
                                            <div class="dec qtybutton"
                                                data-id="{{ $item['variant_id'] ?? $item['product_id'] }}"
                                                data-product-id="{{ $item['product_id'] }}">-
                                                <!-- Lưu product_id ở đây -->
                                            </div>
                                            <div class="inc qtybutton"
                                                data-id="{{ $item['variant_id'] ?? $item['product_id'] }}"
                                                data-product-id="{{ $item['product_id'] }}">+
                                                <!-- Lưu product_id ở đây -->
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td class="pro-subtotal">
                                    <span class="subtotal-{{ $item['variant_id'] ?? $item['product_id'] }}">
                                        {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') }}
                                        đ
                                    </span>
                                </td>
                                <td class="pro-remove">
                                    <form id="delete-form-{{ $item['variant_id'] ?? $item['product_id'] }}"
                                        action="{{ route('cart.remove', ['productId' => $item['product_id'], 'variantId' => $item['variant_id'] ?? null]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="pe-7s-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <!-- Table Body End -->

                    </table>
                </div>

                @endif

            </div>
        </div>

        @if (!empty($cartItems) && count($cartItems) > 0)
        <div class="row">
            <div class="col-lg-5 ms-auto col-custom">

                <!-- Cart Calculation Area Start -->
                <div class="cart-calculator-wrapper">
                    <div class="cart-calculate-items">

                        <!-- Cart Calculate Items Title Start -->
                        <!-- <h3 class="title">Tổng giỏ hàng</h3> -->
                        <!-- Cart Calculate Items Title End -->

                        <!-- Responsive Table Start -->
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Tổng giỏ hàng</td>
                                    <td class="sub-total">{{ number_format($subTotal, 0, ',', '.') }} đ</td>
                                </tr>

                            </table>
                        </div>
                        <!-- Responsive Table End -->

                    </div>
                    <form id="checkout-form" action="{{ route('orders.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="selected_items" value="">
                        <button type="submit" id="checkout-btn" class="btn btn-dark btn-hover-primary rounded-0 w-100">Tiến hành thanh toán</button>
                    </form>

                    <!-- <a href="{{ route('orders.create') }}" class="btn btn-dark btn-hover-primary rounded-0 w-100">Tiến
                        hành thanh toán</a> -->
                </div>

                <!-- Cart Calculation Area End -->

            </div>
        </div>
        @endif

    </div>
</div>

<!-- Shopping Cart Section End -->

<!-- Scroll Top Start -->
<a href="#" class="scroll-top" id="scroll-top">
    <i class="arrow-top fa fa-long-arrow-up"></i>
    <i class="arrow-bottom fa fa-long-arrow-up"></i>
</a>
<!-- Scroll Top End -->
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Cập nhật số lượng khi nhấn dấu cộng hoặc trừ
        $('.qtybutton').on('click', function() {
            var $button = $(this);
            var $input = $button.siblings('input');
            var quantity = parseInt($input.val());
            var availableQuantity = parseInt($input.data('available-quantity'));
            
            // Lấy variant_id và product_id từ data-id và data-product-id
            var variantId = $input.data('id');
            var productId = $button.data('product-id'); // Lấy product_id từ data-product-id của nút
            
            var $subtotal = $('.subtotal-' + variantId);
            
            // Lấy giá trị giá của sản phẩm từ cột Giá (pro-price)
            var priceText = $button.closest('tr').find('.pro-price span').text();
            // Xóa " đ" và dấu phẩy nếu có
            var price = parseFloat(priceText.replace(' đ', '').replace(/,/g, ''));
            
            if ($button.hasClass('inc') && quantity < availableQuantity) {
                quantity++;
            } else if ($button.hasClass('dec') && quantity > 1) {
                quantity--;
            }

            // Cập nhật số lượng trong input
            $input.val(quantity);

            // Tính toán lại subtotal (số tiền của sản phẩm sau khi thay đổi số lượng)
            var subtotal = price * quantity;
            $subtotal.text(subtotal.toLocaleString('vi-VN') + '.000' + ' đ');

            $.ajax({
                url: "{{ route('cart.update') }}", // Đảm bảo route này đúng
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId,  // Truyền thêm product_id vào dữ liệu
                    variant_id: variantId,  // Nếu có variant
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        updateCartTotal(response.cart);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert("Có lỗi xảy ra, vui lòng thử lại!");
                }
            });
            // Cập nhật tổng giỏ hàng
            updateCartTotal();
        });
        // Cập nhật tổng giỏ hàng khi số lượng thay đổi
        function updateCartTotal() {
            var total = 0;
            $('.pro-subtotal span').each(function() {
                var subtotal = $(this).text().replace(' đ', '').replace(/\./g, '').replace(/,/g, '');
                total += parseFloat(subtotal);
            });
            // Hiển thị tổng giỏ hàng với định dạng tiền tệ
            $('.sub-total').text(total.toLocaleString('vi-VN') + ' đ');
        }
    });
</script>

@endsection
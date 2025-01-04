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
                <div class="cart-table table-responsive">
                    <table class="table table-bordered">

                        <!-- Table Head Start -->
                        <thead>
                            <tr>
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
                                <td class="pro-thumbnail">
                                    <a href="#"><img class="img-fluid" src="{{ url('storage/'. $item['image']) }}"
                                            height="auto" width="70" alt="Product" /></a>
                                </td>
                                <td class="pro-title">
                                    <a href="{{ route('product.show', $item['slug']) }}">
                                        {{ $item['name'] }}<br>
                                        @foreach ($item['attributes'] as $attribute)
                                        
                                        {{ $attribute['value'] }}{{ !$loop->last ? ' / ' : '' }}
                                        @endforeach
                                    </a>
                                </td>
                                <td class="pro-price"><span>{{ number_format($item['price'] ?? 0, 0, ',', '.') }}
                                        đ</span></td>
                                <td class="pro-quantity">
                                    <div class="quantity">
                                        <div class="cart-plus-minus" style="margin-left: 35px;">
                                            <input class="cart-plus-minus-box" value="{{ $item['quantity'] }}"
                                                type="text" data-id="{{ $item['variant_id'] ?? $item['product_id'] }}"
                                                data-available-quantity="{{ $item['stock_quantity'] }}">
                                            <div class="dec qtybutton"
                                                data-id="{{ $item['variant_id'] ?? $item['product_id'] }}">-</div>
                                            <div class="inc qtybutton"
                                                data-id="{{ $item['variant_id'] ?? $item['product_id'] }}">+</div>
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
                    <a href="{{ route('orders.create') }}" class="btn btn-dark btn-hover-primary rounded-0 w-100">Tiến
                        hành thanh toán</a>
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

    var shippingFee = 30000; // Phí vận chuyển 30000 đồng

    // Xử lý sự kiện tăng/giảm số lượng
    $('.qtybutton').on('click', function() {
        var productDetailId = $(this).data('id');
        var inputField = $(this).siblings('.cart-plus-minus-box');
        var quantity = parseInt(inputField.val());
        var availableQuantity = parseInt(inputField.data(
            'available-quantity')); // Lấy số lượng có sẵn từ data-attribute

        // Tăng hoặc giảm số lượng
        if ($(this).hasClass('inc')) {
            if (quantity < availableQuantity) {
                quantity++;
            } else {
                // Sử dụng SweetAlert2
                Swal.fire({
                    icon: 'warning',
                    title: 'Không đủ sản phẩm trong kho!',
                    text: 'Số lượng sản phẩm không đủ để đáp ứng yêu cầu của bạn.',
                    confirmButtonText: 'Đã hiểu',
                    confirmButtonColor: '#3085d6',
                });
                return; // Ngừng việc tăng nếu vượt quá số lượng tồn kho
            }
        } else if ($(this).hasClass('dec') && quantity > 1) {
            quantity--;
        }


        // Gửi AJAX để cập nhật số lượng
        $.ajax({
            url: '{{ route("cart.update") }}',
            method: 'POST',
            data: {
                product_detail_id: productDetailId,
                quantity: quantity,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'success') {
                    inputField.val(quantity);

                    // Cập nhật lại subtotal cho sản phẩm này
                    var subtotalCell = inputField.closest('tr').find('.subtotal-' +
                        productDetailId);
                    var formattedSubtotal = formatNumber(response
                        .item_price); // Đảm bảo giá được format đúng

                    // Cập nhật subtotal cho sản phẩm
                    subtotalCell.text(formattedSubtotal + ' đ');

                    // Tính toán tổng giỏ hàng
                    var subTotal = 0;
                    $('.pro-subtotal span').each(function() {
                        var currentSubtotal = $(this).text().replace(' đ', '')
                            .replace('.', '').trim();
                        subTotal += parseFloat(currentSubtotal);
                    });

                    // Cập nhật hiển thị tổng giỏ hàng
                    $('.sub-total').text(subTotal.toFixed(0).replace(
                        /\B(?=(\d{3})+(?!\d))/g, '.') + ' đ');
                    $('.total-amount').text((subTotal + shippingFee).toFixed(0).replace(
                        /\B(?=(\d{3})+(?!\d))/g, '.') + ' đ');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi cập nhật giỏ hàng. Vui lòng thử lại.');
            }
        });
    });

    // Kiểm tra và giới hạn giá trị nhập vào
    $('.cart-plus-minus-box').on('input', function() {
        var inputField = $(this);
        var quantity = parseInt(inputField.val());
        var availableQuantity = parseInt(inputField.data('available-quantity')); // Số lượng có sẵn

        // Nếu giá trị nhập vào lớn hơn số lượng tồn kho, reset giá trị về số lượng tồn kho
        if (quantity > availableQuantity) {
            inputField.val(availableQuantity);
            alert('Số lượng sản phẩm không đủ trong kho!');
        }

        // Đảm bảo chỉ cho phép nhập số
        if (isNaN(quantity) || quantity < 1) {
            inputField.val(1); // Reset về 1 nếu người dùng nhập giá trị không hợp lệ
        }
    });
});

function formatNumber(number) {
    return number.toLocaleString('vi-VN'); // Định dạng số theo kiểu Việt Nam, ví dụ: 2.340.000
}

function confirmDelete(productDetailId) {
    if (confirm('Bạn có chắc chắn muốn xóa mục này?')) {
        // Tìm biểu mẫu và gửi đi nếu người dùng xác nhận
        document.getElementById(`delete-form-${productDetailId}`).submit();
    }
}
</script>
@endsection
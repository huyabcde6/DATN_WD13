@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Giỏ Hàng</h1>
                <ul>
                    <li>
                        <a href="/">Trang Chủ</a>
                    </li>
                    <li class="active">Giỏ Hàng</li>
                </ul>
            </div>
        </div>
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
                                    <a href="#">{{ $item['product_name'] }} <br> {{ $item['size'] }} /
                                        {{ $item['color'] }}</a>
                                </td>
                                <td class="pro-price"><span>{{ number_format($item['price'] ?? 0, 0, ',', '.') }}
                                        đ</span></td>
                                <td class="pro-quantity ">
                                    <div class="quantity">
                                        <div class="cart-plus-minus" style="margin-left: 35px;">
                                            <input class="cart-plus-minus-box" value="{{ $item['quantity'] }}"
                                                type="text" data-id="{{ $item['product_detail_id'] }}">
                                            <div class="dec qtybutton" data-id="{{ $item['product_detail_id'] }}">-
                                            </div>
                                            <div class="inc qtybutton" data-id="{{ $item['product_detail_id'] }}">+
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pro-subtotal">
                                    <span
                                        class="subtotal-{{ $item['product_detail_id'] }}">{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') }}
                                        đ</span>
                                </td>
                                <td class="pro-remove">
                                    <form action="{{ route('cart.remove', $item['product_detail_id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i
                                                class="pe-7s-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <!-- Table Body End -->

                    </table>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 ms-auto col-custom">

                <!-- Cart Calculation Area Start -->
                <!-- Cart Calculation Area Start -->
                <div class="cart-calculator-wrapper">
                    <div class="cart-calculate-items">

                        <!-- Cart Calculate Items Title Start -->
                        <h3 class="title">Tổng giỏ hàng</h3>
                        <!-- Cart Calculate Items Title End -->

                        <!-- Responsive Table Start -->
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Tổng phụ</td>
                                    <td class="sub-total">{{ number_format($subTotal, 0, ',', '.') }} đ</td>
                                </tr>
                                <tr>
                                    <td>Phí vận chuyển</td>
                                    <td>{{ number_format(30000, 0, ',', '.') }} đ</td> <!-- Hiển thị phí vận chuyển -->
                                </tr>
                                <tr class="total">
                                    <td>Tổng cộng</td>
                                    <td class="total-amount">
                                        {{ number_format($total, 0, ',', '.') }} đ
                                        <!-- Hiển thị tổng tiền bao gồm phí ship -->
                                    </td>
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
<script>
$(document).ready(function() {

    var shippingFee = 30000; // Phí vận chuyển 30000 đồng

    // Xử lý sự kiện tăng/giảm số lượng
    $('.qtybutton').on('click', function() {
        var productDetailId = $(this).data('id');
        var inputField = $(this).siblings('.cart-plus-minus-box');
        var quantity = parseInt(inputField.val());

        // Tăng hoặc giảm số lượng
        if ($(this).hasClass('inc')) {
            quantity++;
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

                    // Update the subtotal for this product
                    var subtotalCell = inputField.closest('tr').find('.subtotal-' +
                        productDetailId);
                    var formattedSubtotal = response
                    .item_price; // Ensure price formatting here
                    subtotalCell.text(formattedSubtotal);

                    // Calculate the total for the cart
                    var subTotal = 0;
                    $('.pro-subtotal span').each(function() {
                        var currentSubtotal = $(this).text().replace(' đ', '')
                            .replace('.', '').trim();
                        subTotal += parseFloat(currentSubtotal);
                    });

                    // Update the displayed totals
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
});
</script>
@endsection

